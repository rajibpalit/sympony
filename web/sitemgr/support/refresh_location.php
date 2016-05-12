<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/support/refresh_location.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	define("SELECTED_DOMAIN_ID", $_GET["domain_id"]);
    include("../../conf/loadconfig.inc.php");

	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");

    $locationCounterObj = new LocationCounter();
    
	$arrayModules[] = "listing";
    $arrayModules[] = "classified";
    $arrayModules[] = "event";
    $arrayModules[] = "promotion";
    foreach ($arrayModules as $value) {
        $locationCounterObj->ReCountLocations($value, SELECTED_DOMAIN_ID);
    }