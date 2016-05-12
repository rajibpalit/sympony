<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/activity/review-comments/review/reply.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../../../conf/loadconfig.inc.php");

    # ----------------------------------------------------------------------------------------------------
    # UPDATE REPLY
    # ----------------------------------------------------------------------------------------------------
    
    # ----------------------------------------------------------------------------------------------------
    # SESSION
    # ----------------------------------------------------------------------------------------------------
    sess_validateSMSession();
    permission_hasSMPerm();
    
    if (string_strlen(trim($_GET['reply'])) > 0) {
        
        $reviewObj = new Review($_GET['idReview']);
        $reviewObj->setString("response", trim($_GET['reply']));
        $reviewObj->save();
        
        $message = 3;
        $response = "?class=success&message=$message";
    } else {
        $message = 4;
        $response = "?class=warning&message=$message";
    }
    
    $response .= ($_GET['filter_id'] ? '&filter_id=1&item_id='.$_GET['item_id'] : '')."&item_type=".$_GET['item_type']."&screen=".$_GET['screen']."&letter=".$_GET['letter'];
    header('Location: ' . DEFAULT_URL . '/'.SITEMGR_ALIAS.'/activity/reviews-comments/index.php'.$response);
    exit;

?>