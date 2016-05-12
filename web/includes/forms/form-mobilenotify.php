<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-mobilenotify.php
	# ----------------------------------------------------------------------------------------------------

?>
    <div class="col-sm-7">
        
        <div class="panel panel-form">

            <div class="panel-heading">
                <?=system_showText(LANG_SITEMGR_MOBILE_NOTIF_SING);?> - <?=system_showText(LANG_SITEMGR_MOBILE_IOSANDROID);?>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label for="title"><?=system_showText(LANG_SITEMGR_MOBILE_NOTIFTITLE);?></label>
                    <input class="form-control" type="text" name="title" id="title" placeholder="<?=system_showText(LANG_SITEMGR_MOBILE_NOTIFTITLE_MAXCHARS);?>" value="<?=$title?>" maxlength="24" />
                </div>

                <div class="form-group">
                    <label for="description"><?=system_showText(LANG_SITEMGR_MOBILE_NOTIFTEXT);?>:</label>
                    <input class="form-control" type="text" name="description" id="description" placeholder="<?=system_showText(LANG_SITEMGR_MOBILE_NOTIFTEXT_MAXCHARS);?>" value="<?=$description?>" maxlength="200" />
                </div>
      
                <div class="form-group row">

                    <div class="col-sm-6">
                        <label for="expiration_date"><?=system_showText(LANG_SITEMGR_MOBILE_EXPIRY);?>:</label>
                        <input class="form-control  date-input" type="text" name="expiration_date" id="expiration_date" value="<?=$expiration_date?>" placeholder="(<?=format_printDateStandard()?>)" />
                    </div>

                    <div class="col-sm-6">
                        <label><?=system_showText(LANG_LABEL_STATUS)?></label>
                        <div class="selectize">
                            <?=$statusDropDown?>
                        </div>
                    </div>

                </div>
      
            </div>
        </div>

        <? if ($currentNotif) { ?>

          <div class="panel panel-form">

            <div class="panel-heading">
                <?=system_showText(LANG_SITEMGR_MOBILE_NOTIF_SING);?> - <span class="currently-running"><?=system_showText(LANG_SITEMGR_MOBILE_RUNNING);?></span>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label><?=system_showText(LANG_LABEL_TITLE);?>:</label>
                    <?=$currentNotif["title"];?>
                </div>

                <div class="form-group">
                    <label><?=system_showText(LANG_SITEMGR_MOBILE_NOTIF_SING);?>:</label>
                    <?=$currentNotif["description"];?>
                </div>

            </div>

          </div>

        <? } ?>
    
    </div>

    <div class="col-sm-5">
        <br>
        <div class="panel panel-default">
            <div class="panel-body text-muted">
                <p><?=system_showText(LANG_SITEMGR_MOBILE_NOTIF_TIP2)?></p>
            </div>
        </div>
    </div>