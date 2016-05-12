<?php

namespace ArcaSolutions\EventBundle\Controller;

use ArcaSolutions\EventBundle\Entity\Event;
use Doctrine\Common\Cache\ApcCache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    /**
     * Return the calendar's html
     *
     * @param null $month
     * @param null $year
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function calendarAction($month = null, $year = null)
    {
        if (!checkdate($month, 1, $year)) {
            throw new \Exception('You must pass a valid date');
        }

        $currentMonthTimestamp = mktime(0, 0, 0, $month, 1, $year);
        $firstDay = 'Sunday';

        return $this->render('::modules/event/event-calendar.html.twig', [
            'days_name'    => $this->getWeekDaysName($firstDay, '%a'),
            'calendar'     => $this->buildCalendarArray(
                (int)date('t', $currentMonthTimestamp),
                strftime('%a', $currentMonthTimestamp),
                $this->getWeekDaysName($firstDay),
                $month,
                $year
            ),
            'month_name'   => strftime('%B', $currentMonthTimestamp),
            'year'         => $year,
            'month_number' => $month,
        ]);
    }

    /**
     * Get the name of all days in a week
     *
     * @param string $firstDay Name of the day that week starts
     * @param string $format Format of the name, like: Mon or Monday
     *
     * @return array
     */
    private function getWeekDaysName($firstDay = 'Sunday', $format = '%a')
    {
        $timestamp = strtotime('next '.$firstDay);
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $days[] = strftime($format, $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }

        return $days;
    }

    /**
     * Build a calendar and return it an array
     *
     * @param null $daysMonth Total of the days in month
     * @param null $first_day Name of the first day of the month
     * @param array $daysName Name of all days in a week
     * @param null $month Number month
     * @param null $year
     *
     * @return array
     */
    private function buildCalendarArray(
        $daysMonth = null,
        $first_day = null,
        $daysName = [],
        $month = null,
        $year = null
    ) {
        $calendar = [];
        $weeks = 0;
        $day = 1;

        while ($day <= $daysMonth) {
            for ($i = 0; $i < 7; $i++) {
                if ($day == 1 && $first_day == $daysName[$i]) {
                    $calendar[$weeks][$i] = [
                        'number' => $day,
                        'route'  => $this->dayURLRoute($day, $month, $year),
                    ];
                    $day++;
                } elseif ($day == 1 || $day > $daysMonth) {
                    $calendar[$weeks][$i] = [
                        'number' => ' ',
                        'route'  => '',
                    ];
                } else {
                    $calendar[$weeks][$i] = [
                        'number' => $day,
                        'route'  => $this->dayURLRoute($day, $month, $year),
                    ];
                    $day++;
                }
            }
            $weeks++;
        }

        return $calendar;
    }

    /**
     * Return search event URL with day filter in it
     * Date format: Y-m-d
     *
     * @param null $day
     * @param null $month
     * @param null $year
     *
     * @return string
     */
    private function dayURLRoute($day = null, $month = null, $year = null)
    {
        $date = \DateTime::createFromFormat('Y-m-d',
            sprintf('%d-%d-%d', $year, $month, $day));

        return $this->container->get('router')->generate('global_search_0',
            ['start_date' => $date->format('Y-m-d')]);
    }

    /**
     * @param null $day
     * @param null $month
     * @param null $year
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function upcomingAction($day = null, $month = null, $year = null)
    {
        if (!checkdate($month, $day, $year)) {
            throw new \Exception('You must pass a valid date');
        }

        /* creates date */
        $date = \DateTime::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $year, $month, $day));

        /* Cache APC */
        $cacheDriver = $this->get('apccache.edirectory.service');

        $key = '_upcoming_'.$date->format('Ymd');

        if (!$cacheDriver->contains($key)) {
            /* It doesn't have cache */
            $events = $this->get('doctrine')->getRepository('EventBundle:Event')->upcomingEvents($date);

            /* removes hour,minutes and seconds to compare */
            $date = new \DateTime(date('Y-m-d', $date->getTimestamp()));
            $events = $this->get('event.recurring.service')->filterRecurringItems($events, $date);

            /* Vars used to get the image's URL */
            $imageExtension = $this->get('twig')->getExtension('image_extension');
            $twigEnvironment = $this->get('twig');

            $json = [
                'day'      => $date->format('d'),
                'month'    => $this->get('twig')->getExtension('localized_date')
                    ->localized_date($twigEnvironment, $date, 'MMMM'),
                'day_name' => $this->get('twig')->getExtension('localized_date')
                    ->localized_date($twigEnvironment, $date, 'EEE'),
                'events'   => [],
            ];

            if ($events) {
                foreach ($events as $event) {
                    /* @var $event Event */
                    $image = '';
                    /* get image path, if it has */
                    if ($event->getImageId() > 0) {
                        $image = $this->container->get('assets.packages')->getPackage('domain_images')->getUrl('')
                            .$imageExtension->getPath($event->getImage());
                        $image = $this->container->get('liip_imagine.cache.manager')->getBrowserPath($image, 'small');
                    }

                    /* creates categories's array with title and link */
                    $cat_array = [];
                    foreach ($event->getCategories() as $cat) {
                        $cat_array[] = [
                            'title' => $cat->getTitle(),
                            'link'  => $this->generateUrl('event_homepage').$cat->getFriendlyUrl(),
                        ];
                    }

                    $json['events'][] = [
                        'id'          => $event->getId(),
                        'link'        => $this->generateUrl('event_detail',
                            ['friendlyUrl' => $event->getFriendlyUrl(), '_format' => 'html']),
                        'image'       => $image,
                        'title'       => $event->getTitle(),
                        'description' => $event->getDescription(),
                        'location'    => $event->getLocation(),
                        'categories'  => $cat_array,
                        'day'         => $json['day'],
                        'month'       => $json['month'],
                    ];
                }

                /* make cache */
                $cacheDriver->save($key, $json);
            }
        } else {
            /* it has cache */
            $json = $cacheDriver->fetch($key);
        }

        return JsonResponse::create($json);
    }
}
