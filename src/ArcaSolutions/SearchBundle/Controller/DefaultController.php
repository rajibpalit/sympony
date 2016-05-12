<?php

namespace ArcaSolutions\SearchBundle\Controller;

use ArcaSolutions\ArticleBundle\Search\ArticleConfiguration;
use ArcaSolutions\BlogBundle\Search\BlogConfiguration;
use ArcaSolutions\ClassifiedBundle\Entity\Internal\ClassifiedLevelFeatures;
use ArcaSolutions\ClassifiedBundle\Search\ClassifiedConfiguration;
use ArcaSolutions\CoreBundle\Services\Utility;
use ArcaSolutions\DealBundle\Search\DealConfiguration;
use ArcaSolutions\EventBundle\Entity\Internal\EventLevelFeatures;
use ArcaSolutions\EventBundle\Search\EventConfiguration;
use ArcaSolutions\ListingBundle\Entity\Internal\ListingLevelFeatures;
use ArcaSolutions\ListingBundle\Search\ListingConfiguration;
use ArcaSolutions\SearchBundle\Entity\Elasticsearch\Category;
use ArcaSolutions\SearchBundle\Entity\Elasticsearch\Location;
use ArcaSolutions\SearchBundle\Entity\Filters\CategoryFilter;
use ArcaSolutions\SearchBundle\Entity\Filters\LocationFilter;
use ArcaSolutions\SearchBundle\Entity\Summary\SummaryTitle;
use ArcaSolutions\SearchBundle\Events\SearchEvent;
use Elastica\Query;
use Elastica\Suggest;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function searchAction($page)
    {
        $response = null;

        $searchEngine = $this->get('search.engine');
        $parameterHandler = $this->get("search.parameters");
        $JSHandler = $this->get("javascripthandler");
        $JSHandler->addTwigParameter('geolocationCookieName', $searchEngine->getGeoLocationCookieName());

        $page = $searchEngine->convertFromPaginationFormat($page);

        $keyword = implode(" ", $parameterHandler->getRouteParameter("keyword"));

        if (!empty($keyword)) {
            $this->container->get("reporthandler")
                ->addKeywordSearchReport(
                    $parameterHandler->getReportModule(),
                    $keyword,
                    $this->container->get("request")->get("where")
                );
        }

        /* Returns a SearchEvent instance filled with information collected by a search.global event cast */
        /* The Global search event will collect query and filter information for all available modules */
        $searchEvent = $searchEngine->globalSearch($keyword);

        /* Retrieves the Elastica Search Query assembled with information retrieved by the SearchEvent instance */
        $search = $searchEngine->search($searchEvent);

        /* Retrieves information which will be used while rendering the current page */
        /* @var SlidingPagination $pagination */
        $pagination = $this->get('knp_paginator')->paginate($search, $page);

        /* Processes results aggregations in order to show while rendering the filters */
        $searchEvent->processAggregationResults($pagination);

        /* Sets module level information to be used while rendering the summary templates */
        $levels = $searchEvent->getModuleLevelFeatures();

        /* Adds the required Javascript to enable module results interaction */
        foreach ($searchEvent->getResultsJSTwigs() as $pathToTwig) {
            $JSHandler->addJSBlock($pathToTwig);
        }

        /* Prepares information for SEO pagination meta tags */
        $previousPage = $page > 1 ? $parameterHandler->buildPathTo($page - 1) : null;
        $nextPage = $page < $pagination->getPageCount() ? $parameterHandler->buildPathTo($page + 1) : null;

        $map = $pagination->getTotalItemCount() < 1000 ? $searchEngine->buildMap($keyword) : null;

        $summaryTitle = SummaryTitle::extract($parameterHandler, $this->container);

        $response = $this->render(
            '::results.html.twig',
            [
                'previousPage' => $previousPage,
                'nextPage'     => $nextPage,
                'levels'       => $levels,
                'pagination'   => $pagination,
                'searchEvent'  => $searchEvent,
                'map'          => $map,
                'summaryTitle' => $summaryTitle,
                'dateFilter'   => $this->get("filter.date"),
            ]
        );

        return $response;
    }

    public function suggestWhatAction()
    {
        $response = [];

        if ($input = addslashes($this->get("request")->query->get("key"))) {
            $suggestionName = "search";

            $searchEngine = $this->get("search.engine");

            $elasticaClient = $searchEngine->getElasticaClient();
            $indexName = $this->get("search.engine")->getElasticIndexName();
            $elasticaIndex = $elasticaClient->getIndex($indexName);

            $suggest = new Suggest();
            $suggestion = new Suggest\Completion($suggestionName, "suggest.what");
            $suggestion->setText($input);

            $suggest->addSuggestion($suggestion);

            $result = $elasticaIndex->search($suggest);

            if ($matches = $result->getSuggests()) {
                foreach ($matches[$suggestionName] as $match) {
                    $response = $match;
                }
            }
        }

        return new JsonResponse($response);
    }

    public function suggestWhereAction()
    {
        $response = [];

        if ($input = addslashes($this->get("request")->query->get("key"))) {
            $suggestionName = "search";

            $searchEngine = $this->get("search.engine");

            $elasticaClient = $searchEngine->getElasticaClient();
            $indexName = $this->get("search.engine")->getElasticIndexName();
            $elasticaIndex = $elasticaClient->getIndex($indexName);

            $suggest = new Suggest();
            $suggestion = new Suggest\Completion($suggestionName, "suggest.where");
            $suggestion->setText($input);

            $suggest->addSuggestion($suggestion);

            $result = $elasticaIndex->search($suggest);

            if ($matches = $result->getSuggests()) {
                foreach ($matches[$suggestionName] as $match) {
                    $response = $match;
                }
            }
        }

        return new JsonResponse($response);
    }

    public function advancedCategoryAction()
    {
        $response = null;
        $request = $this->get("request");
        $searchEngine = $this->get('search.engine');
        $eventDispatcher = $this->get("event_dispatcher");

        $keyword = null;

        if ($locationFriendlyUrl = $request->get("data")) {
            if ($results = $searchEngine->locationFriendlyURLSearch($locationFriendlyUrl)) {
                /* @var $location Location */
                $location = array_pop($results);

                $keyword = $location->getId();
            }
        }

        $event = new SearchEvent($keyword);
        $eventDispatcher->dispatch('search.suggest.category', $event);

        $results = $searchEngine->search($event)->search()->getAggregations();

        $categoryDocumentCount = [];

        foreach ($results[CategoryFilter::getName()]["buckets"] as $result) {
            $categoryDocumentCount[$result["key"]] = $result["doc_count"];
        }

        if ($categoryDocumentCount) {
            $categoryInfo = $searchEngine->categoryIdSearch(array_keys($categoryDocumentCount));
        } else {
            $categoryInfo = $searchEngine->getAllCategories();
        }

        $moduleCategories = [];
        foreach ($categoryInfo as $category) {
            if ($category->getParentId() == null) {
                $moduleCategories[$category->getModule()][$category->getId()] = [
                    "item"          => $category,
                    "documentCount" => !empty($categoryDocumentCount[$category->getId()]) ? $categoryDocumentCount[$category->getId()] : 0
                ];
            }
        }

        /* Sorts each module's categories in order to show larger ones first */
        foreach ($moduleCategories as &$category) {
            uasort($category, function ($a, $b) {
                return $a["documentCount"] < $b["documentCount"];
            });
        }

        $response = $this->render(
            '::blocks/search/advanced-category.html.twig',
            ['modules' => $moduleCategories,]
        );

        return $response;
    }

    public function advancedLocationAction()
    {
        $response = null;

        $locationDocumentCount = [];
        $locationInfo = [];
        $moduleLocations = [];

        $searchEngine = $this->get('search.engine');
        $eventDispatcher = $this->get("event_dispatcher");
        $request = $this->get("request");

        $keyword = null;

        if ($categoryFriendlyUrl = $request->get("data")) {

            if ($results = $searchEngine->categoryFriendlyURLSearch($categoryFriendlyUrl)) {
                /* @var $category Category */
                $category = array_pop($results);

                $keyword = $category->getId();
            }
        }

        if ($keyword) {

            $event = new SearchEvent($keyword);
            $eventDispatcher->dispatch('search.suggest.location', $event);

            $results = $searchEngine->search($event)->search()->getAggregations();

            foreach ($results[LocationFilter::getName()]["buckets"] as $result) {
                $locationDocumentCount[$result["key"]] = $result["doc_count"];
            }

            if ($locationDocumentCount) {
                $locationInfo = $searchEngine->locationIdSearch(array_keys($locationDocumentCount));
            }

        } else {
            $locationInfo = $searchEngine->getAllLocations(1);
        }

        foreach ($locationInfo as $location) {

            switch ($location->getLevel()) {
                case 1:
                    $label = "country";
                    break;
                case 2:
                    $label = "region";
                    break;
                case 3:
                    $label = "state";
                    break;
                case 4:
                    $label = "city";
                    break;
                case 5:
                    $label = "neighborhood";
                    break;
                default:
                    $label = "location";
                    break;
            }

            $moduleLocations[$label][$location->getId()] = [
                "item"          => $location,
                "documentCount" => empty($locationDocumentCount[$location->getId()]) ? 0 : $locationDocumentCount[$location->getId()]
            ];
        }

        foreach ($moduleLocations as &$location) {
            uasort($location, function ($a, $b) {
                return $a["documentCount"] < $b["documentCount"];
            });
        }


        $response = $this->render(
            '::blocks/search/advanced-location.html.twig',
            ['locations' => $moduleLocations,]
        );

        return $response;
    }

    public function buildUrlAction()
    {
        $data = [
            "status" => false
        ];

        $request = $this->get("request");
        $parameters = clone $this->get("search.parameters");

        $whatWeHave = 0;

        $location = $request->get("location") and $whatWeHave |= 1;
        $category = $request->get("category") and $whatWeHave |= 2;
        $keyword = implode(" ", array_filter((array)$request->get("keyword"))) and $whatWeHave |= 4;
        $item = $request->get("item") and $whatWeHave |= 8;
        $itemType = $request->get("itemtype") and $whatWeHave |= 16;
        $startDate = $request->get("startDate") and $whatWeHave |= 32;

        if ($whatWeHave & 39) {
            $parameters->clearAllRouteParameters();
            $parameters->clearAllQueryParameters();

            $whatWeHave & 1 and $parameters->addRouteParameter("location", $location);
            $whatWeHave & 2 and $parameters->addRouteParameter("category", $category);
            $whatWeHave & 4 and $parameters->addRouteParameter("keyword", $keyword);


            if ($whatWeHave & 32) {
                $parameters->clearRouteParameter("module");
                $parameters->addRouteParameter("module", $this->get("search.engine")->getModuleAlias("event"));
                $parameters->addRouteParameter("startDate", $startDate);
            } elseif (!($whatWeHave & 2) and $module = $this->get("search.engine")->getModuleAlias($request->get("module"))) {
                $parameters->addRouteParameter("module", $module);
            }

            $data = [
                "status" => true,
                "url"    => $parameters->buildPathTo()
            ];
        } elseif ($whatWeHave == 24) {

            switch ($itemType) {
                case "article":
                    $type = ArticleConfiguration::$elasticType;
                    $route = "article_detail";
                    $repository = "ArticleBundle:Article";
                    break;
                case "blog":
                    $type = BlogConfiguration::$elasticType;
                    $route = "blog_detail";
                    $repository = "BlogBundle:Post";
                    break;
                case "classified":
                    $type = ClassifiedConfiguration::$elasticType;
                    $route = "classified_detail";
                    $repository = "ClassifiedBundle:Classified";
                    break;
                case "deal":
                    $type = DealConfiguration::$elasticType;
                    $route = "deal_detail";
                    $repository = "DealBundle:Promotion";
                    break;
                case "event":
                    $type = EventConfiguration::$elasticType;
                    $route = "event_detail";
                    $repository = "EventBundle:Event";
                    break;
                case "listing":
                    $type = ListingConfiguration::$elasticType;
                    $route = "listing_detail";
                    $repository = "ListingBundle:Listing";
                    break;
                default:
                    $type = null;
                    $route = "";
                    $repository = null;
                    break;
            }

            if ($type) {
                if ($result = $this->get("search.engine")->itemFriendlyURL($item, $type, $repository)) {
                    $data = [
                        "status" => true,
                        "url"    => $this->get("router")->generate(
                            $route,
                            ["friendlyUrl" => $result->getFriendlyUrl(), "_format" => "html"]
                        )
                    ];
                }
            }
        }

        $response = new JsonResponse($data);

        return $response;
    }

    public function mapSummaryAction()
    {
        $twig = $this->get("twig");
        $response = [];

        $data = $this->get("request_stack")->getCurrentRequest()->get("data");

        while ($item = array_pop($data)) {
            $itemId = $item["item"];
            $type = $item["itemtype"];

            switch ($type) {
                case ClassifiedConfiguration::$elasticType :
                    $levels[ClassifiedConfiguration::$elasticType] = ClassifiedLevelFeatures::getByTheme(
                        $this->get("multi_domain.information")->getTemplate(),
                        $this->get("doctrine")
                    );
                    break;
                case DealConfiguration::$elasticType :
                    $levels = true;
                    break;
                case EventConfiguration::$elasticType :
                    $levels[EventConfiguration::$elasticType] = EventLevelFeatures::getByTheme(
                        $this->get("multi_domain.information")->getTemplate(),
                        $this->get("doctrine")
                    );
                    break;
                case ListingConfiguration::$elasticType :
                    $levels[ListingConfiguration::$elasticType] = ListingLevelFeatures::getByTheme(
                        $this->get("multi_domain.information")->getTemplate(),
                        $this->get("doctrine")
                    );
                    break;
                default:
                    $levels = null;
                    break;
            }

            if ($itemId && $levels) {
                $searchEngine = $this->get("search.engine");

                $elasticaClient = $searchEngine->getElasticaClient();
                $indexName = $this->get("search.engine")->getElasticIndexName();

                $elasticaIndex = $elasticaClient->getIndex($indexName);
                $elasticaType = $elasticaIndex->getType($type);
                $item = $elasticaType->getDocument($itemId);

                $itemData = $item->getData();

                $categories = empty($itemData["categoryId"]) ? [] : $searchEngine->categoryIdSearch(Utility::convertStringToArray($itemData["categoryId"],
                    " "));
                $locations = empty($itemData["locationId"]) ? [] : $searchEngine->locationIdSearch(Utility::convertStringToArray($itemData["locationId"],
                    " "));
                $badges = empty($itemData["badgeId"]) ? [] : $searchEngine->badgeIdSearch(Utility::convertStringToArray($itemData["badgeId"],
                    " "));

                $response[$itemData["title"]] = $twig->render(
                    "::modules/{$type}/map-summary.html.twig",
                    [
                        'item'           => $item,
                        'pageCategories' => $categories,
                        'pageLocations'  => $locations,
                        'pageBadges'     => $badges,
                        'levelFeatures'  => $levels
                    ]
                );
            }
        }

        if ($response) {
            if ((count($response) == 1)) {
                $response = array_pop($response);
            } else {
                $response = $twig->render(
                    "::blocks/search/map.multiple.summary.html.twig",
                    [
                        "titles" => array_keys($response),
                        "summaries" => $response
                    ]
                );
            }
        }

        return new Response($response);
    }
}
