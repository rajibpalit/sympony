<?php

namespace ArcaSolutions\CoreBundle\Services\Synchronization;

use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseCategorySynchronizable extends BaseSynchronizable
{
    function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->configurationService = "category.search";
        $this->SQLConditional = "WHERE C.id  IN ( %s )";
    }

    /**
     * @inheritdoc
     */
    public function extractFromResult($info)
    {
        return [
            '_id'           => $info['_id'],
            'title'         => $info['title'],
            'content'       => $info['content'],
            'description'   => $info['description'],
            'friendlyUrl'   => $info['friendlyUrl'],
            'parentId'      => $info['parentId'],
            'subCategoryId' => $info['subCategoryId'],
            'module'        => $info['module'],
            'seo'           => [
                'description' => $info['seo.description'],
                'keywords'    => $info['seo.keywords'],
                'title'       => $info['seo.title'],
            ],
            'suggest'       => [
                'what' => [
                    'input'   => $info['suggest.what.input'],
                    'payload' => $info['suggest.what.payload'],
                    'weight'  => $info['suggest.what.weight'],
                ]
            ]
        ];
    }

    public function addViewUpdate($ids)
    {
    }

    public function addAverageReviewUpdate($id, $value)
    {
    }
}
