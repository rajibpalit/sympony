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
    # * FILE: /classes/class_ArticleReports.php
    # ----------------------------------------------------------------------------------------------------

    class ArticleReports extends BasicModuleReports
    {
        protected static $itemField      = "article_id";
        protected static $itemTable      = "Report_Article";
        protected static $itemDailyTable = "Report_Article_Daily";
        protected static $itemMonthTable = "Report_Article_Monthly";

        public function __construct( $item, $domainID = null )
        {
            parent::__construct( $item, $domainID );

            /* These maps each id to its corresponding property in this object */
            $this->reportTypeDictionary = array(
                1 => &$this->summary,
                2 => &$this->detail,
            );

            $levelObj     = new ArticleLevel();

            $this->reportDictionary = array(
                "detail_view"  => array(
                    "property" => &$this->detail,
                    "color"    => "39,174,96",
                    "label"    => system_showText( LANG_LABEL_ADVERTISE_DETAILVIEW ),
                    "enabled"  => $levelObj && $levelObj->getDetail( $this->item->getNumber( "level" ) ) == "y"
                ),
                "summary_view" => array(
                    "property" => &$this->summary,
                    "color"    => "211,84,0",
                    "label"    => system_showText( LANG_LABEL_ADVERTISE_SUMMARYVIEW ),
                    "enabled"  => true
                ),
            );
        }
    }
