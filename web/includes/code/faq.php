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
	# * FILE: /includes/code/faq.php
	# ----------------------------------------------------------------------------------------------------

	##########################################################################################################################
	# RESULTS
	##########################################################################################################################
	$where = "";
	$faq_limit = RESULTS_PER_PAGE;
	$where .= " ((question LIKE ".db_formatString("%".$keyword."%")." OR answer LIKE ".db_formatString("%".$keyword."%").") OR (MATCH (keyword) AGAINST (".db_formatString($keyword)." IN BOOLEAN MODE)))";
	if ((string_strpos($_SERVER["PHP_SELF"], "".MEMBERS_ALIAS.""))) {
        $paging_url = DEFAULT_URL."/".MEMBERS_ALIAS."/faq.php";
        $where .= " AND member = 'y' ";
        $faq_front = false;
	} else {
		if ((string_strpos($_SERVER["PHP_SELF"], "".SITEMGR_ALIAS.""))){
            $paging_url = DEFAULT_URL."/".SITEMGR_ALIAS."/faq.php";
            $where .= " AND sitemgr = 'y' ";
            $faq_front = false;
            $faq_limit = false;
		} else {
            $paging_url = DEFAULT_URL."/".ALIAS_FAQ_URL_DIVISOR.".php";
            $where .= " AND frontend = 'y' ";
            $faq_front = true;
		}
	}

	#############################################################################################################################
	#Page Browsing
	#############################################################################################################################
	$pageObj = new pageBrowsing("FAQ", $screen, $faq_limit, false, false, false, $where);
	$faqs = $pageObj->retrievePage("array");
	$array_search_params = array();
	foreach ($_GET as $name => $value) {
		if ($name != "screen" && $name != "letter"){
			$array_search_params[] = $name."=".$value;
		}
	}
	$url_search_params = implode("&amp;", $array_search_params);
	$pagesDropDown = $pageObj->getPagesDropDown($_GET, $paging_url, $screen, system_showText(LANG_PAGING_GOTOPAGE)." ", "this.form.submit();");

?>
