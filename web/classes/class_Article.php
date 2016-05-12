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
# * FILE: /classes/class_Article.php
# ----------------------------------------------------------------------------------------------------

class Article extends Handle
{
    var $id;
    var $account_id;
    var $image_id;
    var $thumb_id;
    var $cover_id;
    var $updated;
    var $entered;
    var $renewal_date;
    var $discount_id;
    var $title;
    var $seo_title;
    var $friendly_url;
    var $author;
    var $author_url;
    var $publication_date;
    var $abstract;
    var $seo_abstract;
    var $content;
    var $keywords;
    var $seo_keywords;
    var $status;
    var $suspended_sitemgr;
    var $level;
    var $number_views;
    var $avg_review;
    var $data_in_array;
    var $domain_id;
    var $package_id;
    var $package_price;

    /**
     * <code>
     *        $articleObj = new Article($id);
     * <code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name Article
     * @access Public
     * @param integer $var
     */
    function Article($var = "", $domain_id = false)
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
            $sql = "SELECT * FROM Article WHERE id = $var";
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
     * @name makeFromRow
     * @access Public
     * @param array $row
     */
    function makeFromRow($row = "")
    {

        $status = new ItemStatus();
        $level = new ArticleLevel();

        $this->id = ($row["id"]) ? $row["id"] : ($this->id ? $this->id : 0);
        $this->account_id = ($row["account_id"]) ? $row["account_id"] : 0;
        $this->image_id = ($row["image_id"]) ? $row["image_id"] : ($this->image_id ? $this->image_id : 0);
        $this->thumb_id = ($row["thumb_id"]) ? $row["thumb_id"] : ($this->thumb_id ? $this->thumb_id : 0);
        $this->cover_id = ($row["cover_id"]) ? $row["cover_id"] : ($this->cover_id ? $this->cover_id : 0);
        $this->updated = ($row["updated"]) ? $row["updated"] : ($this->updated ? $this->updated : "");
        $this->entered = ($row["entered"]) ? $row["entered"] : ($this->entered ? $this->entered : "");
        $this->renewal_date = ($row["renewal_date"]) ? $row["renewal_date"] : ($this->renewal_date ? $this->renewal_date : 0);
        $this->discount_id = ($row["discount_id"]) ? $row["discount_id"] : "";
        $this->title = ($row["title"]) ? $row["title"] : ($this->title ? $this->title : "");
        $this->seo_title = ($row["seo_title"]) ? $row["seo_title"] : ($this->seo_title ? $this->seo_title : "");
        $this->friendly_url = ($row["friendly_url"]) ? $row["friendly_url"] : "";
        $this->author = ($row["author"]) ? $row["author"] : "";
        $this->author_url = ($row["author_url"]) ? $row["author_url"] : "";
        $this->publication_date = ($row["publication_date"]) ? $row["publication_date"] : 0;
        $this->abstract = ($row["abstract"]) ? $row["abstract"] : "";
        $this->seo_abstract = ($row["seo_abstract"]) ? $row["seo_abstract"] : ($this->seo_abstract ? $this->seo_abstract : "");
        $this->content = ($row["content"]) ? $row["content"] : "";
        $this->keywords = ($row["keywords"]) ? $row["keywords"] : "";
        $this->seo_keywords = ($row["seo_keywords"]) ? $row["seo_keywords"] : ($this->seo_keywords ? $this->seo_keywords : "");
        $this->status = ($row["status"]) ? $row["status"] : $status->getDefaultStatus();
        $this->suspended_sitemgr = ($row["suspended_sitemgr"]) ? $row["suspended_sitemgr"] : ($this->suspended_sitemgr ? $this->suspended_sitemgr : "n");
        $this->level = ($row["level"]) ? $row["level"] : ($this->level ? $this->level : $level->getDefaultLevel());
        $this->number_views = ($row["number_views"]) ? $row["number_views"] : ($this->number_views ? $this->number_views : 0);
        $this->avg_review = ($row["avg_review"]) ? $row["avg_review"] : ($this->avg_review ? $this->avg_review : 0);
        $this->data_in_array = $row;
        $this->package_id = ($row["package_id"]) ? $row["package_id"] : ($this->package_id ? $this->package_id : 0);
        $this->package_price = ($row["package_price"]) ? $row["package_price"] : ($this->package_price ? $this->package_price : 0);

    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->Save();
     * <br /><br />
     *        //Using this in Article() class.
     *        $this->Save();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name Save
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
            $sql = "SELECT status, publication_date FROM Article WHERE id = $this->id";
            $result = $dbObj->query($sql);
            if ($row = mysql_fetch_assoc($result)) {
                $last_status = $row["status"];
                $last_publication_date = $row["publication_date"];
            }
            $this_status = $this->status;
            $this_id = $this->id;

            $sql = "UPDATE Article SET"
                . " account_id          = $this->account_id,"
                . " image_id            = $this->image_id,"
                . " thumb_id            = $this->thumb_id,"
                . " cover_id            = $this->cover_id,"
                . " updated             = NOW(),"
                . " renewal_date        = $this->renewal_date,"
                . " discount_id         = $this->discount_id,"
                . " title               = $this->title,"
                . " seo_title           = $this->seo_title,"
                . " friendly_url        = $this->friendly_url,"
                . " author              = $this->author,"
                . " author_url          = $this->author_url,"
                . " publication_date    = $this->publication_date,"
                . " abstract            = $this->abstract,"
                . " seo_abstract        = $this->seo_abstract,"
                . " content             = $this->content,"
                . " keywords            = $this->keywords,"
                . " seo_keywords        = $this->seo_keywords,"
                . " status              = $this->status,"
                . " suspended_sitemgr   = $this->suspended_sitemgr,"
                . " level               = $this->level,"
                . " number_views        = $this->number_views,"
                . " avg_review          = $this->avg_review,"
                . " package_id          = $this->package_id,"
                . " package_price       = $this->package_price"
                . " WHERE id            = $this->id";

            $dbObj->query($sql);

            $last_status = str_replace("\"", "", $last_status);
            $last_status = str_replace("'", "", $last_status);
            $this_status = str_replace("\"", "", $this_status);
            $this_status = str_replace("'", "", $this_status);
            $this_id = str_replace("\"", "", $this_id);
            $this_id = str_replace("'", "", $this_id);

            /////
            $lastpublicationDateStr = explode("-", $last_publication_date);
            $publicationDateStr = explode("-", $this->publication_date);

            $lastpublicationDateStr = $lastpublicationDateStr[0] . $lastpublicationDateStr[1] . $lastpublicationDateStr[2];
            $publicationDateStr = $publicationDateStr[0] . $publicationDateStr[1] . $publicationDateStr[2];
            $publicationDateStr = str_replace("'", "", $publicationDateStr);
            ////

            $incCheck = false;
            $decCheck1 = false;
            $decCheck2 = false;

            /**
             * <Lucas Trentim (2015)>
             * @todo: The way dates are being compared aren't really recommended, as soon as we get to
             * php version 5.3, we should use DateTime to treat all date and time related issues.
             */

            //if end_date/until_date is in the past and item status = A, category_count doesn't need changes, because daily_maintenance already did.
            //only change the counter if sitemgr/member corrects the date to future
            if (($last_status == "A" && $this_status == "A") && ($lastpublicationDateStr > date("Ymd") && $publicationDateStr <= date("Ymd"))) {
                $incCheck = true;
            }

            if (($last_status == "A" && $this_status != "A") && ($lastpublicationDateStr > date("Ymd") && $publicationDateStr > date("Ymd"))) {
                $decCheck1 = true; //doesn't need any changes
            }

            if (($last_status != "A" && $this_status == "A") && ($lastpublicationDateStr > date("Ymd") && $publicationDateStr > date("Ymd"))) {
                $decCheck2 = true; //doesn't need any changes
            }

            if ($incCheck) {
                system_countActiveItemByCategory("article", $this_id, "inc");
            }
            if (($this_status == "A") && ($last_status != "A") && !$decCheck2) {
                system_countActiveItemByCategory("article", $this_id, "inc");
            } elseif (($last_status == "A") && ($this_status != "A") && !$decCheck1) {
                system_countActiveItemByCategory("article", $this_id, "dec");
            }

            if ($aux_old_account != $aux_account && $aux_account != 0) {
                domain_SaveAccountInfoDomain($aux_account, $this);
            }

        } else {
            $aux_seoDescription = $this->abstract;
            $aux_seoDescription = str_replace(array("\r\n", "\n"), " ", $aux_seoDescription);
            $aux_seoDescription = str_replace("\\\"", "", $aux_seoDescription);

            $sql = "INSERT INTO Article"
                . " (account_id,"
                . " image_id,"
                . " thumb_id,"
                . " cover_id,"
                . " updated,"
                . " entered,"
                . " renewal_date,"
                . " discount_id,"
                . " title,"
                . " seo_title,"
                . " friendly_url,"
                . " author,"
                . " author_url,"
                . " publication_date,"
                . " abstract,"
                . " seo_abstract,"
                . " content,"
                . " keywords,"
                . " seo_keywords,"
                . " fulltextsearch_keyword,"
                . " fulltextsearch_where,"
                . " status,"
                . " level,"
                . " number_views,"
                . " avg_review,"
                . " package_id,"
                . " package_price)"
                . " VALUES"
                . " ($this->account_id,"
                . " $this->image_id,"
                . " $this->thumb_id,"
                . " $this->cover_id,"
                . " NOW(),"
                . " NOW(),"
                . " $this->renewal_date,"
                . " $this->discount_id,"
                . " $this->title,"
                . " $this->title,"
                . " $this->friendly_url,"
                . " $this->author,"
                . " $this->author_url,"
                . " $this->publication_date,"
                . " $this->abstract,"
                . " $aux_seoDescription,"
                . " $this->content,"
                . " $this->keywords,"
                . " " . str_replace(" || ", ", ", $this->keywords) . ","
                . " '',"
                . " '',"
                . " $this->status,"
                . " $this->level,"
                . " $this->number_views,"
                . " $this->avg_review,"
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
                system_countActiveItemByCategory("article", $this_id, "inc");
            }

