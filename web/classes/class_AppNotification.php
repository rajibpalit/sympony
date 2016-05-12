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
	# * FILE: /classes/class_AppNotification.php
	# ----------------------------------------------------------------------------------------------------

	/**
	 * <code>
	 *		$appNotif = new AppNotification($id);
	 * <code>
	 * @copyright Copyright 2005 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.
	 * @version 9.8.01
	 * @package Classes
	 * @name AppNotification
	 * @method AppNotification
	 * @method makeFromRow
	 * @method Save
	 * @method Delete
	 * @method updateNotifications
	 * @method getCurrent
	 * @access Public
	 */

	class AppNotification extends Handle {

		/**
		 * @var integer
		 * @access Private
		 */
		var $id;
        /**
		 * @var string
		 * @access Private
		 */
		var $title;
        /**
		 * @var string
		 * @access Private
		 */
		var $description;
        /**
		 * @var date
		 * @access Private
		 */
		var $expiration_date;
        /**
		 * @var char
		 * @access Private
		 */
		var $status;
        /**
		 * @var date
		 * @access Private
		 */
		var $entered;

		/**
		 * <code>
		 *		$appNotif = new AppNotification($id);
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.8.01
		 * @name AppNotification
		 * @access Public
		 * @param integer $var
		 */
		function AppNotification($var = "", $domain_id = false) {
			if (is_numeric($var) && ($var)) {
				$dbMain = db_getDBObject(DEFAULT_DB, true);
				if ($domain_id) {
					$this->domain_id = $domain_id;
					$db = db_getDBObjectByDomainID($domain_id, $dbMain);
				} elseif (defined("SELECTED_DOMAIN_ID")) {
					$db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
				} else {
					$db = db_getDBObject();
				}
				unset($dbMain);
				$sql = "SELECT * FROM AppNotification WHERE id = $var";
				$row = mysql_fetch_assoc($db->query($sql));

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
		 * @version 9.8.01
		 * @name makeFromRow
		 * @access Public
		 * @param array $row
		 */
		function makeFromRow($row="") {

			$status = new ItemStatus();

			$this->id				= ($row["id"])					? $row["id"]				: ($this->id					? $this->id                 : 0);
            $this->title            = ($row["title"])               ? $row["title"]             : ($this->title					? $this->title              : "");
            $this->description      = ($row["description"])         ? $row["description"]       : ($this->description			? $this->description        : "");
            $this->expiration_date	= ($row["expiration_date"])		? $row["expiration_date"]	: ($this->expiration_date		? $this->expiration_date    : "");
            $this->status			= ($row["status"])				? $row["status"]			: $status->getDefaultStatus();
            $this->entered			= ($row["entered"])				? $row["entered"]			: ($this->entered				? $this->entered            : "");
			
		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$appNotif->Save();
		 * <br /><br />
		 *		//Using this in AppNotification() class.
		 *		$this->Save();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.8.01
		 * @name Save
		 * @access Public
		 */
		function Save() {

			$dbMain = db_getDBObject(DEFAULT_DB, true);

			if ($this->domain_id) {
				$dbObj = db_getDBObjectByDomainID($this->domain_id, $dbMain);
				$aux_log_domain_id = $this->domain_id;
			} elseif (defined("SELECTED_DOMAIN_ID")) {
				$dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
				$aux_log_domain_id = SELECTED_DOMAIN_ID;
			} else {
				$dbObj = db_getDBObject();
			}
			unset($dbMain);

			$this->prepareToSave();

			if ($this->id) {

				$sql = "UPDATE AppNotification SET"
					. " title               = $this->title,"
					. " description         = $this->description,"
					. " expiration_date     = $this->expiration_date,"
					. " status              = $this->status"
					. " WHERE id            = $this->id";

				$dbObj->query($sql);

			} else {
                                
				$sql = "INSERT INTO AppNotification"
					. " (title,"
					. " description,"
					. " expiration_date,"
					. " status,"
					. " entered)"
					. " VALUES"
					. " ($this->title,"
					. " $this->description,"
					. " $this->expiration_date,"
					. " $this->status,"
					. " NOW())";

				$dbObj->query($sql);

				$this->id = mysql_insert_id($dbObj->link_id);

			}
            
            if ($this->status == "'A'") {
                $this->updateNotifications();
            }
            
			$this->prepareToUse();

		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$appNotif->Delete();
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.8.01
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
            
			### NOTIFICATION
			$sql = "DELETE FROM AppNotification WHERE id = $this->id";
			$dbObj->query($sql);

		}
        
        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$appNotif->updateNotifications();
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.8.01
		 * @name updateNotifications
		 * @access Public
		 */
		function updateNotifications() {
            
            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }
            unset($dbMain);
            
            $sql = "UPDATE AppNotification SET status = 'S' WHERE id != $this->id";
			$dbObj->query($sql);
            
        }
        
        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$appNotif->getCurrent();
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.8.01
		 * @name getCurrent
		 * @access Public
		 */
		function getCurrent() {
            
            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }
            unset($dbMain);
            
            $sql = "SELECT * FROM AppNotification WHERE status = 'A' AND expiration_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') LIMIT 1";
			$result = $dbObj->query($sql);
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_assoc($result);
                return $row;
            } else {
                return false;
            }
            
        }
	}
?>