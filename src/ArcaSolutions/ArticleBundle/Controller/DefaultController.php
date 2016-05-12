<?php

namespace ArcaSolutions\ArticleBundle\Controller;

use ArcaSolutions\ArticleBundle\ArticleItemDetail;
use ArcaSolutions\ArticleBundle\Entity\Article;
use ArcaSolutions\ArticleBundle\Entity\Articlecategory;
use ArcaSolutions\CoreBundle\Exception\ItemNotFoundException;
use ArcaSolutions\CoreBundle\Exception\UnavailableItemException;
use ArcaSolutions\CoreBundle\Services\ValidationDetail;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ArcaSolutions\ArticleBundle\Sample\ArticleSample;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::modules/article/index.html.twig', [
            'title' => 'Article Index',
        ]);
    }

    /**
     * @param $friendlyUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws ItemNotFoundException
     * @throws \Exception
     */
    public function detailAction($friendlyUrl)
    {
        /*
         * Validation
         */
        /* @var $item Article For phpstorm get properties of entity Article */
        $item = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, 'article', 'ArticleBundle:Article');
        /* event not found by friendlyURL */
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        /* normalizes item to validate detail */
        $articleItemDetail = new ArticleItemDetail($this->container, $item);

        /* validating if article is enabled, if article's level is active and if level allows detail */
        if (!ValidationDetail::isDetailAllowed($articleItemDetail)) {
            /* error page */
            throw new UnavailableItemException();
        }

        /*
         * Report
         */
        /* Counts the view towards the statistics */
        $this->container->get("reporthandler")->addArticleReport($item->getId(), ReportHandler::ARTICLE_DETAIL);

        /* gets item's gallery */
        $gallery = null;
        if ($articleItemDetail->getLevel()->imageCount > 0) {
            $gallery = $this->get('doctrine')->getRepository('ArticleBundle:Article')
                ->getGallery($item, $articleItemDetail->getLevel()->imageCount);
        }

        /* gets item reviews */
        $reviews = $this->get('doctrine')->getRepository('WebBundle:Review')->findBy([
            'itemType' => 'article',
            'approved' => '1',
            'itemId'   => $item->getId(),
        ], [
            'rating' => 'DESC',
            'added'  => 'DESC',
        ], 3);

        /* Gets total of reviews */
        $reviews_total = $this->get('doctrine')->getRepository('WebBundle:Review')
            ->getTotalByItemId($item->getId(), 'article');

        $reviews_active = $this->getDoctrine()->getRepository('WebBundle:Setting')
            ->getSetting('review_article_enabled');


        /* Gets profile image from main DB */
        if ($account = $item->getAccount()) {
            /* sets profile image manually because doctrine can't make a relationship using tables from another DB  */
            $account->profileImage = $this->get('profile.image.service')->getProfileImage($account);
            $item->setAccount($account);
        }

        return $this->render('::modules/article/detail.html.twig', [
            'item'           => $item,
            'categories'     => $item->getCategories(),
            'gallery'        => $gallery,
            'reviews_active' => $reviews_active,
            'reviews'        => $reviews,
            'reviews_total'  => $reviews_total,
        ]);
    }

    /**
     * @param int $level
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Ivory\GoogleMap\Exception\MapException
     * @throws \Ivory\GoogleMap\Exception\OverlayException
     */
    public function sampleDetailAction($level = 0)
    {
        $item = new ArticleSample($this->get("translator"), $level);
        $articleItemDetail = new ArticleItemDetail($this->container, $item);

        /* Validates if article has the review active */
        $reviews_active = $this->getDoctrine()->getRepository('WebBundle:Setting')
            ->getSetting('review_article_enabled');

        return $this->render('::modules/article/detail.html.twig', [
            'item'           => $item,
            'level'          => $articleItemDetail->getLevel(),
            'gallery'        => $item->getGallery($articleItemDetail->getLevel()->imageCount),
            'reviews_active' => $reviews_active,
            'reviews'        => $item->getReviews(),
            'reviews_total'  => $item->getReviewCount(),
            'categories'     => $item->getCategories(),
            'isSample'       => true
        ]);
    }

    /**
     * @param $friendlyUrl
     * @param $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function reviewAction($friendlyUrl, $page)
    {
        $page = $this->get("search.engine")->convertFromPaginationFormat($page);

        /* Validates if article has the review active */
        $active = $this->getDoctrine()->getRepository('WebBundle:Setting')->getSetting('review_article_enabled');
        if (is_null($active) or $active == '') {
            throw $this->createNotFoundException('Article has not reviews activated');
        }

        /* Gets article and validation if exist */
        /* @var $article Article For phpstorm get properties of entity article */
        $article = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, 'article', 'ArticleBundle:Article');
        if (is_null($article)) {
            throw $this->createNotFoundException('This Article does not exist');
        }

        /* Gets reviews of article */
        $reviews = $this->getDoctrine()
            ->getRepository('WebBundle:Review')
            ->findBy([
                'itemType' => 'article',
                'approved' => 1,
                'itemId'   => $article->getId(),
            ], ['added' => 'DESC']);

        // Creates the pagination to reviews
        $pagination = $this->get('knp_paginator')->paginate($reviews, $page);

        /* Gets total of reviews */
        $reviews_total = $this->get('doctrine')->getRepository('WebBundle:Review')
            ->getTotalByItemId($article->getId(), 'article');

        return $this->render('::pages/reviews.html.twig', [
            'module'        => 'article',
            'review'        => $article,
            'reviews_total' => $reviews_total,
            'pagination'    => $pagination,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allcategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('ArticleBundle:Articlecategory')
            ->getAllParent();

        usort($categories, function($a, $b){
            /* @var $a Articlecategory */
            /* @var $b Articlecategory */
            return strcmp($a->getTitle(), $b->getTitle() );
        });

        $data = [
            'categories' => $categories,
            'routing'    => $this->get("search.engine")->getModuleAlias("article"),
        ];

        $response = $this->render('::modules/article/all-categories.html.twig', $data);

        return $response;
    }
}
