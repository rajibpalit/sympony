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
	# * FILE: /includes/tables/table_review.php
	# ---------------------------------------------------------------------------------------------------

 ?>
        
	<table class="table table-bordered">
        <thead>
            <tr>
                <th><?=system_showText(LANG_LABEL_ADVERTISE_REVIEW_TITLE);?></th>
                <th><?=($_GET["item_id"] ? system_showText(LANG_LABEL_TYPE) : ucfirst(@constant('LANG_'.string_strtoupper($item_type).'_TITLE')))?></th>
                <th><?=system_showText(LANG_LABEL_ADDED);?></th>
                <th><?=string_ucwords(system_showText(LANG_LABEL_RATING));?></th>
                <th><?=string_ucwords(system_showText(LANG_LABEL_EVALUATOR));?></th>
                <th><?=system_showText(LANG_LABEL_OPTIONS)?></th>
            </tr>
        </thead>
        
        <tbody>

		<?

        if ($reviewsArr) foreach($reviewsArr as $each_rate) {
            
            $rate = $each_rate->getNumber('rating');
    
            $info = array();
			$item_type = $each_rate->getString('item_type');
			$item_id = $each_rate->getNumber("item_id");
			if ($item_type == 'listing') $itemObj = new Listing($item_id); else if ($item_type == 'article') $itemObj = new Article($item_id); else if ($item_type == 'promotion') $itemObj = new Promotion($item_id);
			
            $info["review"] = addslashes($each_rate->getString("review", true));
			if ($item_type != 'promotion'){
				$info["item_title"] = addslashes($itemObj->getString("title" , true));
			} else {
				$info["item_title"] = addslashes($itemObj->getString("name" , true));
			}
            $info["item_title"] = htmlspecialchars($info["item_title"]);
            if (string_strlen($each_rate->getString("response")) > 0) $info["response"] = addslashes($each_rate->getString("response", true));
			// review is a text field type so search for \r \n to not mess javascript
			$info["review"] = str_replace("\r\n", "<br>", $info["review"]);
			$info["review"] = str_replace("\r", "<br>", $info["review"]);
			$info["review"] = str_replace("\n", "<br>", $info["review"]);
			// if review size > 200, get only first 200 chars and put "..."
			$info["review"] = system_showTruncatedText($info["review"], 200);
            
            // response is a text field type so search for \r \n to not mess javascript
            if ($info["response"]) { 
                $info["response"] = str_replace("\r\n", "<br>", $info["response"]);
                $info["response"] = str_replace("\r", "<br>", $info["response"]);
                $info["response"] = str_replace("\n", "<br>", $info["response"]);
                // if response size > 200, get only first 200 chars and put "..."
                $info["response"] = system_showTruncatedText($info["response"], 200);
            }
			?>
			<tr>                
				<td>
					<?
					if ($each_rate->getString("review_title")) {
						$review_title = $each_rate->getString("review_title");
					} else {
						$review_title = system_showText(LANG_NA);
					}
					?>
                    <a href="javascript:void(0);" onclick="showReviewField(<?=$each_rate->getNumber('id');?>);"><?=$review_title?></a>
				</td>
                
                <? if ($_GET["item_id"]) { ?>
                    <td><?=ucfirst(@constant('LANG_'.string_strtoupper($each_rate->getString("item_type"))))?></td>
                <? } else { ?>
                    <td><a href="<?=DEFAULT_URL."/".SITEMGR_ALIAS."/content/".$each_rate->getString("item_type")."/index.php?search_title=".$itemObj->getString(($item_type != "promotion" ? "title" : "name"))?>" target="_blank"><?=$itemObj->getString(($item_type != "promotion" ? "title" : "name"), true);?></a></td>
                <? } ?>
                
				<td><?=($each_rate->getString("added")) ? format_date($each_rate->getString("added"), DEFAULT_DATE_FORMAT, "datetime")." - ".format_getTimeString($each_rate->getNumber("added")) : system_showText(LANG_NA);?></td>
				
                <td><?=($each_rate->getString("rating")) ? $each_rate->getString("rating", true) : system_showText(LANG_NA);?></td>
                
				<td>
					<?
					if ($each_rate->getString("reviewer_name")) {
						$reviewer_name = $each_rate->getString("reviewer_name", true, 25);
					} else {
						$reviewer_name = system_showText(LANG_NA);
					}
					?>
					<?=$reviewer_name?>
				</td>

                <td nowrap class="text-right">
                   
                    <? if ($each_rate->getNumber("approved") == 0 || (string_strlen(trim($each_rate->getString("response"))) > 0 && $each_rate->getNumber("responseapproved") == 0)) { ?>
                        <a class="btn btn-xs btn-primary" href='javascript:void(0);' onclick='showStatusField(<?=$each_rate->getNumber('id');?>);'>
                            <?=string_ucwords(system_showText(LANG_SITEMGR_APPROVE_REVIEW))?>/<?=string_ucwords(system_showText(LANG_REPLYNOUN))?>
                        </a>
                    <? } ?>
                    
                    <a class="btn btn-xs btn-primary" href='javascript:void(0);' onclick='showReviewField(<?=$each_rate->getNumber('id');?>);'>
                        <?=system_showText(LANG_LABEL_EDIT_REVIEW);?>
                    </a>
                    <? if (string_strlen(trim($each_rate->getstring("response"))) > 0) { ?>
                        <a class="btn btn-xs btn-primary" href='javascript:void(0);' onclick='showReplyField(<?=$each_rate->getNumber('id');?>);'>
                            <?=system_showText(LANG_LABEL_EDIT_REPLY);?>
                        </a>
                    <? } ?>
                    <a class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-delete" href="#" onclick="$('#delete-id').val(<?=$each_rate->getNumber('id');?>); $('#item-id').val(<?=$item_id;?>); $('#item-type').val('<?=$item_type;?>')">
                        <?=system_showText(LANG_LABEL_DELETE);?>
                    </a>

				</td>
			</tr>
            
            <?// Edit Form ?>
            <tr id="ReviewTR<?=$each_rate->getNumber('id');?>" class="hideForm" style="display:none">
                <td colspan="6" id="ReviewTD<?=$each_rate->getNumber('id');?>" class="table-in-content">
                    <? include(INCLUDES_DIR."/forms/form_review_sitemgr.php"); ?>
                </td>
            </tr>
            
            <?// Approve Form ?>
            <tr id="statusTR<?=$each_rate->getNumber('id');?>" class="hideForm" style="display:none">
                <td colspan="6" id="statusTD<?=$each_rate->getNumber('id');?>" class="innerTable">
                    <form name="formStatus" action="review/status.php">
                        <p class="alert alert-info"  style="display:none" id="informationMessageStatus"><?=system_showText(LANG_STATUS_EMPTY);?></p>
                        <input type="hidden" name="item_id" value="<?=$each_rate->getNumber('item_id');?>">
                        <input type="hidden" name="item_type" value="<?=$each_rate->getNumber('item_type');?>">
                        <input type="hidden" name="idReview" value="<?=$each_rate->getNumber('id');?>">
                        <input type="hidden" name="screen" value="<?=$_GET['screen']?>"> 
                        <input type="hidden" name="letter" value="<?=$_GET['letter']?>">
                        
                        <div class="form-group col-xs-12 text-center">
                            <? if ($each_rate->getNumber("approved") == 0) {?>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="status" value="review" id="approve_review<?=$each_rate->getNumber('id');?>">&nbsp;<?=system_showText(LANG_SITEMGR_APPROVE_REVIEW)?>
                                    </label>
                                </div>
                            <? } ?>
                            
                            <? if (string_strlen(trim($each_rate->getString("response"))) > 0 && $each_rate->getNumber("responseapproved") == 0 && $each_rate->getNumber("approved") == 1) {?>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="status" value="reply" id="approve_reply<?=$each_rate->getNumber('id');?>">&nbsp;<?=system_showText(LANG_SITEMGR_APPROVE_REPLY)?>
                                    </label>
                                </div>                            
                            <? } ?>
                            
                            <? if (string_strlen(trim($each_rate->getString("response"))) > 0 && $each_rate->getNumber("responseapproved") == 0 && $each_rate->getNumber("approved") == 0) {?>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="status" value="both" id="approve_both<?=$each_rate->getNumber('id');?>">&nbsp;<?=system_showText(LANG_SITEMGR_APPROVE);?> <?=system_showText(LANG_REVIEWANDREPLY);?>
                                    </label>
                                </div>
                            <? } ?>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                                <button type="reset"  name="cancel" value="Cancel" class="btn btn-default" onclick="hideStatusField(<?=$each_rate->getNumber('id');?>);"><?=system_showText(LANG_BUTTON_CANCEL);?></button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            
            <?// Reply Edit Form ?>
            <tr id="replyReviewTR<?=$each_rate->getNumber('id');?>" class="hideForm" style="display:none">
                <td colspan="8" id="replyReviewTD<?=$each_rate->getNumber('id');?>" class="innerTable">
                    <form name="formReply" action="review/reply.php">
                        <p class="alert alert-warning" style="display:none" id="errorMessageReply"></p>
                        <input type="hidden" name="item_id" value="<?=$each_rate->getNumber('item_id');?>">
                        <input type="hidden" name="item_type" value="<?=$each_rate->getNumber('item_type');?>">
                        <input type="hidden" name="idReview" value="<?=$each_rate->getNumber('id');?>">
                        <input type="hidden" name="screen" value="<?=$_GET['screen']?>">
                        <input type="hidden" name="letter" value="<?=$_GET['letter']?>">
                        
                        <div class="form-group">
                            <label for="reply<?=$each_rate->getNumber('id');?>"><?=$review_title;?></label>
                            <textarea class="form-control" name="reply" id="reply<?=$each_rate->getNumber('id');?>" rows="5"><?=$each_rate->getString('response');?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                                <button type="reset"  name="cancel" value="Cancel" class="btn btn-default" onclick="hideReplyField(<?=$each_rate->getNumber('id');?>);"><?=system_showText(LANG_BUTTON_CANCEL);?></button>
                            </div>
                        </div>
                            
                    </form>
                </td>
            </tr>
         
		<? } ?>
        </tbody>
	</table>