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
# * FILE: /includes/code/event_emailform.php
# ----------------------------------------------------------------------------------------------------

# ----------------------------------------------------------------------------------------------------
# VALIDATE FEATURE
# ----------------------------------------------------------------------------------------------------
if (EVENT_FEATURE != "on" || CUSTOM_EVENT_FEATURE != "on") { exit; }

# ----------------------------------------------------------------------------------------------------
# CODE
# ----------------------------------------------------------------------------------------------------

$id = $_POST["id"] ? $_POST["id"] : $_GET["id"];
$id = system_denyInjections($id);
$receiver = $_POST["receiver"] ? $_POST["receiver"] : $_GET["receiver"];
$receiver = system_denyInjections($receiver);

$item_error = FALSE;
if (!$id || !$receiver) {
    $error = system_showText(LANG_MSG_TOFRIEND3)." <a href=".DEFAULT_URL.">" .DEFAULT_URL." </a>".system_showText(LANG_MSG_TOFRIEND4)."<br />";
    $item_error = TRUE;
}
if ($id) {
    $check_id = db_getFromDB('event', 'id', $id);
    if (!$check_id->id)  {
        $error = system_showText(LANG_MSG_TOFRIEND3)." <a href=".DEFAULT_URL.">" .DEFAULT_URL." </a>".system_showText(LANG_MSG_TOFRIEND4)."<br />";
        $item_error = TRUE;
    }
}
if ($receiver) {
    if ($receiver != 'friend' && $receiver != 'owner') {
        $error = system_showText(LANG_MSG_TOFRIEND3)." <a href=".DEFAULT_URL.">" .DEFAULT_URL." </a>".system_showText(LANG_MSG_TOFRIEND4)."<br />";
        $item_error = TRUE;
    }
}

$level = new EventLevel();
$obj = new Event($id);

