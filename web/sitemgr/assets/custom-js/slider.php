<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /ed-admin/assets/custom-js/slider.php
	# ----------------------------------------------------------------------------------------------------

?>
	<script>
                        
        function deleteSlider(id) {
            
            bootbox.confirm("<?=LANG_SITEMGR_SLIDER_CONFIRM_DELETE?>", function(result) {
                if (result) {
                    $('#delete_image_id').attr('value', $('#' + id + '_image_id').val());
                    $('#delete_slider_id').attr('value', $('#' + id + '_id').val());
                    document.delete_slider.submit();
                }
            });

        }
        
        function selectSlide(id) {
            $('#last_slide_changed').attr('value', id);
        }

    </script>