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
	# * FILE: /includes/code/deal_ajax_interface.php
	# ----------------------------------------------------------------------------------------------------

    # ----------------------------------------------------------------------------------------------------
    # LOAD CONFIG
    # ----------------------------------------------------------------------------------------------------
    include("../../conf/loadconfig.inc.php");

    # ----------------------------------------------------------------------------------------------------
    # SESSION
    # ----------------------------------------------------------------------------------------------------
    sess_validateSMSession();

    header( "Content-Type: ".($_GET["sitemgr"] ? "application/json;" : "text/html;")." charset=".EDIR_CHARSET, TRUE );
    header( "Accept-Encoding: gzip, deflate" );
    header( "Expires: Sat, 01 Jan 2000 00:00:00 GMT" );
    header( "Cache-Control: no-store, no-cache, must-revalidate" );
    header( "Cache-Control: post-check=0, pre-check", FALSE );
    header( "Pragma: no-cache" );

    $response = null;

    switch ( $_POST['action'] )
    {
        case "getAllListings":
            $accountId = (int)$_POST['accountId'];
            $listingId = (int)$_POST['listingId'];

            $dbMain = db_getDBObject( DEFAULT_DB, true );
            $dbObj  = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbMain );

            /**
             * Get level with promotion
             */
            $levelObj = new ListingLevel();
            $levels   = $levelObj->getValues();
            foreach ( $levels as $level )
            {
                if ( $levelObj->getHasPromotion( $level ) == "y" )
                {
                    $dealLevels[] = $level;
                }
            }

            $dealLevels = implode( ",", $dealLevels );
            $listingId and $orSegment = " OR ( id = $listingId )";

            $sql = "SELECT `id`, `title`, `status`,`account_id`
                    FROM `Listing_Summary`
                    WHERE (
                        `promotion_id` = 0 AND
                        `account_id` = {$accountId} AND
                        `level` IN ({$dealLevels})
                    )
                    $orSegment
                    ORDER BY `title`";

            $result = $dbObj->query( $sql );

            while ( $rowListings = mysql_fetch_assoc( $result ) )
            {
                $response[] = array(
                    "label" => $rowListings["title"],
                    "id" => $rowListings["id"]
                );
            }

            break;

        case "getAllDeals":
            $accountId   = (int)$_POST['accountId'];
            $promotionId = (int)$_POST['promotionId'];

            $dbMain = db_getDBObject( DEFAULT_DB, true );
            $dbObj  = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbMain );

            $promotionId and $orSegment = " OR ( id = $promotionId )";

            $sql = "SELECT `id`, `name`
                    FROM `Promotion`
                    WHERE (
                        `listing_id` = 0 AND
                        `account_id` = $accountId
                        )
                    $orSegment
                    ORDER BY `name`";

            $result = $dbObj->query( $sql );

            while ( $rowListings = mysql_fetch_assoc( $result ) )
            {
                $response[] = array(
                    "label" => $rowListings["name"],
                    "id"    => $rowListings["id"]
                );
            }
            break;
    }

    echo json_encode( $response );


