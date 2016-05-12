<?php

namespace ArcaSolutions\ArticleBundle\Entity\Internal;

use Doctrine\Bundle\DoctrineBundle\Registry;

class ArticleLevelFeatures
{
    /**
     * @var boolean
     */
    public $isFeatured = false;
    /**
     * @var boolean
     */
    public $isActive = false;
    /**
     * @var boolean
     */
    public $isDefault = false;
    /**
     * @var boolean
     */
    public $hasDetail = false;
    /**
     * @var int
     */
    public $imageCount = 0;
    /**
     * @var double
     */
    public $price = 0;
    /**
     * @var int
     */
    public $level = 0;
    /**
     * @var string
     */
    public $name = null;
    /**
     * @var string
     */
    public $theme = null;
    /**
     * @var string
     */
    public $content = null;

    /**
     * @param $theme
     * @param Registry $doctrine
     * @return array
     */
    public static function getByTheme($theme, $doctrine)
    {
        $return = [];

        $levels = $doctrine->getRepository('ArticleBundle:Articlelevel')->findBy(["theme" => $theme]);

        foreach ($levels as $level) {
            $fields = $doctrine->getRepository('ArticleBundle:Articlelevel')
                ->findBy([
                    "theme" => $theme,
                    "value" => $level->getValue()
                ]);

            $articleLevel = new ArticleLevelFeatures();

            $articleLevel->name = (string)$level->getName();
            $articleLevel->theme = (string)$level->getTheme();

            $articleLevel->isActive = $level->getActive() == "y";

            $articleLevel->level = (int)$level->getValue();
            $articleLevel->imageCount = (int)$level->getImages();

            $articleLevel->price = (double)$level->getPrice();

            $articleLevel->isDefault = $level->getDefaultlevel() == 'y';
            $articleLevel->content = $level->getContent();
            $articleLevel->isFeatured = $level->getFeatured() == 'y';

            /* Setting all the has */
            //$articleLevel->hasCheezburger = true;

            $articleLevel->hasDetail = $level->getDetail() == "y";

            $return[$level->getValue()] = $articleLevel;
        }

        return $return;
    }


}
