<?

	/*==================================================================*\
	######################################################################
	#                                                                    #
	# Copyright 2005 Arca Solutions, Inc. All Rights Reserved.           #
	#                                                                    #
	# This file may not be redistributed in whole or part.               #
	# eDirectory is licensed on a per-domain basis.                      #
	#                                                                    #
	# ---------------- eDirectory IS NOT FREE SOFTWARE ----------------- #
	#                                                                    #
	# http://www.edirectory.com | http://www.edirectory.com/license.html #
	######################################################################
	\*==================================================================*/

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/code/mobilenotif.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST" && !DEMO_LIVE_MODE) {

        $_POST["title"] = trim($_POST["title"]);
		$_POST["title"] = preg_replace('/\s\s+/', ' ', $_POST["title"]);

		if (validate_form("mobilenotif", $_POST, $message_notification)) {

			$notification = new AppNotification($id);

			if (!$notification->getString("id") || $notification->getString("id") == 0) {
                
				$message = 0;
				$notification->makeFromRow($_POST);
				$newest = "1";

			} else {
				
				$message = 1;
				$notification->makeFromRow($_POST);

			}

			$notification->Save();

			header("Location: $url_redirect/index.php?process=".$process."&newest=".$newest."&message=".$message."&screen=$screen&letter=$letter".(($url_search_params) ? "&$url_search_params" : ""));
			exit;

		}

		// removing slashes added if required
		$_POST = format_magicQuotes($_POST);
		$_GET  = format_magicQuotes($_GET);

		extract($_POST);
		extract($_GET);

	}

	# ----------------------------------------------------------------------------------------------------
	# FORMS DEFINES
	# ----------------------------------------------------------------------------------------------------
	$id = $_GET["id"] ? $_GET["id"] : $_POST["id"];
	
	if ($id) {

        $notification = db_getFromDB("appnotification", "id", db_formatNumber($id), 1, "", "object", SELECTED_DOMAIN_ID);
        $notification->extract();

    } else {

        $notification = new AppNotification($id);
        $notification->makeFromRow($_POST);
        
	}

	extract($_POST);
	extract($_GET);   

	// if no expiration date, prefill the field within the current date
	if (!$expiration_date) {
		$today = date('Y-m-d');		
		$expiration_date = format_date($today);		
	}

	// Status Drop Down
	$statusObj = new ItemStatus();
	unset($arrayValue);
	unset($arrayName);
	$arrayValue = $statusObj->getValues();
	$arrayName = $statusObj->getNames();
	unset($arrayValueDD);
	unset($arrayNameDD);
	for ($i=0; $i<count($arrayValue); $i++) {
		if ($arrayValue[$i] != "E" && $arrayValue[$i] != "P") {
			$arrayValueDD[] = $arrayValue[$i];
			$arrayNameDD[] = $arrayName[$i];
		}
	}
	$statusDropDown = html_selectBox("status", $arrayNameDD, $arrayValueDD, $status, "", "", "-- ".system_showText(LANG_LABEL_SELECT_ALLSTATUS)." --");
    
    //Current Notification
    $currentNotif = $notification->getCurrent();
    
?>