<?php

namespace ArcaSolutions\ArticleBundle\Repository;

use ArcaSolutions\CoreBundle\Repository\EntityCategoryRepository;

/**
 * Articlecategory
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticlecategoryRepository extends EntityCategoryRepository
{
    /**
     * {@inheritdoc}
     */
    public function getParentCategories($limit = null, $featured = true)
    {
        $this->setMaxItems($limit);
        $this->setActiveItemsNameField('activeArticle');

        return parent::getParentCategories($featured);
    }
}