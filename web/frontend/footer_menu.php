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
# * FILE: /frontend/footer_menu.php
# ----------------------------------------------------------------------------------------------------

?>

    <ul class="list-unstyled">

        <li>
            <a href="<?=NON_SECURE_URL?>">
                <?=system_showText(LANG_MENU_HOME);?>
            </a>
        </li>

        <li>
            <a href="<?=LISTING_DEFAULT_URL?>/">
                <?=system_showText(LANG_MENU_LISTING);?>
            </a>
        </li>

        <? if (EVENT_FEATURE == "on" && CUSTOM_EVENT_FEATURE == "on") { ?>
            <li>
                <a href="<?=EVENT_DEFAULT_URL?>/">
                    <?=system_showText(LANG_MENU_EVENT);?>
                </a>
            </li>
        <? } ?>

        <? if (CLASSIFIED_FEATURE == "on" && CUSTOM_CLASSIFIED_FEATURE == "on") { ?>
            <li>
                <a href="<?=CLASSIFIED_DEFAULT_URL?>/">
                    <?=system_showText(LANG_MENU_CLASSIFIED);?>
                </a>
            </li>
        <? } ?>

        <? if (ARTICLE_FEATURE == "on" && CUSTOM_ARTICLE_FEATURE == "on") { ?>
            <li>
                <a href="<?=ARTICLE_DEFAULT_URL?>/">
                    <?=system_showText(LANG_MENU_ARTICLE);?>
                </a>
            </li>
        <? } ?>

        <? if (PROMOTION_FEATURE == "on" && CUSTOM_HAS_PROMOTION == "on" && CUSTOM_PROMOTION_FEATURE == "on") { ?>
            <li>
                <a href="<?=PROMOTION_DEFAULT_URL?>/">
                    <?=system_showText(LANG_MENU_PROMOTION);?>
                </a>
            </li>
        <? } ?>

        <? if (BLOG_FEATURE == "on" && CUSTOM_BLOG_FEATURE == "on") { ?>
            <li>
                <a href="<?=BLOG_DEFAULT_URL?>/">
                    <?=system_showText(LANG_MENU_BLOG);?>
                </a>
            </li>
        <? } ?>

        <li>
            <a href="<?=NON_SECURE_URL?>/<?=ALIAS_ADVERTISE_URL_DIVISOR?>/">
                <?=system_showText(LANG_MENU_ADVERTISE);?>
            </a>
        </li>
        <li>
            <a href="<?=NON_SECURE_URL?>/<?=ALIAS_CONTACTUS_URL_DIVISOR?>/">
                <?=system_showText(LANG_MENU_CONTACT);?>
            </a>
        </li>
        <li>
            <a href="<?=NON_SECURE_URL?>/<?=ALIAS_LEAD_URL_DIVISOR?>/">
                <?=system_showText(LANG_MENU_ENQUIRE);?>
            </a>
        </li>
        <li>
            <a href="<?=NON_SECURE_URL?>/<?=ALIAS_FAQ_URL_DIVISOR?>/">
                <?=system_showText(LANG_MENU_FAQ);?>
            </a>
        </li>
        <li>
            <a href="<?=NON_SECURE_URL?>/<?=ALIAS_SITEMAP_URL_DIVISOR?>/">
                <?=system_showText(LANG_MENU_SITEMAP);?>
            </a>
        </li>
        <li>
            <a href="<?=NON_SECURE_URL?>/<?=ALIAS_TERMS_URL_DIVISOR?>/">
                <?=system_showText(LANG_TERMS_USE);?>
            </a>
        </li>
        <li>
            <a href="<?=NON_SECURE_URL?>/<?=ALIAS_PRIVACY_URL_DIVISOR?>/">
                <?=system_showText(LANG_PRIVACY_POLICY);?>
            </a>
        </li>


    </ul>