            if ($aux_account != 0) {
                domain_SaveAccountInfoDomain($aux_account, $this);
            }

        }

        if ((sess_getAccountIdFromSession() && string_strpos($_SERVER["PHP_SELF"],
                    "article.php") !== false) || string_strpos($_SERVER["PHP_SELF"], "order_") !== false
        ) {
            $rowTimeline = array();
            $rowTimeline["item_type"] = "article";
            $rowTimeline["action"] = ($updateItem ? "edit" : "new");
            $rowTimeline["item_id"] = str_replace("'", "", $this->id);
            $timelineObj = new Timeline($rowTimeline);
            $timelineObj->save();
        }

        $this->prepareToUse();

        $this->setFullTextSearch();

    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->Delete();
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
        ### ARTICLE CATEGORY
        if ($this->status == "A") {
            system_countActiveItemByCategory("article", $this->id, "dec", false, $domain_id);
        }

        ### REVIEWS
        $sql = "SELECT id FROM Review WHERE item_type='article' AND item_id= $this->id";
        $result = $dbObj->query($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $reviewObj = new Review($row["id"]);
            $reviewObj->Delete($domain_id);
        }

        ### GALERY
        $sql = "SELECT gallery_id FROM Gallery_Item WHERE item_id = $this->id AND item_type = 'article'";
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
        $sql = "UPDATE Invoice_Article SET article_id = '0' WHERE article_id = $this->id";
        $dbObj->query($sql);

        ### PAYMENT
        $sql = "UPDATE Payment_Article_Log SET article_id = '0' WHERE article_id = $this->id";
        $dbObj->query($sql);

        ### Timeline
        $sql = "DELETE FROM Timeline WHERE item_type = 'article' AND item_id = $this->id";
        $dbObj->query($sql);

        ### ARTICLE
        $sql = "DELETE FROM Article WHERE id = $this->id";
        $dbObj->query($sql);

        if ($domain_id) {
            $domain_idDash = $domain_id;
        } else {
            $domain_idDash = SELECTED_DOMAIN_ID;
        }

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("article.synchronization")->addDelete($this->id);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->getCategories();
     * <br /><br />
     *        //Using this in Article() class.
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
        $sql = "SELECT cat_1_id, cat_2_id, cat_3_id, cat_4_id, cat_5_id FROM Article WHERE id = $this->id";
        $r = $dbObj->query($sql);
        while ($row = mysql_fetch_array($r)) {
            if ($row["cat_1_id"]) {
                $categories[] = new ArticleCategory($row["cat_1_id"]);
            }
            if ($row["cat_2_id"]) {
                $categories[] = new ArticleCategory($row["cat_2_id"]);
            }
            if ($row["cat_3_id"]) {
                $categories[] = new ArticleCategory($row["cat_3_id"]);
            }
            if ($row["cat_4_id"]) {
                $categories[] = new ArticleCategory($row["cat_4_id"]);
            }
            if ($row["cat_5_id"]) {
                $categories[] = new ArticleCategory($row["cat_5_id"]);
            }
        }

        return $categories;
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->setCategories();
     * <br /><br />
     *        //Using this in Article() class.
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
            system_countActiveItemByCategory("article", $this->id, "dec");
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
                        $sql = "SELECT * FROM ArticleCategory WHERE id = $cat_id";
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
        $sql = "UPDATE Article SET cat_1_id = " . $cat_1_id . ", parcat_1_level1_id = " . $parcat_1_level1_id . ", parcat_1_level2_id = " . $parcat_1_level2_id . ", parcat_1_level3_id = " . $parcat_1_level3_id . ", parcat_1_level4_id = " . $parcat_1_level4_id . ", cat_2_id = " . $cat_2_id . ", parcat_2_level1_id = " . $parcat_2_level1_id . ", parcat_2_level2_id = " . $parcat_2_level2_id . ", parcat_2_level3_id = " . $parcat_2_level3_id . ", parcat_2_level4_id = " . $parcat_2_level4_id . ", cat_3_id = " . $cat_3_id . ", parcat_3_level1_id = " . $parcat_3_level1_id . ", parcat_3_level2_id = " . $parcat_3_level2_id . ", parcat_3_level3_id = " . $parcat_3_level3_id . ", parcat_3_level4_id = " . $parcat_3_level4_id . ", cat_4_id = " . $cat_4_id . ", parcat_4_level1_id = " . $parcat_4_level1_id . ", parcat_4_level2_id = " . $parcat_4_level2_id . ", parcat_4_level3_id = " . $parcat_4_level3_id . ", parcat_4_level4_id = " . $parcat_4_level4_id . ", cat_5_id = " . $cat_5_id . ", parcat_5_level1_id = " . $parcat_5_level1_id . ", parcat_5_level2_id = " . $parcat_5_level2_id . ", parcat_5_level3_id = " . $parcat_5_level3_id . ", parcat_5_level4_id = " . $parcat_5_level4_id . " WHERE id = $this->id";
        $dbObj->query($sql);
        $this->setFullTextSearch();

        if ($this->status == "A") {
            system_countActiveItemByCategory("article", $this->id, "inc");
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->getCategories();
     * <br /><br />
     *        //Using this in Article() class.
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

        $levelObj = new ArticleLevel();
        if ($this->package_id) {
            $price = $this->package_price;
        } else {
            $price = $price + $levelObj->getPrice($this->level);
        }

        if ($this->discount_id) {

            $discountCodeObj = new DiscountCode($this->discount_id);

            if (is_valid_discount_code($this->discount_id, "article", $this->id, $discount_message, $discount_error)) {

                if ($discountCodeObj->getString("id") && $discountCodeObj->expire_date >= date('Y-m-d')) {

                    if ($discountCodeObj->getString("type") == "percentage") {
                        $price = $price * (1 - $discountCodeObj->getString("amount") / 100);
                    } elseif ($discountCodeObj->getString("type") == "monetary value") {
                        $price = $price - $discountCodeObj->getString("amount");
                    }

                } elseif (($discountCodeObj->type == 'percentage' && $discountCodeObj->amount == '100.00') || ($discountCodeObj->type == 'monetary value' && $discountCodeObj->amount > $price)) {
                    $this->status = 'E';
                    $this->renewal_date = $discountCodeObj->expire_date;
                    $sql = "UPDATE Article SET status = 'E', renewal_date = '" . $discountCodeObj->expire_date . "', discount_id = '' WHERE id = " . $this->id;
                    $result = $dbObj->query($sql);
                }

            } else {

                if (($discountCodeObj->type == 'percentage' && $discountCodeObj->amount == '100.00') || ($discountCodeObj->type == 'monetary value' && $discountCodeObj->amount > $price)) {
                    $this->status = 'E';
                    $this->renewal_date = $discountCodeObj->expire_date;
                    $sql = "UPDATE Article SET status = 'E', renewal_date = '" . $discountCodeObj->expire_date . "', discount_id = '' WHERE id = " . $this->id;
                } else {
                    $sql = "UPDATE Article SET discount_id = '' WHERE id = " . $this->id;
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
     *        $articleObj->hasRenewalDate();
     * <br /><br />
     *        //Using this in Article() class.
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
     *        $articleObj->needToCheckOut();
     * <br /><br />
     *        //Using this in Article() class.
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
     *        $articleObj->getNextRenewalDate($times);
     * <br /><br />
     *        //Using this in Article() class.
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

            $renewalcycle = payment_getRenewalCycle("article");
            $renewalunit = payment_getRenewalUnit("article");

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
     *        $articleObj->setFullTextSearch();
     * <br /><br />
     *        //Using this in Article() class.
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

        if ($this->abstract) {
            $fulltextsearch_keyword[] = string_substr($this->abstract, 0, 100);
        }

        if ($this->author) {
            $fulltextsearch_keyword[] = $this->author;
        }

        $categories = $this->getCategories();

        if ($categories) {
            foreach ($categories as $category) {
                unset($parents);
                $category_id = $category->getNumber("id");
                while ($category_id != 0) {
                    $sql = "SELECT * FROM ArticleCategory WHERE id = $category_id";
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
            $sql = "UPDATE Article SET fulltextsearch_keyword = $fulltextsearch_keyword_sql WHERE id = $this->id";
            $result = $dbObj->query($sql);
        }

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("article.synchronization")->addUpsert($this->id);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->getGalleries();
     * <br /><br />
     *        //Using this in Article() class.
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
        $sql = "SELECT * FROM Gallery_Item WHERE item_type='article' AND item_id = $this->id ORDER BY gallery_id";
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
     *        $articleObj->setGalleries($gallery);
     * <br /><br />
     *        //Using this in Article() class.
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
        $sql = "DELETE FROM Gallery_Item WHERE item_type='article' AND item_id = $this->id";
        $dbObj->query($sql);
        if ($gallery) {
            $sql = "INSERT INTO Gallery_Item (item_id, gallery_id, item_type) VALUES ($this->id, $gallery, 'article')";
            $rs3 = $dbObj->query($sql);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->setNumberViews($id);
     * <br /><br />
     *        //Using this in Article() class.
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
        $sql = "UPDATE Article SET number_views = " . $this->number_views . " + 1 WHERE Article.id = " . $id;
        $dbObj->query($sql);

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("article.synchronization")->addViewUpdate($id);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->setAvgReview($avg,$id);
     * <br /><br />
     *        //Using this in Article() class.
     *        $this->setAvgReview($avg,$id);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name setAvgReview
     * @access Public
     * @param integer $id
     */
    function setAvgReview($avg, $id)
    {
        $dbMain = db_getDBObject(DEFAULT_DB, true);
        if (defined("SELECTED_DOMAIN_ID")) {
            $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
        } else {
            $dbObj = db_getDBObject();
        }

        unset($dbMain);
        $sql = "UPDATE Article SET avg_review = " . $avg . " WHERE Article.id = " . $id;
        $dbObj->query($sql);

        if ($symfonyContainer = SymfonyCore::getContainer()) {
            $symfonyContainer->get("article.synchronization")->addAverageReviewUpdate($id, $avg);
        }
    }

    /**
     * <code>
     *        //Using this in forms or other pages.
     *        $articleObj->deletePerAccount($account_id);
     * <br /><br />
     *        //Using this in Article() class.
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
            $sql = "SELECT * FROM Article WHERE account_id = $account_id";
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
     *        $articleObj->getArticleByFriendlyURL($friendly_url);
     * <br /><br />
     *        //Using this in Article() class.
     *        $this->getArticleByFriendlyURL($friendly_url);
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getArticleByFriendlyURL
     * @param string $friendly_url
     * @access Public
     */
    function getArticleByFriendlyURL($friendly_url)
    {
        $dbObj = db_getDBObject();
        $sql = "SELECT * FROM Article WHERE friendly_url = '" . $friendly_url . "'";
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
     *        $articleObj->getArticleToApp();
     * <br /><br />
     *        //Using this in Article() class.
     *        $this->getArticleToApp();
     * </code>
     * @copyright Copyright 2005 Arca Solutions, Inc.
     * @author Arca Solutions, Inc.
     * @version 8.0.00
     * @name getArticleToApp
     * @access Public
     */
    function getArticleToApp()
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
            $aux_detail_fields[] = "url";
            $aux_detail_fields[] = "author";
            $aux_detail_fields[] = "publication_date";
            $aux_detail_fields[] = "abstract";
            $aux_detail_fields[] = "content";
            $aux_detail_fields[] = "level";
            $aux_detail_fields[] = "avg_review";

            /*
             * Number fields
             */
            unset($number_fields);
            $number_fields[] = "level";

            unset($add_info);

            foreach ($this->data_in_array as $key => $value) {

                if (strpos($key, "image_id") !== false) {
                    unset($imageObj);
                    $imageObj = new Image($value);
                    if ($imageObj->imageExists()) {
                        $add_info["imageurl"] = $imageObj->getPath();
                    } else {
                        $firstGalImage = system_getImageFromGallery("article", $this->id);
                        if ($firstGalImage) {
                            $add_info["imageurl"] = $firstGalImage;
                        } else {
                            $add_info["imageurl"] = null;
                        }
                    }
                }

                /**
                 * Get just fields to show on detail App
                 */
                if (!is_numeric($key) && in_array($key, $aux_detail_fields)) {

                    if ($key != "image_id") {
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
             * Get number of Reviews
             */
            unset($reviewObj);
            $reviewObj = new Review();
            $reviewObj->item_type = "article";
            $reviewObj->item_id = $this->id;
            $add_info["total_reviews"] = (float)$reviewObj->GetTotalReviewsByItemID();

            /**
             * Preparing friendly URL
             */
            $add_info["friendly_url"] = ARTICLE_DEFAULT_URL . "/" . $this->friendly_url . ".html";


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
     *        $articleObj->GetInfoToApp($array_get, $aux_returnArray, $aux_fields, $items, $auxTable, $aux_Where);
     * <br /><br />
     *        //Using this in Article() class.
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
             * Get article
             */
            unset($articleObj, $articleInfo);
            $articleObj = new Article($id);

            $articleInfo = $articleObj->getArticleToApp();

            if (!is_array($articleInfo)) {

                $aux_returnArray["message"] = "No results found.";
                $aux_returnArray["type"] = $resource;
                $aux_returnArray["total_results"] = 0;
                $aux_returnArray["total_pages"] = 0;
                $aux_returnArray["results_per_page"] = 0;

            } else {
                $items[] = $articleInfo;
                $aux_returnArray["type"] = $resource;
                $aux_returnArray["total_results"] = 1;
                $aux_returnArray["total_pages"] = 1;
                $aux_returnArray["results_per_page"] = 1;
            }

        } else {

            $auxTable = "Article";
            $aux_Where[] = "status = 'A'";
            $aux_Where[] = "publication_date <= DATE_FORMAT(NOW(), '%Y-%m-%d')";

        }

        if ($searchBy) {
            if ($searchBy == "keyword") {

                unset($searchReturn);
                $searchReturn["from_tables"] = "Article";
                $searchReturn["order_by"] = "Article.level";
                $searchReturn["where_clause"] = "Article.status = 'A' AND publication_date <= DATE_FORMAT(NOW(), '%Y-%m-%d') ";
                $searchReturn["select_columns"] = implode(", ", $aux_fields);
                $searchReturn["group_by"] = false;

                $letterField = "title";
                search_frontAppKeyword($array_get, $searchReturn, "Article");

                $pageObj = new pageBrowsing($searchReturn["from_tables"], $page, $aux_results_per_page,
                    $searchReturn["order_by"], $letterField, $letter, $searchReturn["where_clause"],
                    $searchReturn["select_columns"], "Article", $searchReturn["group_by"]);

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
                 * Get articles by category_id
                 */
                $search_for["category_id"] = $category_id;
                $searchReturn = search_frontArticleSearch($search_for, "article");

                if ($searchReturn) {
                    $aux_Where[] = $searchReturn["where_clause"];
                } else {
                    $aux_returnArray["message"] = "No results found.";
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
}
