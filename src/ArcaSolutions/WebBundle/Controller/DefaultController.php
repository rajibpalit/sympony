<?php

namespace ArcaSolutions\WebBundle\Controller;

use ArcaSolutions\WebBundle\Entity\Quicklist;
use ArcaSolutions\WebBundle\Services\CustomContentHandler;
use ArcaSolutions\WebBundle\Services\TimelineHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('::index.html.twig', []);
    }

    /**
     * Newsletter action
     *
     * Used to save news visitors
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function newsletterAction(Request $request)
    {
        // getting POST data
        $data = [
            'name'  => $request->get('name', ''),
            'email' => $request->get('email', '')
        ];

        /* sets validators */
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection([
            'email' => [
                new Assert\Email(),
                new Assert\NotBlank()
            ],
            'name'  => [
                new Assert\NotBlank()
            ]
        ]);
        $validation = $validator->validate($data, $constraint);

        if (count($validation) == 0) {

            // calling service
            $subscription = $this->get('subscription.mailer.service');
            $subscription->setAction('addSubscriber');
            $subscription->setSubscriberName($data['name']);
            $subscription->setSubscriberEmail($data['email']);
            $subscription->setSubscriberType('visitor');
            $subscription->sendSubscription();

            /* Creates sitemanager timeline entry */
            $this->container->get("timelinehandler")->add(
                0,
                TimelineHandler::ITEMTYPE_NEWSLETTER,
                TimelineHandler::ACTION_NEW
            );

            return JsonResponse::create([
                'success' => true,
                'message' => $this->get('translator')->trans('E-mail saved')
            ]);
        }

        $error = [];
        $error['success'] = false;
        for ($i = 0; $i < count($validation); $i++) {
            // getting field name
            preg_match('/[a-zA-Z]+/', $validation->get($i)->getPropertyPath(), $key);
            $key = current($key);

            // creating array of errors
            $error['errors'][] = [
                'field'   => $key,
                'message' => $validation->get($i)->getMessage()
            ];
        }

        return JsonResponse::create($error);
    }

    /**
     * FAQ page
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function faqAction(Request $request)
    {
        $keyword = $request->query->get('keyword', '');

        if (empty($keyword)) {
            $faq = $this->get('doctrine')->getRepository('WebBundle:Faq')->findByFrontend('y');
        } else {
            $faq = $this->get('doctrine')->getRepository('WebBundle:Faq')->searchKeyword($keyword);
        }

        $this->get('javascripthandler')->addJSExternalFile('assets/js/pages/faq.js');

        return $this->render(':pages:faq.html.twig', [
            'questions' => $faq,
            'keyword'   => $keyword
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function termsAction()
    {
        return $this->render(':pages:extra.html.twig', [
            'content' => CustomContentHandler::TYPE_TERMS_OF_USE
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function privacyAction()
    {
        return $this->render(':pages:extra.html.twig', [
            'content' => CustomContentHandler::TYPE_PRIVACY_POLICY
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function sitemapAction()
    {
        $doctrine = $this->getDoctrine();
        $searchEngine = $this->get("search.engine");
        $customContent = $this->get("customcontenthandler")->get(CustomContentHandler::TYPE_SITEMAP, true);

        $sitemapContent = [
            'home'        => [
                'routing' => 'web_homepage',
                'title'   => 'Home',
            ],
            'listings'    => [
                'routing' => 'listing_homepage',
                'title'   => 'Listings',
                'child'   => [
                    'categories' => $doctrine->getRepository('ListingBundle:ListingCategory')
                        ->getAllParent(),
                    'routing'    => $searchEngine->getModuleAlias("listing")
                ],
            ],
            'events'      => [
                'routing' => 'event_homepage',
                'title'   => 'Events',
                'child'   => [
                    'categories' => $doctrine->getRepository('EventBundle:Eventcategory')->getAllParent(),
                    'routing'    => $searchEngine->getModuleAlias("event")
                ],
            ],
            'classifieds' => [
                'routing' => 'classified_homepage',
                'title'   => 'Classifieds',
                'child'   => [
                    'categories' => $doctrine->getRepository('ClassifiedBundle:Classifiedcategory')
                        ->getAllParent(),
                    'routing'    => $searchEngine->getModuleAlias("classified")
                ],
            ],
            'articles'    => [
                'routing' => 'article_homepage',
                'title'   => 'Articles',
                'child'   => [
                    'categories' => $doctrine->getRepository('ArticleBundle:Articlecategory')
                        ->getAllParent(),
                    'routing'    => $searchEngine->getModuleAlias("article")
                ],
            ],
            'deals'       => [
                'routing' => 'deal_homepage',
                'title'   => 'Deals',
                'child'   => [
                    'categories' => $doctrine->getRepository('ListingBundle:ListingCategory')
                        ->getAllParent(),
                    'routing'    => $searchEngine->getModuleAlias("deal")
                ],
            ],
            'blog'        => [
                'routing' => 'blog_homepage',
                'title'   => 'Blog',
                'child'   => [
                    'categories' => $doctrine->getRepository('BlogBundle:Blogcategory')->getAllParent(),
                    'routing'    => $searchEngine->getModuleAlias("blog")
                ],
            ],
            'advertise'   => [
                'routing' => '/' . $this->getParameter('alias_advertise_url_divisor'),
                'title'   => 'Advertise',
            ],
            'faq'         => [
                'routing' => 'web_faq',
                'title'   => 'Faq',
            ],
            'contactus'   => [
                'routing' => 'web_contactus',
                'title'   => 'Contact Us',
            ],
            'enquire'     => [
                'routing' => 'web_enquire',
                'title'   => "Enquire"
            ],
            'terms'       => [
                'routing' => 'web_terms',
                'title'   => "Terms and Conditions"
            ],
            'privacy'     => [
                'routing' => 'web_privacy',
                'title'   => "Privacy Policy"
            ],
        ];

        return $this->render(':pages:sitemap.html.twig', [
            'title'         => $customContent->getTitle(),
            'customContent' => $customContent,
            'content'       => $sitemapContent,
        ]);
    }

    /**
     * Bookmark action, saves a item in a bookmark's list
     * Used in ajax
     *
     * @param Request $request
     * @param int $id
     * @param string $module This is being validated in the routing rules
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function bookmarkAction(Request $request, $id, $module = '')
    {
        /* gets user Id using profile credentials */
        $userId = $request->getSession()->get('SESS_ACCOUNT_ID');

        if (is_null($userId)) {
            /* shows login form */
            return JsonResponse::create([
                'status' => 'login',
                'url'    => '/profile/login.php?userperm=1&bookmark_remember=' . $id
            ]);
        }

        /* search if item was marked before */
        $item = $this->get('doctrine')->getRepository('WebBundle:Quicklist')->findOneBy([
            'accountId' => $userId,
            'itemId'    => $id,
            'itemType'  => $module
        ]);

        try {
            $em = $this->get('doctrine')->getManager();

            /* it's a new record */
            if (is_null($item)) {
                $item = new Quicklist();
                $item->setAccountId($userId)
                    ->setItemId($id)
                    ->setItemType($module);

                $em->persist($item);
                $status = 'pinned';
            } else {
                /* delete a record */
                $em->remove($item);

                $status = 'unpinned';
            }

            $em->flush();
        } catch (\Exception $e) {
            $status = 'fail';
        }

        return JsonResponse::create([
            'status' => $status,
        ]);
    }
}
