<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /includes/forms/form-plugin-sugar.php
    # ----------------------------------------------------------------------------------------------------

?>

    <div class="col-md-8 col-md-offset-2">

        <div class="panel panel-form-media">

            <div class="panel-heading"><?=system_showText(LANG_SITEMGR_PLUGIN_INSTALL);?></div>

            <div class="panel-body">
                <form name="sugar_plugin" id="sugar_plugin">
                    
                    <input type="hidden" name="plugin_type" value="sugar">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sugar_url"><?=system_showText(LANG_SITEMGR_SUGAR_CRM_URL)?></label>
                                <input class="form-control" type="text" name="sugar_url" id="sugar_url" value="<?=$sugar_url?>">
                            </div>
                            <div class="form-group">
                                <label for="sugar_user"><?=system_showText(LANG_SITEMGR_SUGAR_ADMIN_USER_ID)?></label>
                                <input class="form-control" type="text" name="sugar_user" id="sugar_user" value="<?=$sugar_user?>">
                            </div>
                            <div class="form-group">
                                <label for="sugar_password"><?=system_showText(LANG_SITEMGR_SUGAR_PASSWORD)?></label>
                                <input class="form-control" type="text" name="sugar_password" id="sugar_password" value="<?=$sugar_password?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?=system_showText(LANG_SITEMGR_SUGAR_CLICK_BUTTON_VERIFY)?></label>
                                <input class="btn btn-primary btn-block action-save" type="submit" name="submit_form" value="<?=system_showText(LANG_SITEMGR_SUGAR_VERIFY)?>" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" />
                            </div>
                            <div class="form-group" id="sugar_download_button">
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>