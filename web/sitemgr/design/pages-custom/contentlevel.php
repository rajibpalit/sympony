<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/design/pages-custom/contentlevel.php
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
	# CODE
	# ----------------------------------------------------------------------------------------------------
	
	$_section = str_replace('_advertise', '', $section);
	
	if ((!$section) || (!$value)) {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
		exit;
	}
	
	if (($section == "listing" || $section == "listing_advertise")) {
		$levelObj = new ListingLevel();
		$listingLevelValue = $levelObj->getValues();
		if (!in_array($value, $listingLevelValue)) {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
			exit;
		}
	}
	
	if (($section == "event" || $section == "event_advertise") && (EVENT_FEATURE != "on" || CUSTOM_EVENT_FEATURE != "on")) {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
		exit;
	} elseif ($section == "event") {
		$levelObj = new EventLevel();
		$eventLevelValue = $levelObj->getValues();
		if (!in_array($value, $eventLevelValue)) {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
			exit;
		}
	}

	if (($section == "banner" || $section == "banner_advertise") && (BANNER_FEATURE != "on" || CUSTOM_BANNER_FEATURE != "on")) {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
		exit;
	} elseif ($section == "banner" || $section == "banner_advertise") {
		$levelObj = new BannerLevel();
		$bannerLevelValue = $levelObj->getValues();
		if (!in_array($value, $bannerLevelValue)) {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
			exit;
		}
	}

	if (($section == "classified" || $section == "classified_advertise") && (CLASSIFIED_FEATURE != "on" || CUSTOM_CLASSIFIED_FEATURE != "on")) {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
		exit;
	} elseif ($section == "classified") {
		$levelObj = new ClassifiedLevel();
		$classifiedLevelValue = $levelObj->getValues();
		if (!in_array($value, $classifiedLevelValue)) {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
			exit;
		}
	}

	if (($section == "article" || $section == "article_advertise") && (ARTICLE_FEATURE != "on" || CUSTOM_ARTICLE_FEATURE != "on")) {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
		exit;
	} elseif ($section == "article" || $section == "article_advertise") {
		$levelObj = new ArticleLevel();
		$articleLevelValue = $levelObj->getValues();
		if (!in_array($value, $articleLevelValue)) {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/");
			exit;
		}
	}

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if (($_SERVER['REQUEST_METHOD'] == "POST") && (!DEMO_LIVE_MODE)) {

		$contentObj = new Content();
		$contentObj->setString("content", $_POST["content_html"]);
		$contentObj->prepareToSave();
		$dbMain = db_getDBObject(DEFAULT_DB, true);
		$dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);

        $sql = "UPDATE ".string_ucwords($_section)."Level SET content = ".$contentObj->getString("content", false)." WHERE value = '".$value."'";
		$dbObj->query($sql);
		unset($contentObj);

		if ($section == "banner" || $section == "banner_advertise") $message = 6;
		else $message = 7;
		
		header("Location:".DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/contentlevel.php?section=$section&value=$value&message=$message");
		exit;
	}
	# ----------------------------------------------------------------------------------------------------
	# FORM DEFINES
	# ----------------------------------------------------------------------------------------------------
	if ($_section == "listing")     $levelObj = new ListingLevel();
	if ($_section == "event")       $levelObj = new EventLevel();
	if ($_section == "banner")      $levelObj = new BannerLevel();
	if ($_section == "classified")  $levelObj = new ClassifiedLevel();
	if ($_section == "article")     $levelObj = new ArticleLevel();
    
    $contentObj = new Content();                            
    $contentObj->setString("content", $levelObj->getContent($value));
    $content = $contentObj->getString("content", false);
    
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
            
        <?php
        $contentlevelsection = $section;
        $section = $contentlevelsection;
        ?>
        
		<form role="form" name="content" id="content" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">

            <input name="section" type="hidden" value="<?=$section?>" />
            <input name="value" type="hidden" value="<?=$value?>" />
            <input type="hidden" name="submit_button" id="submit_button" />
            
            <section id="edit-listing" class="row heading">
	           	<div class="container">
	           		<h1><?=system_showText(LANG_SITEMGR_EDIT_PAGE);?></h1>
	           		<p><?=string_ucwords(@constant('LANG_SITEMGR_'.string_strtoupper($_section)))." - ".$levelObj->showLevel($value);?></p>
				</div>
            </section>

			<? if (is_numeric($message)) { ?>
                <p class="alert alert-success"><?=$msg_content[$message]?></p>
            <? } ?>

           <section class="row edit-listing">
                <div class="container">
                    <div class="panel panel-form">
                        <div class="panel-heading">
                            <?=system_showText(LANG_SITEMGR_CONTENT)?>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="content_html"><?=system_showText(LANG_LABEL_DESCRIPTION)?></label>
                                <textarea id="content_html" name="content_html" rows="6" class="form-control"><?=strip_tags($content);?></textarea>
                                <p class="help-block small"><?=system_showText(LANG_SITEMGR_SETTINGS_MANAGE_LEVELS_TIP4);?></p>
                            </div>
                        </div>

                    </div>
                </div>
           </section>

           <section class="row footer-action">
           		<div class="container">
	           		<div class="col-xs-12 text-right">
		           		<a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/"?>" class="btn btn-default btn-xs"><?=system_showText(LANG_CANCEL)?></a>
                        <span class="separator"> <?=system_showText(LANG_OR)?> </span>
                        <button type="button" name="Save" value="Save" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" onclick="<?=DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "JS_submit();"?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
					</div>
				</div>
           </section>
            
       </form>

    </main>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	$customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/content.php";
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>