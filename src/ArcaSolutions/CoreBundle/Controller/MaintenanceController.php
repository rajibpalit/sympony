<?php

namespace ArcaSolutions\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaintenanceController extends Controller
{
    /**
     * Handle maintenance mode
     * Get content in Content table
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::maintenance.html.twig');
    }
}
