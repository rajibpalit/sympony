<?
    /* ==================================================================*\
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
      \*================================================================== */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /includes/code/paymentgateway.php
    # ----------------------------------------------------------------------------------------------------
    # ----------------------------------------------------------------------------------------------------
    # SUBMIT
    # ----------------------------------------------------------------------------------------------------
    extract( $_POST );
    extract( $_GET );

    $dbMain = db_getDBObject( DEFAULT_DB, true );
    $dbObj  = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbMain );

    /**
     * Loads info from the database table Setting_payment
     * @param string $name The 'name' field to be returned
     * @param mysql $dbObj
     * @return string
     */
    function getPaymentSetting( $name, $dbObj )
    {
        $variable = null;

        $query = "SELECT * FROM Setting_Payment WHERE name LIKE '$name' LIMIT 1";
		$result = $dbObj->query( $query );

        if( $row = mysql_fetch_assoc($result) )
        {
			$variable = $row["value"];
        }

        return $variable;
    }

    /**
     * Executes a query to set an entry in the Setting_Payment table.
     * @param string $name the NAME field to be changed
     * @param string $value the VALUE to be set
     * @return boolean Will return true if the query was successful.
     */
    function setPaymentSetting( $name, $value)
    {
        $dbMain = db_getDBObject( DEFAULT_DB, true );
        $dbObj  = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $dbMain );

        $query  = "INSERT INTO Setting_Payment ( name, value ) VALUES ( '$name', '$value' ) ON DUPLICATE KEY UPDATE value ='$value'";
        $return = $dbObj->query( $query );
        return $return;
    }

    /**
     * If $recurring is set, it will not validate the $unit and $value variables.
     *
     * @param string $name the NAME field in the settings table to be saved
     * @param int $value the timespan of the module subscription
     * @param string $unit the unit of the value. can be D(ay), M(month) or Y(ear)
     * @param boolean $recurring whether or not recurring is activated.
     */
    function setFrequency( $name, $value, $unit, $recurring = false )
    {
        if( !$recurring )
        {
            switch( $unit )
            {
                case "D" : $value = max( array( $value % 30, 1 )); break;
                case "M" : $value = max( array( $value % 12, 1 )); break;
                case "Y" : $value = max( array( $value % 6, 1 ));  break;
                default: MessageHandler::registerError( "Invalid Frequency" );
            }
        }

        setPaymentSetting($name, $value.$unit);
    }

    /**
     * This function converts data into an older format to allow
     * old functions to work. Yeah, we are looking at YOU, system_updateFormFields()
     * @param array $data an array containing the option's table names as keys and an array with each level associated with their values as value
     * @return array the modified array which will be fed into system_updateFormFields()
     */
    function createItemLevelArray( $data )
    {
        foreach ( $data as $key => $value )
        {
            /* On images we have a special case.
             * If the user sets zero images for a level, the level has no main image and no gallery
             * If the user sets one or more images, one image will be the main image and the rest will
             * be allocated in a gallery
             */
            if( $key == "images" )
            {
                foreach( $value as $level => &$amount )
                {
                    $amount = max( array( $amount, 0 ) );

                    if( $amount > 0 )
                    {
                        $amount--;
                        $data["itemLevel_main_image"][$level] = true;
                    }
                }
            }


            $data["itemLevel_{$key}"] = $value;
            unset( $data[$key] );
        }

        return $data;
    }

    /**
     * Treats and validates all information regarding Payment gateways and perform
     * the necessary database changes. Also makes coffee.
     * @todo This should be moved into a class of its own along with its auxiliary functions, person of the future.
     * @param mysql $dbObj
     */
    function handleGatewayPost( $dbObj )
    {
        /* Lets harvest and filter from POST our recurring options */
        $recurringOptions = $_POST['gateway']['recurring'];

        /* Cycle:
         * max : 11
         * min: 1
         * forced to integer */
        $recurringCycle = min( array( 11, (int)$recurringOptions['cycle'] ) );
        $recurringCycle = max( array( 1, $recurringCycle ) );

        /* Times:
         * min: 0
         * forced to integer */
        $recurringTimes = abs( (int)$recurringOptions['times'] );

        /* Unit:
         * can be either M (month) or Y(year)
         * defaults to M */
        $recurringOptions['unit'] = strtoupper( $recurringOptions['unit'] );
        $recurringUnit            = in_array( $recurringOptions['unit'], array( "M", "Y" ) ) ? $recurringOptions['unit'] : "M";

        $gateway_config = array();

        /* If the user is not using recurring, we'll use the default settings */
        if ( empty( $_POST['gateway']['paypal']['paypal_recurringCheckbox'] ) && empty( $_POST['gateway']['simplePay']['simplepay_recurringCheckbox'] ) && empty( $_POST['gateway']['authorize']['authorize_recurringCheckbox'] ) && empty( $_POST['gateway']['linkpoint']['linkpoint_recurringCheckbox'] ) )
        {
            setFrequency( 'LISTING_RENEWAL_PERIOD', $_POST['frequency']['listing']['value'], $_POST['frequency']['listing']['unit'] );
            setFrequency( 'EVENT_RENEWAL_PERIOD', $_POST['frequency']['event']['value'], $_POST['frequency']['event']['unit']);
            setFrequency( 'BANNER_RENEWAL_PERIOD', $_POST['frequency']['banner']['value'], $_POST['frequency']['banner']['unit'] );
            setFrequency( 'CLASSIFIED_RENEWAL_PERIOD', $_POST['frequency']['classified']['value'], $_POST['frequency']['classified']['unit'] );
            setFrequency( 'ARTICLE_RENEWAL_PERIOD', $_POST['frequency']['article']['value'], $_POST['frequency']['article']['unit'] );

            // yml file
            $gateway_config = array(
                // listing
                'listing.renewal.unit' => $_POST['frequency']['listing']['unit'],
                'listing.renewal.period' => $_POST['frequency']['listing']['value'],

                // event
                'event.renewal.unit' => $_POST['frequency']['event']['unit'],
                'event.renewal.period' => $_POST['frequency']['event']['value'],

                // banner
                'banner.renewal.unit' => $_POST['frequency']['banner']['unit'],
                'banner.renewal.period' => $_POST['frequency']['banner']['value'],

                // classified
                'classified.renewal.unit' => $_POST['frequency']['classified']['unit'],
                'classified.renewal.period' => $_POST['frequency']['classified']['value'],

                // article
                'article.renewal.unit' => $_POST['frequency']['article']['unit'],
                'article.renewal.period' => $_POST['frequency']['article']['value'],
            );
        }
        else
        {
            setFrequency( 'LISTING_RENEWAL_PERIOD', $recurringCycle, $recurringUnit, true );
            setFrequency( 'EVENT_RENEWAL_PERIOD', $recurringCycle, $recurringUnit, true );
            setFrequency( 'BANNER_RENEWAL_PERIOD', $recurringCycle, $recurringUnit, true );
            setFrequency( 'CLASSIFIED_RENEWAL_PERIOD', $recurringCycle, $recurringUnit, true );
            setFrequency( 'ARTICLE_RENEWAL_PERIOD', $recurringCycle, $recurringUnit, true );


            // yml file
            $gateway_config = array(
                // listing
                'listing.renewal.unit' => $recurringUnit,
                'listing.renewal.period' => $recurringCycle,

                // event
                'event.renewal.unit' => $recurringUnit,
                'event.renewal.period' => $recurringCycle,

                // banner
                'banner.renewal.unit' => $recurringUnit,
                'banner.renewal.period' => $recurringCycle,

                // classified
                'classified.renewal.unit' => $recurringUnit,
                'classified.renewal.period' => $recurringCycle,

                // article
                'article.renewal.unit' => $recurringUnit,
                'article.renewal.period' => $recurringCycle,
            );
        }

        foreach ( $_POST['gateway'] as $gateway => $formData )
        {
            switch ( $gateway )
            {
                case "paypal":
                    $enabled   = ( $formData['payment_paypalStatus'] == "on" ? "on" : "off" );
                    $account   = crypt_encrypt( trim( $formData['paypal_account'] ) );
                    $recurring = ( ( $enabled == "on" && $formData['paypal_recurringCheckbox'] ) == "on" ? "on" : "off" );

                    if ( $enabled == "on" && !$account )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_PAYPAL) );
                    }
                    else
                    {
                        setPaymentSetting( "PAYPAL_STATUS", $enabled );
                        setPaymentSetting( "PAYPAL_RECURRING", $recurring );
                        setPaymentSetting( "PAYPAL_ACCOUNT", $account );
                        setPaymentSetting( "PAYPAL_RECURRINGCYCLE", $recurringCycle );
                        setPaymentSetting( "PAYPAL_RECURRINGTIMES", $recurringTimes );
                        setPaymentSetting( "PAYPAL_RECURRINGUNIT", $recurringUnit );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'paypal.status' => $enabled,
                        'paypal.recurring' => $recurring,
                        'paypal.account' => $account,
                        'paypal.recurring.cycle' => $recurringCycle,
                        'paypal.recurring.times' => $recurringTimes,
                        'paypal.recurring.unit' => $recurringUnit,
                    );

                    break;
                case "paypalAPI":
                    $enabled   = ( $formData['payment_paypalapiStatus'] == "on" ? "on" : "off" );
                    $username  = crypt_encrypt( trim( $formData['paypalapi_username'] ) );
                    $password  = crypt_encrypt( trim( $formData['paypalapi_password'] ) );
                    $signature = crypt_encrypt( trim( $formData['paypalapi_signature'] ) );

                    if ( $enabled == "on" && (!$username || !$password || !$signature ) )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_PAYPALAPI) );
                    }
                    else
                    {
                        setPaymentSetting( "PAYPALAPI_STATUS", $enabled );
                        setPaymentSetting( "PAYPALAPI_USERNAME", $username );
                        setPaymentSetting( "PAYPALAPI_PASSWORD", $password );
                        setPaymentSetting( "PAYPALAPI_SIGNATURE", $signature );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'paypalapi.status' => $enabled,
                        'paypalapi.username' => $username,
                        'paypalapi.password' => $password,
                        'paypalapi.signature' => $signature,
                    );

                    break;
                case "simplePay":
                    $enabled   = ( $formData['payment_simplepayStatus'] == "on" ? "on" : "off" );
                    $accessKey = crypt_encrypt( trim( $formData['simplepay_accesskey'] ) );
                    $secretKey = crypt_encrypt( trim( $formData['simplepay_secretkey'] ) );
                    $recurring = ( ( $enabled == "on" &&  $formData['simplepay_recurringCheckbox'] == "on" ) ? "on" : "off" );

                    $unitConversion = array(
                    "M" => "month",
                    "Y" => "year"
                    );

                    if ( $enabled == "on" && (!$accessKey || !$secretKey ) )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_SIMPLEPAY) );
                    }
                    else
                    {
                        setPaymentSetting( "SIMPLEPAY_STATUS", $enabled );
                        setPaymentSetting( "SIMPLEPAY_RECURRING", $recurring );
                        setPaymentSetting( "SIMPLEPAY_ACCESSKEY", $accessKey );
                        setPaymentSetting( "SIMPLEPAY_SECRETKEY", $secretKey );
                        setPaymentSetting( "SIMPLEPAY_RECURRINGCYCLE", $recurringCycle );
                        setPaymentSetting( "SIMPLEPAY_RECURRINGTIMES", $recurringTimes );
                        setPaymentSetting( "SIMPLEPAY_RECURRINGUNIT", $unitConversion[$recurringUnit] );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'simplepay.status' => $enabled,
                        'simplepay.recurring' => $recurring,
                        'simplepay.access.key' => $accessKey,
                        'simplepay.secret.key' => $secretKey,
                        'simplepay.recurring.cycle' => $recurringCycle,
                        'simplepay.recurring.times' => $recurringTimes,
                        'simplepay.recurring.unit' => $unitConversion[$recurringUnit],
                    );

                    break;
                case "pagseguro":
                    $enabled = ( $formData['payment_pagseguroStatus'] == "on" ? "on" : "off" );
                    $email   = crypt_encrypt( trim( $formData['pagseguro_email'] ) );
                    $token   = crypt_encrypt( trim( $formData['pagseguro_token'] ) );

                    $payment_currency = getPaymentSetting( "PAYMENT_CURRENCY", $dbObj );

                    if ( $enabled == "on" && (!$email || !$token ) )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_PAGSEGURO) );
                    }
                    else if ( $enabled == "on" && $payment_currency != "BRL" )
                    {
                        MessageHandler::registerError( LANG_MSG_CURRENCY_PAGSEGURO );
                    }
                    else
                    {
                        setPaymentSetting( "PAGSEGURO_STATUS", $enabled );
                        setPaymentSetting( "PAGSEGURO_EMAIL", $email );
                        setPaymentSetting( "PAGSEGURO_TOKEN", $token );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'pagseguro.status' => $enabled,
                        'pagseguro.email' => $email,
                        'pagseguro.token' => $token,
                    );

                    break;
                case "twoCheckout":
                    $enabled = ( $formData['payment_twocheckoutStatus'] == "on" ? "on" : "off" );
                    $login   = crypt_encrypt( trim( $formData['twocheckout_login'] ) );

                    if ( $enabled == "on" && !$login )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_TWOCHECKOUT) );
                    }
                    else
                    {
                        setPaymentSetting( "TWOCHECKOUT_STATUS", $enabled );
                        setPaymentSetting( "TWOCHECKOUT_LOGIN", $login );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'twocheckout.status' => $enabled,
                        'twocheckout.login' => $login,
                    );

                    break;
                case "authorize":
                    $enabled        = ( $formData['payment_authorizeStatus'] == "on" ? "on" : "off" );
                    $login          = crypt_encrypt( trim( $formData['authorize_login'] ) );
                    $transactionKey = crypt_encrypt( trim( $formData['authorize_txnkey'] ) );
                    $recurring      = ( ( $enabled == "on" && $formData['authorize_recurringCheckbox'] == "on" ) ? "on" : "off" );
                    $length         = ( $recurringUnit == "Y" ? 12 : 1 ) * $recurringCycle;

                    if ( $enabled == "on" && (!$login || !$transactionKey ) )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_AUTHORIZE) );
                    }
                    else
                    {
                        setPaymentSetting( "AUTHORIZE_STATUS", $enabled );
                        setPaymentSetting( "AUTHORIZE_RECURRING", $recurring );
                        setPaymentSetting( "AUTHORIZE_LOGIN", $login );
                        setPaymentSetting( "AUTHORIZE_TXNKEY", $transactionKey );
                        setPaymentSetting( "AUTHORIZE_RECURRINGLENGTH", $length );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'authorize.status' => $enabled,
                        'authorize.recurring' => $recurring,
                        'authorize.login' => $login,
                        'authorize.txnkey' => $transactionKey,
                        'authorize.recurring.length' => $length,
                    );

                    break;
                case "itransact":
                    $enabled  = ( $formData['payment_itransactStatus'] == "on" ? "on" : "off" );
                    $vendorID = crypt_encrypt( trim( $formData['itransact_vendorid'] ) );

                    if ( $enabled == "on" && !$vendorID )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_ITRANSACT) );
                    }
                    else
                    {
                        setPaymentSetting( "ITRANSACT_STATUS", $enabled );
                        setPaymentSetting( "ITRANSACT_VENDORID", $vendorID );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'itransact.status' => $enabled,
                        'itransact.vendorid' => $vendorID,
                    );

                    break;
                case "linkpoint":
                    $enabled    = ( $formData['payment_linkpointStatus'] == "on" ? "on" : "off" );
                    $configFile = crypt_encrypt( trim( $formData['linkpoint_configfile'] ) );
                    $keyFile    = crypt_encrypt( trim( $formData['linkpoint_keyfile'] ) );
                    $recurring  = ( ( $enabled == "on" && $formData['linkpoint_recurringCheckbox'] ) == "on" ? "on" : "off" );

                    if ( $enabled == "on" && (!$configFile || !$keyFile ) )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_LINKPOINT) );
                    }
                    else
                    {
                        setPaymentSetting( "LINKPOINT_STATUS", $enabled );
                        setPaymentSetting( "LINKPOINT_RECURRING", $recurring );
                        setPaymentSetting( "LINKPOINT_CONFIGFILE", $configFile );
                        setPaymentSetting( "LINKPOINT_KEYFILE", $keyFile );
                        setPaymentSetting( "LINKPOINT_RECURRINGTYPE", $recurringCycle.$recurringUnit );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'linkpoint.status' => $enabled,
                        'linkpoint.recurring' => $recurring,
                        'linkpoint.config.file' => $configFile,
                        'linkpoint.key.file' => $keyFile,
                        'linkpoint.recurring.type' => $recurringCycle.$recurringUnit,
                    );

                    break;
                case "payflow":
                    $enabled = ( $formData['payment_payflowStatus'] == "on" ? "on" : "off" );
                    $login   = crypt_encrypt( trim( $formData['payflow_login'] ) );
                    $partner = crypt_encrypt( trim( $formData['payflow_partner'] ) );

                    if ( $enabled == "on" && (!$login || !$partner ) )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_PAYFLOW) );
                    }
                    else
                    {
                        setPaymentSetting( "PAYFLOW_STATUS", $enabled );
                        setPaymentSetting( "PAYFLOW_LOGIN", $login );
                        setPaymentSetting( "PAYFLOW_PARTNER", $partner );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'payflow.status' => $enabled,
                        'payflow.login' => $login,
                        'payflow.partner' => $partner,
                    );

                    break;
                case "psigate":
                    $enabled    = ( $formData['payment_psigateStatus'] == "on" ? "on" : "off" );
                    $storeID    = crypt_encrypt( trim( $formData['psigate_storeid'] ) );
                    $passPhrase = crypt_encrypt( trim( $formData['psigate_passphrase'] ) );

                    if ( $enabled == "on" && (!$storeID || !$passPhrase ) )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_PSIGATE) );
                    }
                    else
                    {
                        setPaymentSetting( "PSIGATE_STATUS", $enabled );
                        setPaymentSetting( "PSIGATE_STOREID", $storeID );
                        setPaymentSetting( "PSIGATE_PASSPHRASE", $passPhrase );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'psigate.status' => $enabled,
                        'psigate.store.id' => $storeID,
                        'psigate.passphrase' => $passPhrase,
                    );

                    break;
                case "worldpay":
                    $enabled   = ( $formData['payment_worldpayStatus'] == "on" ? "on" : "off" );
                    $installID = crypt_encrypt( trim( $formData['worldpay_instid'] ) );

                    if ( $enabled == "on" && !$installID )
                    {
                        MessageHandler::registerError( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_ERROR_WORLDPAY) );
                    }
                    else
                    {
                        setPaymentSetting( "WORLDPAY_STATUS", $enabled );
                        setPaymentSetting( "WORLDPAY_INSTID", $installID );
                    }

                    // creating array to append in gateway file
                    $gateway_config += array(
                        'worldpay.status' => $enabled,
                        'worldpay.instid' => $installID,
                    );


                    break;
            }
        }

        if ( !MessageHandler::haveErrors() )
        {
            MessageHandler::registerSuccess( system_showText( LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_SAVED ) );
        }
    }

    /**
     * Creates the config file with database saved values
     * @param type $dbObj
     */
    function createConfigFile( $dbObj )
    {
        $array_PaymentSetting = array(
            'payment_simplepayStatus'    => getPaymentSetting('SIMPLEPAY_STATUS', $dbObj),
            'payment_paypalStatus'       => getPaymentSetting('PAYPAL_STATUS', $dbObj),
            'payment_paypalapiStatus'    => getPaymentSetting('PAYPALAPI_STATUS', $dbObj),
            'payment_payflowStatus'      => getPaymentSetting('PAYFLOW_STATUS', $dbObj),
            'payment_twocheckoutStatus'  => getPaymentSetting('TWOCHECKOUT_STATUS', $dbObj),
            'payment_psigateStatus'      => getPaymentSetting('PSIGATE_STATUS', $dbObj),
            'payment_worldpayStatus'     => getPaymentSetting('WORLDPAY_STATUS', $dbObj),
            'payment_itransactStatus'    => getPaymentSetting('ITRANSACT_STATUS', $dbObj),
            'payment_linkpointStatus'    => getPaymentSetting('LINKPOINT_STATUS', $dbObj),
            'payment_authorizeStatus'    => getPaymentSetting('AUTHORIZE_STATUS', $dbObj),
            'payment_pagseguroStatus'    => getPaymentSetting('PAGSEGURO_STATUS', $dbObj),
            'payment_simplepayRecurring' => getPaymentSetting('SIMPLEPAY_RECURRING', $dbObj),
            'payment_paypalRecurring'    => getPaymentSetting('PAYPAL_RECURRING', $dbObj),
            'payment_linkpointRecurring' => getPaymentSetting('LINKPOINT_RECURRING', $dbObj),
            'payment_authorizeRecurring' => getPaymentSetting('AUTHORIZE_RECURRING', $dbObj),
            'renewal_periodListing'      => getPaymentSetting('LISTING_RENEWAL_PERIOD', $dbObj),
            'renewal_periodEvent'        => getPaymentSetting('EVENT_RENEWAL_PERIOD', $dbObj),
            'renewal_periodBanner'       => getPaymentSetting('BANNER_RENEWAL_PERIOD', $dbObj),
            'renewal_periodClassified'   => getPaymentSetting('CLASSIFIED_RENEWAL_PERIOD', $dbObj),
            'renewal_periodArticle'      => getPaymentSetting('ARTICLE_RENEWAL_PERIOD', $dbObj),
            'payment_currency'           => getPaymentSetting('PAYMENT_CURRENCY', $dbObj),
            'currency_symbol'            => getPaymentSetting('CURRENCY_SYMBOL', $dbObj),
            'invoice_payment'            => getPaymentSetting('INVOICEPAYMENT_FEATURE', $dbObj),
            'manual_payment'             => getPaymentSetting('MANUALPAYMENT_FEATURE', $dbObj)
        );

        payment_writeSettingPaymentFile( $array_PaymentSetting );
    }

    if ( $_SERVER['REQUEST_METHOD'] == "POST" && !DEMO_LIVE_MODE )
    {
        /* The action post is defined by which button the user has clicked. */
        switch ( $_POST['action'] )
        {
            case "gateways":
                handleGatewayPost( $dbObj );
                createConfigFile( $dbObj );
                break;
            case "currencyOptions":
                /* Filters data*/
                $currencySymbol  = mysql_real_escape_string( strip_tags( trim( $_POST['currency_symbol'] ) ) );
                $paymentCurrency = string_strtoupper( $_POST['payment_currency'] );

                $paymentTaxStatus = $_POST['payment_tax_status'] == "on" ? "on" : "off";
                $paymentTaxLabel  = mysql_real_escape_string( strip_tags( trim( $_POST['payment_tax_label'] ) ) );
                /* Replaces , with . and attempts to convert to a float with two decimal positions */
                $paymentTaxValue  = sprintf("%.2f", str_replace( ",", ".", $_POST['payment_tax_value'] ) );

                /* Data filtering*/
                $invoicePayment = $_POST['invoice_payment'] == "on" ? "on" : "off";
                $manualPayment  = $_POST['manual_payment']  == "on" ? "on" : "off";

                /* Error Handling */
                !$currencySymbol and MessageHandler::registerError( LANG_MSG_CURRENCY_SYMBOL_IS_REQUIRED );

                if ( !$paymentCurrency )
                {
                    MessageHandler::registerError( LANG_MSG_PAYMENT_CURRENCY_IS_REQUIRED );
                }
                else
                {
                    $filteredPaymentCurrency = preg_replace( "/[^a-zA-Z]/", "", $paymentCurrency );

                    if ( string_strlen( $filteredPaymentCurrency ) != 3 )
                    {
                        MessageHandler::registerError( LANG_MSG_PAYMENT_CURRENCY_MUST_CONTAIN_THREE_CHARS );
                    }

                    if ( $filteredPaymentCurrency != $paymentCurrency )
                    {
                        MessageHandler::registerError( LANG_MSG_PAYMENT_CURRENCY_MUST_BE_ONLY_LETTERS );
                    }

                    if ( getPaymentSetting('PAGSEGURO_STATUS', $dbObj) == "on" && $paymentCurrency != "BRL" )
                    {
                        MessageHandler::registerError( LANG_MSG_CURRENCY_PAGSEGURO );
                    }

                    $paymentCurrency = $filteredPaymentCurrency;
                }

                if ( $paymentTaxStatus == "on" )
                {
                    !$paymentTaxLabel and MessageHandler::registerError( LANG_SITEMGR_MSG_MAINLANGUAGE_REQUIRED );

                    if ( !$paymentTaxValue && $paymentTaxValue != 0 )
                    {
                        MessageHandler::registerError( LANG_SITEMGR_MSG_VALUE_REQUIRED );
                    }
                    else
                    {
                        is_numeric( $paymentTaxValue ) or MessageHandler::registerError( LANG_SITEMGR_MSG_VALUE_MUST_BE_NUMERIC );
                        $paymentTaxValue > 0 or MessageHandler::registerError( LANG_SITEMGR_MSG_MIN_VALUE );
                    }
                }

                if ( !MessageHandler::haveErrors() )
                {
                    /* Sets if exists, creates if doesn't */
                    ( setting_get( "payment_tax_status", $unused )   and setting_set( "payment_tax_status", $payment_tax_status ) )  or setting_new( "payment_tax_status", $payment_tax_status );
                    ( setting_get( "payment_tax_value", $unused )    and setting_set( "payment_tax_value", $payment_tax_value )   )  or setting_new( "payment_tax_value", $payment_tax_value );
                    ( customtext_get( "payment_tax_label", $unused ) and customtext_set( "payment_tax_label", $payment_tax_label ) ) or customtext_new( "payment_tax_label", $payment_tax_label );

                    setPaymentSetting('CURRENCY_SYMBOL', $currencySymbol );
                    setPaymentSetting('PAYMENT_CURRENCY', $filteredPaymentCurrency );
                    setPaymentSetting('INVOICEPAYMENT_FEATURE', $invoicePayment );
                    setPaymentSetting('MANUALPAYMENT_FEATURE', $manualPayment );

                    MessageHandler::registerSuccess( system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_CURRENCY_SAVED) );
                }

                createConfigFile( $dbObj );
                break;
            case "levels":
                foreach ( $_POST['level'] as $type => $data )
                {
                    switch( $type )
                    {
                        case "listing" :
                            $levelObj    = new ListingLevel( true );
                            $levelsArray = $levelObj->getLevelValues();
                            $levelOptionData = $_POST['levelOption']['listing'];

                            //We have no deals unless proven otherwise by the following foreach
                            $hasPromotionCheck = false;

                            foreach ( $levelsArray as $levelValue )
                            {
                                /* Data filtering*/
                                $name         = string_strtolower( mysql_real_escape_string( $data['name'][$levelValue] ) );
                                $active       = ( empty( $data['active'][$levelValue] ) ? "n" : "y" );
                                $popular      = ( $data['popular'] == $levelValue ? "y" : "n" );
                                $featured     = ( empty( $data['featured'][$levelValue] ) ? "n" : "y" );

                                if( empty( $levelOptionData['has_promotion'][$levelValue] ) )
                                {
                                    $hasPromotion = "n";
                                }
                                else
                                {
                                    $hasPromotion = "y";
                                    $hasPromotionCheck = true;
                                }

                                $hasReview    = ( empty( $levelOptionData['has_review'][$levelValue] ) ? "n" : "y" );
                                $hasSMS       = ( empty( $levelOptionData['has_sms'][$levelValue] )    ? "n" : "y" );
                                $hasCall      = ( empty( $levelOptionData['has_call'][$levelValue] )   ? "n" : "y" );
                                $backlink     = ( empty( $levelOptionData['backlink'][$levelValue] )   ? "n" : "y" );
                                $detail       = ( empty( $levelOptionData['detail'][$levelValue] )     ? "n" : "y" );
                                $images       = ( empty( $levelOptionData['images'][$levelValue] ) ? 0 : (int)$levelOptionData['images'][$levelValue] );

                                /*Saving to DB*/
                                $levelObj->updateValues( $name, $active, "", "", "", "", "", "", "", $levelValue, "names", $popular );
                                $levelObj->updateValues( "", "", $hasPromotion, $hasReview, $hasSMS, $hasCall, $backlink, $detail, $images, $levelValue, "fields", "" );
                                $levelObj->updatePricing( 'price', ( empty( $data['price'][$levelValue] ) ? 0 : (float)$data['price'][$levelValue] ), $levelValue);
                                $levelObj->updatePricing( 'category_price', ( empty( $data['category_price'][$levelValue] ) ? 0 : (float)$data['category_price'][$levelValue] ), $levelValue);
                                $levelObj->updatePricing( 'free_category', ( empty( $data['free_category'][$levelValue] ) ? 0 : (int)$data['free_category'][$levelValue] ), $levelValue);
                                $levelObj->updateFeatured($featured, $levelValue);
                            }

                            // this mimics old form post structure for old functions to work.
                            $createItemLevelArray = createItemLevelArray( $levelOptionData );

                            //Updates values for table ListingLevel_Field
                            system_updateFormFields( $createItemLevelArray, "Listing" );

                            //Updates promotion setting
                            if ( $hasPromotionCheck )
                            {
                                setting_set( "custom_has_promotion", "on" ) or setting_new( "custom_has_promotion", "on" ) or MessageHandler::registerError( LANG_SITEMGR_SETTINGS_LEVELS_ERROR );
                            }
                            else
                            {
                                setting_set( "custom_has_promotion", "" ) or setting_new( "custom_has_promotion", "" ) or MessageHandler::registerError( LANG_SITEMGR_SETTINGS_LEVELS_ERROR );
                            }
                            break;
                        case "event" :
                            $levelObj    = new EventLevel( true );
                            $levelsArray = $levelObj->getLevelValues();
                            $levelOptionData = $_POST['levelOption']['event'];

                            foreach ( $levelsArray as $levelValue )
                            {
                                /* Data filtering*/
                                $name         = string_strtolower( mysql_real_escape_string( $data['name'][$levelValue] ) );
                                $active       = ( empty( $data['active'][$levelValue] ) ? "n" : "y" );
                                $popular      = ( $data['popular'] == $levelValue ? "y" : "n" );
                                $featured     = ( empty( $data['featured'][$levelValue] ) ? "n" : "y" );

                                $detail       = ( empty( $levelOptionData['detail'][$levelValue] )     ? "n" : "y" );
                                $images       = ( empty( $levelOptionData['images'][$levelValue] ) ? 0 : (int)$levelOptionData['images'][$levelValue] );

                                /*Saving*/
                                $levelObj->updateValues( $name, $active, "", "", $levelValue, "names", $popular );
                                $levelObj->updateValues( "", "", $detail, $images, $levelValue, "fields" );
                                $levelObj->updatePricing( 'price', ( empty( $data['price'][$levelValue] ) ? 0 : (float)$data['price'][$levelValue] ), $levelValue);
                                $levelObj->updateFeatured($featured, $levelValue);
                            }

                            if ( isset( $levelOptionData['start_time']) )
                            {
                                $levelOptionData['time'] = $levelOptionData['start_time'];
                                unset( $levelOptionData['start_time'] );
                            }

                            // this mimics old form post structure for old functions to work.
                            $createItemLevelArray = createItemLevelArray( $levelOptionData );

                            //Updates values for table ListingLevel_Field
                            system_updateFormFields( $createItemLevelArray, "Event" );

                            break;
                        case "banner" :
                            $levelObj    = new BannerLevel( true );
                            $levelsArray = $levelObj->getLevelValues();
                            $levelOptionData = $_POST['levelOption']['banner'];

                            foreach ( $levelsArray as $levelValue )
                            {
                                $name         = string_strtolower( mysql_real_escape_string( $data['name'][$levelValue] ) );
                                $active       = ( empty( $data['active'][$levelValue] ) ? "n" : "y" );
                                $popular      = ( $data['popular'] == $levelValue ? "y" : "n" );

                                $blockImpressions = (int)$data['block_impressions'][$levelValue];
                                $levelObj->updatePricing( 'impression_block', $blockImpressions, $levelValue );
                                $blockPrice       = (float)str_replace( ',', '.', $data['block_price'][$levelValue] );
                                $levelObj->updatePricing( 'impression_price', $blockPrice, $levelValue );

                                $levelObj->updateValues( $name, $active, $levelValue, $popular );
                                $levelObj->updatePricing( 'price', ( empty( $data['price'][$levelValue] ) ? 0 : (float)$data['price'][$levelValue] ), $levelValue);
                            }

                            break;
                        case "classified" :
                            $levelObj    = new ClassifiedLevel( true );
                            $levelsArray = $levelObj->getLevelValues();
                            $levelOptionData = $_POST['levelOption']['classified'];

                            foreach ( $levelsArray as $levelValue )
                            {
                                $name         = string_strtolower( mysql_real_escape_string( $data['name'][$levelValue] ) );
                                $active       = ( empty( $data['active'][$levelValue] ) ? "n" : "y" );
                                $popular      = ( $data['popular'] == $levelValue ? "y" : "n" );
                                $featured     = ( empty( $data['featured'][$levelValue] ) ? "n" : "y" );

                                $detail       = ( empty( $levelOptionData['detail'][$levelValue] )     ? "n" : "y" );
                                $images       = ( empty( $levelOptionData['images'][$levelValue] ) ? 0 : (int)$levelOptionData['images'][$levelValue] );

                                $levelObj->updateValues( $name, $active, "", "", $levelValue, "names", $popular );
                                $levelObj->updateValues( "", "", $detail, $images, $levelValue, "fields" );
                                $levelObj->updatePricing( 'price', ( empty( $data['price'][$levelValue] ) ? 0 : (float)$data['price'][$levelValue] ), $levelValue);
                                $levelObj->updateFeatured($featured, $levelValue);
                            }

                            // this mimics old form post structure for old functions to work.
                            $createItemLevelArray = createItemLevelArray( $levelOptionData );

                            //Updates values for table ListingLevel_Field
                            system_updateFormFields( $createItemLevelArray, "Classified" );

                            break;
                        case "article" :
                            $levelObj        = new ArticleLevel( true );
                            $levelsArray     = $levelObj->getLevelValues();
                            $levelOptionData = $_POST['levelOption']['article'];

                            foreach ( $levelsArray as $levelValue )
                            {
                                $name         = string_strtolower( mysql_real_escape_string( $data['name'][$levelValue] ) );
                                $active       = ( empty( $data['active'][$levelValue] ) ? "n" : "y" );

                                $levelObj->updateValues( $name, $active, "", $levelValue );
                                $levelObj->updatePricing( 'price', ( empty( $data['price'][$levelValue] ) ? 0 : (float)$data['price'][$levelValue] ), $levelValue);
                            }

                            break;
                    }
                }

                MessageHandler::haveErrors() or MessageHandler::registerSuccess( LANG_SITEMGR_SETTINGS_PAYMENTS_LEVELS_SAVED );
                break;
        }

        $_SESSION['PaymentOptions']['type'] = $_POST['action'];

        if( MessageHandler::haveErrors() )
        {
            /* Loads post information into the forms */
            $frequency          = $_POST['frequency'];
            $currency_symbol    = $_POST['currency_symbol'];
            $payment_currency   = $_POST['payment_currency'];
            $payment_tax_status = $_POST['payment_tax_status'];
            $payment_tax_value  = $_POST['payment_tax_value'];
            $payment_tax_label  = $_POST['payment_tax_label'];
            $invoice_payment    = $_POST['invoice_payment'];
            $manual_payment     = $_POST['manual_payment'];
            $gatewayInfo        = $_POST['gateway'];
        }
        else
        {
            /* Since we use the header to reload the page (to clear post data)
             * we need to save the messages in the session for them not to be lost
             * this is basically what this function does */
            MessageHandler::serialize();

            /* This is used on the next page to set which tab will be displayed */
            header("Location: http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
            exit;
        }
    }
    else
    {
        /* Down here we prepare the "default" data which will be shown for each pane
         * These are the user's current settings, in other words. */

        /* Item Renewal Period Defaults */
        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE '%_RENEWAL_PERIOD'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            $fetchedType = strtolower( str_replace( "_RENEWAL_PERIOD", "", $row["name"] ) );

            $frequency[$fetchedType]['value'] = ( preg_match( "/\d+/", $row["value"], $matches ) ? array_pop( $matches ) : "1" );
            $frequency[$fetchedType]['unit']  = strtoupper( preg_match( "/[A-Za-z]/", $row["value"], $matches ) ? array_pop( $matches ) : "D"  );
        }

        /* Currency Defaults */
        $currency_symbol  = getPaymentSetting( "CURRENCY_SYMBOL", $dbObj );
        $payment_currency = getPaymentSetting( "PAYMENT_CURRENCY", $dbObj );

        /* Tax Defaults */

        setting_get( "payment_tax_status", $payment_tax_status );
        setting_get( "payment_tax_value", $payment_tax_value );
        customtext_get( "payment_tax_label", $payment_tax_label );

        /* Invoice Defaults */
        $invoice_payment = getPaymentSetting( "INVOICEPAYMENT_FEATURE", $dbObj );
        $manual_payment  = getPaymentSetting( "MANUALPAYMENT_FEATURE", $dbObj );

        /* Payment Gateways Defaults */
        /* Let's make sure it's empty */
        $gatewayInfo = null;

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'SIMPLEPAY_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "SIMPLEPAY_ACCESSKEY"      : $gatewayInfo['simplePay']['simplepay_accesskey']         = crypt_decrypt( $row["value"] ); break;
                case "SIMPLEPAY_SECRETKEY"      : $gatewayInfo['simplePay']['simplepay_secretkey']         = crypt_decrypt( $row["value"] ); break;
                case "SIMPLEPAY_STATUS"         : $gatewayInfo['simplePay']['payment_simplepayStatus']     = $row["value"]; break;
                case "SIMPLEPAY_RECURRING"      : $gatewayInfo['simplePay']['simplepay_recurringCheckbox'] = $row["value"]; break;
                case "SIMPLEPAY_RECURRINGCYCLE" : $gatewayInfo['simplePay']['simplepay_recurringcycle']    = $row["value"]; break;
                case "SIMPLEPAY_RECURRINGTIMES" : $gatewayInfo['simplePay']['simplepay_recurringtimes']    = $row["value"]; break;
                case "SIMPLEPAY_RECURRINGUNIT"  : $gatewayInfo['simplePay']['simplepay_recurringunit']     = $row["value"]; break;
            }
        }

        /* Paypal */
        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'PAYPAL_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "PAYPAL_ACCOUNT"        : $gatewayInfo['paypal']['paypal_account']           = crypt_decrypt( $row["value"] ); break;
                case "PAYPAL_STATUS"         : $gatewayInfo['paypal']['payment_paypalStatus']     = $row["value"]; break;
                case "PAYPAL_RECURRING"      : $gatewayInfo['paypal']['paypal_recurringCheckbox'] = $row["value"]; break;
                case "PAYPAL_RECURRINGCYCLE" : $gatewayInfo['paypal']['paypal_recurringcycle']    = $row["value"]; break;
                case "PAYPAL_RECURRINGTIMES" : $gatewayInfo['paypal']['paypal_recurringtimes']    = $row["value"]; break;
                case "PAYPAL_RECURRINGUNIT"  : $gatewayInfo['paypal']['paypal_recurringunit']     = $row["value"]; break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'PAYPALAPI_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "PAYPALAPI_STATUS"    : $gatewayInfo['paypalAPI']['payment_paypalapiStatus'] = $row["value"]; break;
                case "PAYPALAPI_USERNAME"  : $gatewayInfo['paypalAPI']['paypalapi_username']      = crypt_decrypt( $row["value"] ); break;
                case "PAYPALAPI_PASSWORD"  : $gatewayInfo['paypalAPI']['paypalapi_password']      = crypt_decrypt( $row["value"] ); break;
                case "PAYPALAPI_SIGNATURE" : $gatewayInfo['paypalAPI']['paypalapi_signature']     = crypt_decrypt( $row["value"] ); break;
            }

        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'PAYFLOW_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "PAYFLOW_STATUS"  : $gatewayInfo['payflow']['payment_payflowStatus'] = $row["value"]; break;
                case "PAYFLOW_LOGIN"   : $gatewayInfo['payflow']['payflow_login']         = crypt_decrypt( $row["value"] ); break;
                case "PAYFLOW_PARTNER" : $gatewayInfo['payflow']['payflow_partner']       = crypt_decrypt( $row["value"] ); break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'TWOCHECKOUT_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "TWOCHECKOUT_STATUS" : $gatewayInfo['twoCheckout']['payment_twocheckoutStatus'] = $row["value"]; break;
                case "TWOCHECKOUT_LOGIN"  : $gatewayInfo['twoCheckout']['twocheckout_login']         = crypt_decrypt( $row["value"] ); break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'PSIGATE_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "PSIGATE_STATUS"     : $gatewayInfo['psigate']['payment_psigateStatus'] = $row["value"]; break;
                case "PSIGATE_STOREID"    : $gatewayInfo['psigate']['psigate_storeid']       = crypt_decrypt( $row["value"] ); break;
                case "PSIGATE_PASSPHRASE" : $gatewayInfo['psigate']['psigate_passphrase']    = crypt_decrypt( $row["value"] ); break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'WORLDPAY_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "WORLDPAY_STATUS" : $gatewayInfo['worldpay']['payment_worldpayStatus'] = $row["value"]; break;
                case "WORLDPAY_INSTID" : $gatewayInfo['worldpay']['worldpay_instid']        = crypt_decrypt( $row["value"] ); break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'ITRANSACT_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "ITRANSACT_STATUS"   : $gatewayInfo['itransact']['payment_itransactStatus'] = $row["value"]; break;
                case "ITRANSACT_VENDORID" : $gatewayInfo['itransact']['itransact_vendorid']      = crypt_decrypt( $row["value"] ); break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'LINKPOINT_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "LINKPOINT_CONFIGFILE"    : $gatewayInfo['linkpoint']['linkpoint_configfile']        = crypt_decrypt( $row["value"] ); break;
                case "LINKPOINT_KEYFILE"       : $gatewayInfo['linkpoint']['linkpoint_keyfile']           = crypt_decrypt( $row["value"] ); break;
                case "LINKPOINT_STATUS"        : $gatewayInfo['linkpoint']['payment_linkpointStatus']     = $row["value"]; break;
                case "LINKPOINT_RECURRING"     : $gatewayInfo['linkpoint']['linkpoint_recurringCheckbox'] = $row["value"]; break;
                case "LINKPOINT_RECURRINGTYPE" : $gatewayInfo['linkpoint']['linkpoint_recurringtype']     = $row["value"]; break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'AUTHORIZE_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "AUTHORIZE_LOGIN"           : $gatewayInfo['authorize']['authorize_login'] = crypt_decrypt( $row["value"] ); break;
                case "AUTHORIZE_TXNKEY"          : $gatewayInfo['authorize']['authorize_txnkey'] = crypt_decrypt( $row["value"] ); break;
                case "AUTHORIZE_STATUS"          : $gatewayInfo['authorize']['payment_authorizeStatus'] = $row["value"]; break;
                case "AUTHORIZE_RECURRING"       : $gatewayInfo['authorize']['authorize_recurringCheckbox'] = $row["value"]; break;
                case "AUTHORIZE_RECURRINGLENGTH" : $gatewayInfo['authorize']['authorize_recurringlength'] = $row["value"]; break;
            }
        }

        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'PAGSEGURO_%'";
        $result = $dbObj->query( $sql );

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "PAGSEGURO_EMAIL"  : $gatewayInfo['pagseguro']['pagseguro_email']         = crypt_decrypt( $row["value"] ); break;
                case "PAGSEGURO_TOKEN"  : $gatewayInfo['pagseguro']['pagseguro_token']         = crypt_decrypt( $row["value"] ); break;
                case "PAGSEGURO_STATUS" : $gatewayInfo['pagseguro']['payment_pagseguroStatus'] = $row["value"]; break;
            }
        }



        /* Fetching (or attempting to) new Recurring information */
        $sql    = "SELECT * FROM Setting_Payment WHERE name LIKE 'RECURRING_%'";
        $result = $dbObj->query( $sql );

        /* This is set to null so that if it isn't changed in the following while, it will still be defined
         * for the following part to work without throwing warnings */
        $gatewayInfo['recurring']['cycle'] = null;
        $gatewayInfo['recurring']['times'] = null;
        $gatewayInfo['recurring']['unit']  = null;

        while ( $row = mysql_fetch_assoc( $result ) )
        {
            switch ( $row["name"] )
            {
                case "RECURRING_CYCLE" : $gatewayInfo['recurring']['cycle'] = $row["value"]; break;
                case "RECURRING_TIMES" : $gatewayInfo['recurring']['times'] = $row["value"]; break;
                case "RECURRING_UNIT"  : $gatewayInfo['recurring']['unit']  = $row["value"]; break;
            }
        }

        /* It's not in the DB, which means this user has not changed settings since the last version */
        $gatewayInfo['recurring']['cycle']
        /* Let's try to get it from the current settings */
        or $gatewayInfo['recurring']['cycle'] = trim( $gatewayInfo['paypal']['paypal_recurringcycle'] )
        or $gatewayInfo['recurring']['cycle'] = trim( $gatewayInfo['simplePay']['simplepay_recurringcycle'] )
        /* This means he probably wasn't using recurring payments. Let's set a default */
        or $gatewayInfo['recurring']['cycle'] = 1;

        /* same thing applies here for times */
        $gatewayInfo['recurring']['times']
        or $gatewayInfo['recurring']['times'] = trim( $gatewayInfo['paypal']['paypal_recurringtimes'] )
        or $gatewayInfo['recurring']['times'] = trim( $gatewayInfo['simplePay']['simplepay_recurringtimes'] )
        or $gatewayInfo['recurring']['times'] = 0;

        /* and here for the time unit */
        $gatewayInfo['recurring']['unit']
        or $gatewayInfo['recurring']['unit'] = trim( $gatewayInfo['paypal']['paypal_recurringunit'] )
        or $gatewayInfo['recurring']['unit'] = trim( $gatewayInfo['simplePay']['simplepay_recurringunit'] )
        or $gatewayInfo['recurring']['unit'] = "M";
    }

    /* Available Modules */
    /* Each module's defaults are loaded separatedly inside includes/forms/form-payment-pricing.php */
    $availableModules["event"]      = array(
        "active" => (EVENT_FEATURE == "on"),
        "name"   => system_showText( LANG_SITEMGR_NAVBAR_EVENT ),
    );
    $availableModules["banner"]     = array(
        "active" => (BANNER_FEATURE == "on"),
        "name"   => system_showText( LANG_SITEMGR_NAVBAR_BANNER ),
    );
    $availableModules["classified"] = array(
        "active" => (CLASSIFIED_FEATURE == "on"),
        "name"   => system_showText( LANG_SITEMGR_NAVBAR_CLASSIFIED ),
    );
    $availableModules["article"]    = array(
        "active" => (ARTICLE_FEATURE == "on"),
        "name"   => system_showText( LANG_SITEMGR_NAVBAR_ARTICLE ),
    );

    $recurring = ( $gatewayInfo['paypal']['paypal_recurringCheckbox'] == "on" || $gatewayInfo['simplePay']['simplepay_recurringCheckbox'] == "on" || $gatewayInfo['authorize']['authorize_recurringCheckbox'] == "on" || $gatewayInfo['linkpoint']['linkpoint_recurringCheckbox'] == "on" );
