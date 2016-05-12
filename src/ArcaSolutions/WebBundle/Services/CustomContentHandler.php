<?php

namespace ArcaSolutions\WebBundle\Services;

use ArcaSolutions\WebBundle\Entity\Content;
use Symfony\Component\DependencyInjection\Container;

class CustomContentHandler
{
    //region Type Constants
    const TYPE_ADD_PROFILE_PAGE = "Add Profile Page";
    const TYPE_ADVERTISE_WITH_US = "Advertise with Us";
    const TYPE_ADVERTISE_WITH_US_BOTTOM = "Advertise with Us Bottom";
    const TYPE_ARTICLE_ADVERTISEMENT = "Article Advertisement";
    const TYPE_ARTICLE_HOME = "Article Home";
    const TYPE_ARTICLE_HOME_BOTTOM = "Article Home Bottom";
    const TYPE_ARTICLE_RESULTS = "Article Results";
    const TYPE_ARTICLE_RESULTS_BOTTOM = "Article Results Bottom";
    const TYPE_ARTICLE_VIEW_ALL_CATEGORIES = "Article View All Categories";
    const TYPE_ARTICLE_VIEW_ALL_CATEGORIES_BOTTOM = "Article View All Categories Bottom";
    const TYPE_BANNER_ADVERTISEMENT = "Banner Advertisement";
    const TYPE_BLOG_HOME = "Blog Home";
    const TYPE_BLOG_HOME_BOTTOM = "Blog Home Bottom";
    const TYPE_BLOG_RESULTS = "Blog Results";
    const TYPE_BLOG_RESULTS_BOTTOM = "Blog Results Bottom";
    const TYPE_BLOG_VIEW_ALL_CATEGORIES = "Blog View All Categories";
    const TYPE_BLOG_VIEW_ALL_CATEGORIES_BOTTOM = "Blog View All Categories Bottom";
    const TYPE_CLASSIFIED_ADVERTISEMENT = "Classified Advertisement";
    const TYPE_CLASSIFIED_CHANGE_LEVEL = "Classified Change Level";
    const TYPE_CLASSIFIED_HOME = "Classified Home";
    const TYPE_CLASSIFIED_HOME_BOTTOM = "Classified Home Bottom";
    const TYPE_CLASSIFIED_RESULTS = "Classified Results";
    const TYPE_CLASSIFIED_RESULTS_BOTTOM = "Classified Results Bottom";
    const TYPE_CLASSIFIED_VIEW_ALL_CATEGORIES = "Classified View All Categories";
    const TYPE_CLASSIFIED_VIEW_ALL_CATEGORIES_BOTTOM = "Classified View All Categories Bottom";
    const TYPE_CLASSIFIED_VIEW_ALL_LOCATIONS = "Classified View All Locations";
    const TYPE_CLASSIFIED_VIEW_ALL_LOCATIONS_BOTTOM = "Classified View All Locations Bottom";
    const TYPE_CONTACT_US = "Contact Us";
    const TYPE_DEAL_HOME = "Deal Home";
    const TYPE_DEAL_HOME_BOTTOM = "Deal Home Bottom";
    const TYPE_DEAL_RESULTS = "Deal Results";
    const TYPE_DEAL_RESULTS_BOTTOM = "Deal Results Bottom";
    const TYPE_DEAL_VIEW_ALL_CATEGORIES = "Deal View All Categories";
    const TYPE_DEAL_VIEW_ALL_CATEGORIES_BOTTOM = "Deal View All Categories Bottom";
    const TYPE_DEAL_VIEW_ALL_LOCATIONS = "Deal View All Locations";
    const TYPE_DEAL_VIEW_ALL_LOCATIONS_BOTTOM = "Deal View All Locations Bottom";
    const TYPE_DIRECTORY_RESULTS = "Directory Results";
    const TYPE_DIRECTORY_RESULTS_BOTTOM = "Directory Results Bottom";
    const TYPE_ERROR_PAGE = "Error Page";
    const TYPE_EVENT_ADVERTISEMENT = "Event Advertisement";
    const TYPE_EVENT_CHANGE_LEVEL = "Event Change Level";
    const TYPE_EVENT_HOME = "Event Home";
    const TYPE_EVENT_HOME_BOTTOM = "Event Home Bottom";
    const TYPE_EVENT_RESULTS = "Event Results";
    const TYPE_EVENT_RESULTS_BOTTOM = "Event Results Bottom";
    const TYPE_EVENT_VIEW_ALL_CATEGORIES = "Event View All Categories";
    const TYPE_EVENT_VIEW_ALL_CATEGORIES_BOTTOM = "Event View All Categories Bottom";
    const TYPE_EVENT_VIEW_ALL_LOCATIONS = "Event View All Locations";
    const TYPE_EVENT_VIEW_ALL_LOCATIONS_BOTTOM = "Event View All Locations Bottom";
    const TYPE_FAQ = "FAQ";
    const TYPE_FOOTER = "Footer";
    const TYPE_HOME_PAGE = "Home Page";
    const TYPE_HOME_PAGE_BOTTOM = "Home Page Bottom";
    const TYPE_LEADS_FORM = "Leads Form";
    const TYPE_LISTING_ADVERTISEMENT = "Listing Advertisement";
    const TYPE_LISTING_CHANGE_LEVEL = "Listing Change Level";
    const TYPE_LISTING_HOME = "Listing Home";
    const TYPE_LISTING_HOME_BOTTOM = "Listing Home Bottom";
    const TYPE_LISTING_RESULTS = "Listing Results";
    const TYPE_LISTING_RESULTS_BOTTOM = "Listing Results Bottom";
    const TYPE_LISTING_VIEW_ALL_CATEGORIES = "Listing View All Categories";
    const TYPE_LISTING_VIEW_ALL_CATEGORIES_BOTTOM = "Listing View All Categories Bottom";
    const TYPE_LISTING_VIEW_ALL_LOCATIONS = "Listing View All Locations";
    const TYPE_LISTING_VIEW_ALL_LOCATIONS_BOTTOM = "Listing View All Locations Bottom";
    const TYPE_MAINTENANCE_PAGE = "Maintenance Page";
    const TYPE_MANAGE_ACCOUNT = "Manage Account";
    const TYPE_MANAGE_ACCOUNT_BOTTOM = "Manage Account Bottom";
    const TYPE_PACKAGES_OFFER = "Packages Offer";
    const TYPE_PRIVACY_POLICY = "Privacy Policy";
    const TYPE_PROFILE_PAGE = "Profile Page";
    const TYPE_PROFILE_PAGE_BOTTOM = "Profile Page Bottom";
    const TYPE_PROFILE_PAGE_LOGIN = "Profile Page Login";
    const TYPE_SITEMAP = "Sitemap";
    const TYPE_SPONSOR_HELP = "Sponsor Help";
    const TYPE_SPONSOR_HELP_BOTTOM = "Sponsor Help Bottom";
    const TYPE_SPONSOR_HOME = "Sponsor Home";
    const TYPE_SPONSOR_HOME_BOTTOM = "Sponsor Home Bottom";
    const TYPE_TERMS_OF_USE = "Terms of Use";
    const TYPE_TRANSACTION = "Transaction";
    const TYPE_TRANSACTION_BOTTOM = "Transaction Bottom";
    //endregion

