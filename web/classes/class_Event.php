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
# * FILE: /classes/class_Event.php
# ----------------------------------------------------------------------------------------------------

/**
 * <code>
 *        $eventObj = new Event($id);
 * <code>
 * @copyright Copyright 2005 Arca Solutions, Inc.
 * @author Arca Solutions, Inc.
 */
class Event extends Handle
{
    var $id;
    var $account_id;
    var $title;
    var $seo_title;
    var $friendly_url;
    var $image_id;
    var $thumb_id;
    var $cover_id;
    var $description;
    var $seo_description;
    var $long_description;
    var $video_snippet;
    var $video_url;
    var $keywords;
    var $seo_keywords;
    var $updated;
    var $entered;
    var $start_date;
    var $has_start_time;
    var $start_time;
    var $end_date;
    var $has_end_time;
    var $end_time;
    var $location;
    var $address;
    var $zip_code;
    var $location_1;
    var $location_2;
    var $location_3;
    var $location_4;
    var $location_5;
    var $url;
    var $contact_name;
    var $phone;
    var $email;
    var $renewal_date;
    var $discount_id;
    var $status;
    var $suspended_sitemgr;
    var $level;
    var $recurring;
    var $day;
    var $dayofweek;
    var $week;
    var $month;
    var $until_date;
    var $repeat_event;
    var $number_views;
    var $latitude;
    var $longitude;
    var $map_zoom;
    var $locationManager;
    var $data_in_array;
    var $domain_id;
    var $package_id;
    var $package_price;

