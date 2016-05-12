<?php

namespace ArcaSolutions\ClassifiedBundle\Controller;

use ArcaSolutions\ClassifiedBundle\ClassifiedItemDetail;
use ArcaSolutions\ClassifiedBundle\Entity\Classified;
use ArcaSolutions\ClassifiedBundle\Entity\Classifiedcategory;
use ArcaSolutions\ClassifiedBundle\Sample\ClassifiedSample;
use ArcaSolutions\CoreBundle\Exception\ItemNotFoundException;
use ArcaSolutions\CoreBundle\Exception\UnavailableItemException;
use ArcaSolutions\CoreBundle\Services\ValidationDetail;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::modules/classified/index.html.twig', array(
            'title' => 'Classified'
        ));
    }

    /**
     * @param $search
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultsAction($search)
    {
        return $this->render('::modules/classified/results.html.twig', array(
            'title' => 'Classified Results'
        ));
    }

    /**
     * @param $friendlyUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws UnavailableItemException
     * @throws \Exception
     * @throws \Ivory\GoogleMap\Exception\MapException
     * @throws \Ivory\GoogleMap\Exception\OverlayException
     */
    public function detailAction($friendlyUrl)
    {
        /*
         * Validation
         */
        /* @var $item Classified For phpstorm get properties of entity Listing */
        $item = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, 'classified', 'ClassifiedBundle:Classified');
        /* event not found by friendlyURL */
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        /* normalizes item to validate detail */
        $classifiedItemDetail = new ClassifiedItemDetail($this->container, $item);

        /* validating if listing is enabled, if listing's level is active and if level allows detail */
        if (!ValidationDetail::isDetailAllowed($classifiedItemDetail)) {
            $parameterHandler = clone $this->get('search.parameters');
            $parameterHandler->clearAllRouteParameters();
            $parameterHandler->clearAllQueryParameters();
            $parameterHandler->addRouteParameter("module", $this->get("search.engine")->getModuleAlias("classified"));
            $parameterHandler->addRouteParameter("keyword", $friendlyUrl);

            $this->get("request_stack")->getCurrentRequest()->cookies->set("edirectory_results_viewmode", "item");
            return $this->redirect($parameterHandler->buildPathTo());
        }

        /*
         * Report
         */
        /* Counts the view towards the statistics */
        $this->container->get("reporthandler")->addClassifiedReport($item->getId(), ReportHandler::CLASSIFIED_DETAIL);

        /*
         * Workaround to get item's locations
         * We did in this way for reuse the 'Utility.address'(summary) macro in view
         */
        $locations = $this->get('location.service')->getLocations($item);
        $locations_ids = [];
        $locations_rows = [];
        foreach (array_filter($locations) as $location) {
            $locations_ids[] = $location->getId();
            $locations_rows[$location->getId()] = $location;
        }

        /* gets item's gallery */
        $gallery = null;
        if ($classifiedItemDetail->getLevel()->imageCount > 0) {
            $gallery = $this->get('doctrine')->getRepository('ClassifiedBundle:Classified')
                ->getGallery($item, --$classifiedItemDetail->getLevel()->imageCount);
        }

        $map = null;
        /* checks if item has latitude and longitude to show the map */
        if ($item->getLatitude() && $item->getLongitude()) {
            /* sets map */
            $map = $this->get('ivory_google_map.map');
            $map->setMapOption("scrollwheel", false);
            $map->setStylesheetOptions(array(
                'width'  => '100%',
                'height' => '255px',
            ));

            $map->setMapOption('zoom', 15);
            /* sets the item's location the center of the map */
            $map->setCenter($item->getLatitude(), $item->getLongitude());

            $marker = $this->get('ivory_google_map.marker');

            /* mark item in map */
            $marker->setPosition($item->getLatitude(), $item->getLongitude(), true);
            $marker->setOptions(array(
                'clickable' => false,
                'flat'      => true,
            ));
            $map->addMarker($marker);
        }

        return $this->render('::modules/classified/detail.html.twig', array(
            'item'          => $item,
            'level'         => $classifiedItemDetail->getLevel(),
            'categories'    => $item->getCategories(),
            'gallery'       => $gallery,
            'map'           => $map,
            'locationsIDs'  => $locations_ids,
            'locationsObjs' => $locations_rows,
            'country'       => $locations['country'],
            'region'        => $locations['region'],
            'state'         => $locations['state'],
            'city'          => $locations['city'],
            'neighborhood'  => $locations['neighborhood']
        ));
    }

    public function sampleDetailAction($level = 0)
    {
        $item = new ClassifiedSample($this->get("translator"), $level);

        /* normalizes item to validate detail */
        $classifiedItemDetail = new ClassifiedItemDetail($this->container, $item);

        $map = null;
        /* checks if item has latitude and longitude to show the map */
        if ($item->getLatitude() && $item->getLongitude()) {
            /* sets map */
            $map = $this->get('ivory_google_map.map');
            $map->setMapOption("scrollwheel", false);
            $map->setStylesheetOptions(array(
                'width'  => '100%',
                'height' => '255px',
            ));

            $map->setMapOption('zoom', 15);
            /* sets the item's location the center of the map */
            $map->setCenter($item->getLatitude(), $item->getLongitude());

            $marker = $this->get('ivory_google_map.marker');

            /* mark item in map */
            $marker->setPosition($item->getLatitude(), $item->getLongitude(), true);
            $marker->setOptions(array(
                'clickable' => false,
                'flat'      => true,
            ));
            $map->addMarker($marker);
        }

        return $this->render('::modules/classified/detail.html.twig', array(
            'item'          => $item,
            'level'         => $classifiedItemDetail->getLevel(),
            'map'           => $map,
            'gallery'       => $item->getGallery(--$classifiedItemDetail->getLevel()->imageCount),
            'categories'    => $item->getCategories(),
            'locationsIDs'  => $item->getFakeLocationsIds(),
            'locationsObjs' => $item->getLocationObjects(),
            'isSample'      => true
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allcategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('ClassifiedBundle:Classifiedcategory')
            ->getAllParent();

        usort($categories, function($a, $b){
            /* @var $a Classifiedcategory */
            /* @var $b Classifiedcategory */
            return strcmp($a->getTitle(), $b->getTitle() );
        });

        $data = array(
            'categories' => $categories,
            'routing'    => $this->get("search.engine")->getModuleAlias("classified"),
        );

        $response = $this->render('::modules/classified/all-categories.html.twig', $data);

        return $response;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function alllocationsAction()
    {
        $locations = $this->get('doctrine')->getRepository('WebBundle:SettingLocation')->getLocationsEnabledID();
        $locations = $this->get('helper.location')->getAllLocations($locations);

        $data = array(
            'locations' => $locations,
            'routing'   => $this->get("search.engine")->getModuleAlias("classified"),
        );

        return $this->render('::modules/classified/all-locations.html.twig', $data);
    }
}
