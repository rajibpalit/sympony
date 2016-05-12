<?

	/*==================================================================*\
	######################################################################
	#                                                                    #
	# Copyright 2005 Arca Solutions, Inc. All Rights Reserved.           #
	#                                                                    #
	# This file may not be redistributed in whole or part.               #
	# eDirectory is licensed on a per-domain basis.                      #
	#                                                                    #
	# ---------------- eDirectory IS NOT FREE SOFTWARE ----------------- #
	#                                                                    #
	# http://www.edirectory.com | http://www.edirectory.com/license.html #
	######################################################################
	\*==================================================================*/

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /conf/constants_default.inc.php
	# ----------------------------------------------------------------------------------------------------

    # ----------------------------------------------------------------------------------------------------
	# IMAGE PARAMETERS (keep the ratio)
	# ----------------------------------------------------------------------------------------------------

	# LISTING
    define("IMAGE_LISTING_FULL_WIDTH",          1024); //detail
    define("IMAGE_LISTING_FULL_HEIGHT",         768); //detail
    define("IMAGE_LISTING_THUMB_WIDTH",         400); //summary
    define("IMAGE_LISTING_THUMB_HEIGHT",        300); //summary
    # PROMOTION
    define("IMAGE_PROMOTION_FULL_WIDTH",        1024); //detail
    define("IMAGE_PROMOTION_FULL_HEIGHT",       768); //detail
    define("IMAGE_PROMOTION_THUMB_WIDTH",       400); //summary
    define("IMAGE_PROMOTION_THUMB_HEIGHT",      300); //summary
    # EVENT
    define("IMAGE_EVENT_FULL_WIDTH",            1024); //detail
    define("IMAGE_EVENT_FULL_HEIGHT",           768); //detail
    define("IMAGE_EVENT_THUMB_WIDTH",           400); //summary
    define("IMAGE_EVENT_THUMB_HEIGHT",          300); //summary
    # CLASSIFIED
    define("IMAGE_CLASSIFIED_FULL_WIDTH",       1024); //detail
    define("IMAGE_CLASSIFIED_FULL_HEIGHT",      768); //detail
    define("IMAGE_CLASSIFIED_THUMB_WIDTH",      400); //summary
    define("IMAGE_CLASSIFIED_THUMB_HEIGHT",     300); //summary
    # ARTICLE
    define("IMAGE_ARTICLE_FULL_WIDTH",          1024); //detail
    define("IMAGE_ARTICLE_FULL_HEIGHT",         768); //detail
    define("IMAGE_ARTICLE_THUMB_WIDTH",         400); //summary
    define("IMAGE_ARTICLE_THUMB_HEIGHT",        300); //summary
   # BLOG
    define("IMAGE_BLOG_FULL_WIDTH",             1024); //detail
    define("IMAGE_BLOG_FULL_HEIGHT",            768); //detail
    define("IMAGE_BLOG_THUMB_WIDTH",            400); //summary
    define("IMAGE_BLOG_THUMB_HEIGHT",           300); //summary
    # DESIGNATION
    define("IMAGE_DESIGNATION_WIDTH",           50); //badges
    define("IMAGE_DESIGNATION_HEIGHT",          50); //badges
    # HEADER
    define("IMAGE_HEADER_WIDTH",                180); //header
    define("IMAGE_HEADER_HEIGHT",               90); //header
    # PROFILE
    define("PROFILE_IMAGE_WIDTH",               130); //front pages
    define("PROFILE_IMAGE_HEIGHT",              130); //front pages
    define("PROFILE_MEMBERS_IMAGE_WIDTH",       130); //sponsors/profile pages
    define("PROFILE_MEMBERS_IMAGE_HEIGHT",      130); //sponsors/profile pages
    # PACKAGE
    define("IMAGE_PACKAGE_FULL_WIDTH",          260); //package
    define("IMAGE_PACKAGE_FULL_HEIGHT",         260); //package
    define("IMAGE_PACKAGE_THUMB_WIDTH",         200); //package
    define("IMAGE_PACKAGE_THUMB_HEIGHT",        150); //package
    # SLIDER
    define("IMAGE_SLIDER_WIDTH",                1920); //slider
    define("IMAGE_SLIDER_HEIGHT",               1080); //slider
    # BACKGROUND IMAGE
    define("IMAGE_THEME_BACKGROUND_W",          1920);
    define("IMAGE_THEME_BACKGROUND_H",          580);
    # CATEGORY
    define("IMAGE_CATEGORY_FULL_WIDTH",         640); //category
    define("IMAGE_CATEGORY_FULL_HEIGHT",        480); //category
    define("IMAGE_CATEGORY_THUMB_WIDTH",        400); //category (form category)
    define("IMAGE_CATEGORY_THUMB_HEIGHT",       300); //category (form category)
    # COVER IMAGE
    define("COVER_IMAGE_WIDTH",                 1920);
    define("COVER_IMAGE_HEIGHT",                480);

    # ----------------------------------------------------------------------------------------------------
	# GENERAL SETTINGS
	# ----------------------------------------------------------------------------------------------------
    # SLIDER AVAILABLE FOR SLIDER
	define("TOTAL_SLIDER_ITEMS", 4);

    # MODULES CONFIGURATION
    define("CUSTOM_LISTINGTEMPLATE_FEATURE", "on");

    /*
     * Navigation configuration
     */
    unset($array_navigation);
    $array_navigation["header"][] = array("name" => LANG_MENU_HOME, "url" => "NON_SECURE_URL");
    $array_navigation["footer"][] = array("name" => LANG_MENU_HOME, "url" => "NON_SECURE_URL");

    $array_navigation["header"][] = array("name" => LANG_MENU_LISTING, "url" => "LISTING_DEFAULT_URL");
    $array_navigation["footer"][] = array("name" => LANG_MENU_LISTING, "url" => "LISTING_DEFAULT_URL");

    $array_navigation["header"][] = array("name" => LANG_MENU_EVENT, "url" => "EVENT_DEFAULT_URL", "module" => "EVENT_FEATURE");
    $array_navigation["footer"][] = array("name" => LANG_MENU_EVENT, "url" => "EVENT_DEFAULT_URL", "module" => "EVENT_FEATURE");

    $array_navigation["header"][] = array("name" => LANG_MENU_CLASSIFIED, "url" => "CLASSIFIED_DEFAULT_URL", "module" => "CLASSIFIED_FEATURE");
    $array_navigation["footer"][] = array("name" => LANG_MENU_CLASSIFIED, "url" => "CLASSIFIED_DEFAULT_URL", "module" => "CLASSIFIED_FEATURE");

    $array_navigation["header"][] = array("name" => LANG_MENU_ARTICLE, "url" => "ARTICLE_DEFAULT_URL", "module" => "ARTICLE_FEATURE");
    $array_navigation["footer"][] = array("name" => LANG_MENU_ARTICLE, "url" => "ARTICLE_DEFAULT_URL", "module" => "ARTICLE_FEATURE");

    $array_navigation["header"][] = array("name" => LANG_MENU_PROMOTION, "url" => "PROMOTION_DEFAULT_URL", "module" => "PROMOTION_FEATURE");
    $array_navigation["footer"][] = array("name" => LANG_MENU_PROMOTION, "url" => "PROMOTION_DEFAULT_URL", "module" => "PROMOTION_FEATURE");

    $array_navigation["header"][] = array("name" => LANG_MENU_BLOG, "url" => "BLOG_DEFAULT_URL", "module" => "BLOG_FEATURE");
    $array_navigation["footer"][] = array("name" => LANG_MENU_BLOG, "url" => "BLOG_DEFAULT_URL", "module" => "BLOG_FEATURE");

    $array_navigation["header"][] = array("name" => LANG_MENU_ADVERTISE, "url" => "ALIAS_ADVERTISE_URL_DIVISOR");
    $array_navigation["footer"][] = array("name" => LANG_MENU_ADVERTISE, "url" => "ALIAS_ADVERTISE_URL_DIVISOR");

    $array_navigation["header"][] = array("name" => LANG_MENU_CONTACT, "url" => "ALIAS_CONTACTUS_URL_DIVISOR");
    $array_navigation["footer"][] = array("name" => LANG_MENU_CONTACT, "url" => "ALIAS_CONTACTUS_URL_DIVISOR");

    $array_navigation["header"][] = array("name" => LANG_MENU_ENQUIRE, "url" => "ALIAS_LEAD_URL_DIVISOR");
    $array_navigation["footer"][] = array("name" => LANG_MENU_ENQUIRE, "url" => "ALIAS_LEAD_URL_DIVISOR");

    $array_navigation["footer"][] = array("name" => LANG_MENU_FAQ, "url" => "ALIAS_FAQ_URL_DIVISOR");
    $array_navigation["footer"][] = array("name" => LANG_MENU_SITEMAP, "url" => "ALIAS_SITEMAP_URL_DIVISOR");
    $array_navigation["footer"][] = array("name" => LANG_TERMS_USE, "url" => "ALIAS_TERMS_URL_DIVISOR");
    $array_navigation["footer"][] = array("name" => LANG_PRIVACY_POLICY, "url" => "ALIAS_PRIVACY_URL_DIVISOR");

    define("THEME_NAVIGATION_MENU", serialize($array_navigation));

    /*
     * Site Content Configuration
     */

    //content not available according to column "type"
    $arrayBlockedContent = array();

    define("SITECONTENT_BLOCKED", serialize($arrayBlockedContent));
    unset($arrayBlockedContent);

    //content available only for SEO purposes
    $arraySEOContent = array();

    define("SITECONTENT_FORSEO", serialize($arraySEOContent));
    unset($arraySEOContent);