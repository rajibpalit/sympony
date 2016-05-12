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
	# * FILE: /includes/code/language_center.php
	# ----------------------------------------------------------------------------------------------------

    setting_get("sitemgr_language", $sitemgr_language);

    switch ($sitemgr_language) {
        case "en_us" :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "After editing your language file, please upload it via FTP at: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> and hit submit to finish the process. Don't have FTP access? Please contact our support.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "The file <strong>[file]</strong> was not found at <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>. Please try again.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "Upload your edited files via FTP at: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>, hit submit here and you're done. Select your new language from the \"Language\" tab above.");
                    break;
        case "fr_fr" :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "Après avoir modifié votre fichier de langue, s'il vous plaît télécharger via FTP à: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> et sur ​​soumettre pour terminer le processus. Ne pas avoir accès FTP? S'il vous plaît contacter notre support.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "Le fichier <strong>[file]</strong> n'a pas été trouvé à <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>. S'il vous plaît essayez de nouveau.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "Envoyez vos fichiers modifiés via FTP à: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>, frappez présenter ici et vous avez terminé. Sélectionnez votre nouvelle langue dans l'onglet \"Langue\" ci-dessus.");
                    break;
        case "ge_ge" :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "Nach der Bearbeitung der Sprachdatei, laden Sie diese bitte per FTP auf: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> und schlug einreichen, um den Prozess zu beenden. Sie haben noch keine FTP-Zugang? Bitte kontaktieren Sie unseren Support.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "Die Datei <strong>[file]</strong> wurde nicht <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> gefunden. Bitte versuchen Sie es erneut.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "Laden Sie Ihre bearbeiteten Dateien per FTP auf: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>, traf hier einreichen und fertig. Wählen Sie Ihre neue Sprache aus der Registerkarte \"Sprache\" oben.");
        case "it_it" :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "Dopo aver modificato il file di lingua, si prega di caricarlo via FTP in: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> e colpire presentare per completare il processo. Non hanno accesso FTP? Si prega di contattare il nostro supporto.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "Il file <strong>[file]</strong> non è stato trovato in <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>. Riprova.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "Carica i tuoi file modificati via FTP in: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>, ha colpito presentare qui e il gioco è fatto. Selezionare la nuova lingua dalla scheda \"Lingua\" di cui sopra.");
        case "pt_br" :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "Após alterar seu arquivo de idioma, por favor, envio-o via FTP para: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> e clique em Enviar para concluir o processo. Não têm acesso FTP? Entre em contato com o nosso suporte.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "O arquivo <strong>[file]</strong> não foi encontrado em <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>. Por favor, tente novamente.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "Envie seus arquivos editados via FTP para: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> e depois clique em Enviar. Você poderá selecionar o novo idioma na aba \"Idioma\" acima.");
        case "tr_tr" :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "Dil dosyasını düzenledikten sonra, en FTP üzerinden upload lütfen: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> ve işlemini bitirmek için teslim çarptı. FTP erişimi yok mu? Bizim desteğe başvurun.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "<strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> de bulunamadı. Lütfen tekrar deneyin.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "De FTP üzerinden düzenlenmiş dosyaları yükleyin: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> burada göndermek vurdu ve bitirdiniz. Yukarıdaki \"Dil\" sekmesinden yeni dili seçin.");
        case "es_es" :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "Después de editar el archivo de idioma, por favor subirlo mediante FTP en: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> y pulse Enviar para finalizar el proceso. ¿No tienes acceso FTP? Por favor, póngase en contacto con nuestro apoyo.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "El archivo <strong>[file]</strong> no se encontró en <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>. Por favor, inténtelo de nuevo.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "Sube tus archivos editados a través de FTP en: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>, pulse Enviar aquí y ya está. Seleccione el nuevo idioma en la pestaña de \"Idioma\" arriba.");
        default      :
                    define("LANG_SITEMGR_LANGUAGE_DOWNLOAD_TIP2", "After editing your language file, please upload it via FTP at: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong> and hit submit to finish the process. Don't have FTP access? Please contact our support.");
                    define("LANG_SITEMGR_LANGUAGE_FILENOTFOUND", "The file <strong>[file]</strong> was not found at <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>. Please try again.");
                    define("LANG_SITEMGR_LANGUAGE_ADD_5_NEW", "Upload your edited files via FTP at: <strong>/custom/domain_".SELECTED_DOMAIN_ID."/lang</strong>, hit submit here and you're done. Select your new language from the \"Language\" tab above.");
                    break;
    }

    if ($actionFrom == "changeLang") {

        if (isset($active) && $id) {
            $langObj = new Lang($id);
            $langObj->changeDefaultLang();
            $langObj->writeLanguageFile();

            // Saves yaml
            $domain = new Domain(SELECTED_DOMAIN_ID);
            $symfony = new Symfony('domain.yml');
            $lang = array(
                'rebuildElastic' => true,
                $domain->getString('url') => array(
                    'locale' => $id,
                ),
            );
            $symfony->save('multi_domain', $lang);


            $url_redirect .= "?message=2";
            header("Location: $url_redirect");
            exit;
        } elseif (isset($activeAdmin) && $id) {
            if (!setting_set("sitemgr_language", $id)) {
                if (!setting_new("sitemgr_language", $id)) {
                    $error = true;
                }
            }

            $url_redirect .= "?message_admin=2";
            header("Location: $url_redirect");
            exit;
        }

    } elseif ($actionFrom == "editLang") {

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !DEMO_LIVE_MODE) {

            $file_name = $lang.($area == "sitemgr" ? "_sitemgr" : "").".php";

            if (file_exists(EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/".$file_name)) {
                if (string_strpos($file_name, "_sitemgr") === false) {
                    $newFile = EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/".$file_name;
                    language_createJSFiles($newFile, str_replace(".php", "", $file_name));
                }
                $successEdit = true;

            } else {
                $error = str_replace("[file]", $file_name, system_showText(LANG_SITEMGR_LANGUAGE_FILENOTFOUND));
            }

        }

    } elseif ($actionFrom == "editName") {

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !DEMO_LIVE_MODE) {

            //Validate form
            unset($errorArray);
            unset($error);
            unset($uploadFlag);

            //Required Fields
            if (!$language_name) $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_LANGUAGE_LANGNAME_REQUIRED);

            //Validate flag image
            if ($_FILES["flag_image"]["tmp_name"] && file_exists($_FILES['flag_image']['tmp_name']) && filesize($_FILES['flag_image']['tmp_name'])) {

                $uploadFlag = true;
                $array_allowed_types = array('jpeg', 'jpg', 'gif', 'png');
                $arr_flag = explode(".", $_FILES['flag_image']['name']);
                $flag_extension = $arr_flag[count($arr_flag)-1];
                $imageSizedata = getimagesize($_FILES['flag_image']['tmp_name']);

                if (!in_array(string_strtolower($flag_extension),$array_allowed_types) || !$imageSizedata["mime"]) {
                    $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_LANGUAGE_FLAG_INVALIDFILE);
                }
            }

            if (is_array($errorArray) && $errorArray[0]) {
                $error = "<b>".system_showText(LANG_MSG_FIELDS_CONTAIN_ERRORS)."</b><br />".implode("<br />", $errorArray);
            }

            if (!$error) {

                //Update language name
                $langObj = new Lang($clang);
                $langObj->setString("name", $language_name);
                $langObj->Save();

                //Upload flag
                if ($uploadFlag) {
                    $flagFolder = EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/flags";
                    $flagPath = $flagFolder."/$clang.png";
                    @unlink($flagPath); //remove old flag
                    copy($_FILES['flag_image']['tmp_name'], $flagPath);
                }

                $url_redirect .= "?message=0";
                header("Location: $url_redirect");

            }

        }

    } elseif ($actionFrom == "addLang") {

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !DEMO_LIVE_MODE) {

            //Validate form
            unset($errorArray);
            unset($error);

            //Required Fields
            if (!$language_name || $language_name == LANG_SITEMGR_LANGUAGE_NAMELANG) $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_LANGUAGE_LANGNAME_REQUIRED);
            if (!$language_abbr || $language_abbr == LANG_SITEMGR_LANGUAGE_ABBRLANG) $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_LANGUAGE_LANGABBR_REQUIRED);
            if (!$_FILES["flag_image"]["tmp_name"] || !file_exists($_FILES['flag_image']['tmp_name']) || !filesize($_FILES['flag_image']['tmp_name'])) $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_FLAG_REQUIRED);

            $fileName = $language_abbr.".php";
            $fileName_sitemgr = $language_abbr."_sitemgr.php";
            if ($language_abbr != LANG_SITEMGR_LANGUAGE_ABBRLANG) {
                if (!file_exists(EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/".$fileName)) {
                    $errorArray[] = "&#149;&nbsp;".str_replace("[file]", $fileName, system_showText(LANG_SITEMGR_LANGUAGE_FILENOTFOUND));
                }
                if (!file_exists(EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/".$fileName_sitemgr)) {
                    $errorArray[] = "&#149;&nbsp;".str_replace("[file]", $fileName_sitemgr, system_showText(LANG_SITEMGR_LANGUAGE_FILENOTFOUND));
                }
            }

            //Abbreviation
            $validAbbreviation = true;
            if ($language_abbr && $language_abbr != LANG_SITEMGR_LANGUAGE_ABBRLANG) {
                if ($language_abbr[2] != "_" || string_strlen($language_abbr) < 5) {
                    $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_LANGUAGE_LANGABBR_INVALID);
                    $validAbbreviation = false;
                } else {
                    $langAux = new Lang($language_abbr);
                    if ($langAux->getString("id")) {
                        $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_LANGUAGE_LANGABBR_EXISTS);
                        $validAbbreviation = false;
                    }
                }
            }

            //Flag
            if ($_FILES["flag_image"]["tmp_name"] && file_exists($_FILES['flag_image']['tmp_name']) && filesize($_FILES['flag_image']['tmp_name'])) {

                $array_allowed_types = array('jpeg', 'jpg', 'gif', 'png');
                $arr_flag = explode(".",$_FILES['flag_image']['name']);
                $flag_extension = $arr_flag[count($arr_flag)-1];
                $imageSizedata = getimagesize($_FILES['flag_image']['tmp_name']);

                if (!image_upload_check($_FILES['flag_image']['tmp_name'])) {
                    $errorArray[] = "&#149;&nbsp;".system_showText(LANG_SITEMGR_LANGUAGE_FLAG_INVALIDFILE);
                }

            }

            if (is_array($errorArray) && $errorArray[0]) {
                $error = "<b>".system_showText(LANG_MSG_FIELDS_CONTAIN_ERRORS)."</b><br />".implode("<br />", $errorArray);
            }

            if (!$error) {

                $language_abbr = string_strtolower($language_abbr);

                //Upload flag
                $flagFolder = EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/flags";
                $flagPath = $flagFolder."/$language_abbr.png";
                if (!is_dir($flagFolder)) {
                    //create folder custom/domain_x/lang/editor
                    if (!mkdir($flagFolder)) {
                        $errorFolder = true;
                    }
                }
                copy($_FILES['flag_image']['tmp_name'], $flagPath);

                $newFile = EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/".$fileName;
                language_createJSFiles($newFile, str_replace(".php", "", $fileName));

                //Create lang record
                $langArray["id"] = $language_abbr;
                $langArray["name"] = $language_name;
                $langArray["lang_enabled"] = "n";
                $langArray["lang_default"] = "n";

                $langObj = new Lang($langArray);
                $langObj->Save(SELECTED_DOMAIN_ID);

                $message = "success";

            }

        } elseif ($_GET["download"] && !DEMO_LIVE_MODE) {

            unset($files);
            $files[0]["file"] = language_getFilePath("en_us", false, false, false, SELECTED_DOMAIN_ID, false, true);
            $files[0]["name"] = "en_us.php";
            $files[1]["file"] = language_getFilePath("en_us", false, false, true, SELECTED_DOMAIN_ID, false, true);
            $files[1]["name"] = "en_us_sitemgr.php";
            system_downloadFile($files, "en_us", "");

        }

    }

    # ----------------------------------------------------------------------------------------------------
    # FORMS DEFINES
    # ----------------------------------------------------------------------------------------------------
    $allLanguages = unserialize(LANGUAGE_INFORMATION);

    if ($actionFrom == "changeLang") {

        setting_get("sitemgr_language", $sitemgr_language);
        $flagFolder = EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/lang/flags";

    } elseif ($actionFrom == "editName") {

        if (!$clang) {
            $clang = EDIR_LANGUAGE;
        }

        $langObj = new Lang($clang);

        if ($langObj->getNumber("id_number")) {
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                $language_name = $langObj->getString("name");
            }
        } else {
            header("Location: ".$url_redirect);
            exit;
        }
    }

?>
