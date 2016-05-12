<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/content/pages/index.php
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
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST" && $action == "delete") {
		$content = new Content($_POST['id']);
		$content->Delete();
        $message = 5;
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/pages/index.php?message=".$message);
		exit;
	}
    
    # ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	$section = "client";

	# ----------------------------------------------------------------------------------------------------
	# PAGE BROWSING
	# ----------------------------------------------------------------------------------------------------
	$pageObj  = new pageBrowsing("Content", $screen, false, "id", "id", $letter, "section = 'client'");
	$contents = $pageObj->retrievePage();

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
            <div class="container">
                <h1><?=system_showText(LANG_SITEMGR_CUSTOMPAGES);?></h1>
                <? if (is_numeric($message) && isset($msg_content[$message])) { ?>
           		<p class="alert alert-success"><?=$msg_content[$message];?></p>
                <? } ?>
                </div>
        </section>

       	<section class="row form-thumbnails">

     		<div class="container row">
        
                <?
                if ($contents) {
                    foreach($contents as $content) {
                        $id = $content->getNumber("id");
                        $contentLabel = string_strtoupper($content->getString("type"));
                        $contentLabel = str_replace(" ", "_", $contentLabel);
                ?>
                <div class="col-md-2 col-xs-6">

                    <div class="thumbnail">
                        <div class="caption">
                            <h5 class="overflow"><?=$content->getString("type")?></h5>
                            <a class="btn btn-primary btn-xs" href="custom.php?id=<?=$id?>"><?=(system_showText(LANG_SITEMGR_EDIT))?></a>
                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-delete" href="#" onclick="$('#delete-id').val(<?=$id?>)"><?=system_showText(LANG_SITEMGR_REMOVE);?></button>
                        </div>
                    </div>

                </div>
                <? } ?>
                <? } ?>

                <div class="col-md-2 col-xs-6">
                    <a class="thumbnail add-new" href="custom.php">
                        <i class="icon-cross8"></i>
                        <div class="caption">
                            <h6><?=system_showText(LANG_SITEMGR_CONTENT_ADDCUSTOMWEBPAGE)?></h6>
                        </div>
                    </a>
                </div>

   			</div>
   		</section>
    </main>

    <? include(INCLUDES_DIR."/modals/modal-delete.php"); ?>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>