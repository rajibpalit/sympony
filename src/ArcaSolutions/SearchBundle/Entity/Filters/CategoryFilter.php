<?php

namespace ArcaSolutions\SearchBundle\Entity\Filters;

use ArcaSolutions\SearchBundle\Entity\Elasticsearch\Category;
use ArcaSolutions\SearchBundle\Entity\FilterMenuTreeNode;
use ArcaSolutions\SearchBundle\Events\SearchEvent;
use ArcaSolutions\SearchBundle\Services\SearchEngine;

class CategoryFilter extends BaseFilter
{
    /**
     * {@inheritdoc}
     */
    protected static $name = "CategoryFilter";

    private $aggregationInfo;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'search.article'        => 'registerItem',
            'search.blog'           => 'registerItem',
            'search.global'         => 'registerItem',
            'search.classified'     => 'registerItem',
            'search.deal'           => 'registerItem',
            'search.event'          => 'registerItem',
            'search.listing'        => 'registerItem',
            'search.global.map'     => 'registerMapItem',
            'search.classified.map' => 'registerMapItem',
            'search.deal.map'       => 'registerMapItem',
            'search.event.map'      => 'registerMapItem',
            'search.listing.map'    => 'registerMapItem',
//            'search.suggest.category' => 'registerSuggest',
        ];
    }

