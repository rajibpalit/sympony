<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/mobile/appbuilder/index.php
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
    
    extract($_POST);
    extract($_GET);
    
    
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

        <?
        require(EDIRECTORY_ROOT."/".SITEMGR_ALIAS."/registration.php");
        require(EDIRECTORY_ROOT."/includes/code/checkregistration.php");
        require(EDIRECTORY_ROOT."/frontend/checkregbin.php");
        ?>        

	    <section class="row heading">
			<div class="col-lg-10  col-lg-offset-1 col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading text-center"><?=system_showText(LANG_SITEMGR_THE_PROCESS)?></div>
					<div class="panel-body">
						<div class="showsteps row">
							<div class="col-sm-4"><em>1</em><span><?=system_showText(LANG_SITEMGR_SELECT_CONTENT)?></span></div>
							<div class="col-sm-4"><em>2</em><span><?=system_showText(LANG_SITEMGR_CONFIGURE_CONTENT_COLORS_ICONS_IMAGES)?></span></div>
							<div class="col-sm-4"><em>3</em><span><?=system_showText(LANG_SITEMGR_BUILD_AND_SUBMIT)?></span></div>
						</div>
					</div>
				</div>
			</div>
		</section>
	            
	    <section class="row appbuilder ">

			<div class="col-md-6 col-md-offset-3 col-sm-12 text-center illustration">
				<h3><?=system_showText(LANG_SITEMGR_MESSAGE_USERS)?></h3>
				<a class="btn btn-primary" href="<?=(DEFAULT_URL."/".SITEMGR_ALIAS."/mobile/appbuilder/step1.php")?>"><?=system_showText(LANG_SITEMGR_START_BUILDER)?></a>
				<br>
				<br>
				<br>
				<img class="img-responsive" src="<?=(DEFAULT_URL."/".SITEMGR_ALIAS."/assets/img/appbuilder/process-appbuilder.png")?>" alt="<?=system_showText(LANG_SITEMGR_THE_PROCESS)?>" />
			</div>

	        
		</section>	        
	        
    </main>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>