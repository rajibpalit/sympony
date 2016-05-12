<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/design/site-navigation/index.php
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
	include(INCLUDES_DIR."/code/navigation.php");
    
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
            <h1><?=system_showText(LANG_SITEMGR_NAVIGATION_EDIT)?></h1>
            <p><?=system_showText(LANG_SITEMGR_NAVIGATION_EXPLANATION)?></p>
             <? if ($errorMessage) { ?>
                <p class="alert alert-warning" id="auxErrorMessage2"><?=$errorMessage?></p>
            <? } elseif ($successMessage == 1) { ?>
                <p class="alert alert-success"><?=system_showText(LANG_SITEMGR_NAVIGATION_SUCCESS);?></p>
            <? } ?>
            <p class="alert alert-warning hidden" id="auxErrorMessage"></p>
        </section>

        <section class="section-form">
                <div class="col-sm-12">
                    <div id="aux_litext" style="display: none;"><?=$aux_LI_code?></div>

                    <form role="form" id="form_navigation" name="form_navigation" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">

                        <input type="hidden" name="domain_id" value="<?=SELECTED_DOMAIN_ID?>">

                        <? include(INCLUDES_DIR."/forms/form-navigation.php"); ?>

                    </form>

                    <form id="reset_navigation" name="reset_navigation" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">
                        <input type="hidden" name="resetNavigation" value="reset" />
                        <input type="hidden" name="area" value="<?=$navigation_area?>" />
                    </form>
                </div>
        </section>

        <section class="row footer-action">
            <div class="container-full">
                <div class="col-xs-6">
                    <a class="btn btn-warning" data-toggle="modal" href="#modal-reset"><?=system_showText(LANG_SITEMGR_RESET_NAVIGATION)?></a>
                </div>
                <div class="col-xs-6 text-right">    			
                    <button type="button" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" onclick="<?=DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "JS_submit();"?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                </div>
            </div>
       </section>

    </main>

    <? include(INCLUDES_DIR."/modals/modal-reset-navigation.php"); ?>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/navigation.php";
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>