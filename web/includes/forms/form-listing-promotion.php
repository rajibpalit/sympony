<?
    /*
    * # Admin Panel for eDirectory
    * @copyright Copyright 2014 Arca Solutions, Inc.
    * @author Basecode - Arca Solutions, Inc.
    */

    # ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form-listing-promotion.php
	# ----------------------------------------------------------------------------------------------------

    JavaScriptHandler::registerLoose('
        function setPromotionSelectBox(){
            $.post( "'.DEFAULT_URL.'/includes/code/deal_ajax_interface.php", { promotionId : '.($promotion_id ? $promotion_id : 0).', action : "getAllDeals", accountId : '.$account_id.' }).done(function( data ) {
                var deals = JSON.parse( data );

                if( deals )
                {
                    var i, length = deals.length;
                    var select   = "<select name=\"promotion_id\">";
                    var selected = '.( $promotion_id ? '""' : '"selected=\"selected\""' ).';
                    select += "<option "+selected+" value=\"0\">'.system_showText( LANG_CHOOSE_DEAL_ATTACH ).'</option>";
                    for ( i = 0; i < deals.length; i++ ) {
                        selected = ( deals[i].id == "'.($promotion_id? $promotion_id : 0).'" ? "selected=\"selected\"" : "" );
                        select += "<option "+selected+" value=\""+deals[i].id+"\">"+deals[i].label+"</option>";
                    }
                    select += "</select>";

                    $("#dealSelectBox").html( select );

                    var options = {
                        allowEmptyOption : true
                    };

                    $("#dealSelectBox select").selectize( options );
                }
                else
                {
                    $("#dealSelectBox").html( "<p class=\"alert alert-info\">'.system_showText(LANG_ATTACHDEAL_UNAVAILABLE).'</p>" );
                }
            });
        }
    ');
    
    JavaScriptHandler::registerOnReady('
        setPromotionSelectBox();
    ');
?>
    <div class="col-md-8">

        <div class="panel panel-form">

            <div class="form-group">
                <div class="panel-heading"><?=system_showText(LANG_SITEMGR_PROMOTION_SING)?></div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <? if ($message_listingpromotion) { ?>
                            <p class="alert alert-warning"><?=$message_listingpromotion?></p>
                        <? } ?>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <? if (!$promotion_id){ ?>
                                    
                                    <a href="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/content/<?=PROMOTION_FEATURE_FOLDER?>/deal.php?listing_id=<?=$listing->getNumber("id")?><?=(($url_search_params) ? "&$url_search_params" : "");?>" class="btn btn-primary">
                                        <?=system_showText(LANG_SITEMGR_ADDNEW)?> <?=system_showText(LANG_SITEMGR_PROMOTION)?>
                                    </a>
                                    <br>
                                    

                                <? } ?>
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">   
                                <label>
                                    <?=system_showText(LANG_OR)?>

                                    <?=system_showText(LANG_SITEMGR_PROMOTION_ASSOCIATE)?>
                                </label>
                                <div id="dealSelectBox"></div>
                                <p class="help-block small"><?=system_showText(LANG_ATTACHDEAL_EMPTY);?></p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <br>
        <div class="panel panel-default">
            <div class="panel-body">
                <p><?=system_showText(LANG_SITEMGR_PROMOTION_TIP1)?></p>
                <p><?=system_showText(LANG_SITEMGR_PROMOTION_TIP2)?></p>
                <p><?=system_showText("&#149;&nbsp".LANG_SITEMGR_PROMOTION_TIP3)?></p>
                <p><?=system_showText("&#149;&nbsp".LANG_SITEMGR_PROMOTION_TIP4)?></p>
            </div>
        </div>
    </div>