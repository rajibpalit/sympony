<?php

namespace ArcaSolutions\WebBundle\Controller;

use ArcaSolutions\CoreBundle\Mailer\Mailer;
use ArcaSolutions\WebBundle\Form\Type\ContactUsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactusController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Ivory\GoogleMap\Exception\MapException
     * @throws \Ivory\GoogleMap\Exception\OverlayException
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new ContactUsType());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $translator = $this->get('translator');
            $name = $form->get('firstname')->getData().' '.$form->get('lastname')->getData();
            $subject = '['.$this->get('multi_domain.information')->getTitle().'] '.$translator->trans('New message');

            $sendTo = explode(',', $this->getDoctrine()
                ->getRepository('WebBundle:Setting')
                ->getSetting('sitemgr_contactus_email'));

            if ($sendTo) {
                try {
                    /** @var Mailer */
                    Mailer::newMail($this->container)
                        ->setSubject($subject.' - '.$form->get('subject')->getData())
                        ->setFrom($form->get('email')->getData(), $name)
                        ->setTo($sendTo)
                        ->setReplyTo($form->get('email')->getData(), $name)
                        ->setBody($this->renderView('::mailer/contactus.html.twig', [
                            'firstname' => $form->get('firstname')->getData(),
                            'lastname'  => $form->get('lastname')->getData(),
                            'email'     => $form->get('email')->getData(),
                            'phone'     => $form->get('phone')->getData(),
                            'message'   => $form->get('message')->getData(),
                        ]), 'text/html')
                        ->send();

                    $this->addFlash('notice', [
                        'alert'   => 'success',
                        'title'   => 'Success!',
                        'message' => $translator->trans('Your e-mail has been sent. Thank you.'),
                    ]);
                } catch (\Swift_TransportException $e) {
                    $this->addFlash('notice', [
                        'alert'   => 'danger',
                        'title'   => 'Error!',
                        'message' => $translator->trans('Please correct it and try again.'),
                    ]);
                }

                return $this->redirectToRoute('web_contactus');
            }
        }

        $data = [];

        /* Settings Map */
        if ($this->container->get('settings')->getSettingGoogle('maps_status') == 'on'
            and ($this->container->get('settings')->getDomainSetting('contact_latitude') and $this->container->get('settings')
                    ->getDomainSetting('contact_longitude'))
        ) {
            /* New map defined */
            $map = $this->get('ivory_google_map.map');
            $map->setStylesheetOptions([
                'width'  => '98%',
                'height' => '240px',
            ]);

            $map->setCenter($this->container->get('settings')->getDomainSetting('contact_latitude'),
                $this->container->get('settings')->getDomainSetting('contact_longitude'));

            $map->setMapOption('zoom', 15);

            $marker = $this->get('ivory_google_map.marker');
            $marker->setPosition($this->container->get('settings')->getDomainSetting('contact_latitude'),
                $this->container->get('settings')->getDomainSetting('contact_longitude'), true);
            $marker->setOptions([
                'clickable' => false,
                'flat'      => true,
            ]);

            $map->addMarker($marker);

            $data['map'] = $map;
        }

        $contact = [
            'company' => $this->container->get('settings')->getDomainSetting('contact_company'),
            'address' => $this->container->get('settings')->getDomainSetting('contact_address'),
            'zipcode' => $this->container->get('settings')->getDomainSetting('contact_zipcode'),
            'country' => $this->container->get('settings')->getDomainSetting('contact_zipcode'),
            'state'   => $this->container->get('settings')->getDomainSetting('contact_state'),
            'city'    => $this->container->get('settings')->getDomainSetting('contact_city'),
            'phone'   => $this->container->get('settings')->getDomainSetting('contact_phone'),
            'fax'     => $this->container->get('settings')->getDomainSetting('contact_fax'),
            'email'   => $this->container->get('settings')->getDomainSetting('contact_email'),
            'mapzoom' => $this->container->get('settings')->getDomainSetting('contact_mapzoom'),
        ];

        $data['form'] = $form->createView();
        $data['contact'] = $contact;

        $response = $this->render('::pages/contactus.html.twig', $data);

        return $response;
    }
}
