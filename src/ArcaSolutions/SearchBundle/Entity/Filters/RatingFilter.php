<?php

namespace ArcaSolutions\SearchBundle\Entity\Filters;

use ArcaSolutions\SearchBundle\Entity\FilterMenuTreeNode;
use ArcaSolutions\SearchBundle\Events\SearchEvent;
use ArcaSolutions\SearchBundle\Services\SearchEngine;

class RatingFilter extends BaseTranslatableUrlFilter
{
    /**
     * {@inheritdoc}
     */
    protected static $name = "RatingFilter";
    /**
     * {@inheritdoc}
     */
    protected static $filterUrlName = "rating";

    private $aggregationInfo;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'search.article'     => 'registerItem',
            'search.global'      => 'registerItem',
            'search.global.map'  => 'registerMapItem',
            'search.listing'     => 'registerItem',
            'search.listing.map' => 'registerMapItem',
        );
    }

    public function registerMapItem(SearchEvent $searchEvent, $eventName)
    {
        $this->register($searchEvent, $eventName);

        if ($ratingInfo = $this->container->get("search.parameters")->getQueryParameter($this->translatedName)) {
            $this->addElasticaFilter(
                SearchEngine::getElasticaQueryBuilder()->filter()->terms("averageReview", $ratingInfo)
            );
        }
    }

    public function registerItem(SearchEvent $searchEvent, $eventName)
    {
        $this->register($searchEvent, $eventName);

        $qb = SearchEngine::getElasticaQueryBuilder();

        if ($ratingInfo = $this->container->get("search.parameters")->getQueryParameter($this->translatedName)) {
            $this->addElasticaPostFilter(
                $qb->filter()->terms("averageReview", $ratingInfo)
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterView()
    {
        $return = null;

        if ($this->aggregationInfo) {
            $menuNodes = [];

            $requestFilterRatings = $this->container->get("search.parameters")->getQueryParameter($this->translatedName);

            krsort($this->aggregationInfo, SORT_NUMERIC);

            foreach ($this->aggregationInfo as $key => $value) {
                $menuNodes[$key] = new FilterMenuTreeNode(
                    null,
                    null,
                    $key,
                    null,
                    null,
                    $key,
                    in_array($key, $requestFilterRatings),
                    $this->getSearchPageUrl($key),
                    $value["numberOfItems"]
                );
            }

            $return = $this->container->get("twig")->render(
                "::blocks/filters/rating.html.twig",
                ["menuNodes" => $menuNodes]
            );
        }


        return $return;
    }

    /**
     * @param $rating
     * @return array
     */
    private function getSearchPageUrl($rating)
    {
        $result = null;

        if ($searchParameters = clone $this->container->get("search.parameters")) {
            $searchParameters->toggleQueryParameter($this->translatedName, $rating);
            $result = $searchParameters->buildPathTo();
        }

        return $result;
    }

    public function getElasticaAggregations()
    {
        $subscribedEvents = self::getSubscribedEvents();

        switch ($subscribedEvents[$this->eventName]) {
            case 'registerItem' :
                $qb = SearchEngine::getElasticaQueryBuilder();

                $aggregation = $qb->aggregation()->terms(static::$name)
                    ->setField("averageReview")
                    ->setSize(0);

                $filters = $this->searchEvent->getElasticaPostFilters();
//                unset ($filters[static::$name]);

                if($filters){
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

    /**
     * {@inheritdoc}
     */
    protected function processAggregationBuckets($filterAggregationBuckets)
    {
        $this->aggregationInfo = null;

        foreach ($filterAggregationBuckets as $bucket) {

            if ($bucket['key'] > 0 and $documentCount = isset($bucket['filtered']) ? $bucket['filtered']['doc_count'] : $bucket['doc_count']) {
                $this->aggregationInfo[$bucket['key']] = [ "numberOfItems" => $documentCount];
            }
        }
    }
}
