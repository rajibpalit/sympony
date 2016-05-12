<?php

namespace ArcaSolutions\WebBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class CopyrightExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction(
                'copyright',
                [$this, 'copyright'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    /**
     * @param \Twig_Environment $twig_Environment
     *
     * @return string
     */
    public function copyright(\Twig_Environment $twig_Environment)
    {
        $url = '';
        if ($this->container->get('multi_domain.information')->getBranded() == 'on') {
            $request = Request::createFromGlobals();
            $url = 'http://www.edirectory.com';
            $url .= strpos($request->getUri(), '.com.br') === true ? '.br' : '';
        }

        return $twig_Environment->render(
            '::blocks/copyright.html.twig',
            [
                'copyright_text' => $this->container->get("customtexthandler")->get('footer_copyright'),
                'branded'        => $this->container->get('multi_domain.information')->getBranded(),
                'url_edirectory' => $url
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'copyright';
    }
}
