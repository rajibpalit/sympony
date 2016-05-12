<?php

namespace ArcaSolutions\WebBundle\Controller;

use ArcaSolutions\CoreBundle\Mailer\Mailer;
use ArcaSolutions\WebBundle\Form\Builder\EnquireBuilder;
use ArcaSolutions\WebBundle\Form\Type\EnquireType;
use ArcaSolutions\WebBundle\Services\LeadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EnquireController extends Controller
{
    public function indexAction(Request $request)
    {
        /* Creates a new form */
        $form = $this->createForm(new EnquireType());

        $folderCustomFields = $this->get('kernel')->getRootDir().'/../web/';
        $folderCustomFields .= $this->get('multi_domain.information')->getPath().'editor/lead/';

        /* Loads the custom fields */
        $customForm = new EnquireBuilder();
        $customForm->setFolder($folderCustomFields);
        $customForm->setFile('save.json');
        $customForm->generate($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* Send Mail for Admins */
            $sendTo = explode(',', $this->getDoctrine()
                ->getRepository('WebBundle:Setting')
                ->getSetting('sitemgr_lead_email'));

            $translator = $this->get('translator');
            $name = $form->get('firstname')->getData().' '.$form->get('lastname')->getData();
            $subject = '['.$this->get('multi_domain.information')->getTitle().'] '.$translator->trans('New Inquire');

            Mailer::newMail($this->container)
                ->setSubject($subject.' - '.$form->get('subject')->getData())
                ->setFrom($form->get('email')->getData(), $name)
                ->setTo($sendTo)
                ->setReplyTo($form->get('email')->getData(), $name)
                ->setBody($this->renderView('::mailer/enquire.html.twig', [
                    'firstname' => $form->get('firstname')->getData(),
                    'lastname'  => $form->get('lastname')->getData(),
                    'email'     => $form->get('email')->getData(),
                    'phone'     => $form->get('phone')->getData(),
                    'message'   => $form->get('message')->getData(),
                ]), 'text/html')
                ->send();

            /* Creates a lead */
            $this->get("leadhandler")->add(
                LeadHandler::ITEMTYPE_GENERAL,
                0,
                $form->get('firstname')->getData(),
                $form->get('lastname')->getData(),
                $form->get('email')->getData(),
                $form->get('phone')->getData(),
                $form->get('subject')->getData(),
                $form->get('message')->getData()
            );

            $translator = $this->get('translator');

            $this->addFlash('notice', [
                'alert'   => 'success',
                'title'   => 'Success!',
                'message' => $translator->trans('Thank you, we will be in touch shortly.'),
            ]);

            return $this->redirectToRoute('web_enquire');
        }

        $data = [
            'form'    => $form->createView(),
            'contact' => [
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
            ],
        ];

        return $this->render('::pages/enquire.html.twig', $data);
    }
}
