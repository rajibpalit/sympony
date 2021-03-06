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
	# * FILE: /includes/forms/form_eventlevel.php
	# ----------------------------------------------------------------------------------------------------

	setting_get("payment_tax_status", $payment_tax_status);
	setting_get("payment_tax_value", $payment_tax_value);
	customtext_get("payment_tax_label", $payment_tax_label);

	$levelObj = new EventLevel();
	$levelValue = $levelObj->getValues();
	unset($strArray);
	foreach ($levelValue as $value) {
		$strAux = "<div class=\"plan-box\"><div class=\"plan-title\">".$levelObj->showLevel($value).":</div><div class=\"plan-info\"><mark>";
		if ($levelObj->getPrice($value) > 0) {
			$strAux .= CURRENCY_SYMBOL . $levelObj->getPrice($value);
		} else {
			$strAux .= CURRENCY_SYMBOL . system_showText(LANG_LABEL_FREE);
		}
		$strAux .= "</mark><p class=\"small\"> ";
		if ($levelObj->getPrice($value) > 0) {
				$strAux .= " ".system_showText(LANG_PER)." ";
				if (payment_getRenewalCycle("event") > 1) {
					$strAux .= payment_getRenewalCycle("event")." ";
					$strAux .= payment_getRenewalUnitName("event")."s";
				} else {
					$strAux .= payment_getRenewalUnitName("event");
				}
		} else {
			$strAux .= "&nbsp;";
		}
		$strAux .= "</p></div></div>";
		$strArray[] = $strAux;
	}

?>

	<h3 class="text-uppercase text-center"><?=system_showText(LANG_LABEL_PRICE_PLURAL);?></h3>
	<section class="block">
		<div class="plans-container">
			<? echo implode("", $strArray); ?>
		</div>

		<?
			if ($payment_tax_status == "on") { ?>
				<p class="text-center"><br>
				   <? echo " (+".$payment_tax_value."% ".$payment_tax_label.")"; ?>
				</p>
			<? }
		?>

	</section>

	<h3 class="theme-title"><?=system_showText(LANG_MENU_SELECT_EVENT_LEVEL)?></h3>

	<? if ((!$event) || (($event) && ($event->needToCheckOut())) || (string_strpos($url_base, "/".SITEMGR_ALIAS."")) || (($event) && ($event->getPrice() <= 0))) { ?>
	<div class="row text-center">
		<div class="form-group">
		<?
		$levelvalues = $levelObj->getLevelValues();
		foreach ($levelvalues as $levelvalue) { ?>
			<div class="radio-inline">
			   <label>
				   <input type="radio" name="level" value="<?=$levelvalue?>" <? if ($levelArray[$levelObj->getLevel($levelvalue)]) echo "checked"; ?> />
					<?=$levelObj->showLevel($levelvalue)?>
				</label>
			</div>
		<? } ?>
		</div>
	</div>
	<? } else { ?>

		<p>
			<?=string_ucwords($levelObj->getLevel($level));?>
			<input type="hidden" name="level" value="<?=$level?>" />
		</p>

	<? } ?>