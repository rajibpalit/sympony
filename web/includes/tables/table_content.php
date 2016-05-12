<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/tables/table_content.php
	# ----------------------------------------------------------------------------------------------------

    foreach ($arrayContents as $k => $Content) { ?>
        <section class="tab-pane <?=(($k == 0 && !$messageFaq) || ($k == (count($arrayContents) -1) && $messageFaq) ?  "active" : "")?>" id="pages-<?=$Content["type"]?>">
            
            <? if ($messageFaq) { ?>
                <div class="col-sm-12">
                    <p class="alert alert-<?=($error) ? "warning" : "success"?>"><?=system_showText($error ? $error : isset($_GET["del"]) ? LANG_SITEMGR_SETTINGS_MSG_DELETE_SUCCESS : ($_GET["stat"] ? $messageFaq : LANG_SITEMGR_SETTINGS_MSG_SAVE_SUCCESS ));?></p>
                </div>
			<? } ?>
            
            <? if ($Content["type"] == "Faq") { ?>
                <form name="FAQ_post" id="FAQ_post" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">
                	<input type="hidden" name="del_faq_id" id="faq_id">
                </form>
            <? } ?>
            
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?=system_showText($Content["title"])?>
                        <? if ($Content["type"] == "Faq") { ?>
                        <div class="pull-right">
                            <a href="javascript:void(0);" onclick="faq_add();"class="btn btn-primary btn-xs"><?=system_showText(LANG_SITEMGR_NEW_FAQ)?></a>
                        </div>
                        <? } ?>
                    </div>
                    
                    <? if ($Content["type"] == "Faq") { ?>
                    <form id="FAQ_add" role="form" class="hideForm" name="FAQ_add" action="<?=system_getFormAction($_SERVER["PHP_SELF"]);?>" method="post" style="display:none;">
                        
                        <div class="panel-body panel-border-bot">
                            <div class="col-xs-12">
                                <p class="alert alert-warning" id="jMessage" style="display: none;"></p>
                                <div class="form-group form-horizontal row">
                                    <label for="faq_question" class="col-xs-2 control-label"><?=system_showText(LANG_SITEMGR_SETTINGS_FAQ_QUESTION)?></label>
                                    <div class="col-xs-10">
                                        <textarea class="form-control" name="faq_question" id="faq_question" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-horizontal row">
                                    <label for="faq_answer" class="col-xs-2 control-label"><?=system_showText(LANG_SITEMGR_SETTINGS_FAQ_ANSWER)?></label>
                                    <div class="col-xs-10">
                                        <textarea class="form-control" name="faq_answer" id="faq_answer" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-horizontal row">
                                    <label class="col-xs-2 control-label"><?=system_showText(LANG_SITEMGR_LABEL_SECTION)?></label>
                                    <div class="col-xs-10">
                                        <div class="checkbox-inline">
                                            <label>
                                                <input type="checkbox" name="faq_section_front">
                                                <?=system_showText(LANG_SITEMGR_FRONT)?>
                                            </label>
                                        </div>
                                        <div class="checkbox-inline">
                                            <label>
                                                <input type="checkbox" name="faq_section_members">
                                                <?=system_showText(LANG_SITEMGR_MEMBERS)?>
                                            </label>
                                        </div>
                                        <div class="checkbox-inline">
                                            <label>
                                                <input type="checkbox" name="faq_section_sitemgr">
                                                <?=system_showText(LANG_SITEMGR_SITEMGR)?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-10 col-xs-offset-2">
                                        <button class="btn btn-sm btn-primary action-save" type="submit" name="FAQ_post_submit" value="Submit" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE);?></button>
                                        <button class="btn btn-sm btn-default" type="button" onclick="hideForm();"><?=system_showText(LANG_BUTTON_CANCEL);?></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <? } ?>
                    
                    <? if (${"contents".$Content["type"]}) { ?>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <span><?=system_showText(LANG_SITEMGR_LABEL_NAME)?></span>
                                </th>
                                <? if ($Content["type"] != "Faq" && $Content["type"] != "Advertisement") { ?>
                                <th nowrap>
                                    <span><?=system_showText(LANG_SITEMGR_LASTUPDATED)?></span>
                                </th>
                                <? } ?>
                                <th class="text-center" width="140px">
                                    <span><?=system_showText(LANG_LABEL_OPTIONS)?></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach (${"contents".$Content["type"]} as $content) {
                            $id = $content->getNumber("id");
                            if ( $id == 68 ) {
                                if ( SITEMAP_FEATURE == 'off' ) continue;
                            }
                            $contentLabel = string_strtoupper($content->getString("type"));
                            $contentLabel = str_replace(" ", "_", $contentLabel);
                        ?>

                            <tr>
                                <? //Special for Faq Section
                                if ($Content["type"] == "Faq") { ?>
                                    <td class="faq-item">
                                        <b><?=$content->getString("question")?></b>
                                        <blockquote class="small"><?=$content->getString("answer")?></blockquote>

                                        <form id="FAQ_edit<?=$id?>" role="form" class="hideForm" name="FAQ_edit" action="<?=system_getFormAction($_SERVER["PHP_SELF"]);?>" method="post" style="display:none;">
                                            <div class="col-xs-12">
                                                <input type="hidden" name="faq_id" value="<?=$id?>">
                                                <p class="alert alert-warning" id="jMessageEdit<?=$id?>" style="display:none;"></p>
                                                <div class="form-group form-horizontal row">
                                                    <label for="faq_question_edit<?=$id?>" class="col-xs-2 control-label"><?=system_showText(LANG_SITEMGR_SETTINGS_FAQ_QUESTION)?>: </label>
                                                    <div class="col-xs-10">
                                                        <textarea class="form-control" name="faq_question_edit" id="faq_question_edit<?=$id?>" rows="2"><?=$content->getString("question")?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group form-horizontal row">
                                                    <label for="faq_answer_edit<?=$id?>" class="col-xs-2 control-label"><?=system_showText(LANG_SITEMGR_SETTINGS_FAQ_ANSWER)?>: </label>
                                                    <div class="col-xs-10">
                                                        <textarea class="form-control" name="faq_answer_edit" id="faq_answer_edit<?=$id?>" rows="4"><?=$content->getString("answer")?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group form-horizontal row">
                                                    <label class="col-xs-2 control-label"><?=system_showText(LANG_SITEMGR_LABEL_SECTION)?>: </label>
                                                    <div class="col-xs-10">
                                                        <div class="checkbox-inline">
                                                            <label>
                                                                <input type="checkbox" name="faq_section_front_edit" <?=($content->getString("frontend") == 'y') ? "checked=\"checked\"" : ""?>>
                                                                <?=system_showText(LANG_SITEMGR_FRONT)?>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox-inline">
                                                            <label>
                                                                <input type="checkbox" name="faq_section_members_edit" <?=($content->getString("member") == 'y') ? "checked=\"checked\"" : ""?>>
                                                                <?=system_showText(LANG_SITEMGR_MEMBERS)?>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox-inline">
                                                            <label>
                                                                <input type="checkbox" name="faq_section_sitemgr_edit" <?=($content->getString("sitemgr") == 'y') ? "checked=\"checked\"" : ""?>>
                                                                <?=system_showText(LANG_SITEMGR_SITEMGR)?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-10 col-xs-offset-2">
                                                        <button class="btn btn-sm btn-primary action-save" type="submit" name="FAQ_edit_submit" value="Submit" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>"><?=system_showText(LANG_SITEMGR_SAVE);?></button>
                                                        <button class="btn btn-sm btn-default" type="button" onclick="hideFormFaq('FAQ_edit<?=$id?>');"><?=system_showText(LANG_BUTTON_CANCEL);?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>

                                <? } else { ?>
                                    <td>
                                        <a href="content.php?id=<?=$id?>">
                                            <?=system_showText(constant("LANG_SITEMGR_CONTENT_".$contentLabel))?>
                                        </a>
                                    </td>
                                <? } ?>

                                <? if ($Content["type"] != "Faq" && $Content["type"] != "Advertisement") { ?>
                                <td>
                                    <?
                                    if ($content->getNumber("updated") == 0) {
                                        echo system_showText(LANG_SITEMGR_NOTUPDATED);
                                    } else {
                                        echo format_date($content->getNumber("updated"), DEFAULT_DATE_FORMAT, "datetime")." - ".format_getTimeString($content->getNumber("updated"));
                                    }
                                    ?>
                                </td>
                                <? } ?>
                                
                                <td nowrap class="main-options text-center">
                                    <? if ($Content["type"] != "Faq") { ?>
                                    <a class="btn btn-primary btn-xs text-capitalize" href="content.php?id=<?=$id?>">
                                        <?=string_strtolower(system_showText(LANG_SITEMGR_EDIT))?>
                                    </a>
                                    <? } else { ?>
                                    <a class="btn btn-primary btn-xs text-capitalize" href="javascript: void(0);" onclick="faq_edit(<?=$id?>)">
                                        <?=string_strtolower(system_showText(LANG_SITEMGR_EDIT))?>
                                    </a>
                                    <a class="btn btn-warning btn-xs text-capitalize" href="javascript: void(0);" onclick="faq_delete(<?=$id?>)">
                                        <?=string_strtolower(system_showText(LANG_SITEMGR_DELETE))?>
                                    </a>
                                    <? } ?>
                                </td>
                            </tr>

                        <? } ?>
                    </tbody>
                    </table>
                    </div>
                    <? } elseif ($Content["type"] == "Faq") { ?>
                    <div class="col-sm-12">
                        <br>
                        <p class="alert alert-info"><?=system_showText(LANG_SITEMGR_SETTINGS_FAQ_NOFAQ);?></p>
                    </div>
                    <? } ?>
                </div>
                
                <? if ($Content["type"] == "Advertisement" && ${"contents".$Content["type"]}) {
                    foreach ($arrayContentLevels as $contentLevel) { ?>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?=string_ucwords(system_showText(constant("LANG_SITEMGR_".string_strtoupper($contentLevel))))?>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <span><?=system_showText(LANG_SITEMGR_LABEL_NAME)?></span>
                                </th>
                                <th class="text-center" width="140px">
                                    <span><?=system_showText(LANG_LABEL_OPTIONS)?></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach (${$contentLevel."levelValue"} as $value) {
                        ?>

                            <tr>
                                <td>
                                    <a href="contentlevel.php?section=<?=$contentLevel?>&value=<?=$value?>">
                                        <?=${$contentLevel."levelObj"}->showLevel($value)?>
                                    </a>
                                </td>
                                <td nowrap class="main-options text-center">
                                    <a class="btn btn-primary btn-xs text-capitalize" href="contentlevel.php?section=<?=$contentLevel?>&value=<?=$value?>">
                                        <?=string_strtolower(system_showText(LANG_SITEMGR_EDIT))?>
                                    </a>
                                </td>
                            </tr>

                        <? } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                    <? }
                } ?>
            </div>
        </section>
    <?
    }
?>