<?php

	/*==================================================================*\
	######################################################################
	#                                                                    #
	# Copyright 2014 Arca Solutions, Inc. All Rights Reserved.           #
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
	# * FILE: /functions/api_funct.php
	# ----------------------------------------------------------------------------------------------------


    /**
	 * Prepare header and format json return
	 * @copyright Copyright 2014 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.	
     * @param array $return
     */
    function api_formatReturn($return) {
         
        header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", FALSE);
        header("Pragma: no-cache");
        header("Content-Type: application/json; charset=".EDIR_CHARSET, TRUE);
        echo json_encode($return);    
        exit;
        
    }
    
    /**
	 * Prepare order by parameters
	 * @copyright Copyright 2014 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.	
     * @param string $orderBy
     * @param string $orderSequence
     * @param array $aux_orderBy
     */
    function api_prepareOrderBy($orderBy, $resource, &$aux_orderBy) {
        
        if ($orderBy != "level" && $orderBy != "publication") {

            if ($orderBy == "title") {
                $aux_orderBy[] = "title";
                if ($resource != "deal" && $resource != "blog" && $resource != "post") {
                    $aux_orderBy[] = "level";
                }
                if (BACKLINK_FEATURE == "on" && $resource == "listing") {
                    $aux_orderBy[] = "backlink DESC";
                }
                if ($resource == "article") {
                    $aux_orderBy[] = "publication_date DESC";
                }
                if ($resource == "deal") {
                    $aux_orderBy[] = "end_date";
                }
                if ($resource != "blog" && $resource != "post") {
                    $aux_orderBy[] = "random_number DESC";
                }
                
                if ($resource == "event") {
                    $aux_orderBy[] = "end_date";
                    $aux_orderBy[] = "until_date";
                }
                
                if ($resource == "article") {
                    $aux_orderBy[] = "updated DESC";
                    $aux_orderBy[] = "entered DESC";
                }
                
                if ($resource == "blog" || $resource == "post") {
                    $aux_orderBy[] = "entered DESC";
                    $aux_orderBy[] = "updated DESC";
                }
                
            } elseif ($orderBy == "popular") {
                $aux_orderBy[] = "number_views DESC";
                if ($resource != "deal" && $resource != "blog" && $resource != "post") {
                    $aux_orderBy[] = "level";
                }
                if (BACKLINK_FEATURE == "on" && $resource == "listing") {
                    $aux_orderBy[] = "backlink DESC";
                }
                if ($resource == "article") {
                    $aux_orderBy[] = "publication_date DESC";
                }
                if ($resource == "deal") {
                    $aux_orderBy[] = "end_date";
                }
                if ($resource != "blog" && $resource != "post") {
                    $aux_orderBy[] = "random_number DESC";
                }
                if ($resource == "event") {
                    $aux_orderBy[] = "end_date";
                    $aux_orderBy[] = "until_date";
                    $aux_orderBy[] = "title";
                } elseif ($resource != "article" && $resource != "blog" && $resource != "post") {
                    $aux_orderBy[] = "title";
                }
                
                if ($resource == "article") {
                    $aux_orderBy[] = "updated DESC";
                    $aux_orderBy[] = "entered DESC";
                    $aux_orderBy[] = "title";
                }
                
                if ($resource == "blog" || $resource == "post") {
                    $aux_orderBy[] = "entered DESC";
                    $aux_orderBy[] = "updated DESC";
                    $aux_orderBy[] = "title";
                }
                
            } elseif ($orderBy == "rating") {
                $aux_orderBy[] = "avg_review DESC";
                if ($resource != "deal") {
                    $aux_orderBy[] = "level";
                }
                if (BACKLINK_FEATURE == "on" && $resource == "listing") {
                    $aux_orderBy[] = "backlink DESC";
                }
                if ($resource == "article") {
                    $aux_orderBy[] = "publication_date DESC";
                }
                if ($resource == "deal") {
                    $aux_orderBy[] = "end_date";
                }
                $aux_orderBy[] = "random_number DESC";
                if ($resource != "article") {
                    $aux_orderBy[] = "title"; 
                }
                
                if ($resource == "article") {
                    $aux_orderBy[] = "updated DESC";
                    $aux_orderBy[] = "entered DESC";
                    $aux_orderBy[] = "title";
                }
                
            } elseif ($orderBy == "updated") {
                $aux_orderBy[] = "updated DESC";
                if ($resource != "deal") {
                    $aux_orderBy[] = "level";
                }
                $aux_orderBy[] = "random_number DESC";
                $aux_orderBy[] = "title";
            } elseif ($orderBy == "distance") {
                $aux_orderBy[] = "distance_score";
                if ($resource != "deal") {
                    $aux_orderBy[] = "level";
                }
                if (BACKLINK_FEATURE == "on" && $resource == "listing") {
                    $aux_orderBy[] = "backlink DESC";
                }
                $aux_orderBy[] = "random_number DESC";
                $aux_orderBy[] = "title"; 
            } elseif ($orderBy == "date") {
                $aux_orderBy[] = "start_date";
                $aux_orderBy[] = "level";
                $aux_orderBy[] = "random_number DESC";
                $aux_orderBy[] = "end_date";
                $aux_orderBy[] = "until_date";
                $aux_orderBy[] = "title";
            } elseif ($orderBy == "active_items") {
                $aux_orderBy[] = "active_items DESC";
            }
        }
    }
    
    function api_validateRequest() {
        
    }
    
    function api_prepareDistance($myLat, $myLong, &$aux_fields, $deal = false) {
        if ($myLat && $myLong) {
            if (ZIPCODE_UNIT == "mile") {
                $aux_fields["distance_score"] = "IF (".($deal ? "listing_" : "")."latitude = '' OR ".($deal ? "listing_" : "")."longitude = '', 99999, SQRT(POW((69.1 * (".$myLat." - ".($deal ? "listing_" : "")."latitude)), 2) + POW((53.0 * (".$myLong." - ".($deal ? "listing_" : "")."longitude)), 2))) AS distance_score";
            } elseif (ZIPCODE_UNIT == "km") {
                $aux_fields["distance_score"] = "IF (".($deal ? "listing_" : "")."latitude = '' OR ".($deal ? "listing_" : "")."longitude = '', 99999, SQRT(POW((69.1 * (".$myLat." - ".($deal ? "listing_" : "")."latitude)), 2) + POW((53.0 * (".$myLong." - ".($deal ? "listing_" : "")."longitude)), 2)) * 1.609344) AS distance_score";
            }
        }
    }
    
    function api_getUserImage($accID) {
        $accountObj = new Account($accID);
        $profileObj = new Profile($accID);
        if ($accountObj->getString("has_profile") == "y") {
            $imgObj = new Image($profileObj->getNumber("image_id"), true);
            if ($imgObj->imageExists()) {
                return $imgObj->getPath();
            //No image
            } else {
                if ($profileObj->getString("facebook_image")) {
                    return $profileObj->getString("facebook_image");
                } else {
                    if (string_strpos($_SERVER["PHP_SELF"], "/".SITEMGR_ALIAS) !== false) {
                        return DEFAULT_URL."/".SITEMGR_ALIAS."/assets/img/profile-thumb.png";
                    } else {
                        return DEFAULT_URL."/assets/images/structure/icon-user-thumb.gif";
                    }                    
                }
            }
        //No image
        } else {
            if (string_strpos($_SERVER["PHP_SELF"], "/".SITEMGR_ALIAS) !== false) {
                return DEFAULT_URL."/".SITEMGR_ALIAS."/assets/img/profile-thumb.png";
            } else {
                return DEFAULT_URL."/assets/images/structure/icon-user-thumb.gif";
            }
        }
    }

?>