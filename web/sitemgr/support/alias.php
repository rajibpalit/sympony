<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/support/alias.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# THIS PAGE IS ONLY USED BY THE SUPPORT
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();

	if (!sess_getSMIdFromSession()){
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/");
        exit;
	} else {
		$dbMain = db_getDBObject(DEFAULT_DB, true);
		$sql = "SELECT username FROM SMAccount WHERE id = ".sess_getSMIdFromSession();
		$row = mysql_fetch_assoc($dbMain->query($sql));
		if ($row["username"] != ARCALOGIN_USERNAME){
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/");
            exit;
		}
	}

    $url_redirect = DEFAULT_URL."/".SITEMGR_ALIAS."/support/reset.php";
    extract($_GET);
    extract($_POST);

    # ----------------------------------------------------------------------------------------------------
	# FORMS DEFINES
	# ----------------------------------------------------------------------------------------------------
    $aliasModules = array();
    $aliasModules[0]["name"] = "ALIAS_LISTING_MODULE";
    $aliasModules[0]["label"] = "Listing";
    $aliasModules[0]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_listing_module : ALIAS_LISTING_MODULE);
    $aliasModules[0]["tip"] = NON_SECURE_URL."/<b>".ALIAS_LISTING_MODULE."</b>";

    $aliasModules[1]["name"] = "ALIAS_EVENT_MODULE";
    $aliasModules[1]["label"] = "Event";
    $aliasModules[1]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_event_module : ALIAS_EVENT_MODULE);
    $aliasModules[1]["tip"] = NON_SECURE_URL."/<b>".ALIAS_EVENT_MODULE."</b>";

    $aliasModules[2]["name"] = "ALIAS_CLASSIFIED_MODULE";
    $aliasModules[2]["label"] = "Classified";
    $aliasModules[2]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_classified_module : ALIAS_CLASSIFIED_MODULE);
    $aliasModules[2]["tip"] = NON_SECURE_URL."/<b>".ALIAS_CLASSIFIED_MODULE."</b>";

    $aliasModules[3]["name"] = "ALIAS_ARTICLE_MODULE";
    $aliasModules[3]["label"] = "Article";
    $aliasModules[3]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_article_module : ALIAS_ARTICLE_MODULE);
    $aliasModules[3]["tip"] = NON_SECURE_URL."/<b>".ALIAS_ARTICLE_MODULE."</b>";

    $aliasModules[4]["name"] = "ALIAS_PROMOTION_MODULE";
    $aliasModules[4]["label"] = "Promotion";
    $aliasModules[4]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_promotion_module : ALIAS_PROMOTION_MODULE);
    $aliasModules[4]["tip"] = NON_SECURE_URL."/<b>".ALIAS_PROMOTION_MODULE."</b>";

    $aliasModules[5]["name"] = "ALIAS_BLOG_MODULE";
    $aliasModules[5]["label"] = "Blog";
    $aliasModules[5]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_blog_module : ALIAS_BLOG_MODULE);
    $aliasModules[5]["tip"] = NON_SECURE_URL."/<b>".ALIAS_BLOG_MODULE."</b>";

    $aliasDivisors[0]["name"] = "ALIAS_CLAIM_URL_DIVISOR";
    $aliasDivisors[0]["label"] = "Claim page";
    $aliasDivisors[0]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_claim_url_divisor : ALIAS_CLAIM_URL_DIVISOR);
    $aliasDivisors[0]["tip"] = NON_SECURE_URL."/<b>".ALIAS_CLAIM_URL_DIVISOR."</b>/...";

    $aliasDivisors[1]["name"] = "ALIAS_REVIEW_URL_DIVISOR";
    $aliasDivisors[1]["label"] = "Reviews page";
    $aliasDivisors[1]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_review_url_divisor : ALIAS_REVIEW_URL_DIVISOR);
    $aliasDivisors[1]["tip"] = NON_SECURE_URL."/".ALIAS_LISTING_MODULE."/<b>".ALIAS_REVIEW_URL_DIVISOR."</b>/...";

    $aliasDivisors[2]["name"] = "ALIAS_CHECKIN_URL_DIVISOR";
    $aliasDivisors[2]["label"] = "Checkins page";
    $aliasDivisors[2]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_checkin_url_divisor : ALIAS_CHECKIN_URL_DIVISOR);
    $aliasDivisors[2]["tip"] = NON_SECURE_URL."/".ALIAS_LISTING_MODULE."/<b>".ALIAS_CHECKIN_URL_DIVISOR."</b>/...";

    $aliasPages = array();
    $i = 0;

    $aliasPages[$i]["name"] = "ALIAS_LISTING_ALLCATEGORIES_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Listing all categories page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_listing_allcategories_url_divisor : ALIAS_LISTING_ALLCATEGORIES_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/".ALIAS_LISTING_MODULE."/<b>".ALIAS_LISTING_ALLCATEGORIES_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_EVENT_ALLCATEGORIES_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Event All categories page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_event_allcategories_url_divisor : ALIAS_EVENT_ALLCATEGORIES_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/".ALIAS_EVENT_MODULE."/<b>".ALIAS_EVENT_ALLCATEGORIES_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_CLASSIFIED_ALLCATEGORIES_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Classified all categories page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_classified_allcategories_url_divisor : ALIAS_CLASSIFIED_ALLCATEGORIES_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/".ALIAS_CLASSIFIED_MODULE."/<b>".ALIAS_CLASSIFIED_ALLCATEGORIES_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_ARTICLE_ALLCATEGORIES_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Article all categories page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_article_allcategories_url_divisor : ALIAS_ARTICLE_ALLCATEGORIES_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/".ALIAS_ARTICLE_MODULE."/<b>".ALIAS_ARTICLE_ALLCATEGORIES_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_PROMOTION_ALLCATEGORIES_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Promotion all categories page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_promotion_allcategories_url_divisor : ALIAS_PROMOTION_ALLCATEGORIES_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/".ALIAS_PROMOTION_MODULE."/<b>".ALIAS_PROMOTION_ALLCATEGORIES_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_BLOG_ALLCATEGORIES_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Blog all categories page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_blog_allcategories_url_divisor : ALIAS_BLOG_ALLCATEGORIES_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/".ALIAS_BLOG_MODULE."/<b>".ALIAS_BLOG_ALLCATEGORIES_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_ALLLOCATIONS_URL_DIVISOR";
    $aliasPages[$i]["label"] = "All locations page (all modules)";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_alllocations_url_divisor : ALIAS_ALLLOCATIONS_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/".ALIAS_LISTING_MODULE."/<b>".ALIAS_ALLLOCATIONS_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_ADVERTISE_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Advertise Page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_advertise_url_divisor : ALIAS_ADVERTISE_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/<b>".ALIAS_ADVERTISE_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_CONTACTUS_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Contact Us Page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_contactus_url_divisor : ALIAS_CONTACTUS_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/<b>".ALIAS_CONTACTUS_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_FAQ_URL_DIVISOR";
    $aliasPages[$i]["label"] = "FAQ Page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_faq_url_divisor : ALIAS_FAQ_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/<b>".ALIAS_FAQ_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_SITEMAP_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Sitemap Page";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_sitemap_url_divisor : ALIAS_SITEMAP_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/<b>".ALIAS_SITEMAP_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_LEAD_URL_DIVISOR";
    $aliasPages[$i]["label"] = "General Contact Page (Leads)";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_lead_url_divisor : ALIAS_LEAD_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/<b>".ALIAS_LEAD_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_TERMS_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Terms of Use";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_terms_url_divisor : ALIAS_TERMS_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/<b>".ALIAS_TERMS_URL_DIVISOR."</b>/";

    $i++;
    $aliasPages[$i]["name"] = "ALIAS_PRIVACY_URL_DIVISOR";
    $aliasPages[$i]["label"] = "Privacy Policy";
    $aliasPages[$i]["value"] = ($_SERVER["REQUEST_METHOD"] == "POST" ? $alias_privacy_url_divisor : ALIAS_PRIVACY_URL_DIVISOR);
    $aliasPages[$i]["tip"] = NON_SECURE_URL."/<b>".ALIAS_PRIVACY_URL_DIVISOR."</b>/";


	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        unset($errorArray, $errorMessage);

        //Validation
        foreach($aliasModules as $module) {
            if (!${strtolower($module["name"])}) {
                $errorArray[] = "&#149;&nbsp;".$module["label"];
            }
        }

        foreach($aliasDivisors as $divisor) {
            if (!${strtolower($divisor["name"])}) {
                $errorArray[] = "&#149;&nbsp;".$divisor["label"];
            }
        }

        foreach($aliasPages as $page) {
            if (!${strtolower($page["name"])}) {
                $errorArray[] = "&#149;&nbsp;".$page["label"];
            }
        }

        if (is_array($errorArray) && $errorArray[0]) {
            $errorMessage = "<b>".system_showText(LANG_MSG_FIELDS_CONTAIN_ERRORS)."</b><br />".implode("<br />", $errorArray);
        }

        if (!$errorMessage) {
            $fileConstPath = EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/conf/constants.inc.php";

            // saves configuration in yaml file
            $domain = new Domain(SELECTED_DOMAIN_ID);
            $classSymfonyYml = new Symfony('domains/'.$domain->getString('url').'.route.yml');
            $classSymfonyYml->save('Configs', array('parameters' => $_POST));

            system_writeConstantsFile($fileConstPath, SELECTED_DOMAIN_ID, $_POST);
            header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/support/alias.php?message=ok");
            exit;
        }

    }

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/header.php");

	# ----------------------------------------------------------------------------------------------------
	# NAVBAR
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/navbar.php");

    # ----------------------------------------------------------------------------------------------------
    # SIDEBAR
    # ----------------------------------------------------------------------------------------------------
    include(SM_EDIRECTORY_ROOT."/layout/sidebar-support.php");

?>

    <main class="wrapper-dashboard togglesidebar container-fluid">

        <?
        require(EDIRECTORY_ROOT."/".SITEMGR_ALIAS."/registration.php");
        require(EDIRECTORY_ROOT."/includes/code/checkregistration.php");
        require(EDIRECTORY_ROOT."/frontend/checkregbin.php");
        ?>

        <section class="heading">
            <h1>Alias Options</h1>
            <? if ($errorMessage) { ?>
                <p class="alert alert-warning"><?=$errorMessage?></p>
            <? } elseif ($_GET["message"] == "ok") { ?>
                <p class="alert alert-success">Settings changed!</p>
            <? } ?>
        </section>

        <form name="configChecker" id="configChecker" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post" class="form-horizontal" role="form">

            <section class=" row section-form">
                <div class="col-sm-12">
                    <? include(INCLUDES_DIR."/forms/form-support-alias.php"); ?>
                </div>
            </section>
            <section class="row footer-action">
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </section>

        </form>

    </main>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>
