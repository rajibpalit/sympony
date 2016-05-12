<?php
	/*==================================================================*\
	######################################################################
	#                                                                    #
	# Copyright 2015 Arca Solutions, Inc. All Rights Reserved.           #
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
	# * FILE: /includes/forms/form_backlinks.php
	# ----------------------------------------------------------------------------------------------------

    if ($message_backlink) {
        echo "<div class=\"alert alert-warning\">";
            echo $message_backlink;
        echo "</div>";
    }
    ?>

    <div class="row ">

		<div class="col-sm-6">
			<div class="content-custom">
				<h2><?=system_showText(str_replace("!", "", LANG_INCREASE_VISIBILITY));?></h2>
				<p>
				<h4><?=system_showText(LANG_LABEL_QUESTION1);?></h4>
				<?=system_showText(LANG_LABEL_ANSWER1);?><br /> <br />
				<h4><?=system_showText(LANG_LABEL_QUESTION2);?></h4>
				<?=system_showText(LANG_LABEL_ANSWER2);?><br /> <br />
				<h4><?=system_showText(LANG_LABEL_QUESTION3)?></h4>
				<?=system_showText(LANG_LABEL_ANSWER4);?><br />
				<strong><?=system_showText(LANG_LABEL_BACKLINKCODE_TIP);?></strong>
				</p>
			</div>
		</div>

        <div class="col-sm-6 text-center">
            <div class="panel panel-theme">
                <div class="panel-body">
            		<div class="form-group">
            			<p><?=system_showText(LANG_LABEL_PUTTHISCODE);?></p>
            			<textarea class="form-control" readonly rows="10"><?=$backlinks?></textarea>
            		</div>
            		<div class="form-group">
            			<p><?=system_showText(LANG_LABEL_ENTERURL);?>
            			<br /><small><?=system_showText(LANG_LABEL_ENTERURL_TIP);?></small></p>
            			<input class="form-control" type="text" id="website_url" name="backlink_url" value="<?=$backlink_url?>" />

            		</div>
            		<div class="form-group">
            			<p><?=system_showText(LANG_LABEL_VERIFYSITE);?></p>

            			<button type="button" class="btn btn-primary btn-block" onclick="checkWebsite();"><?=system_showText(LANG_LABEL_VERIFY)?></button>
                        <p style="display:none" id="imgLoading"><span class="fa fa-spinner fa-spin"></span> </p>
                        <br>
                        <button type="button" class="btn btn-success btn-block disabled" id="continue" disabled="disabled" style="cursor: default;" onclick="addBacklink();"><?=system_showText(LANG_LABEL_CONFIRM_BACKLINK);?></button>


            		</div>
            	</div>
            </div>
        </div>
	</div>