<?
    /*
     * # Admin Panel for eDirectory
     * @copyright Copyright 2014 Arca Solutions, Inc.
     * @author Basecode - Arca Solutions, Inc.
     */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /ed-admin/activity/review-comments/index.php
    # ----------------------------------------------------------------------------------------------------
    # ----------------------------------------------------------------------------------------------------
    # LOAD CONFIG
    # ----------------------------------------------------------------------------------------------------
    include("../../../conf/loadconfig.inc.php");

    # ----------------------------------------------------------------------------------------------------
    # SESSION
    # ----------------------------------------------------------------------------------------------------
    sess_validateSMSession();
    permission_hasSMPerm();

    $url_redirect = DEFAULT_URL . "/" . SITEMGR_ALIAS . "/activity/reviews-comments";
    $url_base = DEFAULT_URL . "/" . SITEMGR_ALIAS . "";

    extract($_GET);
    extract($_POST);

    if ($item_type == "article") {
        if (ARTICLE_FEATURE != "on" || CUSTOM_ARTICLE_FEATURE != "on") {
            header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
            exit;
        }
    } elseif ($item_type == "promotion") {
        if (PROMOTION_FEATURE != "on" || CUSTOM_PROMOTION_FEATURE != "on") {
            header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
            exit;
        }
    } elseif ($item_type == "blog") {
        if (BLOG_FEATURE != "on" || CUSTOM_BLOG_FEATURE != "on") {
            header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
            exit;
        }
    } elseif ($item_type != "checkin") {
        $item_type = "listing";
    }

    //Delete
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if ($action == "delete" && $id && $item_type) {

            if ($item_type == "checkin") {
                
                //Delete Check In
                $checkinObj = new CheckIn($id);
                $checkinObj->Delete();
                $message = 4;
            } elseif ($item_type == "blog") {

                //Delete Comment
                $commentObj = new Comments($id);
                $commentObj->Delete();
                $is_reply = $commentObj->getNumber("reply_id");
                if ($is_reply) {
                    $message = 3;
                } else {
                    $message = 1;
                }
            } else {

                //Delete Review
                $reviewObj = new Review($id);
                $reviewObj->delete();

                $avg = $reviewObj->getRateAvgByItem($item_type, $item_id);
                if (!is_numeric($avg))
                    $avg = 0;

                if ($item_type == "listing") {
                    $listing = new Listing();
                    $listing->setAvgReview($avg, $item_id);
                } else if ($item_type == "article") {
                    $articles = new Article();
                    $articles->setAvgReview($avg, $item_id);
                } else {
                    $promotions = new Promotion();
                    $promotions->setAvgReview($avg, $item_id);
                }
            }

            $message = 2;
            header("Location: " . $url_redirect . "/index.php?reply_id=$is_reply&message=" . $message . "&item_type=$item_type&screen=$screen&letter=$letter");
            exit;
        }
    }

    # ----------------------------------------------------------------------------------------------------
    # AUX
    # ----------------------------------------------------------------------------------------------------
    $tableActivity = "Review";
    $tableActivityLetter = "review_title";
    $tableActivityOrder = "approved, added DESC";
    if (!$itemObj) {
        if ($item_type == "listing") {
            $itemObj = new Listing($item_id);
        } else if ($item_type == "article") {
            $itemObj = new Article($item_id);
        } else if ($item_type == "promotion") {
            $itemObj = new Promotion($item_id);
        } else if ($item_type == "blog") {
            $itemObj = new Post($item_id);
        }
    }

    // Page Browsing /////////////////////////////////////////
    if ($item_id && $item_type != "blog") {
        $sql_where[] = " item_type = '$item_type' AND item_id = '$item_id' ";
    }
    if ($item_type && !$item_id && $item_type != "blog") {
        $sql_where[] = " item_type = '$item_type'";
    }

    if ($item_type == "blog") {
        $tableActivity = "Comments";
        $tableActivityLetter = "description";
        $reply_id = ($reply_id ? $reply_id : 0);
        if ($reply_id) {
            $replyObj = new Comments($reply_id);

            if ($replyObj->getString("description")) {
                $reply_title = $replyObj->getString("description", true, 15);
            } else {
                $replytitle = system_showText(LANG_NA);
            }
        }
        $sql_where[] = " reply_id = $reply_id";
    }

    if ($item_type == "checkin") {
        $tableActivity = "CheckIn";
        $tableActivityOrder = "added DESC";
        $tableActivityLetter = "quick_tip";
        unset($sql_where);
    }

    if ($search_id) {
        $sql_where[] = " id = " . db_formatNumber($search_id);
    }

    if ($sql_where) {
        $where .= " " . implode(" AND ", $sql_where) . " ";
    }

    $pageObj = new pageBrowsing($tableActivity, $screen, RESULTS_PER_PAGE, $tableActivityOrder, $tableActivityLetter, $letter, $where);
    $reviewsArr = $pageObj->retrievePage("object");

    $paging_url = DEFAULT_URL . "/" . SITEMGR_ALIAS . "/activity/reviews-comments/index.php?item_type=$item_type&item_id=$item_id&reply_id=$reply_id";

    if ($item_type == "blog") {
        $msgArray = $msg_comment;
    } else {
        $msgArray = $msg_review;
    }

    # ----------------------------------------------------------------------------------------------------
    # HEADER
    # ----------------------------------------------------------------------------------------------------
    include(SM_EDIRECTORY_ROOT . "/layout/header.php");

    # ----------------------------------------------------------------------------------------------------
    # NAVBAR
    # ----------------------------------------------------------------------------------------------------
    include(SM_EDIRECTORY_ROOT . "/layout/navbar.php");

    # ----------------------------------------------------------------------------------------------------
    # SIDEBAR
    # ----------------------------------------------------------------------------------------------------
    include(SM_EDIRECTORY_ROOT . "/layout/sidebar-activity.php");
    ?> 


    <main class="wrapper togglesidebar container-fluid">        

        <section class="heading">
            <h1><?= ucfirst(system_showText(LANG_SITEMGR_REVIEWS))." & ".system_showText(LANG_CHECKINCOUNT_PLURAL) ?><?=(is_object($itemObj) && $itemObj->getString("title") ? " - ".$itemObj->getString("title") : "")?></h1>
            <? if ($reply_id && $item_type == "blog") { ?>
                <p><?= system_showText(LANG_SITEMGR_COMMENT_MANAGEREPLIES) ?></p>
            <? } ?>
            <? if (is_numeric($message) && isset($msgArray[$message])) { ?>
                <p class="alert alert-<?= ($class == "" ? "success" : $class); ?>"><?= $msgArray[$message] ?></p>
            <? } ?>
        </section>

        <div class="tab-options">
            <ul role="tablist" class="row nav nav-tabs">

                <li class="<?= ($item_type == "listing" ? "active" : "") ?>">
                    <a href="<?= $url_redirect ?>/" role="tab"><?= system_showText(LANG_SITEMGR_LISTINGREVIEWS) ?></a>
                </li>

                <? if (ARTICLE_FEATURE == "on" && CUSTOM_ARTICLE_FEATURE == "on") { ?>
                    <li class="<?= ($item_type == "article" ? "active" : "") ?>">
                        <a href="<?= $url_redirect ?>/?item_type=article" role="tab"><?= system_showText(LANG_SITEMGR_ARTICLEREVIEWS) ?></a>
                    </li>
                <? } ?>

                <? /*if (PROMOTION_FEATURE == "on" && CUSTOM_PROMOTION_FEATURE == "on") { ?>
                    <li class="<?= ($item_type == "promotion" ? "active" : "") ?>">
                        <a href="<?= $url_redirect ?>/?item_type=promotion" role="tab"><?= system_showText(LANG_SITEMGR_PROMOTIONREVIEWS) ?></a>
                    </li>
                <? }*/ ?>

                <? /*if (BLOG_FEATURE == "on" && CUSTOM_BLOG_FEATURE == "on") { ?>
                    <li class="<?= ($item_type == "blog" ? "active" : "") ?>">
                        <a href="<?= $url_redirect ?>/?item_type=blog" role="tab"><?= system_ShowText(LANG_LABEL_COMMENTS) ?></a>
                    </li>
                <? }*/ ?>
                    
                <li class="<?= ($item_type == "checkin" ? "active" : "") ?>">
                    <a href="<?= $url_redirect ?>/?item_type=checkin" role="tab"><?= system_showText(LANG_CHECKINCOUNT_PLURAL) ?></a>
                </li>
            </ul>

            <div class="row tab-content">
                <section class="tab-pane active">
                    <div class="col-sm-12">
                        <? if ($reviewsArr) { ?>
                            <div class="panel panel-default">
                                <div class="table-responsive">
                            <?
                            if ($item_type == "blog") {
                                include(INCLUDES_DIR . "/tables/table_comments.php");
                            } elseif ($item_type == "checkin") {
                                include(INCLUDES_DIR . "/tables/table_checkin.php");
                            } else {
                                include(INCLUDES_DIR . "/tables/table_review.php");
                            }
                            ?>
                                </div>
                                <div class="content-control-bottom pagination-responsive">
                                    <? include(INCLUDES_DIR . "/lists/list-pagination.php"); ?>
                                </div>
                            </div>
                        <? } else { ?>
                            <p class="alert alert-warning">
                            <?
                            if ($item_type == "blog") {
                                if ($reply_id) {
                                    echo system_showText(LANG_SITEMGR_REPLY_NORECORD);
                                } else {
                                    echo system_showText(LANG_SITEMGR_COMMENT_NORECORD);
                                }
                            } elseif ($item_type == "checkin") {
                                echo system_showText(LANG_NORECORD);
                            } else {
                                echo system_showText(LANG_SITEMGR_REVIEW_NORECORD);
                            }
                            ?>
                            </p>
                        <? } ?>
                    </div>
                </section>

            </div>

        </div>

    </main>

    <? include(INCLUDES_DIR . "/modals/modal-delete.php"); ?>

    <?php
    # ----------------------------------------------------------------------------------------------------
    # FOOTER
    # ----------------------------------------------------------------------------------------------------
    $customJS = SM_EDIRECTORY_ROOT . "/assets/custom-js/review.php";
    include(SM_EDIRECTORY_ROOT . "/layout/footer.php");
    ?>