<?php
/*
* # Admin Panel for eDirectory
* @copyright Copyright 2014 Arca Solutions, Inc.
* @author Basecode - Arca Solutions, Inc.
*/

# ----------------------------------------------------------------------------------------------------
# * FILE: /ed-admin/design/pages-custom/content.php
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

# ----------------------------------------------------------------------------------------------------
# CODE
# ----------------------------------------------------------------------------------------------------

extract($_GET);
extract($_POST);

if ($id) {

    // getting the section and type from Content table
    $auxContent = new Content($id);

    $blockedContent = unserialize(SITECONTENT_BLOCKED);
    if (in_array($auxContent->getString("type"), $blockedContent)) {
        header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
        exit;
    }

    if (($auxContent->getString("section") == "article") || ($auxContent->getString("section") == "advertise_article")) {
        if (ARTICLE_FEATURE != "on" || CUSTOM_ARTICLE_FEATURE != "on") {
            header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
            exit;
        }
    }
    if (($auxContent->getString("section") == "blog")) {
        if (BLOG_FEATURE != "on" || CUSTOM_BLOG_FEATURE != "on") {
            header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
            exit;
        }
    }
    if (($auxContent->getString("section") == "event") || ($auxContent->getString("section") == "advertise_event")) {
        if (EVENT_FEATURE != "on" || CUSTOM_EVENT_FEATURE != "on") {
            header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
            exit;
        }
    }
    if (($auxContent->getString("section") == "classified") || ($auxContent->getString("section") == "advertise_classified")) {
        if (CLASSIFIED_FEATURE != "on" || CUSTOM_CLASSIFIED_FEATURE != "on") {
            header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/");
            exit;
        }
    }

    $contentObj = new Content($_REQUEST["id"]);
    if (($_SERVER['REQUEST_METHOD'] == "POST") && (!DEMO_LIVE_MODE)) {

        $errorMessage = "";

        /* Saves main home page search box text settings */
        if ($contentObj->type == "Home Page") {
            try {
                /* I'm avoiding using CustomText class since it isn't able to upsert */
                $connection = DatabaseHandler::getDomainConnection();

                $query = "INSERT INTO `CustomText` (`name`, `value`) VALUES (:propertyName, :propertyValue) ON DUPLICATE KEY UPDATE `value` = :propertyValue;";

                $statement = $connection->prepare($query);
                $statement->bindValue("propertyName", "searchBoxTitle");
                $statement->bindValue("propertyValue", trim(strip_tags($_POST['searchBoxTitle'])));
                $statement->execute();

                $statement->bindValue("propertyName", "searchBoxSubtitle");
                $statement->bindValue("propertyValue", trim(strip_tags($_POST['searchBoxSubtitle'])));
                $statement->execute();
            } catch (\Exception $e) {
                SymfonyCore::getContainer()->get("logger")
                    ->critical("[SITEMGR] Failure while saving search box text labels.", ["exception" => $e]);
            }
        }

        //Save home page extra content info
        if (!$errorMessage && $upload_image != "failed") {

            $description = str_replace('"', '', $_POST["description"]);
            $keywords = str_replace('"', '', $_POST["keywords"]);

            $contentObj->setString("title", trim($title));
            $contentObj->setString("description", trim($description));
            $contentObj->setString("keywords", trim($keywords));
            $contentObj->setString("content", $content_html);
            $contentObj->Save();
            $id = $contentObj->getNumber("id");
            $message = 0;

            header("Location:" . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/design/pages-custom/content.php?id=$id&message=$message");
            exit;

        }
    }
} else {
    header("Location: " . DEFAULT_URL . "/" . SITEMGR_ALIAS . "/design/pages-custom/");
    exit;
}

$allowContent = true;

$blockedContent = unserialize(SITECONTENT_FORSEO);
if (in_array($auxContent->getString("type"), $blockedContent)) {
    $allowContent = false;
}
$contentLabel = string_strtoupper($auxContent->getString("type"));
$contentLabel = str_replace(" ", "_", $contentLabel);

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    setting_get("front_text_top", $front_text_top);
    setting_get("front_text_sidebar", $front_text_sidebar);
    setting_get("front_text_sidebar2", $front_text_sidebar2);
    setting_get("front_testimonial", $front_testimonial);
    setting_get("front_testimonial_author", $front_testimonial_author);
    setting_get("front_itunes_url", $front_itunes_url);
    setting_get("front_gplay_url", $front_gplay_url);
    setting_get("front_review_counter", $front_review_counter);
}

setting_get("review_listing_enabled", $review_enabled);

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
include(SM_EDIRECTORY_ROOT . "/layout/sidebar-design.php");

?>

<main class="wrapper togglesidebar container-fluid">

    <form role="form" name="content" id="content" action="<?= system_getFormAction($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">

        <input name="id" type="hidden" value="<?= $id ?>"/>

        <section id="edit-listing" class="row heading">
            <div class="container">
                <div class="row">
                    <? include(SM_EDIRECTORY_ROOT . "/layout/back-navigation.php"); ?>
                </div>
                <h1><?= system_showText(LANG_SITEMGR_EDIT_PAGE); ?></h1>

                <p><?= system_showText(constant("LANG_SITEMGR_CONTENT_" . $contentLabel)) ?></p>

                <? if (is_numeric($message)) { ?>
                    <p class="alert alert-success"><?= $msg_content[$message] ?></p>
                <? } elseif ($errorMessage) { ?>
                    <p class="alert alert-warning"><?= $errorMessage ?></p>
                <? } ?>
            </div>
        </section>

        <section class="row edit-listing">
            <div class="container">
                <? include(INCLUDES_DIR . "/forms/form-content.php"); ?>
            </div>
        </section>

        <section class="row footer-action">
            <div class="container">
                <div class="col-xs-12 text-right">
                    <a href="<?= DEFAULT_URL . "/" . SITEMGR_ALIAS . "/design/pages-custom/" ?>" class="btn btn-default btn-xs"><?= system_showText(LANG_CANCEL) ?></a>
                    <span class="separator"> <?= system_showText(LANG_OR) ?> </span>
                    <button type="button" name="Save" value="Save" class="btn btn-primary action-save" data-loading-text="<?= system_showText(LANG_LABEL_FORM_WAIT); ?>" onclick="<?= DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "JS_submit();" ?>"><?= system_showText(LANG_SITEMGR_SAVE_CHANGES); ?></button>
                </div>
            </div>
        </section>

    </form>

</main>

<?php
# ----------------------------------------------------------------------------------------------------
# FOOTER
# ----------------------------------------------------------------------------------------------------
$customJS = SM_EDIRECTORY_ROOT . "/assets/custom-js/content.php";
include(SM_EDIRECTORY_ROOT . "/layout/footer.php");
?>
