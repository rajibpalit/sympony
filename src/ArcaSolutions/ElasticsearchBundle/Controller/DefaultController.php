<?php

namespace ArcaSolutions\ElasticsearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function rebuildLocationsAction()
    {
        $response = [ "status" => false ];

        $repository = $this->get("doctrine")->getRepository("WebBundle:Setting");

        if($this->get("kernel")->getEnvironment() == "dev"){
            $this->get("location.synchronization")->generateAllLocations();
            $response = [
                "status" => true,
                "dev" => true,
            ];
        } else if ( $result = $repository->findOneBy(["name" => "elasticsearchRebuildLocations"]) and $result->getValue()) {
            $this->get("location.synchronization")->generateAllLocations();

            $objectManager = $this->get("doctrine")->getManager();
            $objectManager->remove($result);
            $objectManager->flush();

            $response = [ "status" => true ];
        }

        return new JsonResponse($response);
    }
}
