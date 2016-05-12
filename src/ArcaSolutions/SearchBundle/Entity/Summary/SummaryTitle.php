<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 02/09/15
 * Time: 18:39
 */

namespace ArcaSolutions\SearchBundle\Entity\Summary;


use ArcaSolutions\CoreBundle\Services\Utility;
use ArcaSolutions\SearchBundle\Entity\Elasticsearch\Category;
use ArcaSolutions\SearchBundle\Entity\Elasticsearch\Location;
use ArcaSolutions\SearchBundle\Entity\FilterMenuTreeNode;
use ArcaSolutions\SearchBundle\Services\ParameterHandler;
use ArcaSolutions\WebBundle\Services\CustomContentHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SummaryTitle
{
    /**
     * @var ContainerInterface
     */
    private $container;
    private $keyword;
    private $category;
    private $location;
    /**
     * @var FilterMenuTreeNode
     */
    private $date;
    private $description;
    private $module;

    private $content;
    private $SEOTitle;
    private $SEODescription;
    private $SEOKeywords;

    private $flags;

    /**
     * SummaryTitle constructor.
     * @param ContainerInterface $container
     * @param $module
     * @param $keyword
     * @param $category
     * @param $location
     * @param $date
     * @param $description
     * @param $flags
     * @param $content
     * @param $SEOTitle
     * @param $SEODescription
     * @param $SEOKeywords
     */
    public function __construct(
        ContainerInterface $container,
        $module,
        $keyword,
        $category,
        $location,
        $date,
        $description,
        $flags,
        $content,
        $SEOTitle,
        $SEODescription,
        $SEOKeywords
    ) {
        $this->container = $container;
        $this->keyword = $keyword;
        $this->category = $category;
        $this->location = $location;
        $this->date = $date;
        $this->description = $description;
        $this->module = $module;
        $this->flags = $flags;
        $this->content = $content;
        $this->SEOTitle = $SEOTitle;
        $this->SEODescription = $SEODescription;
        $this->SEOKeywords = $SEOKeywords;
    }

    /**
     * Builds a string representing what is being searched for, to be used withing the title head tag and h1 body tag
     * @param null $keywordSurroundingTag
     * @return string
     */
    public function getTitleString($keywordSurroundingTag = null)
    {
        $return = null;

        $flags = $this->flags;

        $translator = $this->container->get("translator");

        if ($flags == 0) {
            if ($this->module) {
                $return[] = $this->module;
            } else {
                $return[] = $translator->trans("directory results");
            }

            $return[] = $translator->trans("in");
            $return[] = $this->container->get("multi_domain.information")->getTitle();
        } else {
            if ($flags & 1) {
                $return[] = $keywordSurroundingTag ? "<{$keywordSurroundingTag}>{$this->keyword}</{$keywordSurroundingTag}>" : $this->keyword;
            } elseif ($this->module) {
                $flags |= 1;
                $return[] = $this->module;
            }

            $flags & 1 and $flags & 2 and $return[] = $translator->trans("in");
            $flags & 2 and $return[] = $this->category;
            $flags & 3 and $flags & 4 and $return[] = $translator->trans("in");
            $flags & 4 and $return[] = $this->location;

            if ($flags & 8) {
                if (empty($return)) {
                    $return[] = $translator->trans("Events");
                }

                switch ($this->date->title) {
                    case "fromToday":
                        $return[] = $translator->trans("from today on");
                        break;
                    case "today":
                        $return[] = $translator->trans("today");
                        break;
                    case "week":
                        $return[] = $translator->trans("this week");
                        break;
                    case "weekend":
                        $return[] = $translator->trans("this weekend");
                        break;
                    case "month":
                        $return[] = $translator->trans("this month");
                        break;
                    case "custom":
                        $dates = [];
                        $dateFilter = $this->container->get("filter.date");

                        $dateFilter->getStartDate() and $dates["%startDate%"] = $dateFilter->getStartDateString();
                        $dateFilter->getEndDate() and $dates["%endDate%"] = $dateFilter->getEndDateString();

                        switch (count($dates)) {
                            default:
                                $return[] = $translator->trans("currently on course", $dates);
                                break;
                            case 1:
                                $return[] = $translator->trans("happening from %startDate% on", $dates);
                                break;
                            case 2:
                                $return[] = $translator->trans("happening between %startDate% and %endDate%", $dates);
                                break;
                        }
                        break;
                }
            }
        }

        return ucfirst(implode(" ", $return));
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function getSeoInformation()
    {
        $this->SEOTitle or $this->SEOTitle = $this->getTitleString();

        $title = $this->container->get("translator")->trans(
            "%pageTitle% | %directoryTitle%",
            [
                "%pageTitle%"      => $this->SEOTitle,
                "%directoryTitle%" => $this->container->get("multi_domain.information")->getTitle()
            ]
        );

        $this->SEODescription or $this->SEODescription = $this->SEOTitle;

        return $this->container->get("twig")->render(
            "::blocks/seo/title.html.twig",
            [
                "title"       => $title,
                "description" => $this->SEODescription,
                "keywords"    => $this->SEOKeywords,
                "author"      => $this->container->get('customtexthandler')->get('header_author')
            ]
        );
    }

    /**
     * Generates a SummaryTitle instance based on the content stored in the $parameterHandler instance.
     *
     * @param ParameterHandler $parameterHandler
     * @param ContainerInterface $container
     * @return SummaryTitle
     */
    public static function extract(ParameterHandler $parameterHandler, ContainerInterface $container)
    {
        $SEOInfoCounter = 0;
        $categoryContent = null;

        $categorySEOInfo = null;
        $locationSEOInfo = null;
        $SEOKeywords[] = $container->get('customtexthandler')->get('header_keywords');

        $flags = 0;

        $date = null;
        $description = null;
        $moduleString = null;
        $keywordString = null;
        $categoryString = null;
        $locationString = null;

        if ($keywordArray = $parameterHandler->getRouteParameter("keyword")) {
            $keywordString = Utility::convertArrayToHumanReadableString(array_unique($keywordArray));
            $flags |= 1;
        }

        if ($moduleArray = $parameterHandler->getRouteParameter("module")) {

            /*
             * Woraround to pluralize module's name
             */
            $translator = $container->get("translator");

            $arrayModulesName = array();
            $arrayModulesName["listing"] = $translator->trans("listings");
            $arrayModulesName["event"] = $translator->trans("events");
            $arrayModulesName["classified"] = $translator->trans("classifieds");
            $arrayModulesName["article"] = $translator->trans("articles");
            $arrayModulesName["deal"] = $translator->trans("deals");
            $arrayModulesName["blog"] = $translator->trans("posts");

            $pluralModules = array();

            foreach ($moduleArray as $singModule) {
                if (array_key_exists($singModule, $arrayModulesName) !== false) {
                    $pluralModules[] = $arrayModulesName[$singModule];
                } else {
                    $pluralModules[] = $singModule;
                }
            }

            $moduleString = Utility::convertArrayToHumanReadableString(array_unique($pluralModules));
        }

        if ($categoryArray = $parameterHandler->getRouteParameter("category")) {
            $categories = $container->get("search.engine")->categoryFriendlyURLSearch($categoryArray);

            /* @var Category $category */
            $category = array_pop($categories);
            $categoryTitleArray[] = trim(strtolower($category->getTitle()));
            $seoInfo = $category->getSeo();
            $SEOKeywords[] = $seoInfo["keywords"];
            $SEOInfoCounter++;

            if (empty($categories)) {
                $description = $category->getDescription();
                $categoryContent = $category->getContent();
                $categorySEOInfo = $category->getSeo();
            } else {
                while ($category = array_pop($categories)) {
                    $SEOInfoCounter++;
                    $categoryTitleArray[] = trim(strtolower($category->getTitle()));
                    $seoInfo = $category->getSeo();
                    $SEOKeywords[] = $seoInfo["keywords"];
                }
            }

            $categoryString = Utility::convertArrayToHumanReadableString(array_unique($categoryTitleArray));
            $flags |= 2;
        }

        if ($locationArray = $parameterHandler->getRouteParameter("location")) {
            $locations = $container->get("search.engine")->locationFriendlyURLSearch($locationArray);

            /* @var Location $location */
            $location = array_pop($locations);
            $locationTitleArray[] = trim(strtolower($location->getTitle()));
            $seoInfo = $location->getSeo();
            $SEOKeywords[] = $seoInfo["keywords"];
            $SEOInfoCounter++;

            if (empty($locations)) {
                $seoInfo = $location->getSeo();
                $seoInfo["title"] = $location->getTitle();
                $locationSEOInfo = $seoInfo;
            } else {
                while ($location = array_pop($locations)) {
                    $SEOInfoCounter++;
                    $locationTitleArray[] = trim(strtolower($location->getTitle()));
                    $seoInfo = $location->getSeo();
                    $SEOKeywords[] = $seoInfo["keywords"];
                }
            }

            $locationString = Utility::convertArrayToHumanReadableString(array_unique($locationTitleArray));
            $flags |= 4;
        }

        $dateFilter = $container->get('filter.date');

        if ($selectedFilter = $dateFilter->getSelectedFilter()) {
            $date = $selectedFilter;
            $flags |= 8;
        }

        if($categoryContent){
            $content = $categoryContent;
        } else {
            $content = $container->get("customcontenthandler")->get(CustomContentHandler::TYPE_DIRECTORY_RESULTS);
        }

        $SEOTitle = null;
        $SEODescription = null;

        if ( $SEOInfoCounter == 1 and ($locationSEOInfo xor $categorySEOInfo)) {
            if ($locationSEOInfo) {
                $SEOTitle = $locationSEOInfo["title"];
                $SEODescription = $locationSEOInfo["description"];
            } else {
                $SEOTitle = $categorySEOInfo["title"];
                $SEODescription = $categorySEOInfo["description"];
            }
        }

        $SEOKeywords = preg_replace("/\s+/", ",", implode(",", $SEOKeywords));

        return new SummaryTitle(
            $container,
            $moduleString,
            $keywordString,
            $categoryString,
            $locationString,
            $date,
            $description,
            $flags,
            $content,
            $SEOTitle,
            $SEODescription,
            $SEOKeywords
        );
    }
}
