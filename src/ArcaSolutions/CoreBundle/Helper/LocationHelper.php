<?php

namespace ArcaSolutions\CoreBundle\Helper;

use Doctrine\Common\Cache\ApcCache;
use Symfony\Component\DependencyInjection\Container;

class LocationHelper
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Return all location and your children
     *
     * @param array $levels
     * @return array
     * @throws \Exception
     */
    public function getAllLocations(Array $levels)
    {
        if (!is_array($levels)) {
            throw new \Exception('You must pass a array');
        }

        $cacheDriver = $this->container->get('apccache.edirectory.service');

        if ($cacheDriver->contains('_all-locations')) {
            $locations = $cacheDriver->fetch('_all-locations');
        } else {
            $level = array_shift($levels);
            $locations = $this->getLocation($level, $levels);

            $cacheDriver->save('_all-locations', $locations, 60 * 60);
        }

        return $locations;
    }

    /**
     * @param int $level
     * @param array $levels
     * @return array
     */
    public function getLocation($level, array $levels, $parentField = false, $parent = false)
    {
        $repository = 'CoreBundle:Location' . $level;
        $levelLocation = $this->container->get('doctrine')
            ->getRepository($repository, 'main');

        if ($parentField and $parent) {
            $levelLocation = $levelLocation->findBy(array('location' . $parentField => $parent), ['name' => 'ASC']);
        } else {
            $levelLocation = $levelLocation->findBy(array(), ['name' => 'ASC']);
        }

        $locations = array();
        $nextLevel = array_shift($levels);
        foreach ($levelLocation as $location) {
            $locations[] = array(
                'item'     => $location,
                'children' => !empty($nextLevel) ? $this->getLocation($nextLevel, $levels, $level,
                    $location->getId()) : null,
            );
        }

        return $locations;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     *
     * @api
     */
    public function getName()
    {
        return 'LocationHelper';
    }
}
