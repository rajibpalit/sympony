<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/design/lead-editor/index.php
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
    include(INCLUDES_DIR."/code/leadeditor.php");
    
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
            <h1><?=system_showText(LANG_SITEMGR_LEADS_EDITOR);?></h1>
            <p><?=system_showText(LANG_SITEMGR_LEADS_TIP1)?></p>
        </section>

        <section class="section-form">
                <div class="col-sm-12">
                    <p><?=system_showText(LANG_SITEMGR_LEADS_TIP2)?></p>
                    <p id="successMessage" class="alert alert-success" style="display:none;"><?=system_showText(LANG_SITEMGR_LEADS_SUCCESS)?></p>
                </div>
                <div class="col-sm-8">
                    <input type="hidden" name="domain_url" id="domain_url" value="<?=$domainURL?>" />
                    <input type="hidden" name="livemode" id="livemode" value="<?=(DEMO_LIVE_MODE ? 1 : 0)?>" />
                    <input type="hidden" name="livemode_msg" id="livemode_msg" value="<?=system_showText(LANG_SITEMGR_THEME_DEMO_MESSAGE2);?>" />
                    <div id="form-builder" class="form-builder"></div>
                </div>
        </section>

    </main>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/lead-editor.php";
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>