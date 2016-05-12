<?php

namespace ArcaSolutions\SearchBundle\Entity\Sorters;

use ArcaSolutions\CoreBundle\Services\Utility;
use Elastica\Query;
use Elastica\Script;

class DistanceSorter extends BaseSorter
{
    protected static $name = "distance";
    private $userGeoLocation = null;

    function __construct($container)
    {
        parent::__construct($container);

        $this->userGeoLocation = Utility::extractGeoPoint($this->container->get("request_stack")->getCurrentRequest()
            ->cookies->get($container->get("search.engine")->getGeoLocationCookieName()));

        if ($this->userGeoLocation) {
            $this->script = new Script("searchDistance", $this->userGeoLocation);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'search.global'         => 'register',
            'search.classified'     => 'register',
            'search.deal'           => 'register',
            'search.event'          => 'register',
            'search.listing'        => 'register',
            'search.global.map'     => 'register',
            'search.classified.map' => 'register',
            'search.deal.map'       => 'register',
            'search.event.map'      => 'register',
            'search.listing.map'    => 'register'
        ];
    }

    public function needsGeoLocation()
    {
        return true;
    }

    public function sort(Query $query)
    {
        if ($this->userGeoLocation) {
            $geoLocationUnit = $this->container->get("translator")->trans("distance.unit", [], "units");
            $query->setSort([
                '_geo_distance' => [
                    'geoLocation' => $this->userGeoLocation,
                    'order'       => 'asc',
                    'unit'        => $geoLocationUnit
                ]
            ]);
        }
    }
}
