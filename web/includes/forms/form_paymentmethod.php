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
	# * FILE: /includes/forms/form_paymentmethod.php
	# ----------------------------------------------------------------------------------------------------

    $arrayGateways = array();
    
    if (AUTHORIZEPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "authorize||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (LINKPOINTPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "linkpoint||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (ITRANSACTPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "itransact||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (WORLDPAYPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "worldpay||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (PSIGATEPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "psigate||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (TWOCHECKOUTPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "twocheckout||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (PAYFLOWPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "payflow||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (PAYPALAPIPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "paypalapi||".system_showText(LANG_LABEL_BY_CREDIT_CARD);
    }
    
    if (PAYPALPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "paypal||".system_showText(LANG_LABEL_BY_PAYPAL);
    }
    
    if (SIMPLEPAYPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "simplepay||".system_showText(LANG_LABEL_BY_SIMPLEPAY);
    }
    
    if (PAGSEGUROPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "pagseguro||".system_showText(LANG_LABEL_BY_PAGSEGURO);
    }
    
    if (INVOICEPAYMENT_FEATURE == "on") {
        $arrayGateways[] = "invoice||".system_showText(LANG_LABEL_PRINT_INVOICE_AND_MAIL_CHECK);
    }
    
    $countGat = 0;

    if (is_array($arrayGateways) && $arrayGateways[0]) {

        foreach ($arrayGateways as $gateway) {

            $gatewayInfo = explode("||", $gateway); 
            $countGat++;
            echo "<div class=\"radio\"><label><input type=\"radio\" name=\"payment_method\" value=\"".$gatewayInfo[0]."\" id=\"radio".$countGat."\" ".($payment_method == $gatewayInfo[0] ? "checked=\"checked\"" : "")." />".$gatewayInfo[1]."</label></div>";

        }
    }
?>