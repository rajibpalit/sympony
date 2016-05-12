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
    # * FILE: /classes/class_ListingReports.php
    # ----------------------------------------------------------------------------------------------------

    class ListingReports extends Reports
    {
        protected static $itemField      = "listing_id";
        protected static $itemTable      = "Report_Listing";
        protected static $itemDailyTable = "Report_Listing_Daily";
        protected static $itemMonthTable = "Report_Listing_Monthly";

        protected $item;

        public $summary;
        public $detail;
        public $click;
        public $email;
        public $phone;
        public $fax;
        public $sms;
        public $click_call;


        public function __construct( $item, $domainID = null )
        {
            parent::__construct( $item, $domainID );

            /* These maps each id to its corresponding property in this object */
            $this->reportTypeDictionary = array(
                1 => &$this->click,
                2 => &$this->click_call,
                3 => &$this->detail,
                4 => &$this->email,
                5 => &$this->fax,
                6 => &$this->phone,
                7 => &$this->sms,
                8 => &$this->summary,
            );

            $levelObj     = new ListingLevel();
            $array_fields = system_getFormFields( 'listing', $this->item->getNumber("level") );

            $this->reportDictionary = array(
                "click_thru"   => array(
                    "property" => &$this->click,
                    "color"    => "51,181,229",
                    "label"    => system_showText(LANG_LABEL_WEBSITEVIEWS),
                    "enabled"  => $array_fields && ( in_array( "url"  , $array_fields ) )
                ),
                "click_call"   => array(
                    "property" => &$this->click_call,
                    "color"    => "255,103,2",
                    "label"    => system_showText(LANG_LABEL_CLICKTOCALL),
                    "enabled"  => $array_fields && ( TWILIO_APP_ENABLED == "on" && TWILIO_APP_ENABLED_SMS  == "on" && in_array( $this->item->getNumber("level"), system_retrieveLevelsWithInfoEnabled("has_sms") ) )
                ),
                "detail_view"  => array(
                    "property" => &$this->detail,
                    "color"    => "39,174,96",
                    "label"    => system_showText(LANG_LABEL_ADVERTISE_DETAILVIEW),
                    "enabled"  => $array_fields && ( $levelObj && $levelObj->getDetail( $this->item->getNumber("level") ) == "y" )
                ),
                "email_sent"   => array(
                    "property" => &$this->email,
                    "color"    => "106,176,222",
                    "label"    => system_showText(LANG_LABEL_LEADS),
                    "enabled"  => $array_fields && ( in_array( "email", $array_fields ) || in_array( "contact_email", $array_fields ) )
                ),
                "fax_view"     => array(
                    "property" => &$this->fax,
                    "color"    => "217,83,79",
                    "label"    => system_showText(LANG_LABEL_FAXVIEWS),
                    "enabled"  => $array_fields && ( in_array( "fax"  , $array_fields ) )
                ),
                "phone_view"   => array(
                    "property" => &$this->phone,
                    "color"    => "26,188,156",
                    "label"    => system_showText(LANG_LABEL_PHONEVIEWS),
                    "enabled"  => $array_fields && ( in_array( "phone", $array_fields ) || in_array( "contact_phone", $array_fields ) )
                ),
                "send_phone"   => array(
                    "property" => &$this->sms,
                    "color"    => "50,209,117",
                    "label"    => system_showText(LANG_LABEL_SENDPHONE),
                    "enabled"  => $array_fields && ( TWILIO_APP_ENABLED == "on" && TWILIO_APP_ENABLED_CALL == "on" && in_array( $this->item->getNumber("level"), system_retrieveLevelsWithInfoEnabled("has_call") ) )
                ),
                "summary_view" => array(
                    "property" => &$this->summary,
                    "color"    => "211,84,0",
                    "label"    => system_showText(LANG_LABEL_ADVERTISE_SUMMARYVIEW),
                    "enabled"  => true
                ),
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
                 .      "SUM(summary_view) AS summary, "
                 .      "SUM(detail_view) AS detail, "
                 .      "SUM(click_thru) AS click, "
                 .      "SUM(email_sent) AS email, "
                 .      "SUM(phone_view) AS phone, "
                 .      "SUM(fax_view) AS fax, "
                 .      "SUM(send_phone) AS sms, "
                 .      "SUM(click_call) AS click_call "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "{$timeRangeClause} "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY year, month";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->click[$row['year']][$row['month']]       += $row['click'];
                $this->click_call[$row['year']][$row['month']]  += $row['click_call'];
                $this->detail[$row['year']][$row['month']]      += $row['detail'];
                $this->email[$row['year']][$row['month']]       += $row['email'];
                $this->fax[$row['year']][$row['month']]         += $row['fax'];
                $this->phone[$row['year']][$row['month']]       += $row['phone'];
                $this->sms[$row['year']][$row['month']]         += $row['sms'];
                $this->summary[$row['year']][$row['month']]     += $row['summary'];
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
                 .      "SUM(summary_view) AS summary, "
                 .      "SUM(detail_view) AS detail, "
                 .      "SUM(click_thru) AS click, "
                 .      "SUM(email_sent) AS email, "
                 .      "SUM(phone_view) AS phone, "
                 .      "SUM(fax_view) AS fax, "
                 .      "SUM(send_phone) AS sms, "
                 .      "SUM(click_call) AS click_call "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "{$timeRangeClause} "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY year, month";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->click[$row['year']][$row['month']] += $row['click'];
                $this->click_call[$row['year']][$row['month']] += $row['click_call'];
                $this->detail[$row['year']][$row['month']] += $row['detail'];
                $this->email[$row['year']][$row['month']] += $row['email'];
                $this->fax[$row['year']][$row['month']] += $row['fax'];
                $this->phone[$row['year']][$row['month']] += $row['phone'];
                $this->sms[$row['year']][$row['month']] += $row['sms'];
                $this->summary[$row['year']][$row['month']] += $row['summary'];
            }
        }

        public function retrieveCurrentMonth( )
        {
            $table = static::$itemDailyTable;
            $field = static::$itemField;

            $sql =  "SELECT "
                 .      "MONTH(day) AS month, "
                 .      "DAY(day)   AS day, "
                 .      "summary_view AS summary, "
                 .      "detail_view AS detail, "
                 .      "click_thru AS click, "
                 .      "email_sent AS email, "
                 .      "phone_view AS phone, "
                 .      "fax_view AS fax, "
                 .      "send_phone AS sms, "
                 .      "click_call AS click_call "
                 .  "FROM {$table} "
                 .  "WHERE "
                 .      "`{$field}` = {$this->itemId} "
                 .  "GROUP BY month, day";

            $result = static::$dataBase->query( $sql );

            while ( $row = mysql_fetch_array( $result ) )
            {
                $this->click[$row['month']][$row['day']] += $row['click'];
                $this->click_call[$row['month']][$row['day']] += $row['click_call'];
                $this->detail[$row['month']][$row['day']] += $row['detail'];
                $this->email[$row['month']][$row['day']] += $row['email'];
                $this->fax[$row['month']][$row['day']] += $row['fax'];
                $this->phone[$row['month']][$row['day']] += $row['phone'];
                $this->sms[$row['month']][$row['day']] += $row['sms'];
                $this->summary[$row['month']][$row['day']] += $row['summary'];
            }
        }
        
    }
