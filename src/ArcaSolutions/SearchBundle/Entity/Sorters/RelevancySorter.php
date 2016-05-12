<?php

namespace ArcaSolutions\SearchBundle\Entity\Sorters;

use Elastica\Query;

class RelevancySorter extends BaseSorter
{
    protected static $name = "relevancy";

    public static function getSubscribedEvents()
    {
        return array(
            'search.global'     => 'register',
            'search.article'    => 'register',
            'search.blog'       => 'register',
            'search.classified' => 'register',
            'search.deal'       => 'register',
            'search.event'      => 'register',
            'search.listing'    => 'register'
        );
    }

    public function sort(Query $query)
    {

        if($this->container->get("search.parameters")->getRouteParameter("keyword")){
            $query->setParam("track_scores", true);
            $query->setSort([
                '_score' => ['order' => 'desc'],
                'level'  => [
                    'order'         => 'asc',
                    "unmapped_type" => "integer"
                ],
            ]);
        } else {
            $query->setParam("track_scores", false);
            $query->setSort([
                'level'  => [
                    'order'         => 'asc',
                    "unmapped_type" => "integer"
                ],
            ]);
        }
    }
}
