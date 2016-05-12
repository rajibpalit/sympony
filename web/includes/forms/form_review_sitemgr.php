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
	# * FILE: /includes/forms/form_review_sitemgr.php
	# ----------------------------------------------------------------------------------------------------
   
?>

    <p class="alert alert-warning"  style="display:none" id="errorMessageReview"></p>

    <form name="formReview" action="review/review.php" method="post">

        <? if ($message_review) { ?>
            <p class="alert alert-warning"><?=$message_review?></p>
        <? } ?>
            
        <input type="hidden" name="rating_<?=$each_rate->getNumber('id');?>" id="rating_<?=$each_rate->getNumber('id');?>" value="">
        <input type="hidden" name="item_id" value="<?=$each_rate->getNumber('item_id');?>">
        <input type="hidden" name="item_type" value="<?=$each_rate->getNumber('item_type');?>">
        <input type="hidden" name="idReview" value="<?=$each_rate->getNumber('id');?>">
        <? if ($filter_id) { ?>
        <input type="hidden" name="filter_id" value="1">
        <? } ?>

        <div class="row">
            <div class="col-md-6 col-md-offset-3 well">
                <div class="row">
                    <div id="star_<?=$each_rate->getNumber('id');?>" class="col-xs-12 text-center">
                        <?
                        $img_id = "star_".$each_rate->getNumber('id')."";
                        $rating_id = "rating_".$each_rate->getNumber('id')."";
                        ?>
                        <?=system_showText(LANG_SITEMGR_REVIEW_RATEIT)?>:
                        <img align="absmiddle" border="0" src="<?=DEFAULT_URL?>/assets/images/structure/review-star-o.png" onclick="setRatingLevel(1, '<?=$rating_id?>', '<?=$img_id?>')" onmouseover="setDisplayRatingLevel(1, '<?=$img_id?>')" alt="star" /><img align="absmiddle" border="0" src="<?=DEFAULT_URL?>/assets/images/structure/review-star-o.png" onclick="setRatingLevel(2, '<?=$rating_id?>', '<?=$img_id?>')" onmouseover="setDisplayRatingLevel(2, '<?=$img_id?>')" alt="star" /><img align="absmiddle" border="0" src="<?=DEFAULT_URL?>/assets/images/structure/review-star-o.png" onclick="setRatingLevel(3, '<?=$rating_id?>', '<?=$img_id?>')" onmouseover="setDisplayRatingLevel(3, '<?=$img_id?>')" alt="star" /><img align="absmiddle" border="0" src="<?=DEFAULT_URL?>/assets/images/structure/review-star-o.png" onclick="setRatingLevel(4, '<?=$rating_id?>', '<?=$img_id?>')" onmouseover="setDisplayRatingLevel(4, '<?=$img_id?>')" alt="star" /><img align="absmiddle" border="0" src="<?=DEFAULT_URL?>/assets/images/structure/review-star-o.png" onclick="setRatingLevel(5, '<?=$rating_id?>', '<?=$img_id?>')" onmouseover="setDisplayRatingLevel(5, '<?=$img_id?>')" alt="star" />
                    </div>
                </div>
                
                <hr>
                
                <div class="form-group row">	
                    <div class="col-sm-4">
                        <label for="reviewer_name<?=$each_rate->getNumber('id');?>"><?=system_showText(LANG_SITEMGR_LABEL_NAME)?></label>
                        <input class="form-control" type="text" name="reviewer_name" id="reviewer_name<?=$each_rate->getNumber('id');?>" value="<?=$each_rate->getString("reviewer_name", true, 0, "...", false);?>" maxlength="50">
                    </div>
                    <div class="col-sm-4">
                        <label for="reviewer_email<?=$each_rate->getNumber('id');?>"><?=system_showText(LANG_SITEMGR_LABEL_EMAIL)?></label>
                        <input class="form-control" type="text" name="reviewer_email" id="reviewer_email<?=$each_rate->getNumber('id');?>" value="<?=$each_rate->getString("reviewer_email", true, 0, "...", false);?>" maxlength="100">
                    </div>
                    <div class="col-sm-4">
                        <label for="reviewer_location<?=$each_rate->getNumber('id');?>"><?=system_showText(LANG_SITEMGR_LABEL_CITY_STATE)?></label>
                        <input class="form-control" type="text" name="reviewer_location" id="reviewer_location<?=$each_rate->getNumber('id');?>" value="<?=$each_rate->getString("reviewer_location", true, 0, "...", false);?>" maxlength="50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="review_title<?=$each_rate->getNumber('id');?>"><?=system_showText(LANG_SITEMGR_TITLE)?></label>
                    <input class="form-control" type="text" name="review_title" id="review_title<?=$each_rate->getNumber('id');?>" value="<?=$each_rate->getString("review_title", true, 0, "...", false);?>" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="review<?=$each_rate->getNumber('id');?>"><?=system_showText(LANG_SITEMGR_LABEL_COMMENT)?></label>
                    <textarea class="form-control" name="review" id="review<?=$each_rate->getNumber('id');?>" class="input-textarea-form-rate" rows="4"><?=$each_rate->getString("review", true, 0, "...", false);?></textarea>
                </div>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" name="submit" value="Submit" class="btn btn-primary action-save"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
                        <button type="reset"  name="cancel" value="Cancel" class="btn btn-default" onclick="hideReviewField(<?=$each_rate->getNumber('id');?>);"><?=system_showText(LANG_BUTTON_CANCEL);?></button>
                    </div>
                </div>
            </div>
        </div>

    </form>