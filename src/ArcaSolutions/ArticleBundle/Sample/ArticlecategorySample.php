<?php
namespace ArcaSolutions\ArticleBundle\Sample;

use ArcaSolutions\ArticleBundle\Entity\Articlecategory;

class ArticlecategorySample extends Articlecategory
{
    /**
     * ArticlecategorySample constructor.
     *
     * @param misc $translator
     * @param int $counter
     */
    public function __construct($translator, $counter)
    {
        $this->setTitle($translator->trans('Category ').++$counter)
            ->setActiveArticle(rand() % 100 + 1)
            ->setFriendlyUrl('category-sample')
            ->setEnabled('y');
    }
}
