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
    <script src="<?=DEFAULT_URL?>/scripts/jquery/formbuilder/jquery.formbuilder.js"></script>
    <script src="<?=DEFAULT_URL?>/scripts/jquery/formbuilder/lang/<?=(file_exists(EDIRECTORY_ROOT."/scripts/jquery/formbuilder/lang/".$sitemgr_language.".js") ? $sitemgr_language : "en_us")?>.js"></script>
    <script>
        $(function(){
            $('#form-builder').formbuilder({
                'save_url': '<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/lead-editor/index.php?action=save&domain_id=".SELECTED_DOMAIN_ID?>',
                'load_url': '<?=DEFAULT_URL."/".SITEMGR_ALIAS."/design/lead-editor/index.php?action=load&domain_id=".SELECTED_DOMAIN_ID?>'
            });

            $(function() {
                $("#form-builder ul").sortable({ opacity: 0.6, cursor: 'move'});
            });
        });
    </script>