<?php
namespace ArcaSolutions\ListingBundle\Twig\Extension;

use ArcaSolutions\ListingBundle\Entity\ListingCategory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BlocksExtension
 *
 * @package ArcaSolutions\ListingBundle\Twig\Extension
 */
class BlocksExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('featuredListing', [$this, 'featuredListing'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('bestOfListing', [$this, 'bestOfListing'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ])
        ];
    }

    /**
     * @param \Twig_Environment $twig_Environment
     * @param int $quantity
     * @param string $class
     * @param string $grid
     *
     * @return string
     */
    public function featuredListing(\Twig_Environment $twig_Environment, $quantity = 4, $class = '', $grid = 'vertical')
    {
        $items = $this->container->get('search.block')->getFeatured('listing', $quantity);

        if (!$items) {
            return '';
        }

        return $twig_Environment->render('::modules/listing/blocks/featured.html.twig', [
            'items' => $items,
            'class' => $class,
            'grid'  => $grid
        ]);
    }

    /**
     * @param \Twig_Environment $twig_Environment
     * @param int $categories_quantity
     * @param int $quantity
     * @param string $class
     * @param string $grid
     *
     * @return string
     */
    public function bestOfListing(
        \Twig_Environment $twig_Environment,
        $categories_quantity = 1,
        $quantity = 4,
        $class = '',
        $grid = 'vertical'
    ) {
        $categories = $this->container->get('doctrine')->getRepository('ListingBundle:ListingCategory')
            ->getBestOfCategories();

        shuffle($categories);

        $searchBlock = $this->container->get('search.block');
        $items = [];
        $count = 0;

        while ($count < $categories_quantity && count($categories)) {
            $category = array_pop($categories);
            if ($content = $searchBlock->getBestOf('listing', $quantity, $category->getId())) {
                /* @var $category ListingCategory */
                $items[] = [
                    'category' => $category,
                    'items'    => $content
                ];
                $count++;
            }
        }

        return $items ? $twig_Environment->render('::modules/listing/blocks/bestof.html.twig', [
            'items' => $items,
            'class' => $class,
            'grid'  => $grid
        ]) : "";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'blocks_listing';
    }
}
