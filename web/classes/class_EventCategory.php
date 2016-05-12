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
# * FILE: /classes/class_eventCategory.php
# ----------------------------------------------------------------------------------------------------

class EventCategory extends Handle
{
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
    var $page_title;
    /**
     * @var string
     * @access Private
     */
    var $friendly_url;
    /**
     * @var integer
     * @access Private
     */
    var $category_id;
    /**
     * @var integer
     * @access Private
     */
    var $image_id;
    /**
     * @var integer
     * @access Private
     */
    var $thumb_id;
    /**
     * @var char
     * @access Private
     */
    var $featured;
    /**
     * @var string
     * @access Private
     */
    var $summary_description;
    /**
     * @var string
     * @access Private
     */
    var $seo_description;
    /**
     * @var string
     * @access Private
     */
    var $keywords;
    /**
     * @var string
     * @access Private
     */
    var $seo_keywords;
    /**
     * @var string
     * @access Private
     */
    var $content;
    /**
     * @var integer
     * @access Private
     */
    var $active_event;
    /**
     * @var char
     * @access Private
     */
    var $enabled;

    function EventCategory($var = '')
    {
        if (is_numeric($var) && ($var)) {
            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if (defined("SELECTED_DOMAIN_ID")) {
                $db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $db = db_getDBObject();
            }

            unset($dbMain);
            $sql = "SELECT * FROM EventCategory WHERE id = $var";
            $row = mysql_fetch_array($db->query($sql));
            $this->makeFromRow($row);
        } else {
            if (!is_array($var)) {
                $var = array();
            }
            $this->makeFromRow($var);
        }
    }

    function makeFromRow($row = '')
    {
        $this->id = ($row["id"]) ? $row["id"] : ($this->id ? $this->id : 0);
        $this->title = ($row["title"]) ? $row["title"] : ($this->title ? $this->title : "");
        $this->page_title = ($row["page_title"]) ? $row["page_title"] : ($this->page_title ? $this->page_title : "");
        $this->friendly_url = ($row["friendly_url"]) ? $row["friendly_url"] : ($this->friendly_url ? $this->friendly_url : "");
        $this->category_id = ($row["category_id"]) ? $row["category_id"] : ($this->category_id ? $this->category_id : 0);
        $this->featured = ($row["featured"]) ? $row["featured"] : ($this->featured ? $this->featured : "n");
        $this->summary_description = ($row["summary_description"]) ? $row["summary_description"] : "";
        $this->seo_description = ($row["seo_description"]) ? $row["seo_description"] : "";
        $this->keywords = ($row["keywords"]) ? $row["keywords"] : ($this->keywords ? $this->keywords : "");
        $this->seo_keywords = ($row["seo_keywords"]) ? $row["seo_keywords"] : "";
        $this->content = ($row["content"]) ? $row["content"] : "";
        $this->active_event = ($row["active_event"]) ? $row["active_event"] : ($this->active_event ? $this->active_event : 0);
        $this->enabled = ($row["enabled"]) ? $row["enabled"] : ($this->enabled ? $this->enabled : "n");

        if ($row["image_id"]) {
            $this->image_id = $row["image_id"];
        } else {
            if (!$this->image_id) {
                $this->image_id = 0;
            }
        }

        if ($row["thumb_id"]) {
            $this->thumb_id = $row["thumb_id"];
        } else {
            if (!$this->thumb_id) {
                $this->thumb_id = 0;
            }
        }
    }

    function Save()
    {
        $this->prepareToSave();

        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);

        $this->friendly_url = string_strtolower($this->friendly_url);

        if ($this->id) {

            $sql = "UPDATE EventCategory SET"
                . " title = $this->title,"
                . " page_title = $this->page_title,"
                . " friendly_url = $this->friendly_url,"
                . " category_id = $this->category_id,"
                . " image_id = $this->image_id,"
                . " thumb_id = $this->thumb_id,"
                . " featured = $this->featured,"
                . " summary_description = $this->summary_description,"
                . " seo_description = $this->seo_description,"
                . " keywords = $this->keywords,"
                . " seo_keywords = $this->seo_keywords,"
                . " content = $this->content,"
                . " enabled = $this->enabled,"
                . " active_event = $this->active_event"
                . " WHERE id = $this->id";
            $dbObj->query($sql);

        } else {

            $sql = "INSERT INTO EventCategory"
                . " (title,"
                . " page_title,"
                . " friendly_url,"
                . " category_id,"
                . " image_id,"
                . " thumb_id,"
                . " featured,"
                . " summary_description,"
                . " seo_description,"
                . " keywords,"
                . " seo_keywords,"
                . " content,"
                . " enabled,"
                . " active_event)"
                . " VALUES"
                . " ($this->title,"
                . " $this->page_title,"
                . " $this->friendly_url,"
                . " $this->category_id,"
                . " $this->image_id,"
                . " $this->thumb_id,"
                . " $this->featured,"
                . " $this->summary_description,"
                . " $this->seo_description,"
                . " $this->keywords,"
                . " $this->seo_keywords,"
                . " $this->content,"
                . " $this->enabled,"
                . " $this->active_event)";

            $dbObj->query($sql);
            $this->id = mysql_insert_id($dbObj->link_id);
        }

