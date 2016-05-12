<?php

namespace ArcaSolutions\WebBundle\Twig\Extension;

use ArcaSolutions\WebBundle\Entity\Content;
use ArcaSolutions\WebBundle\Services\CustomContentHandler;
use Symfony\Component\DependencyInjection\Container;

class CustomContentExtension extends \Twig_Extension
{
    /**
     * @var Content[]
     */
    protected $cache;
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     *{@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'customContent',
                [$this, 'getCustomContent'],
                ['is_safe' => ['all']]
            ),
//            new \Twig_SimpleFunction(
//                'customContentAddProfilePage',
//                [$this, 'getCustomContentAddProfilePage'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentAdvertisewithUs',
//                [$this, 'getCustomContentAdvertisewithUs'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentAdvertisewithUsBottom',
//                [$this, 'getCustomContentAdvertisewithUsBottom'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentArticleAdvertisement',
//                [$this, 'getCustomContentArticleAdvertisement'],
//                ['is_safe' => ['all']]
//            ),
            new \Twig_SimpleFunction(
                'customContentArticleHome',
                [$this, 'getCustomContentArticleHome'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentArticleHomeBottom',
                [$this, 'getCustomContentArticleHomeBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentArticleResults',
                [$this, 'getCustomContentArticleResults'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentArticleResultsBottom',
                [$this, 'getCustomContentArticleResultsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentArticleViewAllCategories',
                [$this, 'getCustomContentArticleViewAllCategories'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentArticleViewAllCategoriesBottom',
                [$this, 'getCustomContentArticleViewAllCategoriesBottom'],
                ['is_safe' => ['all']]
            ),
//            new \Twig_SimpleFunction(
//                'customContentBannerAdvertisement',
//                [$this, 'getCustomContentBannerAdvertisement'],
//                ['is_safe' => ['all']]
//            ),
            new \Twig_SimpleFunction(
                'customContentBlogHome',
                [$this, 'getCustomContentBlogHome'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentBlogHomeBottom',
                [$this, 'getCustomContentBlogHomeBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentBlogResults',
                [$this, 'getCustomContentBlogResults'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentBlogResultsBottom',
                [$this, 'getCustomContentBlogResultsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentBlogViewAllCategories',
                [$this, 'getCustomContentBlogViewAllCategories'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentBlogViewAllCategoriesBottom',
                [$this, 'getCustomContentBlogViewAllCategoriesBottom'],
                ['is_safe' => ['all']]
            ),
//            new \Twig_SimpleFunction(
//                'customContentClassifiedAdvertisement',
//                [$this, 'getCustomContentClassifiedAdvertisement'],
//                ['is_safe' => ['all']]
//            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedChangeLevel',
                [$this, 'getCustomContentClassifiedChangeLevel'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedHome',
                [$this, 'getCustomContentClassifiedHome'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedHomeBottom',
                [$this, 'getCustomContentClassifiedHomeBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedResults',
                [$this, 'getCustomContentClassifiedResults'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedResultsBottom',
                [$this, 'getCustomContentClassifiedResultsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedViewAllCategories',
                [$this, 'getCustomContentClassifiedViewAllCategories'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedViewAllCategoriesBottom',
                [$this, 'getCustomContentClassifiedViewAllCategoriesBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedViewAllLocations',
                [$this, 'getCustomContentClassifiedViewAllLocations'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentClassifiedViewAllLocationsBottom',
                [$this, 'getCustomContentClassifiedViewAllLocationsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentContactUs',
                [$this, 'getCustomContentContactUs'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealHome',
                [$this, 'getCustomContentDealHome'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealHomeBottom',
                [$this, 'getCustomContentDealHomeBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealResults',
                [$this, 'getCustomContentDealResults'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealResultsBottom',
                [$this, 'getCustomContentDealResultsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealViewAllCategories',
                [$this, 'getCustomContentDealViewAllCategories'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealViewAllCategoriesBottom',
                [$this, 'getCustomContentDealViewAllCategoriesBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealViewAllLocations',
                [$this, 'getCustomContentDealViewAllLocations'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDealViewAllLocationsBottom',
                [$this, 'getCustomContentDealViewAllLocationsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDirectoryResults',
                [$this, 'getCustomContentDirectoryResults'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentDirectoryResultsBottom',
                [$this, 'getCustomContentDirectoryResultsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentErrorPage',
                [$this, 'getCustomContentErrorPage'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventAdvertisement',
                [$this, 'getCustomContentEventAdvertisement'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventChangeLevel',
                [$this, 'getCustomContentEventChangeLevel'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventHome',
                [$this, 'getCustomContentEventHome'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventHomeBottom',
                [$this, 'getCustomContentEventHomeBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventResults',
                [$this, 'getCustomContentEventResults'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventResultsBottom',
                [$this, 'getCustomContentEventResultsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventViewAllCategories',
                [$this, 'getCustomContentEventViewAllCategories'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventViewAllCategoriesBottom',
                [$this, 'getCustomContentEventViewAllCategoriesBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventViewAllLocations',
                [$this, 'getCustomContentEventViewAllLocations'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentEventViewAllLocationsBottom',
                [$this, 'getCustomContentEventViewAllLocationsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentFAQ',
                [$this, 'getCustomContentFAQ'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentFooter',
                [$this, 'getCustomContentFooter'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentHomePage',
                [$this, 'getCustomContentHomePage'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentHomePageBottom',
                [$this, 'getCustomContentHomePageBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentLeadsForm',
                [$this, 'getCustomContentLeadsForm'],
                ['is_safe' => ['all']]
            ),
//            new \Twig_SimpleFunction(
//                'customContentListingAdvertisement',
//                [$this, 'getCustomContentListingAdvertisement'],
//                ['is_safe' => ['all']]
//            ),
            new \Twig_SimpleFunction(
                'customContentListingChangeLevel',
                [$this, 'getCustomContentListingChangeLevel'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingHome',
                [$this, 'getCustomContentListingHome'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingHomeBottom',
                [$this, 'getCustomContentListingHomeBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingResults',
                [$this, 'getCustomContentListingResults'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingResultsBottom',
                [$this, 'getCustomContentListingResultsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingViewAllCategories',
                [$this, 'getCustomContentListingViewAllCategories'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingViewAllCategoriesBottom',
                [$this, 'getCustomContentListingViewAllCategoriesBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingViewAllLocations',
                [$this, 'getCustomContentListingViewAllLocations'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentListingViewAllLocationsBottom',
                [$this, 'getCustomContentListingViewAllLocationsBottom'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentMaintenancePage',
                [$this, 'getCustomContentMaintenancePage'],
                ['is_safe' => ['all']]
            ),
//            new \Twig_SimpleFunction(
//                'customContentManageAccount',
//                [$this, 'getCustomContentManageAccount'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentManageAccountBottom',
//                [$this, 'getCustomContentManageAccountBottom'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentPackagesOffer',
//                [$this, 'getCustomContentPackagesOffer'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentPrivacyPolicy',
//                [$this, 'getCustomContentPrivacyPolicy'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentProfilePage',
//                [$this, 'getCustomContentProfilePage'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentProfilePageBottom',
//                [$this, 'getCustomContentProfilePageBottom'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentProfilePageLogin',
//                [$this, 'getCustomContentProfilePageLogin'],
//                ['is_safe' => ['all']]
//            ),
            new \Twig_SimpleFunction(
                'getResultsCustomContent',
                [$this, 'getResultsCustomContent'],
                ['is_safe' => ['all']]
            ),
            new \Twig_SimpleFunction(
                'customContentSitemap',
                [$this, 'getCustomContentSitemap'],
                ['is_safe' => ['all']]
            ),
//            new \Twig_SimpleFunction(
//                'customContentSponsorHelp',
//                [$this, 'getCustomContentSponsorHelp'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentSponsorHelpBottom',
//                [$this, 'getCustomContentSponsorHelpBottom'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentSponsorHome',
//                [$this, 'getCustomContentSponsorHome'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentSponsorHomeBottom',
//                [$this, 'getCustomContentSponsorHomeBottom'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentTermsOfUse',
//                [$this, 'getCustomContentTermsOfUse'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentTransaction',
//                [$this, 'getCustomContentTransaction'],
//                ['is_safe' => ['all']]
//            ),
//            new \Twig_SimpleFunction(
//                'customContentTransactionBottom',
//                [$this, 'getCustomContentTransactionBottom'],
//                ['is_safe' => ['all']]
//            ),
        ];
    }

    /**
     * @param string $type
     * @param bool $object
     * @return Content
     */
    public function getCustomContent($type, $object = false)
    {
        $return = null;

        if (empty($this->cache[$type])) {
            $this->cache[$type] = $this->container->get("customcontenthandler")->get($type, true);
        }

        if ($this->cache[$type]) {
            $return = $object ? $this->cache[$type] : $this->cache[$type]->getContent();
        }

        return $return;
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentAddProfilePage($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ADD_PROFILE_PAGE, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentAdvertisewithUs($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ADVERTISE_WITH_US, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentAdvertisewithUsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ADVERTISE_WITH_US_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentArticleAdvertisement($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ARTICLE_ADVERTISEMENT, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentArticleHome($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ARTICLE_HOME, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentArticleHomeBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ARTICLE_HOME_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentArticleResults($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ARTICLE_RESULTS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentArticleResultsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ARTICLE_RESULTS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentArticleViewAllCategories($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ARTICLE_VIEW_ALL_CATEGORIES, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentArticleViewAllCategoriesBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ARTICLE_VIEW_ALL_CATEGORIES_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentBannerAdvertisement($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_BANNER_ADVERTISEMENT, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentBlogHome($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_BLOG_HOME, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentBlogHomeBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_BLOG_HOME_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentBlogResults($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_BLOG_RESULTS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentBlogResultsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_BLOG_RESULTS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentBlogViewAllCategories($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_BLOG_VIEW_ALL_CATEGORIES, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentBlogViewAllCategoriesBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_BLOG_VIEW_ALL_CATEGORIES_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedAdvertisement($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_ADVERTISEMENT, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedChangeLevel($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_CHANGE_LEVEL, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedHome($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_HOME, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedHomeBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_HOME_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedResults($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_RESULTS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedResultsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_RESULTS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedViewAllCategories($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_VIEW_ALL_CATEGORIES, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedViewAllCategoriesBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_VIEW_ALL_CATEGORIES_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedViewAllLocations($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_VIEW_ALL_LOCATIONS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentClassifiedViewAllLocationsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CLASSIFIED_VIEW_ALL_LOCATIONS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentContactUs($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_CONTACT_US, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealHome($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_HOME, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealHomeBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_HOME_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealResults($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_RESULTS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealResultsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_RESULTS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealViewAllCategories($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_VIEW_ALL_CATEGORIES, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealViewAllCategoriesBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_VIEW_ALL_CATEGORIES_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealViewAllLocations($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_VIEW_ALL_LOCATIONS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDealViewAllLocationsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DEAL_VIEW_ALL_LOCATIONS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDirectoryResults($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DIRECTORY_RESULTS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentDirectoryResultsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_DIRECTORY_RESULTS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentErrorPage($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_ERROR_PAGE, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventAdvertisement($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_ADVERTISEMENT, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventChangeLevel($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_CHANGE_LEVEL, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventHome($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_HOME, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventHomeBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_HOME_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventResults($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_RESULTS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventResultsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_RESULTS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventViewAllCategories($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_VIEW_ALL_CATEGORIES, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventViewAllCategoriesBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_VIEW_ALL_CATEGORIES_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventViewAllLocations($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_VIEW_ALL_LOCATIONS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentEventViewAllLocationsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_EVENT_VIEW_ALL_LOCATIONS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentFAQ($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_FAQ, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentFooter($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_FOOTER, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentHomePage($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_HOME_PAGE, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentHomePageBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_HOME_PAGE_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentLeadsForm($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LEADS_FORM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingAdvertisement($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_ADVERTISEMENT, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingChangeLevel($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_CHANGE_LEVEL, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingHome($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_HOME, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingHomeBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_HOME_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingResults($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_RESULTS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingResultsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_RESULTS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingViewAllCategories($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_VIEW_ALL_CATEGORIES, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingViewAllCategoriesBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_VIEW_ALL_CATEGORIES_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingViewAllLocations($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_VIEW_ALL_LOCATIONS, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentListingViewAllLocationsBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_LISTING_VIEW_ALL_LOCATIONS_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentMaintenancePage($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_MAINTENANCE_PAGE, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentManageAccount($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_MANAGE_ACCOUNT, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentManageAccountBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_MANAGE_ACCOUNT_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentPackagesOffer($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_PACKAGES_OFFER, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentPrivacyPolicy($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_PRIVACY_POLICY, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentProfilePage($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_PROFILE_PAGE, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentProfilePageBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_PROFILE_PAGE_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentProfilePageLogin($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_PROFILE_PAGE_LOGIN, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentSitemap($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_SITEMAP, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentSponsorHelp($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_SPONSOR_HELP, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentSponsorHelpBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_SPONSOR_HELP_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentSponsorHome($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_SPONSOR_HOME, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentSponsorHomeBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_SPONSOR_HOME_BOTTOM, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentTermsOfUse($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_TERMS_OF_USE, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentTransaction($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_TRANSACTION, $object);
    }

    /**
     * @param bool|false $object
     * @return \ArcaSolutions\WebBundle\Entity\Content|null|string
     */
    public function getCustomContentTransactionBottom($object = false)
    {
        return $this->getCustomContent(CustomContentHandler::TYPE_TRANSACTION_BOTTOM, $object);
    }

    /**
     * @return array
     */
    public function getResultsCustomContent()
    {
        $module = null;
        $searchEngine = $this->container->get('search.engine');
        $parameterHandler = $this->container->get("search.parameters");

        if ($searchedModules = $parameterHandler->getRouteParameter("module") and count($searchedModules) == 1) {
            $module = array_pop($searchedModules);
        }

        switch ($module) {
            default:
                $top = $this->getCustomContentDirectoryResults();
                $bottom = $this->getCustomContentDirectoryResultsBottom();
                break;
            case $searchEngine->getModuleAlias("article"):
                $top = $this->getCustomContentArticleResults();
                $bottom = $this->getCustomContentArticleResultsBottom();
                break;
            case $searchEngine->getModuleAlias("blog"):
                $top = $this->getCustomContentBlogResults();
                $bottom = $this->getCustomContentBlogResultsBottom();
                break;
            case $searchEngine->getModuleAlias("classified"):
                $top = $this->getCustomContentClassifiedResults();
                $bottom = $this->getCustomContentClassifiedResultsBottom();
                break;
            case $searchEngine->getModuleAlias("deal"):
                $top = $this->getCustomContentDealResults();
                $bottom = $this->getCustomContentDealResultsBottom();
                break;
            case $searchEngine->getModuleAlias("event"):
                $top = $this->getCustomContentEventResults();
                $bottom = $this->getCustomContentEventResultsBottom();
                break;
            case $searchEngine->getModuleAlias("listing"):
                $top = $this->getCustomContentListingResults();
                $bottom = $this->getCustomContentListingResultsBottom();
                break;
        }

        return [
            "top"    => $top,
            "bottom" => $bottom
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'edirectoryCustomContent';
    }
}