    //region Section Constants
    const SECTION_ADVERTISE_ARTICLE = "advertise_article";
    const SECTION_ADVERTISE_BANNER = "advertise_banner";
    const SECTION_ADVERTISE_CLASSIFIED = "advertise_classified";
    const SECTION_ADVERTISE_EVENT = "advertise_event";
    const SECTION_ADVERTISE_GENERAL = "advertise_general";
    const SECTION_ADVERTISE_LISTING = "advertise_listing";
    const SECTION_ARTICLE = "article";
    const SECTION_BLOG = "blog";
    const SECTION_CLASSIFIED = "classified";
    const SECTION_CLIENT = "client";
    const SECTION_DEAL = "deal";
    const SECTION_EVENT = "event";
    const SECTION_GENERAL = "general";
    const SECTION_LISTING = "listing";
    const SECTION_MEMBER = "member";
    //endregion

    /**
     * @var Container
     */
    private $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Retrieves the value of the custom text with the $name id
     * @param $type
     * @param bool $entity
     * @return null|string|Content
     */
    public function get($type, $entity = false)
    {
        $return = null;
        try {
            if ($content = $this->container->get('doctrine')->getRepository("WebBundle:Content")->findOneBy(["type" => $type])) {
                $return = $entity ? $content : $content->getContent();
            }
        } catch (\Exception $e) {
            $this->container->get('logger')->addWarning("Failed to retrieve custom content. Type = {$type}", ["Exception" => $e]);
        }

        return $return;
    }

    /**
     * Adds or updates a Content entry
     * @param $type
     * @param $content
     * @param $description
     * @param $keywords
     * @param $title
     * @param $url
     * @param $section
     * @param $siteMap
     */
    public function add($type, $content, $description, $title, $keywords = "", $url = "", $section = self::SECTION_GENERAL, $siteMap = true)
    {
        $customContent = $this->get($type, true);

        if (!$customContent) {
            $customContent = new Content();
        }

        $customContent->setUpdated(new \DateTime());
        $content and $customContent->setContent($content);
        $description and $customContent->setDescription($description);
        $keywords and $customContent->setKeywords($keywords);
        $section and $customContent->setSection($section);
        $siteMap and $customContent->setSiteMap($siteMap);
        $title and $customContent->setTitle($title);
        $url and $customContent->setUrl($url);

        $em = $this->container->get("doctrine")->getManager();
        $em->persist($customContent);
        $em->flush();
    }
}
