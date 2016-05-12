<?php

	/*==================================================================*\
	######################################################################
	#                                                                    #
	# Copyright 2015 Arca Solutions, Inc. All Rights Reserved.           #
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
	# * FILE: /sponsors/listing/backlinks.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();

	if (BACKLINK_FEATURE == "off") {
		header("Location: ".DEFAULT_URL."/".MEMBERS_ALIAS."/");
		exit;
	}

    # ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_GET);
	extract($_POST);

	$url_redirect = DEFAULT_URL."/".MEMBERS_ALIAS;
	$url_base = DEFAULT_URL."/".MEMBERS_ALIAS;
	$members = 1;

    if ($id) {
		$level = new ListingLevel();
		$listing = new Listing($id);
		if ($acctId != $listing->getNumber("account_id")) {
			header("Location: ".DEFAULT_URL."/".MEMBERS_ALIAS."/");
			exit;
		}
		$listingHasBacklink = $level->getBacklink($listing->getNumber("level"));
		if ((!$listingHasBacklink) || ($listingHasBacklink != "y")) {
			header("Location: ".DEFAULT_URL."/".MEMBERS_ALIAS);
			exit;
		}
	} else {
		header("Location: ".DEFAULT_URL."/".MEMBERS_ALIAS."/");
		exit;
	}

    # ----------------------------------------------------------------------------------------------------
    # CODE
    # ----------------------------------------------------------------------------------------------------
    include(EDIRECTORY_ROOT."/includes/code/backlinks.php");

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/header.php");

	# ----------------------------------------------------------------------------------------------------
	# NAVBAR
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/navbar.php");
?>

	<section class="top-search">

		<? include(EDIRECTORY_ROOT."/frontend/coverimage.php"); ?>

		<div class="well well-translucid">
			<div class="container">
				<br>
				<h2><?=system_showText(LANG_ADD)?> <?=system_showText(LANG_LISTING_FEATURE_NAME);?></h2>
				<br>
			</div>
		</div>
	</section>

	<section class="block">
		<div class="container">

			<? include(MEMBERS_EDIRECTORY_ROOT."/".LISTING_FEATURE_FOLDER."/navbar.php"); ?>

			<div class="well">

				<div class="media">

					<form name="backlinks" id="backlinks" method="post" action="<?=system_getFormAction($_SERVER["PHP_SELF"]);?>">

						<input type="hidden" name="id" value="<?=$id?>">
						<input type="hidden" id="backlinkValid" name="backlinkValid" value="0">

						<? include(EDIRECTORY_ROOT."/includes/forms/form_backlinks.php");?>
					</form>

				</div>
			</div>
		</div>
	</section>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	$customJS = MEMBERS_EDIRECTORY_ROOT."/scripts.php";
	include(MEMBERS_EDIRECTORY_ROOT."/layout/footer.php");