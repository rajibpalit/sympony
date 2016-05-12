<?php

namespace ArcaSolutions\WebBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BrowseByLocationExtension extends \Twig_Extension
{
    /**
     * ContainerInterface
     *
     * @var ContainerInterface
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
            new \Twig_SimpleFunction('browseByLocation',[$this,'browseByLocation'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByLocationListing',[$this,'browseByLocationListing'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByLocationEvent',[$this,'browseByLocationEvent'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByLocationClassified',[$this,'browseByLocationClassified'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByLocationDeal',[$this,'browseByLocationDeal'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
        ];
    }

    /**
     * Alias function of browseByLocation for Listing module
     *
     * Twig:
     * <code>
     * browseByLocationListing()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     * @return string
     */
    public function browseByLocationListing(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByLocation($twig_Environment, 'listing', $limit);
    }

    /**
     * Render BrowseByLocation's block used in many pages, like homepage
     *
     * Twig:
     * <code>
     * browseByLocation('listing')
     * browseByLocation('event')
     * browseByLocation('classified')
     * browseByLocation('deal')
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     * @param null $module
     *
     * @param null $limit
     * @return string
     * @throws \Exception
     */
    public function browseByLocation(\Twig_Environment $twig_Environment, $module = null, $limit = null)
    {
        $locations = $this->getLocationByModule($module, $limit);

        if (count($locations) == 0) {
            return '';
        }

        return $twig_Environment->render('::blocks/browse-by-location.html.twig',
            array(
                'locations' => $locations,
                'module'    => $module,
                'route'     => $module . '_alllocations'
            ));
    }

    /**
     * Get parents module's categories
     *
     * @param null $module
     *
     * @param null $limit
     * @return Array
     * @throws \Exception
     */
    private function getLocationByModule($module = null, $limit = null)
    {
        if (is_null($module)) {
            throw new \Exception('Module cannot be null');
        }

        $level = $this->container->get('doctrine')->getRepository('WebBundle:Setting')->getSetting('explorelocations_level');

        if (!$level) {
            // getting last level saved in domain.configs.yml
            $level = $this->container->get('doctrine')->getRepository('WebBundle:SettingLocation')
                ->getLastLocationEnabledID();
        }

        switch ($module) {
            case 'listing':
                $return = $this->container->get('doctrine')
                    ->getRepository('ListingBundle:ListingLocationcounter')
                    ->setMaxItems($limit)->getFeaturedLocationsByLevel($level);
                break;

            case 'event':
                $return = $this->container->get('doctrine')
                    ->getRepository('EventBundle:EventLocationcounter')
                    ->setMaxItems($limit)->getFeaturedLocationsByLevel($level);
                break;

            case 'classified':
                $return = $this->container->get('doctrine')
                    ->getRepository('ClassifiedBundle:ClassifiedLocationcounter')
                    ->setMaxItems($limit)->getFeaturedLocationsByLevel($level);
                break;

            case 'deal':
                $return = $this->container->get('doctrine')
                    ->getRepository('DealBundle:PromotionLocationcounter')
                    ->setMaxItems($limit)->getFeaturedLocationsByLevel($level);
                break;

            default:
                throw new \Exception('Not location\'s entity found.');
                break;
        }

        usort($return, function($a, $b){
            return strcmp($a["title"], $b["title"]);
        });

        return $return;
    }

    /**
     * Alias function of browseByLocation for Event module
     *
     * Twig:
     * <code>
     * browseByLocationEvent()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     * @return string
     */
    public function browseByLocationEvent(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByLocation($twig_Environment, 'event', $limit);
    }

    /**
     * Alias function of browseByLocation for Classified module
     *
     * Twig:
     * <code>
     * browseByLocationClassified()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     * @return string
     */
    public function browseByLocationClassified(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByLocation($twig_Environment, 'classified', $limit);
    }

    /**
     * Alias function of browseByLocation for Deal module
     *
     * Twig:
     * <code>
     * browseByLocationDeal()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     * @return string
     */
    public function browseByLocationDeal(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByLocation($twig_Environment, 'deal', $limit);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'browse_by_location';
    }
}
