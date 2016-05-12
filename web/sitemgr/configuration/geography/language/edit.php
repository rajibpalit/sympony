<? exit;
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/configuration/language/edit.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../../../conf/loadconfig.inc.php");
    
	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	permission_hasSMPerm();

	# ----------------------------------------------------------------------------------------------------
	# VALIDATING FEATURES
	# ----------------------------------------------------------------------------------------------------
	if (MULTILANGUAGE_FEATURE != "on") { exit; }

    # ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
    $url_redirect = DEFAULT_URL."/".SITEMGR_ALIAS."/configuration/geography/language/edit.php";
    $url_base = DEFAULT_URL."/".SITEMGR_ALIAS."/configuration/geography/language/";
    extract($_GET);
    extract($_POST);
    $actionFrom = "editLang";

	# ----------------------------------------------------------------------------------------------------
    # CODE
    # ----------------------------------------------------------------------------------------------------
    include(EDIRECTORY_ROOT."/includes/code/language_center.php");
    
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

        <form role="form" name="language" id="language" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">

            <section class="row heading">
	           	<div class="container">
	           		<h1><?=system_showText(LANG_SITEMGR_LANGUAGES_ADD)?></h1>
                    <p><?=system_showText(LANG_SITEMGR_LANGUAGE_ADDTIP)?></p>
				</div>
            </section>
            
            <section class="row section-form">
                <div class="container">
                    
                    <? if ($error) { ?>
                        <p class="alert alert-warning"><?=$error?></p>
                    <? }elseif ($successEdit) { ?>
                        <p class="alert alert-success"><?=system_showText(LANG_SITEMGR_LANGUAGE_CHANGED);?></p>
                    <? } ?>
                    
	           		<div class="row">
		           		<div class="col-sm-8">		           			

		           			<div class="panel panel-form">
						        <div class="panel-heading"><?=system_showText(LANG_SITEMGR_EDITLANG_CHOOSE);?></div>
						        <div class="panel-body">
						        	<p class="help-block"><?=system_showText(LANG_SITEMGR_LANGUAGE_DATA_OPTIONS_TIP);?></p>
						            <div class="row form-horizontal">
						                <div class="col-md-6 selectize">
						                    <select id="lang" name="lang">
						                        <? foreach ($allLanguages as $langInfo) { ?>
						                            <option <?=($lang == $langInfo["id"] ? "selected=\"seleted\"" : "")?> value="<?=$langInfo["id"]?>"><?=$langInfo["name"]?></option>
						                        <? } ?>
						                    </select> 
						                </div>
						                <div class="col-md-6 selectize">
						                    <select id="area" name="area">
						                        <option <?=($area == "front" ? "selected=\"seleted\"" : "")?> value="front"><?=system_showText(LANG_SITEMGR_LANGUAGE_AREA_FRONT);?></option>
						                        <option <?=($area == "sitemgr" ? "selected=\"seleted\"" : "")?> value="sitemgr"><?=system_showText(LANG_SITEMGR_LANGUAGE_AREA_SITEMGR);?></option>
						                    </select> 
						                </div>
						            </div>
                                    <br>
                                    <div class="form-group">
						                <a class="btn btn-sm btn-primary btn-icon" href="javascript: void(0);" onclick="download_file('edit');"><i class="icon-ion-ios7-download-outline"></i><?=system_showText(LANG_SITEMGR_LANGUAGE_DOWNLOAD)?></a>  
						            </div>
						        </div>
						    </div>
                            
						</div>
                        
						<div class="col-sm-4">
                            <div class="panel panel-defaulr">
                                <div class="panel-body">
                                    <p><?=system_showText(LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2);?></p>
                                </div>
                            </div>
					    </div>					    
					</div>
                </div>
           </section>

           <section class="row footer-action">
           		<div class="container">
	           		<div class="col-xs-12 text-right">
		           		<a href="<?=$url_base?>" class="btn btn-default"><?=system_showText(LANG_CANCEL)?></a>
	           			<span class="separator"> <?=system_showText(LANG_OR)?>  </span>        			
                        <button type="button" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" onclick="<?=DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "JS_submit();"?>"><?=system_showText(LANG_SITEMGR_SAVE);?></button>
                    </div>
                </div>
            </section>
            
        </form>
        
        <form role="form" name="language_file" id="language_file" action="language_file.php" method="get" target="_blank">
            <input type="hidden" name="language_id" id="language_id" value="" />
            <input type="hidden" name="language_area" id="language_area" value="" />
            <input type="hidden" name="domain_id" value="<?=SELECTED_DOMAIN_ID?>" />
        </form>

    </main>                           
                         
<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	$customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/language.php";
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>