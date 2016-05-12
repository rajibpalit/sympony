<?php

namespace ArcaSolutions\SearchBundle\Entity\Filters;

use ArcaSolutions\SearchBundle\Entity\FilterMenuTreeNode;
use ArcaSolutions\SearchBundle\Events\SearchEvent;
use ArcaSolutions\SearchBundle\Services\SearchEngine;

class DateFilter extends BaseFilter
{
    /**
     * {@inheritdoc}
     */
    protected static $name = "DateFilter";
    /**
     * @var \DateTime
     */
    protected $startDate = null;
    /**
     * @var \DateTime
     */
    protected $endDate = null;
    /**
     * @var string
     */
    protected $urlDateFormat = 'm-d-Y';
    /**
     * @var string
     */
    protected $dateFormat = 'm/d/Y';
    /**
     * @var string
     */
    protected $queryDateFormat = 'Y-m-d';
    /**
     * @var string
     */
    protected $bootstrapDatepickerLanguage = 'en';
    /**
     * @var string
     */
    protected $bootstrapDatepickerDateFormat = 'mm/dd/yyyy';
    /**
     * @var string
     */
    protected $bootstrapDatepickerUrlDateFormat = '/mm-dd-yyyy';

    /**
     * @var FilterMenuTreeNode|null
     */
    protected $fromTodayFilterOption = null;
    /**
     * @var FilterMenuTreeNode|null
     */
    protected $anyDateFilterOption = null;
    /**
     * @var FilterMenuTreeNode|null
     */
    protected $todayFilterOption = null;
    /**
     * @var FilterMenuTreeNode|null
     */
    protected $weekFilterOption = null;
    /**
     * @var FilterMenuTreeNode|null
     */
    protected $weekendFilterOption = null;
    /**
     * @var FilterMenuTreeNode|null
     */
    protected $monthFilterOption = null;
    /**
     * @var FilterMenuTreeNode|null
     */
    protected $customDateFilterOption = null;

    function __construct($container)
    {
        parent::__construct($container);

        $this->dateFormat = $container->get('languagehandler')->getDateFormat();
        $this->urlDateFormat = preg_replace("/[^\w]/", "-", $this->dateFormat);
        $this->bootstrapDatepickerLanguage = $this->convertLocale($this->container->getParameter("locale"));
        $this->bootstrapDatepickerDateFormat = $this->convertToBootstrapDatepickerFormat($this->dateFormat);
        $this->bootstrapDatepickerUrlDateFormat = "/" . $this->convertToBootstrapDatepickerFormat($this->urlDateFormat);
    }

    public function convertLocale($locale)
    {
        switch ($locale) {
            case "pt":
                $locale = "pt-BR";
                break;
        }

        return $locale;
    }

