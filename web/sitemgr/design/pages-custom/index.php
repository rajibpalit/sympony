<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/design/pages-custom/index.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	permission_hasSMPerm();

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

    # ----------------------------------------------------------------------------------------------------
	# SUBMIT - FAQ
	# ----------------------------------------------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($del_faq_id) {
            $id = intval($del_faq_id);
            $faqObj = new FAQ($id);
            $faqObj->Delete();
            header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/index.php?messageFaq=1&del");
            exit;
        } else {
			if ($FAQ_post_submit) {

				if ( validate_form("faq", $_POST, $error) ) {

					$faqObj = new FAQ();

					if ($faq_section_front == "on") {
						$faqObj->setString("frontend", "y");
					}
					if ($faq_section_members == "on") {
						$faqObj->setString("member", "y");
					}
					if ($faq_section_sitemgr == "on") {
						$faqObj->setString("sitemgr", "y");
					}

					$faqObj->setString("question", $faq_question);
					$faqObj->setString("answer", $faq_answer);
					$faqObj->Save();
					header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/index.php?stat=0");
					exit;
				} else {
					header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/index.php?stat=".$error);
					exit;
				}

			} else if ($FAQ_edit_submit) {

				$faqObj = new FAQ($faq_id);

				($faq_section_front_edit) ? $faqObj->setString("frontend", "y") : $faqObj->setString("frontend", "n");
				($faq_section_members_edit) ? $faqObj->setString("member", "y") : $faqObj->setString("member", "n");
				($faq_section_sitemgr_edit) ? $faqObj->setString("sitemgr", "y") : $faqObj->setString("sitemgr", "n");

				$faqObj->setString("question", $faq_question_edit);
				$faqObj->setString("answer", $faq_answer_edit);
				$faqObj->Save();
                header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/index.php?messageFaq=1");
                exit;

			}
		}
	} else {
		$error = false;
		if ($_GET["stat"] == "0") {
			$messageFaq = system_showText(LANG_SITEMGR_SETTINGS_MSG_SAVE_SUCCESS);
		} else {
			if ($_GET["stat"] == "1") {
                $error = true;
                $messageFaq = "&#149;&nbsp;".system_showText(LANG_SITEMGR_SETTINGS_MSGERROR_QUESTION);
            }
			if ($_GET["stat"] == "2") {
                $error = true;
                $messageFaq = "&#149;&nbsp;".system_showText(LANG_SITEMGR_SETTINGS_MSGERROR_ANSWER);
            }
		}
	}
    
	# ----------------------------------------------------------------------------------------------------
	# GENERAL PAGES
	# ----------------------------------------------------------------------------------------------------
	$arrayContents[0]["type"] = "General";
	$arrayContents[0]["menu"] = LANG_SITEMGR_MENU_GENERAL;
	$arrayContents[0]["title"] = LANG_SITEMGR_LABEL_GENERALPAGES;
    $whereContentGeneral = "section IN ('general', 'faq')";
    $blockedContentGeneral = unserialize(SITECONTENT_BLOCKED);
    $blockedContentGeneral = array_map("db_formatString", $blockedContentGeneral);
    if (count($blockedContentGeneral) > 0) {
        $whereContentGeneral .= " AND type NOT IN (" . implode(",", $blockedContentGeneral) . ")";
    }

	// PAGE BROWSING
	$pageObjGeneral  = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentGeneral);
	$contentsGeneral = $pageObjGeneral->retrievePage();

	# ----------------------------------------------------------------------------------------------------
	# Listing PAGES
	# ----------------------------------------------------------------------------------------------------
  	$arrayContents[1]["type"] = "Listing";
    $arrayContents[1]["menu"] = LANG_SITEMGR_LISTING;
	$arrayContents[1]["title"] = LANG_SITEMGR_LABEL_LISTINGPAGES;
    $whereContentListing = "section = 'listing'";
    $blockedContentListing = unserialize(SITECONTENT_BLOCKED);
    $blockedContentListing = array_map("db_formatString", $blockedContentListing);
    if (count($blockedContentListing) > 0) {
        $whereContentListing .= " AND type NOT IN (" . implode(",", $blockedContentListing) . ")";
    }

	# PAGE BROWSING
	$pageObjListing = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentListing);
	$contentsListing = $pageObjListing->retrievePage();

	# ----------------------------------------------------------------------------------------------------
	# DEAL PAGES
	# ----------------------------------------------------------------------------------------------------
  	if (PROMOTION_FEATURE == "on" && CUSTOM_HAS_PROMOTION == "on") {
        $arrayContents[2]["type"] = "Deal";
        $arrayContents[2]["menu"] = LANG_SITEMGR_PROMOTION;
        $arrayContents[2]["title"] = LANG_SITEMGR_LABEL_PROMOTIONPAGES;
        $countContent = 3;
        $whereContentDeal  = "section = 'deal'";
        $blockedContentDeal  = unserialize(SITECONTENT_BLOCKED);
        $blockedContentDeal  = array_map("db_formatString", $blockedContentDeal);
        if (count($blockedContentDeal) > 0) {
            $whereContentDeal .= " AND type NOT IN (" . implode(",", $blockedContentDeal) . ")";
        }

        # PAGE BROWSING
        $pageObjDeal  = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentDeal);
        $contentsDeal = $pageObjDeal->retrievePage();
    }

	# ----------------------------------------------------------------------------------------------------
	# EVENT PAGES
	# ----------------------------------------------------------------------------------------------------
 	if (EVENT_FEATURE == "on") {
        $arrayContents[$countContent]["type"] = "Event";
        $arrayContents[$countContent]["menu"] = LANG_SITEMGR_EVENT;
        $arrayContents[$countContent]["title"] = LANG_SITEMGR_LABEL_EVENTPAGES;
        $countContent++;
        $whereContentEvent = "section = 'event'";
        $blockedContentEvent = unserialize(SITECONTENT_BLOCKED);
        $blockedContentEvent = array_map("db_formatString", $blockedContentEvent);
        if (count($blockedContentEvent) > 0) {
            $whereContentEvent .= " AND type NOT IN (" . implode(",", $blockedContentEvent) . ")";
        }

        # PAGE BROWSING
        $pageObjEvent = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentEvent);
        $contentsEvent = $pageObjEvent->retrievePage();
    }

	# ----------------------------------------------------------------------------------------------------
	# CLASSIFIED PAGES
	# ----------------------------------------------------------------------------------------------------
 	if (CLASSIFIED_FEATURE == "on") {
        $arrayContents[$countContent]["type"] = "Classified";
        $arrayContents[$countContent]["menu"] = LANG_SITEMGR_CLASSIFIED;
        $arrayContents[$countContent]["title"] = LANG_SITEMGR_LABEL_CLASSIFIEDPAGES;
        $countContent++;
        $whereContentClassified = "section = 'classified'";
        $blockedContentClassified = unserialize(SITECONTENT_BLOCKED);
        $blockedContentClassified = array_map("db_formatString", $blockedContentClassified);
        if (count($blockedContentClassified) > 0) {
            $whereContentClassified .= " AND type NOT IN (" . implode(",", $blockedContentClassified) . ")";
        }

        # PAGE BROWSING
        $pageObjClassified  = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentClassified);
        $contentsClassified= $pageObjClassified->retrievePage();
    }

	# ----------------------------------------------------------------------------------------------------
	# ARTICLE PAGES
	# ----------------------------------------------------------------------------------------------------
    if (ARTICLE_FEATURE == "on") {
        $arrayContents[$countContent]["type"] = "Article";
        $arrayContents[$countContent]["menu"] = LANG_SITEMGR_ARTICLE;
        $arrayContents[$countContent]["title"] = LANG_SITEMGR_LABEL_ARTICLEPAGES;
        $countContent++;
        $whereContentArticle = "section = 'article'";
        $blockedContentArticle = unserialize(SITECONTENT_BLOCKED);
        $blockedContentArticle = array_map("db_formatString", $blockedContentArticle);
        if (count($blockedContentArticle) > 0) {
            $whereContentArticle .= " AND type NOT IN (" . implode(",", $blockedContentArticle) . ")";
        }

        # PAGE BROWSING
        $pageObjArticle  = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentArticle);
        $contentsArticle = $pageObjArticle->retrievePage();
    }

	# ----------------------------------------------------------------------------------------------------
	# BLOG PAGES
	# ----------------------------------------------------------------------------------------------------
    if (BLOG_FEATURE == "on") {
        $arrayContents[$countContent]["type"] = "Blog";
        $arrayContents[$countContent]["menu"] = LANG_SITEMGR_BLOG;
        $arrayContents[$countContent]["title"] = LANG_SITEMGR_LABEL_BLOGPAGES;
        $countContent++;
        $whereContentBlog = "section = 'blog'";
        $blockedContentBlog = unserialize(SITECONTENT_BLOCKED);
        $blockedContentBlog= array_map("db_formatString", $blockedContentBlog);
        if (count($blockedContentBlog) > 0) {
            $whereContentBlog .= " AND type NOT IN (" . implode(",", $blockedContentBlog) . ")";
        }

        # PAGE BROWSING
        $pageObjBlog  = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentBlog);
        $contentsBlog = $pageObjBlog->retrievePage();
    }

	# ----------------------------------------------------------------------------------------------------
	# SPONSOR PAGES
	# ----------------------------------------------------------------------------------------------------
    $arrayContents[$countContent]["type"] = "Sponsor";
    $arrayContents[$countContent]["menu"] = LANG_SITEMGR_MEMBER;
    $arrayContents[$countContent]["title"] = LANG_SITEMGR_LABEL_SPONSORPAGES;
    $countContent++;
	$whereContentSponsor = "section = 'member'";
	if ( PROMOTION_FEATURE != "on" || CUSTOM_PROMOTION_FEATURE != "on" || CUSTOM_HAS_PROMOTION != "on" ) $whereContentSponsor .= " AND `type` NOT LIKE '%deal%' ";
    if ( ARTICLE_FEATURE != "on" || CUSTOM_ARTICLE_FEATURE != "on" ) $whereContentSponsor .= " AND `type` NOT LIKE '%article%' ";
    if ( CLASSIFIED_FEATURE != "on" || CUSTOM_CLASSIFIED_FEATURE != "on" ) $whereContentSponsor .= " AND `type` NOT LIKE '%classified%' ";
    if ( EVENT_FEATURE != "on" || CUSTOM_EVENT_FEATURE != "on" ) $whereContentSponsor .= " AND `type` NOT LIKE '%event%' ";
	# PAGE BROWSING
	$pageObjSponsor  = new pageBrowsing("Content", $screen, false, "id", "id", $letter, $whereContentSponsor);
	$contentsSponsor = $pageObjSponsor->retrievePage();
    
    # ----------------------------------------------------------------------------------------------------
	# ADVERTISEMENT
	# ----------------------------------------------------------------------------------------------------
    $arrayContents[$countContent]["type"] = "Advertisement";
    $arrayContents[$countContent]["menu"] = LANG_SITEMGR_MENU_ADVERTISEMENT;
    $arrayContents[$countContent]["title"] = LANG_SITEMGR_LABEL_ADVERTISEPAGES;
    $countContent++;
    $whereContentAdvertisement = "section = 'advertise_general'";
    $blockedContentAdvertisement = unserialize(SITECONTENT_BLOCKED);
    $blockedContentAdvertisement = array_map("db_formatString", $blockedContentAdvertisement);
    if (count($blockedContentAdvertisement) > 0) {
        $whereContentAdvertisement .= " AND type NOT IN (" . implode(",", $blockedContentAdvertisement) . ")";
    }

    // PAGE BROWSING
    $pageObjAdvertisement  = new pageBrowsing("Content", $screen, 999, "id", "id", $letter, $whereContentAdvertisement);
    $contentsAdvertisement = $pageObjAdvertisement->retrievePage();
    
    # ----------------------------------------------------------------------------------------------------
    # LISTING ADVERTISE
    # ----------------------------------------------------------------------------------------------------
    $pageObjListingAdv  = new pageBrowsing("Content", $screen, 999, "id", "id", $letter, "section = 'advertise_listing'");
    $contentsListingAdv = $pageObjListingAdv->retrievePage();
    $listinglevelObj = new ListingLevel();
    $listinglevelValue = $listinglevelObj->getValues();
    $contentsAdvertisement = array_merge($contentsAdvertisement, $contentsListingAdv);
    $arrayContentLevels[] = "listing";
    
    # ----------------------------------------------------------------------------------------------------
    # EVENT ADVERTISE
    # ----------------------------------------------------------------------------------------------------
    if (EVENT_FEATURE == "on" && CUSTOM_EVENT_FEATURE == "on") {
        $pageObjEventAdv  = new pageBrowsing("Content", $screen, 999, "id", "id", $letter, "section = 'advertise_event'");
        $contentsEventAdv = $pageObjEventAdv->retrievePage();
        $eventlevelObj = new EventLevel();
        $eventlevelValue = $eventlevelObj->getValues();
        $contentsAdvertisement = array_merge($contentsAdvertisement, $contentsEventAdv);
        $arrayContentLevels[] = "event";
    }
    
    # ----------------------------------------------------------------------------------------------------
    # CLASSIFIED ADVERTISE
    # ----------------------------------------------------------------------------------------------------
    if (CLASSIFIED_FEATURE == "on" && CUSTOM_CLASSIFIED_FEATURE == "on") {
        $pageObjClassifiedAdv  = new pageBrowsing("Content", $screen, 999, "id", "id", $letter, "section = 'advertise_classified'");
        $contentsClassifiedAdv = $pageObjClassifiedAdv->retrievePage();
        $classifiedlevelObj = new ClassifiedLevel();
        $classifiedlevelValue = $classifiedlevelObj->getValues();
        $contentsAdvertisement = array_merge($contentsAdvertisement, $contentsClassifiedAdv);
        $arrayContentLevels[] = "classified";
    }
    
    # ----------------------------------------------------------------------------------------------------
    # ARTICLE ADVERTISE
    # ----------------------------------------------------------------------------------------------------
    if (ARTICLE_FEATURE == "on" && CUSTOM_ARTICLE_FEATURE == "on") {
        $pageObjArticleAdv  = new pageBrowsing("Content", $screen, 999, "id", "id", $letter, "section = 'advertise_article'");
        $contentsArticleAdv = $pageObjArticleAdv->retrievePage();
        $articlelevelObj = new ArticleLevel();
        $articlelevelValue = $articlelevelObj->getValues();
        $contentsAdvertisement = array_merge($contentsAdvertisement, $contentsArticleAdv);
        $arrayContentLevels[] = "article";
    }
    
    # ----------------------------------------------------------------------------------------------------
    # BANNER ADVERTISE
    # ----------------------------------------------------------------------------------------------------
    if (BANNER_FEATURE == "on" && CUSTOM_BANNER_FEATURE == "on") {
        $pageObjBannerAdv  = new pageBrowsing("Content", $screen, 999, "id", "id", $letter, "section = 'advertise_banner'");
        $contentsBannerAdv = $pageObjBannerAdv->retrievePage();
        $bannerlevelObj = new BannerLevel();
        $bannerlevelValue = $bannerlevelObj->getValues();
        $contentsAdvertisement = array_merge($contentsAdvertisement, $contentsBannerAdv);
        $arrayContentLevels[] = "banner";
    }
    

    # ----------------------------------------------------------------------------------------------------
    # HELP Content
    # ----------------------------------------------------------------------------------------------------

    $arrayContents[$countContent]["type"] = "Faq";
    $arrayContents[$countContent]["menu"] = LANG_SITEMGR_MENU_FAQ;
    $arrayContents[$countContent]["title"] = LANG_SITEMGR_FREQUENTLYASKEDQUESTIONS;

    # PAGE BROWSING
    $pageObjFaq  = new pageBrowsing("FAQ", $screen, false, "id", "question", $letter, "editable='y'");
    $contentsFaq = $pageObjFaq->retrievePage();

    # ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/header.php");

    # ----------------------------------------------------------------------------------------------------
	# NAVBAR
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/navbar.php");
    
    # ----------------------------------------------------------------------------------------------------
	# SIDEBAR
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/sidebar-design.php");

?> 

    <main class="wrapper togglesidebar container-fluid">

        <section class="heading">
            <h1><?=LANG_SITEMGR_PAGES_CUSTOM?></h1>
            <p><?=LANG_SITEMGR_PAGES_CUSTOM_DESC?></p>
        </section>

        <div class="tab-options">
            <ul role="tablist" class="nav nav-tabs">
                <? foreach ($arrayContents as $k => $Content) { ?>
                <li class="<?=(($k == 0 && !$messageFaq) || ($k == (count($arrayContents) -1) && $messageFaq) ?  "active" : "")?>"><a href="#pages-<?=$Content["type"]?>" data-toggle="tab" role="tab"><?=ucwords($Content["menu"])?></a></li>
                <? } ?>
            </ul>

            <div class="row tab-content">
	   			<? include(INCLUDES_DIR."/tables/table_content.php"); ?>
            </div>
        </div>
    </main>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	$customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/faq.php";
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>