<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-category.php
	# ----------------------------------------------------------------------------------------------------

    ####################################################################################################
	### PAY ATTENTION - SAME CODE FOR LISTING, EVENT, CLASSIFIED, ARTICLE AND BLOG
	####################################################################################################

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------

	switch ($table_category) {
		case "ArticleCategory"      :	$default_url = ARTICLE_DEFAULT_URL;
                                        $module_label = LANG_SITEMGR_ARTICLE_PLURAL;
                                        break;
		case "ClassifiedCategory"   :   $default_url = CLASSIFIED_DEFAULT_URL;
                                        $module_label = LANG_SITEMGR_CLASSIFIED_PLURAL;
                                        break;
		case "EventCategory"        :	$default_url = EVENT_DEFAULT_URL;
                                        $module_label = LANG_SITEMGR_EVENT_PLURAL;
                                        break;
		case "ListingCategory"      :	$default_url = LISTING_DEFAULT_URL;
                                        $module_label = LANG_SITEMGR_LISTING_PLURAL;
                                        break;
        case "BlogCategory"         :	$default_url = BLOG_DEFAULT_URL;
                                        $module_label = LANG_SITEMGR_BLOG;
                                        break;
	}

    ?>
    <script type="text/javascript" src="<?=DEFAULT_URL?>/includes/tiny_mce/tiny_mce_src.js"></script>

    <input type="hidden" name="table_category" value="<?=$table_category;?>">

    <div class="col-md-<?=($category_id ? "12" : "7")?>">

        <!-- Panel Category Informartion  -->
        <div class="panel panel-form">

            <div class="panel-heading"><?=system_showText(LANG_SITEMGR_CATEGORY_INFORMATION)?></div>

            <div class="panel-body">

                <div class="form-group">
                    <label for="title"><?=system_showText(LANG_SITEMGR_TITLE)?></label>
                    <input type="text" id="title" name="title" maxlength="50" class="form-control" value="<?=$title;?>" onblur="easyFriendlyUrl(this.value, 'friendly_url', '<?=FRIENDLYURL_VALIDCHARS?>', '<?=FRIENDLYURL_SEPARATOR?>');">
                </div>

                <div class="form-group">
                    <label for="keywords"><?=system_showText(LANG_LABEL_KEYWORDS_FOR_SEARCH)?></label>
                    <input type="text" name="keywords" id="keywords" class="form-control tag-input" placeholder="<?=system_showText(LANG_HOLDER_KEYWORDS);?>" value="<?=$keywords?>">
                    <p class="help-block small"><?=ucfirst(system_showText(LANG_LABEL_MAX));?> <?=MAX_KEYWORDS?> <?=system_showText(LANG_LABEL_KEYWORDS);?></p>
                </div>

                <? if ($category_id && $category_id != 0) { ?>
                <div class="form-group form-horizontal">
                    <label>
                        <?=system_showText(LANG_SITEMGR_CATEGORY_FATHERCATEGORY)?>:
                        <span><strong><?=$fatherCategoryArray["title"]?></strong></span>
                    </label>
                    <input type="hidden" name="category_id" value="<?=$fatherCategoryArray["id"]?>">
                </div>
                <? } else { ?>
                    <input type="hidden" name="category_id" id="category_id" value="<?=$category_id?>">
                <? }

                if (!$category_id) { ?>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="featured" name="featured" <?=($featured == "on" || $featured == "new") ? "checked" : "" ?>>
                            <?=system_showText(LANG_SITEMGR_FEATURED)?>
                            <br>
                            <small class="text-muted">(<?=system_showText(LANG_SITEMGR_FEATUREDCATEGORY_CHECKEDINFO)?>)</small>
                        </label>
                    </div>
                </div>
                <? } else { ?>
                    <input type="hidden" name="featured" value="<?=$featured?>">
                <? } ?>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="clickToDisable" <?=($enabled == "on") ? "" : "checked" ?>>
                            <?=system_showText(LANG_SITEMGR_DISABLE_CATEGORY)?>
                        </label>
                    </div>
                </div>

                <?/*
                <div class="form-group">
                    <label for="summary_description"><?=system_showText(LANG_LABEL_DESCRIPTION)?></label>
                    <textarea id="summary_description" name="summary_description" class="form-control" rows="5" class="form-control textarea-counter" data-chars="250" data-msg="<?=system_showText(LANG_MSG_CHARS_LEFT)?>"><?=$summary_description;?></textarea>
                </div>
                */?>

                <div class="form-group">
                    <label><?=string_ucwords(system_showText(LANG_SITEMGR_CONTENT));?></label>
                    <div class="col-xs-12 row">
                        <? // TinyMCE Editor Init
                            //fix ie bug with images
                            if (!($content)) $content = "&nbsp;".$content;

                            // calling TinyMCE
                            system_addTinyMCE("", "none", "advanced", "content", "30", "15", "300", $content, false);
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <? if (!$category_id) { ?>

    <div class="col-sm-5">
        <br>

        <div class="panel panel-form-media">
            <div class="panel-heading">
                <?=system_showText(LANG_LABEL_IMAGE)?>
                <small class="text-muted">
                    (<?=IMAGE_CATEGORY_FULL_WIDTH;?>px x <?=IMAGE_CATEGORY_FULL_HEIGHT;?>px)
                </small>
            </div>

            <div class="panel-body">

                <?
                if ($thumb_id) {
                    $imageObj = new Image($thumb_id);
                    if ($imageObj->imageExists()) { ?>
                        <?=$imageObj->getTag(true, IMAGE_CATEGORY_THUMB_WIDTH, IMAGE_CATEGORY_THUMB_HEIGHT, $title, false, false, "img-responsive");?>
                    <? }
                } ?>

                <br>

                <input type="file" class="file-withinput" name="image" id="image" size="50">
                <input type="hidden" name="image_id" value="<?=$image_id?>">
            </div>

            <div class="panel-footer">
                <small class="help-block">
                    <?=system_showText(LANG_MSG_MAX_FILE_SIZE)?> <?=UPLOAD_MAX_SIZE;?> MB. <?=system_showText(LANG_MSG_ANIMATEDGIF_NOT_SUPPORTED);?>
                </small>
            </div>

        </div>

    </div>

    <? } ?>

    <div class="col-sm-12">
        <!-- Panel SEO Information  -->
        <div class="panel panel-form">

            <div class="panel-heading"><?=system_showText(LANG_SITEMGR_CONTENT_SEOCENTER)?></div>

            <div class="panel-body">

                <div class="form-group">
                    <label for="page_title"><?=system_showText(LANG_SITEMGR_LABEL_PAGETITLE)?></label>
                    <input type="text" id="page_title" name="page_title" class="form-control" value="<?=$page_title;?>" >
                </div>

                <div class="form-group">
                    <label for="friendly_url"><?=system_showText(LANG_SITEMGR_LABEL_FRIENDLYTITLE)?></label>
                    <input type="text" id="friendly_url" name="friendly_url" class="form-control" value="<?=$friendly_url;?>" onblur="easyFriendlyUrl(this.value, 'friendly_url', '<?=FRIENDLYURL_VALIDCHARS?>\n', '<?=FRIENDLYURL_SEPARATOR?>');" >
                </div>

                <div class="form-group">
                    <label for="seo_description"><?=system_showText(LANG_SITEMGR_LABEL_METADESCRIPTION)?></label>
                    <textarea id="seo_description" name="seo_description" rows="5" cols="1" class="form-control textarea-counter" data-chars="250" data-msg="<?=system_showText(LANG_MSG_CHARS_LEFT)?>"><?=$seo_description;?></textarea>
                </div>

                <div class="form-group">
                    <label for="seo_keywords"><?=system_showText(LANG_SITEMGR_LABEL_METAKEYWORDS)?></label>
                    <textarea id="seo_keywords" name="seo_keywords" rows="5" cols="1" class="form-control textarea-counter" data-chars="250" data-msg="<?=system_showText(LANG_MSG_CHARS_LEFT)?>"><?=$seo_keywords;?></textarea>
                </div>

            </div>

        </div>

    </div>