    public function convertToBootstrapDatepickerFormat($format)
    {
        return str_replace(["d", "m", "Y"], ["dd", "mm", "yyyy"], $format);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'search.global'     => 'registerItem',
            'search.global.map' => 'registerItem',
        ];
    }

    /**
     * Provides the necessary elasticsearch queries and filters for a summary search
     * @param SearchEvent $searchEvent
     * @param $eventName
     */
    public function registerItem(SearchEvent $searchEvent, $eventName)
    {
        if ($this->isCalendarSearch()) {
            $this->register($searchEvent, $eventName);

            $parameterInfo = $this->container->get("search.parameters");

            $qB = SearchEngine::getElasticaQueryBuilder();

            $today = new \DateTime();
            $startDateString = $today->format($this->queryDateFormat);
            $endDateString = null;

            if ($startDate = $parameterInfo->getRouteParameter("startDate")) {
                $this->startDate = \DateTime::createFromFormat($this->urlDateFormat, $startDate);
                $this->startDate->setTime(0, 0, 0);
                $startDateString = $this->startDate->format($this->queryDateFormat);
            }

            if ($endDate = $parameterInfo->getRouteParameter("endDate")) {
                $this->endDate = \DateTime::createFromFormat($this->urlDateFormat, $endDate);
                $this->endDate->setTime(0, 0, 0);
                $endDateString = $this->endDate->format($this->queryDateFormat);
            }

            $nonRecurringFilter = $qB->filter()->bool_and()
                ->addFilter($qB->filter()->term()->setTerm("recurring.enabled", 0))
                ->addFilter($qB->filter()->range("date.end", ['gte' => $startDateString]));

            $recurringFilter = $qB->filter()->bool_and()
                ->addFilter($qB->filter()->term()->setTerm("recurring.enabled", 1))
                ->addFilter(
                    $qB->filter()->bool_or()
                        ->addFilter($qB->filter()->missing("recurring.until"))
                        ->addFilter($qB->filter()->range("recurring.until", ['gt' => $startDateString]))
                );

            /* If end date is set */
            if ($endDateString) {
                $endDateFilter = $qB->filter()->range("date.start", ['lte' => $endDateString]);

                $recurringFilter->addFilter($endDateFilter);
                $nonRecurringFilter->addFilter($endDateFilter);
            }

            $elasticFilter = $qB->filter()->bool_or()
                ->addFilter($nonRecurringFilter)
                ->addFilter($recurringFilter);

            if ($parameterInfo->getRouteParameter("keyword")) {
                $this->addElasticaFilter($elasticFilter);
            } else {
                $this->addElasticaPostFilter($elasticFilter);
            }
        }
    }

    public function isCalendarSearch()
    {
        $searchedModules = $this->container->get('search.parameters')->getRouteParameter("module");
        $searchEngine = $this->container->get('search.engine');

        return (array_pop($searchedModules) == $searchEngine->getModuleAlias("event") and empty($searchedModules));
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterView()
    {
        return $this->container->get("twig")->render("::blocks/filters/date.html.twig", ["dateFilter" => $this]);
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @param $title
     * @return FilterMenuTreeNode
     */
    public function getFilterOption($start, $end, $title)
    {
        $isSelected = ($start == $this->startDate && $end == $this->endDate);

        $searchPageUrl = $isSelected ? $this->getSearchPageUrl() : $this->getSearchPageUrl($start, $end);

        return new FilterMenuTreeNode(0, 0, $title, 0, 0, 0, $isSelected, $searchPageUrl, 0);
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
    private function getSearchPageUrl($startDate = null, $endDate = null)
    {
        $searchParameters = clone $this->container->get("search.parameters");
        $searchParameters->clearRouteParameter("startDate");
        $searchParameters->clearRouteParameter("endDate");
        $searchParameters->clearRouteParameter("module");

        $searchParameters->addRouteParameter("module", $this->container->get("search.engine")->getModuleAlias("event"));

        if ($startDate) {
            $searchParameters->addRouteParameter("startDate", $startDate->format($this->urlDateFormat));
        }

        if ($endDate) {
            $searchParameters->addRouteParameter("endDate", $endDate->format($this->urlDateFormat));
        }

        return $searchParameters->buildPathTo();
    }

    /**
     * @return FilterMenuTreeNode
     */
    public function getAnyDateFilterOption()
    {
        if ($this->anyDateFilterOption === null) {
            $this->anyDateFilterOption = $this->getFilterOption(null, null, "anyDate");
        }

        return $this->anyDateFilterOption;
    }

    /**
     * @return FilterMenuTreeNode
     */
    public function getFromTodayFilterOption()
    {
        if ($this->fromTodayFilterOption === null) {
            $start = new \DateTime("today");
            $this->fromTodayFilterOption = $this->getFilterOption($start, null, "fromToday");
        }

        return $this->fromTodayFilterOption;
    }

    /**
     * @return FilterMenuTreeNode
     */
    public function getTodayFilterOption()
    {
        if ($this->todayFilterOption === null) {
            $start = new \DateTime("today");
            $this->todayFilterOption = $this->getFilterOption($start, $start, "today");
        }

        return $this->todayFilterOption;
    }

    /**
     * @return FilterMenuTreeNode
     */
    public function getWeekFilterOption()
    {
        if ($this->weekFilterOption === null) {
            $start = new \DateTime("today");
            $end = new \DateTime("next Saturday");
            $this->weekFilterOption = $this->getFilterOption($start, $end, "week");
        }

        return $this->weekFilterOption;
    }

    /**
     * @return FilterMenuTreeNode
     */
    public function getWeekendFilterOption()
    {
        if ($this->weekendFilterOption === null) {
            $start = new \DateTime("next Saturday");
            $end = new \DateTime("next Sunday");
            $this->weekendFilterOption = $this->getFilterOption($start, $end, "weekend");
        }

        return $this->weekendFilterOption;
    }

    /**
     * @return FilterMenuTreeNode
     */
    public function getMonthFilterOption()
    {
        if ($this->monthFilterOption === null) {
            $start = new \DateTime("today");
            $end = new \DateTime("last day of this month");
            $end->setTime(0, 0, 0);
            $this->monthFilterOption = $this->getFilterOption($start, $end, "month");
        }

        return $this->monthFilterOption;
    }

    /**
     * @return FilterMenuTreeNode
     */
    public function getCustomDateFilterOption()
    {
        if ($this->customDateFilterOption === null) {
            $searchParameters = clone $this->container->get("search.parameters");
            $searchParameters->clearRouteParameter("startDate");
            $searchParameters->clearRouteParameter("endDate");
            $searchParameters->clearRouteParameter("module");
            $searchParameters->addRouteParameter("startDate", "STARTDATE");
            $searchParameters->addRouteParameter("endDate", "ENDDATE");
            $searchParameters->addRouteParameter("module",
                $this->container->get("search.engine")->getModuleAlias("event"));
            $this->customDateFilterOption = new FilterMenuTreeNode(0, 0, "custom", 0, 0, 0, false,
                $searchParameters->buildPathTo(), 0);
        }

        return $this->customDateFilterOption;
    }

    /**
     * {@inheritdoc}
     */
    public function processAggregationResults($aggregationResults)
    {
        /* This filter has no aggregations */
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getStartDateString()
    {
        return $this->startDate ? $this->startDate->format($this->dateFormat) : '';
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getEndDateString()
    {
        return $this->endDate ? $this->endDate->format($this->dateFormat) : '';
    }

    /**
     * @return string
     */
    public function getUrlDateFormat()
    {
        return $this->urlDateFormat;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @return string
     */
    public function getQueryDateFormat()
    {
        return $this->queryDateFormat;
    }

    /**
     * @return string
     */
    public function getBootstrapDatepickerLanguage()
    {
        return $this->bootstrapDatepickerLanguage;
    }

    /**
     * @return string
     */
    public function getBootstrapDatepickerUrlDateFormat()
    {
        return $this->bootstrapDatepickerUrlDateFormat;
    }

    /**
     * @return string
     */
    public function getBootstrapDatepickerDateFormat()
    {
        return $this->bootstrapDatepickerDateFormat;
    }

    /**
     * Returns the currently selected date filter option
     * @return FilterMenuTreeNode|null
     */
    public function getSelectedFilter()
    {
        $return = null;

        $filterOptions = [
            $this->getAnyDateFilterOption(),
            $this->getFromTodayFilterOption(),
            $this->getTodayFilterOption(),
            $this->getWeekFilterOption(),
            $this->getWeekendFilterOption(),
            $this->getMonthFilterOption(),
        ];

        /* @var $pointer FilterMenuTreeNode */
        while ($return === null and $pointer = array_pop($filterOptions)) {
            $pointer->isSelected and $return = $pointer;
        }

        if (!$return && ($this->startDate || $this->endDate)) {
            $return = $this->getCustomDateFilterOption();
        }

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    protected function processAggregationBuckets($filterAggregationBuckets)
    {
        /* This filter has no buckets. */
    }
}
