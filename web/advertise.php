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
    # * FILE: /advertise.php
    # ----------------------------------------------------------------------------------------------------

    # ----------------------------------------------------------------------------------------------------
    # LOAD CONFIG
    # ----------------------------------------------------------------------------------------------------
    include("./conf/loadconfig.inc.php");

    # ----------------------------------------------------------------------------------------------------
    # MAINTENANCE MODE
    # ----------------------------------------------------------------------------------------------------
    verify_maintenanceMode();

    # ----------------------------------------------------------------------------------------------------
    # VALIDATION
    # ----------------------------------------------------------------------------------------------------
    include(EDIRECTORY_ROOT."/includes/code/validate_querystring.php");

    # ----------------------------------------------------------------------------------------------------
    # FORMS DEFINES
    # ----------------------------------------------------------------------------------------------------
    $sitecontentSection = "Advertise with Us";
    setting_get("review_listing_enabled", $review_enabled);
    customtext_get("payment_tax_label", $payment_tax_label);
    setting_get("payment_tax_status", $payment_tax_status);
    setting_get("payment_tax_value", $payment_tax_value);

    unset($activeTab);
    if (isset($_GET["event"]) && EVENT_FEATURE == "on" && CUSTOM_EVENT_FEATURE == "on") $activeTab = "event";
    elseif (isset($_GET["banner"]) && BANNER_FEATURE == "on" && CUSTOM_BANNER_FEATURE == "on") $activeTab = "banner";
    elseif (isset($_GET["classified"]) && CLASSIFIED_FEATURE == "on" && CUSTOM_CLASSIFIED_FEATURE == "on") $activeTab = "classified";
    elseif (isset($_GET["article"]) && ARTICLE_FEATURE == "on" && CUSTOM_ARTICLE_FEATURE == "on") $activeTab = "article";
    elseif (isset($_GET["listing"])) $activeTab = "listing";
    else  $activeTab = "listing";

    $advertiseModules[] = "listing";
    if (EVENT_FEATURE == "on" && CUSTOM_EVENT_FEATURE == "on") {
        $advertiseModules[] = "event";
    }
    if (CLASSIFIED_FEATURE == "on" && CUSTOM_CLASSIFIED_FEATURE == "on") {
        $advertiseModules[] = "classified";
    }
    if (ARTICLE_FEATURE == "on" && CUSTOM_ARTICLE_FEATURE == "on") {
        $advertiseModules[] = "article";
    }
    if (BANNER_FEATURE == "on" && CUSTOM_BANNER_FEATURE == "on") {
        $advertiseModules[] = "banner";
    }

    # ----------------------------------------------------------------------------------------------------
    # SITE CONTENT
    # ----------------------------------------------------------------------------------------------------
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
?>
    <div class="block-container first block-bg-image">

        <? include(EDIRECTORY_ROOT."/frontend/coverimage.php"); ?>

        <div class="container">
            <div class="space-content">
                <?php
                if ($sitecontent) {
                    echo "<div class=\"well well-translucid\">".$sitecontent."</div>";
                }
                ?>
            </div>
        </div>

    </div>

    <main>

        <div class="container well well-light">

            <div id="advertisePlans" class="block">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" <?=$activeTab == "listing" ? "class=\"active\"": "";?>>
                            <a href="#Listings" aria-controls="Listings" role="tab" data-toggle="tab"><?=system_showText(LANG_LISTING_OPTIONS)?></a>
                        </li>

                        <?php if (EVENT_FEATURE == "on" && CUSTOM_EVENT_FEATURE == "on") { ?>
                            <li role="presentation" <?=$activeTab == "event" ? "class=\"active\"": "";?>>
                                <a href="#Events" aria-controls="Events" role="tab" data-toggle="tab"><?=system_showText(LANG_EVENT_OPTIONS)?></a>
                            </li>
                        <?php } ?>

                        <?php if (CLASSIFIED_FEATURE == "on" && CUSTOM_CLASSIFIED_FEATURE == "on") { ?>
                            <li role="presentation" <?=$activeTab == "classified" ? "class=\"active\"": "";?>>
                                <a href="#Classifieds" aria-controls="Classifieds" role="tab" data-toggle="tab"><?=system_showText(LANG_CLASSIFIED_OPTIONS)?></a>
                            </li>
                        <?php } ?>

                        <?php if (ARTICLE_FEATURE == "on" && CUSTOM_ARTICLE_FEATURE == "on") { ?>
                            <li role="presentation" <?=$activeTab == "article" ? "class=\"active\"": "";?>>
                                <a href="#Articles" aria-controls="Articles" role="tab" data-toggle="tab"><?=system_showText(LANG_ARTICLE_OPTIONS)?></a>
                            </li>
                        <?php } ?>

                        <?php if (BANNER_FEATURE == "on" && CUSTOM_BANNER_FEATURE == "on") { ?>
                            <li role="presentation" <?=$activeTab == "banner" ? "class=\"active\"": "";?>>
                                <a href="#Banners" aria-controls="Banners" role="tab" data-toggle="tab"><?=system_showText(LANG_BANNER_OPTIONS)?></a>
                            </li>
                        <?php } ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content plans-content">

                        <?php foreach ($advertiseModules as $signupItem) { ?>

                            <div role="tabpanel" class="tab-pane <?=($activeTab == $signupItem ? "active" : "")?>" id="<?=ucfirst($signupItem)."s"?>">
                                <? include(EDIRECTORY_ROOT."/frontend/advertise_item.php"); ?>
                            </div>

                        <?php } ?>

                    </div>

                </div>
            </div>

            <?php
            $contentObj = new Content();
            $content = $contentObj->retrieveContentByType("Advertise with Us Bottom");
            if ($content) {
                echo "<div class=\"content-custom\">".$content."</div>";
            }
            ?>

        </div>

    </main>

    <? foreach ($previewBanner as $banner_name => $banner_image) { ?>

    <div id="banner-<?=$banner_name?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <?=(LANG_BANNER_PREVIEW)?>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <img class="center-block preview-banner" src="<?=$banner_image?>">
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
        </div>
    </div>

    <? } ?>

<?php
    # ----------------------------------------------------------------------------------------------------
    # FOOTER
    # ----------------------------------------------------------------------------------------------------
    include(EDIRECTORY_ROOT."/frontend/footer.php");