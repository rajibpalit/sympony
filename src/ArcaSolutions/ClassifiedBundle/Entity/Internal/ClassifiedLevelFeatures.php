<?php

namespace ArcaSolutions\ClassifiedBundle\Entity\Internal;

use Doctrine\Bundle\DoctrineBundle\Registry;

class ClassifiedLevelFeatures
{
    /**
     * @var boolean
     */
    public $hasDetail = false;
    /**
     * @var boolean
     */
    public $hasURL = false;
    /**
     * @var boolean
     */
    public $hasFax = false;
    /**
     * @var boolean
     */
    public $hasSummaryDescription = false;
    /**
     * @var boolean
     */
    public $hasLongDescription = false;
    /**
     * @var boolean
     */
    public $hasContactName = false;
    /**
     * @var boolean
     */
    public $hasContactPhone = false;
    /**
     * @var boolean
     */
    public $hasContactEmail = false;
    /**
     * @var boolean
     */
    public $hasClassifiedPrice = false;

    /**
     * @var boolean
     */
    public $isActive = false;
    /**
     * @var boolean
     */
    public $isFeatured = false;
    /**
     * @var boolean
     */
    public $isPopular = false;
    /**
     * @var boolean
     */
    public $isDefault = false;

    /**
     * @var double
     */
    public $price = 0;
    /**
     * @var int
     */
    public $imageCount = 0;
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
     * @param          $theme
     * @param Registry $doctrine
     *
     * @return array
     */
    public static function getByTheme($theme, $doctrine)
    {
        $return = [];

        $levels = $doctrine->getRepository('ClassifiedBundle:ClassifiedLevel')->findBy(["theme" => $theme]);

        foreach ($levels as $level) {
            $fields = $doctrine->getRepository('ClassifiedBundle:ClassifiedLevelField')
                ->findBy([
                    "theme" => $theme,
                    "level" => $level->getValue()
                ]);

            $classifiedLevel = new ClassifiedLevelFeatures();

            $classifiedLevel->name = (string)$level->getName();
            $classifiedLevel->theme = (string)$level->getTheme();

            $classifiedLevel->isActive = $level->getActive() == "y";
            $classifiedLevel->isDefault = $level->getDefaultlevel() == "y";
            $classifiedLevel->isPopular = $level->getPopular() == "y";

            $classifiedLevel->level = (int)$level->getValue();
            $classifiedLevel->imageCount = (int)$level->getImages();

            $classifiedLevel->price = (double)$level->getPrice();

            /* Setting all the has */

            $classifiedLevel->hasDetail = $level->getDetail() == "y";

            $classifiedLevel->isFeatured = $level->getFeatured() == "y";

            foreach ($fields as $field) {
                switch ($field->getField()) {
                    case "contact_name" :
                        $classifiedLevel->hasContactName = true;
                        break;
                    case "contact_phone" :
                        $classifiedLevel->hasContactPhone = true;
                        break;
                    case "contact_email" :
                        $classifiedLevel->hasContactEmail = true;
                        break;
                    case "fax" :
                        $classifiedLevel->hasFax = true;
                        break;
                    case "url" :
                        $classifiedLevel->hasURL = true;
                        break;
                    case "long_description" :
                        $classifiedLevel->hasLongDescription = true;
                        break;
                    case "summary_description" :
                        $classifiedLevel->hasSummaryDescription = true;
                        break;
                    case "main_image" :
                        $classifiedLevel->imageCount++;
                        break;
                    case "price" :
                        $classifiedLevel->hasClassifiedPrice = true;
                        break;
                }
            }

            $return[$level->getValue()] = $classifiedLevel;
        }

        return $return;
    }


}
