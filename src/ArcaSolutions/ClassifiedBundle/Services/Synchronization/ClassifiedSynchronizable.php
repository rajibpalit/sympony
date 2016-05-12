<?php

namespace ArcaSolutions\ClassifiedBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClassifiedSynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Modules/Classified.sql";
        $this->SQLConditional = "WHERE C.id  IN ( %s )";
        $this->configurationService = "classified.search";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            '_id'         => $info['_id'],
            'locationId'  => $info['locationId'],
            'categoryId'  => $info['categoryId'],
            'thumbnail'   => $info['thumbnail'],
            'title'       => $info['title'],
            'friendlyUrl' => $info['friendlyUrl'],
            'description' => $info['description'],
            'searchInfo'  => [
                'keyword'  => $info['searchInfo.keyword'],
                'location' => $info['searchInfo.location'],
            ],
            'geoLocation' => [
                'lat' => $info['geoLocation.lat'],
                'lon' => $info['geoLocation.lon'],
            ],
            'level'       => $info['level'],
            'status'      => $info['status'],
            'views'       => $info['views'],
            'price'       => $info['price'],
            'address'     => [
                'street'     => $info['address.street'],
                'complement' => $info['address.complement'],
            ],
            'url'         => $info['url'],
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
