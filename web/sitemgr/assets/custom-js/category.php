<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/assets/custom-js/category.php
	# ----------------------------------------------------------------------------------------------------

?>
	<script>
        
        function system_displayTinyMCEJS() {
            tinyMCE.execCommand('mceAddControl', false, 'content');
        }
        
        $(document).ready(function () {
            
            //Close sidebar automatically
            ControlSidebar();
            
            //Pre-fill page title
            $('#title').blur(function() {
                $('#page_title').attr('value', $('#title').val());
            });
                            
            //Load TinyMCE
            system_displayTinyMCEJS();

        });

    </script>