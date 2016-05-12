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
# * FILE: /sponsors/facebookauth.php
# ----------------------------------------------------------------------------------------------------

# ----------------------------------------------------------------------------------------------------
# LOAD CONFIG
# ----------------------------------------------------------------------------------------------------
include("../conf/loadconfig.inc.php");

# ----------------------------------------------------------------------------------------------------
# AUX
# ----------------------------------------------------------------------------------------------------
Facebook::getFBInstance($facebook);

$FBSession = $facebook->getAccessToken();

if ($_GET["action"] == "check_session") {
    if ($_GET["fb_session"] == "ok") {
        if ($_GET["code"]) {
            if (isset($FBSession)) {
                $facebook->setAccessToken($FBSession);
                unset($fbSess);

                if ($_GET["type"] == "change_account") {
                    $destinyUrl = $_GET["destiny"];
                    $_GET["destiny"] = $facebook->getLogoutUrl(
                        [
                            "next" => $destinyUrl
                        ]
                    );
                }
            }
        }
    }

    if ($_GET["type"] == "fb_comments") {
        if ($_GET["fb_session"] != "ok" || !isset($_SESSION["fb_" . FACEBOOK_APP_ID . "_access_token"])) {
            $destinyUrl = $_GET["destiny"];
            $_GET["destiny"] = $facebook->getLoginUrl(
                [
                    "redirect_uri" => FACEBOOK_REDIRECT_URI . "?type=fb_comments&destiny=" . $destinyUrl,
                    "scope"        => FACEBOOK_PERMISSION_SCOPE
                ]
            );
        } else {
            if ($_GET["session"]) {
                $fbSess = (object)json_decode($_GET["session"]);
                if (isset($fbSess)) {
                    $facebook->setAccessToken($fbSess->access_token);
                    unset($fbSess);
                }
            }
        }
    }
}

$user = $facebook->getUser();

if ($user && $_GET["type"] != "change_account") {
    try {
        if ($_GET["attach_account"] == "true") {
            $sql = "SELECT account_id FROM Profile WHERE facebook_uid = " . $user . " AND account_id <> " . $_GET["edir_account"];
            $db = db_getDBObject(DEFAULT_DB, true);
            $result = $db->query($sql);
            $enableAttach = true;

            $denyUrl = EDIRECTORY_FOLDER . "/" . SOCIALNETWORK_FEATURE_NAME . "/index.php?error=disableAttach";

            if (mysql_num_rows($result) > 0) {
                $_GET["destiny"] = $denyUrl;
                $enableAttach = false;
            } else {
                $extraInfo["account_id"] = $_GET["edir_account"];
                $extraInfo["facebook_action"] = "facebook_import";
            }
        }

        if (($_GET["attach_account"] == "true" && $enableAttach) || $_GET["attach_account"] != "true") {
            $facebook->getUserInfo($userInfo, $extraInfo);

            if (string_strpos(($_GET["destiny"]), "configuration/networking/index.php") !== false) {
                $_GET["destiny"] .= "?user_id=" . $userInfo["uid"];
            } else {
                if ($_GET["type"] != "fb_comments") {
                    if (system_registerForeignAccount($userInfo, "facebook", $_GET["attach_account"])) {
                        setcookie("uid", sess_getAccountIdFromSession(), time() + 60 * 60 * 24 * 30,
                            "" . EDIRECTORY_FOLDER . "/");
                        if ($_GET["claim"] == "yes" || $_GET["advertise"] == "yes" || SOCIALNETWORK_FEATURE == "off") {
                            $accObj = new Account(sess_getAccountIdFromSession());
                            if ($accObj->getString("is_sponsor") == "n") {
                                $accObj->changeMemberStatus(true);
                            }

                            if ($_GET["advertise"] == "yes") {
                                $destinyUrl = $_GET["destiny"];
                                $itemID = $_GET["item_id"];
                                $item = $_GET["advertise_item"];

                                $level = $_SESSION["fb_{$item}_level_{$itemID}"];
                                $expiration = $_SESSION["fb_{$item}_expiration_setting_{$itemID}"];
                                $impressions = $_SESSION["fb_{$item}_unpaid_impressions_{$itemID}"];
                                $template = $_SESSION["fb_{$item}_template_id_{$itemID}"];
                                $title = $_SESSION["fb_{$item}_title_{$itemID}"];
                                $discount_id = $_SESSION["fb_{$item}_discount_id_{$itemID}"];
                                $return_categories = $_SESSION["fb_{$item}_return_categories_{$itemID}"];
                                $caption = $_SESSION["fb_{$item}_caption_{$itemID}"];
                                $package_id = $_SESSION["fb_{$item}_package_id_{$itemID}"];
                                $start_date = $_SESSION["fb_{$item}_start_date_{$itemID}"];
                                $end_date = $_SESSION["fb_{$item}_end_date_{$itemID}"];

                                unset(
                                    $_SESSION["fb_{$item}_level"],
                                    $_SESSION["fb_{$item}_expiration_setting"],
                                    $_SESSION["fb_{$item}_unpaid_impressions"],
                                    $_SESSION["fb_{$item}_template_id"],
                                    $_SESSION["fb_{$item}_title"],
                                    $_SESSION["fb_{$item}_discount_id"],
                                    $_SESSION["fb_{$item}_return_categories"],
                                    $_SESSION["fb_{$item}_caption"],
                                    $_SESSION["fb_{$item}_start_date"],
                                    $_SESSION["fb_{$item}_end_date"],
                                    $_SESSION["fb_{$item}_package_id"]
                                );

                                if ($item == "banner") {
                                    $destinyUrl .= "?type=" . $level;
                                    $destinyUrl .= "&expiration_setting=" . $expiration;
                                    $destinyUrl .= "&caption=" . $caption;
                                } elseif ($item == "listing") {
                                    $destinyUrl .= "?level=" . $level;
                                    if ($template) {
                                        $destinyUrl .= "&listingtemplate_id=" . $template;
                                    }
                                    if ($return_categories) {
                                        $destinyUrl .= "&return_categories=" . $return_categories;
                                    }
                                } elseif ($item == "event") {
                                    $destinyUrl .= "?level=" . $level;
                                    if ($start_date) {
                                        $destinyUrl .= "&start_date=" . $start_date;
                                    }
                                    if ($end_date) {
                                        $destinyUrl .= "&end_date=" . $end_date;
                                    }
                                } else {
                                    $destinyUrl .= "?level=" . $level;
                                }

                                if ($title) {
                                    $destinyUrl .= "&title=" . $title;
                                }
                                if ($discount_id) {
                                    $destinyUrl .= "&discount_id=" . $discount_id;
                                }
                                if ($package_id) {
                                    $destinyUrl .= "&package_id=" . $package_id;
                                }

                                $_GET["destiny"] = $destinyUrl;
                            }
                        }
                    }
                }
            }
        }
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
    }
}

/*
 * Workaround to pin a bookmark without login
 */
if ($_GET['bookmark_remember']) {
    // Sets a cookie to use in font JS
    setcookie('open_bookmark', $_GET['bookmark_remember'], time() + 60 * 60, '/');
}

/*
 * Workaround for make a redeem without login
 */
if ($_GET['redeem_remember']) {
    // Sets a cookie to use in font JS
    setcookie('open_redeem', $_GET['redeem_remember'], time() + 60 * 60, '/');
}

// Opens modal automatically
$_SESSION['_sf2_attributes']['modal'] = 1;

header("Location: " . $_GET["destiny"]);
exit;
