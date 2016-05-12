<?
    /* ==================================================================*\
      ######################################################################
      #                                                                    #
      # Copyright 2015 Arca Solutions, Inc. All Rights Reserved.           #
      #                                                                    #
      # This file may not be redistributed in whole or part.               #
      # eDirectory is licensed on a per-domain basis.                      #
      #                                                                    #
      # ---------------- eDirectory IS NOT FREE SOFTWARE ----------------- #
      #                                                                    #
      # http://www.edirectory.com | http://www.edirectory.com/license.html #
      ######################################################################
      \*================================================================== */

    # ----------------------------------------------------------------------------------------------------
    # * FILE: /classes/class_PromotionReports.php
    # ----------------------------------------------------------------------------------------------------

    class PromotionReports extends BasicModuleReports
    {
        protected static $itemField      = "promotion_id";
        protected static $itemTable      = "Report_Promotion";
        protected static $itemDailyTable = "Report_Promotion_Daily";
        protected static $itemMonthTable = "Report_Promotion_Monthly";

        public function __construct( $item, $domainID = null )
        {
            parent::__construct( $item, $domainID );

            /* These maps each id to its corresponding property in this object */
            $this->reportTypeDictionary = array(
                1 => &$this->summary,
                2 => &$this->detail,
            );

            $this->reportDictionary = array(
                "detail_view"  => array(
                    "property" => &$this->detail,
                    "color"    => "39,174,96",
                    "label"    => system_showText(LANG_LABEL_ADVERTISE_DETAILVIEW),
                    "enabled"  => true
                ),
                "summary_view" => array(
                    "property" => &$this->summary,
                    "color"    => "211,84,0",
                    "label"    => system_showText(LANG_LABEL_ADVERTISE_SUMMARYVIEW),
                    "enabled"  => true
                ),
            );
        }
    }