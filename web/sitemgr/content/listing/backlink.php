<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/content/listing/backlink.php
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
    
    if (BACKLINK_FEATURE == "off") {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/");
		exit;
	}
    
    # ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);
    
    $url_redirect = "".DEFAULT_URL."/".SITEMGR_ALIAS."/content/".LISTING_FEATURE_FOLDER;
    $url_base 	  = "".DEFAULT_URL."/".SITEMGR_ALIAS."";
    $url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));
    $sitemgr 	  = 1;
    
    $errorPage = "$url_redirect/index.php?message=".$message."&screen=$screen&letter=$letter".(($url_search_params) ? "&$url_search_params" : "")."";

    if ($id) {
		$levelObj = new ListingLevel(true);
		$listing = new Listing($id);
		if ((!$listing->getNumber("id")) || ($listing->getNumber("id") <= 0)) {
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/".LISTING_FEATURE_FOLDER."/index.php?message=".$message."&screen=$screen&letter=$letter".(($url_search_params) ? "&$url_search_params" : "")."");
			exit;
		}
		$listingHasBacklink = $levelObj->getBacklink($listing->getNumber("level"));
		if ((!$listingHasBacklink) || ($listingHasBacklink != "y")) {
			header("Location: ".$errorPage);
			exit;
		}
	} else {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/".LISTING_FEATURE_FOLDER."/index.php?screen=$screen&letter=$letter");
		exit;
	}
    
    # ----------------------------------------------------------------------------------------------------
    # CODE
    # ----------------------------------------------------------------------------------------------------
    include(EDIRECTORY_ROOT."/includes/code/backlinks.php");
    
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
            
        <?php
        
        if ($id) {
            $arrayCompletion = system_gamefyItems("listing", $listing);
        ?>
        
        <div class="row">
            <div class="progress">
                <div class="progress-bar" data-placement="bottom" data-toggle="tooltip" data-original-title="<?=$arrayCompletion["total"]?>% <?=ucfirst(LANG_LABEL_COMPLETED)?>" role="progressbar" aria-valuenow="<?=$arrayCompletion["total"]?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$arrayCompletion["total"]?>%;">
                    <span class="sr-only"><?=$arrayCompletion["total"]?>% <?=ucfirst(LANG_LABEL_COMPLETED)?></span>
                </div>
			</div>
		</div>
        
        <? } ?>

        <form role="form" name="backlinks" id="backlinks" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">
					
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="backlinkValid" value="1" />
            <input type="hidden" name="sitemgr" value="1" />
            
            <section class="row heading">
                
	           	<div class="container">
                    <div class="col-sm-8">
                        <? if ($id) { ?>
    	           		<h1><?=string_ucwords(system_showText(LANG_SITEMGR_EDIT))." ".system_showText(LANG_SITEMGR_LISTING_SING)?> <i><?=$listing->getString("title")?></i></h1>
                        <? } else { ?>
                        <h1><?=string_ucwords(system_showText(LANG_SITEMGR_ADD))." ".system_showText(LANG_SITEMGR_LISTING_SING)?></h1>
                        <? } ?>
                    </div>
				</div>
         
            </section>
			
			<section class="row tab-options">
            		
                <div class="container">
                    <? include(SM_EDIRECTORY_ROOT."/layout/nav-tabs-content-listing.php"); ?>

                    <div class="pull-right top-actions">
                        <a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/content/".LISTING_FEATURE_FOLDER."/"?>" class="btn btn-default btn-xs"><?=system_showText(LANG_CANCEL)?></a>
                        <span class="separator"> <?=system_showText(LANG_OR)?>  </span>
                        <button type="submit" value="Submit" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="container">
                            <? include(INCLUDES_DIR."/forms/form-listing-backlink.php"); ?>
                        </div>
                    </div>
                </div>
                
            </section>
            
            <section class="row footer-action">
                
           		<div class="container">
	           		<div class="col-xs-12 text-right">
		           		<a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/content/".LISTING_FEATURE_FOLDER."/"?>" class="btn btn-default btn-xs"><?=system_showText(LANG_CANCEL)?></a>
                        <span class="separator"> <?=system_showText(LANG_OR)?>  </span>
                        <button type="submit" value="Submit" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
					</div>
				</div>
                
            </section>
            
        </form>

    </main>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/modules.php";
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>