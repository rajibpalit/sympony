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
    # * FILE: /classes/class_BasicModuleReports.php
    # ----------------------------------------------------------------------------------------------------

    abstract class BasicModuleReports extends Reports
    {
        public $summary;
        public $detail;

        /**
         * Gathers click and view data from this month's days and orders by Year and Month
         *
         * @param mixed $startDate
         * @param mixed $endDate
         */
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
                 .      "YEAR(day)  AS year, "
                 .      "MONTH(day) AS month, "
                 .      "SUM(summary_view) AS summary, "
                 .      "SUM(detail_view)  AS detail "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "{$timeRangeClause} "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY year, month";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->detail[$row['year']][$row['month']]  += $row['detail'];
                $this->summary[$row['year']][$row['month']] += $row['summary'];
            }
        }

        /**
         * Gathers click and view data from this all years and months and orders by Year and Month
         *
         * @param mixed $startDate
         * @param mixed $endDate
         */
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
                 .      "SUM(summary_view) AS summary, "
                 .      "SUM(detail_view) AS detail "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "{$timeRangeClause} "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY year, month";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->detail[$row['year']][$row['month']]  += $row['detail'];
                $this->summary[$row['year']][$row['month']] += $row['summary'];
            }
        }

        /**
         * Gathers click and view data from one month ago to now and orders by Month and Day
         */
        public function retrieveCurrentMonth()
        {
            $table = static::$itemDailyTable;
            $field = static::$itemField;

            $sql =  "SELECT "
                 .      "MONTH(day) AS month, "
                 .      "DAY(day)   AS day, "
                 .      "summary_view AS summary, "
                 .      "detail_view AS detail "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY month, day";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->detail[$row['month']][$row['day']] += $row['detail'];
                $this->summary[$row['month']][$row['day']] += $row['summary'];
            }
        }
    }
