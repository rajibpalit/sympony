<?php

namespace ArcaSolutions\DealBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DealSynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Modules/Deal.sql";
        $this->SQLConditional = "WHERE D.id  IN ( %s )";
        $this->configurationService = "deal.search";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            'address'     => [
                'street'     => $info['address.street'],
                'complement' => $info['address.complement'],
            ],
            'amount'      => $info['amount'],
            'categoryId'  => $info['categoryId'],
            'date'        => [
                'end'   => $info['date.end'],
                'start' => $info['date.start'],
            ],
            'description' => $info['description'],
            'friendlyUrl' => $info['friendlyUrl'],
            'geoLocation' => [
                'lat' => $info['geoLocation.lat'],
                'lon' => $info['geoLocation.lon'],
            ],
            '_id'         => $info['_id'],
            'level'       => $info['level'],
            'listing'     => [
                'friendlyUrl' => $info['listing.friendlyUrl'],
                'title'       => $info['listing.title'],
            ],
            'locationId'  => $info['locationId'],
            'searchInfo'  => [
                'keyword'  => $info['searchInfo.keyword'],
                'location' => $info['searchInfo.location'],
            ],
            'status'      => $info['status'],
            'thumbnail'   => $info['thumbnail'],
            'title'       => $info['title'],
            'value'       => [
                'deal' => $info['value.deal'],
                'real' => $info['value.real'],
            ],
            'views'   => $info['views'],
            'suggest'     => [
                'what' => [
                    'input'   => $info['suggest.what.input'],
                    'output'  => $info['suggest.what.output'],
                    'payload' => $info['suggest.what.payload'],
                    'weight'  => $info['suggest.what.weight'],
                ]
            ]
        ];
    }

    public function addAverageReviewUpdate($id, $value)
    {
    }
}
