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
	# * FILE: /conf/default_themecolors.inc.php
	# ----------------------------------------------------------------------------------------------------

	//Theme: Default
	//Scheme Color: Default

	//Main pallete colors
	$arrayColors["default"]["default"]["color1"] = "42414f";
	$arrayColors["default"]["default"]["color2"] = "ff5a5f";

	//Advanced colors
	$arrayColors["default"]["default"]["colorNavbar"] = "f8f8f8";
	$arrayColors["default"]["default"]["colorNavbarLink"] = "252525";
	$arrayColors["default"]["default"]["colorFooterLink"] = "f2f2f4";
	$arrayColors["default"]["default"]["fontOption"] = "1";
	$arrayColors["default"]["default"]["fontName"] = "\"Source Sans Pro\", \"Trebuchet MS\", sans-serif";

	$arrayColors["default"]["default"]["colorKnob"] = "ff5a5f";

	define("ARRAY_DEFAULT_COLORS", serialize($arrayColors));
?>
