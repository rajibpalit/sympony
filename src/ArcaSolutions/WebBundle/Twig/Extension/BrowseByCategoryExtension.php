<?php

namespace ArcaSolutions\WebBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BrowseByCategoryExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('browseByCategory',[$this,'browseByCategory'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByCategoryListing',[$this,'browseByCategoryListing'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByCategoryEvent',[$this,'browseByCategoryEvent'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByCategoryArticle',[$this,'browseByCategoryArticle'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByCategoryClassified',[$this,'browseByCategoryClassified'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new \Twig_SimpleFunction('browseByCategoryBlog',[$this,'browseByCategoryBlog'],[
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
        ];
    }

    /**
     * Render BrowseByCategory's block used in many pages, like homepage
     *
     * Twig:
     * <code>
     * browseByCategory('listing')
     * browseByCategory('event')
     * browseByCategory('classified')
     * browseByCategory('blog')
     * browseByCategory('article')
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     * @param null $module
     *
     * @param null $limit
     *
     * @return string
     * @throws \Exception
     */
    public function browseByCategory(\Twig_Environment $twig_Environment, $module = null, $limit = null)
    {
        $return = "";
        $categories = $this->getCategoriesByModule($module, $limit);

        if ($categories["featured"] or $categories["regular"]) {
            $return = $twig_Environment->render(
                '::blocks/browse-by-category.html.twig',
                [
                    'all'                  => $module . '_allcategories',
                    'categories'           => $categories,
                    "activeItemsNameField" => $categories["activeItemsNameField"],
                ]
            );
        }

        return $return;
    }

    /**
     * Alias function of browseByCategory for Listing module
     *
     * Twig:
     * <code>
     * browseByCategoryListing()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     *
     * @return string
     */
    public function browseByCategoryListing(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByCategory($twig_Environment, 'listing');
    }

    /**
     * Alias function of browseByCategory for Event module
     *
     * Twig:
     * <code>
     * browseByCategoryEvent()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     *
     * @return string
     */
    public function browseByCategoryEvent(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByCategory($twig_Environment, 'event', $limit);
    }

    /**
     * Alias function of browseByCategory for Classified module
     *
     * Twig:
     * <code>
     * browseByCategoryClassified()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     *
     * @return string
     */
    public function browseByCategoryClassified(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByCategory($twig_Environment, 'classified', $limit);
    }

    /**
     * Alias function of browseByCategory for Article module
     *
     * Twig:
     * <code>
     * browseByCategoryArticle()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     *
     * @return string
     */
    public function browseByCategoryArticle(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByCategory($twig_Environment, 'article', $limit);
    }

    /**
     * Alias function of browseByCategory for Blog module
     *
     * Twig:
     * <code>
     * browseByCategoryBlog()
     * </code>
     *
     * @param \Twig_Environment $twig_Environment
     *
     * @param null $limit
     *
     * @return string
     */
    public function browseByCategoryBlog(\Twig_Environment $twig_Environment, $limit = null)
    {
        return $this->browseByCategory($twig_Environment, 'blog', $limit);
    }

    /**
     * Get parents module's categories
     *
     * @param null $module
     *
     * @param null $limit
     *
     * @return Array
     * @throws \Exception
     */
    private function getCategoriesByModule($module = null, $limit = null)
    {
        if (is_null($module)) {
            throw new \Exception('Module cannot be null');
        }

        $repository = null;
        $doctrine = $this->container->get('doctrine');

        switch ($module) {
            case 'article':
                $repository = $doctrine->getRepository('ArticleBundle:Articlecategory');
                break;
            case 'blog':
                $repository = $doctrine->getRepository('BlogBundle:Blogcategory');
                break;
            case 'classified':
                $repository = $doctrine->getRepository('ClassifiedBundle:Classifiedcategory');
                break;
            case 'event':
                $repository = $doctrine->getRepository('EventBundle:Eventcategory');
                break;
            case 'listing':
                $repository = $doctrine->getRepository('ListingBundle:ListingCategory');
                break;
            default:
                throw new \Exception('No category\'s entity found.');
        }

        $return = [
            "featured"             => $repository->getParentCategories($limit),
            "regular"              => $repository->getParentCategories($limit, false),
            "activeItemsNameField" => $repository->getActiveItemsNameField(),
        ];

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'browse_by_category';
    }
}
