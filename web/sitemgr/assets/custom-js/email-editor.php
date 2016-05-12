<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/assets/custom-js/email-editor.php
	# ----------------------------------------------------------------------------------------------------

?>
	<script>
        $(document).ready(function () {
            //Close sidebar automatically
            ControlSidebar();
        });
        
        function JS_Back() {
			document.emailnotifications.nav_page.value = 0;
			document.emailnotifications.submit();
		}
        
        function confirmRestore(pText, pId, pForm) {
            
            bootbox.confirm(pText, function(result) {
                if (result) {
                    $("input[name='hiddenValue']").attr('value', pId);
                    document.getElementById(pForm).submit();
                }
            });
            
        }
    </script>