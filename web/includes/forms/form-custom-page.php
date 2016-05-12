<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-custom-page.php
	# ----------------------------------------------------------------------------------------------------
?>

    <div class="panel panel-form">

        <div class="panel-heading">
            <?=system_showText(LANG_LABEL_DESCRIPTION)?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="type"><?=system_showText(LANG_SITEMGR_LABEL_PAGENAME)?></label>
                <input id="type" type="text" name="type" value="<?=$type?>" onblur="easyFriendlyUrl(this.value, 'url', '<?=FRIENDLYURL_VALIDCHARS?>', '<?=FRIENDLYURL_SEPARATOR?>'); updatePageURL();" class="form-control" />
            </div>
        </div>
        
    </div>

    <div class="panel panel-form">
        
        <div class="panel-heading">
            <?=system_showText(LANG_SITEMGR_SEOCENTER)?>
        </div>
        <div class="panel-body">
            <? if (SITEMAP_FEATURE == "on") { ?>
            <div class="form-group checkbox">
                <label>
                    <input type="checkbox" class="inputCheck" name="sitemap" value="1" <? if ($sitemap || (!$id && !$_POST)) { echo "checked"; } ?> />
                    <?=system_showText(LANG_SITEMGR_LABEL_SITEMAP)?>
                    <p class="help-block small"><?=system_showText(LANG_SITEMGR_CONTENT_SITEMAP_CHECKBOX)?></p>
                </label>
            </div>
            <? } ?>
            <div class="form-group">
                <label for="url"><?=system_showText(LANG_SITEMGR_LABEL_URL)?></label>
                <input type="text" name="url" id="url" value="<?=$url?>" class="form-control" onblur="easyFriendlyUrl(this.value, 'url', '<?=FRIENDLYURL_VALIDCHARS?>', '<?=FRIENDLYURL_SEPARATOR?>'); updatePageURL();">
                <p class="help-block small"><a id="page-url" href="#" target="_blank"><?=$newurl?>/[<?=system_showText(LANG_SITEMGR_LABEL_PAGENAME)?>].html</a></p>
            </div>
            <div class="form-group">
                <label for="title"><?=system_showText(LANG_SITEMGR_TITLE)?></label>
                <input id="title" type="text" name="title" value="<?=$title?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="description"><?=system_showText(LANG_LABEL_DESCRIPTION)?></label>
                <textarea id="description" name="description" rows="3" class="form-control"><?=$description?></textarea>
            </div>
            <div class="form-group" id="tour-keywords">
                <label for="kewywords"><?=system_showText(LANG_SITEMGR_LABEL_KEYWORDS)?></label>
                <input type="text" class="form-control tag-input" id="keywords" name="keywords" value="<?=$keywords;?>" placeholder="<?=system_showText(LANG_HOLDER_KEYWORDS);?>">
            </div>
        </div>

    </div>

    <!-- Panel HTML Content -->
    <div class="panel panel-form">

        <div class="panel-heading">
            <?=system_showText(LANG_LABEL_CONTENT)?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <? // TinyMCE Editor Init
                    // getting content
                    $content = $this_content;
                    // calling TinyMCE
                    system_addTinyMCE("", "exact", "advanced", "content_html", "30", "25", "100%", $content);
                ?>
            </div>
        </div>

    </div>