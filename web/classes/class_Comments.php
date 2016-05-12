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
	# * FILE: /classes/class_Comments.php
	# ----------------------------------------------------------------------------------------------------

	/**
	 * <code>
	 *		$commentObj = new Comments($id);
	 * <code>
	 * @copyright Copyright 2005 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.
	 * @version 9.5.00
	 * @package Classes
	 * @name Comments
	 * @method Comments
	 * @method makeFromRow
	 * @method Save
	 * @method Delete
	 * @method deletePerAccount
	 * @method getTimeString
	 * @method SaveWPToEdir
	 * @method deleteWPComment
	 * @method TrashedWPComment
	 * @method UntrashedWPComment
	 * @access Public
	 */
	class Comments extends Handle {

		/**
		 * @var integer
		 * @access Private
		 */
		var $id;
		/**
		 * @var integer
		 * @access Private
		 */
		var $post_id;
		/**
		 * @var integer
		 * @access Private
		 */
		var $reply_id;
		/**
		 * @var integer
		 * @access Private
		 */
		var $member_id;
		/**
		 * @var string
		 * @access Private
		 */
		var $member_name;
		/**
		 * @var date
		 * @access Private
		 */
		var $added;
		/**
		 * @var varchar
		 * @access Private
		 */
		var $description;
		/**
		 * @var integer
		 * @access Private
		 */
		var $approved;
		/**
		 * @var integer
		 * @access Private
		 */
		var $legacy_id;

		/**
		 * <code>
		 *		$commentsObj = new Comments($id);
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name Comments
		 * @access Public
		 * @param mixed $var
		 */
		function Comments($var="") {
			if (is_numeric($var) && ($var)) {
				$dbMain = db_getDBObject(DEFAULT_DB, true);
				if (defined("SELECTED_DOMAIN_ID")) {
					$db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
				} else {
					$db = db_getDBObject();
				}
				unset($dbMain);
				$sql = "SELECT * FROM Comments WHERE id = $var";
				$row = mysql_fetch_array($db->query($sql));
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
		 * @version 9.5.00
		 * @name makeFromRow
		 * @access Public
		 * @param array $row
		 */
		function makeFromRow($row="") {

			$this->id                    = ($row["id"])                     ? $row["id"]                    : ($this->id                    ? $this->id                     : 0);
			$this->post_id               = ($row["post_id"])                ? $row["post_id"]               : ($this->post_id               ? $this->post_id                : 0);
			$this->reply_id			     = ($row["reply_id"])               ? $row["reply_id"]              : ($this->reply_id              ? $this->reply_id               : 0);
			$this->member_id			 = ($row["member_id"])              ? $row["member_id"]             : ($this->member_id             ? $this->member_id              : 0);
			$this->member_name			 = ($row["member_name"])            ? $row["member_name"]           : ($this->member_name           ? $this->member_name            : "");
			$this->added                 = ($row["added"])                  ? $row["added"]                 : ($this->added                 ? $this->added                  : "");
			$this->description           = ($row["description"])            ? $row["description"]           : "";
			$this->approved              = ($row["approved"])               ? $row["approved"]              : 0;
			$this->legacy_id             = ($row["legacy_id"])              ? $row["legacy_id"]             : 0;
			
		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->Save();
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->Save();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name Save
		 * @access Public
		 */
		function Save() {
			
			$empty_legacy_id = false;
			
			if (!$this->legacy_id){
				$empty_legacy_id = true;
			}
			
			$this->prepareToSave();

			$dbMain = db_getDBObject(DEFAULT_DB, true);
			if (defined("SELECTED_DOMAIN_ID")) {
				$dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
			} else {
				$dbObj = db_getDBObject();
			}
			
			unset($dbMain);

			if ($this->id) {

				$sql = "SELECT approved FROM Comments WHERE id = $this->id";
				$result = $dbObj->query($sql);
				if ($row = mysql_fetch_assoc($result)) $last_status = $row["approved"];
				$this_status = $this->approved;

				$sql = "UPDATE Comments SET"
					. " post_id     = $this->post_id,"
					. " reply_id    = $this->reply_id,"
					. " member_id   = $this->member_id,"
					. " member_name = $this->member_name,"
					. " added       = $this->added,"
					. " description = $this->description,"
					. " approved	= $this->approved,"
					. " legacy_id	= $this->legacy_id"
					. " WHERE id    = $this->id";

					$dbObj->query($sql);

					$post = new Post(str_replace("'","",$this->post_id));
					$item_title = $post->getString("title");

			} else {

				$sql = "INSERT INTO Comments"
					. " (post_id,"
					. " reply_id,"
					. " member_id,"
					. " member_name,"
					. " added,"
					. " description,"
					. " approved,"
					. " legacy_id)"
					. " VALUES"
					. " ("
					. " $this->post_id,"
					. " $this->reply_id,"
					. " $this->member_id,"
					. " $this->member_name,"
					. " NOW(),"
					. " $this->description,"
					. " $this->approved,"
					. " $this->legacy_id"
					. " )";

				$dbObj->query($sql);

				$this->id = mysql_insert_id($dbObj->link_id);
                
                $rowTimeline = array();
                $rowTimeline["item_type"] = ($this->reply_id ? "reply" : "comment");
                $rowTimeline["action"] = "new";
                $rowTimeline["item_id"] = $this->id;
                $timelineObj = new Timeline($rowTimeline);
                $timelineObj->save();
				
				/*
				 * Legacy ID to Wordpress
				 */
				if($empty_legacy_id){
					unset($sql_legacy_id);
					$sql_legacy_id = "UPDATE Comments SET legacy_id = 'ed_".$this->id."' WHERE id = ".$this->id;
					$dbObj->query($sql_legacy_id);
					
				}

				$post = new Post(str_replace("'","",$this->post_id));
				$item_title = $post->getString("title");

			}
			$this->prepareToUse();
		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->Delete($domain_id);
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->Delete();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name Delete
		 * @access Public
		 * @param integer $domain_id
		 */
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

			$sql = "DELETE FROM Comments WHERE reply_id = $this->id";
			$dbObj->query($sql);

			$sql = "DELETE FROM Comments WHERE id = $this->id";
			$dbObj->query($sql);
            
            ### Timeline
            if ($this->reply_id) {
                $sql = "DELETE FROM Timeline WHERE item_type = 'reply' AND item_id = $this->id";
            } else {
                $sql = "DELETE FROM Timeline WHERE item_type = 'comment' AND item_id = $this->id";
            }
            $dbObj->query($sql);

		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->deletePerAccount($account_id, $domain_id);
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->deletePerAccount($account_id);
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
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
				$sql = "SELECT * FROM Comments WHERE member_id = $account_id";
				$result = $dbObj->query($sql);
				while ($row = mysql_fetch_array($result)) {
					$this->makeFromRow($row);
					$this->Delete($domain_id);
				}
			}
		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->getTimeString($when);
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->getTimeString($when);
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name getTimeString
		 * @access Public
		 * @param varchar $when
		 * @return varchar $str_time
		 */
		function getTimeString($when = "added") {
			$str_time = "";
			$startTimeStr = explode(":", $this->getString($when));
			$startTimeStr[0] = string_substr($startTimeStr[0],-2);
			if (CLOCK_TYPE == '24') {
				$start_time_hour = $startTimeStr[0];
			} elseif (CLOCK_TYPE == '12') {
				if ($startTimeStr[0] > "12") {
					$start_time_hour = $startTimeStr[0] - 12;
					$start_time_am_pm = "pm";
				} elseif ($startTimeStr[0] == "12") {
					$start_time_hour = 12;
					$start_time_am_pm = "pm";
				} elseif ($startTimeStr[0] == "00") {
					$start_time_hour = 12;
					$start_time_am_pm = "am";
				} else {
					$start_time_hour = $startTimeStr[0];
					$start_time_am_pm = "am";
				}
			}
			if ($start_time_hour < 10) $start_time_hour = "0".($start_time_hour+0);
			$start_time_min = $startTimeStr[1];
			$str_time .= $start_time_hour.":".$start_time_min." ".$start_time_am_pm;

			return $str_time;
		}
		
		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->SaveWPToEdir($wp_content);
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->SaveWPToEdir($wp_content);
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name SaveWPToEdir
		 * @access Public
		 * @param misc $wp_content
		 */
		function SaveWPToEdir($wp_content){

			if(!is_array($wp_content)){
				$wp_content = unserialize($wp_content);
			}
			
			
			if(is_array($wp_content)){
							
				/*
				 * Get Comment ID using legacy ID
				 */
				$db = db_getDBObject();
				$sql = "SELECT * FROM Comments WHERE legacy_id = '"."wp_".$wp_content["fields"]["comment_ID"]."'";
				$result = $db->query($sql);
				if(mysql_num_rows($result)){
					$row = mysql_fetch_assoc($result);
					$this->makeFromRow($row);
				}
				
				/*
				 * Get Post ID using comment_post_ID
				 */
				$db = db_getDBObject();
				$sql = "SELECT id FROM Post WHERE legacy_id = '"."wp_".$wp_content["fields"]["comment_post_ID"]."'";
				$result = $db->query($sql);
				if(mysql_num_rows($result)){
					$rowPost = mysql_fetch_assoc($result);
				}
				
				/*
				 * Get Comment ID using comment_parent
				 */
				$db = db_getDBObject();
				
				
				$sql = "SELECT id, reply_id FROM Comments WHERE legacy_id = '"."wp_".$wp_content["fields"]["comment_parent"]."'";
				$result = $db->query($sql);
				if(mysql_num_rows($result)){
					$rowComment = mysql_fetch_assoc($result);
				}
				
				$current_id = $rowComment["id"] ? $rowComment["id"] : 0;
				$reply_id = $rowComment["reply_id"] ? $rowComment["reply_id"] : 0;
				
				if ($reply_id != 0){
					
					while ($reply_id != 0){
						$sql = "SELECT id, reply_id FROM Comments WHERE id = ".db_formatNumber($reply_id);
						$result = $db->query($sql);
						if(mysql_num_rows($result)){
							$rowCommentAux = mysql_fetch_assoc($result);
							$reply_id = $rowCommentAux["reply_id"];
							$current_id = $rowCommentAux["id"];
						} else {
							$reply_id = 0;
						}
					}
				}

				$fields[0]["name"]		= "legacy_id";
				$fields[0]["content"]	= "wp_".$wp_content["fields"]["comment_ID"];
				
				$fields[1]["name"]		= "member_id";
				$fields[1]["content"]	= 0;
				
				$fields[2]["name"]		= "description";
				$fields[2]["content"]	= $wp_content["fields"]["comment_content"];
				
				$fields[3]["name"]		= "added";
				$fields[3]["content"]	= $wp_content["fields"]["comment_date"];
					
				$fields[4]["name"]		= "member_name";
				$fields[4]["content"]	= $wp_content["fields"]["comment_author"] ;
				
				$fields[5]["name"]		= "approved";
				$fields[5]["content"]	= (!is_numeric($wp_content["fields"]["comment_approved"]) ? 0 : $wp_content["fields"]["comment_approved"]);

				$fields[6]["name"]		= "post_id";
				$fields[6]["content"]	= $rowPost["id"];
				
				$fields[7]["name"]		= "reply_id";
				$fields[7]["content"]	= $current_id;
				
				for($i=0;$i<count($fields);$i++){
					$this->$fields[$i]["name"] = $fields[$i]["content"];
				}
				
				$this->Save();
				
			}
		}
		
        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->deleteWPComment($wp_fields);
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->deleteWPComment($wp_fields);
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name deleteWPComment
		 * @access Public
		 * @param misc $wp_fields
		 */
		function deleteWPComment($wp_fields){
			
			if($wp_fields["fields"]["id"]){
				
				$dbObj = db_getDBObject();
				$sql = "SELECT id FROM Comments WHERE legacy_id = 'wp_".$wp_fields["fields"]["id"]."'";
				$result = $dbObj->query($sql);
				
				if(mysql_num_rows($result)){
					while($row = mysql_fetch_assoc($result)){
						$this->id = $row["id"];
						$this->Delete();
					}
				}
			}
		}
        
		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->TrashedWPComment($wp_fields);
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->TrashedWPComment($wp_fields);
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name TrashedWPComment
		 * @access Public
		 * @param misc $wp_fields
		 */
		function TrashedWPComment($wp_fields){
			
			if($wp_fields["fields"]["id"]){
				
				$dbObj = db_getDBObject();
				$sql = "UPDATE Comments SET approved = 0 WHERE legacy_id = 'wp_".$wp_fields["fields"]["id"]."'";
				$result = $dbObj->query($sql);
				
			}
		}
		
        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$commentsObj->UntrashedWPComment($wp_fields);
		 * <br /><br />
		 *		//Using this in Comments() class.
		 *		$this->UntrashedWPComment($wp_fields);
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.5.00
		 * @name UntrashedWPComment
		 * @access Public
		 * @param misc $wp_fields
		 */
		function UntrashedWPComment($wp_fields){
			
			if($wp_fields["fields"]["id"]){
				
				$dbObj = db_getDBObject();
				$sql = "UPDATE Comments SET approved = 1 WHERE legacy_id = 'wp_".$wp_fields["fields"]["id"]."'";
				$result = $dbObj->query($sql);
				
			}
		}
        
        /**
         * Function to get all comments from an item
         * @return array
         */
        function getCommentsByItemID($post_id = 0) {
            
            $db = db_getDBObject();
            $dbMain = db_getDBObject(DEFAULT_DB, true);
            $sql = "SELECT * FROM Comments WHERE post_id = ".db_formatNumber($this->item_id)." AND description IS NOT NULL AND approved = 1 AND reply_id = ".db_formatNumber($post_id)." ORDER BY added DESC";
            $result = $db->query($sql);
            
            if (mysql_num_rows($result)) {
                
                unset($aux_array_comments);
                $aux_array_comments = array();
                while ($row = mysql_fetch_assoc($result)) {
                    unset($aux_fields);
                    foreach ($row as $key => $value) {
                        if ($key != "approved" && $key != "legacy_id" && $key != "member_name" && $key != "reply_id" && $key != "member_img") {
                            if ($key == "member_id") {
                                $auxContact = new Contact($value);
                                $auxMember = array();
                                $auxMember["id"] = (int)$value;
                                $auxMember["first_name"] = $auxContact->getString("first_name");
                                $auxMember["last_name"] = $auxContact->getString("last_name");
                                $auxMember["email"] = $auxContact->getString("email");
                                $auxMember["member_img"] = api_getUserImage($value);
                                $aux_fields["account"] = $auxMember;
                            } else {
                                $aux_fields[$key] = (is_numeric($value) ? (float)$value : $value);
                            }
                        }
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
                    
                    $replies = $this->getCommentsByItemID($aux_fields["id"]);
                    if (is_array($replies)) {
                        $aux_fields["replies"] = $replies;
                    } else {
                        $aux_fields["replies"] = NULL;
                    }
                    
                    $aux_array_comments[] = $aux_fields;
                }
                
                if (is_array($aux_array_comments)) {
                    return $aux_array_comments;
                } else {
                    return false;
                }
                
            } else {
                return false;
            }
        }
        
        function GetInfoToApp($array_get, &$aux_returnArray, &$items) {
        
        	extract($array_get);
        
        	$items = $this->getCommentsByItemID();
                
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
            
             $aux_returnArray["success"] = TRUE;
        }
        
        function GetTotalCommentsByItemID() {
            $db = db_getDBObject();
            $sql = "SELECT post_id FROM Comments WHERE post_id = ".db_formatNumber($this->post_id)." AND approved = 1";
            
            $result = $db->query($sql);
            $total_result = mysql_num_rows($result);
            if ($total_result) {
                return $total_result;
            } else {
                return NULL;
            }
        }
	}
?>