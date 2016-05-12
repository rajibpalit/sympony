<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/content/pages/custom.php
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
	# CODE
	# ----------------------------------------------------------------------------------------------------
	extract($_GET);
	extract($_POST);	

	if (($_SERVER['REQUEST_METHOD'] == "POST") && (!DEMO_LIVE_MODE)) {
		$tmptype = trim($_POST["type"]);
		if ($tmptype) {
			if (!$_REQUEST['id']) $contentObj = new Content();
			else $contentObj = new Content($_REQUEST["id"]);
			$contentObj->setString("type", trim($_POST["type"]));
			if ($_POST["sitemap"]) $contentObj->setNumber("sitemap", 1);
			else $contentObj->setNumber("sitemap", 0);
			
            $description = str_replace('"', '', $_POST["description"]);
            $keywords = str_replace('"', '', $_POST["keywords"]);
            
            $contentObj->setString("title", trim($_POST["title"]));
			$contentObj->setString("description", trim($description));
			$contentObj->setString("keywords", trim($keywords));
			$contentObj->setString("url", trim($_POST["url"]));
			$contentObj->setString("section", "client");
			$contentObj->setString("content", $_POST["content_html"]);
			if (!$contentObj->isRepeated()) {
				if ($contentObj->getString("url")) {
					if (!$contentObj->isRepeatedURL()) {
						$contentObj->Save();
                        $id = $contentObj->getNumber("id");
                        $message = 0;
						header("Location:".DEFAULT_URL."/".SITEMGR_ALIAS."/content/pages/custom.php?id=$id&message=$message&message_style=successMessage");
						exit;
					} else {
                        $message = 1;
					}
				} else {
                    $message = 2;
				}
			} else {
                $message = 3;
			}
		} else {
            $message = 4;
		}
		$post_content = $_POST["content_html"];
	}

	if ($_REQUEST['id']) {
		$contentObj = new Content($_REQUEST["id"]);
		$defaultContentObj = new Content($_REQUEST["id"]);
		if (!$defaultContentObj->getNumber("id")) {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/pages/");
			exit;
		}
		if ($defaultContentObj->getString("section") != "client") {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/pages/");
			exit;
		}
		$type = $defaultContentObj->getString("type");
		$sitemap = $defaultContentObj->getString("sitemap");
		$title = $contentObj->getString("title");
		$description = $contentObj->getString("description");
		$keywords = $contentObj->getString("keywords");
		$url = $contentObj->getString("url");
		if ($post_content) $this_content = $post_content;
		else $this_content = $contentObj->getString("content");
	} else {
		$type = "";
		$sitemap = "";
		$description = "";
		$keywords = "";
		$url = "";
		if ($post_content) $this_content = $post_content;
		else $this_content = "";
	}
    
    $domain = new Domain(SELECTED_DOMAIN_ID);
    $urlStr = DEFAULT_URL;
    $newurl = str_replace(DEFAULT_URL, $domain->getString("url").EDIRECTORY_FOLDER, $urlStr);

    $newurl = "http://".$newurl;

	$_GET = format_magicQuotes($_GET);
	extract($_GET);
	$_POST = format_magicQuotes($_POST);
	extract($_POST);

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
	include(SM_EDIRECTORY_ROOT."/layout/sidebar-content.php");

?> 

    <main class="wrapper togglesidebar container-fluid">
        
		<form role="form" name="content" id="content" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">

            <input name="id" type="hidden" value="<?=$_REQUEST['id']?>" />
            <input type="hidden" name="submit_button" id="submit_button" />
            
            <section id="edit-listing" class="row heading">
	           	<div class="container">
	           		<div class="row">
	           			<? include(SM_EDIRECTORY_ROOT."/layout/back-navigation.php"); ?>
	           		</div>
	           		<? if ($id && $defaultContentObj->type) { ?>
	           		<h1><?=string_ucwords(system_showText(LANG_SITEMGR_EDIT))." ".system_showText(LANG_SITEMGR_CUSTOMPAGE)?> <i><?=$defaultContentObj->type?></i></h1>
                    <? } else { ?>
                    <h1><?=string_ucwords(system_showText(LANG_SITEMGR_ADD))." ".system_showText(LANG_SITEMGR_CUSTOMPAGE)?></h1>
                    <? } ?>
                    <? if (is_numeric($message)) { ?>
		                <p class="alert alert-<?=($message ? "warning" : "success")?>">
                            <?=$msg_content[$message]?>
                            <? if($id && $defaultContentObj->type) { ?>
                            <?=system_showText(str_replace("[a]", "<a href=\"".$newurl."/$url.html\" target=\"_blank\">", str_replace("[/a]", "</a>", LANG_SITEMGR_CONTENT_SUCCESS2)));?>
                            <? } ?>
                        </p>
		            <? } ?>
				</div>
            </section>

            <section class="row edit-listing">
                <div class="container">
                    <? include(INCLUDES_DIR."/forms/form-custom-page.php"); ?>
                </div>
            </section>

            <section class="row footer-action">
                <div class="container">
                    <div class="col-xs-12 text-right">
                        <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/content/pages/"?>" class="btn btn-default btn-xs"><?=system_showText(LANG_CANCEL)?></a>
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