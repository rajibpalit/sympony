<?php

namespace ArcaSolutions\ListingBundle\Controller;

use ArcaSolutions\CoreBundle\Exception\ItemNotFoundException;
use ArcaSolutions\CoreBundle\Services\ValidationDetail;
use ArcaSolutions\DealBundle\Entity\Promotion;
use ArcaSolutions\ListingBundle\Entity\Listing;
use ArcaSolutions\ListingBundle\Entity\ListingCategory;
use ArcaSolutions\ListingBundle\ListingItemDetail;
use ArcaSolutions\ListingBundle\Sample\ListingSample;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use Elastica\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::modules/listing/index.html.twig');
    }

    /**
     * @param $friendlyUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Ivory\GoogleMap\Exception\MapException
     * @throws \Ivory\GoogleMap\Exception\OverlayException
     */
    public function detailAction($friendlyUrl)
    {
        /*
         * Validation
         */
        /* @var $item Listing For phpstorm get properties of entity Listing */
        $item = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, "listing", "ListingBundle:Listing");
        /* listing not found by friendlyURL */
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        /* normalizes item to validate detail */
        $listingItemDetail = new ListingItemDetail($this->container, $item);

        /* validating if listing is enabled, if listing's level is active and if level allows detail */
        if (!ValidationDetail::isDetailAllowed($listingItemDetail)) {
            $parameterHandler = clone $this->get('search.parameters');
            $parameterHandler->clearAllRouteParameters();
            $parameterHandler->clearAllQueryParameters();
            $parameterHandler->addRouteParameter("module", $this->get("search.engine")->getModuleAlias("listing"));
            $parameterHandler->addRouteParameter("keyword", $friendlyUrl);

            $this->get("request_stack")->getCurrentRequest()->cookies->set("edirectory_results_viewmode", "item");

            return $this->redirect($parameterHandler->buildPathTo());
            /* error page */
//            throw new UnavailableItemException();
        }

        /*
         * Report
         */
        /* Counts the view towards the statistics */
        $this->container->get("reporthandler")->addListingReport($item->getId(), ReportHandler::LISTING_DETAIL);

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
        if ($listingItemDetail->getLevel()->imageCount > 0) {
            $gallery = $this->get('doctrine')->getRepository('ListingBundle:Listing')
                ->getGallery($item, --$listingItemDetail->getLevel()->imageCount);
        }

        /* gets checkins rows */
        $checkins = $this->get('doctrine')->getRepository('WebBundle:Checkin')->findBy(
            ['itemId' => $item->getId(), 'itemType' => 'listing'],
            ['added' => 'DESC'],
            9
        );

        $map = null;
        /* checks if item has latitude and longitude to show the map */
        if ($item->getLatitude() && $item->getLongitude()) {
            /* sets map */
            $map = $this->get('ivory_google_map.map');
            $map->setMapOption("scrollwheel", false);
            $map->setStylesheetOptions([
                'width'  => '100%',
                'height' => '255px',
            ]);

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

        /* gets listing's deal */
        /* @var $deal Promotion */
        $deal = null;
        if ($listingItemDetail->getLevel()->hasDeal) {
            if ($deal = $item->getDeal()) {
                if ($deal->getEndDate() < new \DateTime(date('Y-m-d'))) {
                    $deal = null;
                }
            }
        }

        /* gets item reviews */
        $reviews = $this->get('doctrine')->getRepository('WebBundle:Review')->findBy([
            'itemType' => 'listing',
            'approved' => '1',
            'itemId'   => $item->getId(),
        ], [
            'rating' => 'DESC',
            'added'  => 'DESC',
        ], 3);

        /* gets total of reviews */
        $reviews_total = $this->get('doctrine')->getRepository('WebBundle:Review')
            ->getTotalByItemId($item->getId(), 'listing');

        $extra_fields = null;
        if ($item->getTemplate()) {
            $extra_fields = $item->getTemplate()->getFields();
        }

        /* Validates if listing has the review active */
        $reviews_active = $this->getDoctrine()->getRepository('WebBundle:Setting')
            ->getSetting('review_listing_enabled');

        return $this->render('::modules/listing/detail.html.twig', [
            'item'                => $item,
            'deal'                => $deal,
            'level'               => $listingItemDetail->getLevel(),
            'locationsIDs'        => $locations_ids,
            'locationsObjs'       => $locations_rows,
            'badges'              => $item->getChoices(),
            'gallery'             => $gallery,
            'categories'          => $item->getCategories(),
            'checkins'            => $checkins,
            'reviews_active'      => $reviews_active,
            'reviews'             => $reviews,
            'reviews_total'       => $reviews_total,
            'extra_fields'        => $extra_fields,
            'map'                 => $map,
            'country'             => $locations['country'],
            'region'              => $locations['region'],
            'state'               => $locations['state'],
            'city'                => $locations['city'],
            'neighborhood'        => $locations['neighborhood'],
            'clicktocall_enabled' => $this->get('settings')->getDomainSetting('twilio_enabled_call'),
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
        $item = new ListingSample($this->get("translator"), $level);
        $listingItemDetail = new ListingItemDetail($this->container, $item);

        $map = null;
        /* checks if item has latitude and longitude to show the map */
        if ($item->getLatitude() && $item->getLongitude()) {
            /* sets map */
            $map = $this->get('ivory_google_map.map');
            $map->setMapOption("scrollwheel", false);
            $map->setStylesheetOptions([
                'width'  => '100%',
                'height' => '255px',
            ]);

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

        /* gets listing's deal */
        $deal = null;
        if ($listingItemDetail->getLevel()->hasDeal) {
            $deal = $item->getDeal();
        }

        /* Validates if listing has the review active */
        $reviews_active = $this->getDoctrine()->getRepository('WebBundle:Setting')
            ->getSetting('review_listing_enabled');

        $editorChoice = $this->getDoctrine()->getRepository('ListingBundle:EditorChoice')->findby([
            'available' => 1,
        ]);

        return $this->render('::modules/listing/detail.html.twig', [
            'item'                => $item,
            'level'               => $listingItemDetail->getLevel(),
            'map'                 => $map,
            'gallery'             => $item->getGallery(--$listingItemDetail->getLevel()->imageCount),
            'reviews_active'      => $reviews_active,
            'reviews'             => $item->getReviews(),
            'reviews_total'       => $item->getReviewCount(),
            'checkins'            => $item->getCheckins(),
            'categories'          => $item->getCategories(),
            'deal'                => $deal,
            'locationsIDs'        => $item->getFakeLocationsIds(),
            'locationsObjs'       => $item->getLocationObjects(),
            'badges'              => $editorChoice,
            'clicktocall_enabled' => $this->get('settings')->getDomainSetting('twilio_enabled_call'),
            'isSample'            => true,
        ]);
    }

    public function allcategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('ListingBundle:ListingCategory')
            ->getAllParent();

        usort($categories, function ($a, $b) {
            /* @var $a ListingCategory */
            /* @var $b ListingCategory */
            return strcmp($a->getTitle(), $b->getTitle());
        });

        $data = [
            'categories' => $categories,
            'routing'    => $this->get("search.engine")->getModuleAlias("listing"),
        ];

        $response = $this->render('::modules/listing/all-categories.html.twig', $data);

        return $response;
    }

    public function viewContactAction()
    {
        $return = [
            "status" => false,
        ];

        $session = $this->container->get("session");
        $request = $this->container->get("request");

        $listingId = $request->request->get("item");
        $type = null;
        $reportType = null;

        switch ($request->request->get("type")) {
            case "phone":
                $type = "Phone";
                $reportType = ReportHandler::LISTING_PHONE;
                break;
            case "fax":
                $type = "Fax";
                $reportType = ReportHandler::LISTING_FAX;
                break;
            case "url":
                $type = "Url";
                $reportType = ReportHandler::LISTING_CLICK;
                break;
        }

        if ($type) {
            $recentlyViewed = $session->get("listing{$type}Viewed", []);

            if (empty($recentlyViewed[$listingId])) {
                /* Counts the view towards the statistics */
                $this->container->get("reporthandler")->addListingReport($listingId, $reportType);

                $listing = $this->get('doctrine')->getRepository('ListingBundle:Listing')->find($listingId);

                $recentlyViewed[$listingId] = call_user_func([$listing, "get{$type}"]);
                $session->set("listing{$type}Viewed", $recentlyViewed);
            }

            $return["status"] = true;
            $return["data"] = $recentlyViewed[$listingId];
        }

        return new JsonResponse($return);
    }

    public function alllocationsAction()
    {
        $locations_enable = $this->get('doctrine')->getRepository('WebBundle:SettingLocation')->getLocationsEnabledID();
        $locations = $this->get('helper.location')->getAllLocations($locations_enable);

        $data = [
            'locations' => $locations,
            'routing'   => $this->get("search.engine")->getModuleAlias("listing"),
        ];

        return $this->render('::modules/listing/all-locations.html.twig', $data);
    }

    public function checkinAction($friendlyUrl, $page)
    {
        $page = $this->get("search.engine")->convertFromPaginationFormat($page);

        /* Gets listing and validation if exist */
        /* @var $listing Listing For phpstorm get properties of entity Listing */
        $listing = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, "listing", "ListingBundle:Listing");
        if (is_null($listing)) {
            throw $this->createNotFoundException('This Listing does not exist');
        }

        /* Gets checkins of listing */
        $checkins = $this->getDoctrine()
            ->getRepository('WebBundle:Checkin')
            ->findBy([
                'itemType' => 'listing',
                'itemId'   => $listing->getId(),
            ], ['added' => 'DESC']);

        // Creates the pagination to reviews
        $pagination = $this->get('knp_paginator')->paginate($checkins, $page);

        /* Gets total of checkins */
        $checkins_total = $this->get('doctrine')->getRepository('WebBundle:Checkin')
            ->getTotalByItemId($listing->getId(), 'listing');

        return $this->render('::pages/checkins.html.twig', [
            'checkin'        => $listing,
            'checkins_total' => $checkins_total,
            'pagination'     => $pagination,
        ]);
    }

    /**
     * @param String $friendlyUrl
     * @param Integer $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function reviewAction($friendlyUrl, $page)
    {
        $page = $this->get("search.engine")->convertFromPaginationFormat($page);

        /* Validates if listing has the review active */
        $active = $this->getDoctrine()->getRepository('WebBundle:Setting')->getSetting('review_listing_enabled');
        if (is_null($active) or $active == '') {
            throw $this->createNotFoundException('Listing has not reviews activated');
        }

        /* Gets listing and validation if exist */
        /* @var $listing Listing For phpstorm get properties of entity Listing */
        $listing = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, "listing", "ListingBundle:Listing");
        if (is_null($listing)) {
            throw $this->createNotFoundException('This Listing does not exist');
        }

        /* Validates if level has the review active */
        $listingDetail = new ListingItemDetail($this->container, $listing);
        if (!$listingDetail->getLevel()->hasReview) {
            throw $this->createNotFoundException('This listing has not activated reviews');
        }

        /* Gets reviews of listing */
        $reviews = $this->getDoctrine()
            ->getRepository('WebBundle:Review')
            ->findBy([
                'itemType' => 'listing',
                'approved' => 1,
                'itemId'   => $listing->getId(),
            ], ['added' => 'DESC']);

        // Creates the pagination to reviews
        $pagination = $this->get('knp_paginator')->paginate($reviews, $page);

        /* Gets total of reviews */
        $reviews_total = $this->get('doctrine')->getRepository('WebBundle:Review')
            ->getTotalByItemId($listing->getId(), 'listing');

        return $this->render('::pages/reviews.html.twig', [
            'module'        => 'listing',
            'review'        => $listing,
            'reviews_total' => $reviews_total,
            'pagination'    => $pagination,
        ]);
    }
}
