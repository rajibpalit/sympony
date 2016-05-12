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
	# * FILE: /classes/class_CheckIn.php
	# ----------------------------------------------------------------------------------------------------

	class CheckIn extends Handle {

		var $id;
		var $item_id;
		var $item_type;
		var $member_id;
		var $added;
		var $ip;
		var $quick_tip;
		var $checkin_name;

		function CheckIn($var="") {
			if (is_numeric($var) && ($var)) {
				$dbMain = db_getDBObject(DEFAULT_DB, true);
				if (defined("SELECTED_DOMAIN_ID")) {
					$db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
				} else {
					$db = db_getDBObject();
				}
				unset($dbMain);
				$sql = "SELECT * FROM CheckIn WHERE id = $var";
				$row = mysql_fetch_array($db->query($sql));
				$this->makeFromRow($row);
			} else {
                if (!is_array($var)) {
                    $var = array();
                }
				$this->makeFromRow($var);
			}
		}

		function makeFromRow($row="") {

			$this->id                    = ($row["id"])                     ? $row["id"]                    : ($this->id                    ? $this->id                     : 0);
			$this->item_id               = ($row["item_id"])                ? $row["item_id"]               : ($this->item_id               ? $this->item_id                : 0);
			$this->item_type             = ($row["item_type"])              ? $row["item_type"]             : ($this->item_type             ? $this->item_type              : "listing");
			$this->member_id             = ($row["member_id"])              ? $row["member_id"]             : ($this->member_id             ? $this->member_id              : 0);
			$this->added                 = ($row["added"])                  ? $row["added"]                 : ($this->added                 ? $this->added                  : "");
			$this->ip                    = ($row["ip"])                     ? $row["ip"]                    : ($this->ip                    ? $this->ip                     : "");
			$this->quick_tip             = ($row["quick_tip"])              ? $row["quick_tip"]             : "";
			$this->checkin_name          = ($row["checkin_name"])           ? $row["checkin_name"]          : "";


		}

		function Save() {

			$dbMain = db_getDBObject(DEFAULT_DB, true);
			if (defined("SELECTED_DOMAIN_ID")) {
				$dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
			} else {
				$dbObj = db_getDBObject();
			}
			unset($dbMain);

			$this->prepareToSave();

			if ($this->id) {

				$sql = "UPDATE CheckIn SET"
					. " item_id           = $this->item_id,"
					. " item_type         = $this->item_type,"
					. " member_id         = $this->member_id,"
					. " added             = $this->added,"
					. " ip                = $this->ip,"
					. " quick_tip         = $this->quick_tip, "
					. " checkin_name      = $this->checkin_name "
					. " WHERE id          = $this->id";

					$dbObj->query($sql);

			} else {

				$sql = "INSERT INTO CheckIn"
					. " (item_id,"
					. " item_type,"
					. " member_id,"
					. " added,"
					. " ip,"
					. " quick_tip,"
					. " checkin_name"
					. " )"
					. " VALUES"
					. " ("
					. " $this->item_id,"
					. " $this->item_type,"
					. " $this->member_id,"
					. " NOW(),"
					. " $this->ip,"
					. " $this->quick_tip,"
					. " $this->checkin_name"
					. " )";

				$dbObj->query($sql);

				$this->id = mysql_insert_id($dbObj->link_id);

			}

			$this->prepareToUse();

		}

		function Delete($domain_id = false) {
			$dbMain = db_getDBObject(DEFAULT_DB, true);
			if ($domain_id) {
				$dbObj = db_getDBObjectByDomainID($domain_id, $dbMain);
			} else {
				if (defined("SELECTED_DOMAIN_ID")) {
					$dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
				} else {
					$dbObj = db_getDBObject();
				}
				unset($dbMain);
			}
			$sql = "DELETE FROM CheckIn WHERE id = $this->id";
			$dbObj->query($sql);

		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$checkinObj->deletePerAccount($account_id);
		 * <br /><br />
		 *		//Using this in Checkin() class.
		 *		$this->deletePerAccount($account_id);
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 8.0.00
		 * @name deletePerAccount
		 * @access Public
		 * @param integer $account_id
		 * @param integer $domain_id
		 */
		function deletePerAccount($account_id = 0, $domain_id = false) {
			if (is_numeric($account_id) && $account_id > 0) {
				$dbMain = db_getDBObject(DEFAULT_DB, true);
				if ($domain_id) {
					$dbObj = db_getDBObjectByDomainID($domain_id, $dbMain);
				} else {
					if (defined("SELECTED_DOMAIN_ID")) {
						$dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
					} else {
						$dbObj = db_getDBObject();
					}
					unset($dbMain);
				}
				$sql = "SELECT * FROM CheckIn WHERE member_id = $account_id";
				$result = $dbObj->query($sql);
				while ($row = mysql_fetch_array($result)) {
					$this->makeFromRow($row);
					$this->Delete($domain_id);
				}
			}
		}

		function GetTotalCheckinsByItemID(){
            $db = db_getDBObject();
            $sql = "SELECT item_id FROM CheckIn WHERE item_id = ".db_formatNumber($this->item_id)." AND item_type = ".db_formatString($this->item_type);
            
            $result = $db->query($sql);
            $total_result = mysql_num_rows($result);
            if ($total_result) {
                return $total_result;
            } else {
                return NULL;
            }
        }
        
        /**
         * Function to get all checkins from a item
         * @return array
         */
        function getCheckinByItemID(){
            
            $db = db_getDBObject();
            $dbMain = db_getDBObject(DEFAULT_DB, true);
            $sql = "SELECT * FROM CheckIn WHERE item_id = ".db_formatNumber($this->item_id)." AND item_type = ".db_formatString($this->item_type)." ORDER BY added DESC";
            $result = $db->query($sql);
            
            if (mysql_num_rows($result)) {
                
                unset($aux_array_checkins);
                $aux_array_checkins = array();
                while ($row = mysql_fetch_assoc($result)) {
                    unset($aux_fields);
                    foreach ($row as $key => $value) {
                        $aux_fields[$key] = (is_numeric($value) ? (float)$value : $value);
                    }
                    //Get user image
                    if (SOCIALNETWORK_FEATURE == "on") {
                        
                        if ($row["member_id"] > 0) {

                            $sql = "SELECT image_id, facebook_image, A.has_profile
                                    FROM Profile
                                    LEFT JOIN Account A ON (A.id = account_id)
                                    WHERE account_id = ".db_formatNumber($row["member_id"])."";
                            $resultImage = $dbMain->query($sql);
                            $rowImage = mysql_fetch_assoc($resultImage);
                            
                            if ($rowImage["has_profile"] == "y") {
                                $imgObj = new Image($rowImage["image_id"], true);
                                if ($imgObj->imageExists()) {
                                    $aux_fields["member_img"] = $imgObj->getPath();
                                //No image
                                } else {
                                    if ($rowImage["facebook_image"]) {
                                        $aux_fields["member_img"] = $rowImage["facebook_image"];
                                    } else {
                                        $aux_fields["member_img"] = DEFAULT_URL."/assets/images/structure/icon-user-thumb.gif";
                                    }
                                }
                            //No image
                            } else {
                                $aux_fields["member_img"] = DEFAULT_URL."/assets/images/structure/icon-user-thumb.gif";
                            }

                        //No image
                        } else {
                            $aux_fields["member_img"] = DEFAULT_URL."/assets/images/structure/icon-user-thumb.gif";
                        }
                    } else {
                        $aux_fields["member_img"] = "";
                    }
                    $aux_array_checkins[] = $aux_fields;
                }
                
                if (is_array($aux_array_checkins)) {
                    return $aux_array_checkins;
                } else {
                    return false;
                }
                
            } else {
                return false;
            }
        }
        
        function GetInfoToApp($array_get, &$aux_returnArray,&$items){
        
        	extract($array_get);
        
        	$items = $this->getCheckinByItemID();
                
            if (is_array($items)) {
                    
                $aux_returnArray["type"]            = $resource;
                $aux_returnArray["total_results"]   = count($items); 
                $aux_returnArray["total_pages"]     = ceil(count($items) / $aux_results_per_page); 
                $aux_returnArray["results_per_page"]= $aux_results_per_page; 
                    
            } else {
                    
                $aux_returnArray["type"]            = $resource;
                $aux_returnArray["total_results"]   = 0; 
                $aux_returnArray["total_pages"]     = 0; 
                $aux_returnArray["results_per_page"]= $aux_results_per_page; 
                                    
            }
        }
	}

?>