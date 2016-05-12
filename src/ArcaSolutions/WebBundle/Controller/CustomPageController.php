<?php
namespace ArcaSolutions\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CustomPageController
 *
 * @package ArcaSolutions\WebBundle\Controller
 */
class CustomPageController extends Controller
{
    /**
     * @param $friendlyUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException Content page not found
     */
    public function indexAction($friendlyUrl)
    {
        /* gets page */
        $page = $this->get('doctrine')->getRepository('WebBundle:Content')->findOneBy([
            'url'     => $friendlyUrl,
            'section' => 'client'
        ]);

        if (is_null($page)) {
            throw $this->createNotFoundException('Content not found');
        }

        return $this->render('::pages/extra.html.twig', [
            'content' => $page->getType()
        ]);
    }
}
