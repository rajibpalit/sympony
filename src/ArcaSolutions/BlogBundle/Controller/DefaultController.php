<?php

namespace ArcaSolutions\BlogBundle\Controller;

use ArcaSolutions\BlogBundle\BlogItemDetail;
use ArcaSolutions\BlogBundle\Entity\Blogcategory;
use ArcaSolutions\BlogBundle\Entity\Post;
use ArcaSolutions\CoreBundle\Exception\ItemNotFoundException;
use ArcaSolutions\CoreBundle\Exception\UnavailableItemException;
use ArcaSolutions\CoreBundle\Services\ValidationDetail;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::modules/blog/index.html.twig', array(
            'title' => 'Blog'
        ));
    }

    /**
     * @param $friendlyUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws UnavailableItemException
     * @throws \Exception
     */
    public function detailAction($friendlyUrl)
    {
        /*
         * Validation
         */
        /* @var $item Post For phpstorm get properties of entity Listing */
        $item = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, 'blog', 'BlogBundle:Post');
        /* event not found by friendlyURL */
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        /* normalizes item to validate detail */
        $blogItemDetail = new BlogItemDetail($this->container, $item);

        /* validating if listing is enabled, if listing's level is active and if level allows detail */
        if (!ValidationDetail::isDetailAllowed($blogItemDetail)) {
            /* error page */
            throw new UnavailableItemException();
        }

        /*
         * Report
         */
        /* Counts the view towards the statistics */
        $this->container->get("reporthandler")->addPostReport($item->getId(), ReportHandler::POST_DETAIL);

        return $this->render('::modules/blog/detail.html.twig', array(
            'item'       => $item,
            'categories' => $item->getCategories(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allcategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('BlogBundle:Blogcategory')
            ->getAllParent();

        usort($categories, function($a, $b){
            /* @var $a Blogcategory */
            /* @var $b BlogCategory */
            return strcmp($a->getTitle(), $b->getTitle() );
        });

        $data = array(
            'categories' => $categories,
            'routing'    => $this->get("search.engine")->getModuleAlias("blog"),
        );

        $response = $this->render('::modules/blog/all-categories.html.twig', $data);
        return $response;
    }
}
