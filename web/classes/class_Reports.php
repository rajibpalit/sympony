<?

    /* ==================================================================*\
      ######################################################################
      #                                                                    #
      # Copyright 2005 Arca Solutions, Inc. All Rights Reserved.           #
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
    # * FILE: /classes/class_Reports.php
    # ----------------------------------------------------------------------------------------------------

    abstract class Reports
    {
        /**
         * Stores an instance of the Database handler object
         * @var mysql
         */
        protected static $dataBase;

        /**
         * Stores the field name to be used when retrieving data from the Current Day, Daily and Monthly tables
         * @var string
         */
        protected static $itemField;

        /**
         * The current day report storage table
         * @var string
         */
        protected static $itemTable;
        /**
         * The current month report storage table
         * @var string
         */
        protected static $itemDailyTable;
        /**
         * The monthly report storage table
         * @var string
         */
        protected static $itemMonthTable;

        /**
         * The number of initial reports to be shown
         * @var int
         */
        protected static $initialReportNumber = 2;

        /**
         * This function will attempt the following:
         *
         * If $date is already a DateTime instance, do nothing.
         * If $date is a string, convert to a DateTime instance.
         * return null otherwise.
         *
         * @param string $date
         * @return \DateTime
         */
        public static function convertToDateTime( $date )
        {
            $return = null;

            if( is_a( $date, 'DateTime' ) )
            {
                $return = $date;
            }
            else if( is_string( $date )  )
            {
                try
                {
                    $return = new DateTime( $date );
                }
                catch ( Exception $exc ){}
            }

            return $return;
        }

        /**
         * The specified item Id
         * @var int
         */
        protected $itemId;
        /**
         * A address dictionary for the instance properties where the Key is the report_type value from the database
         * and the value is the address of the instance's associated property.
         * @var array
         */
        protected $reportTypeDictionary;

        /**
         * A dictionary containing information for each type of report. The structure is as follows:
         *
         *  "click_thru"   => array(
         *          "property" => &$this->click, // Instance property address
         *          "color"    => "51,181,229",  // RGB color string
         *          "label"    => system_showText(LANG_LABEL_WEBSITEVIEWS),
         *          "enabled"  => $array_fields && ( in_array( "url"  , $array_fields ) )
         *      )
         *
         * @var array
         */
        protected $reportDictionary;

        /**
         * This stores an isntance of the object being handled by the class. Can be a listing, event, etc...
         * @var mixed
         */
        protected $item;

        public function __construct( $item, $domainID = null )
        {
            $mainDB = db_getDBObject( DEFAULT_DB, true );

            if ( $domainID )
            {
                self::$dataBase = ( is_numeric( $domainID ) ? db_getDBObjectByDomainID( $domainID, $mainDB ) : db_getDBObjectByDomainID( 0, $mainDB, str_replace( "www.", "", $domainID ) ) );
            }
            else if ( defined( "SELECTED_DOMAIN_ID" ) )
            {
                self::$dataBase = db_getDBObjectByDomainID( SELECTED_DOMAIN_ID, $mainDB );
            }
            else
            {
                self::$dataBase = db_getDBObject();
            }

            $this->item   = $item;
            $this->itemId = $item->getNumber("id");
        }

        /**
         * Retrieves report data from the current day
         *
         * If $startDate is not provided, the item creation date will be used instead
         * If $endDate is not provided, the current date will be used instead
         *
         * @param DateTime|string $startDate SQL formatted date Y-m-d
         * @param DateTime|string $endDate SQL formatted date Y-m-d
         */
        public function retrieveCurrentDay( $startDate = null, $endDate = null )
        {
            if ( $startDate || $endDate )
            {
                $this->getDateSpan( $startDate, $endDate );
                $timeRangeClause = "( DATE( date ) BETWEEN '{$startDate->format("Y-m-d")}' AND '{$endDate->format("Y-m-d")}' ) AND ";
            }
            else
            {
                $timeRangeClause = "";
            }

            $table = static::$itemTable;
            $field = static::$itemField;

            $sql    = "SELECT "
                    .     "YEAR(date) AS year, "
                    .     "MONTH(date) AS month, "
                    .     "`report_type` AS type, "
                    .     "SUM(`report_amount`) AS amount "
                    . "FROM {$table} "
                    . "WHERE "
                    .     "{$timeRangeClause} "
                    .     "`{$field}` = {$this->itemId} "
                    . "GROUP BY year, month, `report_type`";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->reportTypeDictionary[ $row['type'] ][ $row['year'] ][ $row['month'] ] += $row['amount'];
            }
        }

        abstract public function retrieveDay( $startDate = null, $endDate = null );

        abstract public function retrieveCurrentMonth();

        abstract public function retrieveMonth( $startDate = null, $endDate = null );

        /**
         * Retrieve report data from all report tables of this module in the specified date range.
         *
         * If $startDate is not provided, the item creation date will be used instead
         * If $endDate is not provided, the current date will be used instead
         *
         * @param type $startDate SQL formatted date Y-m-d
         * @param type $endDate SQL formatted date Y-m-d
         */
        public function retrieveData( $startDate = null, $endDate = null )
        {
            $this->retrieveCurrentDay( $startDate, $endDate );
            $this->retrieveDay( $startDate, $endDate );
            $this->retrieveMonth( $startDate, $endDate );
        }

        /**
         * Compiles instance data into a formatted array to be used with the Javascript generation function..
         *
         * @param string $startDate SQL formatted date Y-m-d
         * @param string $endDate SQL formatted date Y-m-d
         * @return array
         */
        public function compileData( $startDate = null, $endDate = null )
        {
            $this->getDateSpan( $startDate, $endDate );

            $minMonth = (int)$startDate->format('m');
            $minYear  = (int)$startDate->format('Y');

            $maxMonth = (int)$endDate->format('m');
            $maxYear  = (int)$endDate->format('Y');

            if( $minYear == $maxYear && $minMonth == $maxMonth )
            {
                return $this->compileDailyData();
            }
            else
            {
                return $this->compileMonthData( $startDate, $endDate );
            }
        }

        /**
         * Compiles data gathered from the current month table into a Month->Day data format
         *
         * @param mixed $startDate
         * @param mixed $endDate
         * @param int $divisions
         * @return array
         */
        public function compileDailyData( $startDate = null, $endDate = null, $divisions = 10 )
        {
            $this->getDateSpan( $startDate, $endDate );

            $this->retrieveCurrentMonth();

            $minDay = (int)$startDate->format( 'd' );
            $maxDay = (int)$endDate->format( 'd' );

            $month = (int)$startDate->format('m');
            $monthNames = explode(",", LANG_DATE_MONTHS);

            $data                 = null;
            $iteration            = 0;
            $data['maximumValue'] = 0;

            $dayInterval = max( array( ( $maxDay - $minDay ) / $divisions, 1 ) );

            /* Organize data */
            foreach ( $this->reportDictionary as $property => $settings )
            {
                if( $settings['enabled'] )
                {
                    $data[$property]['label'] = $settings['label'];
                    $data[$property]['color'] = $settings['color'];

                    $value = 0;

                    for ( $day = 0; $minDay + $day <= $maxDay; $day++ ) 
                    {
                        $value += ( empty( $settings['property'][$month][$minDay + $day] ) ? 0 : $settings['property'][$month][$minDay + $day] );

                        if( $day % $dayInterval == 0 )
                        {
                            !$iteration && $data["labels"][] = ($minDay + $day) . " - " . ucfirst(string_substr( $monthNames[$month-1], 0, 3));
                            $data['graphs'][$property]['data'][] = $value;

                            /* Gather the maximum value from the initial reports in order to show a properly sized graph */
                            if ( $iteration < static::$initialReportNumber && $data['maximumValue'] < $value )
                            {
                                $data['maximumValue'] = $value;
                            }

                            $value = 0;
                        }
                    }
                    $iteration++;
                }

            }

            return $data;
        }

        /**
         * Compiles instance data into a formatted array to be used with the Javascript generation function..
         *
         * @param string $startDate SQL formatted date Y-m-d
         * @param string $endDate SQL formatted date Y-m-d
         * @return array
         */
        public function compileMonthData( $startDate = null, $endDate = null )
        {
            $this->getDateSpan( $startDate, $endDate );
            $this->retrieveData( $startDate, $endDate );

            $minMonth = (int)$startDate->format('m');
            $minYear  = (int)$startDate->format('Y');

            $maxMonth = (int)$endDate->format('m');
            $maxYear  = (int)$endDate->format('Y');

            $monthNames = explode(",", LANG_DATE_MONTHS);

            $data                 = null;
            $iteration           = 0;
            $data['maximumValue'] = 0;

            /* Organize data */
            foreach ( $this->reportDictionary as $property => $settings )
            {
                if( $settings['enabled'] )
                {
                    $data[$property]['label'] = $settings['label'];
                    $data[$property]['color'] = $settings['color'];

                    for ( $year = $minYear; $year <= $maxYear; $year++ )
                    {
                        $monthStart = ( $year == $minYear ? $minMonth : 1 );
                        $monthLimit = ( $year == $maxYear ? $maxMonth : 12 );

                        for( $month = $monthStart; $month <= $monthLimit; $month++ )
                        {
                            /* Fills out the month labels array. First iteration only. */
                            $iteration or $data["labels"][] = ucfirst(string_substr( $monthNames[$month-1], 0, 3)) . " / ". ( $minYear == $maxYear ? "" : $year);

                            $value = ( $settings['property'][$year][$month] ? $settings['property'][$year][$month] : 0 );

                            $data['graphs'][$property]['data'][] = $value;

                            /* Gather the maximum value from the initial reports in order to show a properly sized graph */
                            if ( $iteration < static::$initialReportNumber && $data['maximumValue'] < $value )
                            {
                                $data['maximumValue'] = $value;
                            }
                        }
                    }
                    $iteration++;
                }
            }

            return $data;
        }

        /**
         * Feeds Javascript code representing the $data sent as parameter into the JavaScriptHandler class
         *
         * If no argument is provided for the $data parameter, it will be automatically generated from this instance
         * since it's creation to the present day.
         *
         * @param array $data a $data array representing this instance generated by the compileData function
         */
        public function getJavascript( $data = null )
        {
            $data or $data = $this->compileData();

            $chartLabels    = json_encode( $data["labels"] );
            $initialReports = "[ ".implode( ", ", array_slice( array_keys($data['graphs']), 0, static::$initialReportNumber ) )." ]";

            $js = "";

            foreach ( $data['graphs'] as $name => $report)
            {
                if( $report["data"] )
                {
                    $joinedData = json_encode( $report["data"] );

                    $js .= "
                        var {$name} = {
                                fillColor        : \"rgba({$this->reportDictionary[$name]['color']},0.1)\",
                                strokeColor      : \"rgba({$this->reportDictionary[$name]['color']},0.3)\",
                                pointColor       : \"rgba({$this->reportDictionary[$name]['color']},1)\",
                                pointStrokeColor : \"#fff\",
                                data : {$joinedData}
                            };
                    ";
                }
            }
            
            $js .= "
                var chartLabels      = {$chartLabels};
                var initialReport    = {$initialReports};
                var maxInitialReport = {$data['maximumValue']};
            ";

            return $js;
        }

        /**
         * This function will convert entered dates to DateTime instances.
         *
         * In case &$startdate is missing, we'll use the item entry date.
         * In case &$endDate is missing, we'll use the current day.
         *
         * @param mixed &$startDate
         * @param mixed &$endDate
         */
        public function getDateSpan( &$startDate, &$endDate )
        {
            $startDate    = self::convertToDateTime( $startDate );
            $creationDate = self::convertToDateTime( $this->item->getString( "entered" ) );

            /* There's no need to show months prior to the creation date. */
            $startDate > $creationDate or $startDate = $creationDate;

            $endDate   = self::convertToDateTime( $endDate )   or $endDate   = new DateTime();
        }

        /**
         * Uses $data parameter to determine all HTML required to display the graphs properly
         * @param mixed $data
         */
        public function renderGraphs( $data )
        {
            $graphs = array_keys( $data['graphs'] );
            $i = 0;
            ?>
                <section class="stats-complete">

                    <h2><?=system_showText(LANG_LABEL_STATISTICS);?></h2>
                    <div class="chart-legends">

                        <div class="hidden-legends <?= ( count( $graphs ) <= static::$initialReportNumber ? "hidden-desktop" : "") ?>">

                            <span><?=system_showText(LANG_LABEL_VIEW_MORE_STATS)?> &raquo;</span>
                            <ul id="optionLegend">

                             <? foreach ( $graphs as $name ) { ?>

                                <li class="legend-<?=++$i?> <?=( $i < static::$initialReportNumber ? "isvisible" : "")?>" report="<?=$name?>" onclick="selectLegend('select', <?=$i?>, <?=$name?>)">
                                    <i <?=($i <= static::$initialReportNumber ? "class=\"checked\"" : "")?>></i>
                                    <b style="background-color: rgb(<?= $this->reportDictionary[$name]['color']?>)"></b>
                                    <?=$this->reportDictionary[$name]['label']?>
                                </li>

                             <? } ?>

                             <? if ( count( $graphs ) > static::$initialReportNumber) { ?>

                                <li class="legend-ALL" onclick="selectLegend('viewALL', <?=$i;?>)">
                                    <i></i>
                                    <b></b>
                                    <?=system_showText(LANG_LABEL_VIEW_ALL)?>
                                </li>

                             <? } ?>
                            </ul>
                        </div>

                        <ul id="controlLegend">
                            <li class="legend-1 isvisible" <?=(count($graphs) > static::$initialReportNumber ? "onclick=\"selectLegend('select', 1, ".$graphs[0].")\"" : "")?>>
                                <i class="checked"></i>
                                <b style="background-color: rgb(<?= $this->reportDictionary[$graphs[0]]['color']?>)"></b>
                                <?= $this->reportDictionary[$graphs[0]]['label']?>
                            </li>

                            <li class="legend-2 isvisible" <?=(count($graphs) > static::$initialReportNumber ? "onclick=\"selectLegend('select', 2, ".$graphs[1].")\"" : "")?>>
                                <i class="checked"></i>
                                <b style="background-color: rgb(<?=$this->reportDictionary[$graphs[1]]['color']?>)"></b>
                                <?=$this->reportDictionary[$graphs[1]]['label']?>
                            </li>
                        </ul>
                    </div>

                    <canvas id="myChart" width="580" height="200"></canvas>
                </section>
            <?
        }
    }
