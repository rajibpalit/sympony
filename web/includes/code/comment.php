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
# * FILE: /includes/code/comment.php
# ----------------------------------------------------------------------------------------------------

setting_get("review_approve", $post_comment_approve);

extract($_POST);
$comment = system_denyInjections($comment, true);
$comment = stripslashes($comment);
$error_comment = "";

if ( !$comment )
{
    $error_comment .= system_showText( LANG_COMMENT_EMPTY )."<br />";
}

if (empty($error_comment)) {

    $postid = $_GET["id"] ? $_GET["id"] : $_POST["id"];

    $commentObj = new Comments();
    $commentObj->setNumber("post_id", $id);
    $commentObj->setNumber("reply_id", ($reply_id ? $reply_id : 0));
    $commentObj->setNumber("member_id", $member_id);
    $commentObj->setString("description", $comment);
    $commentObj->setString("member_name", $comment_name);
    $commentObj->setString("approved", (!$post_comment_approve? 1: 0));
    $commentObj->Save();

    $postObj = new Post($id);
    $commentObj = new Comments($commentObj->getString("id"));

    // site manager warning message /////////////////////////////////////
    setting_get("sitemgr_blog_email", $sitemgr_blog_email);
    $sitemgr_blog_emails = explode(",", $sitemgr_blog_email);

    $emailSubject = "[".EDIRECTORY_TITLE."] ".($reply_id ? system_showText(LANG_NOTIFY_NEWREPLY) : system_showText(LANG_NOTIFY_NEWCOMMENT));

    # send email to sitegmr
    $sitemgr_msg = system_showText(LANG_LABEL_SITE_MANAGER).",<br /><br />"
        .system_showText(LANG_NOTIFY_NEWCOMMENT_1)." \"".$postObj->getString("title")."\" ".($reply_id ? system_showText(system_showText(LANG_NOTIFY_NEWCOMMENT_2)) : system_showText(system_showText(LANG_NOTIFY_NEWCOMMENT_3)))."<br /><br />"
        .$comment_name." (".$comment_email.") ".system_showText(LANG_NOTIFY_NEWCOMMENT_4).":<br /><br />"
        .$comment."<br />"
        ."<br />".system_showText(LANG_NOTIFY_NEWCOMMENT_5)." ".format_date($commentObj->getString("added"), DEFAULT_DATE_FORMAT." H:i:s", "datetime")."<br /><br />"
        .system_showText(LANG_NOTIFY_NEWCOMMENT_6).":<br />"
        ."<a href=\"".DEFAULT_URL."/".SITEMGR_ALIAS."/activity/reviews-comments/index.php?item_type=blog&search_id=".$commentObj->getString("id")."&post_id=".$postid."&id=".$commentObj->getString("id")."\" target=\"_blank\">".DEFAULT_URL."/".SITEMGR_ALIAS."/comments/index.php?item_type=blog&search_id=".$commentObj->getString("id")."&post_id=".$postid."&id=".$commentObj->getString("id")."</a><br /><br />";

    system_notifySitemgr($sitemgr_blog_emails, $emailSubject, $sitemgr_msg);

    $comment = html_entity_decode($comment);

    $success_message = "";
    $success_approve_message = "";
    if (!$reply_id) {
        if ($post_comment_approve == "on") {
            $success_approve_message = LANG_MSG_COMMENT_SENT_TO_APPROVE;
        } else {
            $success_message = LANG_MSG_COMMENT_SUCCESSFULLY_POSTED;
        }
    } else {
        if ($post_comment_approve == "on") {
            $success_approve_message = LANG_MSG_REPLY_SENT_TO_APPROVE;
        } else {
            $success_message = LANG_MSG_REPLY_SUCCESSFULLY_POSTED;
        }
    }

    $success_comment = true;
    $message_comment = ($post_comment_approve == "on" ? $success_approve_message : $success_message);

    unset($comment_name);
    unset($comment);
} else {
    $success_comment = false;
    $message_comment = $error_comment;
}