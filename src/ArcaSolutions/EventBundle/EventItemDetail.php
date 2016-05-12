<?php

namespace ArcaSolutions\EventBundle;

use ArcaSolutions\CoreBundle\Interfaces\ItemDetailInterface;
use ArcaSolutions\EventBundle\Entity\Event;
use ArcaSolutions\EventBundle\Entity\Internal\EventLevelFeatures;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EventItemDetail
 *
 * @package ArcaSolutions\EventBundle
 */
final class EventItemDetail implements ItemDetailInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Event
     */
    private $item = null;

    /**
     * @var EventLevelFeatures
     */
    private $level = null;

    /**
     * @param ContainerInterface $containerInterface
     * @param Event              $event
     */
    public function __construct(ContainerInterface $containerInterface, Event $event)
    {
        $this->container = $containerInterface;
        $this->item = $event;

        /* sets item's level */
        $this->setLevel();
    }

    /**
     * Sets item's level
     */
    private function setLevel()
    {
        /* gets levels */
        $level = EventLevelFeatures::getByTheme(
            $this->container->get("multi_domain.information")->getTemplate(),
            $this->container->get("doctrine")
        );

        /* setting level */
        $this->level = $level[$this->item->getLevel()];
    }

    /** {@inheritdoc} */
    public function getModuleName()
    {
        return 'event';
    }

    /** {@inheritdoc} */
    public function getLevel()
    {
        /* checks if item was seated */
        if (is_null($this->item)) {
            throw new \Exception('You must set the item');
        }

        return $this->level;
    }

    /** {@inheritdoc} */
    public function getItem()
    {
        /* checks if item was seated */
        if (is_null($this->item)) {
            throw new \Exception('You must set the item');
        }

        return $this->item;
    }

    /**
     * Returns container object to give access on services
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
