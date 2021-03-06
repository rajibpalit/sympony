<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/mobile/adverts/advert.php
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

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	include(EDIRECTORY_ROOT."/includes/code/mobileadvert.php");

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
     
        <form name="advert" id="advert" role="form" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">

            <section class="row heading">
	           	<div class="container">
	           		<? if ($id) { ?>
	           		<h1><?=string_ucwords(system_showText(LANG_SITEMGR_EDIT))." ".system_showText(LANG_SITEMGR_MOBILE_ADVERT_SING)?> <i><?=$advert->getString("title")?></i></h1>
                    <? } else { ?>
                    <h1><?=string_ucwords(system_showText(LANG_SITEMGR_ADD))." ".system_showText(LANG_SITEMGR_MOBILE_ADVERT_SING)?></h1>
                    <? } ?>
	           		<!-- <p><?=system_showText(LANG_SITEMGR_MOBILE_ADVERT_TIP1)?></p> -->
	           		<p><?=system_showText(LANG_SITEMGR_MOBILE_ADVERT_TIP2)?></p>

	           		<? if ($message_advert) { ?>
		                <div class="alert alert-warning" role="alert">
		                    <p><?=$message_advert?></p>
		                </div>
				    <? } ?>
				</div>
            </section>
			
			

            <section class="section-form row">
	           	<div class="container">
                    <input type="hidden" name="sitemgr" id="sitemgr" value="<?=$sitemgr?>">
                    <input type="hidden" name="id" id="id" value="<?=$id?>">
                    <input type="hidden" name="letter" value="<?=$letter?>">
                    <input type="hidden" name="screen" value="<?=$screen?>">
                    <?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>

	           		<? include(INCLUDES_DIR."/forms/form-mobileadvert.php"); ?>
	           	</div>
           </section>

           <section class="row footer-action">
           		<div class="container">
	           		<div class="col-xs-12 text-right">
		           		<a href="<?=$url_redirect."/index.php"?>" class="btn btn-default"><?=system_showText(LANG_SITEMGR_CANCEL)?></a>
	           			<span class="separator"> <?=system_showText(LANG_OR)?> </span>
						<button type="<?=DEMO_LIVE_MODE ? "button" : "submit"?>" <?=(DEMO_LIVE_MODE ? "onclick=\"livemodeMessage(true, false);\"" : "")?> class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
					</div>
				</div>
           </section>
            
       </form>

    </main>	


<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>