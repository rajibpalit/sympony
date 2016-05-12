<?

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
	# * FILE: /functions/search_funct.php
	# ----------------------------------------------------------------------------------------------------

	function search_frontListingSearch($search_for, $section, $mobile = false) {
        
		$searchReturn["select_columns"] = false;
		$searchReturn["from_tables"]    = false;
		$searchReturn["where_clause"]   = false;
		$searchReturn["group_by"]       = false;
		$searchReturn["order_by"]       = false;

		$orderByConf =  array("characters",
							"lastupdate",
							"datecreated",
							"popular",
							"rating");
			
        $selecId = false;

        if ($section == "listing_results_api") {
            $section = "listing_results";
            $selecId = true;
        }
		
        $user_order_by = "";
		if (in_array($_GET["orderby"], $orderByConf)) {
			$user_order_by = $_GET["orderby"];
		}

		if (($section == "listing") || ($section == "mobile")) {
			$searchReturn["select_columns"] = (FORCE_SECOND ? "Listing_Summary.*" : "Listing.*");
		} elseif ($section == "random" && !$mobile) {
            $searchReturn["select_columns"] = (FORCE_SECOND ? "Listing_Summary.id, Listing_Summary.title, Listing_Summary.description, Listing_Summary.friendly_url, Listing_Summary.account_id, Listing_Summary.thumb_id, Listing_Summary.image_id " : "Listing.*");
		} elseif ($section == "listing_results" || ($section == "random" && $mobile)) {
            
            $db = db_getDBObject();
            
			/*
			 * Get fields of Listing_Summary Table
			 */
            if ($selecId) {
                $listing_fields = "Listing_Summary.id";
            } else {
                
                if (!defined("DESC_LISTING_SUMMARY")) {
                    $sql_fields = "DESC Listing_Summary";
                    $result = $db->query($sql_fields);
                    if (mysql_num_rows($result) > 0) {
                        $aux_fields_array = array();
                        while ($row = mysql_fetch_assoc($result)) {
                            $aux_fields_array[] = "Listing_Summary.".$row["Field"];
                        }
                        if (count($aux_fields_array) > 0) {
                            $listing_fields = implode(",", $aux_fields_array);
                        } else {
                            $listing_fields = "Listing_Summary.*";
                        }
                    } else {
                        $listing_fields = "Listing_Summary.*";
                    }
                    define("DESC_LISTING_SUMMARY", $listing_fields);
                } else {
                    $listing_fields = DESC_LISTING_SUMMARY;
                }
            }
			            
			$searchReturn["select_columns"] = $listing_fields;
			
            if (SEARCH_FORCE_BOOLEANMODE == "on") {
                $searchReturn["select_columns"] = $searchReturn["select_columns"].", Listing_Summary.title REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
            }

		} elseif ($section == "count") {
			$searchReturn["select_columns"] = "COUNT(DISTINCT(Listing_Summary.id))";
		} elseif ($section == "rss") {
			$searchReturn["select_columns"] = (FORCE_SECOND ? "Listing_Summary.id" : "Listing.id");"Listing.id";
			$searchReturn["from_tables"] = (FORCE_SECOND ? "Listing_Summary" : "Listing");
		}

		if (($section == "listing") || ($section == "mobile")) {
			$searchReturn["from_tables"] = (FORCE_SECOND ? "Listing_Summary" : "Listing");
		} elseif ($section == "count") {
			$searchReturn["from_tables"] = "Listing_Summary";
		} elseif ($section == "random") {
			$searchReturn["from_tables"] = "Listing_FeaturedTemp
											LEFT JOIN ".(FORCE_SECOND ? "Listing_Summary Listing_Summary" : "Listing Listing")." ON (".(FORCE_SECOND ? "Listing_Summary.id" : "Listing.id")." = Listing_FeaturedTemp.listing_id)";
		} elseif ($section == "listing_results") {
			$searchReturn["from_tables"] = "Listing_Summary";
		}
		
		if (isset($search_for["id"]) && is_numeric($search_for["id"])) {
			if ($section == "listing_results") {
				$where_clause[] = "Listing_Summary.id = ".$search_for["id"]."";
			} else {
				$where_clause[] = (FORCE_SECOND ? "Listing_Summary" : "Listing").".id = ".$search_for["id"]."";
			}
		}

        if (isset($search_for["except_id"])) {
			if ($section == "listing_results") {
				$where_clause[] = "Listing_Summary.id NOT IN (".$search_for["except_id"].") ";
			} else {
				$where_clause[] = (FORCE_SECOND ? "Listing_Summary" : "Listing").".id NOT IN (".$search_for["except_id"].")";
			}
		}

        $sitemgrPreview = sess_validateItemPreview();
		if (!$search_for["category_id"] && !$search_for["categories"] && !$sitemgrPreview) {
			if ($section == "listing_results") {
				$where_clause[] = "Listing_Summary.status = 'A'";
			} elseif ($section == "random") {
				$where_clause[] = (FORCE_SECOND ? "Listing_Summary" : "Listing").".status = 'A'";
			} else {
				$where_clause[] = "Listing_Summary.status = 'A'";
			}
		}
        
        if ($search_for["rating"]) {
            $ratings = explode("-", $search_for["rating"]);
            $where_clause[] = "Listing_Summary.avg_review IN (".implode(",", $ratings).")";
        } else {
            if ($search_for["avg_review"]) {
                $where_clause[] = "Listing_Summary.avg_review = ".$search_for["avg_review"];
            }
        }
        
        if ($search_for["price"]) {
            $where_clause[] = "Listing_Summary.price = ".$search_for["price"];
        }
        
        if ($search_for["filter_price"]) {
            $aux_filterPrice = str_replace("-", ",", $search_for["filter_price"]);
            $where_clause[] = "Listing_Summary.price IN (".$aux_filterPrice.")";
            
        }
        
        if ($search_for["filter_deal"]) {
            
            //Get available promotions ids
            $search_forDeal = $search_for;
            unset($search_forDeal["rating"]);
            $searchReturnDeal = search_frontPromotionSearch($search_forDeal, "promotion_results");
            $sql = "SELECT id FROM ".$searchReturnDeal["from_tables"]." WHERE ".$searchReturnDeal["where_clause"];
            $result = $db->query($sql);
            if (mysql_num_rows($result) > 0) {
                $idsDeal = array();
                while ($row = mysql_fetch_assoc($result)) {
                    $idsDeal[] = $row["id"];
                }
            }
            
            $where_clause[] = "Listing_Summary.promotion_id ".(is_array($idsDeal) ? " IN (".implode(",", $idsDeal).") " : " IS NULL ") ;
        }
		
		if ($search_for["account"]) {
			if ($section == "listing_results") {
				$where_clause[] = "Listing_Summary.account_id = ".$search_for["account"];
			} else {
				$where_clause[] = (FORCE_SECOND ? "Listing_Summary" : "Listing").".account_id = ".$search_for["account"];
			}
		}
        
        if ($search_for["categories"]) {
            $categs = explode("-", $search_for["categories"]);
            $listing_ids = "";
            foreach ($categs as $catID) {
                if (is_numeric($catID)) {
                    unset($aux_categoryObj, $aux_cat_hierarchy);
                    $aux_categoryObj = new ListingCategory($catID);
                    $aux_cat_hierarchy = $aux_categoryObj->getHierarchy($catID, false, true);
                    if ($aux_cat_hierarchy) {
                        if ($section == "listing_results") {
                            unset($listing_CategoryObj);
                            $listing_CategoryObj = new Listing_Category();
                            $listing_ids .= ($listing_ids ? "," : "").$listing_CategoryObj->getListingsByCategoryHierarchy($aux_categoryObj->root_id, $aux_categoryObj->left, $aux_categoryObj->right, $search_for["letter"]);
                        }				
                    }
                }
            }
            if ($listing_ids) {
                $where_clause[] = ($section == "listing_results" ? "Listing_Summary" : "Listing_Summary").".id IN (".$listing_ids.")";
            } else {
                $where_clause[] = ($section == "listing_results" ? "Listing_Summary" : "Listing_Summary").".id IN (0)";
            }
        } elseif ($search_for["category_id"]) {
            //Create a category object to get hierarchy of categories
			unset($aux_categoryObj, $aux_cat_hierarchy);
			$aux_categoryObj = new ListingCategory($search_for["category_id"]);
			$aux_cat_hierarchy = $aux_categoryObj->getHierarchy($search_for["category_id"], false, true);
			if ($aux_cat_hierarchy) {
				$listing_ids = "0";
				if (($section == "listing_results") || ($section == "mobile") || ($section == "count")) {
					unset($listing_CategoryObj);
					$listing_CategoryObj = new Listing_Category();
					$listing_ids = $listing_CategoryObj->getListingsByCategoryHierarchy($aux_categoryObj->root_id, $aux_categoryObj->left, $aux_categoryObj->right, $search_for["letter"]);
					$total_listings_ids = $listing_CategoryObj->total_listings;
				}				
					
				$where_clause[] = ($section == "listing_results" ? "Listing_Summary" : "Listing_Summary").".id in (".$listing_ids.")";
				$searchReturn["total_listings"] = $total_listings_ids;	
			}
		}

		$_locations = explode(",", EDIR_LOCATIONS);
        unset($aux_sql_location);
		foreach($_locations as $_location_level) {
			if (is_numeric($search_for["location_".$_location_level])) {
                $sql_location[] = ($section == "listing_results" ? "Listing_Summary" : "Listing").".location_".$_location_level." = ".$search_for["location_".$_location_level]."";
            }
			if ($search_for["filter_location_".$_location_level]){
                $filter_to_location_ids = str_replace("-", ",", $search_for["filter_location_".$_location_level]);
                $aux_sql_location[] = ($section == "listing_results" || $section == "count" ? "Listing_Summary" : "Listing").".location_".$_location_level." IN (".$filter_to_location_ids.")";
                
            }
        }
        
        if (is_array($aux_sql_location)) {
            $sql_location[] = " (".implode(" AND ", $aux_sql_location).") ";
        }
        
		if ($sql_location) {
			$where_clause[] = "(".implode(" AND ", $sql_location).")";
        }

		if (($search_for["keyword"]) && ($section != "mobile")) {
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Listing_Summary.fulltextsearch_keyword";
			$where_clause[] = search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2");
		}

		if (($search_for["where"]) && ($section != "mobile")) {
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = (($section == "listing_results" || $section == "count" || FORCE_SECOND) ? "Listing_Summary" : "Listing").".fulltextsearch_where";
			$where_clause[] = search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2");
		}

		if (($search_for["keyword"]) && ($section == "mobile")) {
			$search_for["where"] = $search_for["keyword"];
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = (($section == "listing_results" || $section == "count" || FORCE_SECOND) ? "Listing_Summary" : "Listing").".fulltextsearch_keyword";
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = (($section == "listing_results" || $section == "count" || FORCE_SECOND) ? "Listing_Summary" : "Listing").".fulltextsearch_where";
			$where_clause[] = "(".search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2")." OR ".search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2").")";
		}

		if ($where_clause && (count($where_clause) > 0)) {
			$searchReturn["where_clause"] = implode(" AND ", $where_clause);
		}
    
		if ($user_order_by == "characters") {
			$user_order_by = ($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".title";
		} elseif ($user_order_by == "lastupdate") {
			$user_order_by = ($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".updated DESC";
		} elseif ($user_order_by == "datecreated") {
			$user_order_by = ($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".entered DESC";
		} elseif ($user_order_by == "popular") {
			$user_order_by = ($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".number_views DESC";
		} elseif ($user_order_by == "rating") {
			$user_order_by = ($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".avg_review DESC";
		} elseif ($user_order_by == "price") {
            $themeSummaryFields = unserialize(TEMPLATE_SUMMARY_FIELDS);
            $user_order_by = "CAST(".($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".".$themeSummaryFields["price_field"]." AS decimal(10,2))";
		}
        
        if (($section == "listing") || ($section == "mobile")) {
		  $searchReturn["order_by"] = ($user_order_by && $section == "mobile" ? $user_order_by.", " : "").($order_by_keyword_score2 ? "keyword_score DESC, " : "").($section == "listing_results" || $section == "mobile" || FORCE_SECOND ? "Listing_Summary" : "Listing").".level, ".($section == "listing_results" || FORCE_SECOND  || $section == "mobile" ? "Listing_Summary" : "Listing").".random_number DESC, ".($section == "listing_results" || FORCE_SECOND  || $section == "mobile" ? "Listing_Summary" : "Listing").".title, ".($section == "listing_results" || FORCE_SECOND  || $section == "mobile" ? "Listing_Summary" : "Listing").".id";
		} elseif ($section == "rss") {
			$searchReturn["order_by"] = ($order_by_keyword_score2 ? "keyword_score DESC, " : "").($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".level, ".($section == "listing_results" || FORCE_SECOND  ? "Listing_Summary" : "Listing").".title, ".($section == "listing_results" || FORCE_SECOND  ? "Listing_Summary" : "Listing").".id";
		} elseif ($section == "listing_results") {
			if (LISTING_SCALABILITY_OPTIMIZATION == "on") {
				$searchReturn["order_by"] = ($user_order_by ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" ? "reg_exp_order DESC, " : "").($order_by_keyword_score2 ? "keyword_score DESC, " : "").($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".level, ".(BACKLINK_FEATURE == "on" ? (FORCE_SECOND ? "Listing_Summary.backlink DESC, " : "Listing.backlink DESC, ") : "").($section == "listing_results" || FORCE_SECOND  ? "Listing_Summary" : "Listing").".title";
			} else {
				$searchReturn["order_by"] = ($user_order_by ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" ? "reg_exp_order DESC, " : "").($order_by_keyword_score2 ? "keyword_score DESC, " : "").($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".level, ".(BACKLINK_FEATURE == "on" ? (FORCE_SECOND ? "Listing_Summary.backlink DESC, " : "Listing.backlink DESC, ") : "").($section == "listing_results" || FORCE_SECOND  ? "Listing_Summary" : "Listing").".random_number DESC, ".($section == "listing_results" || FORCE_SECOND  ? "Listing_Summary" : "Listing").".title, ".($section == "listing_results" || FORCE_SECOND  ? "Listing_Summary" : "Listing").".id";
			}
		} elseif ($section == "random") {
			$searchReturn["order_by"] = ((LISTING_SCALABILITY_OPTIMIZATION == "on")?("Listing_FeaturedTemp.random_number"):("RAND()"));
		} elseif ($section == "count") {
			$searchReturn["order_by"] = ($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing_Summary").".id";
		}

		if ($search_for["keyword"] && $order_by_keyword_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_keyword_score.($order_by_keyword_score2 ? ", ".$order_by_keyword_score2 : "");
		}

		if ($search_for["where"] && $order_by_where_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_where_score;
		}

        if ((($search_for["keyword"] && $order_by_keyword_score) || ($search_for["where"] && $order_by_where_score) || ($search_for["zip"] && $order_by_zipcode_score)) && ($section != "count") && ($section != "random")) {
            $searchReturn["order_by"] = ($user_order_by && ($section == "listing_results" || $section == "mobile") ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "listing_results" ? "reg_exp_order DESC, " : "").($section == "listing_results" || FORCE_SECOND ? "Listing_Summary" : "Listing").".level".($section == "listing_results" && BACKLINK_FEATURE == "on" ? (FORCE_SECOND ? ",Listing_Summary.backlink DESC " : ",Listing.backlink DESC ") : "").($order_by_keyword_score2 ? ", keyword_score DESC" : "");
            if ($order_by_zipcode_score) {
                $searchReturn["order_by"] .= ", zipcode_score";
            }
            if ($order_by_keyword_score) {
                if ($order_by_keyword_score2){
                    $searchReturn["order_by"] .= ", keyword_score2 DESC";
                } else {
                    $searchReturn["order_by"] .= ", keyword_score DESC";
                }
            }
            if ($order_by_where_score) {
                $searchReturn["order_by"] .= ", where_score DESC";
            }
        }
		return $searchReturn;
	}

	function search_frontPromotionSearch($search_for, $section, $soldout = false) {

        $searchReturn["select_columns"] = false;
        $searchReturn["from_tables"] = false;
        $searchReturn["where_clause"] = false;
        $searchReturn["group_by"] = false;
        $searchReturn["order_by"] = false;

        $orderByConf =  array("characters",
                                "lastupdate",
                                "datecreated",
                                "popular",
                                "rating"
                            );

        $user_order_by = "";
        if (in_array($_GET["orderby"], $orderByConf)) {
            $user_order_by = $_GET["orderby"];
        }

        if (($section == "promotion") || ($section == "random") || $section == "promotion_results") {
            $searchReturn["select_columns"] = "Promotion.*";
            if (SEARCH_FORCE_BOOLEANMODE == "on" && $section == "promotion_results") {
                $searchReturn["select_columns"] = $searchReturn["select_columns"].", Promotion.name REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
            }
        } elseif ($section == "count") {
            $searchReturn["select_columns"] = "COUNT(Promotion.id)";
        }

        $_locations = explode(",", EDIR_LOCATIONS);
        unset($aux_sql_location);
        foreach($_locations as $_location_level) {
            if (is_numeric($search_for["location_".$_location_level])) {
                $sql_location[] = "listing_location".$_location_level." = ".$search_for["location_".$_location_level]."";
            }
            if ($search_for["filter_location_".$_location_level]) {
                $filter_to_location_ids = str_replace("-", ",", $search_for["filter_location_".$_location_level]);
                $aux_sql_location[] = "listing_location".$_location_level." IN (".$filter_to_location_ids.")";
            }
        }

        $searchReturn["from_tables"] = "Promotion";

        if (isset($search_for["id"]) && is_numeric($search_for["id"]) && $search_for["id"] > 0) {
            if (!$search_for["keyword"] || $section == "count") {
                $where_clause[] = "Promotion.id = ".$search_for["id"]."";
            } else {
                $having_clause[] = "Promotion.id = ".$search_for["id"]."";
            }
        }

        if (isset($search_for["except_ids"])) {
            if (!$search_for["keyword"] || $section == "count") {
                $where_clause[] = "Promotion.id NOT IN (".$search_for["except_ids"].") ";
            } else {
                $having_clause[] = "Promotion.id NOT IN (".$search_for["except_ids"].") ";
            }
        }

        $sitemgrPreview = sess_validateItemPreview();
        
        if (!$sitemgrPreview) {
            if (!$search_for["keyword"] || $section == "count") {
                $where_clause[] = "Promotion.listing_status = 'A'";
            } else {
                $having_clause[] = "Promotion.listing_status = 'A'";
            }
        }

        if (!$search_for["keyword"] || $section == "count") {
            $where_clause[] = "Promotion.end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d')";
            $where_clause[] = "Promotion.start_date <= DATE_FORMAT(NOW(), '%Y-%m-%d')";
        } else {
            $having_clause[] = "Promotion.end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d')";
            $having_clause[] = "Promotion.start_date <= DATE_FORMAT(NOW(), '%Y-%m-%d')";
        }

        if ($soldout) {
            if (!$search_for["keyword"] || $section == "count") {
                $where_clause[] = "Promotion.amount > 0";
            } else {
                $having_clause[] = "Promotion.amount > 0";
            }
        }

        // RANGE OF HOURS
        if (!$search_for["id"]) {
            $visibility_start = date('H')*60+date('i');
            $visibility_end = date('H')*60+date('i');
            if (!$search_for["keyword"] || $section == "count") {
                $where_clause[] = " ((Promotion.visibility_start <= $visibility_start AND Promotion.visibility_end >= $visibility_end ) OR (Promotion.visibility_start = 24 AND Promotion.visibility_end = 24)) ";
            } else {
                $having_clause[] = " ((Promotion.visibility_start <= $visibility_start AND Promotion.visibility_end >= $visibility_end ) OR (Promotion.visibility_start = 24 AND Promotion.visibility_end = 24)) ";
            }
        }
        
        if ($search_for["filter_valid_for"]) { 
            if ($search_for["filter_valid_for"] == "deal_week") {
                $where_clause[] = "(Promotion.end_date > DATE_FORMAT(adddate(now(), interval 1 week), '%Y-%m-%d'))";
            }
            if ($search_for["filter_valid_for"] == "deal_1_day") {
                $where_clause[] = "(Promotion.end_date <= DATE_FORMAT(adddate(now(), interval 1 day), '%Y-%m-%d'))";
            }
            if ($search_for["filter_valid_for"] == "deal_2_day") {
                $where_clause[] = "(Promotion.end_date > DATE_FORMAT(adddate(now(), interval 2 day), '%Y-%m-%d'))";
            }
        }

        if (!$search_for["keyword"] || $section == "count") {
            $where_clause[] = "Promotion.listing_id > 0";
        } else {
            $having_clause[] = "Promotion.listing_id > 0";
        }

        if ($search_for["account"]) {
            if (!$search_for["keyword"] || $section == "count") {
                $where_clause[] = "Promotion.account_id = ".$search_for["account"];
            } else {
                $having_clause[] = "Promotion.account_id = ".$search_for["account"];
            }
        }
        
        if ($search_for["rating"]) {
            $ratings = explode("-", $search_for["rating"]);
            $where_clause[] = "Promotion.avg_review IN (".implode(",", $ratings).")";
        } else {
            if ($search_for["avg_review"]) {
                if (!$search_for["keyword"] || $section == "count") {
                    $where_clause[] = "Promotion.avg_review = ".$search_for["avg_review"];
                } else {
                    $having_clause[] = "Promotion.avg_review = ".$search_for["avg_review"];
                }
            }
        }

        if ($search_for["listing_IDs"]) {
            $where_clause[] = "Promotion.listing_id IN (".$search_for["listing_IDs"].")";
        }

        $levelObj = new ListingLevel(true);
        $levels = $levelObj->getLevelValues();

        unset($allowed_levels);
        foreach ($levels as $each_level) {
            if ( ($levelObj->getActive($each_level) == 'y') && ($levelObj->getHasPromotion($each_level) == 'y' ) ) {
                $allowed_levels[] = $each_level;
            }
        }

        $search_levels = ($allowed_levels ? implode(",", $allowed_levels) : "0");

        if (!$search_for["keyword"] || $section == "count") {
            $where_clause[] = "Promotion.listing_level IN ($search_levels)";
        } else {
            $having_clause[] = "Promotion.listing_level IN ($search_levels)";
        }

        if ($search_for["categories"]) {
            $categs = explode("-", $search_for["categories"]);

            $listing_ids = "";
            foreach ($categs as $catID) {
                if (is_numeric($catID)) {
                    unset($aux_categoryObj, $aux_cat_hierarchy);
                    $aux_categoryObj = new ListingCategory($catID);
                    $aux_cat_hierarchy = $aux_categoryObj->getHierarchy($catID, false, true);
                    if ($aux_cat_hierarchy) {
                        unset($listing_CategoryObj);
                        $listing_CategoryObj = new Listing_Category();
                        $listing_ids .= ($listing_ids ? "," : "").$listing_CategoryObj->getListingsByCategoryHierarchy($aux_categoryObj->root_id, $aux_categoryObj->left, $aux_categoryObj->right, $search_for["letter"]);
                    }
                }
            }
            if ($listing_ids) {
                $where_clause[] = "Promotion.listing_id IN (".$listing_ids.")";
            } else {
                $where_clause[] = "Promotion.listing_id IN (0)";
            }

        } elseif ($search_for["category_id"]) {
            //Create a category object to get hierarchy of categories
            unset($aux_categoryObj, $aux_cat_hierarchy);
            $aux_categoryObj = new ListingCategory($search_for["category_id"]);
            $aux_cat_hierarchy = $aux_categoryObj->getHierarchy($search_for["category_id"], false, true);
            if ($aux_cat_hierarchy) {
                $listing_ids = "0";
                unset($listing_CategoryObj);
                $listing_CategoryObj = new Listing_Category();
                $listing_ids = $listing_CategoryObj->getListingsByCategoryHierarchy($aux_categoryObj->root_id,  $aux_categoryObj->left, $aux_categoryObj->right, $search_for["letter"]);
                $where_clause[] = "Promotion.listing_id IN (".$listing_ids.")";
            }
        }
        
        if (is_array($aux_sql_location)) {
            $sql_location[] = " (".implode(" AND ", $aux_sql_location).") ";
        }

        if ($sql_location) {
            $where_clause[] = "(".implode(" AND ", $sql_location).")";
        }

        if (($search_for["keyword"]) && ($section != "mobile")) {
            $search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
            $search_for_keyword_fields_promotion[] = "Promotion.fulltextsearch_keyword";
            $where_clause[] = "(".search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields_promotion, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2").")";
        }

        if (($search_for["where"]) && ($section != "mobile")) {
            $search_for["where"] = str_replace("\\", "", $search_for["where"]);
            if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
                $search_for["where"] = str_replace(",", "", $search_for["where"]);
            }
            $search_for_where_fields[] = "Promotion.fulltextsearch_where";
            $where_clause[] = search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2");
        }

        if (($search_for["keyword"]) && ($section == "mobile")) {
            $search_for["where"] = $search_for["keyword"];
            $search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
            $search_for_keyword_fields_promotion[] = "Promotion.fulltextsearch_keyword";
            $search_for_keyword_fields_listing[] = (($section == "promotion_results" || $section == "count" || $section == "random") ? "Listing_Summary" : "Listing").".fulltextsearch_keyword";
            $search_for["where"] = str_replace("\\", "", $search_for["where"]);
            if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
                $search_for["where"] = str_replace(",", "", $search_for["where"]);
            }
            $search_for_where_fields[] = (($section == "promotion_results" || $section == "count" || $section == "random") ? "Listing_Summary" : "Listing").".fulltextsearch_where";
            $where_clause[] = "((".search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields_promotion, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2")." OR ".
            search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields_listing, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2").") OR ".
            search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2").")";
        }

        if ($where_clause && (count($where_clause) > 0)) {
            $searchReturn["where_clause"] = implode(" AND ", $where_clause);
        }

        if ($having_clause && (count($having_clause) > 0)) {
            $searchReturn["having_clause"] = implode(" AND ", $having_clause);
        }

        if ($user_order_by == "characters") {
            $user_order_by = "Promotion.name";
        } elseif ($user_order_by == "lastupdate") {
            $user_order_by = "Promotion.updated DESC";
        } elseif ($user_order_by == "datecreated") {
            $user_order_by = "Promotion.entered DESC";
        } elseif ($user_order_by == "popular") {
            $user_order_by = "Promotion.number_views DESC";
        } elseif ($user_order_by == "rating") {
            $user_order_by = "Promotion.avg_review DESC";
        } 

        if (($section == "promotion")) {
            $searchReturn["order_by"] = "Promotion.random_number DESC, Promotion.end_date, Promotion.name, Promotion.id";
        } elseif (($section == "promotion_results")) {
            $searchReturn["order_by"] = ($user_order_by ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" ? "reg_exp_order DESC, " : "")."Promotion.end_date, Promotion.random_number DESC, Promotion.name, Promotion.id";
        } elseif ($section == "random") {
            $searchReturn["order_by"] = ((PROMOTION_SCALABILITY_OPTIMIZATION == "on") ? ("random_number DESC") : ("RAND()"));
        } elseif ($section == "count") {
            $searchReturn["order_by"] = "Promotion.id";
        }

        if ($search_for["keyword"] && $order_by_keyword_score && ($section != "count") && ($section != "random")) {
            $searchReturn["select_columns"] .= ", ".$order_by_keyword_score.($order_by_keyword_score2 ? ", ".$order_by_keyword_score2 : "");
        }

        if ($search_for["where"] && $order_by_where_score && ($section != "count") && ($section != "random")) {
            $searchReturn["select_columns"] .= ", ".$order_by_where_score;
        }

        if ((($search_for["keyword"] && $order_by_keyword_score) || ($search_for["where"] && $order_by_where_score) || ($search_for["zip"] && $order_by_zipcode_score)) && ($section != "count") && ($section != "random")) {
            $searchReturn["order_by"] = ($user_order_by && $section == "promotion_results" ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "promotion_results" ? "reg_exp_order DESC, " : "")."Promotion.end_date";

            if ($order_by_zipcode_score) {
                if ($searchReturn["order_by"]) {
                    $searchReturn["order_by"] .= ", zipcode_score";
                } else {
                    $searchReturn["order_by"] .= "zipcode_score";
                }
            }
            if ($order_by_keyword_score) {
                if ($order_by_keyword_score2) {
                    if ($searchReturn["order_by"]) $searchReturn["order_by"] .= ", keyword_score DESC, keyword_score2 DESC";
                    else $searchReturn["order_by"] .= "keyword_score DESC, keyword_score2 DESC";
                } else {
                    if ($searchReturn["order_by"]) $searchReturn["order_by"] .= ", keyword_score DESC";
                    else $searchReturn["order_by"] .= "keyword_score DESC";
                }
            }
            if ($order_by_where_score) {
                if ($searchReturn["order_by"]) {
                    $searchReturn["order_by"] .= ", where_score DESC";
                } else {
                    $searchReturn["order_by"] .= "where_score DESC";
                }
            }
        }

        return $searchReturn;

	}

	function search_frontEventSearch($search_for, $section) {

		$searchReturn["select_columns"] = false;
		$searchReturn["from_tables"] = false;
		$searchReturn["where_clause"] = false;
		$searchReturn["group_by"] = false;
		$searchReturn["order_by"] = false;

		$orderByConf =  array("startdate",
							"characters",
							"lastupdate",
							"datecreated",
							"popular");

        $user_order_by = "";
		if (in_array($_GET["orderby"], $orderByConf)) {
			$user_order_by = $_GET["orderby"];
		}

		if (($section == "event") || ($section == "random") || ($section == "mobile")) {
			$searchReturn["select_columns"] = "Event.*";
            if (SEARCH_FORCE_BOOLEANMODE == "on" && $section == "event") {
                $searchReturn["select_columns"] = $searchReturn["select_columns"].", Event.title REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
            }
		} elseif ($section == "count") {
			$searchReturn["select_columns"] = "COUNT(DISTINCT(Event.id))";
		} elseif ($section == "rss") {
			$searchReturn["select_columns"] = "Event.id";
		}

		$searchReturn["from_tables"] = "Event";

		if (isset($search_for["id"]) && is_numeric($search_for["id"]) && $search_for["id"] > 0) {
			$where_clause[] = "Event.id = ".$search_for["id"]."";
		}

        $sitemgrPreview = sess_validateItemPreview();
        if (!$sitemgrPreview) {
            $where_clause[] = "Event.status = 'A'";
        }
		if ($search_for["account"]) {
			$where_clause[] = "Event.account_id = ".$search_for["account"];
		}

		$withoutDate = true;

		if ($search_for["single_month"]) {
            $aux_month1 = preg_replace('/[^0-9]/', '', string_substr($search_for["single_month"], 0, 4));
			$aux_month2 = preg_replace('/[^0-9]/', '', string_substr($search_for["single_month"], 4, 2));
            $datePickedFull = $aux_month1."-".$aux_month2;
                       
            if ($search_for["isApp"]) {
                $where_clause[] = "(
                                (DATE_FORMAT(Event.start_date, '%Y-%m') = '{$datePickedFull}' ".($search_for["day"] ? " AND DATE_FORMAT(Event.start_date, '%d') >= '{$search_for["day"]}'" : "")." AND recurring = 'N' )
                                OR
                                (((DATE_FORMAT(Event.until_date, '%Y-%m') >= '{$datePickedFull}' ) OR DATE_FORMAT(Event.until_date, '%Y-%m-%d') = '0000-00-00') AND recurring = 'Y')
                                )";
            } else {
                $where_clause[] = "(DATE_FORMAT(Event.start_date, '%Y-%m') = '{$datePickedFull}' ".($search_for["day"] ? " AND DATE_FORMAT(Event.start_date, '%d') >= '{$search_for["day"]}'" : "")."  )";
            }
            
            
        } elseif (($search_for["this_date"]) && (!$search_for["month"])) {

			$aux_month1 = preg_replace('/[^0-9]/', '', string_substr($search_for["this_date"],0,4));
			$aux_month2 = preg_replace('/[^0-9]/', '', string_substr($search_for["this_date"], 4, 2));
			$aux_month3 = preg_replace('/[^0-9]/', '', string_substr($search_for["this_date"], 6));

			$datePickedFull = $aux_month1."-".$aux_month2."-".$aux_month3;
			if ($aux_month1 && $aux_month2 && $aux_month3) {
				$datePickedTimestamp = mktime(0,0,0,$aux_month2, $aux_month3, $aux_month1);
            }

			if ($datePickedTimestamp) {
				$datePickedDay = date('d', $datePickedTimestamp);
				$datePickedDayOfTheWeek = date('w', $datePickedTimestamp) + 1; //database does not follow ISO or numeric standard -- sunday=1, monday=2, tuesday=3, (...), saturday=7
			} else {
				$datePickedDay = date('d');
				$datePickedDayOfTheWeek = date('w') + 1; //database does not follow ISO or numeric standard -- sunday=1, monday=2, tuesday=3, (...), saturday=7
			}
			if ($aux_month1 && $aux_month2) {
				$datePickedWeekofMonth = ceil(($aux_month3 + date("w",mktime(0,0,0,$aux_month2,1,$aux_month1)))/7);
            }
			
			if ($datePickedTimestamp) {
				$datePickedMonth = date('m', $datePickedTimestamp);
			} else {
				$datePickedWeekofMonth = "''";
				$datePickedMonth = date('m');
			}

			$where_clause[] = "
								DATE_FORMAT(Event.start_date, '%Y-%m-%d') <= '{$datePickedFull}'
								AND
								(
									(
										Event.recurring = 'Y'
										AND (DATE_FORMAT(Event.until_date, '%Y-%m-%d') >= '{$datePickedFull}' OR DATE_FORMAT(Event.until_date, '%Y-%m-%d') = '0000-00-00')
										AND
										(
											(
												(
													Event.day = '$datePickedDay'
													AND (Event.week = 0 OR Event.week = '' OR Event.week IS NULL )
													AND (Event.dayofweek = 0 OR Event.dayofweek = '' OR Event.dayofweek IS NULL )
													AND (Event.month = 0 OR Event.month = '' OR Event.month IS NULL)
												)

												OR
												(
													Event.day = '$datePickedDay'
													AND (Event.week = 0 OR Event.week = '' OR Event.week IS NULL )
													AND (Event.dayofweek = 0 OR Event.dayofweek = '' OR Event.dayofweek IS NULL )
													AND (Event.month = '$datePickedMonth')
												)


												OR
												(
													LOCATE($datePickedDayOfTheWeek, Event.dayofweek) > 0
													AND (Event.day = 0 OR Event.day IS NULL OR Event.day = '')
													AND (Event.week = 0 OR Event.week = '' OR Event.week IS NULL )
													AND (Event.month = 0 OR Event.month = '' OR Event.month IS NULL )
												)

												OR
												(
                                                    LOCATE($datePickedWeekofMonth, Event.week) > 0
                                                    AND LOCATE($datePickedDayOfTheWeek,Event.dayofweek) > 0
                                                    AND (Event.month = 0 OR Event.month = '' OR Event.month IS NULL OR Event.month = '$datePickedMonth')
												)

												OR
												(
													Event.month = $datePickedMonth
													AND LOCATE($datePickedWeekofMonth, Event.week) > 0
													AND LOCATE($datePickedDayOfTheWeek, Event.dayofweek) > 0
												)
											)
											OR
											(
												(Event.day = 0 OR Event.day IS NULL OR Event.day = '')
												AND (Event.week = 0 OR Event.week = '' OR Event.week IS NULL )
												AND (Event.dayofweek = 0 OR Event.dayofweek = '' OR Event.dayofweek IS NULL )
												AND (Event.month = 0 OR Event.month = '' OR Event.month IS NULL )
											)
										)
									)
									OR (Event.recurring = 'N' AND DATE_FORMAT(Event.end_date, '%Y-%m-%d') >= '{$datePickedFull}')
								)";
			$withoutDate = false;
		}

		if ($search_for["month"] && !$search_for["single_month"]) {
			$aux_month1 = preg_replace('/[^0-9]/', '', string_substr($search_for["month"],4));
			$aux_month2 = preg_replace('/[^0-9]/', '', string_substr($search_for["month"],0,4));
			if ($aux_month1 && $aux_month2) {
				$monthPickedStartTimestamp = mktime(0, 0, 0, $aux_month1, 1, $aux_month2);
            }

			if ($aux_month1 && $aux_month2) {
				$monthPickedEndTimestamp = mktime(23, 59, 59, $aux_month1, date('t', $monthPickedStartTimestamp), $aux_month2);
            }

			if ($monthPickedStartTimestamp) {
				$monthPicked = date('m', $monthPickedStartTimestamp);
				$monthPickedStartFull = date('Y-m-d', $monthPickedStartTimestamp);
			} else {
				$monthPicked = date('m');
				$monthPickedStartFull = date('Y-m-d');
			}

			if ($monthPickedEndTimestamp) {
				$monthPickedEndFull = date('Y-m-d', $monthPickedEndTimestamp);
			} else {
				$monthPickedEndFull = date('Y-m-d');
			}

			$where_clause[] = "
								(

									DATE_FORMAT(Event.start_date, '%Y-%m-%d') <= '{$monthPickedEndFull}'
									AND
									(
										(
											(DATE_FORMAT(Event.until_date, '%Y-%m-%d') >= '{$monthPickedStartFull}' AND DATE_FORMAT(Event.until_date, '%Y-%m-%d') <> '0000-00-00')
											OR (DATE_FORMAT(Event.end_date, '%Y-%m-%d') >= '{$monthPickedStartFull}' AND DATE_FORMAT(Event.end_date, '%Y-%m-%d') <> '0000-00-00')
										)
										OR (DATE_FORMAT(Event.end_date, '%Y-%m-%d') = '0000-00-00' AND DATE_FORMAT(Event.until_date, '%Y-%m-%d') = '0000-00-00')
									)
									AND
									(
										(Event.recurring = 'N')
										OR (Event.month = 0 OR Event.month= ' ' OR Event.month IS NULL OR Event.month = '$monthPicked')
									)
								)";
			$withoutDate = false;
		}

		if ($withoutDate) {
			$where_clause[] = "((Event.end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') OR Event.until_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND repeat_event = 'N') OR (repeat_event = 'Y'))";
		}
        
        unset ($auxSearchCateg);
        if ($search_for["categories"]) {
            $categs = explode("-", $search_for["categories"]);
            foreach ($categs as $catID) {
                if (is_numeric($catID)) {
                    $auxSearchCateg[] = "(Event.cat_1_id = ".$catID." OR Event.parcat_1_level1_id = ".$catID." OR Event.parcat_1_level2_id = ".$catID." OR Event.parcat_1_level3_id = ".$catID." OR Event.parcat_1_level4_id = ".$catID." OR Event.cat_2_id = ".$catID." OR Event.parcat_2_level1_id = ".$catID." OR Event.parcat_2_level2_id = ".$catID." OR Event.parcat_2_level3_id = ".$catID." OR Event.parcat_2_level4_id = ".$catID." OR Event.cat_3_id = ".$catID." OR Event.parcat_3_level1_id = ".$catID." OR Event.parcat_3_level2_id = ".$catID." OR Event.parcat_3_level3_id = ".$catID." OR Event.parcat_3_level4_id = ".$catID." OR Event.cat_4_id = ".$catID." OR Event.parcat_4_level1_id = ".$catID." OR Event.parcat_4_level2_id = ".$catID." OR Event.parcat_4_level3_id = ".$catID." OR Event.parcat_4_level4_id = ".$catID." OR Event.cat_5_id = ".$catID." OR Event.parcat_5_level1_id = ".$catID." OR Event.parcat_5_level2_id = ".$catID." OR Event.parcat_5_level3_id = ".$catID." OR Event.parcat_5_level4_id = ".$catID.")";
                }
            }
        
            if (is_array($auxSearchCateg)) {
                $where_clause[] = " (".implode(" OR ", $auxSearchCateg).") ";
            }
            
        } elseif ($search_for["category_id"]) {
			$where_clause[] = "(Event.cat_1_id = ".$search_for["category_id"]." OR Event.parcat_1_level1_id = ".$search_for["category_id"]." OR Event.parcat_1_level2_id = ".$search_for["category_id"]." OR Event.parcat_1_level3_id = ".$search_for["category_id"]." OR Event.parcat_1_level4_id = ".$search_for["category_id"]." OR Event.cat_2_id = ".$search_for["category_id"]." OR Event.parcat_2_level1_id = ".$search_for["category_id"]." OR Event.parcat_2_level2_id = ".$search_for["category_id"]." OR Event.parcat_2_level3_id = ".$search_for["category_id"]." OR Event.parcat_2_level4_id = ".$search_for["category_id"]." OR Event.cat_3_id = ".$search_for["category_id"]." OR Event.parcat_3_level1_id = ".$search_for["category_id"]." OR Event.parcat_3_level2_id = ".$search_for["category_id"]." OR Event.parcat_3_level3_id = ".$search_for["category_id"]." OR Event.parcat_3_level4_id = ".$search_for["category_id"]." OR Event.cat_4_id = ".$search_for["category_id"]." OR Event.parcat_4_level1_id = ".$search_for["category_id"]." OR Event.parcat_4_level2_id = ".$search_for["category_id"]." OR Event.parcat_4_level3_id = ".$search_for["category_id"]." OR Event.parcat_4_level4_id = ".$search_for["category_id"]." OR Event.cat_5_id = ".$search_for["category_id"]." OR Event.parcat_5_level1_id = ".$search_for["category_id"]." OR Event.parcat_5_level2_id = ".$search_for["category_id"]." OR Event.parcat_5_level3_id = ".$search_for["category_id"]." OR Event.parcat_5_level4_id = ".$search_for["category_id"].")";
		}

		$_locations = explode(",", EDIR_LOCATIONS);       
        unset($aux_sql_location);
		foreach($_locations as $_location_level) {
			if (is_numeric($search_for["location_".$_location_level])) {
                $sql_location[] = " Event.location_".$_location_level." = ".$search_for["location_".$_location_level]."";
            }
			if ($search_for["filter_location_".$_location_level]) {
                $filter_to_location_ids = str_replace("-", ",", $search_for["filter_location_".$_location_level]);
                $aux_sql_location[] = "Event.location_".$_location_level." IN (".$filter_to_location_ids.")";               
            }
        }
        
        if (is_array($aux_sql_location)) {
            $sql_location[] = " (".implode(" AND ", $aux_sql_location).") ";
        }
        
		if ($sql_location) {
			$where_clause[] = "(".implode(" AND ", $sql_location).")";
        }

		if (($search_for["keyword"]) && ($section != "mobile")) {
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Event.fulltextsearch_keyword";
			$where_clause[] = search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2");
		}

		if (($search_for["where"]) && ($section != "mobile")) {
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "Event.fulltextsearch_where";
			$where_clause[] = search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2");
		}

		if (($search_for["keyword"]) && ($section == "mobile")) {
			$search_for["where"] = $search_for["keyword"];
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Event.fulltextsearch_keyword";
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "Event.fulltextsearch_where";
			$where_clause[] = "(".search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2")." OR ".search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2").")";
		}

		if ($where_clause && (count($where_clause) > 0)) {
			$searchReturn["where_clause"] = implode(" AND ", $where_clause);
		}

        if ($user_order_by == "startdate") {
			$user_order_by = "Event.start_date";
		} elseif ($user_order_by == "characters") {
			$user_order_by = "Event.title";
		} elseif ($user_order_by == "lastupdate") {
			$user_order_by = "Event.updated DESC";
		} elseif ($user_order_by == "datecreated") {
			$user_order_by = "Event.entered DESC";
		} elseif ($user_order_by == "popular") {
			$user_order_by = "Event.number_views DESC";
		} 
        
        if (($section == "event") || ($section == "mobile") || ($section == "rss")) {
			$searchReturn["order_by"] = ($user_order_by && ($section == "event" || $section == "mobile") ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "event" ? "reg_exp_order DESC, " : "")."Event.level, Event.random_number DESC, Event.end_date, Event.until_date, Event.title, Event.id";
		} elseif ($section == "random") {
			$searchReturn["order_by"] = ((EVENT_SCALABILITY_OPTIMIZATION == "on") ? ("random_number DESC") : ("RAND()"));
		} elseif ($section == "count") {
			$searchReturn["order_by"] = "Event.id";
		}

		if ($search_for["keyword"] && $order_by_keyword_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_keyword_score.($order_by_keyword_score2 ? ", ".$order_by_keyword_score2 : "");
		}

		if ($search_for["where"] && $order_by_where_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_where_score;
		}

        if ((($search_for["keyword"] && $order_by_keyword_score) || ($search_for["where"] && $order_by_where_score) || ($search_for["zip"] && $order_by_zipcode_score)) && ($section != "count") && ($section != "random")) {
            $searchReturn["order_by"] = ($user_order_by && ($section == "event" || $section == "mobile") ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "event" ? "reg_exp_order DESC, " : "")."Event.level";

            if ($order_by_zipcode_score) {
                $searchReturn["order_by"] .= ", zipcode_score";
            }
            if ($order_by_keyword_score) {
                if ($order_by_keyword_score2){
                    $searchReturn["order_by"] .= ", keyword_score2 DESC";
                } else {
                    $searchReturn["order_by"] .= ", keyword_score DESC";
                }
            }
            if ($order_by_where_score) {
                $searchReturn["order_by"] .= ", where_score DESC";
            }
        }

		return $searchReturn;

	}

	function search_frontClassifiedSearch($search_for, $section) {

		$searchReturn["select_columns"] = false;
		$searchReturn["from_tables"] = false;
		$searchReturn["where_clause"] = false;
		$searchReturn["group_by"] = false;
		$searchReturn["order_by"] = false;

		$orderByConf =  array("characters",
							"lastupdate",
							"datecreated",
							"popular");
			
        $user_order_by = "";
		if (in_array($_GET["orderby"], $orderByConf)) {
			$user_order_by = $_GET["orderby"];
		}

		if (($section == "classified") || ($section == "random") || ($section == "mobile")) {
			$searchReturn["select_columns"] = "Classified.*";
            if (SEARCH_FORCE_BOOLEANMODE == "on" && $section == "classified") {
                $searchReturn["select_columns"] = $searchReturn["select_columns"].", Classified.title REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
            }
		} elseif ($section == "count") {
			$searchReturn["select_columns"] = "COUNT(DISTINCT(Classified.id))";
		} elseif ($section == "rss") {
			$searchReturn["select_columns"] = "Classified.id";
		}

		$searchReturn["from_tables"] = "Classified";

		if (isset($search_for["id"]) && is_numeric($search_for["id"]) && $search_for["id"] > 0) {
			$where_clause[] = "Classified.id = ".$search_for["id"]."";
		}

        $sitemgrPreview = sess_validateItemPreview();
        if (!$sitemgrPreview) {
            $where_clause[] = "Classified.status = 'A'";
        }

		if ($search_for["account"]) {
			$where_clause[] = "Classified.account_id = ".$search_for["account"];
		}
        
        unset ($auxSearchCateg);
        if ($search_for["categories"]) {
            $categs = explode("-", $search_for["categories"]);

            foreach ($categs as $catID) {
                if (is_numeric($catID)) {
                    $auxSearchCateg[] = "(Classified.cat_1_id = ".$catID." OR Classified.parcat_1_level1_id = ".$catID." OR Classified.parcat_1_level2_id = ".$catID." OR Classified.parcat_1_level3_id = ".$catID." OR Classified.parcat_1_level4_id = ".$catID." OR Classified.cat_2_id = ".$catID." OR Classified.parcat_2_level1_id = ".$catID." OR Classified.parcat_2_level2_id = ".$catID." OR Classified.parcat_2_level3_id = ".$catID." OR Classified.parcat_2_level4_id = ".$catID." OR Classified.cat_3_id = ".$catID." OR Classified.parcat_3_level1_id = ".$catID." OR Classified.parcat_3_level2_id = ".$catID." OR Classified.parcat_3_level3_id = ".$catID." OR Classified.parcat_3_level4_id = ".$catID." OR Classified.cat_4_id = ".$catID." OR Classified.parcat_4_level1_id = ".$catID." OR Classified.parcat_4_level2_id = ".$catID." OR Classified.parcat_4_level3_id = ".$catID." OR Classified.parcat_4_level4_id = ".$catID." OR Classified.cat_5_id = ".$catID." OR Classified.parcat_5_level1_id = ".$catID." OR Classified.parcat_5_level2_id = ".$catID." OR Classified.parcat_5_level3_id = ".$catID." OR Classified.parcat_5_level4_id = ".$catID.")";
                }
            }

            if (is_array($auxSearchCateg)) {
                $where_clause[] = " (".implode(" OR ", $auxSearchCateg).") ";
            }
        } elseif ($search_for["category_id"]) {
			$where_clause[] = "(Classified.cat_1_id = ".$search_for["category_id"]." OR Classified.parcat_1_level1_id = ".$search_for["category_id"]." OR Classified.parcat_1_level2_id = ".$search_for["category_id"]." OR Classified.parcat_1_level3_id = ".$search_for["category_id"]." OR Classified.parcat_1_level4_id = ".$search_for["category_id"]." OR Classified.cat_2_id = ".$search_for["category_id"]." OR Classified.parcat_2_level1_id = ".$search_for["category_id"]." OR Classified.parcat_2_level2_id = ".$search_for["category_id"]." OR Classified.parcat_2_level3_id = ".$search_for["category_id"]." OR Classified.parcat_2_level4_id = ".$search_for["category_id"]." OR Classified.cat_3_id = ".$search_for["category_id"]." OR Classified.parcat_3_level1_id = ".$search_for["category_id"]." OR Classified.parcat_3_level2_id = ".$search_for["category_id"]." OR Classified.parcat_3_level3_id = ".$search_for["category_id"]." OR Classified.parcat_3_level4_id = ".$search_for["category_id"]." OR Classified.cat_4_id = ".$search_for["category_id"]." OR Classified.parcat_4_level1_id = ".$search_for["category_id"]." OR Classified.parcat_4_level2_id = ".$search_for["category_id"]." OR Classified.parcat_4_level3_id = ".$search_for["category_id"]." OR Classified.parcat_4_level4_id = ".$search_for["category_id"]." OR Classified.cat_5_id = ".$search_for["category_id"]." OR Classified.parcat_5_level1_id = ".$search_for["category_id"]." OR Classified.parcat_5_level2_id = ".$search_for["category_id"]." OR Classified.parcat_5_level3_id = ".$search_for["category_id"]." OR Classified.parcat_5_level4_id = ".$search_for["category_id"].")";
		}

		$_locations = explode(",", EDIR_LOCATIONS);       
        unset($aux_sql_location);
		foreach($_locations as $_location_level) {
			if (is_numeric($search_for["location_".$_location_level])) {
                $sql_location[] = " Classified.location_".$_location_level." = ".$search_for["location_".$_location_level]."";
            }
			if ($search_for["filter_location_".$_location_level]) {
                $filter_to_location_ids = str_replace("-", ",", $search_for["filter_location_".$_location_level]);
                $aux_sql_location[] = "Classified.location_".$_location_level." IN (".$filter_to_location_ids.")";
            }
        }
        
        if (is_array($aux_sql_location)) {
            $sql_location[] = " (".implode(" AND ", $aux_sql_location).") ";
        }
        
		if ($sql_location) {
			$where_clause[] = "(".implode(" AND ", $sql_location).")";
        }

		if (($search_for["keyword"]) && ($section != "mobile")) {
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Classified.fulltextsearch_keyword";
			$where_clause[] = search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2");
		}

		if (($search_for["where"]) && ($section != "mobile")) {
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "Classified.fulltextsearch_where";
			$where_clause[] = search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2");
		}		

		if (($search_for["keyword"]) && ($section == "mobile")) {
			$search_for["where"] = $search_for["keyword"];
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Classified.fulltextsearch_keyword";
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "Classified.fulltextsearch_where";
			$where_clause[] = "(".search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2")." OR ".search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2").")";
		}

		if ($where_clause && (count($where_clause) > 0)) {
			$searchReturn["where_clause"] = implode(" AND ", $where_clause);
		}

		if ($user_order_by == "characters") {
			$user_order_by = "Classified.title";
		} elseif ($user_order_by == "lastupdate") {
			$user_order_by = "Classified.updated DESC";
		} elseif ($user_order_by == "datecreated") {
			$user_order_by = "Classified.entered DESC";
		} elseif ($user_order_by == "popular") {
			$user_order_by = "Classified.number_views DESC";
		}
        
        if (($section == "classified") || ($section == "mobile") || ($section == "rss")) {
            $searchReturn["order_by"] = ($user_order_by && ($section == "classified" || $section == "mobile") ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "classified" ? "reg_exp_order DESC, " : "")."Classified.level, Classified.random_number DESC, Classified.title, Classified.id";
		} elseif ($section == "random") {
			$searchReturn["order_by"] = ((CLASSIFIED_SCALABILITY_OPTIMIZATION == "on") ? ("random_number DESC") : ("RAND()"));
		} elseif ($section == "count") {
			$searchReturn["order_by"] = "Classified.id";
		}

		if ($search_for["keyword"] && $order_by_keyword_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_keyword_score.($order_by_keyword_score2 ? ", ".$order_by_keyword_score2 : "");
		}

		if ($search_for["where"] && $order_by_where_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_where_score;
		}

        if ((($search_for["keyword"] && $order_by_keyword_score) || ($search_for["where"] && $order_by_where_score) || ($search_for["zip"] && $order_by_zipcode_score)) && ($section != "count") && ($section != "random")) {
            $searchReturn["order_by"] = ($user_order_by && ($section == "classified" || $section == "mobile") ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "classified" ? "reg_exp_order DESC, " : "")."Classified.level";
            
            if ($order_by_zipcode_score) {
                $searchReturn["order_by"] .= ", zipcode_score";
            }
            if ($order_by_keyword_score) {
                if ($order_by_keyword_score2){
                    $searchReturn["order_by"] .= ", keyword_score2 DESC";
                } else {
                    $searchReturn["order_by"] .= ", keyword_score DESC";
                }

            }
            if ($order_by_where_score) {
                $searchReturn["order_by"] .= ", where_score DESC";
            }
        }

		return $searchReturn;

	}

	function search_frontArticleSearch($search_for, $section) {

		$searchReturn["select_columns"] = false;
		$searchReturn["from_tables"] = false;
		$searchReturn["where_clause"] = false;
		$searchReturn["group_by"] = false;
		$searchReturn["order_by"] = false;

		$orderByConf =  array("characters",
							"lastupdate",
							"datecreated",
							"popular",
							"rating");		
		
        $user_order_by = "";
		if (in_array($_GET["orderby"], $orderByConf)) {
			$user_order_by = $_GET["orderby"];			
		}		

		if (($section == "article") || ($section == "random") || ($section == "mobile")) {
			$searchReturn["select_columns"] = "Article.*";
            if (SEARCH_FORCE_BOOLEANMODE == "on" && $section == "article") {
                $searchReturn["select_columns"] = $searchReturn["select_columns"].", Article.title REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
            }
		} elseif ($section == "count") {
			$searchReturn["select_columns"] = "COUNT(DISTINCT(Article.id))";
		} elseif ($section == "rss") {
			$searchReturn["select_columns"] = "Article.id";
		}

		$searchReturn["from_tables"] = "Article";

		if (isset($search_for["id"]) && is_numeric($search_for["id"]) && $search_for["id"] > 0) {
			$where_clause[] = "Article.id = ".$search_for["id"]."";
		}

        $sitemgrPreview = sess_validateItemPreview();
        if (!$sitemgrPreview) {
            $where_clause[] = "Article.status = 'A'";
        }

		if ($search_for["account"]) {
			$where_clause[] = "Article.account_id = ".$search_for["account"];
		}

		$where_clause[] = "Article.publication_date <= DATE_FORMAT(NOW(), '%Y-%m-%d')";

        if ($search_for["rating"]) {
            $ratings = explode("-", $search_for["rating"]);
            $where_clause[] = "Article.avg_review IN (".implode(",", $ratings).")";
        } else {
            if ($search_for["avg_review"]) {
                $where_clause[] = "Article.avg_review = ".$search_for["avg_review"];
            }
        }
                
        unset ($auxSearchCateg);
        if ($search_for["categories"]) {
            $categs = explode("-", $search_for["categories"]);

            foreach ($categs as $catID) {
                if (is_numeric($catID)) {
                    $auxSearchCateg[] = "(Article.cat_1_id = ".$catID." OR Article.parcat_1_level1_id = ".$catID." OR Article.parcat_1_level2_id = ".$catID." OR Article.parcat_1_level3_id = ".$catID." OR Article.parcat_1_level4_id = ".$catID." OR Article.cat_2_id = ".$catID." OR Article.parcat_2_level1_id = ".$catID." OR Article.parcat_2_level2_id = ".$catID." OR Article.parcat_2_level3_id = ".$catID." OR Article.parcat_2_level4_id = ".$catID." OR Article.cat_3_id = ".$catID." OR Article.parcat_3_level1_id = ".$catID." OR Article.parcat_3_level2_id = ".$catID." OR Article.parcat_3_level3_id = ".$catID." OR Article.parcat_3_level4_id = ".$catID." OR Article.cat_4_id = ".$catID." OR Article.parcat_4_level1_id = ".$catID." OR Article.parcat_4_level2_id = ".$catID." OR Article.parcat_4_level3_id = ".$catID." OR Article.parcat_4_level4_id = ".$catID." OR Article.cat_5_id = ".$catID." OR Article.parcat_5_level1_id = ".$catID." OR Article.parcat_5_level2_id = ".$catID." OR Article.parcat_5_level3_id = ".$catID." OR Article.parcat_5_level4_id = ".$catID.")";
                }
            }
            
            if (is_array($auxSearchCateg)) {
                $where_clause[] = " (".implode(" OR ", $auxSearchCateg).") ";
            }
            
        } elseif ($search_for["category_id"]) {
			$where_clause[] = "(Article.cat_1_id = ".$search_for["category_id"]." OR Article.parcat_1_level1_id = ".$search_for["category_id"]." OR Article.parcat_1_level2_id = ".$search_for["category_id"]." OR Article.parcat_1_level3_id = ".$search_for["category_id"]." OR Article.parcat_1_level4_id = ".$search_for["category_id"]." OR Article.cat_2_id = ".$search_for["category_id"]." OR Article.parcat_2_level1_id = ".$search_for["category_id"]." OR Article.parcat_2_level2_id = ".$search_for["category_id"]." OR Article.parcat_2_level3_id = ".$search_for["category_id"]." OR Article.parcat_2_level4_id = ".$search_for["category_id"]." OR Article.cat_3_id = ".$search_for["category_id"]." OR Article.parcat_3_level1_id = ".$search_for["category_id"]." OR Article.parcat_3_level2_id = ".$search_for["category_id"]." OR Article.parcat_3_level3_id = ".$search_for["category_id"]." OR Article.parcat_3_level4_id = ".$search_for["category_id"]." OR Article.cat_4_id = ".$search_for["category_id"]." OR Article.parcat_4_level1_id = ".$search_for["category_id"]." OR Article.parcat_4_level2_id = ".$search_for["category_id"]." OR Article.parcat_4_level3_id = ".$search_for["category_id"]." OR Article.parcat_4_level4_id = ".$search_for["category_id"]." OR Article.cat_5_id = ".$search_for["category_id"]." OR Article.parcat_5_level1_id = ".$search_for["category_id"]." OR Article.parcat_5_level2_id = ".$search_for["category_id"]." OR Article.parcat_5_level3_id = ".$search_for["category_id"]." OR Article.parcat_5_level4_id = ".$search_for["category_id"].")";
		}

		if (($search_for["keyword"]) && ($section != "mobile")) {
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Article.fulltextsearch_keyword";
			$where_clause[] = search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2");
		}

		if (($search_for["where"]) && ($section != "mobile")) {
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "Article.fulltextsearch_where";
			$where_clause[] = search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2");
		}

		if (($search_for["keyword"]) && ($section == "mobile")) {
			$search_for["where"] = $search_for["keyword"];
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Article.fulltextsearch_keyword";
			$search_for["where"] = str_replace("\\", "", $search_for["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "Article.fulltextsearch_where";
			$where_clause[] = "(".search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2")." OR ".search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2").")";
		}

		if ($where_clause && (count($where_clause) > 0)) {
			$searchReturn["where_clause"] = implode(" AND ", $where_clause);
		}		
		
		if ($user_order_by == "characters") {
			$user_order_by = "Article.title";
		} elseif ($user_order_by == "lastupdate") {
			$user_order_by = "Article.updated DESC";
		} elseif ($user_order_by == "datecreated") {
			$user_order_by = "Article.entered DESC";
		} elseif ($user_order_by == "popular") {
			$user_order_by = "Article.number_views DESC";
		} elseif ($user_order_by == "rating") {
			$user_order_by = "Article.avg_review DESC";
		}
        
        if (($section == "article") || ($section == "mobile") || ($section == "rss")) {
            $searchReturn["order_by"] = ($user_order_by && ($section == "article" || $section == "mobile") ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "article" ? "reg_exp_order DESC, " : "")."Article.level, Article.publication_date DESC, Article.random_number DESC,  Article.updated DESC, Article.entered DESC, Article.title, Article.id";
        } elseif ($section == "random") {
			$searchReturn["order_by"] = ((ARTICLE_SCALABILITY_OPTIMIZATION == "on")?("random_number DESC"):("RAND()"));
		} elseif ($section == "count") {
			$searchReturn["order_by"] = "Article.id";
		}

		if ($search_for["keyword"] && $order_by_keyword_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_keyword_score.($order_by_keyword_score2 ? ", ".$order_by_keyword_score2 : "");
		}

		if ($search_for["where"] && $order_by_where_score && ($section != "count") && ($section != "random")) {
			$searchReturn["select_columns"] .= ", ".$order_by_where_score;
		}

        if ((($search_for["keyword"] && $order_by_keyword_score) || ($search_for["where"] && $order_by_where_score) || ($search_for["zip"] && $order_by_zipcode_score)) && ($section != "count") && ($section != "random")) {
            $searchReturn["order_by"] = ($user_order_by && ($section == "article" || $section == "mobile") ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "article" ? "reg_exp_order DESC, " : "")."Article.level";

            if ($order_by_zipcode_score) {
                $searchReturn["order_by"] .= ", zipcode_score";
            }
            if ($order_by_keyword_score) {
                if ($order_by_keyword_score2){
                    $searchReturn["order_by"] .= ", keyword_score2 DESC";
                } else {
                    $searchReturn["order_by"] .= ", keyword_score DESC";
                }

            }
            if ($order_by_where_score) {
                $searchReturn["order_by"] .= ", where_score DESC";
            }
        }

		return $searchReturn;

	}
    
    function search_frontBlogSearch($search_for, $section) {

		$searchReturn["select_columns"] = false;
		$searchReturn["from_tables"] = false;
		$searchReturn["where_clause"] = false;
		$searchReturn["group_by"] = false;
		$searchReturn["order_by"] = false;

		$orderByConf =  array("characters",
							"lastupdate",
							"datecreated",
							"popular");

		if (in_array($_GET["orderby"], $orderByConf)) {
			$user_order_by = $_GET["orderby"];
		}

		if (($section == "blog") || ($section == "random")) {
			$searchReturn["select_columns"] = "Post.*";
            if (SEARCH_FORCE_BOOLEANMODE == "on" && $section == "blog") {
                $searchReturn["select_columns"] = $searchReturn["select_columns"].", Post.title REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
            }
		} elseif ($section == "count") {
			$searchReturn["select_columns"] = "COUNT(DISTINCT(Post.id))";
		} elseif ($section == "rss") {
			$searchReturn["select_columns"] = "Post.id";
		}

		$searchReturn["from_tables"] = "Post";

		if (isset($search_for["id"]) && is_numeric($search_for["id"])) {
			$where_clause[] = "Post.id = ".$search_for["id"]."";
		}

        $sitemgrPreview = sess_validateItemPreview();
        if (!$sitemgrPreview) {
            $where_clause[] = "Post.status = 'A'";
        }

		if ($search_for["category_id"]) {
            //Create a category object to get hierarchy of categories
			unset($aux_categoryObj,$aux_cat_hierarchy);
			$aux_categoryObj = new BlogCategory($search_for["category_id"]);
			$aux_cat_hierarchy = $aux_categoryObj->getHierarchy($search_for["category_id"],false,true);
			if ($aux_cat_hierarchy) {
				$post_ids = "0";
                unset($post_CategoryObj);
                $post_CategoryObj = new Blog_Category();
                $post_ids = $post_CategoryObj->getPostsByCategoryHierarchy($aux_categoryObj->root_id, $aux_categoryObj->left, $aux_categoryObj->right, $search_for["letter"]);
                $total_posts_ids = $post_CategoryObj->total_posts;			
					
				$where_clause[] = "Post.id IN (".$post_ids.")";
				$searchReturn["total_posts"] = $total_posts_ids;	
			}
		}

		if ($search_for["archive_year"]) {
			$where_clause[] = "YEAR(entered) = ".$search_for["archive_year"];
		}

		if ($search_for["archive_month"]) {
			$where_clause[] = "MONTH(entered) = ".$search_for["archive_month"];
		}

		if (($search_for["keyword"]) && ($section != "mobile")) {
			$search_for["keyword"] = str_replace("\\", "", $search_for["keyword"]);
			$search_for_keyword_fields[] = "Post.fulltextsearch_keyword";
			$where_clause[] = search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, "keyword_score", $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, "keyword_score2");
		}

		if ($where_clause && (count($where_clause) > 0)) {
			$searchReturn["where_clause"] = implode(" AND ", $where_clause);
		}

		if ($user_order_by == "characters") {
			$user_order_by = "Post.title";
		} elseif ($user_order_by == "lastupdate") {
			$user_order_by = "Post.updated DESC";
		} elseif ($user_order_by == "datecreated") {
			$user_order_by = "Post.entered DESC";
		} elseif ($user_order_by == "popular") {
			$user_order_by = "Post.number_views DESC";
		}
        
        if (($section == "blog") || ($section == "rss")) {
            $searchReturn["order_by"] = ($user_order_by && $section == "blog" ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "blog" ? "reg_exp_order DESC, " : "")."Post.entered DESC, Post.updated DESC, Post.title, Post.id";
        } elseif ($section == "count") {
			$searchReturn["order_by"] = "Post.id";
		}

		if ($search_for["keyword"] && $order_by_keyword_score && ($section != "count") && ($section != "random")) {
            if ($order_by_keyword_score2) {
                $searchReturn["select_columns"] .= ", ".$order_by_keyword_score.", ".$order_by_keyword_score2;
            } else {
                $searchReturn["select_columns"] .= ", ".$order_by_keyword_score;
            }
		}

		if (($search_for["keyword"] && $order_by_keyword_score) && ($section != "count") && ($section != "random")) {
			$searchReturn["order_by"] = ($user_order_by && $section == "blog" ? $user_order_by.", " : "").(SEARCH_FORCE_BOOLEANMODE == "on" && $section == "blog" ? "reg_exp_order DESC, " : "")."Post.entered DESC";
           
            if ($order_by_keyword_score) {
                if ($order_by_keyword_score2) {
                    $searchReturn["order_by"] .= ", keyword_score2 DESC";
                } else {
                    $searchReturn["order_by"] .= ", keyword_score DESC";
                }
			}
		}
        
		return $searchReturn;

	}

	function search_getSQLFullTextSearch($searchfor, $fields, $order_by_fieldname, &$order_by_score, $force_specific_search="", &$order_by_score2, $order_by_fieldname2 = "") {

		$order_by_score = "";
		$order_by_score2 = "";
		unset($sql_aux);
		unset($searchfor_aux);
		unset($searchfor_array);
		if (($force_specific_search != "exactmatch") && ($force_specific_search != "anyword") && ($force_specific_search != "allwords")) {
			$force_specific_search = "";
		}
        if (!$force_specific_search) {
            setting_get("default_search_option", $force_specific_search);
        }
        if (!$force_specific_search) {
            $force_specific_search = "exactmatch";
        }

		$searchfor = trim($searchfor);

		$words_array = explode(" ", $searchfor);

		/*
		 * Remove wrong spaces
		 */
		unset($aux_words_array);
		for ($i = 0; $i < count($words_array); $i++) {
			if (strlen($words_array[$i]) > 0) {
				$aux_words_array[] = trim($words_array[$i]);
			}
		}
		
		if (count($aux_words_array) > 0) {
			unset($words_array);
			$words_array = $aux_words_array;
			$searchfor = implode(" ",$words_array);
		}
		
		$thesaurus = false;
		if (count($words_array) == 2) {
			$thesaurus = str_replace(" ", "", $searchfor);
		}

		$force_text_search = false;
		if (count($words_array) >= 2) {
			foreach ($words_array as $each_word) {
				if (string_strlen($each_word) <= 3) {
					$force_text_search = true;
					break;
				}
			}
		}

		$force_like = false;
		if (LISTING_SCALABILITY_OPTIMIZATION != "on") {
			foreach ($words_array as $each_searchfor) {
				if (string_strlen(Inflector::singularize($each_searchfor)) < (int)FT_MIN_WORD_LEN) {
					$force_like = true;
					break;
				}
			}
		}
		
        $auxWordsArray = explode("-", $searchfor);
        if (is_array($auxWordsArray) && $auxWordsArray[0]) {
            foreach ($auxWordsArray as $auxWord) {
                if (string_strlen(Inflector::singularize($auxWord)) < (int)FT_MIN_WORD_LEN) {
                    $force_like = true;
                    break;
                }
            }
        }
                
		if ($force_specific_search == "exactmatch") {

			$searchfor = db_formatString($searchfor);
			$searchfor = string_substr($searchfor, 1, string_strlen($searchfor)-2);

			if (string_strlen($searchfor) < (int)FT_MIN_WORD_LEN) {
				if ($searchfor == "'") $searchfor = "\'";
				foreach ($fields as $field) {
					$sql_aux[] = "(".$field." = '$searchfor' OR ".$field." LIKE '$searchfor %' OR ".$field." LIKE '% $searchfor' OR ".$field." LIKE '% $searchfor %')";
				}

				return "(".(implode(" OR ", $sql_aux)).")";
			} else {
				foreach ($words_array as $each_searchfor) {
					$searchfor_array[] = $each_searchfor;
				}

				$searchfor_array = array_unique($searchfor_array);
				$formated_searchfor = implode(" ", $searchfor_array);

                if (SEARCH_FORCE_BOOLEANMODE == "on") {
                    $auxFields = implode(", ", $fields);
                    if (string_strpos($auxFields, "Promotion") !== false) {
                        $auxFields = str_replace("fulltextsearch_keyword", "name", $auxFields);
                    } else {
                        $auxFields = str_replace("fulltextsearch_keyword", "title", $auxFields);
                    }
                    $order_by_score = "MATCH (".$auxFields.") AGAINST ('\"".addslashes($formated_searchfor)."\"' IN BOOLEAN MODE) as ".$order_by_fieldname;
                    $order_by_score2 = "MATCH (".implode(", ", $fields).") AGAINST ('\"".addslashes($formated_searchfor)."\"') as ".$order_by_fieldname2;
                } else {
                    $order_by_score = "MATCH (".implode(", ", $fields).") AGAINST ('\"".addslashes($formated_searchfor)."\"') as ".$order_by_fieldname;
                }
				
				return "MATCH (".implode(", ", $fields).") AGAINST ('\"".addslashes($formated_searchfor)."\"' IN BOOLEAN MODE)";
			}

		} elseif ((string_strlen($searchfor) < (int)FT_MIN_WORD_LEN || $force_like) && ($force_specific_search == "anyword" || !$force_specific_search)) {

			unset($searchfor_aux_array);
			foreach ($words_array as $each_searchfor) {
				$searchfor_aux = $each_searchfor;
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
				$searchfor_array[] = $searchfor_aux;
			}

			unset($searchfor_aux_array);
			foreach ($words_array as $each_searchfor) {
				$searchfor_aux = Inflector::singularize($each_searchfor);
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
				$searchfor_array[] = $searchfor_aux;
			}

			unset($searchfor_aux_array);
			foreach ($words_array as $each_searchfor) {
				$searchfor_aux = Inflector::pluralize($each_searchfor);
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
				$searchfor_array[] = $searchfor_aux;
			}

			if ($thesaurus) {
				$searchfor_aux = $thesaurus;
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
				$searchfor_array[] = $searchfor_aux;
			}

			$searchfor_array = array_unique($searchfor_array);

			$keyCheck = array_search("'",$searchfor_array);
			if ($keyCheck !== false) {
				$searchfor_array[$keyCheck] = "\'";
			}

			foreach ($searchfor_array as $each_searchfor) {
				foreach ($fields as $field) {
					$sql_aux[] = $field." = '$each_searchfor'";
					$sql_aux[] = $field." LIKE '$each_searchfor %'";
					$sql_aux[] = $field." LIKE '% $each_searchfor'";
					$sql_aux[] = $field." LIKE '% $each_searchfor %'";
				}
			}

			return "(".(implode(" OR ", $sql_aux)).")";

		} elseif ($force_specific_search == "anyword" || !$force_specific_search) {

    		unset($searchfor_aux_array);
			foreach ($words_array as $each_searchfor) {
				$searchfor_aux_array[] = $each_searchfor;
			}
			$searchfor_aux = implode(" ", $searchfor_aux_array);
            
            $searchfor_aux_booleanMode = $searchfor_aux;
            
			$searchfor_aux = db_formatString($searchfor_aux);
			$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux) - 2);
			$searchfor_array[] = $searchfor_aux;

			unset($searchfor_aux_array);
			foreach ($words_array as $each_searchfor) {
				$searchfor_aux_array[] = Inflector::singularize($each_searchfor);
			}
			$searchfor_aux = implode(" ", $searchfor_aux_array);
			$searchfor_aux = db_formatString($searchfor_aux);
			$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux) - 2);
			$searchfor_array[] = $searchfor_aux;

			unset($searchfor_aux_array);
			foreach ($words_array as $each_searchfor) {
				$searchfor_aux_array[] = Inflector::pluralize($each_searchfor);
			}
			$searchfor_aux = implode(" ", $searchfor_aux_array);
			$searchfor_aux = db_formatString($searchfor_aux);
			$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux) - 2);
			$searchfor_array[] = $searchfor_aux;

			if ($thesaurus) {
				$searchfor_aux = $thesaurus;
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux) - 2);
				$searchfor_array[] = $searchfor_aux;
			}

			$searchfor_array = array_unique($searchfor_array);

			foreach ($searchfor_array as $each_searchfor) {
				$sql_aux[] = $each_searchfor;
			}

			$searchfor_array = array_unique($sql_aux);

			$formated_searchfor = db_formatString(implode(" ", $searchfor_array));
            if (SEARCH_FORCE_BOOLEANMODE == "on") {
                $auxFields = implode(", ", $fields);
                if (string_strpos($auxFields, "Promotion") !== false) {
                    $auxFields = str_replace("fulltextsearch_keyword", "name", $auxFields);
                } else {
                    $auxFields = str_replace("fulltextsearch_keyword", "title", $auxFields);
                }
                $order_by_score = "MATCH (".$auxFields.") AGAINST ('\"".addslashes($searchfor_aux_booleanMode)."\"' IN BOOLEAN MODE) as ".$order_by_fieldname;
                $order_by_score2 = "MATCH (".implode(", ", $fields).") AGAINST (".$formated_searchfor.") as ".$order_by_fieldname2;
            } else {
                $order_by_score = "MATCH (".implode(", ", $fields).") AGAINST (".$formated_searchfor.") as ".$order_by_fieldname;
            }

			return "MATCH (".implode(", ", $fields).") AGAINST (".$formated_searchfor." IN BOOLEAN MODE)";

		} elseif (($force_specific_search == "allwords")) {

			if ((string_strlen($searchfor) < (int)FT_MIN_WORD_LEN) || ($force_text_search) || $force_like) {

				foreach ($words_array as $each_searchfor) {
					$searchfor_aux = $each_searchfor;
					$searchfor_aux = db_formatString($searchfor_aux);
					$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
					$searchfor_words[] = $searchfor_aux;
				}

				foreach ($words_array as $each_searchfor) {
					$searchfor_aux = Inflector::singularize($each_searchfor);
					$searchfor_aux = db_formatString($searchfor_aux);
					$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
					$searchfor_singular[] = $searchfor_aux;
				}

				foreach ($words_array as $each_searchfor) {
					$searchfor_aux = Inflector::pluralize($each_searchfor);
					$searchfor_aux = db_formatString($searchfor_aux);
					$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
					$searchfor_plural[] = $searchfor_aux;
				}

				unset($searchfor_aux_array);
				$searchfor_aux_array[] = implode(" ", $searchfor_words);
				$searchfor_aux_array[] = implode(" ", $searchfor_singular);
				$searchfor_aux_array[] = implode(" ", $searchfor_plural);

				$searchfor_aux_array = array_unique($searchfor_aux_array);

				foreach ($searchfor_aux_array as $searchword) {
					$searchfor_array = array_merge((array)$searchfor_array, explode(" ", $searchword));
				}
				
				$keyCheck = array_search("'",$searchfor_array);
				if ($keyCheck !== false) {
					$searchfor_array[$keyCheck] = "\'";
				}
				$count = count($words_array);

				foreach ($fields as $field) {
					unset($sqlaux);
					$i = 1;
					$j = 0;
					foreach ($searchfor_array as $each_searchfor) {
						$sqlaux[$j][] = "(".$field." = '$each_searchfor' OR ".$field." LIKE '$each_searchfor %' OR ".$field." LIKE '% $each_searchfor' OR ".$field." LIKE '% $each_searchfor %')";

						if ($i >= $count) {
							$j++;
							$i = 1;
						} else {
							$i++;
						}
					}

					foreach ($sqlaux as $sql) {
						$sql_aux[] = "(".(implode(" AND ", $sql)).")";
					}
				}
			
				return "(".(implode(" OR ", $sql_aux)).")";

			} else {

				unset($searchfor_aux_array);
				foreach ($words_array as $each_searchfor) {
					$searchfor_aux_array[] = "+".$each_searchfor;
				}
				$searchfor_aux = implode(" ", $searchfor_aux_array);
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
				$searchfor_array[] = "(".$searchfor_aux.")";

				unset($searchfor_aux_array);
				foreach ($words_array as $each_searchfor) {
					$searchfor_aux_array[] = "+".Inflector::singularize($each_searchfor);
				}
				$searchfor_aux = implode(" ", $searchfor_aux_array);
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
				$searchfor_array[] = "(".$searchfor_aux.")";

				unset($searchfor_aux_array);
				foreach ($words_array as $each_searchfor) {
					$searchfor_aux_array[] = "+".Inflector::pluralize($each_searchfor);
				}
				$searchfor_aux = implode(" ", $searchfor_aux_array);
				$searchfor_aux = db_formatString($searchfor_aux);
				$searchfor_aux = string_substr($searchfor_aux, 1, string_strlen($searchfor_aux)-2);
				$searchfor_array[] = "(".$searchfor_aux.")";

				$searchfor_array = array_unique($searchfor_array);

                $formated_searchfor_aux = implode(" ", $searchfor_array);

				$formated_searchfor = db_formatString(implode(" ", $searchfor_array));

                if (SEARCH_FORCE_BOOLEANMODE == "on") {
                    $auxFields = implode(", ", $fields);
                    if (string_strpos($auxFields, "Promotion") !== false) {
                        $auxFields = str_replace("fulltextsearch_keyword", "name", $auxFields);
                    } else {
                        $auxFields = str_replace("fulltextsearch_keyword", "title", $auxFields);
                    }
                    $order_by_score = "MATCH (".$auxFields.") AGAINST ('\"".addslashes($formated_searchfor_aux)."\"' IN BOOLEAN MODE) as ".$order_by_fieldname;
                    $order_by_score2 = "MATCH (".implode(", ", $fields).") AGAINST (".$formated_searchfor.") as ".$order_by_fieldname2;
                } else {
                    $order_by_score = "MATCH (".implode(", ", $fields).") AGAINST (".$formated_searchfor.") as ".$order_by_fieldname;
                }

				return "MATCH (".implode(", ", $fields).") AGAINST (".$formated_searchfor." IN BOOLEAN MODE)";

			}
		}

		return "";
	}

    function search_frontListingAppKeyword($array, &$searchReturn) {
        
        if ($array["keyword"]) {
            $search_for["keyword"] = str_replace("\\", "", $array["keyword"]);
            $search_for_keyword_fields[] = "Listing_Summary.fulltextsearch_keyword";

            $aux_label_keyword_score    = "keyword_score";
            $aux_label_keyword_score2   = "keyword_score2";
            $where_clause[] = search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, $aux_label_keyword_score, $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, $aux_label_keyword_score2);
            
            if (SEARCH_FORCE_BOOLEANMODE == "on") {
                $searchReturn["select_columns"] = $searchReturn["select_columns"].", Listing_Summary.title REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
            }
            
            if ($order_by_keyword_score) {
                $searchReturn["select_columns"] .= ", ".$order_by_keyword_score;
            }

            if ($order_by_keyword_score2) {
                $searchReturn["select_columns"] .= ", ".$order_by_keyword_score2;
            }

        }
        
        if ($array["where"]) {
            $search_for["where"] = str_replace("\\", "", $array["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "Listing_Summary.fulltextsearch_where";
			$where_clause[] = search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2");
        }
        
        /**
         * Searching inside a category         
         */
        if ($array["category_id"]) {
            //Create a category object to get hierarchy of categories
			unset($aux_categoryObj,$aux_cat_hierarchy);
			$aux_categoryObj = new ListingCategory($array["category_id"]);
			$aux_cat_hierarchy = $aux_categoryObj->getHierarchy($array["category_id"], false, true);
			if ($aux_cat_hierarchy) {
				$listing_ids = "0";
                unset($listing_CategoryObj);
                $listing_CategoryObj = new Listing_Category();
                $listing_ids = $listing_CategoryObj->getListingsByCategoryHierarchy($aux_categoryObj->root_id,$aux_categoryObj->left,$aux_categoryObj->right,$array["letter"]);
				$where_clause[] = $searchReturn["from_tables"].".id IN (".$listing_ids.")";
			}
		}

        unset($aux_order_by);

        if ($array["orderby"]) {
            api_prepareOrderBy($array["orderby"], "listing", $aux_order_by);
        }

        if (SEARCH_FORCE_BOOLEANMODE == "on" && $array["keyword"]) {
            $aux_order_by[] = "reg_exp_order desc";
        }

        if (!$array["orderby"]) {
            $aux_order_by[] = "Listing_Summary.level".(BACKLINK_FEATURE == "on" ? ",Listing_Summary.backlink DESC" : "");
        }

        if ($order_by_keyword_score && $array["keyword"]) {
            $aux_order_by[] = $aux_label_keyword_score." DESC";
        }

        if ($order_by_keyword_score2 && $array["keyword"]) {
            $aux_order_by[] = $aux_label_keyword_score2." DESC";
        }

        if (is_array($aux_order_by)) {
            $searchReturn["order_by"] = implode(", ",$aux_order_by);
        }
                    
//        search_prepareFilters($array, $searchReturn, "Listing_Summary", $where_clause);
        
        if (is_array($where_clause)) {
            $searchReturn["where_clause"] .= " AND (".implode(" AND ", $where_clause).") ";
        }
    }
    
    function search_frontListingDrawMap($array, $section, $aux_select_columns = false, $mapReview = false) {
        
        if (($array["module"] == "promotion") || ($array["module"] == "deal")) {
            $latitudeField = "listing_latitude";
            $longitudeField = "listing_longitude";
            
            if($array["myLat"] && $array["myLong"]){
                if (ZIPCODE_UNIT == "mile") {
                    $order_by_zipcode_score = "SQRT(POW((69.1 * (".$array["myLat"]." - $latitudeField)), 2) + POW((53.0 * (".$array["myLong"]." - $longitudeField)), 2)) AS distance_score";
                } elseif (ZIPCODE_UNIT == "km") {
                    $order_by_zipcode_score = "SQRT(POW((69.1 * (".$array["myLat"]." - $latitudeField)), 2) + POW((53.0 * (".$array["myLong"]." - $longitudeField)), 2)) * 1.609344 AS distance_score";
                }
            }else{
                $order_by_zipcode_score = false;
            }
            
            $searchReturn["from_tables"]    = "Promotion";
            $searchReturn["order_by"]       = "Promotion.listing_level, Promotion.name";
            $searchReturn["select_columns"] = (is_array($aux_select_columns) ? implode(", ",$aux_select_columns) : "Promotion.name, Promotion.id, Promotion.listing_latitude, Promotion.listing_longitude").($order_by_zipcode_score ? ",".$order_by_zipcode_score : "");
        } else {
            $latitudeField                  = "latitude";
            $longitudeField                 = "longitude";
            
            if($array["myLat"] && $array["myLong"]){
                if (ZIPCODE_UNIT == "mile") {
                    $order_by_zipcode_score = "SQRT(POW((69.1 * (".$array["myLat"]." - $latitudeField)), 2) + POW((53.0 * (".$array["myLong"]." - $longitudeField)), 2)) AS distance_score";
                } elseif (ZIPCODE_UNIT == "km") {
                    $order_by_zipcode_score = "SQRT(POW((69.1 * (".$array["myLat"]." - $latitudeField)), 2) + POW((53.0 * (".$array["myLong"]." - $longitudeField)), 2)) * 1.609344 AS distance_score";
                }
            }else{
                $order_by_zipcode_score = false;
            }
            
            $searchReturn["from_tables"]    = "Listing_Summary";
            $searchReturn["order_by"]       = "Listing_Summary.level, Listing_Summary.title";
            $searchReturn["select_columns"] = (is_array($aux_select_columns) ? implode(", ",$aux_select_columns) : "Listing_Summary.title, Listing_Summary.id, Listing_Summary.latitude, Listing_Summary.longitude").($order_by_zipcode_score ? ",".$order_by_zipcode_score : "");
        }
        
        $where = "";
        $where .= "(";
        $where .= "$latitudeField <= ".$array["drawLat1"];
        $where .= " AND ";
        $where .= "$latitudeField >= ".$array["drawLat0"];
        $where .= " AND ";
        $where .= "$longitudeField <= ".$array["drawLong1"];
        $where .= " AND ";
        $where .= "$longitudeField >= ".$array["drawLong0"];        
        $where .= ")";
        
        $levelObj = new ListingLevel(true);
        $levels = $levelObj->getLevelValues();

        unset($allowed_levels);
        foreach ($levels as $each_level) {
            if ( ($levelObj->getActive($each_level) == 'y') && ($levelObj->getHasPromotion($each_level) == 'y' ) ) {
                $allowed_levels[] = $each_level;
            }
        }

        $search_levels = ($allowed_levels ? implode(",", $allowed_levels) : "0");
        
        if (($array["module"] == "promotion") || ($array["module"] == "deal")) {
            $where .= " AND listing_status = 'A' AND Promotion.end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND Promotion.start_date <= DATE_FORMAT(NOW(), '%Y-%m-%d') AND Promotion.listing_id > 0 AND Promotion.listing_level IN ($search_levels)";
        } else {
            $where .= " AND status = 'A'".($mapReview ? " AND avg_review > 0" : "");
        }
        
        $searchReturn["where_clause"]   = $where;
        $searchReturn["group_by"]       = false;

        if ($array["keyword"] || $array["category_id"]) {
            if (($array["module"] == "promotion") || ($array["module"] == "deal")) {
                search_frontAppKeyword($array, $searchReturn,"Promotion");
            } else {
                search_frontListingAppKeyword($array, $searchReturn);
            }
        } else {
//            search_prepareFilters($array, $searchReturn, $searchReturn["from_tables"], $where_clause);

            if (is_array($where_clause)) {
                $where .= " AND (".implode(" AND ", $where_clause).") ";
                $searchReturn["where_clause"]   = $where;
            }
        }
           
        if (is_array($searchReturn)) {
            return $searchReturn;
        } else {
            return false;
        }
    }
    
    function search_frontAppKeyword($array, &$searchReturn, $tableName) {
        
        if ($array["keyword"]) {
            $search_for["keyword"] = str_replace("\\", "", $array["keyword"]);
            $search_for_keyword_fields[] = $tableName.".fulltextsearch_keyword";

            $aux_label_keyword_score    = "keyword_score";
            $aux_label_keyword_score2   = "keyword_score2";
            $where_clause[] = search_getSQLFullTextSearch($search_for["keyword"], $search_for_keyword_fields, $aux_label_keyword_score, $order_by_keyword_score, $search_for["match"], $order_by_keyword_score2, $aux_label_keyword_score2);
            
            if (SEARCH_FORCE_BOOLEANMODE == "on") {
                if ($tableName == "Promotion") {
                    $searchReturn["select_columns"] = $searchReturn["select_columns"].", ".$tableName.".name REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
                } else {
                    $searchReturn["select_columns"] = $searchReturn["select_columns"].", ".$tableName.".title REGEXP '^".db_formatString($search_for["keyword"], "", false, false)."$' AS reg_exp_order";
                }
            }
            
            if ($order_by_keyword_score) {
                $searchReturn["select_columns"] .= ", ".$order_by_keyword_score;
            }

            if ($order_by_keyword_score2) {
                $searchReturn["select_columns"] .= ", ".$order_by_keyword_score2;
            }

        }
        
        if ($array["where"] && ($tableName == "Event" || $tableName == "Classified" || $tableName == "Promotion")) {
            $search_for["where"] = str_replace("\\", "", $array["where"]);
			if (($locpos = string_strpos($search_for["where"], ",")) !== false) {
				$search_for["where"] = str_replace(",", "", $search_for["where"]);
			}
			$search_for_where_fields[] = "$tableName.fulltextsearch_where";
			$where_clause[] = search_getSQLFullTextSearch($search_for["where"], $search_for_where_fields, "where_score", $order_by_where_score, "allwords", $order_by_where_score2, "where_score2");
        }
                   
        unset($aux_order_by);

        if ($array["orderby"]) {
            api_prepareOrderBy($array["orderby"], ($tableName == "Promotion" ? "deal" : strtolower($tableName)), $aux_order_by);
        }

        if (SEARCH_FORCE_BOOLEANMODE == "on" && $array["keyword"]) {
            $aux_order_by[] = "reg_exp_order desc";
        }

        if (!$array["orderby"] && $tableName != "Promotion"  && $tableName != "Post") {
            $aux_order_by[] = "$tableName.level";
        } else {
            if ($tableName == "Promotion") {
                $aux_order_by[] = "Promotion.end_date";
            }
            if ($tableName == "Post") {
                $aux_order_by[] = "Post.entered DESC";
            }
        }

        if ($order_by_keyword_score && $array["keyword"]) {
            $aux_order_by[] = $aux_label_keyword_score." DESC";
        }

        if ($order_by_keyword_score2 && $array["keyword"]) {
            $aux_order_by[] = $aux_label_keyword_score2." DESC";
        }

        if (is_array($aux_order_by)) {
            $searchReturn["order_by"] = implode(", ",$aux_order_by);
        }
        
//        search_prepareFilters($array, $searchReturn, $tableName, $where_clause);
        
        if (is_array($where_clause)) {
            $searchReturn["where_clause"] .= " AND (".implode(" AND ", $where_clause).") ";
        }
        
    }
    
    function search_frontDrawMap($array, $aux_select_columns = false, $tableName) {
        
        $latitudeField = "latitude";
        $longitudeField = "longitude";
        
        $where = "";
        
        if ($tableName == "Event") {
            $where .= "((end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') OR until_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND repeat_event = 'N') OR (repeat_event = 'Y')) AND";
        }
        
        $where .= "(";
        $where .= "$latitudeField <= ".$array["drawLat1"];
        $where .= " AND ";
        $where .= "$latitudeField >= ".$array["drawLat0"];
        $where .= " AND ";
        $where .= "$longitudeField <= ".$array["drawLong1"];
        $where .= " AND ";
        $where .= "$longitudeField >= ".$array["drawLong0"];        
        $where .= ")";
        $where .= " AND status = 'A'";
        
        $searchReturn["from_tables"]    = $tableName;
        $searchReturn["order_by"]       = $tableName.".level,".$tableName.".title";
        $searchReturn["where_clause"]   = $where;
        $searchReturn["select_columns"] = (is_array($aux_select_columns) ? implode(", ",$aux_select_columns) : $tableName.".title, ".$tableName.".id, ".$tableName.".latitude, ".$tableName.".longitude");
        $searchReturn["group_by"]       = false;

        if ($array["keyword"] || $array["category_id"]) {
            search_frontAppKeyword($array, $searchReturn, $tableName);
        }
           
        if (is_array($searchReturn)) {
            return $searchReturn;
        } else {
            return false;
        }
    }
    
    function search_prepareFilters($array, $searchReturn, $tableName = "Listing_Summary", &$where_clause) {

        //Categories
        if ($array["categories"] && ($tableName == "Listing_Summary" || $tableName == "Promotion")) {
            $categs = explode("-", $array["categories"]);
            $listing_ids = "";
            foreach ($categs as $catID) {
                if (is_numeric($catID)) {
                    unset($aux_categoryObj, $aux_cat_hierarchy);
                    $aux_categoryObj = new ListingCategory($catID);
                    $aux_cat_hierarchy = $aux_categoryObj->getHierarchy($catID, false, true);
                    if ($aux_cat_hierarchy) {
                        unset($listing_CategoryObj);
                        $listing_CategoryObj = new Listing_Category();
                        $listing_ids .= ($listing_ids ? "," : "").$listing_CategoryObj->getListingsByCategoryHierarchy($aux_categoryObj->root_id, $aux_categoryObj->left, $aux_categoryObj->right, $array["letter"]);
                    }
                }
            }
            if ($listing_ids) {
                $where_clause[] = $searchReturn["from_tables"].".".($tableName == "Promotion" ? "listing_" : "")."id IN (".$listing_ids.")";
            }
        }
                        
        //Rating
        if ($array["rating"] && ($tableName == "Listing_Summary" || $tableName == "Promotion" || $tableName == "Article")) {
            $ratings = explode("-", $array["rating"]);
            $where_clause[] = $searchReturn["from_tables"].".avg_review IN (".implode(",", $ratings).")";
        }
        
        //Price
        if ($array["filter_price"] && $tableName == "Listing_Summary") {
            $prices = explode("-", $array["filter_price"]);
            $where_clause[] = $searchReturn["from_tables"].".price IN (".implode(",", $prices).")";
        }

        //Deal
        if ($array["filter_deal"] && $tableName == "Listing_Summary") {
            
            //Get available promotions ids
            $db = db_getDBObject();
            $search_forDeal = $array;
            unset($search_forDeal["rating"]);
            $searchReturnDeal = search_frontPromotionSearch($search_forDeal, "promotion_results");
            $sql = "SELECT id FROM ".$searchReturnDeal["from_tables"]." WHERE ".$searchReturnDeal["where_clause"];
            $result = $db->query($sql);
            if (mysql_num_rows($result) > 0) {
                $idsDeal = array();
                while ($row = mysql_fetch_assoc($result)) {
                    $idsDeal[] = $row["id"];
                }
            }
            
            $where_clause[] = $searchReturn["from_tables"].".promotion_id IN (".(is_array($idsDeal) ? implode(",", $idsDeal) : "0").")";
        }
        
        //Location
        if ($tableName != "Article" && $tableName != "Blog") {
            $_locations = explode(",", EDIR_LOCATIONS);
            unset($aux_sql_location);
            foreach($_locations as $_location_level) {
                if ($array["filter_location_".$_location_level]) {
                    $filter_to_location_ids = explode("-", $array["filter_location_".$_location_level]);
                    foreach ($filter_to_location_ids as $filter_to_location) {
                        $aux_sql_location[] = $searchReturn["from_tables"].".".($tableName == "Promotion" ? "listing_location" : "location_").$_location_level." = ".$filter_to_location."";
                    }
                }
            }
            if (is_array($aux_sql_location)) {
                $where_clause[] = " (".implode(" OR ",$aux_sql_location).") ";
            }
        }
                
        //Deal period
        if ($array["filter_valid_for"] && $tableName == "Promotion") {
            if ($array["filter_valid_for"] == "deal_week") {
                $where_clause[] = "({$searchReturn["from_tables"]}.end_date > DATE_FORMAT(adddate(now(), interval 1 week), '%Y-%m-%d'))";
            }
            if ($array["filter_valid_for"] == "deal_1_day") {
                $where_clause[] = "({$searchReturn["from_tables"]}.end_date <= DATE_FORMAT(adddate(now(), interval 1 day), '%Y-%m-%d'))";
            }
            if ($array["filter_valid_for"] == "deal_2_day") {
                $where_clause[] = "({$searchReturn["from_tables"]}.end_date > DATE_FORMAT(adddate(now(), interval 2 day), '%Y-%m-%d'))";
            }
        }
        
    }
    
?>