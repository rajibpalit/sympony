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
	# * FILE: /sponsors/billing/processpayment.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# VALIDATE FEATURE
	# ----------------------------------------------------------------------------------------------------
	if (PAYMENT_FEATURE != "on") { exit; }
	if (CREDITCARDPAYMENT_FEATURE != "on") { exit; }

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_GET);
	extract($_POST);

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	if ($payment_method != "payflow" && !$_POST["USER1"]) {
		sess_validateSession();
	}

	$acctId = sess_getAccountIdFromSession();
	$url_redirect = "".DEFAULT_URL."/".MEMBERS_ALIAS."/billing";
	$url_base = "".DEFAULT_URL."/".MEMBERS_ALIAS."";

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	include(INCLUDES_DIR."/code/billing_".$payment_method.".php");

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/header.php");
?>

	<section class="top-search">

		<? include(EDIRECTORY_ROOT."/frontend/coverimage.php"); ?>

		<div class="well well-translucid">
			<div class="container">
				<br>
				<h2><?=system_showText(LANG_LABEL_TRANSACTION_STATUS)?></h2>
				<br>
			</div>
		</div>
	</section>

	<main>
		<section class="block">
			<div class="container">

				<div class="well">
					<?
					if ($payment_success == "y") {
						$contentObj = new Content();
						$content = $contentObj->retrieveContentByType("Transaction");
						if ($content) {
							echo "<div class=\"dynamicContent\">".$content."</div>";
						}
					}
					?>

					<? if ($payment_message) { ?>
						<?=urldecode($payment_message)?>
					<? } ?>

					<?
					if ($payment_success == "y") {
						$contentObj = new Content();
						$content = $contentObj->retrieveContentByType("Transaction Bottom");
						if ($content) {
							echo "<div class=\"dynamicContent\">".$content."</div>";
						}
					}
					?>

				</div>
			</div>
		</section>
	</main>

<?php
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/footer.php");