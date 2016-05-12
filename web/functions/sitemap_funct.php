<?php

    /* ==================================================================*\
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
      \*================================================================== */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /cron/sitemap_funct.php
    # ----------------------------------------------------------------------------------------------------

    function sitemap_printHeader( $encoding = "UTF-8" )
    {
        $buffer = "";
        $buffer .= "<?xml version=\"1.0\" encoding=\"".$encoding."\"?>".PHP_EOL;
        $buffer .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">".PHP_EOL;

        return $buffer;
    }

    function sitemap_printNodeUrl( $loc, $lastmod = false )
    {
        if ( !$lastmod )
        {
            $lastmod = date( "Y-m-d" );
        }

        $buffer  = "";
        $buffer .= "\t<url>".PHP_EOL;
        $buffer .= "\t\t<loc>".$loc."</loc>".PHP_EOL;
        $buffer .= "\t\t<lastmod>".$lastmod."</lastmod>".PHP_EOL;
        $buffer .= "\t</url>".PHP_EOL;

        return $buffer;
    }

    function sitemap_printFooter()
    {
        $buffer = "";
        $buffer .= "</urlset>".PHP_EOL;

        return $buffer;
    }

    function sitemap_printHeaderNews( $encoding = "UTF-8" )
    {
        $buffer = "";
        $buffer .= "<?xml version=\"1.0\" encoding=\"".$encoding."\"?>".PHP_EOL;
        $buffer .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:news=\"http://www.google.com/schemas/sitemap-news/0.9\">".PHP_EOL;

        return $buffer;
    }

    function sitemap_printNodeUrlNews( $loc, $publication_date = false, $keywords = false, $title = false, $language = false )
    {
        if ( !$publication_date )
        {
            $publication_date = date( "Y-m-d" );
        }

        if ( !$keywords )
        {
            $keywords = "";
        }

        $buffer           = "";
        $buffer .= "\t<url>".PHP_EOL;
        $buffer .= "\t\t<loc>".$loc."</loc>".PHP_EOL;
        $buffer .= "\t\t<news:news>".PHP_EOL;

        if( $title && $language )
        {
            $buffer .= "\t\t\t<news:publication>".PHP_EOL;
            $buffer .= "\t\t\t\t<news:name>".$title."</news:name>".PHP_EOL;
            $buffer .= "\t\t\t\t<news:language>".$language."</news:language>".PHP_EOL;
            $buffer .= "\t\t\t</news:publication>".PHP_EOL;
        }

        $title       and $buffer .= "\t\t\t<news:title>".$title."</news:title>".PHP_EOL;
        $buffer .= "\t\t\t<news:publication_date>".$publication_date."</news:publication_date>".PHP_EOL;
        $buffer .= "\t\t\t<news:keywords>".$keywords."</news:keywords>".PHP_EOL;
        $buffer .= "\t\t</news:news>".PHP_EOL;
        $buffer .= "\t</url>".PHP_EOL;

        return $buffer;
    }

    function sitemap_printFooterNews()
    {
        $buffer = "";
        $buffer .= "</urlset>".PHP_EOL;

        return $buffer;
    }

    function sitemap_indexPrintHeader( $encoding = "UTF-8" )
    {
        $buffer = "";
        $buffer .= "<?xml version=\"1.0\" encoding=\"".$encoding."\"?>".PHP_EOL;
        $buffer .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">".PHP_EOL;

        return $buffer;
    }

    function sitemap_indexPrintNodeSitemap( $file, $lastmod = false )
    {
        setting_get( "default_url", $url );

        $url_protocol = "http://".(SITEMAP_ADD_WWW == "on" ? "www." : "");

        $default_url  = "$url_protocol$url".EDIRECTORY_FOLDER;
        $sitemap_loc  = $default_url."/custom/domain_".SELECTED_DOMAIN_ID."/sitemap/".$file;

        if ( !$lastmod )
        {
            $lastmod = date( "Y-m-d" );
        }

        $buffer       = "";
        $buffer .= "\t<sitemap>".PHP_EOL;
        $buffer .= "\t\t<loc>".$sitemap_loc."</loc>".PHP_EOL;
        $buffer .= "\t\t<lastmod>".$lastmod."</lastmod>".PHP_EOL;
        $buffer .= "\t</sitemap>".PHP_EOL;
        return $buffer;
    }

    function sitemap_indexPrintFooter()
    {
        $buffer = "";
        $buffer .= "</sitemapindex>".PHP_EOL;
        return $buffer;
    }

    function sitemap_writeFile( $file_path, $file_content )
    {
        $file = @fopen( $file_path, "w" );

        if ( !is_writeable( $file_path ) )
        {
            die( "File: $file_path is not writable".PHP_EOL );
        }

        if ( $file )
        {
            if ( fwrite( $file, $file_content ) )
            {
                fclose( $file );
                return true;
            }
        }

        @fclose( $file );
        return false;
    }

    function sitemap_buildUrlPath( $_locations, $_location_level, $location_father_id, &$buffer_location, $location_str, &$url_number, &$file_number, &$files, $module )
    {
        system_retrieveLocationRelationship( $_locations, $_location_level, $_location_father_level, $_location_child_level );
        $dbObj = db_getDBObject( DEFAULT_DB, true );

        //Get locations with records
        $dbObjDomain   = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbObj );
        $tableLocation = "";

        switch ( $module )
        {
            case "listing": $tableLocation = "Listing_LocationCounter";
                break;
            case "event": $tableLocation = "Event_LocationCounter";
                break;
            case "classified": $tableLocation = "Classified_LocationCounter";
                break;
            case "deal": $tableLocation = "Promotion_LocationCounter";
                break;
        }

        if ( $tableLocation )
        {
            $sqlAux    = "SELECT location_id FROM $tableLocation WHERE location_level = ".$_location_level." AND count > 0";
            $resultAux = $dbObjDomain->query( $sqlAux );
            $strIds    = "";

            while ( $rowAux    = mysql_fetch_assoc( $resultAux ) )
            {
                $strIds .= $rowAux["location_id"].",";
            }

            $strIds = substr( $strIds, 0, -1 );
        }

        $location_query   = "SELECT id, name, friendly_url FROM Location_".$_location_level." WHERE location_".$_location_father_level."=".$location_father_id." ".($strIds ? " AND id IN ($strIds)" : "")." ORDER BY name";

        unset( $locations_result );
        $path             = EDIRECTORY_ROOT;
        $locations_result = $dbObj->query( $location_query );

        while ( $location         = mysql_fetch_array( $locations_result ) )
        {
            if ( $url_number <= 0 )
            {
                $buffer_location .= sitemap_printHeader();
            }

            $str_location_toWrite = $location_str."/".$location['friendly_url'];
            $location_id          = $location['id'];
            $buffer_location .= sitemap_printNodeUrl( $str_location_toWrite, $default_lastmod );
            $url_number++;

            if ( $url_number == SITEMAP_MAXURL )
            {
                $buffer_location .= sitemap_printFooter();

                if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'location'.$file_number.'.xml', $buffer_location ) )
                {
                    die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'location'.$file_number.'.xml!'.PHP_EOL );
                }

                $buffer_location = "";
                $files[]         = $module."location".$file_number.".xml";
                $file_number++;
                $url_number      = 0;
            }

            if ( $_location_child_level )
            {
                sitemap_buildUrlPath( $_locations, $_location_child_level, $location_id, $buffer_location, $location_str, $url_number, $file_number, $files, $module );
            }
        }
    }

    function sitemap_createModuleLocations( $path, $module )
    {
        $dbObj            = db_getDBObject( DEFAULT_DB, true );

        setting_get( "default_url", $url );

        $url_protocol     = "http://".(SITEMAP_ADD_WWW == "on" ? "www." : "");
        $default_url      = "$url_protocol$url";
        $item_default_url = constant( string_strtoupper( $module )."_DEFAULT_URL" );

        if ( !$_SERVER["HTTP_HOST"] )
        {
            if ( string_strpos( $item_default_url, $default_url ) === false )
            {
                $item_default_url = $default_url.str_replace( "http://", "", $item_default_url );
            }
        }

        if ( $module == "promotion" )
        {
            $module = "deal";
        }

        $_locations      = explode( ",", EDIR_LOCATIONS );
        $_location_level = $_locations[0];

        system_retrieveLocationRelationship( $_locations, $_location_level, $_location_father_level, $_location_child_level );

        //Get locations with records
        $dbObjDomain   = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbObj );
        $tableLocation = "";

        switch ( $module )
        {
            case "listing": $tableLocation = "Listing_LocationCounter";
                break;
            case "event": $tableLocation = "Event_LocationCounter";
                break;
            case "classified": $tableLocation = "Classified_LocationCounter";
                break;
            case "deal": $tableLocation = "Promotion_LocationCounter";
                break;
        }

        if ( $tableLocation )
        {
            $sqlAux    = "SELECT location_id FROM $tableLocation WHERE location_level = ".$_location_level." AND count > 0";
            $resultAux = $dbObjDomain->query( $sqlAux );
            $strIds    = "";

            while ( $rowAux    = mysql_fetch_assoc( $resultAux ) )
            {
                $strIds .= $rowAux["location_id"].",";
            }

            $strIds = substr( $strIds, 0, -1 );
        }

        $location_query   = "SELECT id, name, friendly_url FROM Location_".$_location_level." ".($strIds ? " WHERE id IN ($strIds)" : "")." ORDER BY name";

        unset( $locations_result );

        $locations_result = $dbObj->query( $location_query );
        $default_lastmod  = date( "Y-m-d" );
        $buffer_location  = "";
        $files            = false;
        $file_number      = 0;
        $url_number       = 0;

        while ( $location         = mysql_fetch_array( $locations_result ) )
        {
            if ( $url_number <= 0 )
            {
                $buffer_location .= sitemap_printHeader();
            }

            $location_str = $item_default_url."/".$location['friendly_url'];
            $location_id  = $location['id'];
            $buffer_location .= sitemap_printNodeUrl( $location_str, $default_lastmod );
            $url_number++;

            if ( $url_number == SITEMAP_MAXURL )
            {
                $buffer_location .= sitemap_printFooter();

                if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'location'.$file_number.'.xml', $buffer_location ) )
                {
                    die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'location'.$file_number.'.xml!'.PHP_EOL );
                }

                $buffer_location = "";
                $files[]         = $module."location".$file_number.".xml";
                $file_number++;
                $url_number      = 0;
            }

            if ( $_location_child_level )
            {
                sitemap_buildUrlPath( $_locations, $_location_child_level, $location_id, $buffer_location, $item_default_url, $url_number, $file_number, $files, $module );
            }
        }

        if ( $url_number > 0 )
        {
            $buffer_location .= sitemap_printFooter();

            if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'location'.$file_number.'.xml', $buffer_location ) )
            {
                die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'location'.$file_number.'.xml!'.PHP_EOL );
            }

            $buffer_location = "";
            $files[]         = $module."location".$file_number.".xml";
            $file_number++;
            $url_number      = 0;
        }

        return $files;
    }

    function sitemap_createModuleCategories( $path, $module )
    {
        $dbObjMain        = db_getDBObject( DEFAULT_DB, true );
        $dbObj            = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbObjMain );

        setting_get( "default_url", $url );

        $url_protocol     = "http://".(SITEMAP_ADD_WWW == "on" ? "www." : "");

        $default_url      = "$url_protocol$url";
        $item_default_url = constant( string_strtoupper( $module )."_DEFAULT_URL" );

        if ( !$_SERVER["HTTP_HOST"] )
        {
            if ( string_strpos( $item_default_url, $default_url ) === false )
            {
                $item_default_url = $default_url.str_replace( "http://", "", $item_default_url );
            }
        }

        if ( $module == "promotion" )
        {
            $module = "deal";
        }

        $table = string_ucwords( $module );
        if ( $module == "deal" )
        {
            $table = string_ucwords( "listing" );
        }

        if ( $module == "blog" )
        {
            $module = "post";
        }

        switch ( $module )
        {
            case "listing": $activeField = "active_listing";
                break;
            case "event": $activeField = "active_event";
                break;
            case "classified": $activeField = "active_classified";
                break;
            case "article": $activeField = "active_article";
                break;
            case "post": $activeField = "active_post";
                break;
            case "deal": $activeField = "";
                break;
        }

        $category_query = "SELECT id,
                                  title,
                                  friendly_url
                            FROM ".$table."Category
                            WHERE category_id = 0 AND
                                  title != '' AND
                                  friendly_url != '' AND
                                  enabled = 'y'".($activeField ? " AND $activeField > 0" : "")."
                         ORDER BY title";

        $category_result = $dbObj->query( $category_query );
        $default_lastmod = date( "Y-m-d" );
        $buffer_category = "";
        $files           = false;
        $file_number     = 0;
        $url_number      = 0;

        if ( mysql_num_rows( $category_result ) )
        {
            while ( $category_row = mysql_fetch_array( $category_result ) )
            {
                if ( $url_number <= 0 )
                {
                    $buffer_category .= sitemap_printHeader();
                }

                $category_str = $item_default_url."/".$category_row['friendly_url'];
                $buffer_category .= sitemap_printNodeUrl( $category_str, $default_lastmod );
                $url_number++;

                if ( $url_number == SITEMAP_MAXURL )
                {
                    $buffer_category .= sitemap_printFooter();

                    if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'category'.$file_number.'.xml', $buffer_category ) )
                    {
                        die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'category'.$file_number.'.xml!'.PHP_EOL );
                    }

                    $buffer_category = "";
                    $files[]         = $module."category".$file_number.".xml";
                    $file_number++;
                    $url_number      = 0;
                }

                $sub1category_query  = "SELECT id, title, friendly_url FROM ".$table."Category WHERE category_id=".$category_row['id']." AND title !='' AND friendly_url != '' AND enabled = 'y' ".($activeField ? " AND $activeField > 0" : "")." ORDER BY title";
                $sub1category_result = $dbObj->query( $sub1category_query );

                if ( mysql_num_rows( $sub1category_result ) )
                {
                    while ( $sub1category_row = mysql_fetch_array( $sub1category_result ) )
                    {
                        if ( $url_number <= 0 )
                        {
                            $buffer_category .= sitemap_printHeader();
                        }

                        $category_str = $item_default_url."/".$sub1category_row['friendly_url'];
                        $buffer_category .= sitemap_printNodeUrl( $category_str, $default_lastmod );
                        $url_number++;

                        if ( $url_number == SITEMAP_MAXURL )
                        {
                            $buffer_category .= sitemap_printFooter();

                            if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'category'.$file_number.'.xml', $buffer_category ) )
                            {
                                die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'category'.$file_number.'.xml!'.PHP_EOL );
                            }

                            $buffer_category = "";
                            $files[]         = $module."category".$file_number.".xml";
                            $file_number++;
                            $url_number      = 0;
                        }

                        $sub2category_query  = "SELECT id, title, friendly_url FROM ".$table."Category WHERE category_id=".$sub1category_row['id']." AND title !='' AND friendly_url != '' AND enabled = 'y' ".($activeField ? " AND $activeField > 0" : "")." ORDER BY title";
                        $sub2category_result = $dbObj->query( $sub2category_query );

                        if ( mysql_num_rows( $sub2category_result ) )
                        {
                            while ( $sub2category_row = mysql_fetch_array( $sub2category_result ) )
                            {
                                if ( $url_number <= 0 )
                                {
                                    $buffer_category .= sitemap_printHeader();
                                }

                                $category_str = $item_default_url."/".$sub2category_row['friendly_url'];
                                $buffer_category .= sitemap_printNodeUrl( $category_str, $default_lastmod );
                                $url_number++;

                                if ( $url_number == SITEMAP_MAXURL )
                                {
                                    $buffer_category .= sitemap_printFooter();

                                    if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'category'.$file_number.'.xml', $buffer_category ) )
                                    {
                                        die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'category'.$file_number.'.xml!'.PHP_EOL );
                                    }

                                    $buffer_category = "";
                                    $files[]         = $module."category".$file_number.".xml";
                                    $file_number++;
                                    $url_number      = 0;
                                }

                                $sub3category_query  = "SELECT id, title, friendly_url FROM ".$table."Category WHERE category_id=".$sub2category_row['id']." AND title != '' AND friendly_url != '' AND enabled = 'y' ".($activeField ? " AND $activeField > 0" : "")." ORDER BY title";
                                $sub3category_result = $dbObj->query( $sub3category_query );

                                if ( mysql_num_rows( $sub3category_result ) )
                                {
                                    while ( $sub3category_row = mysql_fetch_array( $sub3category_result ) )
                                    {
                                        if ( $url_number <= 0 )
                                        {
                                            $buffer_category .= sitemap_printHeader();
                                        }

                                        $category_str = $item_default_url."/".$sub3category_row['friendly_url'];
                                        $buffer_category .= sitemap_printNodeUrl( $category_str, $default_lastmod );
                                        $url_number++;

                                        if ( $url_number == SITEMAP_MAXURL )
                                        {
                                            $buffer_category .= sitemap_printFooter();

                                            if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'category'.$file_number.'.xml', $buffer_category ) )
                                            {
                                                die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'category'.$file_number.'.xml!'.PHP_EOL );
                                            }

                                            $buffer_category = "";
                                            $files[]         = $module."category".$file_number.".xml";
                                            $file_number++;
                                            $url_number      = 0;
                                        }

                                        $sub4category_query  = "SELECT id, title, friendly_url FROM ".$table."Category WHERE category_id=".$sub3category_row['id']." AND title !='' AND friendly_url != '' AND enabled = 'y' ".($activeField ? " AND $activeField > 0" : "")." ORDER BY title";
                                        $sub4category_result = $dbObj->query( $sub4category_query );

                                        if ( mysql_num_rows( $sub4category_result ) )
                                        {
                                            while ( $sub4category_row = mysql_fetch_array( $sub4category_result ) )
                                            {
                                                if ( $url_number <= 0 )
                                                {
                                                    $buffer_category .= sitemap_printHeader();
                                                }

                                                $category_str = $item_default_url."/".$sub4category_row['friendly_url'];
                                                $buffer_category .= sitemap_printNodeUrl( $category_str, $default_lastmod );
                                                $url_number++;

                                                if ( $url_number == SITEMAP_MAXURL )
                                                {
                                                    $buffer_category .= sitemap_printFooter();

                                                    if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'category'.$file_number.'.xml', $buffer_category ) )
                                                    {
                                                        die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'category'.$file_number.'.xml!'.PHP_EOL );
                                                    }

                                                    $buffer_category = "";
                                                    $files[]         = $module."category".$file_number.".xml";
                                                    $file_number++;
                                                    $url_number      = 0;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ( $url_number > 0 )
        {
            $buffer_category .= sitemap_printFooter();

            if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'category'.$file_number.'.xml', $buffer_category ) )
            {
                die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$module.'category'.$file_number.'.xml!'.PHP_EOL );
            }

            $buffer_category = "";
            $files[]         = $module."category".$file_number.".xml";
            $file_number++;
            $url_number      = 0;
        }

        if ( is_array( $files ) )
        {
            return $files;
        }
        else
        {
            return false;
        }
    }

    function sitemap_createModuleDetails( $path, $module )
    {
        $dbObjMain        = db_getDBObject( DEFAULT_DB, true );
        $dbObj            = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbObjMain );

        setting_get( "default_url", $url );

        $url_protocol     = "http://".(SITEMAP_ADD_WWW == "on" ? "www." : "");
        $default_url      = "$url_protocol$url";
        $item_default_url = constant( string_strtoupper( $module )."_DEFAULT_URL" );

        if ( !$_SERVER["HTTP_HOST"] )
        {
            if ( string_strpos( $item_default_url, $default_url ) === false )
            {
                $item_default_url = $default_url.str_replace( "http://", "", $item_default_url );
            }
        }

        if ( $module == "blog" )
        {
            $items_query  = "SELECT id, DATE(updated) AS updated, title, friendly_url FROM Post WHERE status = 'A' ORDER BY title";
            $items_result = $dbObj->query( $items_query );
            $module       = "post";
        }
        elseif ( $module == "promotion" )
        {
            $levelspromotion_query  = "SELECT value FROM ListingLevel WHERE has_promotion = 'y' AND theme = '".EDIR_THEME."'";
            $levelspromotion_result = $dbObj->query( $levelspromotion_query );
            $levelspromotion        = array();

            while ( $arr                    = mysql_fetch_array( $levelspromotion_result ) )
            {
                $levelspromotion[] = $arr['value'];
            }

            $items_query  = "SELECT id, DATE(updated) AS updated, name as title, friendly_url FROM Promotion WHERE Promotion.listing_status = 'A' AND Promotion.end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND Promotion.start_date <= DATE_FORMAT(NOW(), '%Y-%m-%d') AND Promotion.amount > 0 AND Promotion.listing_id > 0 AND Promotion.listing_level IN ('".implode( ',', $levelspromotion )."') ORDER BY title";
            $items_result = $dbObj->query( $items_query );
            $module       = "deal";
        }
        else
        {

            $levelsdetail_query  = "SELECT value FROM ".ucfirst( $module )."Level WHERE detail = 'y' AND theme = '".EDIR_THEME."'";
            $levelsdetail_result = $dbObj->query( $levelsdetail_query );
            $levelsdetail        = array();

            while ( $arr                 = mysql_fetch_array( $levelsdetail_result ) )
            {
                $levelsdetail[] = $arr['value'];
            }

            $items_query  = "SELECT id, DATE(updated) AS updated, title, friendly_url FROM ".ucfirst( $module )." WHERE FIND_IN_SET(level, '".implode( ',', $levelsdetail )."') AND status = 'A' ORDER BY title";
            $items_result = $dbObj->query( $items_query );
        }

        $buffer_moduleDetails = "";
        $files                = false;
        $file_number          = 0;
        $url_number           = 0;

        while ( $item                 = mysql_fetch_array( $items_result ) )
        {
            if ( $url_number <= 0 )
            {
                $buffer_moduleDetails .= sitemap_printHeader();
            }

            $loc     = "".$item_default_url."/".$item['friendly_url'].".html";
            $lastmod = $item['updated'];
            $buffer_moduleDetails .= sitemap_printNodeUrl( $loc, $lastmod );
            $url_number++;

            if ( $url_number == SITEMAP_MAXURL )
            {
                $buffer_moduleDetails .= sitemap_printFooter();

                if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'detail'.$file_number.'.xml', $buffer_moduleDetails ) )
                {
                    die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'detail'.$file_number.'.xml!'.PHP_EOL );
                }

                $buffer_moduleDetails = "";
                $files[]              = $module."detail".$file_number.".xml";
                $file_number++;
                $url_number           = 0;
            }
        }
        if ( $url_number > 0 )
        {
            $buffer_moduleDetails .= sitemap_printFooter();

            if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'detail'.$file_number.'.xml', $buffer_moduleDetails ) )
            {
                die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'detail'.$file_number.'.xml!'.PHP_EOL );
            }

            $buffer_moduleDetails = "";
            $files[]              = $module."detail".$file_number.".xml";
            $file_number++;
            $url_number           = 0;
        }

        return $files;
    }

    function sitemap_createModuleNews( $path, $module )
    {
        $dbObjMain = db_getDBObject( DEFAULT_DB, true );
        $dbObj     = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbObjMain );

        setting_get( "default_url", $url );

        $url_protocol     = "http://".(SITEMAP_ADD_WWW == "on" ? "www." : "");
        $default_url      = "$url_protocol$url";
        $item_default_url = constant( string_strtoupper( $module )."_DEFAULT_URL" );

        if ( !$_SERVER["HTTP_HOST"] )
        {
            if ( string_strpos( $item_default_url, $default_url ) === false )
            {
                $item_default_url = $default_url.str_replace( "http://", "", $item_default_url );
            }
        }

        $items_query       = "SELECT id, DATE(updated) AS updated, title, friendly_url, seo_keywords FROM ".ucfirst( $module )." WHERE status='A' AND ( DATE( `updated` ) BETWEEN DATE_SUB( CURDATE(), INTERVAL 2 DAY ) AND CURDATE() ) ORDER BY title";
        $items_result      = $dbObj->query( $items_query );
        $buffer_moduleNews = "";
        $files             = false;
        $file_number       = 0;
        $url_number        = 0;

        while ( $item = mysql_fetch_array( $items_result ) )
        {
            if ( $url_number <= 0 )
            {
                $buffer_moduleNews .= sitemap_printHeaderNews();
            }

            /**
             * <Lucas Trentim (2015)>
             * @todo: This is supposed to be a ISO 639 Language Code, and reCaptcha happens to use them aswell.
             * This is temporary, just to avoid data replication. We should build a proper class full of
             * such dictionaries, so all data is centered in one place and all others draw from it.
             *
             * Just hope not to visit this comment in some years and tell myself: "temporary my ass"
             */

            $languageLibrary = array(
                "en_us" => "en",
                "pt_br" => "pt-BR",
                "es_es" => "es",
                "tr_tr" => "tr",
                "ge_ge" => "de",
                "fr_fr" => "fr",
                "it_it" => "it",
            );

            $loc              = "".$item_default_url."/".$item['friendly_url'].".html";
            $publication_date = $item['updated'];
            $keywords         = $item['seo_keywords'];
            $title            = $item['title'];
            $language         = $languageLibrary[EDIR_LANGUAGE];

            $buffer_moduleNews .= sitemap_printNodeUrlNews( $loc, $publication_date, $keywords, $title, $language );
            $url_number++;

            if ( $url_number == SITEMAP_MAXURL )
            {
                $buffer_moduleNews .= sitemap_printFooterNews();

                if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'news'.$file_number.'.xml', $buffer_moduleNews ) )
                {
                    die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'news'.$file_number.'.xml!'.PHP_EOL );
                }

                $buffer_moduleNews = "";
                $files[]           = $module."news".$file_number.".xml";
                $file_number++;
                $url_number        = 0;
            }
        }

        if ( $url_number > 0 )
        {
            $buffer_moduleNews .= sitemap_printFooterNews();

            if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'news'.$file_number.'.xml', $buffer_moduleNews ) )
            {
                die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/'.$module.'news'.$file_number.'.xml!'.PHP_EOL );
            }

            $buffer_moduleNews = "";
            $files[]           = $module."news".$file_number.".xml";
            $file_number++;
            $url_number        = 0;
        }

        return $files;
    }

    function sitemap_createContentMap( $path )
    {
        $dbObjMain      = db_getDBObject( DEFAULT_DB, true );
        $dbObj          = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbObjMain );

        setting_get( "default_url", $url );

        $url_protocol   = "http://".(SITEMAP_ADD_WWW == "on" ? "www." : "");
        $default_url    = "$url_protocol$url";
        $content_query  = "SELECT C.`id`, C.`updated`, C.`title`, C.`url` FROM `Content` AS C WHERE C.`section` = 'client' AND C.`url` != '' AND C.`sitemap` = '1'";
        $content_result = $dbObj->query( $content_query );
        $buffer_content = "";
        $files          = false;
        $file_number    = 0;
        $url_number     = 0;

        while ( $content        = mysql_fetch_array( $content_result ) )
        {
            if ( $url_number <= 0 )
            {
                $buffer_content .= sitemap_printHeader();
            }

            if ( string_strpos( $content['updated'], "0000-00-00" ) !== false )
            {
                $lastmod = date( "Y-m-d" );
            }
            else
            {
                $lastmod = date( "Y-m-d", strtotime( $content['updated'] ) );
            }

            $loc = $default_url."/".$content['url'].".html";
            $buffer_content .= sitemap_printNodeUrl( $loc, $lastmod );
            $url_number++;

            if ( $url_number == SITEMAP_MAXURL )
            {
                $buffer_content .= sitemap_printFooter();
                if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$file_number.'.xml', $buffer_content ) )
                {
                    die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$file_number.'.xml!'.PHP_EOL );
                }
                $buffer_content = "";
                $files[]        = "content".$file_number.".xml";
                $file_number++;
                $url_number     = 0;
            }
        }

        if ( $url_number > 0 )
        {
            $buffer_content .= sitemap_printFooter();
            if ( !sitemap_writeFile( $path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$file_number.'.xml', $buffer_content ) )
            {
                die( 'ERROR WHILE SAVING THE '.$path.'/custom/domain_'.SELECTED_DOMAIN_ID.'/sitemap/content'.$file_number.'.xml!'.PHP_EOL );
            }
            $buffer_content = "";
            $files[]        = "content".$file_number.".xml";
            $file_number++;
            $url_number     = 0;
        }

        return $files;
    }
