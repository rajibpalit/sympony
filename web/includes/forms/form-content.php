<?php
/*
* # Admin Panel for eDirectory
* @copyright Copyright 2014 Arca Solutions, Inc.
* @author Basecode - Arca Solutions, Inc.
*/

# ----------------------------------------------------------------------------------------------------
# * FILE: /includes/forms/form-content.php
# ----------------------------------------------------------------------------------------------------
?>

<!-- Panel Basic Description and SEO CENTER  -->
<? if (
    (($auxContent->getString("section") == "general") || (string_strpos($auxContent->type, "Advertisement") === false))
    && (string_strpos($auxContent->type, "Bottom") === false)
    && (string_strpos($auxContent->type, "Results") === false)
    && ($auxContent->getString("section") != "member")
    && (string_strpos($auxContent->type, "Packages") === false)
    && (string_strpos($auxContent->type, "Footer") === false)
) { ?>
    <div class="panel panel-form">

        <div class="panel-heading">
            <?= system_showText(LANG_LABEL_DESCRIPTION) ?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="title"><?= system_showText(LANG_LABEL_TITLE) ?></label>
                <input id="title" type="text" name="title" value="<?= $contentObj->title ?>" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="description"><?= system_showText(LANG_LABEL_DESCRIPTION) ?></label>
                <textarea id="description" name="description" rows="3" class="form-control textarea-counter" data-chars="250" data-msg="<?= system_showText(LANG_MSG_CHARS_LEFT) ?>"><?= $contentObj->description ?></textarea>
            </div>
            <div class="form-group">
                <label for="kewywords"><?= system_showText(LANG_SITEMGR_LABEL_KEYWORDS) ?></label>
                <input type="text" class="form-control tag-input" id="keywords" name="keywords" value="<?= $contentObj->keywords; ?>" placeholder="<?= system_showText(LANG_HOLDER_KEYWORDS); ?>">
            </div>
        </div>

    </div>
<? } ?>

<?php
    /* Adds extra section in home page configuration to allow user to change search box title and subtitle */
    if ($auxContent->type == "Home Page") {
        $searchBoxTitleContent = new CustomText("searchBoxTitle");
        $searchBoxSubtitleContent = new CustomText("searchBoxSubtitle");
    ?>
    <div class="panel panel-form">
        <div class="panel-heading">
            <?= system_showText(LANG_SITEMGR_CUSTOMIZATION_PAGES_HOME_SEARCHBOX_SECTION) ?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="searchBoxTitle"><?= system_showText(LANG_SITEMGR_CUSTOMIZATION_PAGES_HOME_SEARCHBOX_TITLE) ?></label>
                <input id="searchBoxTitle" type="text" name="searchBoxTitle" value="<?= $searchBoxTitleContent ? $searchBoxTitleContent->value : "" ?>" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="searchBoxSubtitle"><?= system_showText(LANG_SITEMGR_CUSTOMIZATION_PAGES_HOME_SEARCHBOX_SUBTITLE) ?></label>
                <input id="searchBoxSubtitle" type="text" name="searchBoxSubtitle" value="<?= $searchBoxSubtitleContent ? $searchBoxSubtitleContent->value : "" ?>" class="form-control"/>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Panel HTML Content -->
<? if ($allowContent) { ?>
    <div class="panel panel-form">

        <div class="panel-heading">
            <?= system_showText(LANG_LABEL_CONTENT) ?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <? // TinyMCE Editor Init
                // getting content
                $content = $contentObj->getString("content");
                //fix ie bug with images
                if (!$content) {
                    $content = "&nbsp;" . $content;
                }
                // calling TinyMCE
                system_addTinyMCE("", "exact", "advanced", "content_html", "30", "25", "100%", $content);
                ?>
            </div>
        </div>

    </div>
<? } ?>
