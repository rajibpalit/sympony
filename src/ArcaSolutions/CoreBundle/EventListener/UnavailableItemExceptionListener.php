<?php

namespace ArcaSolutions\CoreBundle\EventListener;

use ArcaSolutions\CoreBundle\Exception\UnavailableItemException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class UnavailableItemExceptionListener
 *
 * @package ArcaSolutions\CoreBundle\EventListener
 */
class UnavailableItemExceptionListener
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
     * @param Kernel             $kernel
     */
    public function __construct(ContainerInterface $container, Kernel $kernel)
    {
        $this->container = $container;
        $this->kernel = $kernel;
    }

    /**
     * Exclusive exception for UnavailableItemException
     * Called when UnavailableItemException is triggered
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!($exception instanceof UnavailableItemException)) {
            return;
        }

        if (!('prod' == $this->kernel->getEnvironment())) {
            return;
        }

        $response = new Response();

        $response->setContent(
            $this->container->get('twig')->render('::pages/error-unavailable-item.html.twig', [])
        );

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
