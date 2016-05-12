<?php

namespace ArcaSolutions\ListingBundle\Entity\Internal;

use Doctrine\Bundle\DoctrineBundle\Registry;

class ListingLevelFeatures
{
    /**
     * @var boolean
     */
    public $hasDetail = false;
    /**
     * @var boolean
     */
    public $hasDeal = false;
    /**
     * @var boolean
     */
    public $hasReview = false;
    /**
     * @var boolean
     */
    public $hasBacklink = false;
    /**
     * @var boolean
     */
    public $hasEmail = false;
    /**
     * @var boolean
     */
    public $hasURL = false;
    /**
     * @var boolean
     */
    public $hasPhone = false;
    /**
     * @var boolean
     */
    public $hasFax = false;
    /**
     * @var boolean
     */
    public $hasVideo = false;
    /**
     * @var boolean
     */
    public $hasAdditionalFiles = false;
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
    public $hasHoursOfWork = false;
    /**
     * @var boolean
     */
    public $hasLocationReference = false;
    /**
     * @var boolean
     */
    public $hasBadges = false;
    /**
     * @var boolean
     */
    public $hasFacebookPage = false;
    /**
     * @var boolean
     */
    public $hasFeatureInformation = false;
    /**
     * @var boolean
     */
    public $hasClickToCall = false;
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
    public $categoryPrice = 0;
    /**
     * @var double
     */
    public $price = 0;
    /**
     * @var int
     */
    public $freeCategoryCount = 0;
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
     * @param $theme
     * @param Registry $doctrine
     * @return array
     */
    public static function getByTheme($theme, $doctrine)
    {
        $return = [];

        $levels = $doctrine->getRepository('ListingBundle:ListingLevel')->findBy(["theme" => $theme]);

        foreach ($levels as $level) {
            $fields = $doctrine->getRepository('ListingBundle:ListingLevelField')
                ->findBy([
                    "theme" => $theme,
                    "level" => $level->getValue()
                ]);

            $listingLevel = new ListingLevelFeatures();

            $listingLevel->name = (string)$level->getName();
            $listingLevel->theme = (string)$level->getTheme();

            $listingLevel->isActive = $level->getActive() == "y";
            $listingLevel->isDefault = $level->getDefaultlevel() == "y";
            $listingLevel->isPopular = $level->getPopular() == "y";

            $listingLevel->level = (int)$level->getValue();
            $listingLevel->imageCount = (int)$level->getImages();
            $listingLevel->freeCategoryCount = (int)$level->getFreeCategory();

            $listingLevel->categoryPrice = (double)$level->getCategoryPrice();
            $listingLevel->price = (double)$level->getPrice();

            /* Setting all the has */
            //$listingLevel->hasCheezburger = true;

            $listingLevel->hasDetail = $level->getDetail() == "y";
            $listingLevel->hasDeal = $level->getHasPromotion() == "y";
            $listingLevel->hasReview = $level->getHasReview() == "y";
            $listingLevel->hasBacklink = $level->getBacklink() == "y";
            $listingLevel->hasClickToCall = $level->getHasCall() == "y";

            $listingLevel->isFeatured = $level->getFeatured() == "y";

            foreach ($fields as $field) {
                switch ($field->getField()) {
                    case "email" :
                        $listingLevel->hasEmail = true;
                        break;
                    case "url" :
                        $listingLevel->hasURL = true;
                        break;
                    case "phone" :
                        $listingLevel->hasPhone = true;
                        break;
                    case "fax" :
                        $listingLevel->hasFax = true;
                        break;
                    case "main_image" :
                        $listingLevel->imageCount++;
                        break;
                    case "video" :
                        $listingLevel->hasVideo = true;
                        break;
                    case "attachment_file" :
                        $listingLevel->hasAdditionalFiles = true;
                        break;
                    case "summary_description" :
                        $listingLevel->hasSummaryDescription = true;
                        break;
                    case "long_description" :
                        $listingLevel->hasLongDescription = true;
                        break;
                    case "hours_of_work" :
                        $listingLevel->hasHoursOfWork = true;
                        break;
                    case "locations" :
                        $listingLevel->hasLocationReference = true;
                        break;
                    case "badges" :
                        $listingLevel->hasBadges = true;
                        break;
                    case "fbpage" :
                        $listingLevel->hasFacebookPage = true;
                        break;
                    case "features" :
                        $listingLevel->hasFeatureInformation = true;
                        break;
                }
            }

            $return[$level->getValue()] = $listingLevel;
        }

        return $return;
    }


}
