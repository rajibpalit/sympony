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
    # * FILE: /frontend/advertise_item.php
    # ----------------------------------------------------------------------------------------------------

    # ----------------------------------------------------------------------------------------------------
    # CODE
    # ----------------------------------------------------------------------------------------------------
    unset($level);

    if ($signupItem == "listing") {
        $sitecontentSection = "Listing Advertisement";
        $level = new ListingLevel();
        $levelTable = "ListingLevel";
        $levelsWithReview = system_retrieveLevelsWithInfoEnabled("has_review");
        $levelsWithSendPhone = system_retrieveLevelsWithInfoEnabled("has_sms");
        $levelsWithClickToCall = system_retrieveLevelsWithInfoEnabled("has_call");
        $itemAlias = ALIAS_LISTING_MODULE;
    } elseif ($signupItem == "event") {
        $sitecontentSection = "Event Advertisement";
        $level = new EventLevel();
        $levelTable = "EventLevel";
        $itemAlias = ALIAS_EVENT_MODULE;
    } if ($signupItem == "classified") {
        $sitecontentSection = "Classified Advertisement";
        $level = new ClassifiedLevel();
        $levelTable = "ClassifiedLevel";
        $itemAlias = ALIAS_CLASSIFIED_MODULE;
    } if ($signupItem == "article") {
        $sitecontentSection = "Article Advertisement";
        $level = new ArticleLevel();
        $levelTable = "ArticleLevel";
        $itemAlias = ALIAS_ARTICLE_MODULE;
    } if ($signupItem == "banner") {
        $sitecontentSection = "Banner Advertisement";
        $level = new BannerLevel();
        $levelTable = "BannerLevel";
        $itemAlias = "banner";
    }

    $contentObj = new Content();
    $content = $contentObj->retrieveContentByType($sitecontentSection);
    if ($content) {
        echo "<div class=\"content-custom\">".$content."</div>";
    }

    $activeLevels = $level->getLevelValues();

    if (!$dbObj) {
        $dbMain = db_getDBObject(DEFAULT_DB, false);
        $dbObj = db_getDBObjectByDomainID(SELECTED_DOMAIN_ID, $dbMain);
    }

    //Get popular level
    unset($popularLevel);
    if ($signupItem != "article") {
        $sql = "SELECT value FROM $levelTable WHERE active = 'y' AND theme = '".EDIR_THEME."' AND popular = 'y' LIMIT 1";
        $rowLevel = mysql_fetch_assoc($dbObj->query($sql));
        $popularLevel = $rowLevel["value"];
    }

    //Use 4 columns special layout
    $useLowerLevel = false;
    unset($lowerLevel);
    if ($signupItem != "article" && $signupItem != "banner") {
        if (count($activeLevels) == 4) {
            $useLowerLevel = true;

            setting_get("contact_email", $contact_email);
            setting_get("contact_phone", $contact_phone);

            //Get lower level
            $sql = "SELECT value FROM $levelTable WHERE active = 'y' AND theme = '".EDIR_THEME."' AND popular != 'y' ORDER BY price LIMIT 1";

            $rowLevel = mysql_fetch_assoc($dbObj->query($sql));
            $lowerLevel = $rowLevel["value"];

            //Reorder levels array
            if ($popularLevel) {
                $aux_activeLevels = array();
                $posArray = 0;
                foreach ($activeLevels as $levelValue) {
                    if ($levelValue != $popularLevel && $levelValue != $lowerLevel) {
                        $aux_activeLevels[$posArray] = $levelValue;
                        $posArray = 2;
                    }
                }
                $aux_activeLevels[1] = $popularLevel;
                $aux_activeLevels[3] = $lowerLevel;
                ksort($aux_activeLevels);
                $activeLevels = $aux_activeLevels;
            }

            //Use 3 columns layout
        } elseif($popularLevel) {
            //Reorder levels array
            $aux_activeLevels = array();
            $posArray = 0;
            foreach ($activeLevels as $levelValue) {
                if ($levelValue != $popularLevel && $levelValue != $lowerLevel) {
                    $aux_activeLevels[$posArray] = $levelValue;
                    $posArray = 2;
                }
            }
            $aux_activeLevels[1] = $popularLevel;
            ksort($aux_activeLevels);
            $activeLevels = $aux_activeLevels;
        }
    }

    //Prepare available features
    $review_enabled = "";
    if ($signupItem == "listing" || $signupItem == "article") {
        setting_get("review_{$signupItem}_enabled", $review_enabled);
    }

    $availableFeatures = array();

    //Title/Address
    if ($signupItem == "article") {
        $availableFeatures[] = "title";
    } else {
        $availableFeatures[] = "title_address";
    }

    //Review
    if ($review_enabled == "on") {
        $availableFeatures[] = "review";
    }

    //Detail View
    $availableFeatures[] = "detail_view";

    if ($signupItem == "listing" ) {

        //Backlink
        if (BACKLINK_FEATURE == "on") {
            $availableFeatures[] = "backlink";
        }

        //Deal
        if (PROMOTION_FEATURE == "on" && CUSTOM_PROMOTION_FEATURE == "on") {
            $availableFeatures[] = "deal";
        }

        //Click to Call / Send to phone
        if (TWILIO_APP_ENABLED == "on") {
            if (TWILIO_APP_ENABLED_SMS == "on") {
                $availableFeatures[] = "send_to_phone";
            }
            if (TWILIO_APP_ENABLED_CALL == "on") {
                $availableFeatures[] = "click_to_call";
            }
        }
    }

    //General features

    if ($signupItem != "classified" && $signupItem != "article") {
        $availableFeatures[] = "phone";
    }
    if ($signupItem == "event" || $signupItem == "classified") {
        $availableFeatures[] = "contact_name";
    }
    if ($signupItem == "classified") {
        $availableFeatures[] = "contact_phone";
        $availableFeatures[] = "contact_email";
        $availableFeatures[] = "price";
    }
    if ($signupItem != "classified" && $signupItem != "article") {
        $availableFeatures[] = "email";
    }
    if ($signupItem != "article") {
        $availableFeatures[] = "url";
    }
    if ($signupItem == "event") {
        $availableFeatures[] = "event_time";
    }
    if ($signupItem == "listing" || $signupItem == "classified") {
        $availableFeatures[] = "fax";
    }
    if ($signupItem == "article") {
        $availableFeatures[] = "publication";
        $availableFeatures[] = "author";
        $availableFeatures[] = "abstract";
        $availableFeatures[] = "content";
    } else {
        $availableFeatures[] = "summary_description";
    }
    if ($signupItem == "listing") {
        $availableFeatures[] = "badges";
    }
    if ($signupItem != "article") {
        $availableFeatures[] = "long_description";
    }
    $availableFeatures[] = "main_image";
    if ($signupItem == "listing" || $signupItem == "event") {
        $availableFeatures[] = "video";
    }
    if ($signupItem == "listing") {
        $availableFeatures[] = "attachment_file";
        $availableFeatures[] = "hours_of_work";
        $availableFeatures[] = "locations";
        $availableFeatures[] = "fbpage";
        $availableFeatures[] = "features";
    }

    ?>
    <div class="plans-container">

    <?php
    $countLevels = 0;
    $previewBanner = array();
    foreach ($activeLevels as $levelValue) {
        $countLevels++;

        if ($level->getPrice($levelValue) > 0) {
            $price = $level->getPrice($levelValue);
		$priceAux = explode(".", $price);

            $priceRenewal = "";
            if (payment_getRenewalCycle($signupItem) > 1) {
                $priceRenewal .= payment_getRenewalCycle($signupItem)." ";
                $priceRenewal .= payment_getRenewalUnitNamePlural($signupItem);
            } else {
                $priceRenewal .= payment_getRenewalUnitName($signupItem, true);
            }
            /*if ($payment_tax_status == "on") {
                $priceTax = "+".$payment_tax_value."% ".$payment_tax_label;
                $priceTax .= " (".CURRENCY_SYMBOL.payment_calculateTax($level->getPrice($levelValue), $payment_tax_value).")";
            }*/
        } else {
            $price = system_showText(LANG_FREE);
		    $priceAux = explode(".", $price);
            $priceRenewal = "";
            if ($payment_tax_status == "on") {
                $priceTax = "";
            }
        }

        if ($signupItem == "banner") {
            if ($level->getImpressionPrice($levelValue) > 0) {
                $priceImp = $level->getImpressionPrice($levelValue);
                $priceImpAux = explode(".", $priceImp);

                $priceRenewalImp = $level->getImpressionBlock($levelValue)." ".system_showText(LANG_IMPRESSIONS);

                /*if ($payment_tax_status == "on") {
                    $priceTaxImp = "+".$payment_tax_value."% ".$payment_tax_label;
                    $priceTaxImp .= " (".CURRENCY_SYMBOL.payment_calculateTax($level->getImpressionPrice($levelValue), $payment_tax_value).")";
                }*/
            } else {
                $priceImp = system_showText(LANG_FREE);
                $priceImpAux = explode(".", $priceImp);
                $priceRenewalImp = "";
                if ($payment_tax_status == "on") {
                    $priceTaxImp = "";
                }
            }

        }

        //Get fields from each level
        if ($signupItem != "article" && $signupItem != "banner") {

            $auxDefaultFields = array();
            if ($signupItem == "article") {
                $auxDefaultFields[] = "title";
            } else {
                $auxDefaultFields[] = "title_address";
            }

            //Review
            if ($signupItem == "article") {
                $auxDefaultFields[] = "review";
            } elseif ($signupItem == "listing" && is_array($levelsWithReview) && in_array($levelValue, $levelsWithReview)) {
                $auxDefaultFields[] = "review";
            }

            //Detail View
            if ($level->getDetail($levelValue) == "y") {
                $auxDefaultFields[] = "detail_view";
            }

            //Click to Call / Send to phone
            if ($signupItem == "listing" ) {

                if ($level->getBacklink($levelValue) == "y") {
                    $auxDefaultFields[] = "backlink";
                }

                if ($level->getHasPromotion($levelValue) == "y") {
                    $auxDefaultFields[] = "deal";
                }

                if ($signupItem == "listing" && is_array($levelsWithSendPhone) && in_array($levelValue, $levelsWithSendPhone)) {
                    $auxDefaultFields[] = "send_to_phone";
                }
                if ($signupItem == "listing" && is_array($levelsWithClickToCall) && in_array($levelValue, $levelsWithClickToCall)) {
                    $auxDefaultFields[] = "click_to_call";
                }
            }

            ${"array_fields_".$levelValue} = system_getFormFields(ucfirst($signupItem), $levelValue);
            if (!${"array_fields_".$levelValue}) {
                ${"array_fields_".$levelValue} = array();
            }
            ${"array_fields_".$levelValue} = array_merge(${"array_fields_".$levelValue}, $auxDefaultFields);
        }

        ?>

        <div class="plan-box <?=($levelValue == $popularLevel ? "plan-popular" : "")?>">

            <?php if ($signupItem != "article") { ?>
                <div class="plan-title">
                    <?=ucfirst($level->getName($levelValue));?>
                    <? if ($signupItem == "banner") { ?>
                        <br><small><?=system_showText(LANG_ADVERTISE_SIZE)?>: <?=$level->getWidth($levelValue);?> X <?=$level->getHeight($levelValue);?></small>
                    <? } ?>
                </div>
            <?php } ?>

            <div class="plan-info">
                <?php if ($levelValue == $popularLevel) { ?>
                <span class="popular-tag"><?=system_showText(LANG_ADVERTISE_POPULAR);?></span>
                <?php } ?>

                <mark>
                    <small>
                        <?=(is_numeric($priceAux[0]) ? CURRENCY_SYMBOL : "");?>
                    </small>
                    <?=$priceAux[0];?><?=($priceAux[1] && $priceAux[1] != "00" ? "<small>.".$priceAux[1]."</small>" : "")?>
                </mark>

                <?=($priceRenewal ? "<small>$priceRenewal</small><br>" : "");?>

                <? if ($priceTax) { ?>
                    <small><?=$priceTax;?></small>
                <? } ?>
                <? if ($signupItem == "banner") { ?>

                    <br>
                    <hr><em><span><?=system_showText(LANG_OR);?></span></em>

                    <mark>
                        <?=(is_numeric($priceImpAux[0]) ? "<small>".CURRENCY_SYMBOL."</small>" : "");?><?=$priceImpAux[0];?><?=($priceImpAux[1] && $priceImpAux[1] != "00" ? "<small>.".$priceImpAux[1]."</small>" : "")?>
                    </mark>

                    <p><?=($priceRenewalImp ? "<small>".system_showText(LANG_PER)." $priceRenewalImp</small>" : "<span>&nbsp;</span>");?></p>

                    <? if ($priceTaxImp) { ?>
                        <p><small><?=$priceTaxImp;?></small></p>
                    <? } ?>

                <? } ?>
            </div>
            <div class="plan-desc">
                <? if ($signupItem == "banner") {

                    $auxName = string_strtolower($level->getName($levelValue, true));
                    $auxName = str_replace(" ", "", $auxName);
                    $previewBanner[$auxName] = DEFAULT_URL."/assets/images/preview-banner-".$levelValue.".png";

                    ?>

                    <a href="#banner-<?=$auxName?>" data-toggle="modal" class="btn btn-default btn-block"><?=system_showText(LANG_ADVERTISE_SAMPLE);?></a>

                <? } elseif (is_array($auxDefaultFields) && in_array("detail_view", $auxDefaultFields)) { ?>

                    <a href="<?=DEFAULT_URL."/".$itemAlias."/sample-$levelValue.html"?>" target="_blank" rel="nofollow" class="btn btn-default btn-block"><?=system_showText(LANG_ADVERTISE_SAMPLE);?></a>

                <? } ?>
                <a class="btn btn-highlight btn-block" rel="nofollow" href="<?=DEFAULT_URL?>/<?=ALIAS_ADVERTISE_URL_DIVISOR?>/<?=$itemAlias?>/<?=$levelValue?>"><?=system_showText(LANG_BUTTON_SIGNUP);?></a>

                <ul>

                    <? if ($level->getContent($levelValue)) {

                        echo string_nl2li(strip_tags($level->getContent($levelValue)));

                    } elseif ($signupItem != "banner") {

                        foreach ($availableFeatures as $item) {

                            if ($item == "event_time") {
                                $item = "start_time";
                            }
                            ?>

                            <li <?=((is_array(${"array_fields_".$levelValue}) && in_array($item, ${"array_fields_".$levelValue}) || $signupItem == "article") ? "" : "class=\"text-striketrough\"")?>><?=@constant("LANG_ADVERTISE_LIST_".strtoupper($item))?></li>

                        <? } ?>

                    <? } ?>

                </ul>

            </div>

        </div>

    <? } ?>

    </div>