if ($receiver == "owner") {
    $to = $obj->getString("email");
    $saudation = system_showText(LANG_CONTACT)." ".$obj->getString('title');
    if (empty($subject)) $subject = system_showText(LANG_EVENT_CONTACTSUBJECT_ISNULL_1)." ".$obj->getString('title')." ".system_showText(LANG_EVENT_CONTACTSUBJECT_ISNULL_2)." ".EDIRECTORY_TITLE;
} else {
    $saudation = system_showText(LANG_EVENT_TOFRIEND_SAUDATION);
    $emailNotificationObj = system_checkEmail(SYSTEM_EMAIL_TOFRIEND);
    if (empty($subject)) {
        $subject = system_replaceEmailVariables($emailNotificationObj->subject, $obj->getNumber("id"), "event");
        $subject = htmlspecialchars($subject);
    }
    $disabled = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $to = str_replace('\'', '', $to);
    $to = trim($to);
    $from = trim($from);

    $to = system_denyInjections($to);
    $from = system_denyInjections($from);
    $subject = system_denyInjections($subject);
    $body = system_denyInjections($body, true);

    $error = "";

    if ($receiver == "owner") {
        if (!$name) $error .= system_showText(LANG_MSG_CONTACT_ENTER_NAME)."<br />";
    }

    if (!validate_email($to)) $error .= system_showText(LANG_MSG_TOFRIEND1).".<br />";
    if (!validate_email($from)) {
        if ($receiver == "owner") {
            $error .= system_showText(LANG_MSG_TOFRIEND5).".<br />";
        } else {
            $error .= system_showText(LANG_MSG_TOFRIEND2).".<br />";
        }
    }

    if ($receiver == "owner") {
        if (!$body) $error .= system_showText(LANG_MSG_CONTACT_TYPE_MESSAGE)."<br />";
    }

    $subject = stripslashes($subject);
    $body = stripslashes($body);

    if (empty($error)) {

        if (empty($subject)) $subject = system_showText(LANG_EVENT_CONTACTSUBJECT_ISNULL_1)." ".$obj->getString('title')." ".system_showText(LANG_EVENT_CONTACTSUBJECT_ISNULL_2)." ".EDIRECTORY_TITLE;

        $original_body = $body;
        $original_body = str_replace("<br />", "", $body);
        $original_subject = stripslashes(html_entity_decode($subject));

        $subject = stripslashes($subject);
        $auxsubject = htmlspecialchars_decode($subject);
        $subject = "[".system_showText(LANG_CONTACTPRESUBJECT)." ".EDIRECTORY_TITLE."] ".$subject;

        $message = "";

        if ($receiver == "friend") {

            # ----------------------------------------------------------------------------------------------------
            # DEFINES
            # ----------------------------------------------------------------------------------------------------

            $str_date = $obj->getDateString();
            if ($obj->getString("recurring")=="Y"){
                $str_recurring = $obj->getDateStringRecurring();
            }
            $str_date = str_replace("<br />", "\n", $str_date);
            $str_end = $obj->getDateStringEnd();
            $str_time = $obj->getTimeString();

            $message = "";

            if ($emailNotificationObj->content_type == "text/plain") $linebreak = "\r\n";
            else $linebreak = "<br />";

            if ($emailNotificationObj = system_checkEmail(SYSTEM_EMAIL_TOFRIEND)) {
                $message .= LANG_MESSAGE_SENT_BY.$from.$linebreak.$linebreak;
                $message .= system_replaceEmailVariables($emailNotificationObj->body, $obj->getNumber("id"), "event");
            }

            $message .= $linebreak.$linebreak;
            $message .= system_showText(LANG_EVENT_TOFRIEND_MAIL).$linebreak;
            $message .= system_showText(LANG_LABEL_NAME).": ".htmlspecialchars_decode($obj->getString("title")).$linebreak;
            $message .= system_showText(LANG_EVENT_WHEN).": ".($obj->getString("recurring") != "Y" ? $str_date : $str_recurring).$linebreak;

            if ($str_time) {
                $message .= system_showText(LANG_EVENT_TIME).": ".$str_time.$linebreak;
            }

            if ($obj->getString("contact_name")) {
                $message .= system_showText(LANG_LABEL_CONTACTNAME).": ".$obj->getString("contact_name").$linebreak;
            }
            $message .= $obj->getString("long_description").$linebreak;
            $cityObj = new Location4($obj->getString("location_4"));
            $stateObj = new Location3($obj->getString("location_3"));
            $message .= system_showText(LANG_EVENT_LOCATIONS).":";
            if ($obj->getString("address")) $message .= " ".htmlspecialchars_decode($obj->getString("address"));
            if ($obj->getString("address2")) $message .= " (".htmlspecialchars_decode($obj->getString("address2")).")";
            if (($obj->getString("address")) || ($obj->getString("address2"))) $message .= ", ";
            if ($cityObj->getString("name")) $message .= $cityObj->getString("name");
            if (($cityObj->getString("name")) || ($stateObj->getString("name"))) $message .= " - ";
            if ($stateObj->getString("name")) $message .= $stateObj->getString("name");
            if ($obj->getString("zip_code")) $message .= " ".$obj->getString("zip_code");
            $message .= $linebreak;
            $message .= "----------------------------".$linebreak.$linebreak;

        }

        $body = str_replace("<br />", "\n", $body);

        if ($receiver == "owner"){
            $body = ucfirst(system_showText(LANG_FROM)).": ".$name."\n\n".system_showText(LANG_LABEL_EMAIL).": ".$from."\n\n".system_showText(LANG_LABEL_MESSAGE).":\n\n ".$body;
        }

        $message .= stripslashes(html_entity_decode($body));

        $message .= $linebreak;

        if ($body && $receiver == "friend") {
            $message .= "\n----------------------------".$linebreak.$linebreak;
            $message .= "\n".LANG_THIS_IS_A_AUTOMATIC_MESSAGE;
        }

        $subject = html_entity_decode($subject);

        if ($receiver == "friend") {
            $return = Mailer::mail($to, $subject, $message, $emailNotificationObj->content_type, null, null, $from );
        } else {
            if ($emailNotificationObj = system_checkEmail(SYSTEM_NEW_LEAD)) {
                setting_get("sitemgr_email", $sitemgr_email);
                $sitemgr_emails = explode(",", $sitemgr_email);
                if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                $auxbody   = $message;
                $subject   = $emailNotificationObj->getString("subject");
                $body      = $emailNotificationObj->getString("body");
                $body      = system_replaceEmailVariables($body, $id, 'listing');
                $subject   = system_replaceEmailVariables($subject, $id, 'listing');
                $body      = html_entity_decode($body);
                $subject   = html_entity_decode($subject)." - ".$auxsubject;
                if ($emailNotificationObj->getString("content_type") == "text/html") {
                    $auxbody = nl2br($auxbody);
                }
                $body      = str_replace("LEAD_MESSAGE", $auxbody, $body);
                $return = Mailer::mail( $to, $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ), $from );
            } else {
                $return = Mailer::mail( $to, $subject, $message, $emailNotificationObj->content_type, null, null, $from );
            }
        }

        $return_email_message = "";
        if ($return) {
            $return_email_message .= "<p class=\"successMessage\">".system_showText(LANG_CONTACTMSGSUCCESS)."</p>";

            $arrayMessage = array();
            $arrayMessage["LANG_LABEL_MESSAGE"] = $original_body;
            $leadInfo["item_id"] = $id;
            $leadInfo["member_id"] = sess_getAccountIdFromSession();
            $leadInfo["first_name"] = stripslashes(html_entity_decode($name));
            $leadInfo["email"] = $from;
            $leadInfo["subject"] = $original_subject;
            $leadInfo["message"] = serialize($arrayMessage);
            $leadInfo["type"] = "event";

            $leadObj = new Lead();
            $leadObj->makeFromRow($leadInfo);
            $leadObj->save();

            unset($from, $subject, $body);
        } else {
            $return_email_message .= "<p class=\"errorMessage\">".system_showText(LANG_CONTACTMSGFAILED).($error ? '<br />'.$error : '')."</p>";
            $error = "";
        }
    }
}