<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /ed-admin/configuration/sugarcrm/index.php
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
    
    $_GET["type"] = ($_POST["type"] ? $_POST["type"] : $_GET["type"]);
    
    if (SUGARCRM_FEATURE == "off") {
        exit;
    }

    # ----------------------------------------------------------------------------------------------------
    # CODE
    # ----------------------------------------------------------------------------------------------------
    include(INCLUDES_DIR."/code/plugins.php");
    
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
	include(SM_EDIRECTORY_ROOT."/layout/sidebar-configuration.php");

?> 

        <main class="wrapper togglesidebar container-fluid"> 

            <section class="heading">
                <h1><?=system_showText(LANG_SITEMGR_PLUGINS)?></h1>

                <div class="row">
                    <div class="col-sm-4">
                        <img class="img-responsive" src="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/assets/img/plugins/sugarcrm-logo.png">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-7">
                        <h2><?=system_showText(LANG_SITEMGR_SUGAR_WHAT_IS_THIS_QUESTION)?></h2>
                        <p><?=system_showText(LANG_SITEMGR_SUGAR_WHAT_IS_THIS_ANSWER)?></p>
                    </div>
                    <div class="col-sm-5">
                        <h2><?=system_showText(LANG_SITEMGR_SUGAR_HOW_DOES_IT_WORKS_QUESTION)?></h2>
                        <p>
                            <?=system_showText(LANG_SITEMGR_SUGAR_HOW_DOES_IT_WORKS_ANSWER)?>
                        </p>
                    </div>
                </div>
            </section>

            <section>
                <? include(INCLUDES_DIR."/forms/form-plugin-sugar.php"); ?>
            </section>

        </main>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/plugins.php";
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>