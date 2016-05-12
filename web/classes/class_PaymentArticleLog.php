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
	# * FILE: /classes/class_PaymentArticleLog.php
	# ----------------------------------------------------------------------------------------------------

	/**
	 * <code>
	 *		$paymentArticleLogObj = new PaymentArticleLog($id);
	 * <code>
	 * @copyright Copyright 2005 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.
	 * @version 8.0.00
	 * @package Classes
	 * @name PaymentArticleLog
	 * @method PaymentArticleLog
	 * @method makeFromRow
	 * @method Save
	 * @access Public
	 */
	class PaymentArticleLog extends Handle {

		/**
		 * @var integer
		 * @access Private
		 */
		var $payment_log_id;
		/**
		 * @var integer
		 * @access Private
		 */
		var $article_id;
		/**
		 * @var string
		 * @access Private
		 */
		var $article_title;
		/**
		 * @var integer
		 * @access Private
		 */
		var $discount_id;
		/**
		 * @var integer
		 * @access Private
		 */
        var $level;
		/**
		 * @var string
		 * @access Private
		 */
		var $level_label;
		/**
		 * @var date
		 * @access Private
		 */
		var $renewal_date;
		/**
		 * @var real
		 * @access Private
		 */
		var $amount;
		/**
		 * @var integer
		 * @access Private
		 */
		var $domain_id;

		/**
		 * <code>
		 *		$paymentArticleLogObj = new PaymentArticleLog($id);
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 8.0.00
		 * @name PaymentArticleLog
		 * @access Public
		 * @param integer $var
		 */
		function PaymentArticleLog($var="", $domain_id = false) {
			$this->domain_id = $domain_id;
			if (is_numeric($var) && ($var)) {
				$dbMain = db_getDBObject(DEFAULT_DB, true);
				if (defined("SELECTED_DOMAIN_ID")) {
					$db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
				} else {
					$db = db_getDBObject();
				}
				unset($dbMain);
				$sql = "SELECT * FROM Payment_Article_Log WHERE payment_log_id = $var";
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
		 * @version 8.0.00
		 * @name makeFromRow
		 * @access Public
		 * @param array $row
		 */
		function makeFromRow($row="") {

			$this->payment_log_id	= ($row["payment_log_id"])	? $row["payment_log_id"]	: ($this->payment_log_id	? $this->payment_log_id	: 0);
			$this->article_id		= ($row["article_id"])		? $row["article_id"]		: ($this->article_id		? $this->article_id		: 0);
			$this->article_title	= ($row["article_title"])	? $row["article_title"]		: ($this->article_title		? $this->article_title	: "");
			$this->discount_id		= ($row["discount_id"])		? $row["discount_id"]		: ($this->discount_id		? $this->discount_id	: "");
            $this->level            = ($row["level"])           ? $row["level"]             : ($this->level             ? $this->level          : 0);
			$this->level_label	    = ($row["level_label"])		? $row["level_label"]	    : ($this->level_label		? $this->level_label	: "");
			$this->renewal_date		= ($row["renewal_date"])	? $row["renewal_date"]		: ($this->renewal_date		? $this->renewal_date	: 0);
			$this->amount			= ($row["amount"])			? $row["amount"]			: ($this->amount			? $this->amount			: 0);

		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$paymentArticleLogObj->Save();
		 * <br /><br />
		 *		//Using this in PaymentArticleLog() class.
		 *		$this->Save();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 8.0.00
		 * @name Save
		 * @access Public
		 */
		function Save() {

			$dbMain = db_getDBObject(DEFAULT_DB, true);
			if ($this->domain_id){
				$dbObj = db_getDBObjectByDomainID($this->domain_id, $dbMain);
			} else if (defined("SELECTED_DOMAIN_ID")) {
				$dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
			} else {
				$dbObj = db_getDBObject();
			}
//			$dbMain->close();
			unset($dbMain);

			$this->PrepareToSave();

			$sql = "INSERT INTO Payment_Article_Log"
				. " (payment_log_id,"
				. " article_id,"
				. " article_title,"
				. " discount_id,"
                . " level,"
				. " level_label,"
				. " renewal_date,"
				. " amount"
				. " )"
				. " VALUES"
				. " ("
				. " $this->payment_log_id,"
				. " $this->article_id,"
				. " $this->article_title,"
				. " $this->discount_id,"
                . " $this->level,"
				. " $this->level_label,"
				. " $this->renewal_date,"
				. " $this->amount"
				. " )";

			$dbObj->query($sql);

			$this->id = mysql_insert_id($dbObj->link_id);

			$this->PrepareToUse();

		}

	}

?>
