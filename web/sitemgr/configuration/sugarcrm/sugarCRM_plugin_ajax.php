<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /ed-admin/configuration/wordpress/sugarCRM_plugin_ajax.php
    # ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../../conf/loadconfig.inc.php");
    
    # ----------------------------------------------------------------------------------------------------
    # SESSION
    # ----------------------------------------------------------------------------------------------------
    sess_validateSMSession();
    permission_hasSMPerm();
	
	header("Content-Type: text/html; charset=".EDIR_CHARSET, TRUE);
	header("Accept-Encoding: gzip, deflate");
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check", FALSE);
	header("Pragma: no-cache");

	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		if (validate_form("sugar_crm", $_POST, $error)) {
		
			/*
			 * Save url of sugar
			 */
			if (!setting_set("sugar_url", $_POST["sugar_url"])) {
				if (!setting_new("sugar_url", $_POST["sugar_url"])) {
					$error = true;
				}
			}
			
			/*
			 * Save url of sugar
			 */
			if (!setting_set("sugar_user", $_POST["sugar_user"])) {
				if (!setting_new("sugar_user", $_POST["sugar_user"])) {
					$error = true;
				}
			}
			
			/*
			 * Save url of sugar
			 */
			if (!setting_set("sugar_password", $_POST["sugar_password"])) {
				if (!setting_new("sugar_password", $_POST["sugar_password"])) {
					$error = true;
				}
			}
			
			if ($error) {
               $message_style = "errorMessage";
			   $message = system_showText(LANG_SITEMGR_SUGAR_ERROR_MESSAGE_SAVE);
            }
			
			if (sugar_login()) { ?>
                <label><?=system_showText(LANG_SITEMGR_SUGAR_DOWNLOAD_PLUGIN)?></label>
                <input class="btn btn-success btn-block" type="button" onclick="download_sugar_plugin();" value="<?=system_showText(LANG_SITEMGR_SUGAR_DOWNLOAD)?>">
            <? } else { ?>
                <div class="alert alert-danger"><?=system_showText(LANG_SITEMGR_SUGAR_CHECK_INFORMATION)?></div>
            <?
			}
		}
	}
	?>