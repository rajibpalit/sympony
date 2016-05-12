<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/mobile/appbuilder/step3.php
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
    extract($_POST);
    extract($_GET);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
        if ($color_scheme == "custom") {
            $color_scheme = $colorApp1."-".$colorApp2;
            
            if (!setting_set("appbuilder_colorscheme_custom", $color_scheme)) {
                if (!setting_new("appbuilder_colorscheme_custom", $color_scheme)) {
                    $error = true;
                }
            }
        }
        
        if (!setting_set("appbuilder_colorscheme", $color_scheme)) {
            if (!setting_new("appbuilder_colorscheme", $color_scheme)) {
                $error = true;
            }
        }

        if ( $next == "yes")
        {
            /* User has done step 3 successfully */
            setting_set("appbuilder_step_3", "done") or setting_new("appbuilder_step_3", "done");
        }

        header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/mobile/appbuilder/".($next == "yes" ? "step4.php" : "step3.php?success=1"));
        exit;
    }
    
    extract($_POST);
    extract($_GET);
    
    //Theme colors
    if (!DEMO_LIVE_MODE) {
        $arrayCurValues = unserialize(EDIR_CURR_SCHEME_VALUES);
    } else {
        $arrayDefault = unserialize(ARRAY_DEFAULT_COLORS);
        $arrayCurValues = $arrayDefault[EDIR_THEME];
    }

    $arrayColorsApp[] = $arrayCurValues[EDIR_SCHEME]["color1"]."-".$arrayCurValues[EDIR_SCHEME]["color2"];
    $arrayColorsApp[0] .= "-".system_showText(LANG_SITEMGR_BUILDER_DIRCOLORS);
    $arrayColorsApp[] = "059e9a-f1812d-Contrast";
    $arrayColorsApp[] = "2c3e50-c0392b-Super Contrast";
    $arrayColorsApp[] = "d35400-3498db-Sand & Sea";
    $arrayColorsApp[] = "3498db-63696a-Concrete";
    $arrayColorsApp[] = "8c3ab2-bb7cda-Extroverted";
    $arrayColorsApp[] = "16a085-1abc9c-Enviromentally Friendly";
    $arrayColorsApp[] = "c0392b-34495e-Gothica";
    $arrayColorsApp[] = "e67e22-27ae60-Eat your Veg";
    $arrayColorsApp[] = "aaaaaa-da5138-Red Monochrome";

    setting_get("appbuilder_colorscheme", $appbuilder_colorscheme);
    setting_get("appbuilder_colorscheme_custom", $appbuilder_colorscheme_custom);

    if (!$appbuilder_colorscheme) {
        $appbuilder_colorscheme = $arrayCurValues[EDIR_SCHEME]["color1"]."-".$arrayCurValues[EDIR_SCHEME]["color2"];
    }

    if ($appbuilder_colorscheme_custom) {
        $colorCustom = explode("-", $appbuilder_colorscheme_custom);
    } else {
        $colorCustom = explode("-", $arrayCurValues[EDIR_SCHEME]["color1"]."-".$arrayCurValues[EDIR_SCHEME]["color2"]);
    }
    
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

        <section class="row heading">
            <div class="container">
                <h1><?=system_showText(LANG_SITEMGR_APPBUILDER);?></h1>
                <p><?=system_showText(LANG_SITEMGR_BUILDER_COLORS);?></p>
            </div>
        </section>
        
        <section class="row appbuilder">
            
            <div class="appbuilder-container">
            
                <?
                require(EDIRECTORY_ROOT."/".SITEMGR_ALIAS."/registration.php");
                require(EDIRECTORY_ROOT."/includes/code/checkregistration.php");
                require(EDIRECTORY_ROOT."/frontend/checkregbin.php");
                
                /*  Navbar  */
                include("navbar.php");
                ?>
                
                <section class="container">
                    
                    <h4><?=system_showText(LANG_SITEMGR_BUILDER_COLORS_1)?></h4>
                    <p class="subheading"><?=system_showText(LANG_SITEMGR_BUILDER_COLORS_2)?></p>
                    <p><?=system_showText(LANG_SITEMGR_BUILDER_COLORS_3)?></p>

                    <? if ($success) { ?>
                        <p id="successMessage" class="alert alert-success"><?=ucfirst(system_showText(LANG_SITEMGR_SETTINGSSUCCESSUPDATED));?></p>
                    <? } ?>

                    <form id="step3" name="step3" method="post" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>">

                        <input type="hidden" name="color_option" id="color_option" value="<?=$appbuilder_coloroption?>" />
                        <input type="hidden" name="next" id="next" value="no" />

                        <div class="row">

                            <? 
                            $count = 0;
                            $countTotal = 0;
                            foreach ($arrayColorsApp as $color) {

                                $count++;
                                $countTotal++;
                                $auxColor = explode("-", $color);

                                if ($count == 1) { ?>

                                    <div class="col-sm-4">

                                <? } ?>

                                <label class="colorscheme">
                                    <input type="radio" name="color_scheme" <?=($appbuilder_colorscheme == $auxColor[0]."-".$auxColor[1] ? "checked=\"checked\"" : "")?> value="<?=$auxColor[0]."-".$auxColor[1];?>" />
                                    <b style="background-color:#<?=$auxColor[0];?>"></b>
                                    <b style="background-color:#<?=$auxColor[1];?>"></b>
                                    <b class="colorname"><?=$auxColor[2];?></b>
                                </label>

                                <? if ($countTotal == count($arrayColorsApp)) { ?>
                                    <label class="colorscheme">
                                        <input type="radio" name="color_scheme" <?=($appbuilder_colorscheme == $appbuilder_colorscheme_custom ? "checked=\"checked\"" : "")?> value="custom" />
                                        <b class="colorSelector-5 color-box" data-id="colorApp1" style="background-color:#<?=$colorCustom[0];?>"><span></span></b>
                                        <input type="hidden" id="colorApp1" name="colorApp1" value="<?=$colorCustom[0];?>"/>
                                        <b class="colorSelector-5 color-box" data-id="colorApp2" style="background-color:#<?=$colorCustom[1];?>"><span></span></b>
                                        <input type="hidden" id="colorApp2" name="colorApp2" value="<?=$colorCustom[1];?>"/>
                                        <b class="colorname"><?=system_showText(LANG_SITEMGR_CUSTOM_COLOR);?></b>
                                    </label>
                                <? } ?>

                                <? if ($count == 4 || $countTotal == count($arrayColorsApp)) { $count = 0; ?>
                                    </div>
                                <? } ?>

                            <? } ?>

                        </div>

                        <div class="row action">
                            <button type="button" class="btn btn-success" onclick="JS_submit(true);"><?=system_showText(LANG_SITEMGR_SAVENEXT)?></button>
                        </div>

                    </form>
                        
                </section>                
                
		    </div>
            
        </section>
        
    </main>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/appbuilder.php";
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>