<?php

namespace ArcaSolutions\DealBundle\Controller;

use ArcaSolutions\CoreBundle\Exception\ItemNotFoundException;
use ArcaSolutions\CoreBundle\Exception\UnavailableItemException;
use ArcaSolutions\CoreBundle\Services\ValidationDetail;
use ArcaSolutions\DealBundle\DealItemDetail;
use ArcaSolutions\DealBundle\Entity\Promotion;
use ArcaSolutions\DealBundle\Entity\PromotionRedeem;
use ArcaSolutions\ListingBundle\Entity\ListingCategory;
use ArcaSolutions\ListingBundle\ListingItemDetail;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use ArcaSolutions\WebBundle\Services\EmailNotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

final class DefaultController extends Controller
{
    /**
     * Homepage
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::modules/deal/index.html.twig', [
            'title' => 'Deal Index'
        ]);
    }

    /**
     * Detail page
     *
     * @param $friendlyUrl
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws ItemNotFoundException
     * @throws \Exception
     * @throws \Ivory\GoogleMap\Exception\MapException
     * @throws \Ivory\GoogleMap\Exception\OverlayException
     */
    public function detailAction($friendlyUrl)
    {
        /*
         * Validation
         */
        /* @var $item Promotion For phpstorm get properties of entity Listing */
        $item = $this->get('search.engine')->itemFriendlyURL($friendlyUrl, 'deal', 'DealBundle:Promotion');
        /* event not found by friendlyURL */
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        /* normalizes item to validate detail */
        $dealItemDetail = new DealItemDetail($this->container, $item);
        $listingItemDetail = new ListingItemDetail($this->container, $item->getListing());

        /* validating if listing is enabled, if listing's level is active and if level allows detail */
        if ('A' != $listingItemDetail->getItem()->getStatus() && !ValidationDetail::isDetailAllowed($dealItemDetail)) {
            /* error page */
            throw new UnavailableItemException();
        }

        /*
         * Report
         */
        /* Counts the view towards the statistics */
        $this->container->get("reporthandler")->addDealReport($item->getId(), ReportHandler::DEAL_DETAIL);

        /*
         * Workaround to get item's locations
         * We did in this way for reuse the 'Utility.address'(summary) macro in view
         */
        $locations = array_filter($this->get('location.service')->getLocations($item->getListing()));
        $locations_ids = [];
        $locations_rows = [];
        foreach ($locations as $location) {
            $locations_ids[] = $location->getId();
            $locations_rows[$location->getId()] = $location;
        }

        $map = null;
        /* checks if item has latitude and longitude to show the map */
        if ($item->getListing()->getLatitude() && $item->getListing()->getLongitude()) {
            /* sets map */
            $map = $this->get('ivory_google_map.map');
            $map->setMapOption("scrollwheel", false);
            $map->setStylesheetOptions([
                'width'  => '100%',
                'height' => '255px',
            ]);

            $map->setMapOption('zoom', 15);
            /* sets the item's location the center of the map */
            $map->setCenter($item->getListing()->getLatitude(), $item->getListing()->getLongitude());

            $marker = $this->get('ivory_google_map.marker');

            /* mark item in map */
            $marker->setPosition($item->getListing()->getLatitude(), $item->getListing()->getLongitude(), true);
            $marker->setOptions([
                'clickable' => false,
                'flat'      => true,
            ]);
            $map->addMarker($marker);
        }

        /* adds view phone script(listing) */
        $this->get('javascripthandler')->addJSBlock('::modules/listing/js/summary.js.twig')
            ->addJSExternalFile('assets/js/lib/countdown/jquery.countdown.min.js')
            ->addJSExternalFile('assets/js/modules/deal/detail.js');

        /* calculating percentage */
        $percentage = 0;
        if ($item->getRealvalue() != 0) {
            $percentage = sprintf('%d', 100 - $item->getDealvalue() * 100 / $item->getRealvalue());
        }

        return $this->render('::modules/deal/detail.html.twig', [
            'item'          => $item,
            'map'           => $map,
            'percentage'    => $percentage,
            'listing_level' => $listingItemDetail->getLevel(),
            'locationsIDs'  => $locations_ids,
            'locationsObjs' => $locations_rows
        ]);
    }

