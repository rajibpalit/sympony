<?
/* ==================================================================*\
  ######################################################################
  #                                                                    #
  # Copyright 2005 Arca Solutions, Inc. All Rights Reserved.           #
  #                                                                    #
  # This file may not be redistributed in whole or part.               #
  # eDirectory is licensed on a per-domain basis.                      #
  #                                                                    #
  # ---------------- eDirectory IS NOT FREE SOFTWARE ----------------- #
  #                                                                    #
  # http://www.edirectory.com | http://www.edirectory.com/license.html #
  ######################################################################
  \*================================================================== */

# ----------------------------------------------------------------------------------------------------
# * FILE: /includes/tables/table_checkin.php
# ---------------------------------------------------------------------------------------------------

?>

<table class="table table-bordered table-hovered">
    <thead>
        <tr>
            <th><?= system_showText(LANG_CHECK_IN); ?></th>
            <th><?= system_showText(LANG_LABEL_ITEM); ?></th>
            <th><?= system_showText(LANG_LABEL_ADDED); ?></th>
            <th><?= string_ucwords(system_showText(LANG_LABEL_ACCOUNT)); ?></th>
            <th><?= system_showText(LANG_LABEL_OPTIONS) ?></th>
        </tr>
    </thead>
    <tbody>
        <?
        if ($reviewsArr)
            foreach ($reviewsArr as $each_rate) {

                $item_id = $each_rate->getNumber("item_id");
                $checkintype = ucfirst($each_rate->getString('item_type'));
                $itemObj = new $checkintype($item_id);
                
                ?>

                <tr>
                    <td>
                        <?
                        if ($each_rate->getString("quick_tip")) {
                            $quick_tip = $each_rate->getString("quick_tip", false, 30);
                        } else {
                            $quick_tip = system_showText(LANG_NA);
                        }
                        ?>

                        <?= $quick_tip ?>
                    </td>
                    <td>
                        <? $item_title = $itemObj->getString("title", true, 30); ?>
                        <a href="<?= DEFAULT_URL ?>/<?= SITEMGR_ALIAS ?>/content/<?= @constant(strtoupper($checkintype)."_FEATURE_FOLDER"); ?>/<?=strtolower($checkintype)?>.php?id=<?= $itemObj->getNumber("id") ?>&screen=<?= $screen ?>&letter=<?= $letter ?>" class="link-table"><?= $item_title ?></a>
                    </td>
                    <td><?= ($each_rate->getString("added")) ? format_date($each_rate->getString("added"), DEFAULT_DATE_FORMAT, "datetime") : system_showText(LANG_NA); ?></td>
                    <td>
                        <?
                        $account_id = $each_rate->getNumber("member_id");
                        $account = new Account($account_id);
                        $contact = new Contact($account_id);
                        $pathAccount = "visitor";
                        if ($account->getString("is_sponsor") == "y") {
                            $pathAccount = "sponsor";
                        }
                        if ($contact->getString("first_name")) {
                            $user_name = system_showTruncatedText($contact->getString("first_name") . " " . $contact->getString("last_name"), 25);
                        } else {
                            $user_name = system_showText(LANG_NA);
                        }
                        
                        
                        if ($contact->getString("first_name")) { ?>

                        <a href="<?= DEFAULT_URL ?>/<?= SITEMGR_ALIAS ?>/account/<?=$pathAccount?>/<?=$pathAccount?>.php?id=<?= $account_id ?>&screen=<?= $screen ?>&letter=<?= $letter ?><?= (($url_search_params) ? "&$url_search_params" : "") ?>" class="link-table" title="<?= $user_name ?>">
                        <? } ?>
                            <?= $user_name ?>
                            
                        <? if ($contact->getString("first_name")) { ?>
                        </a>
                        
                        <? } ?>
                    </td>

                    <td>

                        <a class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-delete" href="#" onclick="$('#delete-id').val(<?= $each_rate->getNumber('id'); ?>);
                            $('#item-id').val(<?= $item_id; ?>);
                            $('#item-type').val('checkin')">
                            <?= system_showText(LANG_SITEMGR_DELETE) ?>
                        </a>

                    </td>
                </tr>

        <? } ?>
    </tbody>
</table>