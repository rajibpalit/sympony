<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /ed-admin/configuration/wordpress/wordpress_plugin_ajax.php
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

		if (validate_form("wordpress",$_POST, $error)) {
		
			/*
			 * Save url of WordPress
			 */
			if (!setting_set("wordpress_url", $_POST["wordpress_url"])) {
				if (!setting_new("wordpress_url", $_POST["wordpress_url"])) {
					$error = true;
				}
			}
			
			/*
			 * Generate key to worpress
			 */
			$domainObj = new Domain(SELECTED_DOMAIN_ID);
			$domain = $domainObj->getString("url");
			$edir_key = getKey($domain);

            $wordpress_key = md5($_POST["wordpress_url"].VERSION.$edir_key);

            unset($new_Key);
            $j = 0;
            for ($i = 0; $i < strlen($wordpress_key); $i++) {
                if ($j < 4) {
                    $new_key .= substr($wordpress_key, $i, 1);	
                } else {
                    $new_key .= "-".substr($wordpress_key, $i, 1);
                    $j = 0;
                }
                $j++;

            }
            if (!setting_set("wordpress_key", $new_key)) {
                if (!setting_new("wordpress_key", $new_key)) {
                    $error = true;
                }
            }

            echo $new_key;
		}
	}
?>