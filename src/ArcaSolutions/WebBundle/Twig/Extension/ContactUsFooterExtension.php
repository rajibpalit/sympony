<?php

namespace ArcaSolutions\WebBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ContactUsFooterExtension extends \Twig_Extension
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
                'contactUs',
                [$this, 'contactUs'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    /**
     * @param \Twig_Environment $twig_Environment
     *
     * @return string
     */
    public function contactUs(\Twig_Environment $twig_Environment)
    {
        return $twig_Environment->render('::blocks/contactus.html.twig',
            [
                'twitter'    => $this->container->get('settings')->getDomainSetting('twitter_account'),
                'facebook'   => $this->container->get('settings')->getDomainSetting('setting_facebook_link'),
                'linkedin'   => $this->container->get('settings')->getDomainSetting('setting_linkedin_link'),
                'instagram'  => $this->container->get('settings')->getDomainSetting('setting_instagram_link'),
                'googleplus' => $this->container->get('settings')->getDomainSetting('setting_googleplus_link'),
                'pinterest'  => $this->container->get('settings')->getDomainSetting('setting_pinterest_link'),
                'address'    => $this->container->get('settings')->getDomainSetting('contact_address'),
                'zipcode'    => $this->container->get('settings')->getDomainSetting('contact_zipcode'),
                'country'    => $this->container->get('settings')->getDomainSetting('contact_country'),
                'state'      => $this->container->get('settings')->getDomainSetting('contact_state'),
                'city'       => $this->container->get('settings')->getDomainSetting('contact_city'),
                'phone'      => $this->container->get('settings')->getDomainSetting('contact_phone'),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'contactus';
    }
}
