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
	# FILE: /includes/forms/form_billing_psigate.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# INCLUDE
	# ----------------------------------------------------------------------------------------------------
	include(EDIRECTORY_ROOT."/conf/payment_psigate.inc.php");

	setting_get("payment_tax_status", $payment_tax_status);
	setting_get("payment_tax_value", $payment_tax_value);

	if (PSIGATEPAYMENT_FEATURE == "on") {

		if (!PSIGATE_STOREID || !PSIGATE_PASSPHRASE) {
			echo "<p class=\"errorMessage\">".system_showText(LANG_PSIGATE_NO_AVAILABLE)." <a href=\"".DEFAULT_URL."/".MEMBERS_ALIAS."/help.php\" class=\"billing-contact\">".system_showText(LANG_LABEL_ADMINISTRATOR)."</a>.</p>";
		} else {

			if ($bill_info["listings"]) foreach ($bill_info["listings"] as $id => $info) {
				$listing_ids[] = $id;
				$listing_amounts[] = $info["total_fee"];
			}

			if ($bill_info["events"]) foreach ($bill_info["events"] as $id => $info) {
				$event_ids[] = $id;
				$event_amounts[] = $info["total_fee"];
			}

			if ($bill_info["banners"]) foreach ($bill_info["banners"] as $id => $info) {
				$banner_ids[] = $id;
				$banner_amounts[] = $info["total_fee"];
			}

			if ($bill_info["classifieds"]) foreach ($bill_info["classifieds"] as $id => $info) {
				$classified_ids[] = $id;
				$classified_amounts[] = $info["total_fee"];
			}

			if ($bill_info["articles"]) foreach ($bill_info["articles"] as $id => $info) {
				$article_ids[] = $id;
				$article_amounts[] = $info["total_fee"];
			}

			if ($bill_info["custominvoices"]) foreach($bill_info["custominvoices"] as $id => $info) {
				$custominvoice_ids[] = $id;
				$custominvoice_amounts[] = $info["subtotal"];
			}

			$contactObj = new Contact(sess_getAccountIdFromSession());
			if ($listing_ids) $listing_ids = implode("::",$listing_ids);
			if ($listing_amounts) $listing_amounts = implode("::",$listing_amounts);
			if ($event_ids) $event_ids = implode("::",$event_ids);
			if ($event_amounts) $event_amounts = implode("::",$event_amounts);
			if ($banner_ids) $banner_ids = implode("::",$banner_ids);
			if ($banner_amounts) $banner_amounts = implode("::",$banner_amounts);
			if ($classified_ids) $classified_ids = implode("::",$classified_ids);
			if ($classified_amounts) $classified_amounts = implode("::",$classified_amounts);
			if ($article_ids) $article_ids = implode("::",$article_ids);
			if ($article_amounts) $article_amounts = implode("::",$article_amounts);
			if ($custominvoice_ids) $custominvoice_ids = implode("::",$custominvoice_ids);
			if ($custominvoice_amounts) $custominvoice_amounts = implode("::",$custominvoice_amounts);
			$psigate_x_subtotal = str_replace(",", ".", $bill_info["total_bill"]);
			$psigate_x_bname = $contactObj->getString("first_name")." ".$contactObj->getString("last_name");
			$psigate_x_bcompany = $contactObj->getString("company");
			$psigate_x_baddress1 = $contactObj->getString("address");
			$psigate_x_baddress2 = $contactObj->getString("address2");
			$psigate_x_bcity = $contactObj->getString("city");
			$psigate_x_bprovince = $contactObj->getString("state");
			$psigate_x_bpostalcode = $contactObj->getString("zip");
			$psigate_x_bcountry = $contactObj->getString("country");
			$psigate_x_phone = $contactObj->getString("phone");
			$psigate_x_fax = $contactObj->getString("fax");
			$psigate_x_email = $contactObj->getString("email");

			?>

			<script type="text/javascript">
				<!--
				function submitOrder() {
					document.getElementById("psigatebutton").disabled = true;
					document.psigateform.submit();
				}
				//-->
			</script>

			<form name="psigateform" target="_self" action="<?=DEFAULT_URL?>/<?=MEMBERS_ALIAS?>/<?=$payment_process?>/processpayment.php?payment_method=<?=$payment_method?>" method="post">

				<div style="display: none;">

					<?
					$subtotal = $psigate_x_subtotal;
					$_SESSION["psigate_subtotal"] = $subtotal;
					if ($payment_tax_status == "on") {
						$_SESSION["psigate_tax"] = $payment_tax_value;
						$taxAmount = payment_calculateTax($subtotal, $payment_tax_value, true, false);
					} else {
						$_SESSION["psigate_tax"] = 0;
					}
					?>

					<input type="hidden" name="pay" value="1" />

					<input type="hidden" name="x_listing_ids" value="<?=$listing_ids?>" />
					<input type="hidden" name="x_listing_amounts" value="<?=$listing_amounts?>" />
					<input type="hidden" name="x_event_ids" value="<?=$event_ids?>" />
					<input type="hidden" name="x_event_amounts" value="<?=$event_amounts?>" />
					<input type="hidden" name="x_banner_ids" value="<?=$banner_ids?>" />
					<input type="hidden" name="x_banner_amounts" value="<?=$banner_amounts?>" />
					<input type="hidden" name="x_classified_ids" value="<?=$classified_ids?>" />
					<input type="hidden" name="x_classified_amounts" value="<?=$classified_amounts?>" />
					<input type="hidden" name="x_article_ids" value="<?=$article_ids?>" />
					<input type="hidden" name="x_article_amounts" value="<?=$article_amounts?>" />
					<input type="hidden" name="x_custominvoice_ids" value="<?=$custominvoice_ids?>" />
					<input type="hidden" name="x_custominvoice_amounts" value="<?=$custominvoice_amounts?>" />
					<input type="hidden" name="x_taxtotal" value="<?=$taxAmount?>" />
					<input type="hidden" name="x_subtotal" value="<?=$psigate_x_subtotal?>" />
					<input type="hidden" name="x_package_id" value="<?=$package_id?>" />
				</div>

				<div class="col-sm-8 col-sm-offset-2 well">

					<h3>
						<?=system_showText(LANG_LABEL_BILLING_INFO);?>
					</h3>

                    <div class="row">

                        <div class="form-group col-sm-5">
                            <label><?=system_showText(LANG_LABEL_CARD_NUMBER);?>:</label>
                            <input class="form-control" type="text" name="x_card_number" value="" />
                        </div>

                        <div class="form-group col-sm-4">

                            <label><?=system_showText(LANG_LABEL_CARD_EXPIRE_DATE);?>:</label>

                            <div class="row">
                                <div class="col-sm-7">
                                    <select class="form-control" name="x_card_exp_month">
                                        <option value=""></option>
                                        <?
                                        for ($i=1; $i<=12; $i++) {
                                            if (string_strlen($i) < 2) echo "<option value=\"0".$i."\">0".$i."</option>";
                                            else echo "<option value=\"".$i."\">".$i."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <div></div>
                                    <select class="form-control" name="x_card_exp_year">
                                        <option value=""></option>
                                        <?
                                        for ($i=date("y"); $i<=date("y")+10; $i++) {
                                            if (string_strlen($i) < 2) echo "<option value=\"0".$i."\">0".$i."</option>";
                                            else echo "<option value=\"".$i."\">".$i."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <p class="help-block"><?=system_showText(LANG_LETTER_MONTH).system_showText(LANG_LETTER_MONTH)."/".system_showText(LANG_LETTER_YEAR).system_showText(LANG_LETTER_YEAR);?></p>

                        </div>

                        <div class="form-group col-sm-3">
                            <label><?=system_showText(LANG_LABEL_CARD_CODE);?>:</label>
                                <input class="form-control" type="text" name="x_card_id_number" value="" />
                            </div>
                        </div>

                    </div>

					<div class="col-sm-8 col-sm-offset-2 well">

                        <h3>
                            <?=system_showText(LANG_LABEL_CUSTOMER_INFO);?>
                        </h3>
						<div class="row">
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_NAME);?>:</label>
                                <input class=form-control type="text" name="x_bname" value="<?=$psigate_x_bname?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_COMPANY);?>:</label>
                                <input class="form-control" type="text" name="x_bcompany" value="<?=$psigate_x_bcompany?>" />
                            </div>
                            <div class="form-group col-sm-12">
                                <label><?=system_showText(LANG_LABEL_EMAIL);?>:</label>
                                <input class="form-control" type="text" name="x_email" value="<?=$psigate_x_email?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_ADDRESS1);?>:</label>
                                <input class="form-control" type="text" name="x_baddress1" value="<?=$psigate_x_baddress1?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_ADDRESS2);?>:</label>
                                <input class="form-control" type="text" name="x_baddress2" value="<?=$psigate_x_baddress2?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_CITY)?>:</label>
                                <input class="form-control"  type="text" name="x_bcity" value="<?=$psigate_x_bcity?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_PROVINCE);?>:</label>
                                <input class="form-control" type="text" name="x_bprovince" value="<?=$psigate_x_bprovince?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_POSTAL_CODE);?>:</label>
                                <input class="form-control" type="text" name="x_bpostalcode" value="<?=$psigate_x_bpostalcode?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_COUNTRY)?>:</label>

                                    <?
                                    $countries = array(
                                        "AF" => "Afghanistan",
                                        "AL" => "Albania",
                                        "DZ" => "Algeria",
                                        "AS" => "American Samoa",
                                        "AD" => "Andorra",
                                        "AO" => "Angola",
                                        "AI" => "Anguilla",
                                        "AQ" => "Antarctica",
                                        "AG" => "Antigua And Barbuda",
                                        "AR" => "Argentina",
                                        "AM" => "Armenia",
                                        "AW" => "Aruba",
                                        "AU" => "Australia",
                                        "AT" => "Austria",
                                        "AZ" => "Azerbaijan",
                                        "BS" => "Bahamas",
                                        "BH" => "Bahrain",
                                        "BD" => "Bangladesh",
                                        "BB" => "Barbados",
                                        "BY" => "Belarus",
                                        "BE" => "Belgium",
                                        "BZ" => "Belize",
                                        "BJ" => "Benin",
                                        "BM" => "Bermuda",
                                        "BT" => "Bhutan",
                                        "BO" => "Bolivia",
                                        "BA" => "Bosnia And Herzegowina",
                                        "BW" => "Botswana",
                                        "BV" => "Bouvet Island",
                                        "BR" => "Brazil",
                                        "IO" => "British Indian Ocean Territory",
                                        "BN" => "Brunei Darussalam",
                                        "BG" => "Bulgaria",
                                        "BF" => "Burkina Faso",
                                        "BI" => "Burundi",
                                        "KH" => "Cambodia",
                                        "CM" => "Cameroon",
                                        "CA" => "Canada",
                                        "CV" => "Cape Verde",
                                        "KY" => "Cayman Islands",
                                        "CF" => "Central African Republic",
                                        "TD" => "Chad",
                                        "CL" => "Chile",
                                        "CN" => "China",
                                        "CX" => "Christmas Island",
                                        "CC" => "Cocos (Keeling) Islands",
                                        "CO" => "Colombia",
                                        "KM" => "Comoros",
                                        "CG" => "Congo",
                                        "CK" => "Cook Islands",
                                        "CR" => "Costa Rica",
                                        "CI" => "Cote D'Ivoire",
                                        "HR" => "Croatia",
                                        "CU" => "Cuba",
                                        "CY" => "Cyprus",
                                        "CZ" => "Czech Republic",
                                        "DK" => "Denmark",
                                        "DJ" => "Djibouti",
                                        "DM" => "Dominica",
                                        "DO" => "Dominican Republic",
                                        "TP" => "East Timor",
                                        "EC" => "Ecuador",
                                        "EG" => "Egypt",
                                        "SV" => "El Salvador",
                                        "GQ" => "Equatorial Guinea",
                                        "ER" => "Eritrea",
                                        "EE" => "Estonia",
                                        "ET" => "Ethiopia",
                                        "FK" => "Falkland Islands",
                                        "FO" => "Faroe Islands",
                                        "FJ" => "Fiji",
                                        "FI" => "Finland",
                                        "FR" => "France",
                                        "FX" => "France, Metropolitan",
                                        "GF" => "French Guiana",
                                        "PF" => "French Polynesia",
                                        "TF" => "French Southern Territories",
                                        "GA" => "Gabon",
                                        "GM" => "Gambia",
                                        "GE" => "Georgia",
                                        "DE" => "Germany",
                                        "GH" => "Ghana",
                                        "GI" => "Gibraltar",
                                        "GR" => "Greece",
                                        "GL" => "Greenland",
                                        "GD" => "Grenada",
                                        "GP" => "Guadeloupe",
                                        "GU" => "Guam",
                                        "GT" => "Guatemala",
                                        "GN" => "Guinea",
                                        "GW" => "Guinea-Bissau",
                                        "GY" => "Guyana",
                                        "HT" => "Haiti",
                                        "HM" => "Heard And Mc Donald Islands",
                                        "HN" => "Honduras",
                                        "HK" => "Hong Kong",
                                        "HU" => "Hungary",
                                        "IS" => "Iceland",
                                        "IN" => "India",
                                        "ID" => "Indonesia",
                                        "IR" => "Iran",
                                        "IQ" => "Iraq",
                                        "IE" => "Ireland",
                                        "IL" => "Israel",
                                        "IT" => "Italy",
                                        "JM" => "Jamaica",
                                        "JP" => "Japan",
                                        "JO" => "Jordan",
                                        "KZ" => "Kazakhstan",
                                        "KE" => "Kenya",
                                        "KI" => "Kiribati",
                                        "KP" => "North Korea",
                                        "KR" => "South Korea",
                                        "KW" => "Kuwait",
                                        "KG" => "Kyrgyzstan",
                                        "LA" => "Lao People's Republic",
                                        "LV" => "Latvia",
                                        "LB" => "Lebanon",
                                        "LS" => "Lesotho",
                                        "LR" => "Liberia",
                                        "LY" => "Libyan Arab Jamahiriya",
                                        "LI" => "Liechtenstein",
                                        "LT" => "Lithuania",
                                        "LU" => "Luxembourg",
                                        "MO" => "Macau",
                                        "MK" => "Macedonia",
                                        "MG" => "Madagascar",
                                        "MW" => "Malawi",
                                        "MY" => "Malaysia",
                                        "MV" => "Maldives",
                                        "ML" => "Mali",
                                        "MT" => "Malta",
                                        "MH" => "Marshall Islands",
                                        "MQ" => "Martinique",
                                        "MR" => "Mauritania",
                                        "MU" => "Mauritius",
                                        "YT" => "Mayotte",
                                        "MX" => "Mexico",
                                        "FM" => "Micronesia",
                                        "MD" => "Moldova",
                                        "MC" => "Monaco",
                                        "MN" => "Mongolia",
                                        "MS" => "Montserrat",
                                        "MA" => "Morocco",
                                        "MZ" => "Mozambique",
                                        "MM" => "Myanmar",
                                        "NA" => "Namibia",
                                        "NR" => "Nauru",
                                        "NP" => "Nepal",
                                        "NL" => "Netherlands",
                                        "AN" => "Netherlands Antilles",
                                        "NC" => "New Caledonia",
                                        "NZ" => "New Zealand",
                                        "NI" => "Nicaragua",
                                        "NE" => "Niger",
                                        "NG" => "Nigeria",
                                        "NU" => "Niue",
                                        "NF" => "Norfolk Island",
                                        "MP" => "Northern Mariana Islands",
                                        "NO" => "Norway",
                                        "OM" => "Oman",
                                        "PK" => "Pakistan",
                                        "PW" => "Palau",
                                        "PA" => "Panama",
                                        "PG" => "Papua New Guinea",
                                        "PY" => "Paraguay",
                                        "PE" => "Peru",
                                        "PH" => "Philippines",
                                        "PN" => "Pitcairn",
                                        "PL" => "Poland",
                                        "PT" => "Portugal",
                                        "PR" => "Puerto Rico",
                                        "QA" => "Qatar",
                                        "RE" => "Reunion",
                                        "RO" => "Romania",
                                        "RU" => "Russian Federation",
                                        "RW" => "Rwanda",
                                        "KN" => "Saint Kitts And Nevis",
                                        "LC" => "Saint Lucia",
                                        "VC" => "Saint Vincent And The Grenadines",
                                        "WS" => "Samoa",
                                        "SM" => "San Marino",
                                        "ST" => "Sao Tome And Principe",
                                        "SA" => "Saudi Arabia",
                                        "SN" => "Senegal",
                                        "SC" => "Seychelles",
                                        "SL" => "Sierra Leone",
                                        "SG" => "Singapore",
                                        "SK" => "Slovakia",
                                        "SI" => "Slovenia",
                                        "SB" => "Solomon Islands",
                                        "SO" => "Somalia",
                                        "ZA" => "South Africa",
                                        "GS" => "South Georgia &amp; South Sandwich Islands",
                                        "ES" => "Spain",
                                        "LK" => "Sri Lanka",
                                        "SH" => "St Helena",
                                        "PM" => "St Pierre and Miquelon",
                                        "SD" => "Sudan",
                                        "SR" => "Suriname",
                                        "SJ" => "Svalbard And Jan Mayen Islands",
                                        "SZ" => "Swaziland",
                                        "SE" => "Sweden",
                                        "CH" => "Switzerland",
                                        "SY" => "Syrian Arab Republic",
                                        "TW" => "Taiwan",
                                        "TJ" => "Tajikistan",
                                        "TZ" => "Tanzania",
                                        "TH" => "Thailand",
                                        "TG" => "Togo",
                                        "TK" => "Tokelau",
                                        "TO" => "Tonga",
                                        "TT" => "Trinidad And Tobago",
                                        "TN" => "Tunisia",
                                        "TR" => "Turkey",
                                        "TM" => "Turkmenistan",
                                        "TC" => "Turks And Caicos Islands",
                                        "TV" => "Tuvalu",
                                        "UG" => "Uganda",
                                        "UA" => "Ukraine",
                                        "AE" => "United Arab Emirates",
                                        "GB" => "United Kingdom/Great Britain",
                                        "US" => "United States",
                                        "UM" => "United States Minor Outlying Islands",
                                        "UY" => "Uruguay",
                                        "UZ" => "Uzbekistan",
                                        "VU" => "Vanuatu",
                                        "VA" => "Vatican City State",
                                        "VE" => "Venezuela",
                                        "VN" => "Viet Nam",
                                        "VG" => "Virgin Islands (British)",
                                        "VI" => "Virgin Islands (U.S.)",
                                        "WF" => "Wallis And Futuna Islands",
                                        "EH" => "Western Sahara",
                                        "YE" => "Yemen",
                                        "ZR" => "Zaire",
                                        "ZM" => "Zambia",
                                        "ZW" => "Zimbabwe",
                                        "ZZ" => "Other-Not Shown"
                                    );
                                    ?>
                                    <select class="form-control" name="x_bcountry" class="select-country">
                                        <option value=""></option>
                                        <?
                                        foreach ($countries as $country_code => $country_name) {
                                            if (($psigate_x_bcountry == $country_code) || ($psigate_x_bcountry == $country_name)) $selected = "selected";
                                            else $selected = "";
                                            echo "<option ".$selected." value=\"".$country_code."\">".$country_name."</option>";
                                        }
                                        ?>
                                    </select>

                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_PHONE)?>:</label>
                                <input class="form-control" type="text" name="x_phone" value="<?=$psigate_x_phone?>" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label><?=system_showText(LANG_LABEL_FAX)?>:</label>
                                <input class="form-control" type="text" name="x_fax" value="<?=$psigate_x_fax?>" />
                            </div>
						</div>
				</div>

				<? if ($payment_process == "signup") {

                    $buttonGateway = "<button class=\"btn btn-success\"  type=\"button\" id=\"psigatebutton\" onclick=\"submitOrder();\">".system_highlightWords(system_showText(LANG_LABEL_PLACE_ORDER_CONTINUE))."</button>";

                } else { ?>
					<p class="row text-center">
						<button class="btn btn-success" type="button" id="psigatebutton" onclick="submitOrder();"><?=system_showText(LANG_BUTTON_PAY_BY_CREDIT_CARD);?></button>
					</p>
				<? } ?>

			</form>

			<?

		}

	}

?>
