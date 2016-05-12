<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-location.php
	# ----------------------------------------------------------------------------------------------------

    $edirLocConf = explode(",", EDIR_LOCATIONS);
    $edirLocConfNames = explode(",", EDIR_ALL_LOCATIONNAMES);
?>

    <div class="col-md-7">

    <?  if ($_location_level != $edirLocConf[0]){ ?>
        <h1><?= system_showText(constant("LANG_SITEMGR_".$edirLocConfNames[$_location_level-1]."_HIERARCHY")) ?></h1>
    <?  }
    
    include(EDIRECTORY_ROOT."/includes/code/load_location_location.php");
    
    if ( $operationTypeCheck ) { ?>
        <input type="hidden" name="default" id="default" value="<?=$location_default?>" />
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <div class="form-group">
            <label for="location_name"><?=LOCATION_TITLE?></label>
            <input class="form-control" id="location_name" type="text" name="location_name" value="<?=htmlspecialchars($location_name)?>" onblur="easyFriendlyUrl(this.value, 'friendly_url', '<?=FRIENDLYURL_VALIDCHARS?>', '<?=FRIENDLYURL_SEPARATOR?>');" />
        </div>

        <div class="form-group">
            <label for="location_abbreviation"><?=string_ucwords(system_showText(LANG_SITEMGR_ABBREVIATION))?></label>
            <i class="form-tip icon-help10" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_LOCATION_USEDFORSEARCH)?>. <?=system_showText(LANG_SITEMGR_LOCATION_ABBMSG)?>"></i>
            <input class="form-control" id="location_abbreviation" type="text" name="location_abbreviation" value="<?=htmlspecialchars($location_abbreviation);?>" />
        </div>

        <?
        $locations_info = db_getFromDB("settinglocation", "id", $_location_level, 1, "", "array", SELECTED_DOMAIN_ID);
        ?>

        <div class="form-group">
            <label for="friendly_url"><?=string_ucwords(system_showText(LANG_SITEMGR_LABEL_FRIENDLYTITLE))?></label>
            <input class="form-control" id="friendly_url" type="text" name="friendly_url" value="<?=$friendly_url?>" onblur="easyFriendlyUrl(this.value, 'friendly_url', '<?=FRIENDLYURL_VALIDCHARS?>', '<?=FRIENDLYURL_SEPARATOR?>');" />
        </div>

        <div class="form-group">
            <label for="seo_description"><?=string_ucwords(system_showText(LANG_SITEMGR_LABEL_METADESCRIPTION))?></label>
            <textarea class="form-control textarea-counter" data-chars="250" data-msg="<?=system_showText(LANG_MSG_CHARS_LEFT)?>" id="seo_description" name="seo_description" rows="5" ><?=$seo_description?></textarea>
        </div>

        <div class="form-group">
            <label for="seo_keywords"><?=string_ucwords(system_showText(LANG_SITEMGR_LABEL_METAKEYWORDS))?></label>
            <textarea class="form-control textarea-counter" data-chars="250" data-msg="<?=system_showText(LANG_MSG_CHARS_LEFT)?>" id="seo_keywords" name="seo_keywords" rows="5" cols="1" ><?=$seo_keywords?></textarea>
        </div>
    <? } ?>
    </div>

    <div class="col-md-5">
        <div class="panel panel-default" id="tour-contact">
            <div class="panel-heading"> <?=system_showText(LANG_SITEMGR_SEOCENTER)?> </div>
            <div class="panel-body">

                    <span>
                        <?=system_showText(LANG_SITEMGR_LOCATION_FRIENDLY_URL1)?><br>
                        <br>
                        <strong><?=system_showText(LANG_SITEMGR_FOREXAMPLE)?>:</strong><br>
                        <br>
                        <?=system_showText(LANG_SITEMGR_LOCATION_FRIENDLY_URL2)?><br>
                        "<?=LISTING_DEFAULT_URL?>/united-states"<br>
                        <br>
                        <?=system_showText(LANG_SITEMGR_LOCATION_FRIENDLY_URL5)?>
                    </span>
            </div>
        </div>
    </div>

<?php
    $customJS = SM_EDIRECTORY_ROOT."/assets/custom-js/location.php";
