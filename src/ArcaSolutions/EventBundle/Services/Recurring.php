<?php
namespace ArcaSolutions\EventBundle\Services;

use ArcaSolutions\EventBundle\Entity\Event;

class Recurring
{
    /**
     * Array of week name days
     *
     * @var array
     */
    protected $weekdays
        = array(
            1 => 'SU',
            2 => 'MO',
            3 => 'TU',
            4 => 'WE',
            5 => 'TH',
            6 => 'FR',
            7 => 'SA'
        );

    /**
     * It filters recurring events by occurrences
     *
     * @param array(Event) $events
     * @param \DateTime $date
     *
     * @return array
     * @throws \Exception
     */
    public function filterRecurringItems($events, \DateTime $date)
    {
        if (!is_array($events)) {
            throw new \Exception('You must pass an array of events.');
        }

        /*
         * Creates a interval to calculate recurrence following the rules.
         *
         * It substitute startDate of an event to avoid calculate
         * unnecessary dates to compare.
         *
         * If a event's startDate started five years ago, depending on
         * the rules, it will generate hundred of unnecessary dates.
         * @todo Rever lógica com o Fake do start date
         */
        //$date_start = strtotime('-1 month');
        //$date_start = new \DateTime(date('Y-m-d', $date_start));

        foreach ($events as $key => $event) {
            if ('Y' != $event->getRecurring()) {
                continue;
            }

            $whenExtended = new WhenExtended();
            $whenExtended->startDate($date);

            $rule = $this->getRule($event, $date);
            $whenExtended->rrule($rule);

            $whenExtended->generateOccurrences();

            $entered = 0;
            foreach ($whenExtended->occurrences as $occur) {
                // occurrence found
                if ($occur == $date) {
                    $entered = 1;
                    break;
                }

                // occurrence not found
                if ($occur > $date) {
                    break;
                }
            }

            if (1 == $entered) {
                continue;
            }

            unset($events[$key]);
        }

        // reorder array
        return array_values($events);
    }

    /**
     * Build rule to generate occurrences
     *
     * @param Event $event
     *
     * @param \DateTime $date
     *
     * @return string
     * @throws \Exception
     */
    private function getRule(Event $event, \DateTime $date)
    {
        $rule = array();

        /*
         * Control variables of each situation
         * Makes code more easier to understand
         */
        $isYearly = $this->isYearly($event);
        $isMonthly = $this->isMonthly($event);
        $isWeekly = $this->isWeekly($event);
        $isDaily = $this->isDaily($event);

        /*
         * Yearly rules
         */
        if ($isYearly) {
            $rule[] = 'FREQ=YEARLY';
            $rule[] = 'BYMONTH=' . $event->getMonth();
        }

        /*
         * Monthly rule
         */
        if ($isMonthly) {
            $rule[] = 'FREQ=MONTHLY';
        }

        /*
         * Weekly rule
         */
        if ($isWeekly) {
            $rule[] = 'FREQ=WEEKLY';
        }

        /*
         * Daily rule
         */
        if ($isDaily) {
            $rule[] = 'FREQ=DAILY';
        }

        /* general rules */

        /*
         * Sets week number
         * Used to set first, second, third, fourth and fifth week in a month
         */
        if ($isYearly || $isMonthly) {
            /* Use clone to avoid changing of the object inside the function */
            $weekRecurrence = $this->getWeekRecurrence($event, clone $date);
            if ($event->getWeek() && $weekRecurrence) {
                $rule[] = 'BYWEEKNO=' . $weekRecurrence;
            }
        }

        /*
         * Sets a month's day
         */
        if ($event->getDay() && ($isYearly || $isMonthly)) {
            $rule[] = 'BYMONTHDAY=' . $event->getDay();
        }

        /*
         * Adds week name days (SU,MO,TH,...)
         */
        if ($event->getDayofweek() && ($isYearly || $isMonthly || $isWeekly)) {
            $rule[] = 'BYDAY=' . $this->translateDayOfWeekFromNumberToString($event->getDayofweek());
        }

        /*
         * Checks if untilDate is a valid date.
         * Because of doctrine, UntilDate will always be a \DateTime object
         */
        if (checkdate(
            $event->getUntilDate()->format('m'),
            $event->getUntilDate()->format('d'),
            $event->getUntilDate()->format('y')
        )) {
            $rule[] = 'UNTIL=' . $event->getUntilDate()->format('YmdHis');
        }

        /* sets limit */
        $rule[] = 'COUNT=35';

        /* return format */

        return implode(';', $rule);
    }

    /**
     * Checks if a event is yearly
     *
     * @param Event $event
     *
     * @return bool
     */
    public function isYearly(Event $event)
    {
        return 0 != $event->getMonth();
    }

    /**
     * Checks if a event is monthly
     *
     * Note:
     * It is used to cover the possibility of a monthly recurrence in a certain day
     * The flags used in DB is different of a normal monthly recurrence,
     * so it is needed verify other things
     *
     * @param Event $event
     *
     * @return bool
     */
    public function isMonthly(Event $event)
    {
        return (0 == $event->getMonth() && '' != $event->getWeek())
        || (!$this->isDaily($event)
            && !$this->isWeekly($event)
            && !$this->isYearly($event));
    }

    /**
     * Checks if a event is daily
     *
     * @param Event $event
     *
     * @return bool
     */
    public function isDaily(Event $event)
    {
        return 0 == $event->getMonth() && '' == $event->getWeek() && '' == $event->getDayofweek()
        && 0 == $event->getDay();
    }

    /**
     * Checks if a event is weekly
     *
     * @param Event $event
     *
     * @return bool
     */
    public function isWeekly(Event $event)
    {
        return 0 == $event->getMonth() && '' == $event->getWeek() && '' != $event->getDayofweek();
    }

    /**
     * Translates the week order inside the month in week number in the year
     * PHP just understands the week number of the year
     *
     * @param Event $event
     * @param \DateTime $date
     *
     * @return string
     */
    private function getWeekRecurrence(Event $event, \DateTime $date)
    {
        $firstWeekOnMonth = date('W', mktime(0, 0, 0, $date->format('m'), 1, $date->format('Y')));
        $week_sequence = $event->getWeek();

        // it was selected the option 'last week'
        if (false !== strpos($event->getWeek(), '5')) {
            $date->modify('last day of this month');
            // check if the last week of the month is the fourth or fifth week
            if (4 == ($date->format('W') - $firstWeekOnMonth - 1)) {
                $week_sequence = str_replace('5', '4', $week_sequence);
            }
        }

        $week_sequence = explode(',', $week_sequence);
        $week_number = array();
        foreach ($week_sequence as $week) {
            /*
             * Using max() and mod to solve a possible bug when the first week of the year is not 1.
             * E.g: The first week of 2016 is 53, instead of 1.
             * The mod will return 0 when the week number is 54, so we turn it into 1 because the
             * first number week is 1
             */
            $week_number[] = max([($firstWeekOnMonth + (int)$week - 1) % 54, 1]);
        }

        return implode(',', $week_number);
    }

    /**
     * Translate the numeric representation of the day if the week in string
     *
     * @param string $numbers
     *
     * @return string
     * @throws \Exception
     */
    private function translateDayOfWeekFromNumberToString($numbers = '')
    {
        if (!is_string($numbers)) {
            throw new \Exception('You must pass a string.');
        }

        $daysname = array();

        for ($i = 1; $i <= 7; $i++) {
            if (preg_match('/(' . $i . ')/', $numbers)) {
                $daysname[] = $this->weekdays[$i];
            }
        }

        return implode(',', $daysname);
    }
}
