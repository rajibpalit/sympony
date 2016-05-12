<?php

namespace ArcaSolutions\BlogBundle\Services\Synchronization;

use ArcaSolutions\CoreBundle\Services\Synchronization\BaseCategorySynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BlogCategorySynchronizable extends BaseCategorySynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->idFormat = "B:%d";
        $this->SQLQueryFile = "Category/BlogCategory.sql";
    }
}