//    public function registerSuggest(SearchEvent $event)
//    {
//        $this->register($event);
//
//        $qB = SearchEngine::getElasticaQueryBuilder();
//
//        if ($keyword = $event->getKeyword()) {
//            $this->addElasticaFilter(
//                $qB->filter()->terms("locationId", $keyword)
//            );
//        }
//
//        $this->addElasticaAggregation(
//            $qB->aggregation()->terms(static::$name)
//                ->setField("categoryId")
//                ->setSize(0)
//        );
//    }

    public function registerItem(SearchEvent $event, $eventName)
    {
        $this->register($event, $eventName);

        $parameterInfo = $this->container->get("search.parameters");
        $searchEngine = $this->container->get("search.engine");

        $qb = SearchEngine::getElasticaQueryBuilder();

        /* will only add filters if there are category information inside the request */
        if ($categoryFriendlyURLs = $parameterInfo->getRouteParameter("category")) {

            $searchedCategories = $searchEngine->categoryFriendlyURLSearch($categoryFriendlyURLs);

            /* Creates reports for categories being searched */
            foreach ($searchedCategories as $id => $category) {
                $filteredId = preg_replace("/[^\d+]/", "", $id);

                $this->container->get("reporthandler")->addCategorySearchReport(
                    $parameterInfo->getReportModule(),
                    (int)$filteredId
                );
            }

            /* Attempts to get all subcategories as well */
            if ($results = $this->getRecursiveCategories($searchedCategories)) {
                /* the ID is the key of each category within the $results array */
                $categoryIds = array_keys($results);

                $elasticFilter = $qb->filter()->terms("categoryId", $categoryIds);

                $keyword = $parameterInfo->getRouteParameter("keyword");

                if (empty($keyword)) {
                    $this->addElasticaFilter($elasticFilter);
                } else {
                    $this->addElasticaPostFilter($elasticFilter);
                }
            }
        }
    }

    public function getElasticaAggregations()
    {
        $subscribedEvents = self::getSubscribedEvents();

        switch ($subscribedEvents[$this->eventName]) {
            case 'registerItem' :
                $qb = SearchEngine::getElasticaQueryBuilder();

                $aggregation = $qb->aggregation()->terms(static::$name)
                    ->setField("categoryId")
                    ->setSize(0);

                $filters = $this->searchEvent->getElasticaPostFilters();
                unset ($filters[static::$name]);

                if ($filters) {
                    $aggregation->addAggregation(
                        $qb->aggregation()->filter(
                            "filtered",
                            $qb->filter()
                                ->bool()
                                ->addMust($filters)
                        )
                    );
                }

                $this->addElasticaAggregation($aggregation);

                break;
        }

        return $this->elasticaAggregations;
    }


    public function registerMapItem(SearchEvent $event, $eventName)
    {
        $this->register($event, $eventName);

        /* will only add filters if there are category information inside the request */
        if ($categoryFriendlyURLs = $this->container->get("search.parameters")->getRouteParameter("category")) {

            $searchEngine = $this->container->get("search.engine");
            $searchedCategories = $searchEngine->categoryFriendlyURLSearch($categoryFriendlyURLs);

            /* Attempts to get all subcategories as well */
            if ($results = $this->getRecursiveCategories($searchedCategories)) {
                /* the ID is the key of each category within the $results array */
                $categoryIds = array_keys($results);

                $this->addElasticaFilter(
                    SearchEngine::getElasticaQueryBuilder()->filter()->terms("categoryId", $categoryIds)
                );
            }
        }
    }

    /**
     * Starting from a friendly url, queries elasticsearch for information on the provided categories and also all of
     * their children recursively.
     *
     * In order to fetch multiple initial categories, please separate them with commas (,)
     *
     * @param $categories Category[]
     * @return array
     */
    public function getRecursiveCategories($categories)
    {
        $returnValue = $categories;
        $searchEngine = $this->container->get("search.engine");

        /* This guy will keep all children for later processing */
        $recursiveStack = [];

        foreach ($categories as $category) {

            /* We'll add all children to the stack to get their own subcategories */
            if ($children = $category->getSubCategoryId()) {
                $recursiveStack = array_merge($recursiveStack, $children);
            }
        }

        /* this will assemble a Id query and return every category within the stack */
        while ($recursiveStack) {
            $results = $searchEngine->categoryIdSearch($recursiveStack);
            /* Empties the array, for it's values have already been used above */
            $recursiveStack = [];

            foreach ($results as $category) {
                /* Checks if the category has already been processed */
                if (!isset($returnValue[$category->getId()])) {
                    $returnValue[$category->getId()] = $category;

                    /* We'll add all children here to get their own subcategories */
                    if ($children = $category->getSubCategoryId()) {
                        $recursiveStack = array_merge($recursiveStack, (array)$children);
                    }
                }
            }
        }

        return $returnValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterView()
    {
        $return = null;

        if ($this->aggregationInfo) {

            $javaScriptHandler = $this->container->get("javascripthandler");
            $javaScriptHandler->addJSExternalFile("assets/js/search/utility.js");
            $javaScriptHandler->addJSBlock("::js/filters/category.js.twig");

            $searchEngine = $this->container->get("search.engine");

            /* Gets the friendlyUrl of the categories being searched for */
            $requestFilterCategories = $this->container->get("search.parameters")->getRouteParameter("category");

            /* Gets categories objects */
            $requestedCategories = $searchEngine->categoryFriendlyURLSearch($requestFilterCategories);

            /* Gets all the categories within the resultset */
            $resultCategories = $searchEngine->categoryIdSearch(array_keys($this->aggregationInfo));

            /* Fills the Dictionary with information about the categories contained in the resultset */
            $categoryDictionary = [];
            $this->extractFromResultSet($resultCategories, $categoryDictionary, $requestFilterCategories);

            /* Transforms the dictionary into a tree */
            $categoryTree = $this->linkElements($categoryDictionary);

            foreach ($categoryTree as $node) {
                $this->bubbleCounts($node);
                $this->sortTree($node);
            }

            usort($categoryTree, [$this, "categorySort"]);

            $return = $this->container->get("twig")->render(
                "::blocks/filters/category.html.twig",
                [
                    "categoryTree" => $categoryTree,
                    "selected"     => $requestedCategories
                ]
            );
        }

        return $return;
    }

    /**
     * Extracts category data from the Resultset
     * @param Category[] $categories
     * @param $dictionary
     * @param array $marked
     */
    public function extractFromResultSet($categories, &$dictionary, $marked = [])
    {
        $parents = [];

        foreach ($categories as $result) {
            if (isset($dictionary[$result->getId()])) {
                continue;
            }

            $resultCount = isset($this->aggregationInfo[$result->getId()]) ? $this->aggregationInfo[$result->getId()]["numberOfItems"] : 0;

            if ($result->getParentId() && !isset($dictionary[$result->getParentId()])) {
                $parents[$result->getParentId()] = true;
            }

            $dictionary[$result->getId()] = new FilterMenuTreeNode(
                $result->getParentId(),
                $result->getSubCategoryId(),
                $result->getTitle(),
                $result->getFriendlyUrl(),
                $result->getModule(),
                $result->getId(),
                in_array($result->getFriendlyUrl(), $marked),
                null,
                $resultCount
            );
        }

        if ($parents) {
            $resultCategories = $this->container->get("search.engine")->categoryIdSearch(array_keys($parents));
            $this->extractFromResultSet($resultCategories, $dictionary, $marked);
        }
    }

    /**
     * Removes from a category tree root all categories not marked as used (isUsed == true)
     * @param $friendlyUrl
     * @param array $parents
     * @return array
     */
    private function getSearchPageUrl($friendlyUrl, $parents = [])
    {
        $result = null;

        if ($friendlyUrl) {
            $searchParameters = clone $this->container->get("search.parameters");

            while($parent = array_pop($parents)){
                $searchParameters->removeRouteParameter("category", $parent);
            }

            $searchParameters->toggleRouteParameter("category", $friendlyUrl);
            $result = $searchParameters->buildPathTo();
        }

        return $result;
    }

    /**
     * Assembles a tree based on the CategoryDictionary connections
     * @param FilterMenuTreeNode[] $categoryDictionary
     * @return FilterMenuTreeNode[]
     */
    private function linkElements(&$categoryDictionary)
    {
        $selectedItemParents = [];
        $parentlessItems = [];


        foreach ($categoryDictionary as &$category) {
            /* Links to the Parent, if any */
            if ($category->parentId && isset($categoryDictionary[$category->parentId])) {
                $category->parent = $categoryDictionary[$category->parentId];

                if ($category->isSelected) {
                    if ($category->parent && !isset($selectedItemParents[$category->parent->id])) {
                        $selectedItemParents[$category->parent->id] = $category->parent;
                    }
                }
            } elseif (!isset($parentlessItems[$category->id])) {
                $parentlessItems[$category->id] = $category;
            }

            /* Links to the children, if any */
            foreach ($category->childrenId as $childId) {
                if (isset($categoryDictionary[$childId])) {
                    $category->children[$childId] = &$categoryDictionary[$childId];
                }
            }
        }

        /* @var FilterMenuTreeNode $element */
        while ($element = array_pop($selectedItemParents)) {
            if (!$element->isParentOfSelected) {
                $element->isParentOfSelected = true;
                $element->parent and array_push($selectedItemParents, $element->parent);
            }
        }

        return $parentlessItems;
    }

    /**
     * {@inheritdoc}
     */
    protected function processAggregationBuckets($filterAggregationBuckets)
    {
        $this->aggregationInfo = null;

        foreach ($filterAggregationBuckets as $bucket) {
            if ($documentCount = isset($bucket['filtered']) ? $bucket['filtered']['doc_count'] : $bucket['doc_count']) {
                $this->aggregationInfo[$bucket['key']] = ["numberOfItems" => $documentCount];
            }
        }
    }

    /**
     * Calculates the amount of items within nodes properly.
     * <b> Recursive Function </b>
     *
     * @param FilterMenuTreeNode $category
     * @param array $parents
     * @return int
     */
    private function bubbleCounts($category, $parents = [])
    {
        $category->searchPageUrl = $this->getSearchPageUrl($category->friendlyUrl, $parents);

        if ($category->children) {
            $parents[] = $category->friendlyUrl;

            foreach ($category->children as $child) {
                $category->resultCount += $this->bubbleCounts($child, $parents);
            }
        }

        return $category->resultCount;
    }

    /**
     * @param $a FilterMenuTreeNode
     * @param $b FilterMenuTreeNode
     * @return int
     */
    private function categorySort($a, $b)
    {
        $result = 0;

        $a->isSelected and $result -= 100000;
        $b->isSelected and $result += 100000;

        $a->isParentOfSelected and $result -= 50000;
        $b->isParentOfSelected and $result += 50000;

        $a->resultCount > 0 and $result -= 75000;
        $b->resultCount > 0 and $result += 75000;

        $result += strcmp($a->title, $b->title);

        return $result;
    }

    /**
     * @param $category FilterMenuTreeNode
     */
    private function sortTree($category)
    {
        if ($category->children) {
            usort($category->children, [$this, "categorySort"]);
            foreach ($category->children as $child) {
                $this->sortTree($child);
            }
        }
    }
}
