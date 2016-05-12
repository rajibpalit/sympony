<?php

namespace ArcaSolutions\ListingBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AllBadgesSynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Badges/Badge.sql";
        $this->SQLConditional = null;
        $this->configurationService = "badge.search";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            '_id' => $info['_id'],
            'available' => $info['available'],
            'image' => $info['image'],
            'name' => $info['name'],
        ];
    }

    public function addViewUpdate($ids)
    {
    }

    public function addAverageReviewUpdate($id, $value)
    {
    }
}
