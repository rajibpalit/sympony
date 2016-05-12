<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/modals/modal-api.php
	# ----------------------------------------------------------------------------------------------------

    # ----------------------------------------------------------------------------------------------------
	# FORMS DEFINES
	# ----------------------------------------------------------------------------------------------------

    $helpLink = "<a href=\"apihelp.php\">";
    $helpLabel = system_showText(LANG_SITEMGR_API_TIP5); 
    $helpLabel = str_replace("[OPENLINK]", $helpLink, $helpLabel);
    $helpLabel = str_replace("[CLOSELINK]", "</a>", $helpLabel);

    $downloadLink = "<a href=\"javascript: void(0);\" onclick=\"download_doc();\">";
    $downloadLabel = system_showText(LANG_SITEMGR_API_TIP9); 
    $downloadLabel = str_replace("[OPENLINK]", $downloadLink, $downloadLabel);
    $downloadLabel = str_replace("[CLOSELINK]", "</a>", $downloadLabel);
    
    $defaultVAR = array	(
		0	=>	array("variable" => "* key",          "description" => system_showText(LANG_SITEMGR_API_VAR_KEY)),
		1	=>	array("variable" => "* module",       "description" => system_showText(LANG_SITEMGR_API_VAR_MODULE)),
		2	=>	array("variable" => "* keyword",      "description" => system_showText(LANG_SITEMGR_API_VAR_KEYWORD)),
		3	=>	array("variable" => "where",        "description" => system_showText(LANG_SITEMGR_API_VAR_WHERE)),
		4	=>	array("variable" => "screen",		"description" => system_showText(LANG_SITEMGR_API_VAR_SCREEN)),
		5	=>	array("variable" => "letter",		"description" => system_showText(LANG_SITEMGR_API_VAR_LETTER))
	);
?>

    <div class="modal fade" id="modal-api" tabindex="-1" role="dialog" aria-labelledby="modal-api" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?=system_showText(LANG_CLOSE);?></span></button>
                    <h4 class="modal-title"><?=system_showText(LANG_SITEMGR_API_TIP1)?></h4>
                </div>
                
                <div class="modal-body">
                        <p><?=system_showText(LANG_SITEMGR_API_TIP2)?></p><br />
                        <p>1) <?=system_showText(LANG_SITEMGR_API_TIP3)?></p>
                        <p>2) <?=system_showText(LANG_SITEMGR_API_TIP4)?></p>
                        <br />
                        <pre><code><?=system_showText(DEFAULT_URL."/API/api.php?key=[".LANG_SITEMGR_API_TIP6."]&module=[".LANG_SITEMGR_API_TIP7."]&keyword=[".LANG_SITEMGR_API_TIP8."]")?></code></pre>
                        <br />
                        <p class="text-warning"><?=system_showText(LANG_SITEMGR_API_NOTE);?></p>                  
                        <p><?=system_showText(LANG_SITEMGR_API_HELP_USEPARAMETERS)?>:</p>
                           
                       
                        <table  class="table table-bordered">
                            <thead>
                                <tr>
                                    <td colspan="2"><?=system_showText(LANG_SITEMGR_API_HELP_PARAMETERSDESCRIPTION)?></td>
                                </tr>
                            </thead>
                        <? if ($defaultVAR) { ?>
                            <? foreach ($defaultVAR as $var) { ?>
                                <tr>
                                    <th><?=$var["variable"]?></th>
                                    <td><?=$var["description"]?></td>
                                </tr>
                            <? } ?>
                        <? } ?>
                        </table>
                        <p><?=$downloadLabel?></p><br />
                        
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->