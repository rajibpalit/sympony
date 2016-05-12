<?php

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
# * FILE: /includes/code/review.php
# ----------------------------------------------------------------------------------------------------

# ----------------------------------------------------------------------------------------------------
# AUX
# ----------------------------------------------------------------------------------------------------
if ($item_type == "listing") {
    $itemObj = new Listing($item_id);
    $item_name = $itemObj->getString("title");
} else if ($item_type == "promotion") {
    $itemObj = new Promotion($item_id);
    $item_name = $itemObj->getString("name");
} else if ($item_type == "article") {
    $itemObj = new Article($item_id);
    $item_name = $itemObj->getString("title");
}

$rating_stars = "";

$hostReview = string_strtoupper(str_replace("www.", "", $_SERVER["HTTP_HOST"]));
$host_cookieReview = str_replace(".", "_", $hostReview);


# ----------------------------------------------------------------------------------------------------
# CODE
# ----------------------------------------------------------------------------------------------------

$success_review = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    setting_get("review_manditory", $review_manditory);
    setting_get("review_approve", $review_approve);

    if ($_COOKIE[$host_cookieReview."review"]) {
        $cookie_value = $_COOKIE[$host_cookieReview."review"];
        $cookie_arr   = explode(":",$_COOKIE[$host_cookieReview."review"]);
    }

    $allowed = true;

    if (!$_POST["rating"]) {
        $message_review = system_showText(LANG_MSG_REVIEW_SELECTRATING);
        $allowed = false;
    } elseif ($_POST["rating"] > 5 ) {
        $message_review = system_showText(LANG_MSG_REVIEW_FRAUD_SELECTRATING);
        $allowed = false;
    } elseif (!trim($_POST["review"]) || !trim($_POST["review_title"])) {
        $message_review = system_showText(LANG_MSG_REVIEW_COMMENTREQUIRED);
        $allowed = false;
    }

    if ($review_manditory == "on") {
        if (!trim($_POST["reviewer_name"]) || !trim($_POST["reviewer_email"])) {
            $message_review = system_showText(LANG_MSG_REVIEW_NAMEEMAILREQUIRED);
            $allowed = false;
        }
    }

    if ($_POST["reviewer_email"] && !validate_email($_POST["reviewer_email"])) {
        $message_review = system_showText(LANG_MSG_REVIEW_TYPEVALIDEMAIL);
        $allowed = false;
    }

    $reviewObj = new Review();
    $denied_ips = $reviewObj->getDeniedIpsByItem($item_type, $itemObj->getString("id"));
    if ($denied_ips) {
        foreach ($denied_ips as $each_ip) {
            if ($_SERVER["REMOTE_ADDR"] == $each_ip) {
                $message_review = system_showText(LANG_MSG_REVIEW_YOUALREADYGIVENOPINION);
                $allowed = false;
            }
        }
    }

    for ($i = 1; $i < 6; $i++) {
        $img  = "<img ";
        $img .= ($i <= $rating) ? "src=\"".DEFAULT_URL."/images/content/img_rate_star_on.gif\" alt=\"Star On\"" : "src=\"".DEFAULT_URL."/images/content/img_rate_star_off.gif\" alt=\"Star Off\"";
        $img .= "onclick=\"setRatingLevel($i)\"";
        $img .= "onmouseout=\"resetRatingLevel()\"";
        $img .= "onmouseover=\"setDisplayRatingLevel($i)\"";
        $img .= "name=\"star$i\" />";
        $rating_stars .= $img;
    }

    if ($allowed) {

        $_POST["ip"] = $_SERVER["REMOTE_ADDR"];
        $reviewObj = new Review($_POST);

        if ($review_approve != "on") {
            $reviewObj->setNumber("approved", 1);
        }
        $reviewObj->Save();
        if ($review_approve != "on") {
            $avg = $reviewObj->getRateAvgByItem($item_type, $item_id);
            if (!is_numeric($avg)) $avg = 0;
            if ($item_type == 'listing') {
                $listing = new Listing();
                $listing->setAvgReview($avg, $item_id);
            } else if ($item_type == 'promotion'){
                $promotion = new Promotion();
                $promotion->setAvgReview($avg, $item_id);
            } else {
                $articles = new Article();
                $articles->setAvgReview($avg, $item_id);
            }
        }

        $reviewObj = new Review($reviewObj->getString("id"));

        $value = ($cookie_value) ? $cookie_value.":".$item_id : $item_id;

        setcookie($host_cookieReview."review", "$value", time()-3600, "".EDIRECTORY_FOLDER."/");
        setcookie($host_cookieReview."review", "$value", time()+60*60*24*30*120, "".EDIRECTORY_FOLDER."/");

        if ($reviewObj->getString("review")) {

            setting_get("sitemgr_rate_email", $sitemgr_rate_email);
            $sitemgr_rate_emails = explode(",", $sitemgr_rate_email);
            if ( ! $reviewObj->getString("reviewer_email") ) $reviewObj->setString("reviewer_email", "anonimous");

            // site manager warning message /////////////////////////////////////
            $emailSubject = "[".EDIRECTORY_TITLE."] ".system_showText(LANG_NOTIFY_NEWREVIEW);

            $sitemgr_msg = system_showText(LANG_LABEL_SITE_MANAGER).",<br /><br />"
                ."\"".$item_name."\" ".system_showText(LANG_NOTIFY_NEWREVIEW_1)." - ".$reviewObj->getString("rating")." ".system_showText(LANG_NOTIFY_NEWREVIEW_2)." <br />"
                .$reviewObj->getString("reviewer_name")." (".$reviewObj->getString("reviewer_email").") ".system_showText(LANG_NOTIFY_NEWREVIEW_4)." ".$reviewObj->getString("reviewer_location")." ".system_showText(LANG_NOTIFY_NEWREVIEW_5).": <br />"
                .$reviewObj->getString("review_title")."<br />"
                .$reviewObj->getString("review")."<br />"
                .format_date($reviewObj->getString("added"), DEFAULT_DATE_FORMAT." H:i:s", "datetime")."<br /><br />"
                ."".system_showText(LANG_NOTIFY_NEWREVIEW_3)." :<br />"
                ."<a href=\"".DEFAULT_URL."/".SITEMGR_ALIAS."/activity/reviews-comments/index.php?item_type=".$reviewObj->getString("item_type")."&search_id=".$reviewObj->getString("id")."\" target=\"_blank\">".DEFAULT_URL."/".SITEMGR_ALIAS."/activity/reviews-comments/index.php?search_id=".$reviewObj->getString("id")."</a><br /><br />";

            system_notifySitemgr($sitemgr_rate_emails, $emailSubject, $sitemgr_msg);

            /* send e-mail to listing owner */
            if($reviewObj->getString('item_type') == 'listing') {
                $contactObj = new Contact($itemObj->getNumber('account_id'));
                if($emailNotificationObj = system_checkEmail(SYSTEM_NEW_REVIEW)) {
                    setting_get("sitemgr_send_email", $sitemgr_send_email);
                    setting_get("sitemgr_email", $sitemgr_email);
                    $sitemgr_emails = explode(",", $sitemgr_email);
                    if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                    $subject   = $emailNotificationObj->getString("subject");
                    $body      = $emailNotificationObj->getString("body");
                    $body      = system_replaceEmailVariables($body, $itemObj->getNumber('id'), 'listing');
                    $subject   = system_replaceEmailVariables($subject, $itemObj->getNumber('id'), 'listing');
                    $body      = html_entity_decode($body);
                    $subject   = html_entity_decode($subject);
                    $error = false;

                    Mailer::mail($contactObj->getString("email"), $subject, $body, $emailNotificationObj->getString("content_type"), null, $emailNotificationObj->getString("bcc") );

                }
            }

            /* send e-mail to article owner */
            if($reviewObj->getString('item_type') == 'article') {
                $contactObj = new Contact($itemObj->getNumber('account_id'));
                if($emailNotificationObj = system_checkEmail(SYSTEM_NEW_REVIEW)) {
                    setting_get("sitemgr_send_email", $sitemgr_send_email);
                    setting_get("sitemgr_email", $sitemgr_email);
                    $sitemgr_emails = explode(",", $sitemgr_email);
                    if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                    $subject   = $emailNotificationObj->getString("subject");
                    $body      = $emailNotificationObj->getString("body");
                    $body      = system_replaceEmailVariables($body, $itemObj->getNumber('id'), 'article');
                    $subject   = system_replaceEmailVariables($subject, $itemObj->getNumber('id'), 'article');
                    $body      = html_entity_decode($body);
                    $subject   = html_entity_decode($subject);

                    Mailer::mail($contactObj->getString("email"), $subject, $body, $emailNotificationObj->getString("content_type"), null, $emailNotificationObj->getString("bcc") );
                }
            }
            /* send e-mail to promotion owner */
            if($reviewObj->getString('item_type') == 'promotion') {
                $contactObj = new Contact($itemObj->getNumber('account_id'));
                if($emailNotificationObj = system_checkEmail(SYSTEM_NEW_REVIEW)) {
                    setting_get("sitemgr_send_email", $sitemgr_send_email);
                    setting_get("sitemgr_email", $sitemgr_email);
                    $sitemgr_emails = explode(",", $sitemgr_email);
                    if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                    $subject   = $emailNotificationObj->getString("subject");
                    $body      = $emailNotificationObj->getString("body");
                    $body      = system_replaceEmailVariables($body, $itemObj->getNumber('id'), 'promotion');
                    $subject   = system_replaceEmailVariables($subject, $itemObj->getNumber('id'), 'promotion');
                    $body      = html_entity_decode($body);
                    $subject   = html_entity_decode($subject);

                    Mailer::mail($contactObj->getString("email"), $subject, $body, $emailNotificationObj->getString("content_type"), null, $emailNotificationObj->getString("bcc") );
                }
            }

            /* */

            if (!$review_approve == 'on') {
                /* send e-mail to listing owner */
                if($reviewObj->getString('item_type') == 'listing') {
                    $contactObj = new Contact($itemObj->getNumber('account_id'));
                    if($emailNotificationObj = system_checkEmail(SYSTEM_APPROVE_REVIEW)) {
                        setting_get("sitemgr_send_email", $sitemgr_send_email);
                        setting_get("sitemgr_email", $sitemgr_email);
                        $sitemgr_emails = explode(",", $sitemgr_email);
                        if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                        $subject   = $emailNotificationObj->getString("subject");
                        $body      = $emailNotificationObj->getString("body");
                        $body      = system_replaceEmailVariables($body, $itemObj->getNumber('id'), 'listing');
                        $subject   = system_replaceEmailVariables($subject, $itemObj->getNumber('id'), 'listing');
                        $body      = html_entity_decode($body);
                        $subject   = html_entity_decode($subject);

                        Mailer::mail($contactObj->getString("email"), $subject, $body, $emailNotificationObj->getString("content_type"), null, $emailNotificationObj->getString("bcc") );
                    }
                }

                /* send e-mail to article owner */
                if($reviewObj->getString('item_type') == 'article') {
                    $contactObj = new Contact($itemObj->getNumber('account_id'));
                    if($emailNotificationObj = system_checkEmail(SYSTEM_APPROVE_REVIEW)) {
                        setting_get("sitemgr_send_email", $sitemgr_send_email);
                        setting_get("sitemgr_email", $sitemgr_email);
                        $sitemgr_emails = explode(",", $sitemgr_email);
                        if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                        $subject   = $emailNotificationObj->getString("subject");
                        $body      = $emailNotificationObj->getString("body");
                        $body      = system_replaceEmailVariables($body, $itemObj->getNumber('id'), 'article');
                        $subject   = system_replaceEmailVariables($subject, $itemObj->getNumber('id'), 'article');
                        $body      = html_entity_decode($body);
                        $subject   = html_entity_decode($subject);

                        Mailer::mail($contactObj->getString("email"), $subject, $body, $emailNotificationObj->getString("content_type"), null, $emailNotificationObj->getString("bcc") );
                    }
                }
                /* send e-mail to promotion owner */
                if($reviewObj->getString('item_type') == 'promotion') {
                    $contactObj = new Contact($itemObj->getNumber('account_id'));
                    if($emailNotificationObj = system_checkEmail(SYSTEM_APPROVE_REVIEW)) {
                        setting_get("sitemgr_send_email", $sitemgr_send_email);
                        setting_get("sitemgr_email", $sitemgr_email);
                        $sitemgr_emails = explode(",", $sitemgr_email);
                        if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                        $subject   = $emailNotificationObj->getString("subject");
                        $body      = $emailNotificationObj->getString("body");
                        $body      = system_replaceEmailVariables($body, $itemObj->getNumber('id'), 'promotion');
                        $subject   = system_replaceEmailVariables($subject, $itemObj->getNumber('id'), 'promotion');
                        $body      = html_entity_decode($body);
                        $subject   = html_entity_decode($subject);

                        Mailer::mail($contactObj->getString("email"), $subject, $body, $emailNotificationObj->getString("content_type"), null, $emailNotificationObj->getString("bcc") );
                    }
                }

                /* */
            }

        }

        $message_review = system_showText(LANG_MSG_REVIEW_THANKSFEEDBACK);

        if ($review_approve == "on") {
            $message_review .= " ".system_showText(LANG_MSG_REVIEW_REVIEWSUBMITTEDAPPROVAL);
        }

        $success_review = true;

    }

}