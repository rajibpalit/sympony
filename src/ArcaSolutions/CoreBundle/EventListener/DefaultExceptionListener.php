<?php

namespace ArcaSolutions\CoreBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class DefaultExceptionListener
 *
 * @package ArcaSolutions\CoreBundle\EventListener
 */
class DefaultExceptionListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * UnavailableItemExceptionListener constructor.
     *
     * @param ContainerInterface $container
     * @param Kernel $kernel
     */
    public function __construct(ContainerInterface $container, Kernel $kernel)
    {
        $this->container = $container;
        $this->kernel = $kernel;
    }

    /**
     * Sets response with custom error page
     * Every exception that is not handled before will drop here and finish with default error page
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        /*
         * Saves error messages in log files
         * It helps with debug
         */
        $logger = $this->container->get('logger');
        $logger->crit($exception->getMessage());

        if (!('prod' == $this->kernel->getEnvironment())) {
            return;
        }

        $response = new Response($this->container->get('twig')->render(':pages:error.html.twig'));

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