    /**
     * All categories page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allcategoriesAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('ListingBundle:ListingCategory')
            ->getAllParent();

        usort($categories, function($a, $b){
            /* @var $a ListingCategory */
            /* @var $b ListingCategory */
            return strcmp($a->getTitle(), $b->getTitle() );
        });

        $data = [
            'categories' => $categories,
            'routing'    => $this->get("search.engine")->getModuleAlias("deal"),
        ];

        $response = $this->render('::modules/deal/all-categories.html.twig', $data);

        return $response;
    }

    /**
     * Make a redeem of a deal. Send notification and get the code.
     * If it was already redeemed, just get the code and show it again.
     * If it was not, generate a new code, save it and show.
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function redeemAction(Request $request, $id)
    {
        /* gets user Id using profile credentials */
        $userId = $request->getSession()->get('SESS_ACCOUNT_ID');

        if (is_null($userId)) {
            return $this->redirect('/profile/login.php?userperm=1&redeem_remember=' . $id);
        }

        $deal = $this->get('doctrine')->getRepository('DealBundle:Promotion')->find($id);

        /*
         * Validations
         */
        if (is_null($deal)) {
            throw new \Exception('Not Found.');
        }

        if (0 == $deal->getListingId()) {
            throw new \Exception('This deal is not available.');
        }

        if ('A' != $deal->getListing()->getStatus()) {
            throw new \Exception('This deal is not available.');
        }

        $today = new \DateTime('now');
        /* workaround to fix edirectory behavior */
        if (0 == $deal->getAmount() || ($deal->getEndDate()->modify('+1 day') < $today)) {
            throw new \Exception('Sold out.');
        }

        /* Check if it was already redeemed */
        $redeem = $this->get('doctrine')->getRepository('DealBundle:PromotionRedeem')
            ->existUserCodeForDeal($deal, $userId);

        $userAccount = $this->get('doctrine')->getManager('main')->getRepository('CoreBundle:Contact')->find($userId);

        /* Generate the code if it was not */
        if (is_null($redeem)) {
            /* generate code */
            $redeem = $this->get('doctrine')->getRepository('DealBundle:PromotionRedeem')->redeemCode($deal, $userId);

            $from_sitemgr = explode(',',
                $this->getDoctrine()->getRepository('WebBundle:Setting')->getSetting('sitemgr_email'));

            $owner_listing_contact = $this->get('doctrine')->getManager('main')->getRepository('CoreBundle:Contact')
                ->find($deal->getListing()->getAccountId());

            $sendTo = $userAccount->getEmail();
            $name = sprintf('%s %s', $userAccount->getFirstName(), $userAccount->getLastName());
            $owner_name = sprintf('%s %s', $owner_listing_contact->getFirstName(),
                $owner_listing_contact->getLastName());

            /* Send listing's owner email */
            $this->get('email.notification.service')->getEmailMessage(EmailNotificationService::DEAL_REDEEM_OWNER)
                ->setTo($owner_listing_contact->getEmail())
                ->setFrom($from_sitemgr)
                ->setPlaceholder('ACCOUNT_NAME', $owner_name)
                ->sendEmail();

            /* Send user email */
            $this->get('email.notification.service')->getEmailMessage(EmailNotificationService::DEAL_REDEEM_VISITOR)
                ->setTo($sendTo)
                ->setFrom($from_sitemgr)
                ->setPlaceholder('ACCOUNT_NAME', $name)
                ->setPlaceholder('REDEEM_CODE', $redeem->getRedeemCode())
                ->sendEmail();
        }

        $listing = $this->get('doctrine')->getRepository('ListingBundle:Listing')->find($deal->getListingId());

        /* Get deal(listing) location. It used this function because locations's table is in other database */
        $locations = $this->get('location.service')->getLocations($listing);

        return $this->render('::blocks/modals/modal-redeem.html.twig', [
            'redeem'    => $redeem,
            'deal'      => $deal,
            'locations' => $locations,
            'user'      => $userAccount
        ]);
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
            'routing'   => $this->get("search.engine")->getModuleAlias("deal"),
        ];

        return $this->render('::modules/deal/all-locations.html.twig', $data);
    }
}
