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
	# * FILE: /classes/class_LocationCounter.php
	# ----------------------------------------------------------------------------------------------------

	/**
	 * <code>
	 *		$locationCounterObj = new LocationCounter($id);
	 * <code>
	 * @copyright Copyright 2013 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.
	 * @version 9.9.00
	 * @package Classes
	 * @name LocationCounter
	 * @access Public
	 */
	class LocationCounter extends Handle {

		/**
		 * @var integer
		 * @access Private
		 */
		var $id;
		/**
		 * @var integer
		 * @access Private
		 */
		var $location_level;
		/**
		 * @var integer
		 * @access Private
		 */
		var $location_id;
		/**
		 * @var integer
		 * @access Private
		 */
		var $count;
		/**
		 * @var string
		 * @access Private
		 */
		var $title;
		/**
		 * @var string
		 * @access Private
		 */
		var $full_friendly_url;
		/**
		 * @var string
		 * @access Private
		 */
		var $module_name;
		
		/**
		 * <code>
		 *		$locationCounterObj = new LocationCounter($id);
		 *		//OR
		 *		$locationCounterObj = new LocationCounter($row);
		 * <code>
		 * @copyright Copyright 2013 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.9.00
		 * @name LocationCounter
		 * @access Public
		 * @param mixed $var
		 */
		function LocationCounter($var = '', $domain_id = false, $module = false) {

			if (is_numeric($var) && ($var)) {
				$dbMain = db_getDBObject(DEFAULT_DB, true);
				if ($domain_id) {
					$this->domain_id = $domain_id;
					$db = db_getDBObjectByDomainID($domain_id, $dbMain);
				} else if (defined("SELECTED_DOMAIN_ID")) {
					$db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
				} else {
					$db = db_getDBObject();
				}
				unset($dbMain);
				$sql = "SELECT * FROM ".$module."_LocationCounter WHERE id = $var";

				$row = mysql_fetch_array($db->query($sql));

				unset($db);

				$this->makeFromRow($row);
			} else {
                if (!is_array($var)) {
                    $var = array();
                }
				$this->makeFromRow($var);
			}

		}

		/**
		 * <code>
		 *		$this->makeFromRow($row);
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 8.0.00
		 * @name makeFromRow
		 * @access Public
		 * @param array $row
		 */
		function makeFromRow($row='') {

			$this->id					= ($row["id"])					? $row["id"]					: ($this->id				? $this->id					: 0);
			$this->location_level		= ($row["location_level"])  	? $row["location_level"]		: ($this->location_level	? $this->location_level		: 0);
			$this->location_id          = ($row["location_id"])         ? $row["location_id"]           : ($this->location_id       ? $this->location_id		: 0);
			$this->count                = ($row["count"])               ? $row["count"]                 : ($this->count             ? $this->count      		: 0);
			$this->title                = ($row["title"])               ? $row["title"]                 : ($this->title             ? $this->title      		: "");
			$this->full_friendly_url    = ($row["full_friendly_url"])   ? $row["full_friendly_url"]     : ($this->full_friendly_url ? $this->full_friendly_url  : "");
            
		}        
        
        function ReCountLocations($module, $domain_id = false) {
            
            $dbMain = db_getDBObject(DEFAULT_DB, true);

			if ($domain_id) {
                $dbObj = db_getDBObjectByDomainID($domain_id, $dbMain);
			} elseif (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
			} else {
                $dbObj = db_getDBObject();
			}

			unset($dbMain);

            /**
             * Clean table
             */
            $sqlDelete = "DELETE FROM ".ucfirst($module)."_LocationCounter";
            $dbObj->query($sqlDelete);

            for ($i = 1; $i <= 5; $i++) {

                if ($module == "listing") {
                    $sql = "SELECT count(id) AS total, location_".$i." FROM Listing_Summary WHERE location_".$i." > 0 AND status = 'A' GROUP BY `location_".$i;
                } elseif ($module == "promotion") {
                    
                    $levelObj = new ListingLevel(true);
                    $levels = $levelObj->getLevelValues();

                    unset($allowed_levels);
                    foreach ($levels as $each_level) {
                        if ( ($levelObj->getActive($each_level) == 'y') && ($levelObj->getHasPromotion($each_level) == 'y' ) ) {
                            $allowed_levels[] = $each_level;
                        }
                    }

                    $search_levels = ($allowed_levels ? implode(",", $allowed_levels) : "0");
                    
                    $sql = "SELECT count(id) AS total, listing_location".$i." FROM ".ucfirst($module)." WHERE listing_location".$i." > 0 AND listing_status = 'A' AND listing_id > 0 AND listing_level IN ($search_levels) AND Promotion.end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND Promotion.start_date <= DATE_FORMAT(NOW(), '%Y-%m-%d') GROUP BY listing_location".$i." ORDER BY listing_location".$i;
                } else {
                    $sql = "SELECT count(id) AS total, location_".$i." FROM ".ucfirst($module)." WHERE location_".$i." > 0 AND status = 'A' GROUP BY location_".$i." ORDER BY location_".$i;
                }
                $result = $dbObj->query($sql);
                if (mysql_num_rows($result)) {
                    
                    if ($module == "promotion") {
                        $fieldName = "listing_location".$i;
                    } else {
                        $fieldName = "location_".$i;
                    }
                    
                    while ($row = mysql_fetch_assoc($result)) {
                        unset($locationObj);
                        $className = "Location".$i;
                        $locationObj = new $className($row[$fieldName]);
                        $title = $locationObj->getString("name");
                        $full_friendly_url = $locationObj->getFullFriendlyURL();
                    
                        $sqlUpdate = "INSERT INTO ".ucfirst($module)."_LocationCounter (count, location_level, location_id,title, full_friendly_url) VALUES (";
                        $sqlUpdate .= $row["total"].", ".$i.", ".$row[$fieldName].", ".db_formatString($title).", ".db_formatString($full_friendly_url).")";
                        $dbObj->query($sqlUpdate);
                    }
                }
            } 
        }
        
        public static function getLastLevelLocationCounter($locationLevel, $module, $orderField, $limit) {
            
            if ($locationLevel) {
                $dbMain = db_getDBObject(DEFAULT_DB, true);

                if ($domain_id) {
                    $dbObj = db_getDBObjectByDomainID($domain_id, $dbMain);
                } elseif (defined("SELECTED_DOMAIN_ID")) {
                    $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
                } else {
                    $dbObj = db_getDBObject();
                }

                unset($dbMain);

                $sql = "SELECT count, title, full_friendly_url, location_id FROM ".ucfirst($module)."_LocationCounter WHERE location_level = ".$locationLevel." AND title != '' ORDER BY ".$orderField." LIMIT ".$limit;
                $result = $dbObj->query($sql);
                if (mysql_num_rows($result)) {
                    $aux_arrayLocationCounter = array();
                    $i = 0;
                    while ($row = mysql_fetch_assoc($result)) {
                        $aux_arrayLocationCounter[$i]["title"] = $row["title"];
                        $aux_arrayLocationCounter[$i]["total"] = $row["count"];
                        $aux_arrayLocationCounter[$i]["id"] = $row["location_id"];
                        $aux_arrayLocationCounter[$i]["url"] = $row["full_friendly_url"];
                        $i++;
                    }
                    return $aux_arrayLocationCounter;
                } else {
                    return false;
                }
            }
            
        }

        public static function getLocationIDByLocationLevel($location_level) {
            $dbMain = db_getDBObject(DEFAULT_DB, true);

			if ($domain_id) {
                $dbObj = db_getDBObjectByDomainID($domain_id, $dbMain);
			} else	if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
			} else {
                $dbObj = db_getDBObject();
			}

			unset($dbMain);
            
            if (ACTUAL_MODULE_FOLDER == LISTING_FEATURE_FOLDER) {
                $module = "Listing";
            } elseif(ACTUAL_MODULE_FOLDER == CLASSIFIED_FEATURE_FOLDER) {
                $module = "Classified";
            } elseif(ACTUAL_MODULE_FOLDER == EVENT_FEATURE_FOLDER) {
                $module = "Event";
            } elseif(ACTUAL_MODULE_FOLDER == PROMOTION_FEATURE_FOLDER) {
                $module = "Listing";
            } else {
                $module = false;
            }
            
            if ($module) {
                $sql = "SELECT location_id FROM ".$module."_LocationCounter WHERE location_level = ".$location_level;
                $result = $dbObj->query($sql);
                if (mysql_num_rows($result)) {
                    unset($array_location_ids);
                    while ($row = mysql_fetch_assoc($result)) {
                        $array_location_ids[] = $row["location_id"];
                    }
                    return $array_location_ids;
                } else {
                    return false;
                }
            } else {
                return false;
            }
            
        }
		
	}