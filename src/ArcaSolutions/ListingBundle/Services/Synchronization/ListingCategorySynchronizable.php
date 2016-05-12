<?php

namespace ArcaSolutions\ListingBundle\Services\Synchronization;

use ArcaSolutions\CoreBundle\Services\Synchronization\BaseCategorySynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ListingCategorySynchronizable extends BaseCategorySynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->idFormat = "L:%d";
        $this->SQLQueryFile = "Category/ListingCategory.sql";
    }
}
