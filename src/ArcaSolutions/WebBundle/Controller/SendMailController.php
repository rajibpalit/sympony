<?php
namespace ArcaSolutions\WebBundle\Controller;

use ArcaSolutions\WebBundle\Form\Type\SendMailType;
use ArcaSolutions\WebBundle\Services\EmailNotificationService;
use ArcaSolutions\WebBundle\Services\LeadHandler;
use ArcaSolutions\WebBundle\Services\TimelineHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SendMailController extends Controller
{
    /**
     * Send email to the item owner (Listing, Classified, Event)
     *
     * @param Request $request
     * @param string $id
     * @param string $module
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     * @throws \Exception When a module is allowed or not selected
     */
    public function indexAction(Request $request, $id = '', $module = '')
    {
        $translator = $this->get("translator");

        /* Default error response for this action */
        $response = [
            'status'  => false,
            'title'   => $translator->trans("Error"),
            'content' => $translator->trans("The item you are trying to contact does not exist.")
        ];

        if (is_numeric($id) && $id > 0) {
            $doctrine = $this->get('doctrine');

            switch ($module) {
                case 'listing':
                    $item = $doctrine->getRepository('ListingBundle:Listing')->find($id);
                    $leadType = LeadHandler::ITEMTYPE_LISTING;
                    break;
                case 'event':
                    $item = $doctrine->getRepository('EventBundle:Event')->find($id);
                    $leadType = LeadHandler::ITEMTYPE_EVENT;
                    break;
                case 'classified':
                    $item = $doctrine->getRepository('ClassifiedBundle:Classified')->find($id);
                    $leadType = LeadHandler::ITEMTYPE_CLASSIFIED;
                    break;
                default:
                    $item = null;
                    $leadType = null;
                    break;
            }

            if ($item) {
                $form = $this->createForm(new SendMailType());
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $owner = $doctrine->getRepository('CoreBundle:Contact', 'main')->find($item->getAccountId());

                    /* The item can not be account */
                    if ($owner) {
                        $from_sitemgr = explode(
                            ',',
                            $doctrine->getRepository('WebBundle:Setting')->getSetting('sitemgr_email')
                        );

                        /* making the lead body */
                        $body = $translator->trans('Item') . ": " . $item->getTitle();
                        $body .= PHP_EOL . PHP_EOL . $translator->trans('Name') . ": " . $form->get('name')->getData();
                        $body .= PHP_EOL . PHP_EOL . $translator->trans('Email') . ": " . $form->get('email')->getData();
                        $body .= PHP_EOL . PHP_EOL . $translator->trans('Message') . ": " . PHP_EOL . PHP_EOL . $form->get('text')->getData();

                        /* getting notification object */
                        $notification = $this->get('email.notification.service')->getEmailMessage(EmailNotificationService::NEW_LEAD);

                        /* adds subject from user */
                        $notification->setSubject($notification->getSubject() . ' ' . $form->get('subject')->getData());

                        /* replacing placeholders and sending message */
                        $notification->setTo($owner->getEmail())
                            ->setFrom($from_sitemgr)
                            ->setPlaceholder('ACCOUNT_NAME', $owner->getFirstName() . ' ' . $owner->getLastName())
                            ->setPlaceholder('LEAD_MESSAGE', $body)
                            ->sendEmail();

                        /* Prepares information for lead insertion */
                        $names = explode(" ", trim($form->get('name')->getData()));
                        $firstName = array_pop($names);
                        $lastName = implode(" ", $names);
                        $email = $form->get('email')->getData();
                        $subject = $form->get('subject')->getData();
                        $message = $form->get('text')->getData();

                        /* Adds to sitemanager's timeline */
                        $lead = $this->get("leadhandler")->add(
                            $leadType,
                            $id,
                            $firstName,
                            $lastName,
                            $email,
                            "",
                            $subject,
                            $message
                        );

                        $this->get("timelinehandler")->add(
                            $lead->getId(),
                            TimelineHandler::ITEMTYPE_LEAD,
                            TimelineHandler::ACTION_NEW
                        );
                    }

                    $response = [
                        'status'  => true,
                        'title'   => $translator->trans("Message"),
                        'content' => $translator->trans("Your e-mail has been sent. Thank you."),
                    ];
                } else {
                    $response = [
                        'status'  => false,
                        'title'   => $translator->trans("Send E-mail"),
                        'content' => $this->get("twig")->render('::blocks/modals/modal-send-email.html.twig', [
                            'form' => $form->createView(),
                            'item' => $item
                        ])
                    ];
                }
            }
        }

        return JsonResponse::create($response);
    }
}
