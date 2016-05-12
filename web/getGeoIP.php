<?

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
# * FILE: /getGeoIP.php
# ----------------------------------------------------------------------------------------------------

# ----------------------------------------------------------------------------------------------------
# LOAD CONFIG
# ----------------------------------------------------------------------------------------------------
include("./conf/loadconfig.inc.php");

header("Content-Type: text/html; charset=" . EDIR_CHARSET, true);

# ----------------------------------------------------------------------------------------------------
# CODE
# ----------------------------------------------------------------------------------------------------

$debug_geoIP = false;

if (GEOIP_FEATURE != "off") {
    if ($_COOKIE["location_geoip"]) {
        $location_GeoIP = $_COOKIE["location_geoip"];
    } else {
        $location_GeoIP = geo_GeoIP($debug_geoIP);

        if (EDIR_LANGUAGE == "pt_br" && string_strpos($location_GeoIP, "Brazil") !== false) {
            $location_GeoIP = str_replace("Brazil", "Brasil", $location_GeoIP);
        }

        setcookie("location_geoip", $location_GeoIP, 0, "" . EDIRECTORY_FOLDER . "/");
    }

    echo $location_GeoIP;
}
