#!/usr/bin/php -q
<?php
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
# * FILE: /cron/count_locations.php
# ----------------------------------------------------------------------------------------------------

////////////////////////////////////////////////////////////////////////////////////////////////////
ini_set("html_errors", false);
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
define("EDIRECTORY_ROOT", __DIR__ . "/..");
define("BIN_PATH", EDIRECTORY_ROOT . "/bin");
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
$_inCron = true;
include_once(EDIRECTORY_ROOT . "/conf/config.inc.php");
include_once(EDIRECTORY_ROOT . "/functions/log_funct.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());

    return ((float)$usec + (float)$sec);
}

$time_start = getmicrotime();
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
$host = _DIRECTORYDB_HOST;
$db = _DIRECTORYDB_NAME;
$user = _DIRECTORYDB_USER;
$pass = _DIRECTORYDB_PASS;
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
$link = mysql_connect($host, $user, $pass);
mysql_query("SET NAMES 'utf8'", $link);
mysql_query('SET character_set_connection=utf8', $link);
mysql_query('SET character_set_client=utf8', $link);
mysql_query('SET character_set_results=utf8', $link);
mysql_select_db($db);
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
$sqlDomain = "	SELECT
						D.`id`, D.`database_host`, D.`database_port`, D.`database_username`, D.`database_password`, D.`database_name`, D.`url`
					FROM `Domain` AS D
					LEFT JOIN `Control_Cron` AS CC ON (CC.`domain_id` = D.`id`)
					WHERE CC.`running` = 'N'
					AND CC.`type` = 'count_locations'
					AND D.`status` = 'A'
					AND (ADDDATE(CC.`last_run_date`, INTERVAL 20 MINUTE) <= NOW() OR CC.`last_run_date` = '0000-00-00 00:00:00')
                    ORDER BY
						IF (CC.`last_run_date` IS NULL, 0, 1),
						CC.`last_run_date`,
						D.`id`
                    LIMIT 1";

$resDomain = mysql_query($sqlDomain, $link);

if (mysql_num_rows($resDomain) > 0) {
    $rowDomain = mysql_fetch_assoc($resDomain);
    define("SELECTED_DOMAIN_ID", $rowDomain["id"]);

    $sqlUpdate = "UPDATE `Control_Cron` SET `running` = 'Y', `last_run_date` = NOW() WHERE `domain_id` = " . SELECTED_DOMAIN_ID . " AND `type` = 'count_locations'";
    mysql_query($sqlUpdate, $link);
    $messageLog = "Starting cron";
    log_addCronRecord($link, "count_locations", $messageLog, false, $cron_log_id);

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    $domainHost = $rowDomain["database_host"] . ($rowDomain["database_port"] ? ":" . $rowDomain["database_port"] : "");
    $domainUser = $rowDomain["database_username"];
    $domainPass = $rowDomain["database_password"];
    $domainDBName = $rowDomain["database_name"];
    $domainURL = $rowDomain["url"];

    $link_domain = mysql_connect($domainHost, $domainUser, $domainPass, true);
    mysql_query("SET NAMES 'utf8'", $link_domain);
    mysql_query('SET character_set_connection=utf8', $link_domain);
    mysql_query('SET character_set_client=utf8', $link_domain);
    mysql_query('SET character_set_results=utf8', $link_domain);
    mysql_select_db($domainDBName);

    $_inCron = false;
    include_once(EDIRECTORY_ROOT . "/conf/loadconfig.inc.php");

    $locationCounterObj = new LocationCounter();

    $arrayModules[] = "listing";
    $arrayModules[] = "classified";
    $arrayModules[] = "event";
    $arrayModules[] = "promotion";
    foreach ($arrayModules as $value) {
        $locationCounterObj->ReCountLocations($value, SELECTED_DOMAIN_ID);
    }

    $sqlUpdate = "UPDATE `Control_Cron` SET `running` = 'N', `last_run_date` = NOW() WHERE `domain_id` = " . SELECTED_DOMAIN_ID . " AND `type` = 'count_locations'";
    mysql_query($sqlUpdate, $link);
    $messageLog = "Cron finished";

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    $time_end = getmicrotime();
    $time = $time_end - $time_start;
    print "Count locations on Domain " . SELECTED_DOMAIN_ID . " - " . date("Y-m-d H:i:s") . " - " . round($time,
            2) . " seconds.\n";
    log_addCronRecord($link, "count_locations", $messageLog, true, $cron_log_id, true, round($time, 2));
    ////////////////////////////////////////////////////////////////////////////////////////////////////

} else {
    exit;
}
