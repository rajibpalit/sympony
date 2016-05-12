<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/assets/custom-js/plugins.php
	# ----------------------------------------------------------------------------------------------------

?>
	<script>
        
		function download_wordpress_plugin(type) {
			<? if (!DEMO_LIVE_MODE) { ?>
				document.location = "<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/configuration/wordpress/index.php?download=1&type="+type;
			<? } else { ?>
				livemodeMessage(true, false);
			<? } ?>
		}
        
        function download_sugar_plugin() {
			<? if (!DEMO_LIVE_MODE) { ?>
				document.location = "<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/configuration/sugarcrm/index.php?download=1&type=sugar";
			<? } else { ?>
				livemodeMessage(true, false);
			<? } ?>
		}

		$(document).ready(
			
			function(){
				$("#wordpress_plugin").submit(function(event){
                    event.preventDefault();
                    if ($("#wordpress_url").val()){
                       
                        $.post("<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/configuration/wordpress/wordpress_plugin_ajax.php", $("#wordpress_plugin").serialize(), 
                            function(data){
                                $("#download-box").removeClass("hidden");
                                $("#wp_key").html(data);
                                $('.action-save').button('reset');
                            }
                        );
                    } else {
                        bootbox.alert('<?=system_showText(LANG_LABEL_TYPE_URL)?>', function() {
                            btn = $('.action-save');
                            btn.button('reset');
                        });
                    }
					
				});
                
                $("#sugar_plugin").submit(function(event){
					event.preventDefault();
                    if ($("#sugar_url").val() && $("#sugar_user").val() && $("#sugar_password").val()){
                    
                        $.post("<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/configuration/sugarcrm/sugarCRM_plugin_ajax.php", $("#sugar_plugin").serialize(), 
                        function(data) {
                            $("#sugar_download_button").html(data);
                            $('.action-save').button('reset');
                        });
                    } else {
                        bootbox.alert('<?=system_showText(LANG_LABEL_TYPE_FIELDS)?>', function() {
                            btn = $('.action-save');
                            btn.button('reset');
                        });
                    }
				});
			}
		);
        
	</script>