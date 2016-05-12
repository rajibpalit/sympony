<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/mobile/appbuilder/navbar.php
	# ----------------------------------------------------------------------------------------------------
	
    for ($i = 1; $i <=6; $i++) {
        setting_get("appbuilder_step_".$i, ${"appbuilder_step_".$i});
    }

    require_once(CLASSES_DIR."/class_AppCustomPage.php");
    $appbuilder_step_5 = AppCustomPage::count();
?>

	<nav class="navicons">

        <ol>

            <li class="<?=($appbuilder_step_1 == "done" ? "checked" : "")?> <?=(string_strpos($_SERVER["PHP_SELF"], "step1.php") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/step1.php"><i class="iab-icon"></i><?=system_showText(LANG_SITEMGR_CHOOSE_ICON);?></a>
            </li>            

            <li class="<?=($appbuilder_step_2 == "done" ? "checked" : "")?> <?=(string_strpos($_SERVER["PHP_SELF"], "step2.php") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/step2.php"><i class="iab-loadingimage"></i><?=system_showText(LANG_SITEMGR_CHOOSE_LOADING_PAGE);?></a>
            </li>

            <li class="<?=($appbuilder_step_3 == "done" ? "checked" : "")?> <?=(string_strpos($_SERVER["PHP_SELF"], "step3.php") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/step3.php"><i class="iab-colors"></i><?=system_showText(LANG_SITEMGR_CONFIGURE_COLORS);?></a>
            </li>

            <li class="<?=($appbuilder_step_4 == "done" ? "checked" : "")?> <?=(string_strpos($_SERVER["PHP_SELF"], "step4.php") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/step4.php"><i class="iab-about"></i><?=system_showText(LANG_SITEMGR_CONFIGURE_ABOUT_PAGE);?></a>
            </li>

            <li class="<?=( $appbuilder_step_5 ? "checked" : "")?> <?=(string_strpos($_SERVER["PHP_SELF"], "step5.php") !== false ? "active" : "")?>">
                <a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/step5.php"><i class="iab-cpages"></i><?=system_showText(LANG_SITEMGR_CUSTOMPAGES);?></a>
            </li>

            <li class="<?=($appbuilder_step_6 == "done" ? "checked" : "")?> <?=(string_strpos($_SERVER["PHP_SELF"], "step6.php") !== false ? "active" : "")?>">
            	<a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/step6.php"><i class="iab-menu"></i><?=system_showText(LANG_SITEMGR_CONFIGURE_MENU);?></a>
            </li>

            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "previewapp.php") !== false ? "active" : "")?>">
            	<a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/previewapp.php"><i class="iab-previewapp"></i><?=system_showText(LANG_SITEMGR_DOWNLOAD_PREVIEWER);?></a>
            </li>

            <li class="<?=(string_strpos($_SERVER["PHP_SELF"], "finalstep.php") !== false ? "active" : "")?>">
            	<a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/mobile/appbuilder/finalstep.php"><i class="iab-build"></i><?=system_showText(LANG_SITEMGR_BUILD_APP);?></a>
            </li>
        </ol>

	</nav>