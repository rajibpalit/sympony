<?php
    /**
    * # Admin Panel for eDirectory
    * @copyright Copyright 2015 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/layout/nav-tabs-content-blog.php
	# ----------------------------------------------------------------------------------------------------

    $matches = null;
    preg_match( "/(\w*)(?=\.php)/", $_SERVER['PHP_SELF'], $matches );

    empty( $matches ) or $activeTab[ array_pop( $matches ) ] = 'class="active"';
?>

    <? if ($id) { ?>
    <ul class="nav nav-tabs pull-left" role="tablist">
        <li <?= $activeTab['blog']; ?>>
            <a href="<?=$url_redirect?>/blog.php?id=<?=$id?>" role="tab"><?=system_showText(LANG_SITEMGR_LISTINGTEMPLATE_EDITINFORMATION);?></a>
        </li>

        <li <?= $activeTab['seocenter']; ?>>
            <a href="<?=$url_redirect?>/seocenter.php?id=<?=$id?>" role="tab"><?=system_showText(LANG_LABEL_SEO_TUNING);?></a>
        </li>
    </ul>
    <? } ?>