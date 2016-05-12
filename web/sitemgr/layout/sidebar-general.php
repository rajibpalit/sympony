<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/layout/sidebar-general.php
	# ----------------------------------------------------------------------------------------------------

?>
    <div class="main-navigation nano">
        <ul class="nav nav-pills nav-stacked nano-content">
            <li>
                <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/"?>" data-toggle="tooltip" data-placement="bottom" title="<?=system_showText(LANG_SITEMGR_DASHBOARD);?>"><i class="icon-dashboard5"></i></a>
            </li>
            
            <? if (permission_hasSMPermSection(SITEMGR_PERMISSION_CONTENT)) { ?>
            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "/content/") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/content/".LISTING_FEATURE_FOLDER."/"?>" data-toggle="tooltip" data-placement="bottom" title="<?=system_showText(LANG_SITEMGR_CONTENT_MANAGER);?>"><i class="icon-document49"></i></a>
            </li>
            <? } ?>
            
            <? if (permission_hasSMPermSection(SITEMGR_PERMISSION_ACTIVITY)) { ?>
            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "/activity/") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/activity/traffic/"?>" data-toggle="tooltip" data-placement="bottom"  title="<?=system_showText(LANG_SITEMGR_ACTIVITY);?>"><i class="icon-connecting7"></i></a>
            </li>
            <? } ?>
            
            <? if (permission_hasSMPermSection(SITEMGR_PERMISSION_PROMOTE)) { ?>
            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "/promote/") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/promote/helpme/"?>" data-toggle="tooltip" data-placement="bottom" title="<?=system_showText(LANG_SITEMGR_PROMOTE);?>"><i class="icon-uniE601"></i></a>
            </li>
            <? } ?>
            
            <? if (permission_hasSMPermSection(SITEMGR_PERMISSION_DESIGN)) { ?>
            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "/design/") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/layout-editor/"?>" data-toggle="tooltip" data-placement="bottom" title="<?=system_showText(LANG_SITEMGR_DESIGN_CUSTOM);?>"><i class="icon-paint14"></i></a>
            </li>
            <? } ?>
            
            <? if (permission_hasSMPermSection(SITEMGR_PERMISSION_CONFIG)) { ?>
            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "/configuration/") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/configuration/basic-information/"?>" data-toggle="tooltip" data-placement="bottom" title="<?=system_showText(LANG_SITEMGR_CONFIG);?>"><i class="icon-repair6"></i></a>
            </li>
            <? } ?>
            
            <? if (permission_hasSMPermSection(SITEMGR_PERMISSION_MOBILE)) { ?>
            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "/mobile/") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/mobile/appbuilder/"?>" data-toggle="tooltip" data-placement="bottom" title="<?=system_showText(LANG_SITEMGR_MOBILE_APPS);?>"><i class="icon-mobile143"></i></a>
            </li>
            <? } ?>

            <? if (BRANDED_PRINT == "on") { ?>
            <li class="branding-message">
                <a href="http://www.edirectory.com<?=(string_strpos($_SERVER["HTTP_HOST"], ".com.br") !== false ? ".br" : "")?>" target="_blank" data-toggle="tooltip" data-placement="bottom"  title="eDirectory Cloud Serice" >eDirectory</a>
            </li>
            <? } ?>

        </ul>
    </div>
