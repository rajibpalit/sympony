<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/configuration/geography/locations/location_updateFeatured.php
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
	# CODE
	# ----------------------------------------------------------------------------------------------------

	$id = $_GET['id'];
	$featured = $_GET['featured'];
	$row_id = $_GET['row_id'];
	$level = $_GET['level'];
	
	$featured = ($featured == "y" ? "n" : "y");

	$locationFeatObj = new LocationFeatured(SELECTED_DOMAIN_ID, $level, $id);

	if ($featured == "y") {
		$locationFeatObj->setFeatured(SELECTED_DOMAIN_ID, $level, $id);
	} else {
		$locationFeatObj->deleteFeatured(SELECTED_DOMAIN_ID, $level, $id);
	}

	?>
	<a href="javascript:void(0);" onclick="javascript:updateFeatured(<?=$id?>,'<?=$featured?>',<?=$level?>,<?=$row_id?>)">
		<img src="<?=DEFAULT_URL?>/assets/images/structure/<?=$featured == 'y' ? 'icon_check.gif' : 'icon_uncheck.gif'?>" border="0" alt="<?=($featured == 'y' ? system_showText(LANG_SITEMGR_ACTIVATED) : system_showText(LANG_SITEMGR_DEACTIVATED))?>" title="<?=($featured == 'y' ? system_showText(LANG_SITEMGR_ACTIVATED) : system_showText(LANG_SITEMGR_DEACTIVATED))?>" />
	</a>

