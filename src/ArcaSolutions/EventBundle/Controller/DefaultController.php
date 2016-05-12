<?php

namespace ArcaSolutions\EventBundle\Controller;

use ArcaSolutions\CoreBundle\Exception\ItemNotFoundException;
use ArcaSolutions\CoreBundle\Exception\UnavailableItemException;
use ArcaSolutions\CoreBundle\Services\ValidationDetail;
use ArcaSolutions\EventBundle\Entity\Event;
use ArcaSolutions\EventBundle\Entity\Eventcategory;
use ArcaSolutions\EventBundle\EventItemDetail;
use ArcaSolutions\EventBundle\Sample\EventSample;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::modules/event/index.html.twig', [
            'title'      => 'Event Index',
            'dateFilter' => $this->get('filter.date')
        ]);
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
        /* @var $item Event For phpstorm get properties of entity Event */
        $item = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, 'event', 'EventBundle:Event');
        /* event not found by friendlyURL */
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        /* normalizes item to validate detail */
        $eventItemDetail = new EventItemDetail($this->container, $item);

        /* validating if event is enabled, if events level is active and if level allows detail */
        if (!ValidationDetail::isDetailAllowed($eventItemDetail)) {
            $parameterHandler = clone $this->get('search.parameters');
            $parameterHandler->clearAllRouteParameters();
            $parameterHandler->clearAllQueryParameters();
            $parameterHandler->addRouteParameter("module", $this->get("search.engine")->getModuleAlias("event"));
            $parameterHandler->addRouteParameter("keyword", $friendlyUrl);

            $this->get("request_stack")->getCurrentRequest()->cookies->set("edirectory_results_viewmode", "item");
            return $this->redirect($parameterHandler->buildPathTo());
        }

        /*
         * Report
         */
        /* Counts the view towards the statistics */
        $this->container->get("reporthandler")->addEventReport($item->getId(), ReportHandler::EVENT_DETAIL);

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
        if ($eventItemDetail->getLevel()->imageCount > 0) {
            $gallery = $this->get('doctrine')->getRepository('EventBundle:Event')
                ->getGallery($item, --$eventItemDetail->getLevel()->imageCount);
        }

        $map = null;
        /* checks if item has latitude and longitude to show the map */
        if ($item->getLatitude() && $item->getLongitude()) {
            /* sets map */
            $map = $this->get('ivory_google_map.map');
            $map->setMapOption("scrollwheel", false);
            $map->setMapOption('zoom', 15);
            /* sets the item's location the center of the map */
            $map->setCenter($item->getLatitude(), $item->getLongitude());

            $marker = $this->get('ivory_google_map.marker');

            /* mark item in map */
            $marker->setPosition($item->getLatitude(), $item->getLongitude(), true);
            $marker->setOptions([
                'clickable' => false,
                'flat'      => true,
            ]);
            $map->addMarker($marker);
        }

        return $this->render('::modules/event/detail.html.twig', [
            'item'          => $item,
            'level'         => $eventItemDetail->getLevel(),
            'categories'    => $item->getCategories(),
            'gallery'       => $gallery,
            'map'           => $map,
            'locationsIDs'  => $locations_ids,
            'locationsObjs' => $locations_rows,
            'country'       => $locations['country'],
            'region'        => $locations['region'],
            'state'         => $locations['state'],
            'city'          => $locations['city'],
            'neighborhood'  => $locations['neighborhood'],
            'dateFilter'    => $this->get('filter.date')
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
        $item = new EventSample($this->get("translator"), $level);

        /* normalizes item to validate detail */
        $eventItemDetail = new EventItemDetail($this->container, $item);

        $map = null;
        /* checks if item has latitude and longitude to show the map */
        if ($item->getLatitude() && $item->getLongitude()) {
            /* sets map */
            $map = $this->get('ivory_google_map.map');
            $map->setMapOption("scrollwheel", false);
            $map->setMapOption('zoom', 15);
            /* sets the item's location the center of the map */
            $map->setCenter($item->getLatitude(), $item->getLongitude());

            $marker = $this->get('ivory_google_map.marker');

            /* mark item in map */
            $marker->setPosition($item->getLatitude(), $item->getLongitude(), true);
            $marker->setOptions([
                'clickable' => false,
                'flat'      => true,
            ]);
            $map->addMarker($marker);
        }

        return $this->render('::modules/event/detail.html.twig', [
            'item'          => $item,
            'level'         => $eventItemDetail->getLevel(),
            'gallery'       => $item->getGallery(--$eventItemDetail->getLevel()->imageCount),
            'map'           => $map,
            'locationsIDs'  => $item->getFakeLocationsIds(),
            'locationsObjs' => $item->getLocationObjects(),
            'categories'    => $item->getCategories(),
            'dateFilter'    => $this->get('filter.date'),
            'isSample'      => true
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allcategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('EventBundle:Eventcategory')
            ->getAllParent();

        usort($categories, function($a, $b){
            /* @var $a Eventcategory */
            /* @var $b Eventcategory */
            return strcmp($a->getTitle(), $b->getTitle() );
        });

        $data = [
            'categories' => $categories,
            'routing'    => $this->get("search.engine")->getModuleAlias("event"),
        ];

        $response = $this->render('::modules/event/all-categories.html.twig', $data);

        return $response;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function alllocationsAction()
    {
        $locations_enable = $this->get('doctrine')->getRepository('WebBundle:SettingLocation')->getLocationsEnabledID();
        $locations = $this->get('helper.location')->getAllLocations($locations_enable);

        $data = [
            'locations' => $locations,
            'routing'   => $this->get("search.engine")->getModuleAlias("event"),
        ];

        return $this->render('::modules/event/all-locations.html.twig', $data);
    }

    /**
     * @param $friendlyUrl
     * @param $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkinAction($friendlyUrl, $page)
    {
        $page = $this->get("search.engine")->convertFromPaginationFormat($page);

        /* Gets events and validation if exist */
        /* @var $events Event For phpstorm get properties of entity Event */
        $events = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, "event", "EventBundle:Event");
        if (is_null($events)) {
            throw $this->createNotFoundException('This Event does not exist');
        }

        /* Gets checkins of events */
        $checkins = $this->getDoctrine()
            ->getRepository('WebBundle:Checkin')
            ->findBy([
                'itemType' => 'event',
                'itemId'   => $events->getId(),
            ], ['added' => 'DESC']);

        // Creates the pagination to checkins
        $pagination = $this->get('knp_paginator')->paginate($checkins, $page);

        /* Gets total of checkins */
        $checkins_total = $this->get('doctrine')->getRepository('WebBundle:Checkin')
            ->getTotalByItemId($events->getId(), 'event');

        return $this->render('::pages/checkins.html.twig', [
            'checkin'        => $events,
            'checkins_total' => $checkins_total,
            'pagination'     => $pagination,
        ]);
    }
}
