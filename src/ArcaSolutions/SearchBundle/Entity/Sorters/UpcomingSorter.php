<?php

namespace ArcaSolutions\SearchBundle\Entity\Sorters;

use Elastica\Query;

class UpcomingSorter extends BaseSorter
{
    protected static $name = "upcoming";

    public static function getSubscribedEvents()
    {
        return array(
            'search.global'         => 'register',
            'search.global.map'     => 'register',
        );
    }

    public function sort(Query $query)
    {
            $query->setSort([
                'date.start' => [
                    'order' => 'asc',
                    "unmapped_type" => "date"
                ],
                'level' => ['order' => 'asc']
            ]);
    }
}
