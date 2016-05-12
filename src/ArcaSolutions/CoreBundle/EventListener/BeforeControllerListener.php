<?php
namespace ArcaSolutions\CoreBundle\EventListener;

use ArcaSolutions\CoreBundle\Controller\MaintenanceController;
use ArcaSolutions\CoreBundle\Services\Settings;
use Symfony\Bundle\AsseticBundle\Controller\AsseticController;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class BeforeControllerListener
 *
 * @package ArcaSolutions\CoreBundle\EventListener
 */
class BeforeControllerListener
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * BeforeControllerListener constructor.
     *
     * @param Container $container
     * @param Settings $settings
     */
    public function __construct(Container $container, Settings $settings)
    {
        $this->container = $container;
        $this->settings = $settings;
    }

    /**
     * Call it before a controller in every request
     *
     * @param FilterControllerEvent $event
     * @return Response|void
     * @throws \Exception
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        $this->validateRoute($event);

        /*
         * Creates image package
         */
        $path = $this->container->get('multi_domain.information')->getPath();
        $packs = $this->container->get('assets.packages');

        $packs->addPackage('profile_images', new PathPackage('custom/profile/', new EmptyVersionStrategy()));
        $packs->addPackage('assets_images', new PathPackage('assets/images/', new EmptyVersionStrategy()));
        $packs->addPackage('domain_images', new PathPackage($path . 'image_files/', new EmptyVersionStrategy()));
        $packs->addPackage('domain_content', new PathPackage($path . 'content_files/', new EmptyVersionStrategy()));
        $packs->addPackage('domain_extrafiles', new PathPackage($path . 'extra_files/', new EmptyVersionStrategy()));

        /*
         * Redirects if maintenance mode is true or sends code 503 if a ajax
         * request, else if the user is in the maintenance screen it is
         * redirected to the home page
         */
        $this->maintenanceMode($controller, $event);

        /*
         * Sets project locale
         */
        $this->setsTimeLocale();

        /*
         * Exits if it is a ajax request
         */
        if ($event->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();

        if ($request->getSession()->get('modal')) {
            $request->getSession()->remove('modal');
            $this->container->get('twig')->addGlobal('openModal', true);
        }
    }

    /**
     * @param FilterControllerEvent $event
     * @return Response
     * @throws \Exception
     */
    private function validateRoute(FilterControllerEvent $event)
    {
        /* gets current route's name */
        $possibly_module_name = explode('_', $event->getRequest()->get('_route'));
        $possibly_module_name = current($possibly_module_name);

        /*
         * If it is not a module, just continue
         * If it is a module, then validate it
         */
        if ($this->container->get('modules')->isModule($possibly_module_name)
            && !$this->container->get('modules')->isModuleAvailable($possibly_module_name)
        ) {
            throw new \Exception('Module disabled');
        }
    }

    /**
     * Verifies if redirect is necessary because of the maintenance mode
     *
     * @param array $controller
     * @param object $event
     *
     * @return Response
     */
    private function maintenanceMode($controller, $event)
    {
        // Gets the parameter of the maintenance
        $maintenance = $this->settings->getDomainSetting('maintenance_mode');
        $redirectUrl = null;

        if ($maintenance == 'on' and !($controller[0] instanceof MaintenanceController or
                $controller[0] instanceof AsseticController)
        ) {
            if ($event->getRequest()->isXmlHttpRequest()) {
                $response = new Response();
                $response->setStatusCode(503);

                return $response->send();
            }

            $redirectUrl = $this->container->get('router')->generate('web_maintenance');
        } elseif ($maintenance == 'off' and $controller[0] instanceof MaintenanceController) {
            $redirectUrl = $this->container->get('router')->generate('web_homepage');
        }

        if (!is_null($redirectUrl)) {
            $event->setController(function () use ($redirectUrl) {
                return new RedirectResponse($redirectUrl);
            });
        }
    }

    /**
     * Sets project locale
     *
     * @return void
     */
    private function setsTimeLocale()
    {
        $settings = $this->container->get('settings')->getDomainSetting('date_timezone');

        date_default_timezone_set($settings ?: 'America/Los_Angeles');

        setlocale(LC_TIME, $this->container->get('multi_domain.information')->getLocale() . '.' . $this->container->getParameter('charset'));
    }
}
