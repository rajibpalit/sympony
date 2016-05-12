<?php

namespace ArcaSolutions\CoreBundle\Services\Synchronization;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AllCategoriesSynchronizable extends BaseCategorySynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Category/AllCategories.sql";
        $this->SQLConditional = null;
    }
}
