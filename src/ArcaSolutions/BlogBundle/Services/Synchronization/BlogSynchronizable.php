<?php

namespace ArcaSolutions\BlogBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BlogSynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Modules/Blog.sql";
        $this->SQLConditional = "WHERE B.id  IN ( %s )";
        $this->configurationService = "blog.search";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            '_id'             => $info['_id'],
            'categoryId'      => $info['categoryId'],
            'thumbnail'       => $info['thumbnail'],
            'views'           => $info['views'],
            'friendlyUrl'     => $info['friendlyUrl'],
            'title'           => $info['title'],
            'content'         => $info['content'],
            'status'          => $info['status'],
            'searchInfo'      => [
                'keyword' => $info['searchInfo.keyword']
            ],
            'publicationDate' => $info['publicationDate'],
            'commentCount'    => $info['commentCount'],
            'level'           => $info['level'],
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

    public function addAverageReviewUpdate($id, $value)
    {
    }
}
