<?php

namespace ArcaSolutions\ListingBundle\Services\Synchronization;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BadgeSynchronizable extends AllBadgesSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLConditional = "WHERE EC.id  IN ( %s )";
    }
}
