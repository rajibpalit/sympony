<?php

namespace ArcaSolutions\CoreBundle\Services;

use ArcaSolutions\ArticleBundle\Entity\Article;
use ArcaSolutions\ClassifiedBundle\Entity\Classified;
use ArcaSolutions\EventBundle\Entity\Event;
use ArcaSolutions\ListingBundle\Entity\Listing;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LocationService
 *
 * @package ArcaSolutions\CoreBundle\Services
 */
class LocationService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns country, region, state, city and neighborhood objects
     * Workaround to get item's location
     *
     * @param Listing|Article|Classified|Event $item
     *
     * @return array
     */
    public function getLocations($item)
    {
        $array = [
            'neighborhood'  => null,
            'city'          => null,
            'state'         => null,
            'region'        => null,
            'country'       => null
        ];

        if ($item->getLocation1()) {
            $array['country'] = $this->container->get('doctrine')->getRepository('CoreBundle:Location1', 'main')
                ->find($item->getLocation1());
            /* workaround to it works like in elastic search */
            if($array['country']){
                $array['country']->level = 1;
            }
        }

        if ($item->getLocation2()) {
            $array['region'] = $this->container->get('doctrine')->getRepository('CoreBundle:Location2', 'main')
                ->find($item->getLocation2());
            /* workaround to it works like in elastic search */
            if($array['region']){
                $array['region']->level = 2;
            }
        }

        if ($item->getLocation3()) {
            $array['state'] = $this->container->get('doctrine')->getRepository('CoreBundle:Location3', 'main')
                ->find($item->getLocation3());
            /* workaround to it works like in elastic search */
            if($array['state']){
                $array['state']->level = 3;
            }
        }

        if ($item->getLocation4()) {
            $array['city'] = $this->container->get('doctrine')->getRepository('CoreBundle:Location4', 'main')
                ->find($item->getLocation4());
            /* workaround to it works like in elastic search */
            if($array['city']){
                $array['city']->level = 4;
            }
        }

        if ($item->getLocation5()) {
            $array['neighborhood'] = $this->container->get('doctrine')->getRepository('CoreBundle:Location5', 'main')
                ->find($item->getLocation5());
            /* workaround to it works like in elastic search */
            if($array['neighborhood']){
                $array['neighborhood']->level = 5;
            }
        }

        return $array;
    }
}
