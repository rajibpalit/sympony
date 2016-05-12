<?php
namespace ArcaSolutions\WebBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class UserExtension
 *
 * @package ArcaSolutions\WebBundle\Twig\Extension
 */
final class UserExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * UserExtension constructor.
     *
     * @param RequestStack $request
     * @param ContainerInterface $container
     */
    public function __construct(RequestStack $request, ContainerInterface $container)
    {
        $this->request = $request;
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('loginNavBar', [$this, 'loginNavBar'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('getUser', [$this, 'getUser'])
        ];
    }

    /**
     * Returns login navbar, checking user credentials
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @return string
     */
    public function loginNavBar(\Twig_Environment $twig_Environment)
    {
        $user = $this->container->get('user')->getUser();

        return $twig_Environment->render('::blocks/login/navbar.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Checks if user is logged or not
     *
     * @return \ArcaSolutions\WebBundle\Entity\Accountprofilecontact|false
     */
    public function getUser()
    {
        return $this->container->get('user')->getUser();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'login_nav_bar';
    }
}
