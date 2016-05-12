<?php

namespace ArcaSolutions\ListingBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ListingSynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Modules/Listing.sql";
        $this->SQLConditional = "WHERE L.id IN ( %s )";
        $this->configurationService = "listing.search";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            'averageReview'   => $info['averageReview'],
            'address'         => [
                'complement' => $info['address.complement'],
                'street'     => $info['address.street'],
                'zipcode'    => $info['address.zipcode'],
            ],
            'backlink'        => $info['backlink'],
            'badgeId'         => $info['badgeId'],
            'categoryId'      => $info['categoryId'],
            '_id'             => $info['_id'],
            'claim'           => $info['claim'],
            'dealFriendlyUrl' => $info['dealFriendlyUrl'],
            'description'     => $info['description'],
            'email'           => $info['email'],
            'fax'             => $info['fax'],
            'friendlyUrl'     => $info['friendlyUrl'],
            'geoLocation'     => [
                'lat' => $info['geoLocation.lat'],
                'lon' => $info['geoLocation.lon']
            ],
            'level'           => $info['level'],
            'locationId'      => $info['locationId'],
            'phone'           => $info['phone'],
            'price'           => $info['price'],
            'reviewCount'     => $info['reviewCount'],
            'searchInfo'      => [
                'keyword'  => $info['searchInfo.keyword'],
                'location' => $info['searchInfo.location']
            ],
            'status'          => $info['status'],
            'thumbnail'       => $info['thumbnail'],
            'title'           => $info['title'],
            'url'             => $info['url'],
            'views'           => $info['views'],
            'suggest'         => [
                'what' => [
                    'input'   => $info['suggest.what.input'],
                    'output'  => $info['suggest.what.output'],
                    'payload' => $info['suggest.what.payload'],
                    'weight'  => $info['suggest.what.weight'],
                ]
            ]
        ];
    }
}
