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
	# * FILE: /includes/forms/form_facebooklogin.php
	# ----------------------------------------------------------------------------------------------------

	Facebook::getFBInstance($facebook);

	if (!isset($urlRedirect)) {
		$urlRedirect = "?destiny=".urlencode(DEFAULT_URL.str_replace(EDIRECTORY_FOLDER, "", $_SERVER["REQUEST_URI"]));
	}

	/*
	 * Workaround to pin a bookmark without login
	 */
	if ($_GET['bookmark_remember']) {
		$urlRedirect .= '&bookmark_remember=' . $_GET['bookmark_remember'];
	}

	/*
	 * Workaround for make a redeem without login
	 */
	if ($_GET['redeem_remember']) {
		$urlRedirect .= '&redeem_remember=' . $_GET['redeem_remember'];
	}

	$loginParams = array(
		"redirect_uri"		=> FACEBOOK_REDIRECT_URI.$urlRedirect,
		"scope"				=> FACEBOOK_PERMISSION_SCOPE
	);

    if (!$fbLabel) {
        if (string_strpos($_SERVER["PHP_SELF"], "order") !== false || string_strpos($_SERVER["REQUEST_URI"], ALIAS_CLAIM_URL_DIVISOR."/") !== false) {
            $fbLabel = "Facebook";
        } else {
            $fbLabel = system_showText(LANG_LOGINFACEBOOKUSER);
        }
    }

    if ($linkAttachFB) { ?>

		<p class="text-center">
			<a href="<?=$facebook->getLoginUrl($loginParams);?>" class="btn btn-facebook btn-sm btn-block"><span class="fa fa-facebook"></span> <?=system_showText(LANG_LABEL_LINK_FACEBOOK);?></a>
		</p>

    <? } else { ?>

        <a <?=($isPopUP ? "target=\"_top\"" : "")?> href="<?=$facebook->getLoginUrl($loginParams);?>" class="btn btn-facebook btn-block"><span class="fa fa-facebook"> </span> <?=$fbLabel?></a>

    <? } ?>