    /**
     * <code>
     *        $eventObj = new Event($id);
     * <code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @param integer $var
     */
    function Event($var = '', $domain_id = false)
    {

        if (is_numeric($var) && ($var)) {
            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if ($domain_id) {
                $this->domain_id = $domain_id;
                $db = db_getDBObjectByDomainID($domain_id, $dbMain);
            } else {
                if (defined("SELECTED_DOMAIN_ID")) {
                    $db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
                } else {
                    $db = db_getDBObject();
                }
            }
            unset($dbMain);
            $sql = "SELECT * FROM Event WHERE id = $var";
            $row = mysql_fetch_array($db->query($sql));

            $this->old_account_id = $row["account_id"];

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
     *        $this->makeFromRow($row);
     * <code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @param array $row
     */
    function makeFromRow($row = '')
    {
        $statusObj = new ItemStatus();
        $level = new EventLevel();

        $this->id = ($row["id"]) ? $row["id"] : ($this->id ? $this->id : 0);
        $this->account_id = ($row["account_id"]) ? $row["account_id"] : 0;
        $this->title = ($row["title"]) ? $row["title"] : ($this->title ? $this->title : "");
        $this->seo_title = ($row["seo_title"]) ? $row["seo_title"] : ($this->seo_title ? $this->seo_title : "");
        $this->friendly_url = ($row["friendly_url"]) ? $row["friendly_url"] : "";
        $this->image_id = ($row["image_id"]) ? $row["image_id"] : ($this->image_id ? $this->image_id : 0);
        $this->thumb_id = ($row["thumb_id"]) ? $row["thumb_id"] : ($this->thumb_id ? $this->thumb_id : 0);
        $this->cover_id = ($row["cover_id"]) ? $row["cover_id"] : ($this->cover_id ? $this->cover_id : 0);
        $this->description = ($row["description"]) ? $row["description"] : "";
        $this->seo_description = ($row["seo_description"]) ? $row["seo_description"] : ($this->seo_description ? $this->seo_description : "");
        $this->long_description = ($row["long_description"]) ? $row["long_description"] : "";
        $this->video_snippet = ($row["video_snippet"]) ? $row["video_snippet"] : "";
        $this->video_url = ($row["video_url"]) ? $row["video_url"] : "";
        $this->keywords = ($row["keywords"]) ? $row["keywords"] : "";
        $this->seo_keywords = ($row["seo_keywords"]) ? $row["seo_keywords"] : ($this->seo_keywords ? $this->seo_keywords : "");
        $this->updated = ($row["updated"]) ? $row["updated"] : ($this->updated ? $this->updated : "");
        $this->entered = ($row["entered"]) ? $row["entered"] : ($this->entered ? $this->entered : "");
        $this->setDate("start_date", $row["start_date"]);
        $this->has_start_time = ($row["has_start_time"]) ? $row["has_start_time"] : "n";
        $this->start_time = ($row["start_time"]) ? $row["start_time"] : 0;
        $this->setDate("end_date", $row["end_date"]);
        $this->has_end_time = ($row["has_end_time"]) ? $row["has_end_time"] : "n";
        $this->end_time = ($row["end_time"]) ? $row["end_time"] : 0;
        $this->location = ($row["location"]) ? $row["location"] : "";
        $this->address = ($row["address"]) ? $row["address"] : "";
        $this->zip_code = ($row["zip_code"]) ? $row["zip_code"] : "";
        $this->location_1 = ($row["location_1"]) ? $row["location_1"] : 0;
        $this->location_2 = ($row["location_2"]) ? $row["location_2"] : 0;
        $this->location_3 = ($row["location_3"]) ? $row["location_3"] : 0;
        $this->location_4 = ($row["location_4"]) ? $row["location_4"] : 0;
        $this->location_5 = ($row["location_5"]) ? $row["location_5"] : 0;
        $this->url = ($row["url"]) ? $row["url"] : "";
        $this->contact_name = ($row["contact_name"]) ? $row["contact_name"] : "";
        $this->phone = ($row["phone"]) ? $row["phone"] : "";
        $this->email = ($row["email"]) ? $row["email"] : "";
        $this->renewal_date = ($row["renewal_date"]) ? $row["renewal_date"] : ($this->renewal_date ? $this->renewal_date : 0);
        $this->discount_id = ($row["discount_id"]) ? $row["discount_id"] : "";
        $this->status = ($row["status"]) ? $row["status"] : $statusObj->getDefaultStatus();
        $this->suspended_sitemgr = ($row["suspended_sitemgr"]) ? $row["suspended_sitemgr"] : ($this->suspended_sitemgr ? $this->suspended_sitemgr : "n");
        $this->level = ($row["level"]) ? $row["level"] : ($this->level ? $this->level : $level->getDefaultLevel());
        $this->recurring = ($row["recurring"]) ? $row["recurring"] : "N";
        $this->day = ($row["day"]) ? $row["day"] : 0;
        $this->dayofweek = ($row["dayofweek"]) ? $row["dayofweek"] : "";
        $this->week = ($row["week"]) ? $row["week"] : "";
        $this->month = ($row["month"]) ? $row["month"] : 0;
        $this->setDate("until_date", ($row["until_date"] ? $row["until_date"] : "0000-00-00"));
        $this->repeat_event = ($row["repeat_event"]) ? $row["repeat_event"] : "N";

        if ($this->recurring == "N") {
            $this->day = 0;
            $this->dayofweek = "";
            $this->week = "";
            $this->month = 0;
            $this->until_date = "0000-00-00";
        }

        $this->number_views = ($row["number_views"]) ? $row["number_views"] : ($this->number_views ? $this->number_views : 0);
        $this->latitude = ($row["latitude"]) ? $row["latitude"] : ($this->latitude ? $this->latitude : "");
        $this->longitude = ($row["longitude"]) ? $row["longitude"] : ($this->longitude ? $this->longitude : "");
        $this->map_zoom = ($row["map_zoom"]) ? $row["map_zoom"] : 0;
        $this->data_in_array = $row;
        $this->package_id = ($row["package_id"]) ? $row["package_id"] : ($this->package_id ? $this->package_id : 0);
        $this->package_price = ($row["package_price"]) ? $row["package_price"] : ($this->package_price ? $this->package_price : 0);

        //video_url added on v10.4. This will get the url for existing videos (iframe)
        if ($this->video_snippet && !$this->video_url) {
            $this->video_url = system_getVideoURL($this->video_snippet);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->Save();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->Save();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @access Public
     */
    function Save()
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);

        if ($this->domain_id) {
            $dbObj = db_getDBObjectByDomainID($this->domain_id, $dbMain);
            $aux_log_domain_id = $this->domain_id;
        } else {
            if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
                $aux_log_domain_id = SELECTED_DOMAIN_ID;
            } else {
                $dbObj = db_getDBObject();
            }
        }

        unset($dbMain);

        $this->prepareToSave();

        $aux_old_account = str_replace("'", "", $this->old_account_id);
        $aux_account = str_replace("'", "", $this->account_id);

        $this->friendly_url = string_strtolower($this->friendly_url);

        if ($this->id) {

            $updateItem = true;
            $sql = "SELECT status, end_date, until_date FROM Event WHERE id = {$this->id}";
            $result = $dbObj->query($sql);

            if ($row = mysql_fetch_assoc($result)) {
                $last_status = $row["status"];
                $last_end_date = $row["end_date"];
                $last_until_date = $row["until_date"];
            }

            $this_status = $this->status;
            $this_id = $this->id;

            $sql = "UPDATE Event SET"
                . " account_id        = $this->account_id,"
                . " title             = $this->title,"
                . " seo_title         = $this->seo_title,"
                . " friendly_url      = $this->friendly_url,"
                . " image_id          = $this->image_id,"
                . " thumb_id          = $this->thumb_id,"
                . " cover_id          = $this->cover_id,"
                . " description       = $this->description,"
                . " seo_description   = $this->seo_description,"
                . " long_description  = $this->long_description,"
                . " video_snippet     = $this->video_snippet,"
                . " video_url         = $this->video_url,"
                . " keywords          = $this->keywords,"
                . " seo_keywords      = $this->seo_keywords,"
                . " updated           = NOW(),"
                . " start_date        = $this->start_date,"
                . " has_start_time    = $this->has_start_time,"
                . " start_time        = $this->start_time,"
                . " end_date          = $this->end_date,"
                . " has_end_time      = $this->has_end_time,"
                . " end_time          = $this->end_time,"
                . " location          = $this->location,"
                . " address           = $this->address,"
                . " zip_code          = $this->zip_code,"
                . " location_1        = $this->location_1,"
                . " location_2        = $this->location_2,"
                . " location_3        = $this->location_3,"
                . " location_4        = $this->location_4,"
                . " location_5        = $this->location_5,"
                . " url               = $this->url,"
                . " contact_name      = $this->contact_name,"
                . " phone             = $this->phone,"
                . " email             = $this->email,"
                . " renewal_date      = $this->renewal_date,"
                . " discount_id       = $this->discount_id,"
                . " status            = $this->status,"
                . " suspended_sitemgr = $this->suspended_sitemgr,"
                . " level             = $this->level,"
                . " recurring         = $this->recurring,"
                . " day               = $this->day,"
                . " dayofweek         = $this->dayofweek,"
                . " week              = $this->week,"
                . " month             = $this->month,"
                . " until_date        = $this->until_date,"
                . " repeat_event      = $this->repeat_event,"
                . " number_views      = $this->number_views,"
                . " latitude          = $this->latitude,"
                . " longitude         = $this->longitude,"
                . " map_zoom          = $this->map_zoom,"
                . " package_id        = $this->package_id,"
                . " package_price     = $this->package_price"
                . " WHERE id          = $this->id";

            $dbObj->query($sql);

            $last_status = str_replace("\"", "", $last_status);
            $last_status = str_replace("'", "", $last_status);
            $this_status = str_replace("\"", "", $this_status);
            $this_status = str_replace("'", "", $this_status);
            $this_id = str_replace("\"", "", $this_id);
            $this_id = str_replace("'", "", $this_id);

            /////
            $lastendDateStr = explode("-", $last_end_date);
            $lastuntilDateStr = explode("-", $last_until_date);
            $endDateStr = explode("-", $this->end_date);
            $untilDateStr = explode("-", $this->until_date);

            $lastendDateStr = $lastendDateStr[0] . $lastendDateStr[1] . $lastendDateStr[2];
            $lastuntilDateStr = $lastuntilDateStr[0] . $lastuntilDateStr[1] . $lastuntilDateStr[2];
            $endDateStr = $endDateStr[0] . $endDateStr[1] . $endDateStr[2];
            $untilDateStr = $untilDateStr[0] . $untilDateStr[1] . $untilDateStr[2];
            $endDateStr = str_replace("'", "", $endDateStr);
            $untilDateStr = str_replace("'", "", $untilDateStr);
            ////

            $incCheck = false;
            $decCheck1 = false;
            $decCheck2 = false;

            //if end_date/until_date is in the past and item status = A, category_count doesn't need changes, because daily_maintenance already did.
            //only change the counter if sitemgr/member corrects the date to future
            if (($last_status == "A" && $this_status == "A") && (($lastendDateStr < date("Ymd") && $endDateStr >= date("Ymd") && $this->recurring == "'N'") || ($this->recurring == "'Y'" && $this->repeat == "'N'" && $lastuntilDateStr < date("Ymd") && $untilDateStr >= date("Ymd")))) {
                $incCheck = true;
            }

            if (($last_status == "A" && $this_status != "A") && (($lastendDateStr < date("Ymd") && $endDateStr < date("Ymd") && $this->recurring == "'N'") || ($this->recurring == "'Y'" && $this->repeat == "'N'" && $lastuntilDateStr < date("Ymd") && $untilDateStr < date("Ymd")))) {
                $decCheck1 = true; //doesn't need any changes
            }

            if (($last_status != "A" && $this_status == "A") && (($lastendDateStr < date("Ymd") && $endDateStr < date("Ymd") && $this->recurring == "'N'") || ($this->recurring == "'Y'" && $this->repeat == "'N'" && $lastuntilDateStr < date("Ymd") && $untilDateStr < date("Ymd")))) {
                $decCheck2 = true; //doesn't need any changes
            }

            if ($incCheck) {
                system_countActiveItemByCategory("event", $this_id, "inc");
            }
            if (($this_status == "A") && ($last_status != "A") && !$decCheck2) {
                system_countActiveItemByCategory("event", $this_id, "inc");
            } elseif (($last_status == "A") && ($this_status != "A") && !$decCheck1) {
                system_countActiveItemByCategory("event", $this_id, "dec");
            }

            if ($aux_old_account != $aux_account && $aux_account != 0) {
                domain_SaveAccountInfoDomain($aux_account, $this);
            }

        } else {
            $aux_seoDescription = $this->description;
            $aux_seoDescription = str_replace(array("\r\n", "\n"), " ", $aux_seoDescription);
            $aux_seoDescription = str_replace("\\\"", "", $aux_seoDescription);

            $sql = "INSERT INTO Event"
                . " (account_id,"
                . " title,"
                . " seo_title,"
                . " friendly_url,"
                . " image_id,"
                . " thumb_id,"
                . " cover_id,"
                . " description,"
                . " seo_description,"
                . " long_description,"
                . " video_snippet,"
                . " video_url,"
                . " keywords,"
                . " seo_keywords,"
                . " updated,"
                . " entered,"
                . " start_date,"
                . " has_start_time,"
                . " start_time,"
                . " end_date,"
                . " has_end_time,"
                . " end_time,"
                . " location,"
                . " address,"
                . " zip_code,"
                . " location_1,"
                . " location_2,"
                . " location_3,"
                . " location_4,"
                . " location_5,"
                . " url,"
                . " contact_name,"
                . " phone,"
                . " email,"
                . " renewal_date,"
                . " discount_id,"
                . " status,"
                . " level,"
                . " fulltextsearch_keyword,"
                . " fulltextsearch_where,"
                . " recurring,"
                . " day,"
                . " dayofweek,"
                . " week,"
                . " month,"
                . " until_date,"
                . " repeat_event,"
                . " number_views,"
                . " latitude,"
                . " longitude,"
                . " map_zoom,"
                . " package_id,"
                . " package_price)"
                . " VALUES"
                . " ($this->account_id,"
                . " $this->title,"
                . " $this->title,"
                . " $this->friendly_url,"
                . " $this->image_id,"
                . " $this->thumb_id,"
                . " $this->cover_id,"
                . " $this->description,"
                . " $aux_seoDescription,"
                . " $this->long_description,"
                . " $this->video_snippet,"
                . " $this->video_url,"
                . " $this->keywords,"
                . " " . str_replace(" || ", ", ", $this->keywords) . ","
                . " NOW(),"
                . " NOW(),"
                . " $this->start_date,"
                . " $this->has_start_time,"
                . " $this->start_time,"
                . " $this->end_date,"
                . " $this->has_end_time,"
                . " $this->end_time,"
                . " $this->location,"
                . " $this->address,"
                . " $this->zip_code,"
                . " $this->location_1,"
                . " $this->location_2,"
                . " $this->location_3,"
                . " $this->location_4,"
                . " $this->location_5,"
                . " $this->url,"
                . " $this->contact_name,"
                . " $this->phone,"
                . " $this->email,"
                . " $this->renewal_date,"
                . " $this->discount_id,"
                . " $this->status,"
                . " $this->level,"
                . " '',"
                . " '',"
                . " $this->recurring,"
                . " $this->day,"
                . " $this->dayofweek,"
                . " $this->week,"
                . " $this->month,"
                . " $this->until_date,"
                . " $this->repeat_event,"
                . " $this->number_views,"
                . " $this->latitude,"
                . " $this->longitude,"
                . " $this->map_zoom,"
                . " $this->package_id,"
                . " $this->package_price)";

            $dbObj->query($sql);
            $this->id = mysql_insert_id($dbObj->link_id);

            $this_status = $this->status;
            $this_id = $this->id;
            $this_status = str_replace("\"", "", $this_status);
            $this_status = str_replace("'", "", $this_status);
            $this_id = str_replace("\"", "", $this_id);
            $this_id = str_replace("'", "", $this_id);
            if ($this_status == "A") {
                system_countActiveItemByCategory("event", $this_id, "inc");
            }

            if ($aux_account != 0) {
                domain_SaveAccountInfoDomain($aux_account, $this);
            }

        }

        if ((sess_getAccountIdFromSession() && string_strpos($_SERVER["PHP_SELF"],
                    "event.php") !== false) || string_strpos($_SERVER["PHP_SELF"], "order_") !== false
        ) {
            $rowTimeline = array();
            $rowTimeline["item_type"] = "event";
            $rowTimeline["action"] = ($updateItem ? "edit" : "new");
            $rowTimeline["item_id"] = str_replace("'", "", $this->id);
            $timelineObj = new Timeline($rowTimeline);
            $timelineObj->save();
        }

        $this->prepareToUse();

        $this->setFullTextSearch();

        $this->cleanCacheEvent();
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->Delete();
     * <code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name Delete
     * @access Public
     * @param integer $domain_id
     */
    function Delete($domain_id = false)
    {

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
        ### EVENT CATEGORY
        if ($this->status == "A") {
            system_countActiveItemByCategory("event", $this->id, "dec", false, $domain_id);
        }

        ### GALERY
        $sql = "SELECT gallery_id FROM Gallery_Item WHERE item_id = $this->id AND item_type = 'event'";
        $row = mysql_fetch_array($dbObj->query($sql));
        $gallery_id = $row["gallery_id"];
        if ($gallery_id) {
            $gallery = new Gallery($gallery_id);
            $gallery->delete();
        }

        ### IMAGE
        if ($this->image_id) {
            $image = new Image($this->image_id);
            if ($image) {
                $image->Delete($domain_id);
            }
        }
        if ($this->thumb_id) {
            $image = new Image($this->thumb_id);
            if ($image) {
                $image->Delete($domain_id);
            }
        }
        if ($this->cover_id) {
            $image = new Image($this->cover_id);
            if ($image) {
                $image->Delete($domain_id);
            }
        }

        ### INVOICE
        $sql = "UPDATE Invoice_Event SET event_id = '0' WHERE event_id = $this->id";
        $dbObj->query($sql);

        ### PAYMENT
        $sql = "UPDATE Payment_Event_Log SET event_id = '0' WHERE event_id = $this->id";
        $dbObj->query($sql);

        ### Timeline
        $sql = "DELETE FROM Timeline WHERE item_type = 'event' AND item_id = $this->id";
        $dbObj->query($sql);

        ### EVENT
        $sql = "DELETE FROM Event WHERE id = $this->id";
        $dbObj->query($sql);

        if ($domain_id) {
            $domain_idDash = $domain_id;
        } else {
            $domain_idDash = SELECTED_DOMAIN_ID;
        }

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("event.synchronization")->addDelete($this->id);
        }

        $this->cleanCacheEvent();
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getCategories();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getCategories();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getCategories
     * @access Public
     * @return array
     */
    function getCategories()
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "SELECT cat_1_id, cat_2_id, cat_3_id, cat_4_id, cat_5_id FROM Event WHERE id = $this->id";
        $r = $dbObj->query($sql);
        while ($row = mysql_fetch_array($r)) {
            if ($row["cat_1_id"]) {
                $categories[] = new EventCategory($row["cat_1_id"]);
            }
            if ($row["cat_2_id"]) {
                $categories[] = new EventCategory($row["cat_2_id"]);
            }
            if ($row["cat_3_id"]) {
                $categories[] = new EventCategory($row["cat_3_id"]);
            }
            if ($row["cat_4_id"]) {
                $categories[] = new EventCategory($row["cat_4_id"]);
            }
            if ($row["cat_5_id"]) {
                $categories[] = new EventCategory($row["cat_5_id"]);
            }
        }

        return $categories;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->setCategories();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->setCategories();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name setCategories
     * @access Public
     */
    function setCategories($array)
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);

        if ($this->status == "A") {
            system_countActiveItemByCategory("event", $this->id, "dec");
        }

        $cat_1_id = 0;
        $parcat_1_level1_id = 0;
        $parcat_1_level2_id = 0;
        $parcat_1_level3_id = 0;
        $parcat_1_level4_id = 0;
        $cat_2_id = 0;
        $parcat_2_level1_id = 0;
        $parcat_2_level2_id = 0;
        $parcat_2_level3_id = 0;
        $parcat_2_level4_id = 0;
        $cat_3_id = 0;
        $parcat_3_level1_id = 0;
        $parcat_3_level2_id = 0;
        $parcat_3_level3_id = 0;
        $parcat_3_level4_id = 0;
        $cat_4_id = 0;
        $parcat_4_level1_id = 0;
        $parcat_4_level2_id = 0;
        $parcat_4_level3_id = 0;
        $parcat_4_level4_id = 0;
        $cat_5_id = 0;
        $parcat_5_level1_id = 0;
        $parcat_5_level2_id = 0;
        $parcat_5_level3_id = 0;
        $parcat_5_level4_id = 0;
        if ($array) {
            $count_category_aux = 1;
            foreach ($array as $category) {
                if ($category) {
                    unset($parents);
                    $cat_id = $category;
                    $i = 0;
                    while ($cat_id != 0) {
                        $sql = "SELECT * FROM EventCategory WHERE id = $cat_id";
                        $rs1 = $dbObj->query($sql);
                        if (mysql_num_rows($rs1) > 0) {
                            $cat_info = mysql_fetch_assoc($rs1);
                            $cat_id = $cat_info["category_id"];
                            $parents[$i++] = $cat_id;
                        } else {
                            $cat_id = 0;
                        }
                    }
                    for ($j = count($parents) - 1; $j < 4; $j++) {
                        $parents[$j] = 0;
                    }
                    ${"cat_" . $count_category_aux . "_id"} = $category;
                    ${"parcat_" . $count_category_aux . "_level1_id"} = $parents[0];
                    ${"parcat_" . $count_category_aux . "_level2_id"} = $parents[1];
                    ${"parcat_" . $count_category_aux . "_level3_id"} = $parents[2];
                    ${"parcat_" . $count_category_aux . "_level4_id"} = $parents[3];
                    $count_category_aux++;
                }
            }
        }
        $sql = "UPDATE Event SET cat_1_id = " . $cat_1_id . ", parcat_1_level1_id = " . $parcat_1_level1_id . ", parcat_1_level2_id = " . $parcat_1_level2_id . ", parcat_1_level3_id = " . $parcat_1_level3_id . ", parcat_1_level4_id = " . $parcat_1_level4_id . ", cat_2_id = " . $cat_2_id . ", parcat_2_level1_id = " . $parcat_2_level1_id . ", parcat_2_level2_id = " . $parcat_2_level2_id . ", parcat_2_level3_id = " . $parcat_2_level3_id . ", parcat_2_level4_id = " . $parcat_2_level4_id . ", cat_3_id = " . $cat_3_id . ", parcat_3_level1_id = " . $parcat_3_level1_id . ", parcat_3_level2_id = " . $parcat_3_level2_id . ", parcat_3_level3_id = " . $parcat_3_level3_id . ", parcat_3_level4_id = " . $parcat_3_level4_id . ", cat_4_id = " . $cat_4_id . ", parcat_4_level1_id = " . $parcat_4_level1_id . ", parcat_4_level2_id = " . $parcat_4_level2_id . ", parcat_4_level3_id = " . $parcat_4_level3_id . ", parcat_4_level4_id = " . $parcat_4_level4_id . ", cat_5_id = " . $cat_5_id . ", parcat_5_level1_id = " . $parcat_5_level1_id . ", parcat_5_level2_id = " . $parcat_5_level2_id . ", parcat_5_level3_id = " . $parcat_5_level3_id . ", parcat_5_level4_id = " . $parcat_5_level4_id . " WHERE id = $this->id";
        $dbObj->query($sql);
        $this->setFullTextSearch();

        if ($this->status == "A") {
            system_countActiveItemByCategory("event", $this->id, "inc");
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getCategories();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getCategories();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getCategories
     * @access Public
     * @return real
     */
    function getPrice()
    {
        $price = 0;

        $dbMain = db_getDBObject(DEFAULT_DB, true);

        if ($this->domain_id) {
            $dbObj = db_getDBObjectByDomainID($this->domain_id, $dbMain);
        } else {
            if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }
        }

        unset($dbMain);

        $levelObj = new EventLevel();
        if ($this->package_id) {
            $price = $this->package_price;
        } else {
            $price = $price + $levelObj->getPrice($this->level);
        }

        if ($this->discount_id) {

            $discountCodeObj = new DiscountCode($this->discount_id);

            if (is_valid_discount_code($this->discount_id, "event", $this->id, $discount_message, $discount_error)) {

                if ($discountCodeObj->getString("id") && $discountCodeObj->expire_date >= date('Y-m-d')) {

                    if ($discountCodeObj->getString("type") == "percentage") {
                        $price = $price * (1 - $discountCodeObj->getString("amount") / 100);
                    } elseif ($discountCodeObj->getString("type") == "monetary value") {
                        $price = $price - $discountCodeObj->getString("amount");
                    }

                } elseif (($discountCodeObj->type == 'percentage' && $discountCodeObj->amount == '100.00') || ($discountCodeObj->type == 'monetary value' && $discountCodeObj->amount > $price)) {
                    $this->status = 'E';
                    $this->renewal_date = $discountCodeObj->expire_date;

                    $sql = "UPDATE Event SET status = 'E', renewal_date = '" . $discountCodeObj->expire_date . "', discount_id = '' WHERE id = " . $this->id;
                    $result = $dbObj->query($sql);
                }

            } else {

                if (($discountCodeObj->type == 'percentage' && $discountCodeObj->amount == '100.00') || ($discountCodeObj->type == 'monetary value' && $discountCodeObj->amount > $price)) {
                    $this->status = 'E';
                    $this->renewal_date = $discountCodeObj->expire_date;
                    $sql = "UPDATE Event SET status = 'E', renewal_date = '" . $discountCodeObj->expire_date . "', discount_id = '' WHERE id = " . $this->id;
                } else {
                    $sql = "UPDATE Event SET discount_id = '' WHERE id = " . $this->id;
                }
                $result = $dbObj->query($sql);

            }

        }

        if ($price <= 0) {
            $price = 0;
        }

        return $price;

    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->hasRenewalDate();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->hasRenewalDate();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name hasRenewalDate
     * @access Public
     * @return boolean
     */
    function hasRenewalDate()
    {
        if (PAYMENT_FEATURE != "on") {
            return false;
        }
        if ((CREDITCARDPAYMENT_FEATURE != "on") && (INVOICEPAYMENT_FEATURE != "on") && (MANUALPAYMENT_FEATURE != "on")) {
            return false;
        }
        if ($this->getPrice() <= 0) {
            return false;
        }

        return true;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->needToCheckOut();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->needToCheckOut();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name needToCheckOut
     * @access Public
     * @return boolean
     */
    function needToCheckOut()
    {

        if ($this->hasRenewalDate()) {

            $today = date("Y-m-d");
            $today = explode("-", $today);
            $today_year = $today[0];
            $today_month = $today[1];
            $today_day = $today[2];
            $timestamp_today = mktime(0, 0, 0, $today_month, $today_day, $today_year);

            $this_renewaldate = $this->renewal_date;
            $renewaldate = explode("-", $this_renewaldate);
            $renewaldate_year = $renewaldate[0];
            $renewaldate_month = $renewaldate[1];
            $renewaldate_day = $renewaldate[2];
            $timestamp_renewaldate = mktime(0, 0, 0, $renewaldate_month, $renewaldate_day, $renewaldate_year);

            if (($this->status == "E") || ($this_renewaldate == "0000-00-00") || ($timestamp_today > $timestamp_renewaldate)) {
                return true;
            }

        }

        return false;

    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getNextRenewalDate($times);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getNextRenewalDate($times);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getNextRenewalDate
     * @access Public
     * @param integer $times
     * @return date
     */
    function getNextRenewalDate($times = 1)
    {

        $nextrenewaldate = "0000-00-00";

        if ($this->hasRenewalDate()) {

            if ($this->needToCheckOut()) {

                $today = date("Y-m-d");
                $today = explode("-", $today);
                $start_year = $today[0];
                $start_month = $today[1];
                $start_day = $today[2];

            } else {

                $this_renewaldate = $this->renewal_date;
                $renewaldate = explode("-", $this_renewaldate);
                $start_year = $renewaldate[0];
                $start_month = $renewaldate[1];
                $start_day = $renewaldate[2];

            }

            $renewalcycle = payment_getRenewalCycle("event");
            $renewalunit = payment_getRenewalUnit("event");

            if ($renewalunit == "Y") {
                $nextrenewaldate = date("Y-m-d",
                    mktime(0, 0, 0, (int)$start_month, (int)$start_day, (int)$start_year + ($renewalcycle * $times)));
            } elseif ($renewalunit == "M") {
                $nextrenewaldate = date("Y-m-d",
                    mktime(0, 0, 0, (int)$start_month + ($renewalcycle * $times), (int)$start_day, (int)$start_year));
            } elseif ($renewalunit == "D") {
                $nextrenewaldate = date("Y-m-d",
                    mktime(0, 0, 0, (int)$start_month, (int)$start_day + ($renewalcycle * $times), (int)$start_year));
            }

        }

        return $nextrenewaldate;

    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getDateString();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getDateString();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getDateString
     * @access Public
     * @return string
     */
    function getDateString($use_text = false)
    {
        $str_date = "";

        if ($this->getDate("start_date") == $this->getDate("end_date")) {
            $str_date = $this->getDate("start_date");
        } elseif ($this->getString("recurring") != "Y") {
            if ($use_text) {
                $str_date = "<p><strong>" . ucfirst(system_showText(LANG_LABEL_FROM)) . ":</strong>" . "<span>" . $this->getDate("start_date") . "</span></p>" . "<p><strong>" . ucfirst(system_showText(LANG_LABEL_DATE_TO)) . ":</strong>" . "<span>" . $this->getDate("end_date") . "</span></p>";
            } else {
                $str_date = $this->getDate("start_date") . " - " . $this->getDate("end_date");
            }
        } else {
            $str_date = $this->getDate("start_date");
        }

        return $str_date;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getDateStringEnd();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getDateStringEnd();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getDateStringEnd
     * @access Public
     * @return string
     */
    function getDateStringEnd()
    {
        $str_date = "";
        $str_date = $this->getDate("until_date");

        return $str_date;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getDateStringRecurring();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getDateStringRecurring();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getDateStringRecurring
     * @access Public
     * @return string
     */
    function getDateStringRecurring()
    {
        $str_date = "";

        if ($this->getString("recurring") == "Y") {

            $month_names = explode(",", LANG_DATE_MONTHS);
            $weekday_names = explode(",", LANG_DATE_WEEKDAYS);

            if ($this->getString("dayofweek") && $this->getNumber("week") && $this->getNumber("month")) { //yearly with determined week and random days

                $aux = system_getRecurringWeeks($this->getString("week"));
                $checkDays = system_checkDay($this->getString("dayofweek"));
                $str_date .= $checkDays;
                if ($aux) {
                    $str_date .= ", " . LANG_EVERY2 . " " . $aux . system_showText(LANG_WEEK) . " " . system_showText(LANG_OF2) . " " . ucfirst($month_names[$this->getNumber("month") - 1]);
                } else {
                    $str_date .= " " . system_showText(LANG_OF2) . " " . ucfirst($month_names[$this->getNumber("month") - 1]);
                }

            } elseif ($this->getNumber("day")) { //monthly or yearly with determined day

                if ($this->getNumber("month")) {
                    if (EDIR_LANGUAGE == "en_us") {
                        $str_date .= ucfirst($month_names[$this->getNumber("month") - 1]) . " " . system_getOrdinalLabel($this->getNumber("day")) . ", " . LANG_EVERY_YEAR;
                    } else {
                        $str_date .= ucfirst(system_showText(LANG_DAY)) . " " . $this->getNumber("day") . " " . system_showText(LANG_OF2) . " " . ucfirst($month_names[$this->getNumber("month") - 1]);
                    }
                } else {
                    if (EDIR_LANGUAGE == "en_us") {
                        $str_date .= system_getOrdinalLabel($this->getNumber("day")) . " " . ucfirst(system_showText(LANG_DAY)) . " " . LANG_OF . " " . LANG_THE_MONTH;
                    } else {
                        $str_date .= system_showText(LANG_EVERY2) . " " . system_showText(LANG_DAY) . " " . $this->getNumber("day");
                    }
                }

            } elseif ($this->getString("dayofweek")) { //weekly or monthly, with determined week and random days

                if ($this->getNumber("week")) {

                    $aux = system_getRecurringWeeks($this->getString("week"));
                    $checkDays = system_checkDay($this->getString("dayofweek"));
                    $str_date .= $checkDays . " ";
                    if ($aux) {
                        $str_date = str_replace(LANG_EVERY2 . " " . ucfirst(LANG_EVENT_WEEKEND),
                            ucfirst(LANG_EVENT_WEEKENDS) . ", ", $str_date);
                        $str_date .= LANG_EVERY2 . " " . $aux . LANG_WEEK . (EDIR_LANGUAGE == "en_us" ? " " . LANG_OF2 : "") . " " . LANG_THE_MONTH;
                    }
                } else {
                    $checkDays = system_checkDay($this->getString("dayofweek"));
                    $str_date .= $checkDays;
                }

            } else { //daily
                $str_date .= system_showText(LANG_DAILY2);
            }

        }

        return $str_date;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getTimeString();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getTimeString();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getTimeString
     * @access Public
     * @return string
     */
    function getTimeString()
    {
        $str_time = "";
        if ($this->getString("has_start_time") == "y") {
            $startTimeStr = explode(":", $this->getString("start_time"));
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
            if ($start_time_hour < 10) {
                $start_time_hour = "0" . ($start_time_hour + 0);
            }
            $start_time_min = $startTimeStr[1];
            $str_time .= $start_time_hour . ":" . $start_time_min . " " . $start_time_am_pm;
        } else {
            $str_time .= LANG_NA;
        }
        $str_time .= " - ";
        if ($this->getString("has_end_time") == "y") {
            $endTimeStr = explode(":", $this->getString("end_time"));
            if (CLOCK_TYPE == '24') {
                $end_time_hour = $endTimeStr[0];
            } elseif (CLOCK_TYPE == '12') {
                if ($endTimeStr[0] > "12") {
                    $end_time_hour = $endTimeStr[0] - 12;
                    $end_time_am_pm = "pm";
                } elseif ($endTimeStr[0] == "12") {
                    $end_time_hour = 12;
                    $end_time_am_pm = "pm";
                } elseif ($endTimeStr[0] == "00") {
                    $end_time_hour = 12;
                    $end_time_am_pm = "am";
                } else {
                    $end_time_hour = $endTimeStr[0];
                    $end_time_am_pm = "am";
                }
            }
            if ($end_time_hour < 10) {
                $end_time_hour = "0" . ($end_time_hour + 0);
            }
            $end_time_min = $endTimeStr[1];
            $str_time .= $end_time_hour . ":" . $end_time_min . " " . $end_time_am_pm;
        } else {
            $str_time .= LANG_NA;
        }
        if (($this->getString("has_start_time") == "n") && ($this->getString("has_end_time") == "n")) {
            $str_time = "";
        }

        return $str_time;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getMonthAbbr();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getMonthAbbr();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getMonthAbbr
     * @access Public
     * @return string
     */
    function getMonthAbbr()
    {
        $aux = explode("/", $this->getDate("start_date"));
        $months = explode(",", LANG_DATE_MONTHS);
        if (DEFAULT_DATE_FORMAT == "m/d/Y") {
            $month = $aux[0];
        } else {
            $month = $aux[1];
        }

        switch ($month) {
            case "01" :
                return string_substr($months[0], 0, 3);
                break;
            case "02" :
                return string_substr($months[1], 0, 3);
                break;
            case "03" :
                return string_substr($months[2], 0, 3);
                break;
            case "04" :
                return string_substr($months[3], 0, 3);
                break;
            case "05" :
                return string_substr($months[4], 0, 3);
                break;
            case "06" :
                return string_substr($months[5], 0, 3);
                break;
            case "07" :
                return string_substr($months[6], 0, 3);
                break;
            case "08" :
                return string_substr($months[7], 0, 3);
                break;
            case "09" :
                return string_substr($months[8], 0, 3);
                break;
            case "10" :
                return string_substr($months[9], 0, 3);
                break;
            case "11" :
                return string_substr($months[10], 0, 3);
                break;
            case "12" :
                return string_substr($months[11], 0, 3);
                break;
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->checkStartDate();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->checkStartDate();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name checkStartDate
     * @access Public
     * @return string
     */
    function checkStartDate()
    {
        if ($this->getString("recurring") != "Y") {
            $today = date("Y-m-d");
            $auxStartDate = explode("/", $this->getDate("start_date"));
            if (DEFAULT_DATE_FORMAT == "m/d/Y") {
                $startDate = $auxStartDate[2] . "-" . $auxStartDate[0] . "-" . $auxStartDate[1];
            } else {
                $startDate = $auxStartDate[2] . "-" . $auxStartDate[1] . "-" . $auxStartDate[0];
            }
            if ($today == $startDate) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getMonthAbbr();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getMonthAbbr();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getTimeString
     * @access Public
     * @return string
     */
    function getDayStr()
    {
        $aux = explode("/", $this->getDate("start_date"));
        if (DEFAULT_DATE_FORMAT == "m/d/Y") {
            return $aux[1];
        } else {
            return $aux[0];
        }

    }

    /**
     * <code>
     *        //Using this in Event() class.
     *        $this->setLocationManager(&$locationManager);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name setLocationManager
     * @access Public
     * @param string $locationManager
     */
    function setLocationManager(&$locationManager)
    {
        $this->locationManager =& $locationManager;
    }

    /**
     * <code>
     *        //Using this in Event() class.
     *        $this->getLocationManager();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getLocationManager
     * @access Public
     * @return array
     */
    function &getLocationManager()
    {
        return $this->locationManager; /* NEVER auto-instantiate this*/
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getLocationString($format,$forceManagerCreation);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getLocationString();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getLocationString
     * @access Public
     * @param string $format , boolean $forceManagerCreation
     * @return array
     */
    function getLocationString($format, $forceManagerCreation = false, $lineBreak = true)
    {
        if ($forceManagerCreation && !$this->locationManager) {
            $this->locationManager = new LocationManager();
        }

        return db_getLocationString($this, $format, true, $lineBreak);
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->setFullTextSearch();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->setFullTextSearch();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name setFullTextSearch
     * @access Public
     */
    function setFullTextSearch()
    {

        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);

        if ($this->title) {
            $string = str_replace(" || ", " ", $this->title);
            $fulltextsearch_keyword[] = $string;
            $addkeyword = format_addApostWords($string);
            if ($addkeyword != '') {
                $fulltextsearch_keyword[] = $addkeyword;
            }
            unset($addkeyword);
        }

        if ($this->keywords) {
            $string = str_replace(" || ", " ", $this->keywords);
            $fulltextsearch_keyword[] = $string;
            $addkeyword = format_addApostWords($string);
            if ($addkeyword != '') {
                $fulltextsearch_keyword[] = $addkeyword;
            }
            unset($addkeyword);
        }

        if ($this->description) {
            $fulltextsearch_keyword[] = string_substr($this->description, 0, 100);
        }

        if ($this->address) {
            $fulltextsearch_where[] = $this->address;
        }

        if ($this->location) {
            $fulltextsearch_where[] = $this->location;
        }

        if ($this->zip_code) {
            $fulltextsearch_where[] = $this->zip_code;
        }

        $Location1 = new Location1($this->location_1);
        if ($Location1->getNumber("id")) {
            $fulltextsearch_where[] = $Location1->getString("name", false);
            if ($Location1->getString("abbreviation")) {
                $fulltextsearch_where[] = $Location1->getString("abbreviation", false);
            }
        }

        $_locations = explode(",", EDIR_LOCATIONS);
        foreach ($_locations as $each_location) {
            unset ($objLocation);
            $objLocationLabel = "Location" . $each_location;
            $attributeLocation = 'location_' . $each_location;
            $objLocation = new $objLocationLabel;
            $objLocation->SetString("id", $this->$attributeLocation);
            $locationsInfo = $objLocation->retrieveLocationById();
            if ($locationsInfo["id"]) {
                $fulltextsearch_where[] = $locationsInfo["name"];
                if ($locationsInfo["abbreviation"]) {
                    $fulltextsearch_where[] = $locationsInfo["abbreviation"];
                }
            }
        }

        $categories = $this->getCategories();
        if ($categories) {
            foreach ($categories as $category) {
                unset($parents);
                $category_id = $category->getNumber("id");
                while ($category_id != 0) {
                    $sql = "SELECT * FROM EventCategory WHERE id = $category_id";
                    $result = $dbObj->query($sql);
                    if (mysql_num_rows($result) > 0) {
                        $category_info = mysql_fetch_assoc($result);
                        if ($category_info["enabled"] == "y") {
                            if ($category_info["title"]) {
                                $fulltextsearch_keyword[] = $category_info["title"];
                            }

                            if ($category_info["keywords"]) {
                                $fulltextsearch_keyword[] = str_replace(array("\r\n", "\n"), " ",
                                    $category_info["keywords"]);
                            }
                        }
                        $category_id = $category_info["category_id"];
                    } else {
                        $category_id = 0;
                    }
                }
            }
        }

        if (is_array($fulltextsearch_keyword)) {
            $fulltextsearch_keyword_sql = db_formatString(implode(" ", $fulltextsearch_keyword));
            $sql = "UPDATE Event SET fulltextsearch_keyword = {$fulltextsearch_keyword_sql} WHERE id = {$this->id}";
            $result = $dbObj->query($sql);
        }

        if (is_array($fulltextsearch_where)) {
            $fulltextsearch_where_sql = db_formatString(implode(" ", $fulltextsearch_where));
            $sql = "UPDATE Event SET fulltextsearch_where = {$fulltextsearch_where_sql} WHERE id = {$this->id}";
            $result = $dbObj->query($sql);
        }

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("event.synchronization")->addUpsert($this->id);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getGalleries();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getGalleries();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getGalleries
     * @access Public
     * @return array
     */
    function getGalleries()
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "SELECT * FROM Gallery_Item WHERE item_type='event' AND item_id = $this->id ORDER BY gallery_id";
        $r = $dbObj->query($sql);
        if ($this->id > 0) {
            while ($row = mysql_fetch_array($r)) {
                $galleries[] = $row["gallery_id"];
            }
        }

        return $galleries;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->setGalleries($gallery);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->setGalleries($gallery);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name setGalleries
     * @access Public
     * @param integer $gallery
     */
    function setGalleries($gallery = false)
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "DELETE FROM Gallery_Item WHERE item_type='event' AND item_id = $this->id";
        $dbObj->query($sql);
        if ($gallery) {
            $sql = "INSERT INTO Gallery_Item (item_id, gallery_id, item_type) VALUES ($this->id, $gallery, 'event')";
            $rs3 = $dbObj->query($sql);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->setMapTuning($latitude_longitude,$map_zoom);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->setMapTuning($gallery);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name setMapTuning
     * @access Public
     * @param string $latitude_longitude , integer $map_zoom
     */
    function setMapTuning($latitude_longitude = "", $map_zoom)
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }
        unset($dbMain);

        $auxCoord = explode(",", $latitude_longitude);
        $latitude = $auxCoord[0];
        $longitude = $auxCoord[1];

        $sql = "UPDATE Event SET latitude = " . db_formatString($latitude) . ", longitude = " . db_formatString($longitude) . ", map_zoom = " . db_formatNumber($map_zoom) . " WHERE id = " . $this->id . "";
        $dbObj->query($sql);

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("event.synchronization")->addUpsert($this->id);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->hasDetail();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->hasDetail();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name hasDetail
     * @access Public
     * @return char
     */
    function hasDetail()
    {
        $eventLevel = new EventLevel();
        $detail = $eventLevel->getDetail($this->level);
        unset($eventLevel);

        return $detail;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->setNumberViews($id);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->setNumberViews($id);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name setNumberViews
     * @access Public
     * @param integer $id
     */
    function setNumberViews($id)
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "UPDATE Event SET number_views = " . $this->number_views . " + 1 WHERE Event.id = " . $id;
        $dbObj->query($sql);

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("event.synchronization")->addViewUpdate($id);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->deletePerAccount($account_id);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->deletePerAccount($account_id);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name deletePerAccount
     * @access Public
     * @param integer $account_id
     * @param integer $domain_id
     */
    function deletePerAccount($account_id = 0, $domain_id = false)
    {
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
            $sql = "SELECT * FROM Event WHERE account_id = $account_id";
            $result = $dbObj->query($sql);
            while ($row = mysql_fetch_array($result)) {
                $this->makeFromRow($row);
                $this->Delete($domain_id);
            }
        }
    }


    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getEventByFriendlyURL($friendly_url);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getEventByFriendlyURL($friendly_url);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getEventByFriendlyURL
     * @param string $friendly_url
     * @access Public
     */
    function getEventByFriendlyURL($friendly_url)
    {
        $dbObj = db_getDBObject();
        $sql = "SELECT * FROM Event WHERE friendly_url = '" . $friendly_url . "'";
        $result = $dbObj->query($sql);
        if (mysql_num_rows($result)) {
            $this->makeFromRow(mysql_fetch_assoc($result));

            return true;
        } else {
            return false;
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->getEventToApp();
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->getEventToApp();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getEventToApp
     * @access Public
     */
    function getEventToApp()
    {

        if ($this->id > 0 && $this->status == 'A') {

            /**
             * Fields to detail page
             */
            unset($aux_detail_fields);

            $aux_detail_fields[] = "id";
            $aux_detail_fields[] = "title";
            $aux_detail_fields[] = "email";
            $aux_detail_fields[] = "phone";
            $aux_detail_fields[] = "contact_name";
            $aux_detail_fields[] = "url";
            $aux_detail_fields[] = "latitude";
            $aux_detail_fields[] = "longitude";
            $aux_detail_fields[] = "description";
            $aux_detail_fields[] = "long_description";
            $aux_detail_fields[] = "level";
            $aux_detail_fields[] = "start_date";
            $aux_detail_fields[] = "end_date";
            $aux_detail_fields[] = "start_time";
            $aux_detail_fields[] = "end_time";
            $aux_detail_fields[] = "has_start_time";
            $aux_detail_fields[] = "has_end_time";
            $aux_detail_fields[] = "level";
            $aux_detail_fields[] = "recurring";
            $aux_detail_fields[] = "until_date";
            $aux_detail_fields[] = "repeat_event";
            $aux_detail_fields[] = "video_snippet";
            $aux_detail_fields[] = "video_description";

            /*
                 * Number fields
                 */
            unset($number_fields);
            $number_fields[] = "latitude";
            $number_fields[] = "longitude";
            $number_fields[] = "level";

            unset($add_info);
            $locationsToshow = system_retrieveLocationsToShow();
            $locationsParam = "A, B, " . system_formatLocation($locationsToshow . ", z");

            $add_info["location_information"] = $this->getLocationString($locationsParam, true);
            $add_info["location_name"] = $this->getString("location");
            $add_info["string_time"] = $this->getTimeString();

            if ($this->getString("recurring") == "Y") {
                $add_info["recurring_string"] = $this->getDateStringRecurring();
            } else {
                $add_info["recurring_string"] = "";
            }

            foreach ($this->data_in_array as $key => $value) {

                if (strpos($key, "image_id") !== false) {
                    unset($imageObj);
                    $imageObj = new Image($value);
                    if ($imageObj->imageExists()) {
                        $add_info["imageurl"] = $imageObj->getPath();
                    } else {
                        $firstGalImage = system_getImageFromGallery("event", $this->id);
                        if ($firstGalImage) {
                            $add_info["imageurl"] = $firstGalImage;
                        } else {
                            $add_info["imageurl"] = null;
                        }
                    }
                }

                if (strpos($key, "start_time") !== false && $value == "00:00:00") {
                    if ($this->has_start_time == "n") {
                        $value = null;
                    }
                }

                if (strpos($key, "end_time") !== false && $value == "00:00:00") {
                    if ($this->has_end_time == "n") {
                        $value = null;
                    }
                }

                /**
                 * Get just fields to show on detail App
                 */
                if (!is_numeric($key) && in_array($key, $aux_detail_fields)) {

                    if ($key != "image_id" && $key != "has_start_time" && $key != "has_end_time") {
                        if (is_array($aux_fields)) {
                            $add_info[array_search($key, $aux_fields)] = ((is_numeric($value) && in_array($key,
                                    $number_fields)) ? (float)$value : $value);
                        } else {
                            $add_info[$key] = ((is_numeric($value) && in_array($key,
                                    $number_fields)) ? (float)$value : $value);
                        }
                    }
                }
            }

            /**
             * Get galleries
             */
            unset($aux_galleries);

            $aux_galleries = $this->getGalleries();
            if (is_array($aux_galleries)) {

                $galleryObj = new Gallery();

                for ($i = 0; $i < count($aux_galleries); $i++) {

                    $images = $galleryObj->getAllImages($aux_galleries[$i]);

                    if (is_array($images)) {

                        $k = 0;
                        for ($j = 0; $j < count($images); $j++) {

                            unset($imageObj);
                            $imageObj = new Image($images[$j]["image_id"]);
                            if ($imageObj->imageExists()) {
                                $add_info["gallery"][$k]["imageurl"] = $imageObj->getPath();
                                $add_info["gallery"][$k]["caption"] = $images[$j]["thumb_caption"];
                                $add_info["gallery"][$k]["description"] = $images[$j]["image_caption"];
                                $k++;
                            }

                        }
                    }
                }
            }

            /*
                 * Get categories
                 */
            unset($aux_categories);
            $aux_categories = $this->getCategories();
            if (is_array($aux_categories) && count($aux_categories)) {
                for ($j = 0; $j < count($aux_categories); $j++) {
                    $add_info["categories"][$j]["id"] = (int)$aux_categories[$j]->getNumber("id");
                    $add_info["categories"][$j]["title"] = $aux_categories[$j]->getString("title");
                }

            } else {
                $add_info["categories"] = null;
            }

            /**
             * Preparing friendly URL
             */
            $add_info["friendly_url"] = EVENT_DEFAULT_URL . "/" . $this->friendly_url . ".html";

            if (is_array($add_info)) {
                return $add_info;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->GetInfoToApp($array_get, $aux_returnArray, $aux_fields, $items, $auxTable, $aux_Where);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->GetInfoToApp($array_get, $aux_returnArray, $aux_fields, $items, $auxTable, $aux_Where);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name GetInfoToApp
     * @param array $array_get
     * @param array $aux_returnArray
     * @param array $aux_fields
     * @param array $items
     * @param array $auxTable
     * @param array $aux_Where
     * @access Public
     */
    public static function GetInfoToApp($array_get, &$aux_returnArray, &$aux_fields, &$items, &$auxTable, &$aux_Where)
    {

        extract($array_get);

        /**
         * Prepare columns with alias
         */
        if (is_array($aux_fields)) {

            unset($fields_to_map);

            foreach ($aux_fields as $key => $value) {
                if (strpos($value, " AS ") !== false) {
                    $fields_to_map[] = $value;
                } else {
                    $fields_to_map[] = $value . " AS `" . $key . "`";
                }
            }

        }

        if ($id) {

            /*
                 * Get Event
                 */
            unset($eventObj, $eventInfo);
            $eventObj = new Event($id);

            $eventInfo = $eventObj->getEventToApp();

            if (!is_array($eventInfo)) {

                $aux_returnArray["message"] = "No results found.";
                $aux_returnArray["type"] = $resource;
                $aux_returnArray["total_results"] = 0;
                $aux_returnArray["total_pages"] = 0;
                $aux_returnArray["results_per_page"] = 0;

            } else {
                $items[] = $eventInfo;
                $aux_returnArray["type"] = $resource;
                $aux_returnArray["total_results"] = 1;
                $aux_returnArray["total_pages"] = 1;
                $aux_returnArray["results_per_page"] = 1;
            }

        } else {

            $auxTable = "Event";
            $aux_Where[] = "status = 'A' AND ( (Event.end_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') OR Event.until_date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND repeat_event = 'N') OR (repeat_event = 'Y'))";

            if ($featured) {
                $level = implode(",", system_getLevelDetail("EventLevel"));
                if ($level) {
                    $aux_Where[] = "level IN ($level)";
                } else {
                    $aux_Where[] = "id IN (0)";
                }
            }

        }

        if ($searchBy) {
            if ($searchBy == "keyword" || $searchBy == "keyword_where") {

                unset($searchReturn);
                $searchReturn["from_tables"] = "Event";
                $searchReturn["order_by"] = "Event.level";
                $searchReturn["where_clause"] = "Event.status = 'A' ";
                $searchReturn["select_columns"] = implode(", ", $fields_to_map);
                $searchReturn["group_by"] = false;

                $letterField = "title";
                search_frontAppKeyword($array_get, $searchReturn, "Event");

                $pageObj = new pageBrowsing($searchReturn["from_tables"], $page, $aux_results_per_page,
                    $searchReturn["order_by"], $letterField, $letter, $searchReturn["where_clause"],
                    $searchReturn["select_columns"], "Event", $searchReturn["group_by"]);
                $items = $pageObj->retrievePage("array");

                if (!is_array($items)) {
                    $aux_returnArray["message"] = "No results found.";
                }

                $aux_returnArray["type"] = $resource;
                $aux_returnArray["total_results"] = $pageObj->record_amount;
                $aux_returnArray["total_pages"] = $pageObj->pages;
                $aux_returnArray["results_per_page"] = $pageObj->limit;


            } elseif ($searchBy == "map" && ($drawLat0 && $drawLat1 && $drawLong0 && $drawLong1)) {

                /**
                 * Search on map with coordinates and / or keyword
                 */
                $letterField = "title";
                $searchReturn = search_frontDrawMap($array_get, $fields_to_map, "Event");
                $pageObj = new pageBrowsing($searchReturn["from_tables"], $page, $aux_results_per_page,
                    $searchReturn["order_by"], $letterField, $letter, $searchReturn["where_clause"],
                    $searchReturn["select_columns"], "Event", $searchReturn["group_by"]);

                $items = $pageObj->retrievePage("array");

                if (!is_array($items)) {
                    $aux_returnArray["message"] = "No results found.";
                }

                $aux_returnArray["type"] = $resource;
                $aux_returnArray["total_results"] = $pageObj->record_amount;
                $aux_returnArray["total_pages"] = $pageObj->pages;
                $aux_returnArray["results_per_page"] = $pageObj->limit;


            } elseif ($searchBy == "category" && $category_id) {

                /*
                     * Get Events by category_id
                     */
                $search_for["category_id"] = $category_id;
                $searchReturn = search_frontEventSearch($search_for, "event");

                if ($searchReturn) {
                    $aux_Where[] = $searchReturn["where_clause"];
                } else {
                    $aux_returnArray["message"] = "No results found.";
                }

            } elseif ($searchBy == "calendar" && $year) {

                return $this->EventsDay($year, $month);

            } elseif ($searchBy == "calendarList" && $month && $year) {

                $search_for["single_month"] = $year . $month;
                if ($day) {
                    $search_for["day"] = $day;
                }

                $search_for["isApp"] = true;

                $searchReturn = search_frontEventSearch($search_for, "event");

                $searchReturn["select_columns"] = " id,
                                                        title,
                                                        friendly_url,
                                                        description,
                                                        long_description,
                                                        start_date,
                                                        has_start_time,
                                                        start_time,
                                                        end_date,
                                                        has_end_time,
                                                        end_time,
                                                        address,
                                                        latitude,
                                                        longitude,
                                                        url,
                                                        phone,
                                                        email,
                                                        status,
                                                        level,
                                                        recurring,
                                                        day,
                                                        dayofweek,
                                                        week,
                                                        month,
                                                        until_date,
                                                        repeat_event
                                                        ";

                $searchReturn["order_by"] = "Event.start_date";

                $pageObj = new pageBrowsing($searchReturn["from_tables"], $page, $aux_results_per_page,
                    $searchReturn["order_by"], $letterField, $letter, $searchReturn["where_clause"],
                    $searchReturn["select_columns"], "Event", $searchReturn["group_by"]);
                $items = $pageObj->retrievePage("array");

                //////////Replicate recurring events////////
                $newItems = array();

                if ($day) {
                    $startDayfor = $day;
                } else {
                    $startDayfor = 1;
                }

                $endDatefor = date('t', mktime(0, 0, 0, $month, 1, $year));

                if ($items) {

                    $counterItems = 0;
                    $startDateTimeRequest = mktime(0, 0, 0, $month, ($day ? $day : 1), $year);

                    foreach ($items as $item) {

                        if ($item["recurring"] == "Y") {

                            $newItem = $item;

                            $startDateInfo = explode("-", $item["start_date"]);
                            $startDateTime = mktime(0, 0, 0, $startDateInfo[1], $startDateInfo[2], $startDateInfo[0]);

                            if ($startDateTime < $startDateTimeRequest) {
                                unset($items[$counterItems]);
                            }
                            $counterItems++;

                            if ($item["until_date"] == "0000-00-00") { //endless event
                                $validateDate = false;
                            } else { //event with end date
                                $validateDate = true;
                                $untilDateInfo = explode("-", $item["until_date"]);
                            }

                            $i = $month;

                            if ($item["day"]) { //unique day. Ex: Monthly - Every day 1 / Yearly - Every May 1

                                if (!$item["month"] || $item["month"] == $i) { //without "month": monthly. with "month": yearly

                                    if (!$validateDate || ($validateDate && $untilDateInfo[0] > $year) || ($validateDate && ($i < $untilDateInfo[1] || ($i == $untilDateInfo[1] && $item["day"] <= $untilDateInfo[2])))) {

                                        $dateTime = mktime(0, 0, 0, $i, $item["day"], $year);

                                        $startDate = "$year-" . $i . "-" . $item["day"];

                                        $newStartDay = date('t', mktime(0, 0, 0, $i, 1, $year));

                                        if ($dateTime > $startDateTime && $startDate != $newItem["start_date"] && $item["day"] <= $newStartDay) {
                                            $newItem["start_date"] = $startDate;
                                            $newItems[] = $newItem;
                                        }

                                    }
                                }

                            } elseif (!$item["dayofweek"]) { //daily

                                for ($k = $startDayfor; $k <= $endDatefor; $k++) {

                                    if (!$validateDate || ($validateDate && $untilDateInfo[0] > $year) || ($validateDate && ($i < $untilDateInfo[1] || ($i == $untilDateInfo[1] && $k <= $untilDateInfo[2])))) {

                                        $dateTime = mktime(0, 0, 0, $i, $k, $year);

                                        $startDate = "$year-" . $i . "-" . $k;

                                        if ($dateTime > $startDateTime && $startDate != $newItem["start_date"]) {
                                            $newItem["start_date"] = $startDate;
                                            $newItems[] = $newItem;
                                        }

                                    }

                                }

                            } elseif ($item["dayofweek"]) { //determined days. Weekly: every sunday and monday / Monthly: every Monday of First Week / Yearly: every Monday of First Week of December

                                for ($k = $startDayfor; $k <= $endDatefor; $k++) {

                                    $dayOfWeek = date("w",
                                        mktime(0, 0, 0, $i, $k, $year)); //0 (for Sunday) through 6 (for Saturday)
                                    $dayOfWeek = $dayOfWeek + 1; //on database is 1 (for Sunday) through 7 (for Saturday)

                                    $daysOfWeek = explode(",",
                                        $item["dayofweek"]); //days of week when the event happens. Ex: 2,3,4...

                                    foreach ($daysOfWeek as $dayWeek) {
                                        if ($dayOfWeek == $dayWeek) { //day of week ok, continue...

                                            if (!$item["month"] || ($item["month"] && ($item["month"] == $i))) { //validate month

                                                //validate week
                                                $validWeek = false;
                                                if (!$item["week"]) {
                                                    $validWeek = true;
                                                } else {

                                                    $firstWeekMonth = date('W', mktime(0, 0, 0, $i, 1,
                                                        $year)); //week number of the year (first day)
                                                    $thisWeekMonth = date('W', mktime(0, 0, 0, $i, $k,
                                                        $year)); //week number of the year (day "$k")

                                                    $weekOntheMonth = ($thisWeekMonth - $firstWeekMonth) + 1; //week number on the month (0-4)

                                                    //fix
                                                    if ($dayOfWeek == 7 && ($k == 7 || $k == 14 || $k == 21 || $k == 28)) {
                                                        $weekOntheMonth--;
                                                    }

                                                    if ($item["week"] == $weekOntheMonth) {
                                                        $validWeek = true;
                                                    } else {
                                                        $validWeek = false;
                                                    }

                                                }

                                                if ($validWeek) {

                                                    if (!$validateDate || ($validateDate && $untilDateInfo[0] > $year) || ($validateDate && ($i < $untilDateInfo[1] || ($i == $untilDateInfo[1] && $k <= $untilDateInfo[2])))) {

                                                        $dateTime = mktime(0, 0, 0, $i, $k, $year);

                                                        $startDate = "$year-" . $i . "-" . $k;

                                                        if ($dateTime > $startDateTime && $startDate != $newItem["start_date"]) {
                                                            $newItem["start_date"] = $startDate;
                                                            $newItems[] = $newItem;
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

                    if (count($newItems) > 0) {
                        $items = array_merge($items, $newItems);
                    }
                }

                /////////////////////

                if (!$front_cal) {

                    if (!is_array($items) || !count($items)) {
                        $aux_returnArray["message"] = "No results found.";
                    }

                    $aux_returnArray["type"] = $resource;
                    $aux_returnArray["total_results"] = $pageObj->record_amount;
                    $aux_returnArray["total_pages"] = $pageObj->pages;
                    $aux_returnArray["results_per_page"] = $pageObj->limit;

                }
            } else {
                $return["type"] = $resource;
                $return["total_results"] = 0;
                $return["total_pages"] = 0;
                $return["results_per_page"] = 0;
                $return["success"] = false;
                $return["message"] = "Wrong Search, check the parameters";
                api_formatReturn($return);
            }
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $eventObj->EventsDay($year, $month);
     * <br /><br />
     *        //Using this in Event() class.
     *        $this->EventsDay($year, $month);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name EventsDay
     * @param string $year
     * @param boolean $month
     * @access Public
     */
    public static function EventsDay($year, $month = false, $front = false)
    {
        $db = db_getDBObject();

        $dateFormatKey = ($front ? "m" : "M");

        $sql = "SELECT concat(month(start_date),
                            day(start_date)) AS concat_Mon_Day,
                            day(start_date) AS day_start_date,
                            month(start_date) month_start_date
                        FROM Event
                        WHERE year(start_date) = " . $year . " AND " . ($month ? " month(start_date) = " . $month . " AND " : "") . "
                            STATUS = 'A'
                    GROUP BY month_start_date, day_start_date
                    ORDER BY " . ($front ? "day_start_date" : "month_start_date") . "";


        $result = $db->query($sql);

        $sqlRecurring = "SELECT start_date, `day`, dayofweek, week, `month`, until_date, repeat_event
                        FROM Event
                        WHERE ((year(until_date) >= " . $year . " AND " . ($month ? " month(until_date) >= " . $month . " AND " : "") . " repeat_event = 'N') OR (repeat_event = 'Y' AND until_date = '0000-00-00 00:00:00'))
                            AND status = 'A'";

        $resultRecurring = $db->query($sqlRecurring);

        /**
         * Preparing array to return
         */
        $aux_returnArray["type"] = "eventCalendar";
        $aux_returnArray["total_results"] = 12; // months
        $aux_returnArray["total_pages"] = 1;
        $aux_returnArray["results_per_page"] = 12; //months

        if (mysql_num_rows($result) || mysql_num_rows($resultRecurring)) {
            unset($arrayDayEvents);

            if (mysql_num_rows($result)) {

                while ($row = mysql_fetch_assoc($result)) {
                    $arrayDayEvents[date($dateFormatKey,
                        mktime(0, 0, 0, $row["month_start_date"], 1, $year))][] = (int)$row["day_start_date"];
                }

                for ($i = 1; $i <= 12; $i++) {

                    if (!is_array($arrayDayEvents[date($dateFormatKey, mktime(0, 0, 0, $i, 1, $year))])) {
                        $arrayDayEvents[date($dateFormatKey, mktime(0, 0, 0, $i, 1, $year))] = null;
                    }

                }

            }

            if (mysql_num_rows($resultRecurring)) {

                while ($rowRecurring = mysql_fetch_assoc($resultRecurring)) {

                    for ($i = 1; $i <= 12; $i++) {

                        $startDateInfo = explode("-", $rowRecurring["start_date"]);
                        $startDateTime = mktime(0, 0, 0, $startDateInfo[1], $startDateInfo[2], $startDateInfo[0]);

                        if ($rowRecurring["until_date"] == "0000-00-00") { //endless event
                            $validateDate = false;
                        } else { //event with end date
                            $validateDate = true;
                            $untilDateInfo = explode("-", $rowRecurring["until_date"]);
                        }

                        if ($rowRecurring["day"]) { //unique day. Ex: Monthly - Every day 1 / Yearly - Every May 1

                            if (!$rowRecurring["month"] || $rowRecurring["month"] == $i) { //without "month": monthly. with "month": yearly

                                if (!$validateDate || ($validateDate && $untilDateInfo[0] > $year) || ($validateDate && ($i < $untilDateInfo[1] || ($i == $untilDateInfo[1] && $rowRecurring["day"] <= $untilDateInfo[2])))) {

                                    $dateTime = mktime(0, 0, 0, $i, $rowRecurring["day"], $year);

                                    if ($dateTime >= $startDateTime) {
                                        $arrayDayEvents[date($dateFormatKey,
                                            mktime(0, 0, 0, $i, 1, $year))][] = (int)$rowRecurring["day"];
                                    }

                                }
                            }

                        } elseif (!$rowRecurring["dayofweek"]) { //daily

                            for ($k = 1; $k <= 31; $k++) {

                                if (!$validateDate || ($validateDate && $untilDateInfo[0] > $year) || ($validateDate && ($i < $untilDateInfo[1] || ($i == $untilDateInfo[1] && $k <= $untilDateInfo[2])))) {

                                    $dateTime = mktime(0, 0, 0, $i, $k, $year);

                                    if ($dateTime >= $startDateTime) {
                                        $arrayDayEvents[date($dateFormatKey,
                                            mktime(0, 0, 0, $i, 1, $year))][] = (int)$k;
                                    }

                                }

                            }

                        } elseif ($rowRecurring["dayofweek"]) { //determined days. Weekly: every sunday and monday / Monthly: every Monday of First Week / Yearly: every Monday of First Week of December

                            for ($k = 1; $k <= 31; $k++) {

                                $dayOfWeek = date("w",
                                    mktime(0, 0, 0, $i, $k, $year)); //0 (for Sunday) through 6 (for Saturday)
                                $dayOfWeek = $dayOfWeek + 1; //on database is 1 (for Sunday) through 7 (for Saturday)

                                $daysOfWeek = explode(",",
                                    $rowRecurring["dayofweek"]); //days of week when the event happens. Ex: 2,3,4...

                                foreach ($daysOfWeek as $dayWeek) {
                                    if ($dayOfWeek == $dayWeek) { //day of week ok, continue...

                                        if (!$rowRecurring["month"] || ($rowRecurring["month"] && ($rowRecurring["month"] == $i))) { //validate month

                                            //validate week
                                            $validWeek = false;
                                            if (!$rowRecurring["week"]) {
                                                $validWeek = true;
                                            } else {

                                                $firstWeekMonth = date('W', mktime(0, 0, 0, $i, 1,
                                                    $year)); //week number of the year (first day)
                                                $thisWeekMonth = date('W', mktime(0, 0, 0, $i, $k,
                                                    $year)); //week number of the year (day "$k")

                                                $weekOntheMonth = ($thisWeekMonth - $firstWeekMonth) + 1; //week number on the month (0-4)

                                                //fix
                                                if ($dayOfWeek == 7 && ($k == 7 || $k == 14 || $k == 21 || $k == 28)) {
                                                    $weekOntheMonth--;
                                                }

                                                if ($rowRecurring["week"] == $weekOntheMonth) {
                                                    $validWeek = true;
                                                } else {
                                                    $validWeek = false;
                                                }

                                            }

                                            if ($validWeek) {

                                                if (!$validateDate || ($validateDate && $untilDateInfo[0] > $year) || ($validateDate && ($i < $untilDateInfo[1] || ($i == $untilDateInfo[1] && $k <= $untilDateInfo[2])))) {

                                                    $dateTime = mktime(0, 0, 0, $i, $k, $year);

                                                    if ($dateTime >= $startDateTime) {
                                                        $arrayDayEvents[date($dateFormatKey,
                                                            mktime(0, 0, 0, $i, 1, $year))][] = (int)$k;
                                                    }

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (is_array($arrayDayEvents[date($dateFormatKey, mktime(0, 0, 0, $i, 1, $year))])) {
                            $arrayDayEvents[date($dateFormatKey,
                                mktime(0, 0, 0, $i, 1, $year))] = array_unique($arrayDayEvents[date($dateFormatKey,
                                mktime(0, 0, 0, $i, 1, $year))], SORT_REGULAR);
                            sort($arrayDayEvents[date($dateFormatKey, mktime(0, 0, 0, $i, 1, $year))], SORT_REGULAR);
                        }
                    }

                }

            }

            if (is_array($arrayDayEvents)) {
                ksort($arrayDayEvents);
                $aux_returnArray["results"] = $arrayDayEvents;
                if ($front) {
                    return $arrayDayEvents;
                } else {
                    return $aux_returnArray;
                }
            } else {
                $aux_returnArray["message"] = "No results found.";

                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Cleans event cache used in
     *
     * @return void
     */
    private function cleanCacheEvent()
    {
        /* clean upcoming event cache used in front(symfony) */
        $cacheDriver = SymfonyCore::getContainer()->get('apccache.edirectory.service');
        $date = new \DateTime('now');
        for($i = 0; $i < 30; $i++) {
            $date->modify('+'.$i.' day');
            $key = '_upcoming_' . $date->format('Ymd');
            $cacheDriver->delete($key);
        }
        /***********/
    }
}
