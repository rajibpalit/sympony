<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/assets/custom-js/content.php
	# ----------------------------------------------------------------------------------------------------

?>
	<script>
        
        $(document).ready(function () {
            
            //Close sidebar automatically
            var wW = $(window).width();
            if (wW >= 1200) {
               ControlSidebar();
            }
            
            if ($("#url").length) {
                updatePageURL();
            }
        });
        
        function JS_submit() {
            $("#submit_button").attr("value", 1);
            document.content.submit();
        }
        
        function updatePageURL() {
            if ($('#url').val()) {
                var newURL = '<?=$newurl."/"?>' + $('#url').val() + '.html';
                $('#page-url').attr('href', newURL);
                $('#page-url').html(newURL);
            }
        }

    </script>