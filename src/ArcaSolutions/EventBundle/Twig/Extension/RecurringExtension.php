<?php

namespace ArcaSolutions\EventBundle\Twig\Extension;

use ArcaSolutions\EventBundle\Entity\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RecurringExtension
 *
 * @package ArcaSolutions\EventBundle\Twig\Extension
 */
class RecurringExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('recurringPhrase',[$this,'recurringPhrase'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
        ];
    }

    /**
     * Returns the phrase of each recurring kind
     *
     * @param \Twig_Environment $twig_Environment
     * @param Event             $event
     *
     * @return string
     * @throws \Exception
     */
    public function recurringPhrase(\Twig_Environment $twig_Environment, Event $event)
    {
        $type = $this->checksTypeOfRecurring(clone $event);
        switch ($type) {
            case 'yearly':
                return $this->yearlyPhrase($twig_Environment, clone $event);
                break;
            case 'monthly':
                return $this->monthlyPhrase($twig_Environment, clone $event);
                break;
            case 'weekly':
                return $this->weeklyPhrase($twig_Environment, clone $event);
                break;
            case 'daily':
                return $this->dailyPhrase($twig_Environment);
                break;
        }

        throw new \Exception('type of Recurring not found.');
    }

    /**
     * Returns the kind of recurring of a event
     *
     * @param Event $event
     *
     * @return string daily|weekly|monthly|yearly
     * @throws \Exception When kind of recurrence is not found
     */
    private function checksTypeOfRecurring(Event $event)
    {
        $eventRecurringService = $this->container->get('event.recurring.service');

        if ($eventRecurringService->isYearly($event)) {
            return 'yearly';
        }

        if ($eventRecurringService->isMonthly($event)) {
            return 'monthly';
        }

        if ($eventRecurringService->isWeekly($event)) {
            return 'weekly';
        }

        if ($eventRecurringService->isDaily($event)) {
            return 'daily';
        }

        throw new \Exception('type of Recurring not found.');
    }

    /**
     * Builds yearly recurring phrase
     *
     * @param \Twig_Environment $twig_Environment
     * @param Event             $event
     *
     * @return string
     */
    private function yearlyPhrase(\Twig_Environment $twig_Environment, Event $event)
    {
        /*
         * It's a yearly event but just happens in a specific day
         */
        if (0 != $event->getDay()) {
            return $twig_Environment->render('::modules/event/recurring/yearly/day.html.twig', [
                'event'    => $event,
                'location' => $this->container->get('request_stack')->getCurrentRequest()->getLocale(),
            ]);
        }

        /*
         * It's a yearly event but can vary in days of week and weeks inside a month
         */
        $days = explode(',', $event->getDayofweek());
        $week_order = explode(',', $event->getWeek());

        /* checks if all days were selected */
        $alldays = 7 == count($days);
        /* checks if Sunday and Saturday were selected */
        $weekend = 2 == count($days) && !array_diff([1, 7], $days);
        /* checks if Monday, Tuesday, Wednesday, Thursday and Friday were selected */
        $businessdays = 5 == count($days) && !array_diff([2, 3, 4, 5, 6], $days);

        return $twig_Environment->render('::modules/event/recurring/yearly/week.html.twig', [
            'event'         => $event,
            'days'          => $days,
            'weeks'         => $week_order,
            'all_days'      => $alldays,
            'weekend'       => $weekend,
            'business_days' => $businessdays
        ]);
    }

    /**
     * Builds monthly recurring phrase
     *
     * @param \Twig_Environment $twig_Environment
     * @param Event             $event
     *
     * @return string
     */
    private function monthlyPhrase(\Twig_Environment $twig_Environment, Event $event)
    {
        /*
         * It's a monthly event but just happens in a specific day
         */
        if (0 != $event->getDay()) {
            return $twig_Environment->render('::modules/event/recurring/monthly/day.html.twig', [
                'event'    => $event,
                'location' => $this->container->get('request_stack')->getCurrentRequest()->getLocale(),
            ]);
        }

        /*
         * It's a monthly event but can vary in days of week and weeks inside a month
         */
        $days = explode(',', $event->getDayofweek());
        $week_order = explode(',', $event->getWeek());

        /* checks if all days were selected */
        $alldays = 7 == count($days);
        /* checks if Sunday and Saturday were selected */
        $weekend = 2 == count($days) && !array_diff([1, 7], $days);
        /* checks if Monday, Tuesday, Wednesday, Thursday and Friday were selected */
        $businessdays = 5 == count($days) && !array_diff([2, 3, 4, 5, 6], $days);

        return $twig_Environment->render('::modules/event/recurring/monthly/week.html.twig', [
            'days'          => $days,
            'weeks'         => $week_order,
            'all_days'      => $alldays,
            'weekend'       => $weekend,
            'business_days' => $businessdays,
            'location'      => $this->container->get('request_stack')->getCurrentRequest()->getLocale(),
        ]);
    }

    /**
     * Builds weekly recurring phrase
     *
     * @param \Twig_Environment $twig_Environment
     * @param Event             $event
     *
     * @return string
     */
    private function weeklyPhrase(\Twig_Environment $twig_Environment, Event $event)
    {
        $days = explode(',', $event->getDayofweek());

        /* checks if all days were selected */
        $alldays = 7 == count($days);
        /* checks if Sunday and Saturday were selected */
        $weekend = 2 == count($days) && !array_diff([1, 7], $days);
        /* checks if Monday, Tuesday, Wednesday, Thursday and Friday were selected */
        $businessdays = 5 == count($days) && !array_diff([2, 3, 4, 5, 6], $days);

        return $twig_Environment->render('::modules/event/recurring/weekly/week.html.twig', [
            'days'          => $days,
            'all_days'      => $alldays,
            'weekend'       => $weekend,
            'business_days' => $businessdays,
        ]);
    }

    /**
     * Builds daily recurring phrase
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @return string
     */
    private function dailyPhrase(\Twig_Environment $twig_Environment)
    {
        return $twig_Environment->render('::modules/event/recurring/daily/day.html.twig',[]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'event_recurring';
    }
}
