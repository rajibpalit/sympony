<?php

namespace ArcaSolutions\WebBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class DayNameExtension extends \Twig_Extension
{
    /**
     * ContainerInterface
     */
    protected $container;
    /**
     * @var array
     */
    private $day_name = [];

    /**
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->init();
    }

    /**
     * Translates Days name
     *
     * @return void
     */
    private function init()
    {
        $array_names = [
            $this->container->get('translator')->trans('Sunday'),
            $this->container->get('translator')->trans('Monday'),
            $this->container->get('translator')->trans('Tuesday'),
            $this->container->get('translator')->trans('Wednesday'),
            $this->container->get('translator')->trans('Thursday'),
            $this->container->get('translator')->trans('Friday'),
            $this->container->get('translator')->trans('Saturday')
        ];
        foreach ($array_names as $names) {
            $this->day_name[] = $names;
        }
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('day_name', [$this, 'day_name'], [])
        );
    }

    /**
     * @param int $day_number
     *
     * @return string
     * @throws \Exception
     */
    public function day_name($day_number)
    {
        if ($day_number <= 0 || $day_number > 7) {
            throw new \Exception('You must pass a day number between 1 and 7');
        }

        return $this->day_name[$day_number - 1];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'day_name';
    }
}
