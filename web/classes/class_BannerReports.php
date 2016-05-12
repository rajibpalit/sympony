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
    # * FILE: /classes/class_BannerReports.php
    # ----------------------------------------------------------------------------------------------------

    class BannerReports extends Reports
    {
        protected static $itemField      = "banner_id";
        protected static $itemTable      = "Report_Banner";
        protected static $itemDailyTable = "Report_Banner_Daily";
        protected static $itemMonthTable = "Report_Banner_Monthly";

        protected $item;

        public $click;
        public $view;

        public function __construct( $item, $domainID = null )
        {
            parent::__construct( $item, $domainID );

            /* These maps each id to its corresponding property in this object */
            $this->reportTypeDictionary = array(
                1 => &$this->click,
                2 => &$this->view,
            );

            $this->reportDictionary = array(
                "click_thru"   => array(
                    "property" => &$this->click,
                    "color"    => "51,181,229",
                    "label"    => system_showText(LANG_LABEL_WEBSITEVIEWS),
                    "enabled"  => true
                ),
                "email_sent"   => array(
                    "property" => &$this->view,
                    "color"    => "39,174,96",
                    "label"    => system_showText(LANG_LABEL_TOTALVIEWERS),
                    "enabled"  => true
                )
            );
        }

        public function retrieveDay( $startDate = null, $endDate = null )
        {
            if ( $startDate || $endDate )
            {
                $this->getDateSpan( $startDate, $endDate );
                $timeRangeClause = "( DATE( day ) BETWEEN '{$startDate->format("Y-m-d")}' AND '{$endDate->format("Y-m-d")}' ) AND ";
            }
            else
            {
                $timeRangeClause = "";
            }

            $table = static::$itemDailyTable;
            $field = static::$itemField;

            $sql =  "SELECT "
                 .      "YEAR(day) AS year, "
                 .      "MONTH(day) AS month, "
                 .      "SUM(click_thru) AS click, "
                 .      "SUM(view) AS view "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "{$timeRangeClause} "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY year, month";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->click[$row['year']][$row['month']] += $row['click'];
                $this->view[$row['year']][$row['month']]  += $row['view'];
            }
        }

        public function retrieveMonth( $startDate = null, $endDate = null )
        {
            if ( $startDate || $endDate )
            {
                $this->getDateSpan( $startDate, $endDate );
                $timeRangeClause = "( DATE( day ) BETWEEN '{$startDate->format("Y-m-d")}' AND '{$endDate->format("Y-m-d")}' ) AND ";
            }
            else
            {
                $timeRangeClause = "";
            }

            $table = static::$itemMonthTable;
            $field = static::$itemField;

            $sql =  "SELECT "
                 .      "YEAR(day) AS year, "
                 .      "MONTH(day) AS month, "
                 .      "SUM(click_thru) AS click, "
                 .      "SUM(view) AS view "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "{$timeRangeClause} "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY year, month";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->click[$row['year']][$row['month']] += $row['click'];
                $this->view[$row['year']][$row['month']]  += $row['view'];
            }
        }

        public function retrieveCurrentMonth( )
        {
            $table = static::$itemDailyTable;
            $field = static::$itemField;

            $sql =  "SELECT "
                 .      "MONTH(day) AS month, "
                 .      "DAY(day)   AS day, "
                 .      "click_thru AS click, "
                 .      "view "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY month, day";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->click[$row['month']][$row['day']] += $row['click'];
                $this->view[$row['month']][$row['day']]  += $row['view'];
            }
        }
        
    }
