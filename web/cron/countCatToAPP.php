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
# * FILE: /cron/countCatToAPP.php
# ----------------------------------------------------------------------------------------------------

# ----------------------------------------------------------------------------------------------------
# LOAD CONFIG
# ----------------------------------------------------------------------------------------------------
$_inCron = true;
include("../conf/config.inc.php");

$host = _DIRECTORYDB_HOST;
$db = _DIRECTORYDB_NAME;
$user = _DIRECTORYDB_USER;
$pass = _DIRECTORYDB_PASS;

// Counting categories to App
$link = mysql_connect($host, $user, $pass);
mysql_query("SET NAMES 'utf8'", $link);
mysql_query('SET character_set_connection=utf8', $link);
mysql_query('SET character_set_client=utf8', $link);
mysql_query('SET character_set_results=utf8', $link);
mysql_select_db($db);
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////

$sqlDomain = "	SELECT `id`, `database_host`, `database_port`, `database_username`, `database_password`, `database_name`, `url` FROM `Domain` WHERE `status` = 'A'";
$resDomain = mysql_query($sqlDomain, $link);
if ($resDomain) {
    while ($row = mysql_fetch_assoc($resDomain)) {
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "http://" . $row["url"] . "/API/checkcategory.php");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // grab URL and pass it to the browser
        curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);
    }
}
