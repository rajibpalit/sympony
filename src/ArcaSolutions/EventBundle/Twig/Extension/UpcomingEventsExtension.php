<?php

namespace ArcaSolutions\EventBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class UpcomingEventsExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('upcomingEvents',[$this,'upcomingEvents'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('upcomingEventsCarousel',[$this,'upcomingEventsCarousel'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
        ];
    }

    /**
     * creating a alias for upcoming Events in front, just render event calendar view
     *
     * @param \Twig_Environment $twig_Environment
     * @param int $limit Limit of success
     *
     * @return string
     */
    public function upcomingEvents(\Twig_Environment $twig_Environment, $limit = 5)
    {
        if (!$this->container->get('modules')->isModuleAvailable('event')) {
            return '';
        }

        $this->container->get('javascripthandler')
            ->addJSExternalFile('assets/js/modules/event/upcoming/event.upcoming.js')
            ->addJSExternalFile('assets/js/modules/event/upcoming/upcoming.auto.js');

        return $twig_Environment->render('::blocks/event-upcoming-widget.html.twig', [
            'limit'      => $limit,
            'dateFilter' => $this->container->get('filter.date')
        ]);
    }

    /**
     * @param \Twig_Environment $twig_Environment
     * @param int $days_limit Total of days in carousel
     *
     * @return string
     */
    public function upcomingEventsCarousel(\Twig_Environment $twig_Environment, $days_limit = 10)
    {
        if (!$this->container->get('modules')->isModuleAvailable('event')) {
            return '';
        }

        $today = new \DateTime('now');

        $days = $this->container->get('event.api.service')->getDaysWithEventsInAnYear($today->format('Y'), $days_limit);

        /* get, at maximum, the next year to search event */
        if (count($days) < $days_limit) {
            $new = $this->container->get('event.api.service')->getDaysWithEventsInAnYear($today->modify('+1 year')
                ->format('Y'), $days_limit - count($days));
            $days = array_merge($days, $new);
        }

        /* if none event were found, returns nothing. This usually happens in the beginning */
        if (0 == count($days)) {
            return '';
        }

        /* adds js */
        $this->container->get('javascripthandler')
            ->addJSExternalFile('assets/js/modules/event/upcoming/underscore-min.js')
            ->addJSExternalFile('assets/js/lib/owl-carousel/owl.carousel.min.js')
            ->addJSExternalFile('assets/js/modules/event/upcoming/event.upcoming.js')
            ->addJSExternalFile('assets/js/modules/event/upcoming/upcoming.calendar.js');

        return $twig_Environment->render('::blocks/event-upcoming-widget-carousel.html.twig', [
            'days' => $days
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'event_upcoming';
    }
}
