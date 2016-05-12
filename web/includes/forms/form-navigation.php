<?php
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-navigation.php
	# ----------------------------------------------------------------------------------------------------

?>

    <input type="hidden" name="order_options" id="order_options" value="" />
    <input type="hidden" name="aux_count_li" id="aux_count_li" value="<?=count($arrayOptions)?>" />
    <input type="hidden" name="SaveByAjax" value="true" id="SaveByAjax" value=""/>

    <div class="form-group row">
        <div class="col-md-2 col-sm-4">
            <label class=" text-right"><?=system_showText(LANG_SITEMGR_SECTION)?>:</label>
            <div class="selectize">
                <select name="navigation_area" id="navigation_area" onchange="ChangeArea(this.value)">
                    <option value="header" <?=($navigation_area == "header" ? "selected" : "")?>><?=system_showText(LANG_SITEMGR_HEADER)?></option>
                    <option value="footer" <?=($navigation_area == "footer" ? "selected" : "")?>><?=system_showText(LANG_SITEMGR_FOOTER)?></option>
                </select>
            </div>
        </div>
    </div>

    <div class="row text-center sortable-title">
        <div class="col-sm-1 col-xs-2"><?=system_showText(LANG_SITEMGR_NAVIGATION_ORDER)?></div>
        <div class="col-sm-4 col-xs-4"><?=system_showText(LANG_SITEMGR_NAVIGATION_NAVIGATION_TEXT)?></div>
        <div class="col-sm-3 col-xs-3"><?=system_showText(LANG_SITEMGR_NAVIGATION_LINKS_TO)?></div>
        <div class="col-sm-3 col-xs-3"><?=system_showText(LANG_SITEMGR_NAVIGATION_CUSTOM_LINK)?></div>
    </div>

    <ul id="sortable" class="list-sortable list-lg">
        <? for ($i = 0; $i < count($arrayOptions); $i++) { ?>
            <li class="row" id="<?=$i?>">
                <p>
                    <span class="col-sm-1 col-xs-2 text-center"><i class="drag"></i></span>
                    <span class="col-sm-4 col-xs-4"><input type="text" class="form-control" name="navigation_text_<?=$i?>" id="navigation_text_<?=$i?>" value="<?=$arrayOptions[$i]["label"]?>" /></span>
                    <span class="col-sm-3 col-xs-3">
                        <span class="selectize">
                            <select name="dropdown_link_to_<?=$i?>" id="dropdown_link_to_<?=$i?>" onchange="enableCustomLink(<?=$i?>)">
                                <? for($j = 0; $j < count($array_modules); $j++) {
                                    
                                    $moduleOn = false;
                                    if ($array_modules[$j]["module"]) {
                                        if ((constant($array_modules[$j]["module"]) == "on") && (constant("CUSTOM_".$array_modules[$j]["module"]) == "on")) {
                                            $moduleOn = true;
                                        }
                                    } else {
                                        $moduleOn = true;
                                    }
                                    
                                    if ($moduleOn) {
                                    
                                        $labelName = (strpos($array_modules[$j]["name"], "LANG_MENU") !== false || strpos($array_modules[$j]["name"], "TERMS") !== false || strpos($array_modules[$j]["name"], "PRIVACY") !== false ? constant($array_modules[$j]["name"]) : $array_modules[$j]["name"]);
                                        $selected = false;
                                        if (($array_modules[$j]["url"] == $arrayOptions[$i]["link"]) || ($array_modules[$j]["url"] == "custom" && $arrayOptions[$i]["custom"] == "y")) {
                                            $selected = "selected = \"selected\"";
                                        } ?>
                                
                                        <option value="<?=$array_modules[$j]["url"]?>" <?=($selected ? $selected : "")?>>
                                            <?=string_ucwords($labelName)?>
                                        </option>
                                    <? }
                                } ?>
                            </select>
                        </span>
                    </span>
                    <span class="col-sm-3 col-xs-3"><input type="text" class="form-control" name="custom_link_<?=$i?>" id="custom_link_<?=$i?>" value="<?=($arrayOptions[$i]["custom"] == "y" ? $arrayOptions[$i]["link"] :"")?>" <?=($arrayOptions[$i]["custom"] == "n" ? "disabled=\"true\" style=\"background-color:#f0f0f0\"" : "")?> /></span>
                    <span class="options">
                        <a class="sortable-remove" href="javascript:void(0)" onclick="removeItem(<?=$i?>)" title="<?=system_showText(LANG_SITEMGR_REMOVE)?>">
                            <i class="icon-waste2 text-warning"></i>
                        </a>
                    </span>
                </p>
            </li>
        <? } ?>
    </ul>
    <br>
    
    <div class="text-right">
        <a class="sortable-add" href="javascript:void(0)" onclick="CreateNewItem();"><?=system_showText(LANG_SITEMGR_NAVIGATION_ADDROW);?></a>
        <br><br><br>
    </div>