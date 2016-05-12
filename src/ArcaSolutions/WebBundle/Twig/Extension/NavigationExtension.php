<?php

namespace ArcaSolutions\WebBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class NavigationExtension extends \Twig_Extension
{
    /**
     * ContainerInterface
     *
     * @var object
     */
    protected $container;

    /**
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('navigationHeader', [$this, 'navigationHeader'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('navigationFooter', [$this, 'navigationFooter'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ])
        ];
    }

    /**
     * Render header navigation view
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @return string
     */
    public function navigationHeader(\Twig_Environment $twig_Environment)
    {
        $items = $this->container->get('navigation.handler')->getHeader();

        // doesn't have items
        if (false === $items) {
            return '';
        }

        return $twig_Environment->render('::blocks/navigation/header-navigation.html.twig',
            array(
                'items' => $items
            ));
    }

    /**
     * Render footer navigation view
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @return string
     */
    public function navigationFooter(\Twig_Environment $twig_Environment)
    {
        $items = $this->container->get('navigation.handler')->getFooter();

        // doesn't have items
        if (false === $items) {
            return '';
        }

        return $twig_Environment->render('::blocks/navigation/footer-navigation.html.twig',
            array(
                'items' => $items
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'navigation_front';
    }
}
