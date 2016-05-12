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
# * FILE: /includes/code/classified_emailform.php
# ----------------------------------------------------------------------------------------------------

# ----------------------------------------------------------------------------------------------------
# VALIDATE FEATURE
# ----------------------------------------------------------------------------------------------------
if (CLASSIFIED_FEATURE != "on" || CUSTOM_CLASSIFIED_FEATURE != "on") { exit; }

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
    $check_id = db_getFromDB('classified', 'id', $id);
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

$level = new ClassifiedLevel();
$obj = new Classified($id);

if ($receiver == "owner") {
    $to = $obj->getString("email");
    $saudation = system_showText(LANG_CONTACT)." ".$obj->getString('title');
    if (empty($subject)) $subject = system_showText(LANG_CLASSIFIED_CONTACTSUBJECT_ISNULL_1)." ".$obj->getString('title')." ".system_showText(LANG_CLASSIFIED_CONTACTSUBJECT_ISNULL_2)." ".EDIRECTORY_TITLE;
} else {
    $saudation = system_showText(LANG_CLASSIFIED_TOFRIEND_SAUDATION);
    $emailNotificationObj = system_checkEmail(SYSTEM_EMAIL_TOFRIEND);
    if (empty($subject)) {
        $subject = system_replaceEmailVariables($emailNotificationObj->subject, $obj->getNumber("id"), "classified");
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

        if ($receiver == "owner") {

            if (empty($subject)) $subject = LANG_CLASSIFIED_CONTACTSUBJECT_ISNULL_1." ".$obj->getString("title")." ".LANG_CLASSIFIED_CONTACTSUBJECT_ISNULL_2." ".EDIRECTORY_TITLE;

            $original_body = $body;
            $original_body = str_replace("<br />", "", $body);

            $body = str_replace("<br />", "\n", $body);

            $subject = stripslashes(html_entity_decode($subject));
            $original_subject = $subject;
            $name = stripslashes(html_entity_decode($name));
            $body 	 = stripslashes($body);

            $body = ucfirst(system_showText(LANG_FROM)).": ".$name."\n\n".system_showText(LANG_LABEL_EMAIL).": ".$from."\n\n".system_showText(LANG_LABEL_MESSAGE).":\n\n ".$body;

            $auxsubject     = htmlspecialchars_decode($subject);
            $subject = "[".system_showText(LANG_CONTACTPRESUBJECT)." ".EDIRECTORY_TITLE."] ".$subject;

            if ($emailNotificationObj = system_checkEmail(SYSTEM_NEW_LEAD)) {
                setting_get("sitemgr_email", $sitemgr_email);
                $sitemgr_emails = explode(",", $sitemgr_email);
                if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
                $auxbody   = $body;
                $subject   = $emailNotificationObj->getString("subject");
                $body      = $emailNotificationObj->getString("body");
                $body      = system_replaceEmailVariables($body, $id, 'classified');
                $subject   = system_replaceEmailVariables($subject, $id, 'classified');
                $body      = html_entity_decode($body);
                $subject   = html_entity_decode($subject)." - ".$auxsubject;
                if ($emailNotificationObj->getString("content_type") == "text/html") {
                    $auxbody = nl2br($auxbody);
                }
                $body      = str_replace("LEAD_MESSAGE", $auxbody, $body);
                $error = false;
                $return = Mailer::mail($to, $subject, $body, $emailNotificationObj->getString("content_type"), null, null, $from );
            } else {
                $error = false;
                $return = Mailer::mail($to, htmlspecialchars_decode($subject), $body, false, null, null, $from );
            }

            $return_email_message = "";
            if ($return) {
                $return_email_message .= "<p class=\"successMessage\">".system_showText(LANG_CONTACTMSGSUCCESS)."</p>";

                $arrayMessage = array();
                $arrayMessage["LANG_LABEL_MESSAGE"] = $original_body;
                $leadInfo["item_id"] = $id;
                $leadInfo["member_id"] = sess_getAccountIdFromSession();
                $leadInfo["first_name"] = $name;
                $leadInfo["email"] = $from;
                $leadInfo["subject"] = $original_subject;
                $leadInfo["message"] = serialize($arrayMessage);
                $leadInfo["type"] = "classified";

                $leadObj = new Lead();
                $leadObj->makeFromRow($leadInfo);
                $leadObj->save();

                unset($from, $subject, $body);
            } else {
                $return_email_message .= "<p class=\"errorMessage\">".system_showText(LANG_CONTACTMSGFAILED).($error ? '<br />'.$error : '')."</p>";
                $error = "";
            }

        } else {
            if (empty($subject)) $subject = system_showText(LANG_CLASSIFIED_CONTACTSUBJECT_ISNULL_1)." ".$obj->getString("title")." ".system_showText(LANG_CLASSIFIED_CONTACTSUBJECT_ISNULL_2)." ".EDIRECTORY_TITLE;

            $subject = stripslashes($subject);

            $subject = "[".system_showText(LANG_CONTACTPRESUBJECT)." ".EDIRECTORY_TITLE."] ".$subject;

            $message = "";

            if ($emailNotificationObj->content_type == "text/plain") $linebreak = "\r\n";
            else $linebreak = "<br />";


            if ($emailNotificationObj = system_checkEmail(SYSTEM_EMAIL_TOFRIEND)) {
                $message .= LANG_MESSAGE_SENT_BY.$from.$linebreak.$linebreak;
                $message .= system_replaceEmailVariables($emailNotificationObj->body, $obj->getNumber("id"), "classified");
            }

            $message .= $linebreak.$linebreak;
            $message .= system_showText(LANG_CLASSIFIED_TOFRIEND_MAIL).$linebreak;
            $message .= system_showText(LANG_LABEL_NAME).": ".htmlspecialchars_decode($obj->getString("title")).$linebreak;
            $cityObj = new Location4($obj->getString("location_4"));
            $stateObj = new Location3($obj->getString("location_3"));
            $message .= system_showText(LANG_CLASSIFIED_LOCATIONS).":";
            if ($obj->getString("address")) $message .= " ".htmlspecialchars_decode($obj->getString("address"));
            if ($obj->getString("address2")) $message .= " (".htmlspecialchars_decode($obj->getString("address2")).")";
            if (($obj->getString("address")) || ($obj->getString("address2"))) $message .= ", ";
            if ($cityObj->getString("name")) $message .= $cityObj->getString("name");
            if (($cityObj->getString("name")) || ($stateObj->getString("name"))) $message .= " - ";
            if ($stateObj->getString("name")) $message .= $stateObj->getString("name");
            if ($obj->getString("zip_code")) $message .= " ".$obj->getString("zip_code");
            $message .= $linebreak;
            if ($obj->getString("classified_price")!='NULL') $message .= system_showText(LANG_LABEL_PRICE).": ".CURRENCY_SYMBOL.htmlspecialchars_decode($obj->getString("classified_price")).$linebreak;
            $message .= "----------------------------".$linebreak;

            $body = str_replace("<br />", "\n", $body);

            $message .= stripslashes(html_entity_decode($body));

            $message .= $linebreak;

            if ($body) {
                $message .= "\n----------------------------".$linebreak.$linebreak;
            }

            $message .= "\n".LANG_THIS_IS_A_AUTOMATIC_MESSAGE;

            $subject = html_entity_decode($subject);

            $error = false;
            $return = Mailer::mail($to, $subject, $message, $emailNotificationObj->content_type, null, null, $from );

            $return_email_message = "";
            if ($return) {
                $return_email_message .= "<p class=\"successMessage\">".system_showText(LANG_CONTACTMSGSUCCESS)."</p>";
                unset($from, $subject, $body);
            } else {
                $return_email_message .= "<p class=\"errorMessage\">".system_showText(LANG_CONTACTMSGFAILED).($error ? '<br />'.$error : '')."</p>";
                $error = "";
            }
        }
    }
}