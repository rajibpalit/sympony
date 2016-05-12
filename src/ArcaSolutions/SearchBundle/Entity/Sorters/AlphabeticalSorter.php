<?php

namespace ArcaSolutions\SearchBundle\Entity\Sorters;

use Elastica\Query;

class AlphabeticalSorter extends BaseSorter
{
    protected static $name = "alphabetical";

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
        $query->setSort([
            'title.raw' => ['order' => 'asc']
        ]);
    }
}