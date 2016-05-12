<?php

namespace ArcaSolutions\EventBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EventSynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Modules/Event.sql";
        $this->SQLConditional = "WHERE E.id  IN ( %s )";
        $this->configurationService = "event.search";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            'address'     => [
                'street'   => $info['address.street'],
                'zipcode'  => $info['address.zipcode'],
                'location' => $info['address.location'],
            ],
            'categoryId'  => $info['categoryId'],
            'date'        => [
                'end'   => $info['date.end'],
                'start' => $info['date.start'],
            ],
            'description' => $info['description'],
            'email'       => $info['email'],
            'friendlyUrl' => $info['friendlyUrl'],
            'geoLocation' => [
                'lat' => $info['geoLocation.lat'],
                'lon' => $info['geoLocation.lon'],
            ],
            '_id'         => $info['_id'],
            'level'       => $info['level'],
            'locationId'  => $info['locationId'],
            'phone'       => $info['phone'],
            'recurring'   => [
                'until'   => $info['recurring.until'],
                'enabled' => $info['recurring.enabled'],
            ],
            'searchInfo'  => [
                'keyword'  => $info['searchInfo.keyword'],
                'location' => $info['searchInfo.location'],
            ],
            'status'      => $info['status'],
            'thumbnail'   => $info['thumbnail'],
            'title'       => $info['title'],
            'url'         => $info['url'],
            'views'       => $info['views'],
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
