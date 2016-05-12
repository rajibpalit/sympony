<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-logo.php
	# ----------------------------------------------------------------------------------------------------

    if ($message_header) { ?>
        <p class="alert alert-<?=($error ? "warning" : "success")?>"><?=$message_header?></p>
    <? } ?>
    
    <div class="panel panel-default">
        <div class="panel-heading"><?=system_showText(LANG_SITEMGR_BASIC_INFO_LOGO);?></div>
        <div class="panel-body">
            
            <div class="row">
                <div class="col-sm-5">
                    <? 
                    if (file_exists(EDIRECTORY_ROOT.IMAGE_HEADER_PATH)) {
                        $headerlogo_path = DEFAULT_URL.IMAGE_HEADER_PATH;
                    } else {
                        $headerlogo_path = (HTTPS_MODE != "on" ? "http://" : "https://")."placehold.it/".IMAGE_HEADER_WIDTH."X".IMAGE_HEADER_HEIGHT;
                    }

                    $headerlogo_width  = 0;
                    $headerlogo_height = 0;
                    $headerlogo_info = @getimagesize(EDIRECTORY_ROOT."/".$headerlogo_path);
                    if (count($headerlogo_info)) {
                        $width  = $headerlogo_info[0];
                        $height = $headerlogo_info[1];
                    } else {
                        $width  = IMAGE_HEADER_WIDTH;
                        $height = IMAGE_HEADER_HEIGHT;
                    }
                    image_getNewDimension((IMAGE_HEADER_WIDTH/2), (IMAGE_HEADER_HEIGHT/2), $width, $height, $headerlogo_width, $headerlogo_height);
                    ?>
                    <img src="<?=$headerlogo_path?>?<?=rand(0, 1000)?>" class="img-responsive" alt="Logo Image">
                </div>
                <div class="col-sm-7">
                    <p><?=system_showText(LANG_SITEMGR_BASIC_INFO_LOGO_CHOOSE);?></p>
                    <small class="help-block"><?=IMAGE_HEADER_WIDTH?>px x <?=IMAGE_HEADER_HEIGHT?>px.<?=system_showText(LANG_SITEMGR_MSGMAXFILESIZE)?> <?=UPLOAD_MAX_SIZE;?> MB. <?=system_showText(LANG_MSG_ANIMATEDGIF_NOT_SUPPORTED);?></small>
                    <div class="row">
                        <div class="col-sm-7">
                            <input class="morphOnSelect file-withinput" type="file" name="header_image">
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="row">
                <div class="col-sm-5">
                    <? if (file_exists(EDIRECTORY_ROOT.NOIMAGE_PATH."/".NOIMAGE_NAME.".".NOIMAGE_IMGEXT)) { ?>
                    <img src="<?=DEFAULT_URL.NOIMAGE_PATH."/".NOIMAGE_NAME.".".NOIMAGE_IMGEXT;?>?<?=rand(0, 1000)?>" class="img-responsive" alt="Default Image">
                    <? } else { ?>
                    <img src="<?=(HTTPS_MODE != "on" ? "http://" : "https://")?>placehold.it/300X150" class="img-responsive" alt="Default Image">
                    <? } ?>
                </div>
                <div class="col-sm-7">
                    <p><?=system_showText(LANG_SITEMGR_BASIC_INFO_NOIMAGE_CHOOSE);?></p>
                    <small class="help-block"><?=system_showText(LANG_SITEMGR_BASIC_INFO_NOIMAGE_TIP);?></small>
                    <div class="row">
                        <div class="col-sm-7">
                            <input class="morphOnSelect file-withinput" type="file" name="noimage_image">
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="row">
                <div class="col-sm-5">
                    <? if (file_exists(EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/content_files/favicon_".$last_favicon_id.".ico")) { ?>
                    <img src="<?=DEFAULT_URL."/custom/domain_".SELECTED_DOMAIN_ID."/content_files/favicon_".$last_favicon_id.".ico"?>?<?=rand(0, 1000)?>" class="img-responsive" alt="Favicon">
                    <? } else { ?>
                    <img src="<?=(HTTPS_MODE != "on" ? "http://" : "https://")?>placehold.it/16X16" class="img-responsive" alt="Favicon">
                    <? } ?>
                </div>
                <div class="col-sm-7">
                    <p><?=system_showText(LANG_SITEMGR_BASIC_INFO_FAVICON_CHOOSE);?></p>
                    <small class="help-block"><?=system_showText(LANG_SITEMGR_BASIC_INFO_FAVICON_TIP);?></small>
                    <small class="help-block"><b><?=system_showText(LANG_SITEMGR_ICONTIP);?></b></small>
                    <div class="row">
                        <div class="col-sm-7">
                            <input class="morphOnSelect file-withinput" type="file" name="favicon_file">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="button" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" onclick="<?=DEMO_LIVE_MODE ? "livemodeMessage(true, false);" : "document.header.submit();"?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
        </div>
    </div>