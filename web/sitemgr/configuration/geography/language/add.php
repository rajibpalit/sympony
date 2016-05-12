<? exit;
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/configuration/language/add.php
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
    $url_redirect = DEFAULT_URL."/".SITEMGR_ALIAS."/configuration/geography/language/add.php";
    $url_base = DEFAULT_URL."/".SITEMGR_ALIAS."/configuration/geography/language/";
    extract($_GET);
    extract($_POST);
    $actionFrom = "addLang";

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

        <form role="form" name="language" id="language" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data">

            <section class="row heading">
	           	<div class="container">
	           		<h1><?=system_showText(LANG_SITEMGR_LANGUAGES_ADD)?></h1>
                    <p><?=system_showText(LANG_SITEMGR_LANGUAGE_ADDTIP)?></p>
				</div>
            </section>
            
            <section class="row">
                <div class="container">
                    
                    <? if ($error) { ?>
                        <p class="alert alert-warning"><?=$error?></p>
                    <? } ?>

                    <? if ($message) { ?>
                        <p class="alert alert-success"><?=system_showText(LANG_SITEMGR_LANGUAGE_ADDED);?></p>
                    <? } ?>
                    
	           		<div class="row">
		           		<div class="col-sm-8">		           			

		           			<?//Download file ?>
						    <div class="panel panel-form">
						        <div class="panel-heading"><?=system_showText(LANG_SITEMGR_LANGUAGE_DOWNLOAD)?></div>
						        <div class="panel-body">
						        	<p class="help-block"><?=system_showText(LANG_SITEMGR_LANGUAGE_ADD_1)?></p>
						            <div class="form-group">
						                <a class="btn btn-primary" href="javascript: void(0);" onclick="download_file('add');"><?=system_showText(LANG_SITEMGR_LANGUAGE_DOWNLOAD)?></a>  
						            </div>
						        </div>
						    </div>

						    <?//Edit Language settings ?>
						    <div class="panel panel-form">
						    	<div class="panel-heading"><?=str_replace("...", "", system_showText(LANG_SITEMGR_LANGUAGE_NAMELANG))?></div>
						    	<div class="panel-body">
						    		<div class="row">
						    			<div class="col-md-7 form-group">
						    				<label for="language_name"><?=system_showText(LANG_SITEMGR_LANGUAGE_ADD_2)?></label>
						    				<input class="form-control" type="text" id="language_name" name="language_name" maxlength="12" value="<?=$language_name?>" placeholder="<?=system_showText(LANG_SITEMGR_LANGUAGE_NAMELANG)?>">
						    			</div>
						    			<div class="col-md-5 form-group">
						    				<label for="language_abbr"><?=system_showText(LANG_SITEMGR_LANGUAGE_ADD_3)?> <i class="icon-help10" id="iconHelp" data-toggle="tooltip" data-placement="top" title="<?=string_htmlentities(system_showText(LANG_SITEMGR_LANGUAGE_ADD_3_TIP));?>"></i></label>
						    				<input class="form-control" type="text" id="language_abbr" name="language_abbr" maxlength="5" value="<?=$language_abbr?>" placeholder="<?=system_showText(LANG_SITEMGR_LANGUAGE_ABBRLANG)?>">
						    			</div>
						    		</div>
						    	</div>
						    </div>

						    <?//Upload using FTP ?>
						    <div class="panel panel-form">
						    	<div class="panel-heading"><?=system_showText(LANG_SITEMGR_FINALSTEP);?></div>
						    	<div class="panel-body">
						    		<p class="text-info"><?=system_showText(LANG_SITEMGR_LANGUAGE_ADD_5_NEW);?></p>
						    	</div>
						    </div>
                            
						</div>
                        
						<div class="col-sm-4">
							<br>
							<?//Flag Image ?>
						    <div class="panel panel-form-media">
                                <div class="panel-heading">
                                    <?=system_showText(LANG_SITEMGR_LANGUAGE_NEWFLAG);?>
                                    <div class="pull-right">
                                        <input type="file" name="flag_image" class="filestyle upload-files file-noinput">
                                    </div>
							    </div>
							    <div class="panel-body">
						    		<div id="no-filesImages" class="no-files center-block text-center">
                                        <i class="icon-images9"></i>
                                        <p class="text-muted"><?=system_showText(LANG_SITEMGR_LANGUAGE_ADD_4)?></p>
                                    </div>
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
                        <button type="button" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" onclick="<?=DEMO_LIVE_MODE ? "livemodeMessage(true);" : "JS_submit();"?>"><?=system_showText(LANG_SITEMGR_SAVE);?></button>
                    </div>
                </div>
            </section>
            
        </form>

    </main>
            
<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/language.php";
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>