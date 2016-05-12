<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-email2.php
	# ----------------------------------------------------------------------------------------------------
?>

	<input type="hidden" name="content_type" value="<?=$content_type?>" />
	<input type="hidden" name="bcc" value="<?=$bcc?>" />
	<input type="hidden" name="subject" value="<?=$subject?>" />
	<input type="hidden" name="body" value="<?=$body?>" />
	<? if ($id == 36){
	
		foreach ($levelValue as $value) { ?>
	
		<input type="hidden" name="email_traffic_listing_<?=$value?>" value="<?=${"email_traffic_listing_".$value}?>">
		
		<? }
		
	} ?>
	<?
	if ($deactivate) {
		echo "<input type=\"hidden\" name=\"deactivate\" value=\"1\" >\n";
	} else {
		echo "<input type=\"hidden\" name=\"deactivate\" value=\"\" >\n";
	}
	?>

	<?

	if ($content_type == "text/plain") {
		$body = str_replace("&quot;", "\"", $body);
		$body = "<div class=\"email-content\" ".nl2br(htmlspecialchars($body))."</div>";
	}

	setting_get("sitemgr_email",$sitemgr_email);
	list($sitemgr_emails) = explode(",",$sitemgr_email);

	customtext_get("payment_tax_label", $payment_tax_label);
	$domain = new Domain(SELECTED_DOMAIN_ID);

	//body message
	
	$body = str_replace("ACCOUNT_NAME", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ACCOUNT_NAME), $body);
	$body = str_replace("LISTING_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_LISTING_TITLE), $body);
	$body = str_replace("EVENT_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_EVENT_TITLE), $body);
	$body = str_replace("BANNER_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_BANNER_TITLE), $body);
	$body = str_replace("CLASSIFIED_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_CLASSIFIED_TITLE), $body);
	$body = str_replace("ARTICLE_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ARTICLE_TITLE), $body);
	$body = str_replace("LISTING_RENEWAL_DATE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_LISTING_RENEWAL_DATE), $body);
	$body = str_replace("ACCOUNT_USERNAME", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ACCOUNT_USERNAME), $body);
	$body = str_replace("ACCOUNT_PASSWORD", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ACCOUNT_PASSWORD), $body);
	$body = str_replace("ACCOUNT_LOGIN_INFORMATION", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ACCOUNT_LOGIN_INFORMATION), $body);
	$body = str_replace("ACCOUNT_NUMBER", "xxx", $body);
	$body = str_replace("KEY_ACCOUNT", "<a href=\"".DEFAULT_URL."/".MEMBERS_ALIAS."/login.php?key=7wjw84w93iussdiwsieosw\" class=\"email_style_settings\">".DEFAULT_URL."/".MEMBERS_ALIAS."/login.php?key=7wjw84w93iussdiwsieosw</a>", $body);
	$body = str_replace("LINK_ACTIVATE_ACCOUNT", "<a href=\"".DEFAULT_URL."/".MEMBERS_ALIAS."/login.php?key=7wjw84w93iussdiwsieosw\" class=\"email_style_settings\">".DEFAULT_URL."/".MEMBERS_ALIAS."/activate.php?key=7wjw84w93iussdiwsieosw</a>", $body);
	$body = str_replace("CUSTOM_INVOICE_AMOUNT", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_CUSTOMINVOICE_AMOUNT), $body);
	$body = str_replace("CUSTOM_INVOICE_TAX", "+ ".$payment_tax_label, $body);

	$body = str_replace("SITEMGR_EMAIL", $sitemgr_email, $body);
	$body = str_replace("EDIRECTORY_TITLE", EDIRECTORY_TITLE, $body);
	$body = str_replace("EDIRECTORY_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_EDIRECTORYTITLE), $body);
	$body = str_replace("DIRECTORY_TITLE", EDIRECTORY_TITLE, $body);
	$body = str_replace("ARTICLE_DEFAULT_URL", ARTICLE_DEFAULT_URL, $body);
	$body = str_replace("CLASSIFIED_DEFAULT_URL", CLASSIFIED_DEFAULT_URL, $body);
	$body = str_replace("EVENT_DEFAULT_URL", EVENT_DEFAULT_URL, $body);
	$body = str_replace("LISTING_DEFAULT_URL", LISTING_DEFAULT_URL, $body);
    $body = str_replace("DEFAULT_URL", DEFAULT_URL, $body);
	$body = str_replace("MEMBERS_URL", MEMBERS_ALIAS, $body);
	
	$body = str_replace("DAYS_INTERVAL", $days, $body);
	$body = str_replace("REDEEM_CODE", "xxxxx", $body);

	$body = str_replace("ITEM_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ITEM_TITLE), $body);
	$body = str_replace("ITEM_URL", DEFAULT_URL."/item/title.html", $body);
	$body = str_replace($_SERVER["HTTP_HOST"], $domain->getString("url"), $body);
    
	if ($id == 36){
		/*
		 * Prepare table with stats to listing
		 */    
		$data_email = retrieveListingReport(0);
		$table = report_PrepareListingStatsReviewToEmail($data_email, 0, "listing");
		$body = str_replace("[TABLE_STATS]", $table, $body);

	}

	//subject message
	$subject = str_replace("ACCOUNT_NAME", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ACCOUNT_NAME), $subject);
	$subject = str_replace("LISTING_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_LISTING_TITLE), $subject);
	$subject = str_replace("EVENT_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_EVENT_TITLE), $subject);
	$subject = str_replace("BANNER_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_BANNER_TITLE), $subject);
	$subject = str_replace("CLASSIFIED_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_CLASSIFIED_TITLE), $subject);
	$subject = str_replace("ARTICLE_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ARTICLE_TITLE), $subject);
	$subject = str_replace("LISTING_RENEWAL_DATE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_LISTING_RENEWAL_DATE), $subject);
	$subject = str_replace("ACCOUNT_USERNAME", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ACCOUNT_USERNAME), $subject);
	$subject = str_replace("ACCOUNT_PASSWORD", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ACCOUNT_PASSWORD), $subject);

	$subject = str_replace("SITEMGR_EMAIL", $sitemgr_email, $subject);
	$subject = str_replace("EDIRECTORY_TITLE", EDIRECTORY_TITLE, $subject);
	$subject = str_replace("EDIRECTORY_TITLE",system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_EDIRECTORYTITLE), $subject);
	$subject = str_replace("DIRECTORY_TITLE", EDIRECTORY_TITLE, $subject);
	$subject = str_replace("ARTICLE_DEFAULT_URL", ARTICLE_DEFAULT_URL, $subject);
	$subject = str_replace("CLASSIFIED_DEFAULT_URL", CLASSIFIED_DEFAULT_URL, $subject);
	$subject = str_replace("EVENT_DEFAULT_URL", EVENT_DEFAULT_URL, $subject);
	$subject = str_replace("LISTING_DEFAULT_URL", LISTING_DEFAULT_URL, $subject);
	$subject = str_replace("DEFAULT_URL", DEFAULT_URL, $subject);
	$subject = str_replace("DAYS_INTERVAL", $days, $subject);
	$subject = str_replace($_SERVER["HTTP_HOST"], $domain->getString("url"), $subject);
	$subject = str_replace("ITEM_TITLE", system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_ITEM_TITLE), $subject);
	$subject = str_replace("ITEM_URL", DEFAULT_URL."/item/title.html", $subject);

	$from = $sitemgr_email;
	$to = system_showText(LANG_SITEMGR_EMAILNOTIFICATION_VAR_EMAIL);
        
	?>

	
	<div class="form-horizontal well-mailer small">
		<div class="row form-group ">
			<label class="control-label col-sm-2"><?=system_showText(LANG_SITEMGR_LABEL_FROM)?>:</label>
			<span class="form-control-static col-sm-10"><?=$from?></span>
		</div>
		<div class="row form-group ">	
			<label class="control-label col-sm-2"><?=system_showText(LANG_SITEMGR_LABEL_TO)?>:</label>
			<span class="form-control-static col-sm-10"><?=$to?></span>
		</div>	
		<div class="row form-group ">	
			<label class="control-label col-sm-2"><?=system_showText(LANG_SITEMGR_LABEL_BCC)?>:</label>
			<span class="form-control-static col-sm-10"><?=$bcc?></span>
		</div>	
		<div class="row form-group ">	
			<label class="control-label col-sm-2"><?=system_showText(LANG_SITEMGR_LABEL_SUBJECT)?>:</label>
			<span class="form-control-static col-sm-10"><?=$subject?></span>
		</div>	
	</div>
        
    <div class="well well-mailer">
    	<?=$body?>
    </div>
                
