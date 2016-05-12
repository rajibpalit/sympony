<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/design/layout-editor/index.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------

    //Ajax requests - Define domain ID and sitemgr language
    if (isset($_GET["domain_id"]) && $_GET["action"] == "ajax") define("SELECTED_DOMAIN_ID", $_GET["domain_id"]);
    
    if (isset($_GET["type"]) && $_GET["type"] == "uploadBackground") {
        $loadSitemgrLangs = true;
    }
    
    include("../../../conf/loadconfig.inc.php");
    
    //Ajax requests - Define header
    if ($_GET["type"] == "uploadBackground" || $_GET["type"] == "general") {
        header("Content-Type: text/html; charset=".EDIR_CHARSET, TRUE);
        header("Accept-Encoding: gzip, deflate");
        header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check", FALSE);
        header("Pragma: no-cache");
    }

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	permission_hasSMPerm();
    
    # ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	include(INCLUDES_DIR."/code/layout_editor.php");
    include(INCLUDES_DIR."/code/editor.php");
    
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
                <h1><?=system_showText(LANG_SITEMGR_MENU_THEMES)?></h1>
                <p><?=system_showText(LANG_SITEMGR_SETTINGS_THEME_TIP);?></p>
                
                <? if ($message || is_numeric($message)) { ?>
                <div class="col-sm-12 alert alert-<?=$message_style?>" role="alert">
                    <p>
                    <?
                    if (is_numeric($message) && isset($msg_editor[$message])) {
                        echo $msg_editor[$message];
                    } else {
                        echo $message;
                    }
                    ?>
                    </p>
                </div>
                <? } elseif ($errorMessage) { ?>
                    <div class="col-sm-12 alert alert-warning" role="alert">
                        <p><?=$errorMessage?></p>
                    </div>
                <? } ?>
        </section>
        	
        <section class="row">
            <div class="form-thumbnails">
            <form name="theme" id="theme" role="form" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">
					
                <input type="hidden" name="domain_id" value="<?=SELECTED_DOMAIN_ID?>">
                <input type="hidden" name="scheme" id="scheme" value="<?=EDIR_SCHEME?>">
                <input type="hidden" name="select_theme" id="select_theme" value="<?=EDIR_THEME?>">
                <input type="hidden" name="import_categories" id="import_categories" value="">
                <input type="hidden" name="submitAction" value="changetheme">
                
                <div class="row">

                    <? foreach ($availableThemes as $avTheme) { ?>

                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="select-theme thumbnail <?=($avTheme["value"] == $edir_theme ? "active in-use" : "")?>">
                            <img src="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/assets/img/themes/".$avTheme["value"].".png";?>" alt="<?=$avTheme["name"];?>">
                            <? if ($avTheme["value"] != $edir_theme) { ?>
                                <a href="<?=$avTheme["preview_url"];?>" target="_blank" class="btn btn-default btn-xs btn-preview"><?=system_showText(LANG_SITEMGR_PREVIEW);?></a>
                            <? } ?>

                            <div class="caption">
                                <h6><?=$avTheme["name"];?></h6>
                                <p class="text-center">
                                    <? if ($avTheme["value"] == $edir_theme) { ?>
                                    <a href="javascript:void(0);" class="active btn btn-primary btn-xs"><?=system_showText(LANG_SITEMGR_INUSE)?></a>
                                    <? } else { ?>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-xs" onclick="JS_submit(false, true, '<?=$avTheme["value"]?>');"><?=system_showText(LANG_SITEMGR_USETHIS)?></a> 
                                    <? } ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <? } ?>

                </div>
                
            </form>
            </div>
            
   		</section>

   		<section class="row theme-options">
            
            <div class="row tab-pane fade in active">

                <ul class="nav nav-tabs" role="tablist">
                    <? if (string_strpos($availableTabs[EDIR_THEME], "color") !== false) { ?>
                    <li <?=(!$_GET["file"] && !$errorMessage && !$extrafields ? "class=\"active\"" : "")?>><a href="#tab-colors" role="tab" data-toggle="tab"><?=system_showText(LANG_SITEMGR_COLOR_COLOROPTIONS);?></a></li>
                    <? } ?>
                    
                    <? if (string_strpos($availableTabs[EDIR_THEME], "background") !== false) { ?>
                    <li><a href="#tab-background" role="tab" data-toggle="tab"><?=system_showText(LANG_SITEMGR_COLOR_BACKGROUNDIMAGE);?></a></li>
                    <? } ?>
                    
                    <? if (string_strpos($availableTabs[EDIR_THEME], "css") !== false) { ?>
                    <li <?=($_GET["file"] || $errorMessage)?>><a href="#tab-csseditor" role="tab" data-toggle="tab"><?=system_showText(LANG_SITEMGR_SETTINGS_HTMLEDITOR)?></a></li>
                    <? } ?>
                    
                    <? if (string_strpos($availableTabs[EDIR_THEME], "price") !== false) { ?>
                    <li><a href="#tab-listing" role="tab" data-toggle="tab"><?=system_showText(LANG_SITEMGR_DG_OPTIONS)?></a></li>
                    <? } ?>
                    
                    <? if (string_strpos($availableTabs[EDIR_THEME], "extrafields") !== false) { ?>
                    <li <?=($extrafields ? "class=\"active\"" : "")?>><a href="#tab-extrafields" role="tab" data-toggle="tab"><?=system_showText(LANG_SITEMGR_DG_OPTIONS)?></a></li>
                    <? } ?>
                </ul>
                <div class="col-xs-12">
                    <div class="tab-content">
                        
                        <section class="tab-pane <?=(!$_GET["file"] && !$errorMessage  && !$extrafields && (string_strpos($availableTabs[EDIR_THEME], "color") !== false) ? "active" : "")?>" id="tab-colors">
                            
                            <form name="color_scheme" id="color_scheme" role="form" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
                                
                                <input type="hidden" name="submitAction" value="changecolors">
                                <input type="hidden" name="theme" value="<?=EDIR_THEME?>">
                                <input type="hidden" name="scheme" value="<?=EDIR_SCHEME?>">
                                <input type="hidden" name="action" id="action" value="submit">
                                <input type="hidden" name="aux_action" id="aux_action" value="0">
                                
                                <h4><?=system_showText(LANG_SITEMGR_COLOR_COLOROPTIONS);?></h4>
                                
                                <h5><?=system_showText(LANG_SITEMGR_COLOR_MAINCOLORS);?></h5>
                                
                                <div class="row">
                                    
                                    <? foreach ($table_colors_3 as $table_info) { ?>
                                    <div class="form-group col-sm-4 col-xs-12">
                                        <div class="col-xs-2">
                                            <b class="colorSelector-<?=$table_info?> color-box" data-id="color<?=$table_info?>" style="background-color:#<?=${"color".$table_info}?>"><span></span></b>
                                            <input type="hidden" id="color<?=$table_info?>" name="color<?=$table_info?>" value="<?=${"color".$table_info}?>">
                                        </div>
                                        <label class="col-xs-10 control-label">
                                            <?=system_showText(constant("LANG_SITEMGR_COLOR_".string_strtoupper($table_info)))?>
                                            <p class="help-block small"><a href="javascript: void(0);" onclick="restoreDefault('color<?=$table_info?>', 'colorSelector-<?=$table_info?>', '<?=$arrayDefault[EDIR_THEME][EDIR_SCHEME]["color".$table_info]?>')"><?=LANG_SITEMGR_COLOR_RESTORE?></a></p>
                                        </label>
                                    </div>
                                    <? } ?>
                                    
                                </div>
                                
                                <h5><?=system_showText(LANG_SITEMGR_COLOR_SUPPORTCOLORS);?></h5>
                                
                                <div class="row">
                                    
                                    <? foreach ($table_colors_2 as $table_info) { ?>
                                    <div class="form-group col-sm-4 col-xs-12">
                                        <div class="col-xs-2">
                                            <b class="colorSelector-<?=$table_info?> color-box" data-id="color<?=$table_info?>" style="background-color:#<?=${"color".$table_info}?>"><span></span></b>
                                            <input type="hidden" id="color<?=$table_info?>" name="color<?=$table_info?>" value="<?=${"color".$table_info}?>">
                                        </div>
                                        <label class="col-xs-10 control-label">
                                            <?=system_showText(constant("LANG_SITEMGR_COLOR_".string_strtoupper($table_info)."COLOR"))?>
                                            <p class="help-block small"><a href="javascript: void(0);" onclick="restoreDefault('color<?=$table_info?>', 'colorSelector-<?=$table_info?>', '<?=$arrayDefault[EDIR_THEME][EDIR_SCHEME]["color".$table_info]?>')"><?=LANG_SITEMGR_COLOR_RESTORE?></a></p>
                                        </label>
                                    </div>
                                    <? } ?>
                                    
                                </div>
                                
                                <h5><?=system_showText(LANG_SITEMGR_COLOR_TYPOGRAFYOPTIONS);?></h5>
                                
                                <div class="row">
                                    
                                    <? foreach ($table_colors_1 as $table_info) { ?>
                                    <div class="form-group col-sm-4 col-xs-12">
                                        <div class="col-xs-2">
                                            <b class="colorSelector-<?=$table_info?> color-box" data-id="color<?=$table_info?>" style="background-color:#<?=${"color".$table_info}?>"><span></span></b>
                                            <input type="hidden" id="color<?=$table_info?>" name="color<?=$table_info?>" value="<?=${"color".$table_info}?>">
                                        </div>
                                        <label class="col-xs-10 control-label">
                                            <?=system_showText(constant("LANG_SITEMGR_COLOR_".string_strtoupper($table_info)."COLOR"))?>
                                            <p class="help-block small"><a href="javascript: void(0);" onclick="restoreDefault('color<?=$table_info?>', 'colorSelector-<?=$table_info?>', '<?=$arrayDefault[EDIR_THEME][EDIR_SCHEME]["color".$table_info]?>')"><?=LANG_SITEMGR_COLOR_RESTORE?></a></p>
                                        </label>
                                    </div>
                                    <? } ?>
                                    
                                    <div class="form-group col-sm-4 col-xs-12">
                                        <div class="col-xs-10 control-label">
                                            <label><?=string_ucwords(system_showText(LANG_SITEMGR_COLOR_FONT))?></label>
                                            <div class="selectize">
                                                <?=$arrayFont;?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            
                            </form>
                            
                            <section class="row footer-action">
                                    <div class="col-xs-12 text-right">
                                        <button type="button" name="reset_button" value="Submit" class="btn btn-default btn-xs action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" onclick="<?=(DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "JS_submitColors('reset');")?>"><?=system_showText(LANG_SITEMGR_RESET)?></button>
                                        <span class="separator"> </span>
                                        <button type="button" name="submit_button" value="Submit" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" onclick="<?=(DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "JS_submitColors('submit');")?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                                    </div>
                            </section>
                            
                        </section>
                        
                        <section class="tab-pane" id="tab-background">
                            
                            <form id="theme_background_image" role="form" method="post" enctype="multipart/form-data" action="javascript:void(0);">
                            
                                <input type="hidden" name="form_id" value="theme_background_image">
                                <input type="hidden" name="reset_form" id="reset_form" value="">
                                <input type="hidden" name="curr_image_id" id="curr_image_id" value="<?=$curr_image_id;?>">
                                
                                <p id="returnMessage" class="alert" style="display:none;"></p>

                                <h4><?=system_showText(LANG_SITEMGR_COLOR_BACKGROUNDIMAGE);?></h4>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <p><?=str_replace("[dimension]", IMAGE_THEME_BACKGROUND_W." x ".IMAGE_THEME_BACKGROUND_H, system_showText(LANG_SITEMGR_BACKGROUND_TIP));?></p>
                                        <div class="row">
                                            <div class="col-xs-12 form-group">
                                                <input type="file" class="file-noinput" name="file_background_image" id="file_background_image" onchange="sendFile();">
                                                <p class="help-block"><?=IMAGE_THEME_BACKGROUND_W?> x <?=IMAGE_THEME_BACKGROUND_H?>px</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="image-background" class="col-sm-6 col-xs-12 img-background text-center">
                                        <?=front_getBackground(true);?>
                                    </div>
                                </div>
                                
                                <div id="loading_backgroundimage" class="alert alert-loading alert-block text-center hidden">
                                    <img src="<?=DEFAULT_URL;?>/<?=SITEMGR_ALIAS?>/assets/img/loading-64.gif">
                                </div>
                                
                            </form>
                            
                            <section class="row footer-action">
                                <div class="row text-right">
                                    <button type="button" id="buttonReset" class="btn btn-default btn-xs action-save" <?=(file_exists(EDIRECTORY_ROOT.BKIMAGE_PATH."/".BKIMAGE_NAME.".".BKIMAGE_EXT) ? "" : "disabled=\"\"")?> onclick="resetImage(); submitForm('theme_background_image');" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_RESET)?></button>
                                </div>
                            </section>
                            
                        </section>
                        
                        <section class="tab-pane <?=($_GET["file"] || $errorMessage)?>" id="tab-csseditor">
                            
                            <form id="htmleditor" role="form" name="htmleditor" class="html-editor" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">
                                
                                <input type="hidden" name="domain_id" value="<?=SELECTED_DOMAIN_ID?>">
                                <input type="hidden" name="file" value="<?=$file?>">
                                <input type="hidden" name="fileType" value="<?=$fileType?>">
                                <input type="hidden" name="submitAction" value="csseditor">
                        
                                <h4><?=system_showText(LANG_SITEMGR_SETTINGS_HTMLEDITOR)?></h4>
                                <div class="row">
                                    <div class="col-md-3 col-xs-12">
                                        <?=system_showText(LANG_SITEMGR_EDITOR_TIP1);?>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <textarea name="text" id="textarea" class="form-control" rows="30"><?=htmlspecialchars($text)?></textarea>
                                    </div>
                                </div>
                                
                                <section class="row footer-action">
                                    <div class="col-xs-12 text-right">
                                        <button type="submit" name="revert" value="Submit" class="btn btn-default btn-xs action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_RESET)?></button>
                                        <span class="separator"> </span>
                                        <button type="submit" name="htmleditor" value="Submit" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                                    </div>
                                </section>
                                
                            </form>                       

                        </section>
                        
                        <section class="tab-pane" id="tab-listing">
                            
                            <form id="pricing_levels_form" role="form" method="post" enctype="multipart/form-data" action="javascript:void(0);">
                                
                                <input type="hidden" name="form_id" value="pricing_levels_form">
                                
                                <p id="returnMessage-pricing_levels_form" class="alert" style="display:none;"></p>
                                
                                <h4><?=system_showText(LANG_SITEMGR_PRICING_LEVELS)?></h4>
                                <div class="row">
                                    <div class="col-md-3 col-xs-12">
                                        <?=system_showText(LANG_SITEMGR_PRICING_LEVELS_TEXT)?>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        
                                        <div class="form-group">
                                            <label><?=system_showText(LANG_SITEMGR_PRICING_LEVELS_SYMBOL)?></label>
                                            <p class="help-block small"><?=system_showText(LANG_SITEMGR_PRICING_LEVELS_WHICH_SYMBOL)?></p>
                                        </div>
                                        <div class="form-inline">
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" id="symbol-1" value="$" name="symbol" onclick="changePriceSymbol('$')" <?=($listing_price_symbol == "$" ? "checked=\"checked\"" : "")?>> $
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" id="symbol-2" value="£" name="symbol" onclick="changePriceSymbol('£')" <?=($listing_price_symbol == "£" ? "checked=\"checked\"" : "")?>> £
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" id="symbol-3" value="€" name="symbol" onclick="changePriceSymbol('€')" <?=($listing_price_symbol == "€" ? "checked=\"checked\"" : "")?>> €
                                                </label>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="symbol-4" value="custom" name="symbol" onclick="changePriceSymbol(document.getElementById('custom_symbol').value);" <?=(($listing_price_symbol != "€" && $listing_price_symbol != "£" && $listing_price_symbol != "$") ? "checked=\"checked\"" : "")?>> 
                                                </span> 
                                                <input type="text" name="custom_symbol" id="custom_symbol" class="form-control" maxlength="3" onkeyup="changePriceSymbol(this.value);" value="<?=(($listing_price_symbol != "€" && $listing_price_symbol != "£" && $listing_price_symbol != "$") ? $listing_price_symbol : "")?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><?=system_showText(LANG_SITEMGR_PRICING_RANGES)?></label>
                                            <p class="help-block small"><?=system_showText(LANG_SITEMGR_PRICING_RANGES_TEXT)?></p>
                                        </div>
                                                                            
                                        <div class="form-group row">
                    
                                            <div class="col-xs-3">
                                                <label><b id="inexpensive_symbol">$</b> <?=system_showText(LANG_SITEMGR_PRICING_INEXPENSIVE)?></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">0</span>
                                                    <span class="input-group-addon"> - </span>
                                                    <input type="number" class="form-control" maxlength="5" name="listing_price_1_to" id="listing_price_1_to" value="<?=$listing_price_1_to?>">
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="form-group row">
                    
                                            <div class="col-xs-3">
                                                <label><b id="averagely_expensive_symbol">$$</b> <?=system_showText(LANG_SITEMGR_PRICING_AVERAGELY_EXPENSIVE)?></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" maxlength="5" name="listing_price_2_from" id="listing_price_2_from" value="<?=$listing_price_2_from?>">
                                                    <span class="input-group-addon"> - </span>
                                                    <input type="number" class="form-control" maxlength="5" name="listing_price_2_to" id="listing_price_2_to" value="<?=$listing_price_2_to?>">
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="form-group row">
                    
                                            <div class="col-xs-3">
                                                <label><b id="moderately_expensive_symbol">$$$</b> <?=system_showText(LANG_SITEMGR_PRICING_MODERATELY_EXPENSIVE)?></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" maxlength="5" name="listing_price_3_from" id="listing_price_3_from" value="<?=$listing_price_3_from?>">
                                                    <span class="input-group-addon"> - </span>
                                                    <input type="number" class="form-control" maxlength="5" name="listing_price_3_to" id="listing_price_3_to" value="<?=$listing_price_3_to?>">
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="form-group row">
                    
                                            <div class="col-xs-3">
                                                <label><b id="expensive_symbol">$$$$</b> <?=system_showText(LANG_SITEMGR_PRICING_EXPENSIVE)?></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" maxlength="5" name="listing_price_4_from" id="listing_price_4_from" value="<?=$listing_price_4_from?>">
                                                    <span class="input-group-addon"> - <?=system_showText(LANG_SITEMGR_PRICING_AND_UPWARDS)?></span>
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <section class="row footer-action">
                                        <div class="col-xs-12 text-right">
                                            <button type="button" name="submit_bt" value="options" class="btn btn-primary action-save" onclick="submitForm('pricing_levels_form')" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                                        </div>
                                </section>
                                
                            </form>                       

                        </section>
                        
                        <section class="tab-pane <?=($extrafields ? "active" : "")?>" id="tab-extrafields">
                            
                            <form id="listingtemplate" role="form" name="listingtemplate" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="POST">
                                
                                <input type="hidden" name="submitAction" value="changeExtraFields">
                                <input type="hidden" name="id" value="<?=THEME_TEMPLATE_ID?>">
                        
                                <h4><?=system_showText(LANG_SITEMGR_ADDFIELDS)?></h4>
                                <div class="row">
                                    <div class="col-md-3 col-xs-12">
                                        <?=system_showText(LANG_SITEMGR_ADDFIELDS_TIP);?>
                                        <br><br>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_INTRO)?></b></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_FIELD)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_FIELD)?></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_LABEL)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_LABEL)?></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TOOLTIP)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_TOOLTIP)?></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_REQUIRED)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_REQUIRED)?></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_SEARCH)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_SEARCH)?></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_SEARCHBYKEYWORD)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_SEARCHBYKEYWORD)?></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_SEARCHBYRANGE)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_SEARCHBYRANGE)?></p>
                                        <p><b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_VALUES)?>: </b><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_TIPS_VALUES)?></p>
                                        
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <? include(INCLUDES_DIR."/forms/form_themetemplate.php"); ?>
                                    </div>
                                </div>
                                
                                <section class="row footer-action">
                                        <div class="col-xs-12 text-right">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                                        </div>
                                </section>
                                
                            </form>                       

                        </section>
                        
                    </div>
                </div>
            </div>
            
		</section>
    
    </main>

<?php
    # ----------------------------------------------------------------------------------------------------
    # FOOTER
    # ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/layout-editor.php";
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>