<?php

namespace ArcaSolutions\CoreBundle\Search;

use ArcaSolutions\SearchBundle\Events\SearchEvent;
use Elastica;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class BaseConfiguration implements EventSubscriberInterface
{
    /**
     * @var bool
     */
    protected $typeIncludedOnSearch = true;
    /**
     * @var string|null
     */
    public static $elasticType = null;
    /**
     * @var string
     */
    protected static $module = null;
    /**
     * @var Elastica\Aggregation\AbstractAggregation[]
     */
    protected $elasticaAggregations = [];
    /**
     * @var Elastica\Filter\AbstractFilter[]
     */
    protected $elasticaFilters = [];
    /**
     * @var Elastica\Query\AbstractQuery
     */
    protected $elasticaQuery = null;
    /**
     * @var SearchEvent
     */
    protected $searchEvent = null;
    /**
     * @var Container
     */
    protected $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * True if the $elasticType of this module should be added to the final search
     * @return boolean
     */
    public function isTypeIncludedOnSearch()
    {
        return $this->typeIncludedOnSearch;
    }

    /**
     * Returns the Elasticsearch Type associated with this module
     * @return string|null
     */
    public function getElasticType()
    {
        return static::$elasticType;
    }

    /**
     * Registers this module to the $event. This means all queries, filters and aggregations
     * associated with this module will be inserted into the final query.
     * @param SearchEvent $event
     */
    public function register(SearchEvent $event)
    {
        $this->searchEvent = $event;
        $event->addModule($this, static::$elasticType);
    }

    /**
     * Returns this module's inserted Elastica filters
     * @return Elastica\Filter\AbstractFilter[]
     */
    public function getElasticaFilters()
    {
        return $this->elasticaFilters;
    }

    /**
     * Adds this module's Elastica filters to be added to the final Search instance
     * @param Elastica\Filter\AbstractFilter $elasticaFilter
     * @param $key
     */
    public function addElasticaFilter($elasticaFilter, $key = null)
    {
        $key or $key = static::$elasticType;

        $this->elasticaFilters[$key] = $elasticaFilter;
    }

    /**
     * Returns this module's inserted Elastica query
     * @return Elastica\Query\AbstractQuery
     */
    public function getElasticaQuery()
    {
        return $this->elasticaQuery;
    }

    /**
     * Sets this module's Elastica Query to be added to the final Search instance
     * @param Elastica\Query\AbstractQuery $elasticaQuery
     * @param $key
     */
    public function setElasticaQuery($elasticaQuery, $key = null)
    {
        $key or $key = static::$elasticType;

        $this->elasticaQuery = [$key => $elasticaQuery];
    }

    /**
     * Returns this module's inserted Elastica aggregations
     * @return Elastica\Aggregation\AbstractAggregation[]
     */
    public function getElasticaAggregations()
    {
        return $this->elasticaAggregations;
    }

    /**
     * Adds an aggregation to be inserted into the final Search instance
     * @param $key
     * @param Elastica\Aggregation\AbstractAggregation $elasticaAggregation
     */
    public function addElasticaAggregation($key, $elasticaAggregation)
    {
        $key or $key = static::$elasticType;
        $this->elasticaAggregations[$key] = $elasticaAggregation;
    }

    /**
     * This functions feeds the module configuration level features into the &features array, if any.
     * Per convention, the key name should be the module's name.
     * @param array &$features
     */
    public function getLevelFeatures(&$features)
    {
    }

    /**
     * Returns all js twigs which should be rendered in the results page
     * @return string[]
     */
    public function getResultsJS()
    {
        return [];
    }
}
