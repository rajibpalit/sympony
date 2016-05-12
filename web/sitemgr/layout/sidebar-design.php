<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/layout/sidebar-design.php
	# ----------------------------------------------------------------------------------------------------

?>

    <div class="sidebar sidebar-ext togglepush" id="sidebar" role="navigation">

        <div class="short-sidebar">
            <?php
            /* General Sidebar*/
            include(SM_EDIRECTORY_ROOT."/layout/sidebar-general.php");
            ?>
        </div>
        <div class="second-sidebar">
            <h1><?=system_showText(LANG_SITEMGR_DESIGN_CUSTOM);?></h1>
            <p><?=system_showText(LANG_SITEMGR_DESIGN_CUSTOM_TIP);?></p>
            <div class="navigation nano">
                <div class="list-group nano-content">
                    <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/layout-editor/"?>" class="list-group-item <?=(string_strpos($_SERVER["PHP_SELF"], "/design/layout-editor/") !== false ? "active" : "")?>"><?=system_showText(LANG_SITEMGR_LAYOUT_EDITOR);?></a>
                    <? if (LISTINGTEMPLATE_FEATURE == "on" && CUSTOM_LISTINGTEMPLATE_FEATURE == "on") { ?>
                        <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/listing-types/"?>" class="list-group-item <?=(string_strpos($_SERVER["PHP_SELF"], "/design/listing-types") !== false ? "active" : "")?>"><?=ucwords(system_showText(LANG_SITEMGR_LISTINGTEMPLATE_PLURAL));?></a>
                    <? } ?>
                    <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/site-navigation/"?>" class="list-group-item <?=(string_strpos($_SERVER["PHP_SELF"], "/design/site-navigation") !== false ? "active" : "")?>"><?=system_showText(LANG_SITEMGR_SITE_NAVIGATION);?></a>
                    <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/pages-custom/"?>" class="list-group-item <?=(string_strpos($_SERVER["PHP_SELF"], "/design/pages-custom") !== false ? "active" : "")?>"><?=system_showText(LANG_SITEMGR_PAGES_CUSTOM);?></a>
                    <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/email-editor/"?>" class="list-group-item <?=(string_strpos($_SERVER["PHP_SELF"], "/design/email-editor") !== false ? "active" : "")?>"><?=system_showText(LANG_SITEMGR_EMAIL_EDITOR);?></a>
                    <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/lead-editor/"?>" class="list-group-item <?=(string_strpos($_SERVER["PHP_SELF"], "/design/lead-editor") !== false ? "active" : "")?>"><?=system_showText(LANG_SITEMGR_LEADS_EDITOR);?></a>
                </div>
            </div>
        </div>

    </div>