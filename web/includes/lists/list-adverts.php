<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/lists/list-adverts.php
	# ----------------------------------------------------------------------------------------------------

    if (is_numeric($message) && isset($msg_appAdvert[$message])) { ?>
        <p class="alert alert-success"><?=$msg_appAdvert[$message]?></p>
    <? } ?>

    <section>

        <ul class="list-content-item tree">

        <? foreach($adverts as $advert) { $id = $advert->getNumber("id"); ?>

            <li class="content-item-noview">
                <div class="status text-hide"><?=$statusObj->getStatusWithStyle($advert->getString("status"));?></div>
                <div class="item">
                    <h3 class="item-title">
                        <?=$advert->getString("title", true, 40);?>
                    </h3>
                    <p><?=system_showText(LANG_SITEMGR_MOBILE_EXPIRY);?>: <span title="<?=format_date($advert->getString("expiration_date"))?>" style="cursor:default"><?=format_date($advert->getString("expiration_date"));?></span></p>
                    <p>
                        <span class="pull-right"> <?=$statusObj->getStatusWithStyle($advert->getString("status"));?></span>
                    </p>
                    <a href="<?=$url_redirect?>/advert.php?id=<?=$id?>&screen=<?=$screen?>&letter=<?=$letter?><?=(($url_search_params) ? "&$url_search_params" : "")?>">
                        <?=system_showText(LANG_LABEL_EDIT);?>
                    </a>
                    <b>|</b>
                    <a class="btn btn-icon btn-danger" data-toggle="modal" data-target="#modal-delete" href="#" onclick="$('#delete-id').val(<?=$id?>)" title="<?=system_showText(LANG_LABEL_DELETE);?>"><i class="icon-waste2"></i> <?=system_showText(LANG_LABEL_DELETE);?></a>
                </div>
            </li>

        <? } ?>

        </ul>

    </section>