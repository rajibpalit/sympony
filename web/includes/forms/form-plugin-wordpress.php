<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /includes/forms/form-plugin-wordpress.php
    # ----------------------------------------------------------------------------------------------------

?>
    
    <? if ($message_wp_options) { ?>
        <div class="col-sm-12">
            <div id="warning" class="<?=$error ? "alert alert-warning" : "alert alert-success" ?>">
            <?=$message_wp_options?>
            </div>
        </div>
    <? } ?>

    <div class="col-md-8 col-md-offset-2">
        
        <br>
        
        <div class="panel panel-form-media">

            <div class="panel-heading"><?=system_showText(LANG_SITEMGR_OPTIONS);?></div>

            <div class="panel-body">
                <form name="wordpress_plugin_options" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">

                    <input type="hidden" name="type" value="<?=$_GET["type"]?>">
                    <input type="hidden" name="plugin_type" value="wordpress">

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="wp_enabled" value="on" <?=($wp_enabled ? "checked" : "")?> />
                                <?=system_showText(LANG_SITEMGR_PLUGINGS_ENABLE_WP)?>
                                <p class="help-block"><?=system_showText(LANG_SITEMGR_PLUGINGS_WP_TIP)?></p>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="wordpress_plugin_options" value="Submit" class="btn btn-primary pull-right action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES)?></button>
                    </div>
                </form>
            </div>
            
        </div>
        
    </div>

    <div class="col-md-8 col-md-offset-2">
        
        <br>
        
        <div class="panel panel-form-media">

            <div class="panel-heading"><?=system_showText(LANG_SITEMGR_PLUGIN_INSTALL);?></div>

            <div class="panel-body">
                <form name="wordpress_plugin" id="wordpress_plugin">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="wordpress_url"><?=system_showText(LANG_SITEMGR_WORDPRESS_URL)?></label>
                            <input class="form-control" type="text" name="wordpress_url" id="wordpress_url" value="<?=$wordpress_url?>" />
                        </div>
                        <div class="form-group col-md-6">
                            <label><?=system_showText(LANG_SITEMGR_WORDPRESS_CLICK_BUTTON_VERIFY)?></label>
                            <input class="btn btn-primary btn-block action-save" type="submit" name="submit_form" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" value="<?=system_showText(LANG_SITEMGR_WORDPRESS_VERIFY)?>" />
                        </div>
                        <div id="download-box" class="<?=($wordpress_key ? "" : "hidden")?>">
                            <div class="form-group col-md-6">
                                <label><?=system_showText(LANG_SITEMGR_WORDPRESS_DOWNLOAD_PLUGIN)?></label>
                                <p class="help-block"><?=system_showText(LANG_SITEMGR_WORDPRESS_KEY)?>: <span id="wp_key"><?=$wordpress_key;?></span></p>
                            </div>
                            <div class="form-group col-md-6">
                                <br>
                                <input class="btn btn-success btn-block" type="button" onclick="download_wordpress_plugin('wordpress');" value="<?=system_showText(LANG_SITEMGR_WORDPRESS_DOWNLOAD)?>" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        
    </div>