<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-listing-backlink.php
	# ----------------------------------------------------------------------------------------------------
?>

    <div class="col-sm-8">

        <div class="panel panel-form">

            <div class="form-group">
                <div class="panel-heading"><?=system_showText(LANG_SITEMGR_LISTING_SING);?> <?=string_ucwords(system_showText(LANG_LABEL_BACKLINK))?></div>
                <div class="panel-body">
                    
                    <? if ($message_backlink) { ?>
                    <div class="alert alert-warning" role="alert">
                        <p><?=$message_backlink;?></p>
                    </div>
                    <? } ?>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <div class="checkbox">
                                <br>
                                <label>
                                    <input type="checkbox" name="backlink" value="1" class="inputCheck" <?=$backlinkCheck || $backlink ? "checked" : ""?>>
                                    <?=system_showText(LANG_MSG_CLICK_TO_ADD_BACKLINK);?>
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="url">
                                <?=system_showText(LANG_LABEL_BACKLINK_URL);?>
                            </label>
                            <input type="text" name="backlink_url" value="<?=$backlink_url?>" class="form-control" id="url">
                            <p class="help-block"><?=system_showText(LANG_LABEL_BACKLINK_URL_TIP);?></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <br>
        <div class="panel panel-default">
            <div class="panel-body">
                <p><?=system_showText(LANG_SITEMGR_BACKLINK_USETIP)?></p>
            </div>
        </div>
    </div>
