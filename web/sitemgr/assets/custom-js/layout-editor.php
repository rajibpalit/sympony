<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/assets/custom-js/layout-editor.php
	# ----------------------------------------------------------------------------------------------------

?>
	<script src="<?=DEFAULT_URL?>/scripts/jquery/auto_upload/js/file_uploads.js"></script>
    <script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/editarea/edit_area/edit_area_full.js"></script>

    <script>

        function JS_submit(scheme, checkTheme, value) {
            if (scheme) {
                $("#scheme").attr("value", scheme);
            }
            $("#select_theme").attr("value", value);
            $("#theme").submit();
        }
        
        function JS_submitColors(type) {
			if (type == "reset") {
                $("#action").attr("value", "reset");
                bootbox.confirm('<?=system_showText(LANG_SITEMGR_COLORS_RESET_CONFIRM);?>', function(result) {
                    if (result) {
                        document.color_scheme.submit();
                    } else {
                        btn = $('.action-save');
                        btn.button('reset');
                    }
                });
			} else {		
                document.color_scheme.submit();
			}
		}
        		
		function restoreDefault(id, div, color) {
			if (color) {
				$("#"+id).attr("value", color);
				$("."+div).css("backgroundColor", "#"+color);
			} else {
				$("#"+id).attr("value", "SCHEME_EMPTY");
				$("."+div).css("backgroundColor", "");
			}
		}
        
        <? if ($loadCateg) { ?>
            $(document).ready(function() {
                $.get("<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/layout-editor/index.php"?>", {
                    action: 'ajax',
                    domain_id: <?=SELECTED_DOMAIN_ID;?>
                });
            });
        <? } ?>
    
        function resetImage() {
            $("#reset_form").attr("value", "reset");
        }
        
        function submitForm(form_id) {
            
            <? if (!DEMO_LIVE_MODE) { ?>
            
            var strReturn;
            $.post("<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/layout-editor/index.php?action=ajax&type=general&domain_id=".SELECTED_DOMAIN_ID?>", $('#'+form_id).serialize(), function(response) {
                strReturn = response.split("||");
                
                var returnMessageID = "returnMessage";
                if (form_id == "pricing_levels_form") {
                    returnMessageID = returnMessageID + '-' + form_id;
                }

                $("#"+returnMessageID).removeClass("alert-success");
                $("#"+returnMessageID).removeClass("alert-warning");
                if (strReturn[0] == 'error') {
                    strReturn[0] = 'warning'
                }
                $("#"+returnMessageID).addClass("alert-"+strReturn[0]);
                $("#"+returnMessageID).html(strReturn[1]);
                $("#"+returnMessageID).show();
                
                btn = $('.action-save');
                btn.button('reset');
                
                //Reset image
                if (strReturn[2]) {

                    if (strReturn[2] == "show") {
                        $("#buttonReset").prop("disabled", "");
                    } else {
                        $("#buttonReset").prop("disabled", "disabled");
                        $("#image-background").hide().fadeIn('slow').html(strReturn[3]);
                    }

                }
             });
             
            <? } else { ?>
				livemodeMessage(true, false);
			<? } ?>
        }
        
        function sendFile() {
            
            <? if (!DEMO_LIVE_MODE) { ?>
            
            $("#theme_background_image").vPB({
                url: '<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/layout-editor/index.php?action=ajax&type=uploadBackground&domain_id=".SELECTED_DOMAIN_ID?>',
                beforeSubmit: function() 
                {
                    $("#loading_backgroundimage").removeClass('hidden');
                },
                success: function(response) 
                {
                    strReturn = response.split("||");
                    $('#loading_backgroundimage').addClass('hidden');

                    if ($.trim(strReturn[0]) == "ok") {
                        $("#returnMessage").hide();
                        $("#image-background").hide().fadeIn('slow').html(strReturn[1]);
                    } else {
                        $("#returnMessage").removeClass("alert-success");
                        $("#returnMessage").removeClass("alert-warning");

                        $("#returnMessage").addClass("alert-warning");
                        $("#returnMessage").html(strReturn[1]);
                        $("#returnMessage").show();
                    }
                    
                    btn = $('.action-save');
                    btn.button('reset');
                }
            }).submit();
            
            <? } else { ?>
				livemodeMessage(true, false);
			<? } ?>
        }
        
        function setEditor(value) {
            if (value) {
                location.href = '<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/layout-editor/index.php?file="?>'+value;
            }
        }
        
        function InitEDitor() {
            editAreaLoader.init({
                id : "textarea",	
                syntax: "<?=$editorSyntax?>",			
                start_highlight: true,
                language: "<?=$editorLang?>",
                allow_toggle: false
            });
        }
        
        function changePriceSymbol(price_symbol) {
            $("#inexpensive_symbol").html(price_symbol);
            $("#averagely_expensive_symbol").html(price_symbol+''+price_symbol);
            $("#moderately_expensive_symbol").html(price_symbol+''+price_symbol+''+price_symbol);            
            $("#expensive_symbol").html(price_symbol+''+price_symbol+''+price_symbol+''+price_symbol);
        }
        
        $(document).ready(function() {

            changePriceSymbol('<?=$listing_price_symbol;?>');
            InitEDitor();
            
        });
                
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            InitEDitor();
        });

    </script>