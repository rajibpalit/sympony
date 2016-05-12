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

	$url_redirect = "".DEFAULT_URL."/".SITEMGR_ALIAS."/mobile/notifications";
	$url_base = "".DEFAULT_URL."/".SITEMGR_ALIAS."";
	$sitemgr = 1;

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	extract($_GET);
	extract($_POST);

    //Submit - delete
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Delete advert
        if ($action == "delete") {
            $notifObj = new AppNotification($_POST["id"]);
            $notifObj->Delete();
            header("Location: $url_redirect/index.php?message=3&screen=$screen&letter=$letter".(($url_search_params) ? "&$url_search_params" : "" )."");
            exit;
        }
    }
	
	// Page Browsing /////////////////////////////////////////
	unset($pageObj);

	$pageObj  = new pageBrowsing("AppNotification", $screen, false, ($_GET["newest"] ? "id DESC, entered" : "status, entered desc"), "title", $letter, false);
	$notifs = $pageObj->retrievePage();
	$paging_url = DEFAULT_URL."/".SITEMGR_ALIAS."/mobile/notifications/index.php";
    
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
                <h1><?=system_showText(LANG_SITEMGR_MOBILE_NOTIFICATION_ADD);?></h1>
                <p><?=system_showText(LANG_SITEMGR_MOBILE_NOTIF_TIP1)?></p>

                <? if (is_numeric($message) && isset($msg_appNotif[$message])) { ?>
                    <p class="alert alert-success"><?=$msg_appNotif[$message]?></p>
                <? } ?>
            </div>

        </section>

        <section class="row form-thumbnails">

            <div class="container row">
        
                <? if (is_array($notifs)) foreach($notifs as $notif) { $id = $notif->getNumber("id"); ?>

                <div class="col-md-2 col-xs-6">

                    <div class="thumbnail">
                        <div class="caption">
                            <h5 class="overflow"> <?=$notif->getString("title", true, 40);?></h5>
                            <p><?=$statusObj->getStatusWithStyle($notif->getString("status"));?></p>
                            <p><?=system_showText(LANG_SITEMGR_MOBILE_EXPIRY);?>: <span title="<?=format_date($notif->getString("expiration_date"))?>" style="cursor:default"><?=format_date($notif->getString("expiration_date"));?></span></p>
                            <a class="btn btn-primary btn-xs" href="<?=$url_redirect?>/notification.php?id=<?=$id?>&screen=<?=$screen?>&letter=<?=$letter?><?=(($url_search_params) ? "&$url_search_params" : "")?>"><?=(system_showText(LANG_SITEMGR_EDIT))?></a>
                            <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-delete" href="#" onclick="$('#delete-id').val(<?=$id?>)" title="<?=system_showText(LANG_SITEMGR_REMOVE);?>"><?=system_showText(LANG_SITEMGR_REMOVE);?></a>
                        </div>
                    </div>

                </div>
                <? } ?>

                <div class="col-md-2 col-xs-6">
                    <a class="thumbnail add-new" href="<?=$url_redirect."/notification.php"?>">
                        <i class="icon-cross8"></i>
                        <div class="caption">
                            <h6><?=system_showText(LANG_SITEMGR_MOBILE_NOTIFICATION_ADD)?></h6>
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