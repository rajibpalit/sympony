<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/mobile/adverts/index.php
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

	$url_redirect = "".DEFAULT_URL."/".SITEMGR_ALIAS."/mobile/adverts";
	$url_base = "".DEFAULT_URL."/".SITEMGR_ALIAS."";
	$sitemgr = 1;

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	extract($_GET);
	extract($_POST);

    //Submit - delete
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Delete advert
        if ($action == "delete") {
            $advObj = new AppAdvert($_POST['id']);
            $advObj->Delete();
            header("Location: $url_redirect/index.php?message=3&screen=$screen&letter=$letter".(($url_search_params) ? "&$url_search_params" : "" )."");
            exit;
        }
    }
	
	// Page Browsing /////////////////////////////////////////
	unset($pageObj);

	$pageObj  = new pageBrowsing("AppAdvert", $screen, false, ($_GET["newest"] ? "id DESC, entered" : "entered desc"), "title", $letter, false);
	$adverts = $pageObj->retrievePage();
	$paging_url = DEFAULT_URL."/".SITEMGR_ALIAS."/mobile/adverts/index.php";
    
    $statusObj = new ItemStatus();

	# PAGES DROP DOWN ----------------------------------------------------------------------------------------------
	$pagesDropDown = $pageObj->getPagesDropDown($_GET, $paging_url, $screen, system_showText(LANG_SITEMGR_PAGING_GOTOPAGE)." ", "this.form.submit();");
	# --------------------------------------------------------------------------------------------------------------

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
	include(SM_EDIRECTORY_ROOT."/layout/sidebar-mobile.php");

?> 

    <main class="wrapper togglesidebar container-fluid">        

         <section class="heading">
            <div class="container">
                <h1><?=system_showText(LANG_SITEMGR_MOBILE_ADVERTS);?></h1>
                <p><?=system_showText(LANG_SITEMGR_MOBILE_ADVERT_TIP1)?></p>
                
                <? if (is_numeric($message) && isset($msg_appAdvert[$message])) { ?>
                    <p class="alert alert-success"><?=$msg_appAdvert[$message]?></p>
                <? } ?>
            </div>

        </section>

        <section class="row form-thumbnails">

            <div class="container row">
        
                <? if (is_array($adverts)) foreach($adverts as $advert) { $id = $advert->getNumber("id"); ?>

                <div class="col-md-2 col-xs-6">

                    <div class="thumbnail">
                        <div class="caption">
                            <h5 class="overflow"><?=$advert->getString("title", true, 40);?></h5>
                            <p><?=$statusObj->getStatusWithStyle($advert->getString("status"));?></p>
                            <p><?=system_showText(LANG_SITEMGR_MOBILE_EXPIRY);?>: <span title="<?=format_date($advert->getString("expiration_date"))?>" style="cursor:default"><?=format_date($advert->getString("expiration_date"));?></span></p>
                            <a class="btn btn-primary btn-xs" href="<?=$url_redirect?>/advert.php?id=<?=$id?>&screen=<?=$screen?>&letter=<?=$letter?><?=(($url_search_params) ? "&$url_search_params" : "")?>"><?=(system_showText(LANG_SITEMGR_EDIT))?></a>
                            <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-delete" href="#" onclick="$('#delete-id').val(<?=$id?>)" title="<?=system_showText(LANG_SITEMGR_REMOVE);?>"><?=system_showText(LANG_SITEMGR_REMOVE);?></a>
                        </div>
                    </div>

                </div>
                <? } ?>

                <div class="col-md-2 col-xs-6">
                    <a class="thumbnail add-new" href="<?=$url_redirect."/advert.php"?>">
                        <i class="icon-cross8"></i>
                        <div class="caption">
                            <h6><?=system_showText(LANG_SITEMGR_MOBILE_ADVERT_ADD)?></h6>
                        </div>
                    </a>
                </div>

            </div>
        </section>



    </main>

    <? include(INCLUDES_DIR."/modals/modal-delete.php"); ?>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>