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
	# * FILE: /classes/class_AppAdvert.php
	# ----------------------------------------------------------------------------------------------------

	/**
	 * <code>
	 *		$appAdvert = new AppAdvert($id);
	 * <code>
	 * @copyright Copyright 2005 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.
	 * @version 9.8.01
	 * @package Classes
	 * @name AppAdvert
	 * @method AppAdvert
	 * @method makeFromRow
	 * @method Save
	 * @method Delete
	 * @method getAdverts
	 * @access Public
	 */

	class AppAdvert extends Handle {

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
		 * @var integer
		 * @access Private
		 */
		var $image_id;
        /**
		 * @var string
		 * @access Private
		 */
		var $url;
        /**
		 * @var string
		 * @access Private
		 */
		var $device;
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
		 *		$appAdvert = new AppAdvert($id);
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.8.01
		 * @name AppAdvert
		 * @access Public
		 * @param integer $var
		 */
		function AppAdvert($var = "", $domain_id = false) {
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
				$sql = "SELECT * FROM AppAdvert WHERE id = $var";
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
            $this->image_id         = ($row["image_id"])            ? $row["image_id"]          : ($this->image_id              ? $this->image_id           : 0);
            $this->url              = ($row["url"])                 ? $row["url"]               : ($this->url                   ? $this->url                : "");
            $this->device           = ($row["device"])              ? $row["device"]            : ($this->device                ? $this->device             : "");
            $this->expiration_date	= ($row["expiration_date"])		? $row["expiration_date"]	: ($this->expiration_date		? $this->expiration_date    : "");
            $this->status			= ($row["status"])				? $row["status"]			: $status->getDefaultStatus();
            $this->entered			= ($row["entered"])				? $row["entered"]			: ($this->entered				? $this->entered            : "");
			
		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$appAdvert->Save();
		 * <br /><br />
		 *		//Using this in AppAdvert() class.
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

				$sql = "UPDATE AppAdvert SET"
                    . " title               = $this->title,"
					. " image_id            = $this->image_id,"
					. " url                 = $this->url,"
					. " device              = $this->device,"
					. " expiration_date     = $this->expiration_date,"
					. " status              = $this->status"
					. " WHERE id            = $this->id";

				$dbObj->query($sql);

			} else {
                                
				$sql = "INSERT INTO AppAdvert"
                    . " (title,"
					. " image_id,"
					. " url,"
					. " device,"
					. " expiration_date,"
					. " status,"
					. " entered)"
					. " VALUES"
                    . " ($this->title,"
					. " $this->image_id,"
					. " $this->url,"
					. " $this->device,"
					. " $this->expiration_date,"
					. " $this->status,"
					. " NOW())";

				$dbObj->query($sql);

				$this->id = mysql_insert_id($dbObj->link_id);

			}

			$this->prepareToUse();

		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$appAdvert->Delete();
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
            
            ### IMAGE
			if ($this->image_id) {
				$image = new Image($this->image_id);
				if ($image) $image->Delete($domain_id);
			}
            
			### Advert
			$sql = "DELETE FROM AppAdvert WHERE id = $this->id";
			$dbObj->query($sql);

		}
        
        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$appAdvert->getAdverts();
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.8.01
		 * @name getAdverts
		 * @access Public
		 * @param string $device
		 * @param integer $max
		 */
        function getAdverts($device = "", $max = "") {
            
            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }
            unset($dbMain);
            
            $sql = "SELECT * FROM AppAdvert WHERE status = 'A' AND expiration_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND device like ('%$device%') ORDER BY RAND() LIMIT $max";
            $result = $dbObj->query($sql);
            
            $adverts = array();
            
            if (mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    $adverts[] = $row;
                }
                return $adverts;
            } else {
                return false;
            }
            
        }
	}
?>