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
	# * FILE: /classes/class_Navigation.php
	# ----------------------------------------------------------------------------------------------------

	/**
	 * <code>
	 *		$navigationObj = new Navigation($id);
	 * <code>
	 * @copyright Copyright 2005 Arca Solutions, Inc.
	 * @author Arca Solutions, Inc.
	 * @version 9.7.00
	 * @package Classes
	 * @name Navigation
	 * @method Navigation
	 * @method makeFromRow
	 * @method Save
	 * @method ClearNavigation
	 * @method WriteNavBar
	 * @method getNavbar
	 * @method ResetNavbar
	 * @access Public
	 */
	class Navigation extends Handle {

		/**
		 * @var integer
		 * @access Private
		 */
		var $order;
		/**
		 * @var varchar
		 * @access Private
		 */
		var $label;
		/**
		 * @var varchar
		 * @access Private
		 */
		var $link;
		/**
		 * @var varchar
		 * @access Private
		 */
		var $area;
		/**
		 * @var varchar
		 * @access Private
		 */
		var $custom;


		/**
		 * <code>
		 *		$navigationObj = new Navigation($id);
		 *		//OR
		 *		$navigationObj = new Navigation($row);
		 * <code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.7.00
		 * @name Navigation
		 * @access Public
		 * @param mixed $var
		 */
		function Navigation($var='', $domain_id = false) {

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
				$sql = "SELECT * FROM Navigation WHERE order = $var";

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
		 * @version 9.7.00
		 * @name makeFromRow
		 * @access Public
		 * @param array $row
		 */
		function makeFromRow($row='') {

			$this->order    = ($row["order"])       ? $row["order"]     : ($this->order     ? $this->order  : 0);
			$this->label    = ($row["label"])       ? $row["label"]     : ($this->label     ? $this->label  : "");
			$this->link     = ($row["link"])        ? $row["link"]      : ($this->link      ? $this->link   : "");
			$this->area     = ($row["area"])        ? $row["area"]      : ($this->area      ? $this->area   : "");
			$this->custom   = ($row["custom"])      ? $row["custom"]    : ($this->custom    ? $this->custom : "");

		}

		/**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$navigationObj->Save();
		 * <br /><br />
		 *		//Using this in Navigation() class.
		 *		$this->Save();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.7.00
		 * @name Save
		 * @access Public
		 */
		function Save() {

            $dbMain = db_getDBObject(DEFAULT_DB, true);

            if ($this->domain_id) {
                $dbObj = db_getDBObjectByDomainID($this->domain_id, $dbMain);
            } else	if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }

            unset($dbMain);

            $this->prepareToSave();

            $sql = "INSERT INTO Setting_Navigation (`order`, `label`, `link`, `area`, `custom`, `theme`) VALUES (".$this->order.", ".$this->label.", ".$this->link.", ".$this->area.", ".$this->custom.", '".EDIR_THEME."')";
            $dbObj->query($sql);

		}

        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$navigationObj->ClearNavigation();
		 * <br /><br />
		 *		//Using this in Navigation() class.
		 *		$this->ClearNavigation();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.7.00
		 * @name ClearNavigation
		 * @access Public
         * @param string $area
		 */
        function ClearNavigation($area) {

            $dbMain = db_getDBObject(DEFAULT_DB, true);

            if ($this->domain_id) {
                $dbObj = db_getDBObjectByDomainID($this->domain_id, $dbMain);
            } else	if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }

            unset($dbMain);
            $sql = "DELETE FROM Setting_Navigation WHERE `area` = '".$area."' AND theme = '".EDIR_THEME."'";
            $dbObj->query($sql);

        }

        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$navigationObj->WriteNavBar();
		 * <br /><br />
		 *		//Using this in Navigation() class.
		 *		$this->WriteNavBar();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.7.00
		 * @name WriteNavBar
		 * @access Public
         * @param string $area
		 */
        function WriteNavBar($area) {

            $dbMain = db_getDBObject(DEFAULT_DB, true);

            if ($this->domain_id) {
                $dbObj = db_getDBObjectByDomainID($this->domain_id, $dbMain);
            } else	if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }

            unset($dbMain, $navbar, $classActive, $itemLink, $validation, $closeValidation);

            $sql = "SELECT `link`, `label`, `custom` FROM Setting_Navigation WHERE area = '".$area."' AND theme = '".EDIR_THEME."' ORDER BY `order`";
            $result = $dbObj->query($sql);

            if (mysql_num_rows($result)) {
                while ($row = mysql_fetch_assoc($result)) {
                    if ($row["custom"] == "y") {

                        if ($area == "header") {
                            $classActive = "<?=((string_strpos(\$_SERVER[\"REQUEST_URI\"], \"".str_replace(NON_SECURE_URL.EDIRECTORY_FOLDER."/", "", $row["link"])."\") !== false) ? \"active\" : \"\")?>";
                        }

                        $itemLink = $row["link"];

                    } else {

                        //Home
                        if ($row["link"] == "NON_SECURE_URL") {
                            $itemLink = "<?=NON_SECURE_URL?>";
                        //Advertise
                        } elseif ($row["link"] == "ALIAS_ADVERTISE_URL_DIVISOR") {
                            $classActive = "<?=((string_strpos(\$_SERVER[\"PHP_SELF\"], \"advertise.php\") !== false) ? \"active\" : \"\")?>";
                            $itemLink = "<?=NON_SECURE_URL?>/<?=ALIAS_ADVERTISE_URL_DIVISOR?>/";
                        //Contact Us
                        } elseif ($row["link"] == "ALIAS_CONTACTUS_URL_DIVISOR") {
                            $itemLink = "<?=NON_SECURE_URL?>/<?=ALIAS_CONTACTUS_URL_DIVISOR?>/";
                        //Listing
                        } elseif ($row["link"] == "LISTING_DEFAULT_URL") {
                            $itemLink = "<?=LISTING_DEFAULT_URL?>/";
                        //Event
                        } elseif ($row["link"] == "EVENT_DEFAULT_URL") {
                            $itemLink = "<?=EVENT_DEFAULT_URL?>/";
                            $validation = "<? if (EVENT_FEATURE == \"on\" && CUSTOM_EVENT_FEATURE == \"on\") { ?>";
                        //Classified
                        } elseif ($row["link"] == "CLASSIFIED_DEFAULT_URL") {
                            $itemLink = "<?=CLASSIFIED_DEFAULT_URL?>/";
                            $validation = "<? if (CLASSIFIED_FEATURE == \"on\" && CUSTOM_CLASSIFIED_FEATURE == \"on\") { ?>";
                        //Article
                        } elseif ($row["link"] == "ARTICLE_DEFAULT_URL") {
                            $itemLink = "<?=ARTICLE_DEFAULT_URL?>/";
                            $validation = "<? if (ARTICLE_FEATURE == \"on\" && CUSTOM_ARTICLE_FEATURE == \"on\") { ?>";
                        //Deal
                        } elseif ($row["link"] == "PROMOTION_DEFAULT_URL") {
                            $itemLink = "<?=PROMOTION_DEFAULT_URL?>/";
                            $validation = "<? if (PROMOTION_FEATURE == \"on\" && CUSTOM_HAS_PROMOTION == \"on\" && CUSTOM_PROMOTION_FEATURE == \"on\") { ?>";
                        //Blog
                        } elseif ($row["link"] == "BLOG_DEFAULT_URL") {
                            $itemLink = "<?=BLOG_DEFAULT_URL?>/";
                            $validation = "<? if (BLOG_FEATURE == \"on\" && CUSTOM_BLOG_FEATURE == \"on\") { ?>";
                        //Enquire
                        } elseif ($row["link"] == "ALIAS_LEAD_URL_DIVISOR") {
                            $itemLink = "<?=NON_SECURE_URL?>/<?=ALIAS_LEAD_URL_DIVISOR?>/";
                        //Faq
                        } elseif ($row["link"] == "ALIAS_FAQ_URL_DIVISOR") {
                            $itemLink = "<?=NON_SECURE_URL?>/<?=ALIAS_FAQ_URL_DIVISOR?>/";
                        //Sitemap
                        } elseif ($row["link"] == "ALIAS_SITEMAP_URL_DIVISOR") {
                            $itemLink = "<?=NON_SECURE_URL?>/<?=ALIAS_SITEMAP_URL_DIVISOR?>/";
                        //Terms of Use
                        } elseif ($row["link"] == "ALIAS_TERMS_URL_DIVISOR") {
                            $itemLink = "<?=NON_SECURE_URL?>/<?=ALIAS_TERMS_URL_DIVISOR?>/";
                        //Privacy Policy
                        } elseif ($row["link"] == "ALIAS_PRIVACY_URL_DIVISOR") {
                            $itemLink = "<?=NON_SECURE_URL?>/<?=ALIAS_PRIVACY_URL_DIVISOR?>/";
                        }

                        if ($validation) {
                            $closeValidation = "<? } ?>";
                        }

                    }
                    $navbar .= $validation.PHP_EOL;
                    $navbar .= "<li class=\"dropdown {$classActive}\"><a href=\"".$itemLink."\">".string_htmlentities($row["label"])."</a></li>".PHP_EOL;
                    $navbar .= $closeValidation.PHP_EOL;

                    unset($classActive, $itemLink, $validation, $closeValidation);
                }
            }

            $navbar = "<ul class=\"".($area == "header" ? "nav navbar-nav navbar-right" : "list-unstyled")."\">$navbar</ul>";

            $filePath = HTMLEDITOR_FOLDER."/".EDIR_THEME."/".$area."_menu.php";

            if (!is_dir(HTMLEDITOR_FOLDER)) {
                //create folder custom/domain_x/editor
                mkdir(HTMLEDITOR_FOLDER);
            }
            if (!is_dir(HTMLEDITOR_FOLDER."/".EDIR_THEME)) {
                mkdir(HTMLEDITOR_FOLDER."/".EDIR_THEME);
            }

            $file = fopen($filePath, "w+");
            if ($file) {
                fwrite($file,$navbar);
            }
            fclose($file);
        }

        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$navigationObj->getNavbar();
		 * <br /><br />
		 *		//Using this in Navigation() class.
		 *		$this->getNavbar();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.7.00
		 * @name getNavbar
		 * @access Public
         * @param array $navBarOptions
         * @param string $area
		 */
        public static function getNavbar(&$navBarOptions, $area, $api = false, $app_api_version = "") {

            $dbMain = db_getDBObject(DEFAULT_DB, true);
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);

            unset($dbMain, $navbar);

            $sql = "SELECT ".($api ? "label, link" : "*")." FROM Setting_Navigation WHERE `area` = '".$area."' AND theme = '".EDIR_THEME."' ORDER BY `order`";
            $result = $dbObj->query($sql);

            if (mysql_num_rows($result)) {
                $i = 0;
                while($row = mysql_fetch_assoc($result)) {
                    $row["icon"] = null;

                    //Validate available modules
                    $addNode = false;
                    if ($area == "tabbar") {
                        if ($row["link"] == "events") {
                            if (EVENT_FEATURE == "on" && CUSTOM_EVENT_FEATURE == "on") {
                                $addNode = true;
                            }
                        } elseif ($row["link"] == "classifieds") {
                            if (CLASSIFIED_FEATURE == "on" && CUSTOM_CLASSIFIED_FEATURE == "on") {
                                $addNode = true;
                            }
                        } elseif ($row["link"] == "articles") {
                            if (ARTICLE_FEATURE == "on" && CUSTOM_ARTICLE_FEATURE == "on") {
                                $addNode = true;
                            }
                        } elseif ($row["link"] == "blog") {
                            if (BLOG_FEATURE == "on" && CUSTOM_BLOG_FEATURE == "on" && (($app_api_version && $api) || !$api)) {
                                $addNode = true;
                            }
                        } elseif ($row["link"] == "deals") {
                            if (PROMOTION_FEATURE == "on" && CUSTOM_PROMOTION_FEATURE == "on" && CUSTOM_HAS_PROMOTION == "on") {
                                $addNode = true;
                            }
                        } elseif ($row["link"] == "reviews") {
                            setting_get("review_listing_enabled", $review_enabled);

                            if ($review_enabled == "on") {
                                $addNode = true;
                            }
                        } else if( strpos ( $row["link"], "cp_" ) !== false ){

                            if( $addNode = empty( $app_api_version ) or  $addNode = ( (float)$app_api_version >= 1.2 ) )
                            {
                                $parts = explode( "_", $row["link"]);
                                $customPage = AppCustomPage::Load( $parts[1] );
                                $row["icon"] = $customPage->icon;
                                $row["id"]   = $customPage->id;
                                $row["link"] = "custompage";
                            }
                        }
                        else {
                            $addNode = true;
                        }
                    } else {
                        $addNode = true;
                    }

                    if ($addNode) {
                        foreach ($row as $key => $value) {
                            $navBarOptions[$i][$key] = $value;
                        }
                        $i++;
                    }
                }
            }
        }

        /**
		 * <code>
		 *		//Using this in forms or other pages.
		 *		$navigationObj->ResetNavbar();
		 * <br /><br />
		 *		//Using this in Navigation() class.
		 *		$this->ResetNavbar();
		 * </code>
		 * @copyright Copyright 2005 Arca Solutions, Inc.
		 * @author Arca Solutions, Inc.
		 * @version 9.7.00
		 * @name ResetNavbar
		 * @access Public
         * @param string $area
		 */
        function ResetNavbar($area, $appBuilder = false) {

            $this->ClearNavigation($area);

            /**
             * Array with Modules and URL
             */
            if ($appBuilder) {
                $auxArrayModules = unserialize(APPBUILDER_MENU);
            } else {
                $auxArrayModules = unserialize(THEME_NAVIGATION_MENU);
            }
            $array_modules = $auxArrayModules[$area];

            for ($i = 0; $i < count($array_modules); $i++) {

                $moduleOn = false;
                if ($array_modules[$i]["module"]) {
                    if ((constant($array_modules[$i]["module"]) == "on") && (constant("CUSTOM_".$array_modules[$i]["module"]) == "on")) {
                        $moduleOn = true;
                    }

                } else {
                    $moduleOn = true;
                }

                if ($moduleOn) {

                    $labelName = strpos($array_modules[$i]["name"], "LANG_") !== false ? constant($array_modules[$i]["name"]) : $array_modules[$i]["name"];

                    unset($aux_array);
                    $aux_array["order"]     = $i;
                    $aux_array["label"]     = $labelName;
                    $aux_array["link"]      = $array_modules[$i]["url"];
                    $aux_array["area"]      = $area;
                    $aux_array["custom"]    = "n";
                    $this->makeFromRow($aux_array);
                    $this->Save();
                }
            }

            if (!$appBuilder) {
                $filePath = HTMLEDITOR_FOLDER."/".EDIR_THEME."/".$area."_menu.php";
                @unlink($filePath);
            }
        }
    }
