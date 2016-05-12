<?php

namespace ArcaSolutions\SearchBundle\Entity\Filters;

use ArcaSolutions\SearchBundle\Entity\FilterMenuTreeNode;
use ArcaSolutions\SearchBundle\Events\SearchEvent;
use ArcaSolutions\SearchBundle\Services\SearchEngine;

class ModuleFilter extends BaseFilter
{
    /**
     * {@inheritdoc}
     */
    protected static $name = "ModuleFilter";

    private $aggregationInfo;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'search.global'     => [['registerItem', -100]],
            'search.global.map' => [['registerItem', -100]],
        ];
    }

    public function registerItem(SearchEvent $event, $eventName)
    {
        $this->register($event, $eventName);

        $parameterInfo = $this->container->get("search.parameters");
        $searchEngine = $this->container->get("search.engine");
        $qb = SearchEngine::getElasticaQueryBuilder();

        if ($searchedModules = $parameterInfo->getRouteParameter("module")) {

            $filters = [];

            while ($module = array_pop($searchedModules)) {
                $filters[] = $qb->filter()->type(
                    $searchEngine->getElasticTypeByModuleAlias($module)
                );
            }

            if (count($filters) > 1) {
                $this->addElasticaPostFilter($qb->filter()->bool_or($filters));
            } else {
                $this->addElasticaPostFilter(array_pop($filters));
            }

        }
    }

    public function getElasticaAggregations()
    {
        $subscribedEvents = self::getSubscribedEvents();

        switch ($subscribedEvents[$this->eventName][0][0]) {
            case 'registerItem' :
                $qb = SearchEngine::getElasticaQueryBuilder();

                $aggregation = $qb->aggregation()->terms(static::$name)
                    ->setField("_type")
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

    /**
     * {@inheritdoc}
     */
    public function getFilterView()
    {
        $return = null;

        if ($this->aggregationInfo && count($this->aggregationInfo) > 1) {
            $searchEngine = $this->container->get("search.engine");

            $modules = [];
            /* Gets the friendlyUrl of the categories being searched for */
            $requestModules = $this->container->get("search.parameters")->getRouteParameter("module");

            foreach ($this->aggregationInfo as $module => $documentCount) {
                $alias = $searchEngine->getModuleAlias($module);

                $modules[$module] = new FilterMenuTreeNode(
                    null,
                    null,
                    $alias,
                    $module,
                    null,
                    null,
                    in_array($alias, $requestModules),
                    $this->getSearchPageUrl($alias),
                    $documentCount,
                    false
                );
            }

            $return = $this->container->get("twig")->render(
                "::blocks/filters/module.html.twig",
                [
                    "availableModules" => $modules,
                    "selectedModules"  => $requestModules
                ]
            );
        }

        return $return;
    }

    /**
     * Removes from a category tree root all categories not marked as used (isUsed == true)
     * @param $friendlyUrl
     * @return array
     */
    private function getSearchPageUrl($friendlyUrl)
    {
        $result = null;

        if ($friendlyUrl) {
            $searchParameters = clone $this->container->get("search.parameters");
            $searchParameters->toggleRouteParameter("module", $friendlyUrl);
            $result = $searchParameters->buildPathTo();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function processAggregationBuckets($filterAggregationBuckets)
    {
        $this->aggregationInfo = null;

        foreach ($filterAggregationBuckets as $bucket) {
            if ($documentCount = isset($bucket['filtered']) ? $bucket['filtered']['doc_count'] : $bucket['doc_count']) {
                $this->aggregationInfo[$bucket['key']] = $documentCount;
            }
        }
    }
}
