<?php

namespace ArcaSolutions\EventBundle\Search;

use ArcaSolutions\CoreBundle\Search\BaseConfiguration;
use ArcaSolutions\CoreBundle\Services\Utility;
use ArcaSolutions\EventBundle\Entity\Internal\EventLevelFeatures;
use ArcaSolutions\SearchBundle\Events\SearchEvent;
use ArcaSolutions\SearchBundle\Services\SearchBlock;
use ArcaSolutions\SearchBundle\Services\SearchEngine;
use Elastica\Filter\AbstractFilter;
use Elastica\QueryBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EventConfiguration extends BaseConfiguration
{
    /**
     * @var string|null
     */
    public static $elasticType = "event";
    /**
     * @var string
     */
    protected $moduleUrlName = null;

    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->moduleUrlName = $container->getParameter("alias_event_module");
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'search.global'     => 'registerItem',
            'search.global.map' => 'registerItem',
            'featured.event'    => 'registerFeatured',
            'popular.event'     => 'registerPopular'
        ];
    }

    public function registerItem(SearchEvent $searchEvent)
    {
        $this->register($searchEvent);
        $qB = SearchEngine::getElasticaQueryBuilder();

        if ($keyword = Utility::convertArrayToString($this->searchEvent->getKeyword())) {
            $query = $qB->query()->multi_match()
                ->setQuery($keyword)
                ->setTieBreaker(0.3)
                ->setOperator("and")
                ->setFields([
                    'friendlyUrl^500',
                    'title.raw^200',
                    'title.analyzed^10',
                    'description^5',
                    'searchInfo.keyword^1',
                    'searchInfo.location^1'
                ]);
        } else {
            $query = $qB->query()->match_all();
        }

        $filter = $qB->filter()->bool()
            ->addMust($qB->filter()->type(self::$elasticType))
            ->addMust($qB->filter()->term()->setTerm("status", true));

        $dateFilter = $this->container->get("filter.date");

        if (!$dateFilter->isCalendarSearch()) {
            $today = new \DateTime();
            $startDateString = $today->format($dateFilter->getQueryDateFormat());

            $filter->addMust(
                $qB->filter()->bool_or()
                    ->addFilter($qB->filter()->bool_and()
                        ->addFilter($qB->filter()->term()->setTerm("recurring.enabled", 0))
                        ->addFilter($qB->filter()->range("date.end", ['gte' => $startDateString])))
                    ->addFilter($qB->filter()->bool_and()
                        ->addFilter($qB->filter()->term()->setTerm("recurring.enabled", 1))
                        ->addFilter(
                            $qB->filter()->bool_or()
                                ->addFilter($qB->filter()->missing("recurring.until"))
                                ->addFilter($qB->filter()->range("recurring.until", ['gt' => $startDateString]))
                        ))
            );
        }

        $this->setElasticaQuery(
            $qB->query()->filtered($query, $filter)
        );
    }

    public function registerSuggest(SearchEvent $event)
    {
        $this->register($event);

        $qB = SearchEngine::getElasticaQueryBuilder();

        $this->setElasticaQuery(
            $qB->query()->filtered(
                $qB->query()->match_all(),
                $qB->filter()->bool()
                    ->addMust($qB->filter()->term()->setTerm("_type", self::$elasticType))
                    ->addMust($qB->filter()->term()->setTerm("status", true))
                    ->addShould($this->getConditionForNoRecurringEvent($qB))
                    ->addShould($this->getConditionForRecurringEvent($qB))
            )
        );
    }

    /**
     * Gets condition for no recurring event using QueryBuilder from Elastica
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return AbstractFilter
     */
    private function getConditionForNoRecurringEvent(QueryBuilder $queryBuilder)
    {
        return $queryBuilder->filter()->bool()
            ->addMust(
                $queryBuilder->filter()->term()->setTerm("recurring.enabled", 0)
            )
            ->addMust($queryBuilder->filter()->range("date.end", ['gte' => "now"]));
    }

    /**
     * Gets condition for no recurring event using QueryBuilder from Elastica
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return AbstractFilter
     */
    private function getConditionForRecurringEvent(QueryBuilder $queryBuilder)
    {
        return $queryBuilder->filter()->bool()
            ->addMust(
                $queryBuilder->filter()->term()->setTerm("recurring.enabled", 1)
            )
            ->addMust($queryBuilder->filter()->bool()
                ->addShould($queryBuilder->filter()->term()->setTerm("recurring.until", 0))
                ->addShould($queryBuilder->filter()->range("recurring.until", ['gt' => "now"]))
            );
    }

    /**
     * Gets features listings using elasticSearch
     *
     * @param SearchEvent $event
     */
    public function registerFeatured(SearchEvent $event)
    {
        /* registers this event */
        $this->register($event);

        $qb = SearchEngine::getElasticaQueryBuilder();

        /* all levels with module as a key */
        $this->getLevelFeatures($featuredLevels);

        /* getting just featured levels */
        $featuredLevels = array_filter(array_map(function ($array) {
            if ('y' == $array->isFeatured) {
                return $array->level;
            }
        }, current($featuredLevels)));

        /* query */
        $this->setElasticaQuery(
            $qb->query()->filtered(
            /* gets all */
                $qb->query()->match_all(),
                $qb->filter()->bool()
                    /* sets level */
                    ->addMust($qb->filter()->terms()->setTerms('level', $featuredLevels))
                    /* sets status */
                    ->addMust($qb->filter()->term()->setTerm('status', true))
                    /* excludes previous items using var from SearchBlock */
                    ->addMustNot($qb->filter()->terms()
                        ->setTerms('_id', SearchBlock::$previousItems[self::$elasticType]))
                    /* conditions events */
                    ->addShould($this->getConditionForNoRecurringEvent($qb))
                    ->addShould($this->getConditionForRecurringEvent($qb))
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getLevelFeatures(&$features)
    {
        /* Sets Event level information to be used while rendering the summary templates */
        $features[self::$elasticType] = EventLevelFeatures::getByTheme(
            $this->container->get("multi_domain.information")->getTemplate(),
            $this->container->get("doctrine")
        );
    }

    /**
     * @param SearchEvent $searchEvent
     */
    public function registerPopular(SearchEvent $searchEvent)
    {
        /* registers this event */
        $this->register($searchEvent);

        $qb = SearchEngine::getElasticaQueryBuilder();

        $searchEvent->setDefaultSorter($this->container->get('sorter.view'));

        /* query */
        $this->setElasticaQuery(
            $qb->query()->filtered(
            /* gets all */
                $qb->query()->match_all(),
                $qb->filter()->bool()
                    /* sets status */
                    ->addMust($qb->filter()->term()->setTerm('status', true))
                    /* excludes previous items using var from SearchBlock */
                    ->addMustNot($qb->filter()->terms()
                        ->setTerms('_id', SearchBlock::$previousItems[self::$elasticType]))
                    /* conditions events */
                    ->addShould($this->getConditionForNoRecurringEvent($qb))
                    ->addShould($this->getConditionForRecurringEvent($qb))
            )
        );
    }
}
