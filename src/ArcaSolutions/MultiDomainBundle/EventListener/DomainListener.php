<?php

namespace ArcaSolutions\MultiDomainBundle\EventListener;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DomainListener
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $hostsConfig;

    /**
     * @var string
     */
    private $rootPath;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function onKernelController()
    {
        $this->container->get('liip_theme.active_theme')
            ->setName($this->container->get('multi_domain.information')->getTemplate());

    }
}
