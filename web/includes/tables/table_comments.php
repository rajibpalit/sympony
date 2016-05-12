<?

	/*==================================================================*\
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
	\*==================================================================*/

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/tables/table_comments.php
	# ---------------------------------------------------------------------------------------------------

	$wp_enabled = "";
?>
	
 	<table class="table table-bordered table-hovered">
        <thead>
    		<tr>
    			<? if ($reply_id) { ?>
    			<th><?=system_showText(LANG_LABEL_REPLY);?></th>
    			<? } else { ?>
    			<th><?=system_showText(LANG_LABEL_COMMENT);?></th>
    			<? } ?>
    			<th><?=system_showText(LANG_LABEL_POST);?></th>
    			<th><?=system_showText(LANG_LABEL_ADDED);?></th>
    			<th><?=string_ucwords(system_showText(LANG_LABEL_ACCOUNT));?></th>
    			<? if (!$wp_enabled) { ?>
                    <th><?=string_ucwords(system_showText(LANG_LABEL_STATUS));?></th>
    			<? } ?>
    			<th><?=system_showText(LANG_LABEL_OPTIONS)?></th>
    		</tr>
        </thead>
        <tbody>
		<? if ($reviewsArr) foreach($reviewsArr as $each_rate) {

			$hasReply = blog_getReply($each_rate->getNumber('id'));
			$post = new Post($each_rate->getNumber('post_id'));
			$item_id = $each_rate->getNumber("post_id");
			?>

			<tr>
				<td>
					<?
					if ($each_rate->getString("description")) {
						$comment_title = strip_tags($each_rate->getString("description", false, 30));
					} else {
						$comment_title = system_showText(LANG_NA);
					}
					?>

					<?=$comment_title?>
				</td>
				<td>
					<? $post_title = $post->getString("title", true, 30); ?>
					<a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/content/<?=BLOG_FEATURE_FOLDER;?>/blog.php?id=<?=$post->getNumber("id")?>&screen=<?=$screen?>&letter=<?=$letter?>" class="link-table"><?=$post_title?></a>

				</td>
				<td><?=($each_rate->getString("added")) ? format_date($each_rate->getString("added"), DEFAULT_DATE_FORMAT, "datetime")." - ".$each_rate->getTimeString("added") : system_showText(LANG_NA);?></td>
				<td>
					<?
					$account_id = $each_rate->getNumber("member_id");
					$account = new Contact($account_id);
					if ($account->getString("first_name")) {
						$reviewer_name = system_showTruncatedText($account->getString("first_name")." ".$account->getString("last_name"), 25);
					} else {
						$reviewer_name = system_showText(LANG_NA);
					}
					?>

					<a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/account/sponsor/sponsor.php?id=<?=$account_id?>&screen=<?=$screen?>&letter=<?=$letter?><?=(($url_search_params) ? "&$url_search_params" : "")?>" class="link-table" title="<?=$reviewer_name?>">
                        <?=$reviewer_name?>
					</a>
				</td>

				<? if (!$wp_enabled) { ?>
                <td>
					
                	<? if ($each_rate->getNumber("approved") == 0) { ?>
                		<span class="text-warning"><?=(system_showText(LANG_LABEL_PENDING_APPROVAL))?></span>
            		<? } ?>
					
					<? if ($each_rate->getNumber("approved") == 1) { ?>
                		<span class="text-success"><?=(system_showText(LANG_LABEL_APPROVED))?></span>
            		<? } ?>
            		
				</td>
				<? } ?>
                
                <td>

                    <? if ($each_rate->getNumber("approved") == 0) { ?> 
                        <a class="btn btn-info btn-xs" href='javascript:void(0);' onclick='showStatusField(<?=$each_rate->getNumber('id');?>);'>
                            <?=(system_showText(LANG_REVIEW_APPROVE))?>
                        </a>
                    <? } ?>
                    
                    <? if (!$wp_enabled) { ?>
                        <? if (!$reply_title) { ?>
                            <? if (!$hasReply) { ?>
                                <a href="javascript:void(0);" class="btn btn-default btn-xs disabled"><?=system_showText(LANG_LABEL_REPLY);?></a> 
                            <? } else { ?>
                                <a class="btn btn-primary btn-xs" href="<?=$url_redirect?>/index.php?item_type=blog&reply_id=<?=$each_rate->getNumber("id")?>">
                                    <?=system_showText(LANG_LABEL_REPLY);?>
                                </a>
                            <? } ?>
                        <? } ?>
                    <? } ?>

                    <a class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-delete" href="#" onclick="$('#delete-id').val(<?=$each_rate->getNumber('id');?>); $('#item-id').val(<?=$item_id;?>); $('#item-type').val('<?=$item_type;?>')">
                        <?=system_showText(LANG_SITEMGR_DELETE)?>
                    </a>
                            
				</td>
			</tr>

             <? // Status Edit Form ?>
            <tr id="statusTR<?=$each_rate->getNumber('id');?>" class="hideForm" style="display:none">
                <td colspan="7" id="statusTD<?=$each_rate->getNumber('id');?>" class="table-in-content">
                    <form name="formStatus" action="review/status.php">

                        <p class="alert alert-warning"  style="display:none" id="informationMessageStatus"><?=system_showText(LANG_STATUS_EMPTY);?></p>
                        
                        <input type="hidden" name="post_id" value="<?=$each_rate->getNumber('post_id');?>">
                        <input type="hidden" name="idComment" value="<?=$each_rate->getNumber('id');?>">
                        <input type="hidden" name="item_type" value="blog">
                        <input type="hidden" name="item_id" value="<?=$item_id;?>">
                        <input type="hidden" name="screen" value="<?=$_GET['screen']?>">
                        <input type="hidden" name="letter" value="<?=$_GET['letter']?>">
                                                
                        <? if ($each_rate->getNumber("approved") == 0) { ?>
                        <div class="form-group col-xs-12 text-center">
                            <div class="radio-inline">
                                <label>
                                    <input type="radio" name="status" value="comment" id="approve_comment<?=$each_rate->getNumber('id');?>">
                                    <?=($reply_id ? system_showText(LANG_SITEMGR_APPROVE_REPLY) : system_showText(LANG_SITEMGR_APPROVE_COMMENT))?>
                                </label>
                            </div>
                        </div>
                        <? } ?>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" name="submit" value="Submit"  class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                                <button type="reset"  name="cancel" value="Cancel" class="btn btn-default" onclick="hideStatusField(<?=$each_rate->getNumber('id');?>);"><?=system_showText(LANG_BUTTON_CANCEL);?></button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        <? } ?>
        </tbody>
    </table>