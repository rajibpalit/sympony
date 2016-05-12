<?php

namespace ArcaSolutions\EventBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class EventCalendarExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('eventCalendar',[$this,'eventCalendar'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
        ];
    }

    /**
     * creating a alias for Event calendar in front, just render event calendar view
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @return string
     */
    public function eventCalendar(\Twig_Environment $twig_Environment)
    {
        return $twig_Environment->render('::blocks/event-calendar-widget.html.twig', array());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'event_calendar';
    }
}
