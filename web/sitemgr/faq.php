<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/faq.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	
	$url_redirect = "".DEFAULT_URL."/".SITEMGR_ALIAS."/";
	$url_base = "".DEFAULT_URL."/".SITEMGR_ALIAS."";
	$sitemgr = 1;
    
    $url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

	include(EDIRECTORY_ROOT."/includes/code/faq.php");

    # ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/header.php");

    # ----------------------------------------------------------------------------------------------------
	# NAVBAR
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/navbar.php");

    # ----------------------------------------------------------------------------------------------------
	# Sidebar
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/sidebar-dashboard.php");
   
?> 

    <main class="wrapper-dashboard togglesidebar container-fluid">

        <section class="container heading">
            <h1><?=system_showText(LANG_SITEMGR_FAQ)?></h1>
            <p><?=system_showText(LANG_SITEMGR_FAQ_TIP1)?></p>
            <p><?=system_showText(LANG_SITEMGR_FAQ_TIP2)?></p>
        </section>

        <section class="row section-form">
            <div class="container" id="view-content-list">

                <form role="search" name="faq" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="get">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" name="keyword" id="keyword" value="<?=$keyword;?>" placeholder="<?=system_showText(LANG_LABEL_SEARCHKEYWORD);?>" class="col-xs-12 form-control search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><?=system_showText(LANG_BUTTON_SEARCH);?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?
                if ($faqs) {
                        $i = 0;
                        echo "<ul class=\"list-unstyled list-faq list\">";
                        foreach ($faqs as $faq) {
                            echo "<li>";
                            echo "<h5 class=\"item-title title-list\">".$faq["question"]."</h5>";
                            echo "<p class=\"item-feature\" id=\"answer".$i."\" >".trim(str_replace('"','',$faq["answer"]))."</p>";
                            echo "</li>";
                            $i++;
                        }
                        echo "</ul>";
                    } else { ?>
                            <?include(SM_EDIRECTORY_ROOT."/layout/norecords.php"); ?>
                    <? }
                ?>

            </div>
        </section>

    </main>

<?php 
	    
    # ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
    $controlSidebar = true;
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/general.php";
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");

?>