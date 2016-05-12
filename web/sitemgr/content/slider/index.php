<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/content/slider/index.php
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
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);	
	
	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	include(INCLUDES_DIR."/code/slider.php");
    
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
	include(SM_EDIRECTORY_ROOT."/layout/sidebar-content.php");

?> 

    <main class="wrapper togglesidebar container-fluid">

        <section class="heading">
            <div class="container-fluid">
                <h1><?=system_showText(LANG_SITEMGR_SLIDER_MSG_CONTENT)?></h1>
                <p><?=str_replace("[totalSlides]", TOTAL_SLIDER_ITEMS, system_showText(LANG_SITEMGR_SLIDER_EXPLAIN_LINE_1));?> </p>
                                
                <? if ($message) { ?>
                    <p class="alert alert-<?=($error ? "warning" : "success")?>"><?=$message?></p>
                <? } ?>
            </div>
        </section>

        <section class="form-thumbnails slider-thumbnails">
     		<div class="row" role="tablist">
                
                <?
                $nextSlideAvailable = 0;
                for ($slider_number = 1; $slider_number <= TOTAL_SLIDER_ITEMS; $slider_number++) {
                    if ($array_slider[$slider_number]["image_id"]) { ?>
                
                    <div class="col-md-2 col-xs-6">
                        <div class="thumbnail" role="tab">
                            <?
                            $imageObj = new Image($array_slider[$slider_number]["image_id"]);
                            if ($imageObj->imageExists()) {
                                echo $imageObj->getTag(false, 0, 0, $array_slider[$slider_number]["alternative_text"]);
                            }
                            ?>
                            <div class="caption">
                                <h6><?=$array_slider[$slider_number]["title"]?></h6>
                                <a class="btn btn-primary btn-xs" data-toggle="tab" onclick="scrollPage('.tab-content'); selectSlide(<?=$slider_number;?>);" href="#slider<?=$slider_number;?>"><?=system_showText(LANG_LABEL_EDIT)?></a>
                                <button type="button" class="btn btn-warning btn-xs" onclick="<?=DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "deleteSlider($slider_number);"?>"><?=system_showText(LANG_SITEMGR_REMOVE)?></button>
                            </div>
                        </div>
                    </div>
                
                <? } else {
                        if (!$nextSlideAvailable) {
                            $nextSlideAvailable = $slider_number;
                        }
                    }
                
                } ?>
                
                    <div class="col-md-2 col-xs-6 <?=($nextSlideAvailable ? "" : "hidden")?>">
                        <a class="thumbnail add-new" data-toggle="tab" onclick="scrollPage('.tab-content'); selectSlide(<?=$nextSlideAvailable;?>);" href="#slider<?=$nextSlideAvailable;?>" role="tab">
                            <i class="image-placeholder icon-cross8"></i>
                            <div class="caption">
                                <h6><?=system_showText(LANG_SITEMGR_SLIDER_ADD);?></h6>
                            </div>
                        </a>
                    </div>
                
   			</div>
   		</section>

        <form name="slider" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="number_of_items" value="<?=TOTAL_SLIDER_ITEMS?>" />
            <input type="hidden" name="settings" value="settings" />
            <input type="hidden" name="submit_button" id="submit_button" />
            <input type="hidden" name="last_slide_changed" id="last_slide_changed" value="" />
            
            <section class="tab-content">
                                                
                <? for ($slider_number = 1; $slider_number <= TOTAL_SLIDER_ITEMS; $slider_number++) { ?>

                <section class="row tab-pane section-form <?=($_POST && $last_slide_changed == $slider_number ? "active" : "")?>" id="slider<?=$slider_number?>">
                    <div class="container-fluid">
                        <div class="col-xs-12">
                            <div class="col-sm-12">
                                <fieldset>
                                    <legend><?=system_showText(LANG_SITEMGR_SLIDER_EDIT);?></legend>
                                </fieldset>
                            </div>

                            <? include(INCLUDES_DIR."/forms/form-slider.php"); ?>
                        </div>
                    </div>

                </section>

                <? } ?>
            </section>
            
        </form>
        
        <form name="delete_slider" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">
            <input type="hidden" name="image_id" id="delete_image_id" />
            <input type="hidden" name="slider_id" id="delete_slider_id" />
            <input type="hidden" name="delete" value="delete" />
        </form>
    
    </main>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/slider.php";
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>