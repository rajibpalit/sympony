<?php

namespace ArcaSolutions\ArticleBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ArticleSynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->SQLQueryFile = "Modules/Article.sql";
        $this->SQLConditional = "WHERE A.id  IN ( %s )";
        $this->configurationService = "article.search";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            'abstract'        => $info['abstract'],
            'accountId'       => $info['accountId'],
            'author'          => [
                'name' => $info['author.name'],
                'url'  => $info['author.url'],
            ],
            'averageReview'   => $info['averageReview'],
            'friendlyUrl'     => $info['friendlyUrl'],
            '_id'             => $info['_id'],
            'level'           => $info['level'],
            'publicationDate' => $info['publicationDate'],
            'reviewCount'     => $info['reviewCount'],
            'searchInfo'      => [
                'keyword' => $info['searchInfo.keyword']
            ],
            'status'          => $info['status'],
            'thumbnail'       => $info['thumbnail'],
            'title'           => $info['title'],
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
