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
	# * FILE: /includes/code/slider.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["settings"] && !DEMO_LIVE_MODE) {
        
		/*
		 * Prepare POST to validate
		 */
		 if ($_FILES) {
		 	$i = 1;
		 	$image_errors = array();
		 	
		 	$maxImageSize = ((UPLOAD_MAX_SIZE * 10) + 1)."00000";
		 	
		 	foreach ($_FILES as $key => $value) {

		 		if (strlen($value["tmp_name"]) > 0) {
		 			if (image_upload_check($value["tmp_name"])) {
		 				if (strlen($value["name"])) {
		 					$_POST[$key] = $value["name"];
		 				}
		 			} else {
		 				$image_errors[] = "&#149;&nbsp; ".system_showText(LANG_SITEMGR_ITEM_SLIDER." ".$i." - ".LANG_SITEMGR_MSGERROR_FILEEXTENSIONNOTALLOWED);
		 			}	
		 			
		 			if ($value["size"] > $maxImageSize) {
		 				$image_errors[] = "&#149;&nbsp; ".system_showText(LANG_SITEMGR_ITEM_SLIDER." ".$i." - ".system_showText(LANG_SITEMGR_MSGERROR_MAXFILESIZEALLOWEDIS." ".UPLOAD_MAX_SIZE."MB."));
		 			}
		 		}
		 		$i++;
		 	}
		 }
		 
		/*
		 * Validate form
		 */
		if ((count($image_errors) == 0)) {
			/*
			 * Get all items of slider to save
			 */
			$array_save_slider = array();
			
			for ($i = 1; $i <= $_POST["number_of_items"]; $i++) {
				
				/*
				 * Preparing items to save
				 */
				$array_save_slider[$i]["title"] = trim($_POST[$i."_title"]);
					
                // strip \r chars provided by Windows, in order to keep character count standard
                if ($_POST[$i."_summary"]) {
                    $array_save_slider[$i]["summary"] = str_replace("\r", "", $_POST[$i."_summary"]);
                }

                if ($_POST[$i."_alternative_text"]) {
                    $array_save_slider[$i]["alternative_text"] = str_replace("\r", "", $_POST[$i."_alternative_text"]);
                }

                if ($_POST[$i."_title_text"]) {
                    $array_save_slider[$i]["title_text"] = str_replace("\r", "", $_POST[$i."_title_text"]);
                }

                if ($_POST[$i."_link"]) {
                    // fixing url field if needed.
                    if (trim($_POST[$i."_link"]) != "") {
                        if (string_strpos($_POST[$i."_link"], "://") !== false) {
                            $aux_link = explode("://", $_POST[$i."_link"]);
                            $aux_link = $aux_link[1];
                            $_POST[$i."_link"] = $aux_link;
                        }
                    }

                    $array_save_slider[$i]["link"] = str_replace("\r", "", $_POST[$i."_link"]);
                }
				
				$array_save_slider[$i]["id"]			= $_POST[$i."_id"];
				$array_save_slider[$i]["target"]        = ($_POST[$i."_target_window"] ? "blank" : "self");
				$array_save_slider[$i]["slide_order"]	= $i;
				$array_save_slider[$i]["image_id"]		= $_POST[$i."_image_id"];
				$array_save_slider[$i]["title"]         = preg_replace('/\s\s+/', ' ', $array_save_slider[$i]["title"]);
                
				//Clean the image for each slider
				if ($_POST[$i."_remove_image"]) {
					unset($auxSlider);
					$auxSlider = new Slider($_POST[$i."_id"]);
					$idm = $auxSlider->getNumber("image_id");
					if ($idm) {
						$image = new Image($idm);
						if ($image){
							$image->Delete();
						}
					}					
				}
				
				/*
				 * Upload Images
				 */
				if ($_FILES[$i."_image"]["error"] == 0) {
                    
                    $imageObj = image_upload($_FILES[$i."_image"]["tmp_name"], IMAGE_SLIDER_WIDTH, IMAGE_SLIDER_HEIGHT, 'sitemgr_', false);
					if ($imageObj) {
						$array_save_slider[$i]["image_id"] = $imageObj->getNumber("id");
						unset($imageObj);
					}
				}
                
                if (!$array_save_slider[$i]["image_id"]) {
                    $array_save_slider[$i]["title"] = "";
                    $array_save_slider[$i]["summary"] = "";
                    $array_save_slider[$i]["alternative_text"] = "";
                    $array_save_slider[$i]["title_text"] = "";
                    $array_save_slider[$i]["link"] = "";
                    $array_save_slider[$i]["price"] = "";
                }
			}
			
			/*
			 * Saving slider items on database
			 */
			for ($i = 1; $i <= $_POST["number_of_items"]; $i++) {
				unset($sliderObj);
				
				if ($array_save_slider[$i]["image_id"] || $array_save_slider[$i]["title"]) {
					$message = system_showText(LANG_SITEMGR_SLIDER_MESSAGE_SAVED);
				}
				
				$sliderObj = new Slider($array_save_slider[$i]);
				$sliderObj->save();
			}
			
			if ($message) {
				header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/slider/index.php?message=".urlencode($message));
			} else {
				header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/slider/index.php");
			}
			exit;

		} else {
		
			unset($array_slider);
			$array_slider = array();
			foreach ($_POST as $key => $value) {
				if (is_numeric(substr($key,0,1))) {
					$array_slider[substr($key,0,1)][substr($key,2)] = htmlspecialchars($value);
				}
			}
			$error = 1;
			$message_slider .= implode("<br />",$image_errors);
			$message = $message_slider;
            
		}

		// removing slashes added if required
		$_POST = format_magicQuotes($_POST);
		$_GET  = format_magicQuotes($_GET);

		extract($_POST);
		extract($_GET);

	} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["delete"] && !DEMO_LIVE_MODE) {
        
        $imageObj = new Image($_POST["image_id"]);
		$imageObj->Delete();
		
		$sliderObj = new Slider($_POST["slider_id"]);
		$sliderObj->ClearSlider();
        
        header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/content/slider/index.php");
        exit;
        
    } else {
		
		/**
		 * Get slider items
		 */
		$sliderObj = new Slider();
		$array_slider = $sliderObj->getAllSliderItems();
	}
	
	setting_get("slider_feature", $slider_feature);

?>