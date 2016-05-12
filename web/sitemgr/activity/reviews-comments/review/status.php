<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/activity/review-comments/review/status.php
	# ----------------------------------------------------------------------------------------------------

    /**
     * <Lucas Trentim (2015)>
     * @todo : This code could use a liiiitle HUGE cleanup.
     */

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../../../conf/loadconfig.inc.php");

    # ----------------------------------------------------------------------------------------------------
    # SESSION
    # ----------------------------------------------------------------------------------------------------
    sess_validateSMSession();
    permission_hasSMPerm();

    extract($_GET);
    extract($_POST);
	$domain = new Domain(SELECTED_DOMAIN_ID);

    #--------------------------------------------------------------------------------
    # REVIEW
    #--------------------------------------------------------------------------------
    if ( $status == "review" )
    {
        $reviewObj = new Review( $idReview );
        $reviewObj->setNumber( 'approved', 1 );
        $reviewObj->Save();

        $avg = $reviewObj->getRateAvgByItem( $item_type, $item_id );

        if ( !is_numeric( $avg ) )
        {
            $avg = 0;
        }

        if ( $item_type == 'listing' )
        {
            $listing = new Listing();
            $listing->setAvgReview( $avg, $item_id );
        }
        else if ( $item_type == 'article' )
        {
            $articles = new Article();
            $articles->setAvgReview( $avg, $item_id );
        }
        else
        {
            $promotions = new Promotion();
            $promotions->setAvgReview( $avg, $item_id );
        }

        /* send e-mail to owner */
        if ( $reviewObj->getString( 'item_type' ) == 'listing' )
        {
            $itemObj    = new Listing( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REVIEW ) )
            {

                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'listing' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'listing' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $reviewObj->getString( 'item_type' ) == 'article' )
        {
            $itemObj    = new Article( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REVIEW ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'article' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'article' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $reviewObj->getString( 'item_type' ) == 'promotion' )
        {
            $itemObj    = new Promotion( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REVIEW ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'promotion' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'promotion' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        $message = 1;
    }

    #--------------------------------------------------------------------------------
    # REPLY
    #--------------------------------------------------------------------------------
    if ( $status == "reply" )
    {
        $replyObj = new Review( $idReview );
        $replyObj->setNumber( 'responseapproved', 1 );
        $replyObj->Save();

        /* send e-mail to owner */
        if ( $replyObj->getString( 'item_type' ) == 'listing' )
        {
            $itemObj    = new Listing( $replyObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REPLY ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'listing' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'listing' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $replyObj->getString( 'item_type' ) == 'article' )
        {
            $itemObj    = new Article( $replyObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REPLY ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'article' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'article' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $replyObj->getString( 'item_type' ) == 'promotion' )
        {
            $itemObj    = new Promotion( $replyObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REPLY ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'promotion' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'promotion' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        $message = 7;
    }

    if ( $status == "both" )
    {
        $reviewObj = new Review( $idReview );
        $reviewObj->setNumber( 'responseapproved', 1 );
        $reviewObj->setNumber( 'approved', 1 );
        $reviewObj->Save();

        /* send e-mail to owner */
        if ( $reviewObj->getString( 'item_type' ) == 'listing' )
        {
            $itemObj    = new Listing( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REVIEW ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'listing' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'listing' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $reviewObj->getString( 'item_type' ) == 'article' )
        {
            $itemObj    = new Article( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REVIEW ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'article' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'article' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $reviewObj->getString( 'item_type' ) == 'promotion' )
        {
            $itemObj    = new Promotion( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REVIEW ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'promotion' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'promotion' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $reviewObj->getString( 'item_type' ) == 'listing' )
        {
            $itemObj    = new Listing( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REPLY ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'listing' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'listing' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $reviewObj->getString( 'item_type' ) == 'article' )
        {
            $itemObj    = new Article( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REPLY ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'article' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'article' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        if ( $reviewObj->getString( 'item_type' ) == 'promotion' )
        {
            $itemObj    = new Promotion( $reviewObj->getNumber( 'item_id' ) );
            $contactObj = new Contact( $itemObj->getNumber( "account_id" ) );

            if ( $emailNotificationObj = system_checkEmail( SYSTEM_APPROVE_REPLY ) )
            {
                $subject = $emailNotificationObj->getString( "subject" );
                $subject = system_replaceEmailVariables( $subject, $itemObj->getNumber( 'id' ), 'promotion' );
                $subject = html_entity_decode( $subject );

                $body = $emailNotificationObj->getString( "body" );
                $body = system_replaceEmailVariables( $body, $itemObj->getNumber( 'id' ), 'promotion' );
                $body = str_replace( $_SERVER["HTTP_HOST"], $domain->getString( "url" ), $body );
                $body = html_entity_decode( $body );

                Mailer::mail( $contactObj->getString( "email" ), $subject, $body, $emailNotificationObj->getString( "content_type" ), null, $emailNotificationObj->getString( "bcc" ) );
            }
        }

        $message = 8;
    }

    if ( $status == "comment" )
    {
        $commentObj = new Comments( $idComment );
        $commentObj->setNumber( "approved", 1 );
        $commentObj->Save();

        $is_reply = $commentObj->getNumber( "reply_id" );

        if ( $is_reply )
        {
            $message = 5;
        }
        else
        {
            $message = 4;
        }
    }

    $response .= "?message=".$message."&item_type=$item_type&item_id=$item_id&reply_id=$is_reply&screen=$screen&letter=$letter&item_letter=$item_letter&item_screen=$item_screen";
    header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/activity/reviews-comments/index.php".$response);
    exit;