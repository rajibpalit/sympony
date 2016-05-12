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
    # * FILE: /frontend/footer.php
    # ----------------------------------------------------------------------------------------------------

    front_getCopyright($footer, true);
    include(INCLUDES_DIR."/code/contactus.php");

    //Get custom content
    $contentObjFooter = new Content();
    $contentFooter = $contentObjFooter->retrieveContentInfoByType("Footer");
?>

            <? if (!$_GET['userperm']) { ?>
            <!-- Footer Begin -->
            <footer class="footer-static-bottom">
                <?=($contentFooter["content"])?>
                <div class="footer-links">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <h5><?=system_showText(LANG_SITE_CONTENT)?></h5>
                                <div class="list-columns-2">
                                    <? include(system_getFrontendPath("footer_menu.php", "frontend")); ?>
                                </div>
                            </div>

                            <?php if ($contactInfoStr || $contact_phone) { ?>

                            <div class="col-sm-3 col-xs-6">
                                <h5><?=system_showText(LANG_MENU_CONTACT)?></h5>

                                <div itemscope itemtype="http://schema.org/Organization">
                                    <address class="contact-address" itemprop="name" content="Demo Directory">

                                        <?php if ($contactInfoStr) { ?>
                                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                            <span class="fa fa-map-marker"></span>
                                            <?php if ($contact_address) { ?>
                                            <span itemprop="streetAddress"><?=$contact_address?></span><br>
                                            <?php } ?>
                                            <?php if ($contact_city) { ?>
                                            <span itemprop="addressLocality"><?=$contact_city?></span>,
                                            <?php } ?>
                                            <?php if ($contact_state) { ?>
                                            <span itemprop="addressRegion"><?=$contact_state?></span>,
                                            <?php } ?>
                                            <?php if ($contact_zipcode) { ?>
                                            <span itemprop="postalCode"><?=$contact_zipcode?></span>
                                            <?php } ?>
                                            <?php if ($contact_country) { ?>
                                            <br><span itemprop="addressCountry"><?=$contact_country?></span>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>

                                        <?php if ($contact_phone) { ?>
                                        <span class="fa fa-phone"></span>
                                        <span itemprop="telephone"><?=$contact_phone?></span>
                                        <?php } ?>

                                    </address>
                                </div>
                            </div>

                            <?php } ?>

                            <?php
                            if ($setting_twitter_link ||
                                $setting_facebook_link ||
                                $setting_linkedin_link ||
                                $setting_instagram_link ||
                                $setting_googleplus_link ||
                                $setting_pinterest_link
                            ) { ?>

                            <div class="col-sm-3 col-xs-6">
                                <h5><?=system_showText(LANG_FOLLOW_US)?></h5>
                                <ul class="list-unstyled">
                                    <?php if ($setting_facebook_link) { ?>
                                    <li>
                                        <a target="_blank" href="<?=$setting_facebook_link?>" class="social-links"><span class="fa fa-facebook"></span> Facebook </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($setting_linkedin_link) { ?>
                                    <li>
                                        <a target="_blank" href="<?=$setting_twitter_link?>" class="social-links"><span class="fa fa-linkedin"></span> Linkedin </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($setting_twitter_link) { ?>
                                    <li>
                                        <a target="_blank" href="http://www.twitter.com/<?=$setting_twitter_link?>" class="social-links"><span class="fa fa-twitter"></span> Twitter </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($setting_instagram_link) { ?>
                                        <li>
                                            <a target="_blank" href="<?=$setting_instagram_link?>" class="social-links"><span class="fa fa-instagram"></span> Instagram </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($setting_googleplus_link) { ?>
                                        <li>
                                            <a target="_blank" href="<?=$setting_googleplus_link?>" class="social-links"><span class="fa fa-google"></span> Google Plus </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($setting_pinterest_link) { ?>
                                        <li>
                                            <a target="_blank" href="<?=$setting_pinterest_link?>" class="social-links"><span class="fa fa-pinterest"></span> Pinterest </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8">
                                <?
                                customtext_get("footer_copyright", $footer_copyright);

                                if (!$footer_copyright) {
                                    $footer = "Copyright &copy; ".date("Y")." Arca Solutions, Inc. All Rights Reserved.";
                                } else {
                                    $footer = $footer_copyright;
                                }
                                ?>

                                <?=$footer?>
                            </div>
                            <div class="col-sm-4 text-right">
                                <?php
                                if (BRANDED_PRINT == "on") { ?>
                                    Powered by <a href="http://www.edirectory.com<?=(string_strpos($_SERVER["HTTP_HOST"], ".com.br") !== false ? ".br" : "")?>" target="_blank">eDirectory Cloud Service&trade;</a>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </footer>
            <!-- Footer End -->
            <? } ?>

            <!-- Auxiliary vars -->
            <script>
                DEFAULT_URL = "<?=DEFAULT_URL?>";
                MEMBERS_ALIAS = "<?=MEMBERS_ALIAS?>";
                DATEPICKER_FORMAT = '<?=(DEFAULT_DATE_FORMAT == "m/d/Y" ? "mm/dd/yyyy" : "dd/mm/yyyy")?>';
                DATEPICKER_LANGUAGE = '<?=EDIR_LANGUAGE?>';
            </script>

            <!-- Core Scripts -->

            <!-- Modernizr -->
            <script src="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/assets/js/modernizr.custom.13060.js"></script>

            <!-- jQuery -->
            <script src="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/assets/js/jquery-1.11.1.min.js"></script>

            <!-- jQuery - Sortable package only -->
            <script src="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/assets/js/jquery-ui-1.11.1.min.js"></script>

            <!-- Bootstrap -->
            <script src="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/assets/js/bootstrap.min.js"></script>

            <!-- External Plugins -->

            <!--Bootstrap Date Picker-->
            <script src="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/assets/js/bootstrap-datepicker-master/bootstrap-datepicker.js"></script>
            <? if (EDIR_LANGUAGE != "en_us") { ?>
                <script src="<?=language_getDatePickPath(EDIR_LANGUAGE, SELECTED_DOMAIN_ID, false, true);?>"></script>
            <? } ?>

            <!-- Jquery Time Picker-->
            <script src="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/assets/js/jquery-timepicker-master/jquery.timepicker.min.js"></script>

            <!-- Additional scripts -->
            <script src="<?=language_getFilePath(EDIR_LANGUAGE, true);?>"></script>
            <script src="<?=DEFAULT_URL?>/scripts/specialChars.js"></script>
            <script src="<?=DEFAULT_URL?>/scripts/common.js"></script>
            <script src="<?=DEFAULT_URL?>/scripts/categorytree.js"></script>
            <script src="<?=DEFAULT_URL?>/scripts/orders.js"></script>

            <script>

                $(document).ready(function() {

                    <? if ($advertiseItem == "event") { ?>
                    $(".date-input").datepicker({
                        format: DATEPICKER_FORMAT,
                        language: DATEPICKER_LANGUAGE,
                        autoclose: true,
                        todayHighlight: true
                    });
                    <? } ?>

                    <? if ($advertiseItem == "listing") { ?>
                    <? if ($listingtemplate_id) { ?>
                    loadCategoryTree('template', 'listing_', 'ListingCategory', 0, <?=$listingtemplate_id?>, '<?=DEFAULT_URL?>',<?=SELECTED_DOMAIN_ID?>);
                    <? } else {  ?>
                    loadCategoryTree('all', 'listing_', 'ListingCategory', 0, 0, '<?=DEFAULT_URL?>',<?=SELECTED_DOMAIN_ID?>);
                    <? } ?>
                    <? } ?>

                    <? if ($advertiseItem) { ?>
                    orderCalculate();
                    <? } ?>

                    <?	if ($_POST["account_sugar_id"]) { ?>
                    populateField(document.getElementById('username').value, 'email');
                    <? } ?>

                });

                function orderCalculate() {

                    var xmlhttp;

                    try {
                        xmlhttp = new XMLHttpRequest();
                    } catch (e) {
                        try {
                            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                        } catch (e) {
                            try {
                                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                            } catch (e) {
                                xmlhttp = false;
                            }
                        }
                    }

                    if (document.getElementById("check_out_payment")) document.getElementById("check_out_payment").className = "isHidden";
                    $("#check_out_payment_2").removeClass("isVisible").addClass("isHidden");
                    if (document.getElementById("check_out_free")) document.getElementById("check_out_free").className = "isHidden";
                    $("#check_out_free_2").removeClass("isVisible").addClass("isHidden");
                    if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").style.display = "";
                    if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").innerHTML = "<?=system_showText(LANG_WAITLOADING)?>";
                    if (xmlhttp) {
                        xmlhttp.onreadystatechange = function() {
                            if (xmlhttp.readyState == 4) {
                                if (xmlhttp.status == 200) {
                                    var price = xmlhttp.responseText;
                                    var arrPrice = price.split("|");
                                    var html = "";
                                    var tax_status = '<?=$payment_tax_status;?>';
                                    var tax_info = "";
                                    <? if ((PAYMENT_FEATURE == "on") && ((CREDITCARDPAYMENT_FEATURE == "on") || (INVOICEPAYMENT_FEATURE == "on"))) { ?>
                                    if (arrPrice[0] > 0) {
                                        if (tax_status == "on") {
                                            html += "<strong><?=system_showText(LANG_SUBTOTALAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[0].substring(0, arrPrice[0].length-2)+"."+arrPrice[0].substring(arrPrice[0].length-2, arrPrice[0].length);
                                            html += "<br /><strong><?=system_showText(LANG_TAXAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[1].substring(0, arrPrice[1].length-2)+"."+arrPrice[1].substring(arrPrice[1].length-2, arrPrice[1].length);
                                            html += "<br /><strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[2].substring(0, arrPrice[2].length-2)+"."+arrPrice[2].substring(arrPrice[2].length-2, arrPrice[2].length);
                                            tax_info = "<?="+".$payment_tax_value."% ".$payment_tax_label;?> (" + "<?=CURRENCY_SYMBOL?>"+arrPrice[2].substring(0, arrPrice[2].length-2)+"."+arrPrice[2].substring(arrPrice[2].length-2, arrPrice[2].length) + ")";
                                        } else {
                                            html += "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[0].substring(0, arrPrice[0].length-2)+"."+arrPrice[0].substring(arrPrice[0].length-2, arrPrice[0].length);
                                        }
                                        $('#divTax').addClass('isVisible');
                                        $('#divTax').removeClass('isHidden');
                                        $("#free_item").attr("value", "0");
                                        if (document.getElementById("check_out_payment")) document.getElementById("check_out_payment").className = "isVisible";
                                        $("#check_out_payment_2").addClass("isVisible").removeClass("isHidden");
                                        if (document.getElementById("payment-method")) document.getElementById("payment-method").className = "isVisible";
                                        if (document.getElementById("checkoutpayment_total")) document.getElementById("checkoutpayment_total").innerHTML = html;
                                        $("#checkout_steps").addClass("isVisible").removeClass("isHidden");
                                    } else {
                                        $('#divTax').addClass('isHidden');
                                        $('#divTax').removeClass('isVisible');
                                        $("#free_item").attr("value", "1");
                                        if (document.getElementById("check_out_free")) document.getElementById("check_out_free").className = "isVisible";
                                        $("#check_out_free_2").addClass("isVisible").removeClass("isHidden");
                                        if (document.getElementById("payment-method")) document.getElementById("payment-method").className = "isHidden";
                                        if (document.getElementById("checkoutfree_total")) document.getElementById("checkoutfree_total").innerHTML = "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?><?=system_showText(LANG_FREE)?>";
                                        $("#checkout_steps").addClass("isHidden").removeClass("isVisible");
                                    }
                                    if (tax_status == "on") document.getElementById("taxInfo").innerHTML = tax_info;
                                    <? } else { ?>
                                    $("#free_item").attr("value", "1");
                                    if (document.getElementById("check_out_free")) document.getElementById("check_out_free").className = "isVisible";
                                    $("#check_out_free_2").addClass("isVisible").removeClass("isHidden");
                                    if (document.getElementById("payment-method")) document.getElementById("payment-method").className = "isHidden";
                                    if (arrPrice[0] > 0) {
                                        if (tax_status == "on") {
                                            html += "<strong><?=system_showText(LANG_SUBTOTALAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[0].substring(0, arrPrice[0].length-2)+"."+arrPrice[0].substring(arrPrice[0].length-2, arrPrice[0].length);
                                            html += "<br /><strong><?=system_showText(LANG_TAXAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[1].substring(0, arrPrice[1].length-2)+"."+arrPrice[1].substring(arrPrice[1].length-2, arrPrice[1].length);
                                            html += "<br /><strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[2].substring(0, arrPrice[2].length-2)+"."+arrPrice[2].substring(arrPrice[2].length-2, arrPrice[2].length);
                                            tax_info = "<?="+".$payment_tax_value."% ".$payment_tax_label;?> (" + "<?=CURRENCY_SYMBOL?>"+arrPrice[2].substring(0, arrPrice[2].length-2)+"."+arrPrice[2].substring(arrPrice[2].length-2, arrPrice[2].length) + ")";
                                        } else {
                                            html += "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+arrPrice[0].substring(0, arrPrice[0].length-2)+"."+arrPrice[0].substring(arrPrice[0].length-2, arrPrice[0].length);
                                        }
                                        $('#divTax').addClass('isVisible');
                                        $('#divTax').removeClass('isHidden');
                                        if (document.getElementById("checkoutfree_total")) document.getElementById("checkoutfree_total").innerHTML = html;
                                    } else {
                                        $('#divTax').addClass('isHidden');
                                        $('#divTax').removeClass('isVisible');
                                        if (document.getElementById("checkoutfree_total")) document.getElementById("checkoutfree_total").innerHTML = "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?><?=system_showText(LANG_FREE)?>";
                                    }
                                    if (tax_status == "on") document.getElementById("taxInfo").innerHTML = tax_info;
                                    <? } ?>
                                    if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").style.display = "none";
                                    if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").innerHTML = "";
                                }
                            }
                        }
                        var get_level = "";
                        if (document.order_item.level) get_level = "&level=" + document.order_item.level.value;

                        var get_categories = "";
                        if (document.order_item.feed) get_categories = "&categories=" + document.order_item.feed.length;

                        var get_listingtemplate_id = "";
                        if (document.order_item.select_listingtemplate_id) get_listingtemplate_id = "&listingtemplate_id=" + document.order_item.select_listingtemplate_id.value;

                        var get_discount_id = "";
                        if (document.order_item.discount_id) get_discount_id = document.order_item.discount_id.value;

                        var get_type = "";
                        if (document.order_item.type) get_type = "&type=" + document.order_item.type.value;

                        var get_expiration_setting = "";
                        if (document.order_item.expiration_setting) get_expiration_setting = "&expiration_setting=" + document.order_item.expiration_setting.value;

                        var get_unpaid_impressions = "";
                        if (document.order_item.unpaid_impressions) get_unpaid_impressions = "&unpaid_impressions=" + document.order_item.unpaid_impressions.value;

                        xmlhttp.open("GET", "<?=DEFAULT_URL;?>/ordercalculateprice.php?item=<?=$advertiseItem?>&item_id=<?=$unique_id;?>"+get_level+get_categories+get_listingtemplate_id+"&discount_id="+get_discount_id+get_type+get_expiration_setting+get_unpaid_impressions, true);
                        xmlhttp.send(null);
                    }
                }

                <? if (LISTINGTEMPLATE_FEATURE == "on" && CUSTOM_LISTINGTEMPLATE_FEATURE == "on" && $advertiseItem == "listing") { ?>
                function templateSwitch(template) {
                    if (!template) template = 0;
                    <?=$jsVarsType;?>
                    document.order_item.listingtemplate_id.value = template;
                    if (document.getElementById("title_label")) {
                        document.getElementById("title_label").innerHTML = eval("title_template_" + template);
                    }
                    orderCalculate();
                    loadCategoryTree('template', 'listing_', 'ListingCategory', 0, template, '<?=DEFAULT_URL?>',<?=SELECTED_DOMAIN_ID?>);
                    updateFormAction();
                }
                <? } ?>

                <? if ($advertiseItem == "banner") { ?>
                function typeSwitch(type, expiration_setting) {
                    <?
                    foreach ($levelValue as $value) {
                        echo "var impressions_".$value."_".BANNER_EXPIRATION_RENEWAL_DATE." = 0;";
                        echo "var impressions_".$value."_".BANNER_EXPIRATION_IMPRESSION." = ".$bannerLevelObj->getImpressionBlock($value).";";
                    }
                    ?>
                    document.order_item.type.value = type;
                    document.order_item.expiration_setting.value = expiration_setting;
                    document.order_item.unpaid_impressions.value = eval("impressions_" + type + "_" + expiration_setting);
                    orderCalculate();
                    updateFormAction();
                }
                <? } ?>

                function updateFormAction() {
                    var levelValue = "";
                    var titleValue = "";
                    var templateValue = "";
                    var categValue = "";
                    var discountValue = "";
                    var packageValue = "";
                    var packageID = "";
                    var startDateValue = "";
                    var endDateValue = "";
                    var expirationValue = "";
                    var advertiseItem = "<?=$advertiseItem?>";

                    //Get level/type
                    if (document.order_item.level) {
                        levelValue = "level=" + document.order_item.level.value;
                    } else if (document.order_item.type) {
                        levelValue = "type=" + document.order_item.type.value;
                    }

                    //Get Title/Caption
                    if (document.order_item.title) {
                        titleValue = "&title=" + urlencode(document.order_item.title.value);
                    } else if (document.order_item.caption) {
                        titleValue = "&caption=" + urlencode(document.order_item.caption.value);
                    }

                    //Get expiration setting (banner)
                    if (document.order_item.expiration_setting) {
                        expirationValue = "&expiration_setting=" + document.order_item.expiration_setting.value;
                    }

                    //Get Template ID
                    if (document.order_item.select_listingtemplate_id) {
                        templateValue = "&listingtemplate_id=" + document.order_item.select_listingtemplate_id.value;
                    }

                    //Get Discount
                    if (document.order_item.discount_id) {
                        discountValue = "&discount_id=" + document.order_item.discount_id.value;
                    }

                    //Get Start Date (event)
                    if (document.order_item.start_date) {
                        startDateValue = "&start_date=" + document.order_item.start_date.value;
                    }

                    //Get End Date (event)
                    if (document.order_item.end_date) {
                        endDateValue = "&end_date=" + document.order_item.end_date.value;
                    }

                    <? if ($advertiseItem == "listing") { ?>

                    //Get Categories
                    feed = document.order_item.feed;
                    var return_categories = "";

                    for (i = 0; i < feed.length; i++) {
                        if (!isNaN(feed.options[i].value)) {
                            if (return_categories.length > 0) {
                                return_categories = return_categories + "," + feed.options[i].value;
                            } else {
                                return_categories = return_categories + feed.options[i].value;
                            }
                        }
                    }
                    if (return_categories.length > 0) {
                        categValue = "&return_categories=" + return_categories;
                    }

                    <? } ?>

                    //Get package
                    if ($("#using_package").val() == "y") {
                        packageID = $("#aux_package_id").val();
                        packageValue = "&package_id="+packageID;
                    } else if (advertiseItem == "article") {
                        packageID = "skipPackageOffer";
                        packageValue = "&package_id="+packageID;
                    }

                    if (document.formDirectory != undefined)	document.formDirectory.action = "<?=$formloginaction?>&query=" + levelValue + templateValue + titleValue + categValue + discountValue + packageValue + startDateValue + endDateValue + expirationValue;

                    <? if ($googleEnabled || $facebookEnabled) { ?>

                    $.get(DEFAULT_URL + "/ordercalculateprice.php", {

                        item:               "<?=$advertiseItem?>",

                        item_id:            "<?=$unique_id;?>",

                        <? if ($advertiseItem == "banner") { ?>

                        type:              document.order_item.type.value,

                        caption:            document.order_item.caption.value,

                        <? } else { ?>

                        level:              document.order_item.level.value,

                        title:              document.order_item.title.value,

                        <? } ?>

                        <? if ($advertiseItem == "listing") { ?>

                        <? if (LISTINGTEMPLATE_FEATURE == "on" && CUSTOM_LISTINGTEMPLATE_FEATURE == "on" && system_showListingTypeDropdown($listingtemplate_id)) { ?>

                        listingtemplate_id: document.order_item.select_listingtemplate_id.value,

                        <? } ?>

                        return_categories:  return_categories,

                        <? } elseif ($advertiseItem == "event") { ?>

                        start_date:         document.order_item.start_date.value,

                        end_date:           document.order_item.end_date.value,

                        <? } elseif ($advertiseItem == "banner") { ?>

                        expiration_setting: document.order_item.expiration_setting.value,

                        unpaid_impressions: document.order_item.unpaid_impressions.value,

                        <? } ?>

                        discount_id:        document.order_item.discount_id.value,

                        package_id:         packageID
                    }, function () {});

                    <? } ?>
                }

                <? if ($advertiseItem == "listing") { ?>

                function JS_addCategory(id) {
                    seed = document.order_item.seed;
                    feed = document.order_item.feed;
                    var text = unescapeHTML($("#liContent"+id).html());
                    var flag = true;
                    for (i = 0; i < feed.length; i++) {
                        if (feed.options[i].value == id) {
                            flag = false;
                        }
                        if (!feed.options[i].value || feed.options[i].value == "empty") {
                            feed.remove(feed.options[i]);
                        }
                    }
                    if (text && id && flag) {
                        feed.options[feed.length] = new Option(text, id);
                        $('#categoryAdd'+id).after("<span class=\"categorySuccessMessage\"><?=system_showText(LANG_MSG_CATEGORY_SUCCESSFULLY_ADDED)?></span>").css('display', 'none');
                        $('.categorySuccessMessage').fadeOut(5000);
                        orderCalculate();
                        updateFormAction();
                    } else {
                        if (!flag) {
                            $('#categoryAdd'+id).after("</a> <span class=\"categoryErrorMessage\"><?=system_showText(LANG_MSG_CATEGORY_ALREADY_INSERTED)?></span> </li>");
                        } else {
                            ('#categoryAdd'+id).after("</a> <span class=\"categoryErrorMessage\"><?=system_showText(LANG_MSG_SELECT_VALID_CATEGORY)?></span> </li>");
                        }
                    }

                    $('#removeCategoriesButton').show();

                }

                <? } ?>

                function JS_submit() {
                    disableButtons();
                    <? if ($advertiseItem == "listing") { ?>
                    feed = document.order_item.feed;
                    return_categories = document.order_item.return_categories;
                    if (return_categories.value.length > 0) {
                        return_categories.value = "";
                    }
                    for (i = 0; i < feed.length; i++) {
                        if (!isNaN(feed.options[i].value)) {
                            if (return_categories.value.length > 0) {
                                return_categories.value = return_categories.value + "," + feed.options[i].value;
                            } else {
                                return_categories.value = return_categories.value + feed.options[i].value;
                            }
                        }
                    }
                    <? } ?>
                }

                function getFacebookImage() {

                    $("#image_fb").html("<img src=\"" + DEFAULT_URL + "/assets/images/structure/img_loading.gif\" alt=\"\" />");

                    $.post(DEFAULT_URL + "/<?=MEMBERS_ALIAS?>/ajax.php", {
                        ajax_type: 'getFacebookImage',
                        id: '<?=sess_getAccountIdFromSession();?>'
                    }, function(newImage) {
                        var eURL = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- ./?%&=]*)?/
                        var arrInfo = newImage.split("[FBIMG]");
                        var imgSize = "";

                        if (arrInfo[0] && eURL.exec(arrInfo[0])) {
                            $("#facebook_image").val(arrInfo[0]);
                            if (arrInfo[1] && arrInfo[2]) {
                                var w = parseInt(arrInfo[1]);
                                var h = parseInt(arrInfo[2]);
                                $("#facebook_image_height").val(h);
                                $("#facebook_image_width").val(w);

                                imgSize = " width=\"" + w + "\" ";
                                imgSize += " height=\"" + h + "\" ";
                            } else {
                                $("#facebook_image_height").val("<?=PROFILE_MEMBERS_IMAGE_HEIGHT?>");
                                $("#facebook_image_widht").val("<?=PROFILE_MEMBERS_IMAGE_WIDTH?>");
                                imgSize = " width=\"<?=PROFILE_MEMBERS_IMAGE_WIDTH?>\" ";
                                imgSize += " height=\"<?=PROFILE_MEMBERS_IMAGE_HEIGHT?>\" ";
                            }
                            $("#image_fb").html("<img src=\"" + arrInfo[0] + "\" " + imgSize + " alt=\"\" />");
                            if ($("#message").text() == "<?=system_showText(LANG_MSGERROR_ERRORUPLOADINGIMAGE);?>") {
                                $("#message").removeClass("errorMessage");
                                $("#message").text("");
                            }
                        } else if (!eURL.exec(arrInfo[0])) {
                            $("#facebook_image").val("");
                            $("#image_fb").html("<img src=\"<?=DEFAULT_URL;?>/assets/images/user-image.png\" width=\"<?=PROFILE_MEMBERS_IMAGE_WIDTH?>\" height=\"<?=PROFILE_MEMBERS_IMAGE_HEIGHT?>\" alt=\"No Image\" />");
                            $("#message").removeClass("successMessage");
                            $("#message").removeClass("informationMessage");
                            $("#message").addClass("errorMessage");
                            $("#message").text("<?=system_showText(LANG_MSGERROR_ERRORUPLOADINGIMAGE);?>");
                        }
                    });
                }

                function profileStatus(check_id) {
                    var check = $("#" + check_id).attr("checked");

                    $.post(DEFAULT_URL + "/includes/code/profile.php", {
                        action: "changeStatus",
                        has_profile: check,
                        account_id: '<?=sess_getAccountIdFromSession();?>',
                        ajax: true
                    });

                }

                function validateFriendlyURL(friendly_url, current_acc) {

                    $("#URL_ok").css("display", "none");
                    $("#URL_notok").css("display", "none");

                    if (friendly_url) {

                        $("#loadingURL").css("display", "");

                        $.get(DEFAULT_URL + "/check_friendlyurl.php", {
                            type: "profile",
                            friendly_url: friendly_url,
                            current_acc : current_acc
                        }, function (response) {
                            if ($.trim(response) == "ok") {
                                $("#urlSample").html(friendly_url);
                                $("#URL_ok").css("display", "");
                                $("#URL_notok").css("display", "none");
                            } else {
                                $("#URL_ok").css("display", "none");
                                $("#URL_notok").css("display", "");
                            }
                            $("#loadingURL").css("display", "none");
                        });
                    } else {
                        $("#URL_ok").css("display", "none");
                        $("#URL_notok").css("display", "none");
                    }
                }

                function removePhoto() {
                    $.post(DEFAULT_URL + "/includes/code/profile.php", {
                        action: "removePhoto",
                        account_id: '<?=sess_getAccountIdFromSession();?>',
                        ajax: true
                    }, function(){
                        $("#facebook_image").attr("value", "");
                        $("#facebook_image_height").attr("value", "");
                        $("#facebook_image_width").attr("value", "");
                        $("#linkRemovePhoto").css("display", "none");
                        $("#image_fb").html("<img src=\"<?=DEFAULT_URL;?>/assets/images/user-image.png\" width=\"<?=PROFILE_MEMBERS_IMAGE_WIDTH?>\" height=\"<?=PROFILE_MEMBERS_IMAGE_HEIGHT?>\" alt=\"No Image\" />");
                    });
                }

            </script>

            <!--[if lt IE 9]>
            <script src="<?=DEFAULT_URL."/scripts/html5shiv.js"?>"></script>
            <![endif]-->

        </body>

    </html>