<?php

    /*==================================================================*\
    ######################################################################
    #                                                                    #
    # Copyright 2015 Arca Solutions, Inc. All Rights Reserved.           #
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
    # * FILE: /profile/add.php
    # ----------------------------------------------------------------------------------------------------

    # ----------------------------------------------------------------------------------------------------
    # LOAD CONFIG
    # ----------------------------------------------------------------------------------------------------

    include("../conf/loadconfig.inc.php");

    if (sess_getAccountIdFromSession()) {
        header("Location: ".DEFAULT_URL."/".SOCIALNETWORK_FEATURE_NAME."/");
        exit;
    }

    # ----------------------------------------------------------------------------------------------------
    # MAINTENANCE MODE
    # ----------------------------------------------------------------------------------------------------
    verify_maintenanceMode();

    # ----------------------------------------------------------------------------------------------------
    # SESSION
    # ----------------------------------------------------------------------------------------------------
    sess_validateSessionFront();

    # ----------------------------------------------------------------------------------------------------
    # VALIDATION
    # ----------------------------------------------------------------------------------------------------
    include(EDIRECTORY_ROOT."/includes/code/validate_querystring.php");

    if (SOCIALNETWORK_FEATURE == "off") { exit; }

    if (sess_isAccountLogged()) {
        header("Location: ".SOCIALNETWORK_URL."/");
        exit;
    }

    # ----------------------------------------------------------------------------------------------------
    # SUBMIT
    # ----------------------------------------------------------------------------------------------------
    include(INCLUDES_DIR."/code/add_account.php");

    # ----------------------------------------------------------------------------------------------------
    # SITE CONTENT
    # ----------------------------------------------------------------------------------------------------
    $sitecontentSection = "Add Profile Page";
    $array_HeaderContent = front_getSiteContent($sitecontentSection);
    extract($array_HeaderContent);

    # ----------------------------------------------------------------------------------------------------
    # HEADER
    # ----------------------------------------------------------------------------------------------------
    $headertag_title = $headertagtitle;
    $headertag_description = $headertagdescription;
    $headertag_keywords = $headertagkeywords;
    include(EDIRECTORY_ROOT."/frontend/header.php");

    # ----------------------------------------------------------------------------------------------------
    # BODY
    # ----------------------------------------------------------------------------------------------------
    include(INCLUDES_DIR."/code/newsletter.php");
    setting_get("foreignaccount_google", $foreignaccount_google);

?>

    <section class="top-search">

        <? include(EDIRECTORY_ROOT."/frontend/coverimage.php"); ?>

        <div class="well well-translucid">
            <div class="container">
                <br>
                <h1><?=system_showText(LANG_JOIN_PROFILE);?></h1>
                <br>
            </div>
        </div>
    </section>

    <main>

        <div class="container well well-light">

            <div class="row">
                <? if ($sitecontent)  { ?>
                <div class="col-md-6 col-sm-12">
                    <div class="custom-content">
                        <?=$sitecontent?>
                        <br>
                        <p class="text-center">
                            <a href="<?=((SSL_ENABLED == "on" && FORCE_MEMBERS_SSL == "on") ? SECURE_URL : NON_SECURE_URL)?>/<?=MEMBERS_ALIAS?>/" class="btn btn-default"><?=system_showText(LANG_GO_TO_SPONSOR_AREA)?></a>
                        </p>
                    </div>
                </div>
                <? } ?>
                <div class="col-md-6 col-sm-12<?=($sitecontent ? "" : " col-md-offset-3")?>">
                    <div class="panel panel-theme">
                        <div class="panel-body">

                            <? if ($foreignaccount_google == "on" || FACEBOOK_APP_ENABLED == "on") {

                                if (FACEBOOK_APP_ENABLED == "on") {
                                    $urlRedirect = "?destiny=".urlencode(DEFAULT_URL."/".SOCIALNETWORK_FEATURE_NAME."/");
                                    include(INCLUDES_DIR."/forms/form_facebooklogin.php");
                                }

                                if ($foreignaccount_google == "on") {
                                    $urlRedirect = "&destiny=".urlencode(DEFAULT_URL."/".SOCIALNETWORK_FEATURE_NAME."/");
                                    include(INCLUDES_DIR."/forms/form_googlelogin.php");
                                } ?>

                                <p><?=system_showText(LANG_OR_SIGNUPEMAIL);?></p>

                            <? } ?>

                            <form role="form" class="form" name="add_account" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">

                                <? include(INCLUDES_DIR."/forms/form_addaccount.php"); ?>

                            </form>
                            <hr>
                            <div class="text-center">
                                <a href="<?=SOCIALNETWORK_URL?>/login.php" class="btn btn-primary"><?=system_showText(LANG_LABEL_ALREADY_MEMBER);?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div>

    </main>

<?

    # ----------------------------------------------------------------------------------------------------
    # FOOTER
    # ----------------------------------------------------------------------------------------------------
    include(EDIRECTORY_ROOT."/frontend/footer.php");