        $this->prepareToUse();

        /*
         * Count Sub Categories to APP
         */
        $this->countSubCatToApp();

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("event.category.synchronization")->addUpsert($this->id);
        }
    }

    function updateImage($imageArray)
    {
        unset($imageObj);
        if ($this->image_id) {
            $imageobj = new Image($this->image_id);
            if ($imageobj) {
                $imageobj->delete();
            }
        }
        $this->image_id = $imageArray["image_id"];
        unset($imageObj);
        if ($this->thumb_id) {
            $imageObj = new Image($this->thumb_id);
            if ($imageObj) {
                $imageObj->delete();
            }
        }
        $this->thumb_id = $imageArray["thumb_id"];
        unset($imageObj);
    }

    function Delete()
    {

        if ($this->id != 0) {

            foreach ($this->getFullPath() as $cat_path) {
                $cat_id[] = $cat_path["id"];
            }

            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }

            unset($dbMain);

            $sql = "SELECT * FROM EventCategory WHERE category_id = {$this->id}";
            $r = $dbObj->query($sql);

            while ($row = mysql_fetch_array($r)) {

                $sql = "SELECT * FROM EventCategory WHERE category_id = {$row["id"]}";
                $r2 = $dbObj->query($sql);

                while ($row2 = mysql_fetch_array($r2)) {

                    $sql = "SELECT * FROM EventCategory WHERE category_id = {$row2["id"]}";
                    $r3 = $dbObj->query($sql);

                    while ($row3 = mysql_fetch_array($r3)) {

                        $sql = "SELECT * FROM EventCategory WHERE category_id = {$row3["id"]}";
                        $r4 = $dbObj->query($sql);

                        while ($row4 = mysql_fetch_array($r4)) {

                            $sql = "UPDATE Event SET cat_1_id = 0, parcat_1_level1_id = 0, parcat_1_level2_id = 0, parcat_1_level3_id = 0, parcat_1_level4_id = 0 WHERE cat_1_id = {$row4["id"]}";
                            $dbObj->query($sql);
                            $sql = "UPDATE Event SET cat_2_id = 0, parcat_2_level1_id = 0, parcat_2_level2_id = 0, parcat_2_level3_id = 0, parcat_2_level4_id = 0 WHERE cat_2_id = {$row4["id"]}";
                            $dbObj->query($sql);
                            $sql = "UPDATE Event SET cat_3_id = 0, parcat_3_level1_id = 0, parcat_3_level2_id = 0, parcat_3_level3_id = 0, parcat_3_level4_id = 0 WHERE cat_3_id = {$row4["id"]}";
                            $dbObj->query($sql);
                            $sql = "UPDATE Event SET cat_4_id = 0, parcat_4_level1_id = 0, parcat_4_level2_id = 0, parcat_4_level3_id = 0, parcat_4_level4_id = 0 WHERE cat_4_id = {$row4["id"]}";
                            $dbObj->query($sql);
                            $sql = "UPDATE Event SET cat_5_id = 0, parcat_5_level1_id = 0, parcat_5_level2_id = 0, parcat_5_level3_id = 0, parcat_5_level4_id = 0 WHERE cat_5_id = {$row4["id"]}";
                            $dbObj->query($sql);
                        }

                        $sql = "UPDATE Event SET cat_1_id = 0, parcat_1_level1_id = 0, parcat_1_level2_id = 0, parcat_1_level3_id = 0, parcat_1_level4_id = 0 WHERE cat_1_id = {$row3["id"]}";
                        $dbObj->query($sql);
                        $sql = "UPDATE Event SET cat_2_id = 0, parcat_2_level1_id = 0, parcat_2_level2_id = 0, parcat_2_level3_id = 0, parcat_2_level4_id = 0 WHERE cat_2_id = {$row3["id"]}";
                        $dbObj->query($sql);
                        $sql = "UPDATE Event SET cat_3_id = 0, parcat_3_level1_id = 0, parcat_3_level2_id = 0, parcat_3_level3_id = 0, parcat_3_level4_id = 0 WHERE cat_3_id = {$row3["id"]}";
                        $dbObj->query($sql);
                        $sql = "UPDATE Event SET cat_4_id = 0, parcat_4_level1_id = 0, parcat_4_level2_id = 0, parcat_4_level3_id = 0, parcat_4_level4_id = 0 WHERE cat_4_id = {$row3["id"]}";
                        $dbObj->query($sql);
                        $sql = "UPDATE Event SET cat_5_id = 0, parcat_5_level1_id = 0, parcat_5_level2_id = 0, parcat_5_level3_id = 0, parcat_5_level4_id = 0 WHERE cat_5_id = {$row3["id"]}";
                        $dbObj->query($sql);
                    }

                    $sql = "UPDATE Event SET cat_1_id = 0, parcat_1_level1_id = 0, parcat_1_level2_id = 0, parcat_1_level3_id = 0, parcat_1_level4_id = 0 WHERE cat_1_id = {$row2["id"]}";
                    $dbObj->query($sql);
                    $sql = "UPDATE Event SET cat_2_id = 0, parcat_2_level1_id = 0, parcat_2_level2_id = 0, parcat_2_level3_id = 0, parcat_2_level4_id = 0 WHERE cat_2_id = {$row2["id"]}";
                    $dbObj->query($sql);
                    $sql = "UPDATE Event SET cat_3_id = 0, parcat_3_level1_id = 0, parcat_3_level2_id = 0, parcat_3_level3_id = 0, parcat_3_level4_id = 0 WHERE cat_3_id = {$row2["id"]}";
                    $dbObj->query($sql);
                    $sql = "UPDATE Event SET cat_4_id = 0, parcat_4_level1_id = 0, parcat_4_level2_id = 0, parcat_4_level3_id = 0, parcat_4_level4_id = 0 WHERE cat_4_id = {$row2["id"]}";
                    $dbObj->query($sql);
                    $sql = "UPDATE Event SET cat_5_id = 0, parcat_5_level1_id = 0, parcat_5_level2_id = 0, parcat_5_level3_id = 0, parcat_5_level4_id = 0 WHERE cat_5_id = {$row2["id"]}";
                    $dbObj->query($sql);
                }

                $sql = "UPDATE Event SET cat_1_id = 0, parcat_1_level1_id = 0, parcat_1_level2_id = 0, parcat_1_level3_id = 0, parcat_1_level4_id = 0 WHERE cat_1_id = {$row["id"]}";
                $dbObj->query($sql);
                $sql = "UPDATE Event SET cat_2_id = 0, parcat_2_level1_id = 0, parcat_2_level2_id = 0, parcat_2_level3_id = 0, parcat_2_level4_id = 0 WHERE cat_2_id = {$row["id"]}";
                $dbObj->query($sql);
                $sql = "UPDATE Event SET cat_3_id = 0, parcat_3_level1_id = 0, parcat_3_level2_id = 0, parcat_3_level3_id = 0, parcat_3_level4_id = 0 WHERE cat_3_id = {$row["id"]}";
                $dbObj->query($sql);
                $sql = "UPDATE Event SET cat_4_id = 0, parcat_4_level1_id = 0, parcat_4_level2_id = 0, parcat_4_level3_id = 0, parcat_4_level4_id = 0 WHERE cat_4_id = {$row["id"]}";
                $dbObj->query($sql);
                $sql = "UPDATE Event SET cat_5_id = 0, parcat_5_level1_id = 0, parcat_5_level2_id = 0, parcat_5_level3_id = 0, parcat_5_level4_id = 0 WHERE cat_5_id = {$row["id"]}";
                $dbObj->query($sql);
            }

            $sql = "UPDATE Event SET cat_1_id = 0, parcat_1_level1_id = 0, parcat_1_level2_id = 0, parcat_1_level3_id = 0, parcat_1_level4_id = 0 WHERE cat_1_id = $this->id";
            $dbObj->query($sql);
            $sql = "UPDATE Event SET cat_2_id = 0, parcat_2_level1_id = 0, parcat_2_level2_id = 0, parcat_2_level3_id = 0, parcat_2_level4_id = 0 WHERE cat_2_id = $this->id";
            $dbObj->query($sql);
            $sql = "UPDATE Event SET cat_3_id = 0, parcat_3_level1_id = 0, parcat_3_level2_id = 0, parcat_3_level3_id = 0, parcat_3_level4_id = 0 WHERE cat_3_id = $this->id";
            $dbObj->query($sql);
            $sql = "UPDATE Event SET cat_4_id = 0, parcat_4_level1_id = 0, parcat_4_level2_id = 0, parcat_4_level3_id = 0, parcat_4_level4_id = 0 WHERE cat_4_id = $this->id";
            $dbObj->query($sql);
            $sql = "UPDATE Event SET cat_5_id = 0, parcat_5_level1_id = 0, parcat_5_level2_id = 0, parcat_5_level3_id = 0, parcat_5_level4_id = 0 WHERE cat_5_id = $this->id";
            $dbObj->query($sql);

            /* In here we'll collect all categories which will meet their doom */
            $categoryDump[] = $this->id;

            $sql = "SELECT * FROM EventCategory WHERE category_id = {$this->id}";
            $r = $dbObj->query($sql);

            while ($row = mysql_fetch_array($r)) {

                $sql = "SELECT * FROM EventCategory WHERE category_id = {$row["id"]}";
                $r2 = $dbObj->query($sql);

                while ($row2 = mysql_fetch_array($r2)) {

                    $sql = "SELECT * FROM EventCategory WHERE category_id = {$row2["id"]}";
                    $r3 = $dbObj->query($sql);

                    while ($row3 = mysql_fetch_array($r3)) {

                        $sql = "SELECT * FROM EventCategory WHERE category_id = {$row3["id"]}";
                        $r4 = $dbObj->query($sql);

                        while ($row4 = mysql_fetch_array($r4)) {
                            $categoryDump[] = $row4["id"];
                            $sql = "DELETE FROM EventCategory WHERE id = {$row4["id"]}";
                            $dbObj->query($sql);
                        }

                        $categoryDump[] = $row3["id"];
                        $sql = "DELETE FROM EventCategory WHERE id = {$row3["id"]}";
                        $dbObj->query($sql);
                    }

                    $categoryDump[] = $row2["id"];
                    $sql = "DELETE FROM EventCategory WHERE id = {$row2["id"]}";
                    $dbObj->query($sql);
                }

                $categoryDump[] = $row["id"];
                $sql = "DELETE FROM EventCategory WHERE id = {$row["id"]}";
                $dbObj->query($sql);
            }

            $categoryDump[] = $this->id;
            $sql = "DELETE FROM EventCategory WHERE id = $this->id LIMIT 1";
            $dbObj->query($sql);

            $sql = "UPDATE Banner SET category_id = 0 WHERE category_id = $this->id AND section = 'event'";
            $dbObj->query($sql);

            $this->updateFullTextItems();
            system_countActiveItemByCategory("event", "", "", $cat_id);

            if ($symfonyContainer = SymfonyCore::getContainer()) {
                $symfonyContainer->get("event.category.synchronization")->addDelete($categoryDump);
            }
        }

        /*
         * Count Sub Categories to APP
         */
        $this->countSubCatToApp();

    }

    function retrieveAllCategories($featured = '')
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "SELECT * FROM EventCategory WHERE category_id = '0'";
        if ($featured == "on") {
            $sql .= " AND featured = 'y'";
        }
        $sql .= "  AND enabled = 'y' ORDER BY title";
        $result = $dbObj->query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    function retrieveAllSubCatById($id = '', $featured = '')
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "SELECT * FROM EventCategory WHERE category_id = $id";
        if ($featured == "on") {
            $sql .= " AND featured = 'y'";
        }
        $sql .= "  AND enabled = 'y' ORDER BY title";
        $result = $dbObj->query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $data[] = $row;
        }
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    function getLevel()
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $cat_level = 0;
        $category_id = $this->getString("id");
        while ($category_id != 0) {
            $sql = "SELECT category_id FROM EventCategory WHERE id = $category_id";
            $result = $dbObj->query($sql);
            $row = mysql_fetch_assoc($result);
            $category_id = $row["category_id"];
            $cat_level++;
        }

        return $cat_level;
    }

    function getFullPath()
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);

        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);

        $fields = "`id`, `category_id`, `active_event`, `featured`, `enabled`, `friendly_url`, `title`";

        $category_id = $this->id;
        $i = 0;

        while ($category_id != 0) {
            $sql = "SELECT $fields FROM EventCategory WHERE id = $category_id";
            $result = $dbObj->query($sql);
            $row = mysql_fetch_assoc($result);
            $path[$i]["id"] = $row["id"];
            $path[$i]["dad"] = $row["category_id"];
            $path[$i]["title"] = $row["title"];
            $path[$i]["friendly_url"] = $row["friendly_url"];
            $path[$i]["active_event"] = $row["active_event"];
            $path[$i]["featured"] = $row["featured"];
            $path[$i]["enabled"] = $row["enabled"];
            $i++;
            $category_id = $row["category_id"];
        }

        if ($path) {
            $path = array_reverse($path);
            for ($i = 0; $i < count($path); $i++) {
                $path[$i]["level"] = $i + 1;
            }

            return ($path);
        } else {
            return false;
        }
    }

    function updateFullTextItems()
    {

        if ($this->id) {

            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if (defined("SELECTED_DOMAIN_ID")) {
                $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $dbObj = db_getDBObject();
            }

            unset($dbMain);

            $category_id = $this->id;

            $sql = "SELECT id
                    FROM Event
                    WHERE
                        (
                            cat_1_id = {$category_id}
                            OR parcat_1_level1_id = {$category_id}
                            OR parcat_1_level2_id = {$category_id}
                            OR parcat_1_level3_id = {$category_id}
                            OR parcat_1_level4_id = {$category_id}
                            OR cat_2_id = {$category_id}
                            OR parcat_2_level1_id = {$category_id}
                            OR parcat_2_level2_id = {$category_id}
                            OR parcat_2_level3_id = {$category_id}
                            OR parcat_2_level4_id = {$category_id}
                            OR cat_3_id = {$category_id}
                            OR parcat_3_level1_id = {$category_id}
                            OR parcat_3_level2_id = {$category_id}
                            OR parcat_3_level3_id = {$category_id}
                            OR parcat_3_level4_id = {$category_id}
                            OR cat_4_id = {$category_id}
                            OR parcat_4_level1_id = {$category_id}
                            OR parcat_4_level2_id = {$category_id}
                            OR parcat_4_level3_id = {$category_id}
                            OR parcat_4_level4_id = {$category_id}
                            OR cat_5_id = {$category_id}
                            OR parcat_5_level1_id = {$category_id}
                            OR parcat_5_level2_id = {$category_id}
                            OR parcat_5_level3_id = {$category_id}
                            OR parcat_5_level4_id = {$category_id}
                        )";

            $result = $dbObj->query($sql);

            while ($row = mysql_fetch_array($result)) {
                if ($row['id']) {
                    $eventObj = new Event($row['id']);
                    $eventObj->setFullTextSearch();
                    unset($eventObj);
                }
            }

            return true;
        }

        return false;
    }

    function setFeatured()
    {
        if (!$this->id) {
            return false;
        }
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "UPDATE EventCategory SET featured='y'  WHERE id=$this->id";

        return $dbObj->query($sql);
    }

    /*
     * Function to number of subcategories to App
     */
    function countSubCatToApp()
    {

        if ($this->category_id == 0) {
            $sql = "SELECT id FROM EventCategory WHERE category_id = " . $this->id;
            $aux_id = $this->id;
        } elseif ($this->id) {
            $sql = "SELECT id FROM EventCategory WHERE category_id = " . $this->category_id;
            $aux_id = $this->category_id;
        }

        if ($aux_id) {

            $dbMain = db_getDBObject(DEFAULT_DB, true);
            if (defined("SELECTED_DOMAIN_ID")) {
                $db = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
            } else {
                $db = db_getDBObject();
            }
            unset($dbMain);

            $result = $db->query($sql);
            $total = mysql_num_rows($result);

            $update_sql = "UPDATE EventCategory SET count_sub = " . $total . " WHERE id = " . $aux_id;
            $result_update = $db->query($update_sql);

        }
    }

    /**
     * Function to prepare content to App
     * @return array
     */
    public static function GetInfoToApp($array_get, &$aux_returnArray, &$aux_fields, &$items, &$auxTable, &$aux_Where)
    {

        extract($array_get);

        $auxTable = "EventCategory";

        /**
         * Fields to Event
         */
        // Label = value (field on DB);
        $aux_fields["id"] = "id";
        $aux_fields["title"] = "title";
        $aux_fields["active_items"] = "active_event";
        $aux_fields["father_id"] = "category_id";
        $aux_fields["total_sub"] = "count_sub";

        $aux_Where[] = "enabled = 'y'";

        if ($father_id && is_numeric($father_id)) {
            $aux_Where[] = "category_id =" . $father_id;
        } else {
            $aux_Where[] = "category_id = 0";
        }
    }
}
