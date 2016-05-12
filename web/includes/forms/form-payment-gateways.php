<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */
?>
<div class="col-sm-12">

    <?php
        if( checkActiveTab( "gateways" ) )
        {
            MessageHandler::render();
        }

        /* This javascript will modify the sub options of a select deppending on what the user has chosen.
         * I.e chosing Days will change the value subselect options to span from 1 to 30 */
        $onReadyJS = '
            $(".frequencyselect").change( function() {

                var type = $(this).data("type");
                var i;
                var newOptions = "";

                console.log( type, i, newOptions );
                switch( $(this).val() )
                {
                    case "D" :
                        for( i = 1; i <= 29; i++ )
                        {
                            newOptions += "<option value=\""+i+"\">"+i+"</option>";
                        }
                        break;
                    case "M" :
                        for( i = 1; i <= 11; i++ )
                        {
                            newOptions += "<option value=\""+i+"\">"+i+"</option>";
                        }
                        break;
                    case "Y" :
                        for( i = 1; i <= 5; i++ )
                        {
                            newOptions += "<option value=\""+i+"\">"+i+"</option>";
                        }
                        break;
                }

                $("#"+type+"SubSelect").html( newOptions );
            });


            $(".recurringAction").change( checkRecurring );
            $(".hiddenPaneRevealer").change( function(){
                enableGateway( $(this).data("hiddenpanel"), this );
            });
               ';
        JavaScriptHandler::registerOnReady($onReadyJS);

        /* This javascript function toggles submenu visibility for each gateway */
        $looseJS = '

        function checkRecurring()
        {
            var isrecurring = false;
            var wasrecurring = $("#recurringSettings").is(":visible");

            $( ".recurringAction" ).each(function() {
                if( $(this).prop("checked") == true ){
                    isrecurring = true;
                    return false;
                }
            });

            if( isrecurring && !wasrecurring ){
                $("#frequencySettings").fadeOut( "fast", function(){
                    $("#recurringSettings").fadeIn();
                    scrollPage("#recurringSettings");
                } );
            }
            else if( !isrecurring && wasrecurring )
            {
                $("#recurringSettings").fadeOut( "fast", function(){
                    $("#frequencySettings").fadeIn();
                    scrollPage("#frequencySettings");
                } );
            }
        }

        function enableGateway(gtw, obj){
            var wrapper = null;
            switch(gtw) {
                case "paypal"             : wrapper = $("#wrap-paypal"); break;
                case "paypalapi"          : wrapper = $("#wrap-paypalapi"); break;
                case "simplepay"          : wrapper = $("#wrap-simplepay"); break;
                case "pagseguro"          : wrapper = $("#wrap-pagseguro"); break;
                case "twocheckout"        : wrapper = $("#wrap-twocheckout"); break;
                case "authorize"          : wrapper = $("#wrap-authorize"); break;
                case "itransaction"       : wrapper = $("#wrap-itransaction"); break;
                case "linkpoint"          : wrapper = $("#wrap-linkpoint"); break;
                case "payflow"            : wrapper = $("#wrap-payflow"); break;
                case "psigate"            : wrapper = $("#wrap-psigate"); break;
                case "worldpay"           : wrapper = $("#wrap-worldpay"); break;
            }

            if (obj.checked ) {
                wrapper.removeClass("hidden");
            } else {
                wrapper.addClass("hidden");
            }
        };
            ';
        JavaScriptHandler::registerLoose($looseJS);

        /**
         * This function prints options ranging from $i = 1 to the
         * maximum value defined for the specified frequency unit.
         * Will also mark the option when $i == $selectValue
         *
         * @param array $frequency
         * @param int $selectValue
         */
        function renderFrequencyOptions( $frequency, $selectValue )
        {
            switch( $frequency )
            {
                case "D" : $max = 29; break;
                case "M" : $max = 11; break;
                case "Y" : $max = 5; break;
            }

            for( $i = 1; $i <= $max; $i++ )
            {
                $selected = ( $selectValue == $i ? 'selected="selected"' : '' );
                echo "<option value=\"{$i}\" {$selected}>{$i}</option>\n";
            }
        }

        /**
         * Renders an row for the selection of a payment frequency for
         * one of the modules.
         *
         * The row contains a select field where the user can select from Day, Month or Year
         * and doing so will change a second select, which contains the values related to
         * the first choice. I.e. If the user selects Month the second input will range
         * from 1 to 12.
         *
         * @param string $name The post name of the module
         * @param array $frequency an array containing the unit and the value loaded from the database to select a default option.
         */
        function renderFrequencyInput( $name, $frequency )
        {
            $label = strtoupper($name);
            ?>
            <div class="row">
				<div class="form-group col-sm-4">
                    <label for="listingSubSelect"><?=constant( "LANG_SITEMGR_{$label}_SING" )?></label>
				</div>
				<div class="form-group col-sm-4">
                    <select class="form-control frequencyselect" data-type="<?=$name?>" name="frequency[<?=$name?>][unit]">
                        <option value="D" <?= $frequency['unit'] == "D" ? 'selected="selected"' : "" ?>><?=system_showText(LANG_SITEMGR_DAY)?></option>
                        <option value="M" <?= $frequency['unit'] == "M" ? 'selected="selected"' : "" ?>><?=system_showText(LANG_SITEMGR_REPORT_LABEL_MONTH)?></option>
                        <option value="Y" <?= $frequency['unit'] == "Y" ? 'selected="selected"' : "" ?>><?=system_showText(LANG_SITEMGR_REPORT_LABEL_YEAR)?></option>
                    </select>
				</div>
				<div class="form-group col-sm-4">
                    <select class="form-control frequencyunitselect" id="<?=$name?>SubSelect" name="frequency[<?=$name?>][value]">
                        <?php
                            renderFrequencyOptions($frequency['unit'], $frequency['value']);
                        ?>
                    </select>
				</div>
			</div>
            <?
        }
    ?>

	<div class="panel panel-default" id='frequencySettings' <?= ( $recurring ? "style='display: none;'" : "" ) ?>>
		<div class="panel-heading"><?=system_showText(LANG_SITEMGR_ITEM_RENEWAL_PERIOD)?></div>
		<div class="panel-body">
            <?php
                /* The $frequency array is defined in includes/code/paymentgateway.php
                 * It is loaded from the database to contain the module's default values
                 *
                 * Structure:
                 * $frequency = array(
                 *     "listing" => array(
                 *          "unit"  => ('D'|'M'|'Y'),
                 *          "value" => (int),
                 *      ),
                 *      ...
                 * )
                 */
                foreach ( $frequency as $name => $frequencies )
                {
                    renderFrequencyInput( $name, $frequencies );
                }
            ?>
		</div>
		<div class="panel-footer">
            <button class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" type="submit" name="action" value="gateways"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
		</div>
	</div>
    
	<div class="panel panel-default" id='recurringSettings' <?= ( !$recurring ? "style='display: none;'" : "" ) ?>>
		<div class="panel-heading"><?=system_showText(LANG_SITEMGR_SETTINGS_RECURRING)?></div>
		<div class="panel-body">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label><?=system_showText(LANG_SITEMGR_RECURRING_UNIT)?></label>
                    <div class="clearfix form-horizontal">
                        <div class="radio-inline">
                            <label for="recurringUnitM">
                                <input id='recurringUnitM' type="radio" name="gateway[recurring][unit]" value="M" <?= ($gatewayInfo['recurring']['unit'] == "M" ? 'checked="checked"' : "" )?>>
                                <?=system_showText(LANG_SITEMGR_REPORT_LABEL_MONTH)?>
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label for="recurringUnitY">
                                <input id='recurringUnitY' type="radio" name="gateway[recurring][unit]" value="Y" <?= ($gatewayInfo['recurring']['unit'] == "Y" ? 'checked="checked"' : "" )?>>
                                <?=system_showText(LANG_SITEMGR_REPORT_LABEL_YEAR)?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="cycle"><?=system_showText(LANG_SITEMGR_RECURRING_CYCLE)?></label> <i class="form-tip icon-help10" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_CYCLE_TIP);?>"></i>
                    <input id='cycle' class="form-control" type="number" min="1" max="11" name="gateway[recurring][cycle]"  value="<?= $gatewayInfo['recurring']['cycle'] ?>">
                </div>
                <div class="form-group col-sm-2">
                    <label for="times"><?=system_showText(LANG_SITEMGR_RECURRING_TIMES)?></label> <i class="form-tip icon-help10" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_TIMES_TIP);?>"></i>
                    <input id='times' class="form-control" type="number" min="0" name="gateway[recurring][times]" value="<?= $gatewayInfo['recurring']['times'] ?>">
                </div>
			</div>
		</div>
		<div class="panel-footer">
            <button class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" type="submit" name="action" value="gateways"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENTS_GATEWAY_HEADING);?></div>
		<div class="panel-body">

			<?// ------------ Paypal Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='paypalCheckbox'>
							<br>
							<input id='paypalCheckbox' type="checkbox" name="gateway[paypal][payment_paypalStatus]" data-hiddenpanel="paypal"  class="hiddenPaneRevealer" <?= ($gatewayInfo['paypal']['payment_paypalStatus'] == "on" ? 'checked="checked"' : "" )?>>
                            <?=system_showText(LANG_SITEMGR_ENABLE);?> Paypal
							<i class="icon-ion-ios7-checkmark-outline icon-middle form-tip text-primary <?= ($gatewayInfo['paypal']['payment_paypalStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
						
					</div>
				</div>
				<div id="wrap-paypal" class="<?= ($gatewayInfo['paypal']['payment_paypalStatus'] == "on" ? '' : "hidden" )?>">
					<div class="form-group col-sm-3">
						<label for="paypalAccount"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_ACCOUNT)?></label>
						<input id="paypalAccount" type="text" class="form-control"  name="gateway[paypal][paypal_account]" value="<?= $gatewayInfo['paypal']['paypal_account'] ?>" />
					</div>
                    <div class="form-group col-sm-offset-2 col-sm-2">
                        <div class="checkbox">
                            <label for="paypalRecurring">
                                <br>
                                <input id='paypalRecurring' class='recurringAction' type="checkbox" name="gateway[paypal][paypal_recurringCheckbox]" <?= ($gatewayInfo['paypal']['paypal_recurringCheckbox'] == "on" ? 'checked="checked"' : "" )?>>
                                <?=system_showText(LANG_SITEMGR_SETTINGS_RECURRING)?>
                            </label>
                        </div>
                    </div>
				</div>
			</div>

			<hr class="small">

			<?// ------------ SimplePay Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='simplePayCheckbox'>
							<br>
							<input id='simplePayCheckbox' type="checkbox" data-hiddenpanel="simplepay"  class="hiddenPaneRevealer" name="gateway[simplePay][payment_simplepayStatus]" <?= ($gatewayInfo['simplePay']['payment_simplepayStatus'] == "on" ? 'checked="checked"' : "" )?> >
							<?=system_showText(LANG_SITEMGR_ENABLE);?> Simplepay
							<i class="icon-ion-ios7-checkmark-outline icon-middle form-tip text-primary <?= ($gatewayInfo['simplePay']['payment_simplepayStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>

					</div>
				</div>
				<div id="wrap-simplepay" class="<?= ($gatewayInfo['simplePay']['payment_simplepayStatus'] == "on" ? '' : "hidden" )?>">
					<div class="form-group col-sm-3">
						<label for="simplePayAcessKey"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_ACCESSKEY)?></label>
						<input id='simplePayAcessKey' type="text" class="form-control"  name="gateway[simplePay][simplepay_accesskey]"  value="<?= $gatewayInfo['simplePay']['simplepay_accesskey'] ?>" />
					</div>
					<div class="form-group col-sm-2">
						<label for="simplePaySecretKey"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_SECRETKEY)?></label>
						<input id='simplePaySecretKey' type="text" class="form-control"  name="gateway[simplePay][simplepay_secretkey]"  value="<?= $gatewayInfo['simplePay']['simplepay_secretkey'] ?>" />
					</div>
                    <div class="form-group col-sm-2">
                        <div class="checkbox">
                            <label for='simplePayRecurring'>
                                <br>
                                <input id="simplePayRecurring" class='recurringAction' type="checkbox" name="gateway[simplePay][simplepay_recurringCheckbox]" <?= ($gatewayInfo['simplePay']['simplepay_recurringCheckbox'] == "on" ? 'checked="checked"' : "" )?> >
                                <?=system_showText(LANG_SITEMGR_SETTINGS_RECURRING)?>
                            </label>
                        </div>
                    </div>
				</div>
			</div>

			<hr class="small">

			<?// ------------ Authorize.Net Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='authorizeCheckbox'>
							<br>
							<input id='authorizeCheckbox' type="checkbox" data-hiddenpanel="authorize"  class="hiddenPaneRevealer" name="gateway[authorize][payment_authorizeStatus]" <?= ($gatewayInfo['authorize']['payment_authorizeStatus'] == "on" ? 'checked="checked"' : "" )?>>
							<?=system_showText(LANG_SITEMGR_ENABLE);?> Authorize.Net
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['authorize']['payment_authorizeStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>

					</div>
				</div>
				<div id="wrap-authorize" class="<?= ($gatewayInfo['authorize']['payment_authorizeStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="authorizeLogin"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_LOGIN)?></label>
                        <input id='authorizeLogin' class="form-control" type="text"  name="gateway[authorize][authorize_login]" value="<?= $gatewayInfo['authorize']['authorize_login'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="authorizeKey"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_TRANSACTIONKEY)?></label>
                        <input id='authorizeKey' class="form-control" type="text"  name="gateway[authorize][authorize_txnkey]" value="<?= $gatewayInfo['authorize']['authorize_txnkey'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="checkbox">
                            <label for='authorizeRecurring'>
                                <br>
                                <input id='authorizeRecurring' class='recurringAction' type="checkbox" name="gateway[authorize][authorize_recurringCheckbox]" <?= ($gatewayInfo['authorize']['authorize_recurringCheckbox'] == "on" ? 'checked="checked"' : "" )?>>
                                <?=system_showText(LANG_SITEMGR_SETTINGS_RECURRING)?>
                            </label>
                        </div>
                    </div>
				</div><!-- wrapper-->
			</div>

			<hr class="small">

			<?// ------------ LinkPoint Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='linkpointCheckbox'>
							<br>
							<input id='linkpointCheckbox' type="checkbox" data-hiddenpanel="linkpoint"  class="hiddenPaneRevealer" name="gateway[linkpoint][payment_linkpointStatus]" <?= ($gatewayInfo['linkpoint']['payment_linkpointStatus'] == "on" ? 'checked="checked"' : "" )?>>
							<?=system_showText(LANG_SITEMGR_ENABLE);?> LinkPoint
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['linkpoint']['payment_linkpointStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>

					</div>
				</div>
				<div id="wrap-linkpoint" class="<?= ($gatewayInfo['linkpoint']['payment_linkpointStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="linkpointFile"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_CONFIGFILE)?> <i class="form-tip icon-help10" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LINKPOINTINFORMATION_WARNING)?>"></i></label>
                        <input id='linkpointFile' class="form-control" type="text"  name="gateway[linkpoint][linkpoint_configfile]" value="<?= $gatewayInfo['linkpoint']['linkpoint_configfile'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="linkpointKey"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_KEYFILE)?> </label>
                        <input id="linkpointKey" class="form-control" type="text"  name="gateway[linkpoint][linkpoint_keyfile]" value="<?= $gatewayInfo['linkpoint']['linkpoint_keyfile'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="checkbox">
                            <label for='linkpointRecurring'>
                                <br>
                                <input id='linkpointRecurring' class='recurringAction' type="checkbox" name="gateway[linkpoint][linkpoint_recurringCheckbox]" <?= ($gatewayInfo['linkpoint']['linkpoint_recurringCheckbox'] == "on" ? 'checked="checked"' : "" )?>>
                                <?=system_showText(LANG_SITEMGR_SETTINGS_RECURRING)?>
                            </label>
                        </div>
                    </div>
				</div><!-- wrapper-->
			</div>

			<hr class="small">
            
			<?// ------------ Paypal Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='paypalAPICheckbox'>
							<br>
							<input id='paypalAPICheckbox' type="checkbox" data-hiddenpanel="paypalapi"  class="hiddenPaneRevealer" name="gateway[paypalAPI][payment_paypalapiStatus]" <?= ($gatewayInfo['paypalAPI']['payment_paypalapiStatus'] == "on" ? 'checked="checked"' : "" )?> >
							<?=system_showText(LANG_SITEMGR_ENABLE);?> Paypal API
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['paypalAPI']['payment_paypalapiStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
						
					</div>
				</div>
				<div id="wrap-paypalapi" class="<?= ($gatewayInfo['paypalAPI']['payment_paypalapiStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="paypalAPIUsername"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_USERNAME)?></label>
                        <input id="paypalAPIUsername" class="form-control" type="text"  name="gateway[paypalAPI][paypalapi_username]" value="<?= $gatewayInfo['paypalAPI']['paypalapi_username'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="paypalAPIPassword"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_PASSWORD)?></label>
                        <input id='paypalAPIPassword' class="form-control" type="text" name="gateway[paypalAPI][paypalapi_password]" value="<?= $gatewayInfo['paypalAPI']['paypalapi_password'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="paypalAPISignature"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_SIGNATURE)?></label>
                        <input id='paypalAPISignature' class="form-control" type="text" name="gateway[paypalAPI][paypalapi_signature]" value="<?= $gatewayInfo['paypalAPI']['paypalapi_signature'] ?>">
                    </div>
				</div>
			</div>

			<hr class="small">
			
			<?// ------------ PagSeguro Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
                        <label for="pagseguroCheckbox">
							<br>
							<input id='pagseguroCheckbox' type="checkbox" data-hiddenpanel="pagseguro"  class="hiddenPaneRevealer" name="gateway[pagseguro][payment_pagseguroStatus]" <?= ($gatewayInfo['pagseguro']['payment_pagseguroStatus'] == "on" ? 'checked="checked"' : "" )?> >
							<?=system_showText(LANG_SITEMGR_ENABLE);?> PagSeguro
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['pagseguro']['payment_pagseguroStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
						
					</div>
				</div>
				<div id="wrap-pagseguro" class="<?= ($gatewayInfo['pagseguro']['payment_pagseguroStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="pagseguroUsername"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_ACCOUNT)?></label>
                        <input id="pagseguroUsername" class="form-control" type="text"  name="gateway[pagseguro][pagseguro_email]" value="<?= $gatewayInfo['pagseguro']['pagseguro_email'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="pagseguroPassword"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_PAGSEGUROTOKEN)?></label>
                        <input id='pagseguroPassword' class="form-control" type="text" name="gateway[pagseguro][pagseguro_token]" value="<?= $gatewayInfo['pagseguro']['pagseguro_token'] ?>">
                    </div>
				</div>
			</div>

			<hr class="small">
			
			<?// ------------ 2CheckOut Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='twocheckoutCheckbox'>
							<br>
							<input id='twocheckoutCheckbox' type="checkbox" data-hiddenpanel="twocheckout"  class="hiddenPaneRevealer" name="gateway[twoCheckout][payment_twocheckoutStatus]" <?= ($gatewayInfo['twoCheckout']['payment_twocheckoutStatus'] == "on" ? 'checked="checked"' : "" )?>>
							<?=system_showText(LANG_SITEMGR_ENABLE);?> 2CheckOut
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['twoCheckout']['payment_twocheckoutStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
					</div>
				</div>
				<div id="wrap-twocheckout" class="<?= ($gatewayInfo['twoCheckout']['payment_twocheckoutStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="twocheckoutUsername"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_ACCOUNT)?></label>
                        <input id='twocheckoutUsername' class="form-control" type="text"  name="gateway[twoCheckout][twocheckout_login]" value="<?= $gatewayInfo['twoCheckout']['twocheckout_login'] ?>">
                    </div>
				</div>
			</div>

			<hr class="small">

			<?// ------------ iTransact Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='itransactCheckbox'>
							<br>
							<input id='itransactCheckbox' type="checkbox" name="gateway[itransact][payment_itransactStatus]" data-hiddenpanel="itransaction"  class="hiddenPaneRevealer" <?= ($gatewayInfo['itransact']['payment_itransactStatus'] == "on" ? 'checked="checked"' : "" )?>>
							<?=system_showText(LANG_SITEMGR_ENABLE);?> iTransact
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['itransact']['payment_itransactStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
						
					</div>
				</div>
				<div id="wrap-itransaction" class="<?= ($gatewayInfo['itransact']['payment_itransactStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="itransactionVendorID"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_VENDORID)?></label>
                        <input id='itransactionVendorID' class="form-control" type="text"  name="gateway[itransact][itransact_vendorid]"  value="<?= $gatewayInfo['itransact']['itransact_vendorid'] ?>">
                    </div>
				</div>
			</div>

			<hr class="small">

			<?// ------------ PayFlow Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='payflowCheckbox'>
							<br>
							<input id='payflowCheckbox' type="checkbox" name="gateway[payflow][payment_payflowStatus]" data-hiddenpanel="payflow"  class="hiddenPaneRevealer" <?= ($gatewayInfo['payflow']['payment_payflowStatus'] == "on" ? 'checked="checked"' : "" )?>>
							<?=system_showText(LANG_SITEMGR_ENABLE);?> PayFlow
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['payflow']['payment_payflowStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
						
					</div>
				</div>
				<div id="wrap-payflow" class="<?= ($gatewayInfo['payflow']['payment_payflowStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="payflowUsername"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_LOGIN)?></label>
                        <input id='payflowUsername' class="form-control" type="text"  name="gateway[payflow][payflow_login]" value="<?= $gatewayInfo['payflow']['payflow_login'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="payflowPartner"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_PARTNER)?></label>
                        <input id='payflowPartner' class="form-control" type="text"  name="gateway[payflow][payflow_partner]" value="<?= $gatewayInfo['payflow']['payflow_partner'] ?>">
                    </div>
				</div>
			</div>

			<hr class="small">

			<?// ------------ PSIgate Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='psigateCheckbox'>
							<br>
							<input id='psigateCheckbox' type="checkbox" name="gateway[psigate][payment_psigateStatus]" data-hiddenpanel="psigate"  class="hiddenPaneRevealer" <?= ($gatewayInfo['psigate']['payment_psigateStatus'] == "on" ? 'checked="checked"' : "" )?>>
							<?=system_showText(LANG_SITEMGR_ENABLE);?> PSIgate
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['psigate']['payment_psigateStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
						
					</div>
				</div>
				<div id="wrap-psigate" class="<?= ($gatewayInfo['psigate']['payment_psigateStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="psigateUsername"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_STOREID)?></label>
                        <input id='psigateUsername' class="form-control" type="text"  name="gateway[psigate][psigate_storeid]" value="<?= $gatewayInfo['psigate']['psigate_storeid'] ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="psigatePass"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_PASSPHRASE)?></label>
                        <input id='psigatePass' class="form-control" type="text"  name="gateway[psigate][psigate_passphrase]" value="<?= $gatewayInfo['psigate']['psigate_passphrase'] ?>">
                    </div>
				</div>
			</div>

			<hr class="small">			

			<?// ------------ worldpay Gateway ------------- ?>
			<div class="row">
				<div class="form-group col-sm-3">
					<div class="checkbox">
						<label for='worldpayCheckbox'>
							<br>
							<input id='worldpayCheckbox' type="checkbox" name="gateway[worldpay][payment_worldpayStatus]" data-hiddenpanel="worldpay"  class="hiddenPaneRevealer" <?= ($gatewayInfo['worldpay']['payment_worldpayStatus'] == "on" ? 'checked="checked"' : "" )?>>
							<?=system_showText(LANG_SITEMGR_ENABLE);?> WorldPay
							<i class="icon-ion-ios7-checkmark-outline icon-middle  form-tip text-primary <?= ($gatewayInfo['worldpay']['payment_worldpayStatus'] == "on" ? '' : "hidden" )?>" data-toggle="tooltip" data-original-title="<?=system_showText(LANG_SITEMGR_ACTIVE)?>"></i>
						</label>
						
					</div>
				</div>
				<div id="wrap-worldpay" class="<?= ($gatewayInfo['worldpay']['payment_worldpayStatus'] == "on" ? '' : "hidden" )?>">
                    <div class="form-group col-sm-3">
                        <label for="worldpayUsername"><?=system_showText(LANG_SITEMGR_SETTINGS_PAYMENT_LABEL_INSTALATIONID)?></label>
                        <input id='worldpayUsername' class="form-control" type="text"  name="gateway[worldpay][worldpay_instid]"  value="<?= $gatewayInfo['worldpay']['worldpay_instid'] ?>">
                    </div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<button class="btn btn-primary action-save" data-loading-text="<?=system_showText(LANG_LABEL_FORM_WAIT);?>" type="submit" name="action" value="gateways"><?=system_showText(LANG_SITEMGR_SAVE_CHANGES);?></button>
		</div>
	</div>

</div>