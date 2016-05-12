<?php

namespace ArcaSolutions\EventBundle\Services\Synchronization;

use ArcaSolutions\CoreBundle\Services\Synchronization\BaseCategorySynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EventCategorySynchronizable extends BaseCategorySynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->idFormat = "E:%d";
        $this->SQLQueryFile = "Category/EventCategory.sql";
    }
}
