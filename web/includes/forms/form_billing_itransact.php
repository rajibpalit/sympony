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
	# * FILE: /includes/forms/form_billing_itransact.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# INCLUDE
	# ----------------------------------------------------------------------------------------------------
	include(EDIRECTORY_ROOT."/conf/payment_itransact.inc.php");

	setting_get("payment_tax_status", $payment_tax_status);
	setting_get("payment_tax_value", $payment_tax_value);
	customtext_get("payment_tax_label", $payment_tax_label);

	if (ITRANSACTPAYMENT_FEATURE == "on") {

		if (!ITRANSACT_VENDORID) {
			echo "<p class=\"errorMessage\">".system_showText(LANG_ITRANSACT_NO_AVAILABLE)." <a href=\"".DEFAULT_URL."/".MEMBERS_ALIAS."/help.php\" class=\"billing-contact\">".system_showText(LANG_LABEL_ADMINISTRATOR)."</a>.</p>";
		} else {

			$itemCount = 1;

			$subtotal = 0;
			if ($bill_info["listings"]) foreach ($bill_info["listings"] as $id => $info) {

				$subtotal += $info["total_fee"];
				$listing_ids[] = $id;
				$listing_amounts[] = $info["total_fee"];

				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$info["title"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_id\" value=\"listing:$id\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".$info["total_fee"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";

				$itemCount++;

			}

			if ($bill_info["events"]) foreach ($bill_info["events"] as $id => $info) {

				$subtotal += $info["total_fee"];
				$event_ids[] = $id;
				$event_amounts[] = $info["total_fee"];

				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$info["title"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_id\" value=\"event:$id\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".$info["total_fee"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";

				$itemCount++;

			}

			if ($bill_info["banners"]) foreach ($bill_info["banners"] as $id => $info) {

				$subtotal += $info["total_fee"];
				$banner_ids[] = $id;
				$banner_amounts[] = $info["total_fee"];

				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$info["caption"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_id\" value=\"banner:$id\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".$info["total_fee"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";

				$itemCount++;

			}

			if ($bill_info["classifieds"]) foreach ($bill_info["classifieds"] as $id => $info) {

				$subtotal += $info["total_fee"];
				$classified_ids[] = $id;
				$classified_amounts[] = $info["total_fee"];

				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$info["title"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_id\" value=\"classified:$id\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".$info["total_fee"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";

				$itemCount++;

			}

			if ($bill_info["articles"]) foreach ($bill_info["articles"] as $id => $info) {

				$subtotal += $info["total_fee"];
				$article_ids[] = $id;
				$article_amounts[] = $info["total_fee"];

				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$info["title"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_id\" value=\"article:$id\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".$info["total_fee"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";

				$itemCount++;

			}

			if ($bill_info["custominvoices"]) foreach($bill_info["custominvoices"] as $id => $info) {

				$subtotal += $info["subtotal"];
				$custominvoice_ids[] = $id;
				$custominvoice_amounts[] = $info["subtotal"];

				$customInvoiceTitle = system_showTruncatedText($info["title"], 25);

				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$customInvoiceTitle."\" />
					<input type=\"hidden\" name=\"".$itemCount."_id\" value=\"custominvoice:$id\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".$info["subtotal"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";

				$itemCount++;
			}

			if ($bill_info["package"]) {

				$subtotal += $bill_info["package"]["value"];
				$package_ids[] = $bill_info["package"]["id"];
				$package_amounts[] = $bill_info["package"]["value"];

				$packageTitle = system_showTruncatedText($bill_info["package"]["title"], 25);

				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$packageTitle."\" />
					<input type=\"hidden\" name=\"".$itemCount."_id\" value=\"package:".$bill_info["package"]["id"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".$bill_info["package"]["value"]."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";

				$itemCount++;
			}

			/**
			 * Just For Tax Values
			 */
			if ($payment_tax_status == "on") {
				$cart_items .= "
					<input type=\"hidden\" name=\"".$itemCount."_desc\" value=\"".$payment_tax_label."\" />
					<input type=\"hidden\" name=\"".$itemCount."_cost\" value=\"".payment_calculateTax($subtotal, $payment_tax_value, true, false)."\" />
					<input type=\"hidden\" name=\"".$itemCount."_qty\" value=\"1\" />";
				$itemCount++;
			}

			$contactObj = new Contact(sess_getAccountIdFromSession());
			$amount = str_replace(",", ".", $bill_info["total_bill"]);
			if ($listing_ids) $listing_ids = implode(":", $listing_ids);
			if ($listing_amounts) $listing_amounts = implode(":", $listing_amounts);
			if ($event_ids) $event_ids = implode(":", $event_ids);
			if ($event_amounts) $event_amounts = implode(":", $event_amounts);
			if ($banner_ids) $banner_ids = implode(":", $banner_ids);
			if ($banner_amounts) $banner_amounts = implode(":", $banner_amounts);
			if ($classified_ids) $classified_ids = implode(":", $classified_ids);
			if ($classified_amounts) $classified_amounts = implode(":", $classified_amounts);
			if ($article_ids) $article_ids = implode(":", $article_ids);
			if ($article_amounts) $article_amounts = implode(":", $article_amounts);
			if ($custominvoice_ids) $custominvoice_ids = implode(":", $custominvoice_ids);
			if ($custominvoice_amounts) $custominvoice_amounts = implode(":", $custominvoice_amounts);
			$itransact_return_address = DEFAULT_URL."/".MEMBERS_ALIAS."/".$payment_process."/processpayment.php";
			$itransact_first_name = $contactObj->getString("first_name");
			$itransact_last_name = $contactObj->getString("last_name");
			$itransact_address = $contactObj->getString("address");
			$itransact_city = $contactObj->getString("city");
			$itransact_state = $contactObj->getString("state");
			$itransact_zip = $contactObj->getString("zip");
			$itransact_country = $contactObj->getString("country");
			$itransact_phone = $contactObj->getString("phone");
			$itransact_email = $contactObj->getString("email");

			if ($payment_tax_status == "on") {
				$_SESSION["itransact_tax_value"] = $payment_tax_value;
				$_SESSION["itransact_subtotal"] = $subtotal;
			} else {
				$_SESSION["itransact_tax_value"] = 0;
				$_SESSION["itransact_subtotal"] = $subtotal;
			}

			$_SESSION["domain_id"] = SELECTED_DOMAIN_ID;
			$_SESSION["package_id"] = $package_id;

			?>

			<script type="text/javascript">
				<!--
				function submitOrder() {
					document.getElementById("itransactbutton").disabled = true;
					document.itransactform.submit();
				}
				//-->
			</script>


			<form name="itransactform" target="_self" action="<?=ITRANSACT_HOST?>" method="post">

				<div style="display: none;">

					<input type="hidden" name="vendor_id" value="<?=ITRANSACT_VENDORID?>" />
					<input type="hidden" name="home_page" value="<?=DEFAULT_URL?>" />
					<input type="hidden" name="ret_addr"  value="<?=$itransact_return_address?>" />

					<input type="hidden" name="mername"     value="<?=EDIRECTORY_TITLE?>" />
					<input type="hidden" name="formtype"    value="2" />
					<input type="hidden" name="acceptcards" value="1" />

					<input type="hidden" name="items" value="<?=($itemCount-1)?>" />

					<?=$cart_items;?>

					<input type="hidden" name="lookup" value="authcode" />
					<input type="hidden" name="lookup" value="cc_last_four" />
					<input type="hidden" name="lookup" value="ck_last_four" />
					<input type="hidden" name="lookup" value="cc_name" />
					<input type="hidden" name="lookup" value="total" />
					<input type="hidden" name="lookup" value="test_mode" />
					<input type="hidden" name="lookup" value="when" />
					<input type="hidden" name="lookup" value="xid" />
					<input type="hidden" name="lookup" value="avs_response" />
					<input type="hidden" name="lookup" value="cvv2_response" />
					<input type="hidden" name="lookup" value="confemail" />

					<input type="hidden" name="passback"       value="payment_method" />
					<input type="hidden" name="payment_method" value="<?=$payment_method?>" />

					<input type="hidden" name="passback" value="ordernum" />
					<input type="hidden" name="ordernum" value="<?=uniqid(0);?>" />

					<input type="hidden" name="passback"        value="listing_ids" />
					<input type="hidden" name="listing_ids"     value="<?=$listing_ids?>" />
					<input type="hidden" name="passback"        value="listing_amounts" />
					<input type="hidden" name="listing_amounts" value="<?=$listing_amounts?>" />

					<input type="hidden" name="passback"      value="event_ids" />
					<input type="hidden" name="event_ids"     value="<?=$event_ids?>" />
					<input type="hidden" name="passback"      value="event_amounts" />
					<input type="hidden" name="event_amounts" value="<?=$event_amounts?>">

					<input type="hidden" name="passback"       value="banner_ids" />
					<input type="hidden" name="banner_ids"     value="<?=$banner_ids?>" />
					<input type="hidden" name="passback"       value="banner_amounts" />
					<input type="hidden" name="banner_amounts" value="<?=$banner_amounts?>" />

					<input type="hidden" name="passback"           value="classified_ids" />
					<input type="hidden" name="classified_ids"     value="<?=$classified_ids?>" />
					<input type="hidden" name="passback"           value="classified_amounts" />
					<input type="hidden" name="classified_amounts" value="<?=$classified_amounts?>" />

					<input type="hidden" name="passback"        value="article_ids" />
					<input type="hidden" name="article_ids"     value="<?=$article_ids?>" />
					<input type="hidden" name="passback"        value="article_amounts" />
					<input type="hidden" name="article_amounts" value="<?=$article_amounts?>" />

					<input type="hidden" name="passback"              value="custominvoice_ids" />
					<input type="hidden" name="custominvoice_ids"     value="<?=$custominvoice_ids?>" />
					<input type="hidden" name="passback"              value="custominvoice_amounts" />
					<input type="hidden" name="custominvoice_amounts" value="<?=$custominvoice_amounts?>" />

				</div>

				<div class="col-sm-8 col-sm-offset-2 well">
					<h3>
						<?=string_ucwords(system_showText(LANG_LABEL_GENERAL_INFORMATION));?>
					</h3>
					<div class="row">
						<div class="form-group col-sm-6">
							<label><?=system_showText(LANG_LABEL_FIRST_NAME);?>:</label>
							<input class="form-control" type="text" name="first_name" value="<?=$itransact_first_name?>" />
						</div>
						<div class="form-group col-sm-6">
							<label><?=system_showText(LANG_LABEL_LAST_NAME);?>:</label>
							<input class="form-control" type="text" name="last_name" value="<?=$itransact_last_name?>" />
						</div>
						<div class="form-group col-sm-6">
							<label><?=system_showText(LANG_LABEL_PHONE_NUMBER)?>:</label>
							<input class="form-control" type="text" name="phone" value="<?=$itransact_phone?>" />
						</div>
						<div class="form-group col-sm-6">
							<label><?=system_showText(LANG_LABEL_EMAIL_ADDRESS)?>:</label>
							<input class="form-control" type="text" name="email" value="<?=$itransact_email?>" />
						</div>
						<div class="form-group col-sm-12">
							<label><?=system_showText(LANG_LABEL_ADDRESS);?>:</label>
							<input class="form-control" type="text" name="address" value="<?=$itransact_address?>" />
						</div>
						<div class="form-group col-sm-6">
							<label><?=system_showText(LANG_LABEL_CITY)?>:</label>
							<input class="form-control" type="text" name="city" value="<?=$itransact_city?>" />
						</div>
						<div class="form-group col-sm-6">
							<label><?=system_showText(LANG_LABEL_STATE)?>:</label>
							<input class="form-control" type="text" name="state" value="<?=$itransact_state?>" />
						</div>
						<div class="form-group col-sm-6">
							<label><?=string_ucwords(system_showText(LANG_LABEL_ZIP))?>:</label>
							<input class="form-control" type="text" name="zip" value="<?=$itransact_zip?>" />
						</div>
						<div class="form-group col-sm-6">
							<label><?=system_showText(LANG_LABEL_COUNTRY)?>:</label>
							<input class="form-control" type="text" name="country" value="<?=(($itransact_country) ? ($itransact_country) : ("USA"))?>" />
						</div>
					</div>
				</div>
				<div class="col-sm-8 col-sm-offset-2 well">
					<h3>
						<?=string_ucwords(system_showText(LANG_LABEL_CREDIT_CARD_INFORMATION))?>
					</h3>
					<div class="row">
						<div class="form-group col-sm-4">
							<label>* <?=system_showText(LANG_LABEL_CARD_NUMBER);?>:</label>
							<input class="form-control" type="text" name="ccnum" value="" />
						</div>
						<div class="form-group col-sm-8">
							<label>* <?=system_showText(LANG_LABEL_EXP_DATE);?>:</label>
							<? $all_months = explode(",", LANG_DATE_MONTHS); ?>
							<div class="row">
								<div class="col-sm-7">
									<select class="form-control" NAME="ccmo">
										<option value=""></option>
										<option value="January"><?=$all_months[0];?></option>
										<option value="February"><?=$all_months[1];?></option>
										<option value="March"><?=$all_months[2];?></option>
										<option value="April"><?=$all_months[3];?></option>
										<option value="May"><?=$all_months[4];?></option>
										<option value="June"><?=$all_months[5];?></option>
										<option value="July"><?=$all_months[6];?></option>
										<option value="August"><?=$all_months[7];?></option>
										<option value="September"><?=$all_months[8];?></option>
										<option value="October"><?=$all_months[9];?></option>
										<option value="November"><?=$all_months[10];?></option>
										<option value="December"><?=$all_months[11];?></option>
									</select>
								</div>
								<div class="col-sm-5">
									<select class="form-control" name="ccyr">
										<option value=""></option>
										<?
										$todayyear = date("Y");
										for ($i=0; $i<15; $i++) {
											echo "<option value=\"".($todayyear+$i)."\">".($todayyear+$i)."</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<? if ($payment_process == "signup") {

                    $buttonGateway = "<button class=\"btn btn-success btn-lg\" type=\"button\" id=\"itransactbutton\" onclick=\"submitOrder();\">".system_highlightWords(system_showText(LANG_LABEL_PLACE_ORDER_CONTINUE))."</button>";

                } else { ?>
					<p class="row text-center">
						<button class="btn btn-success" type="button" id="itransactbutton" onclick="submitOrder();"><?=system_showText(LANG_BUTTON_PAY_BY_CREDIT_CARD);?></button>
					</p>
				<? } ?>

			</form>

			<?

		}

	}

?>
