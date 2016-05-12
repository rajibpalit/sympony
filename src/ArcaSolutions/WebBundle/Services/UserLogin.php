<?php

namespace ArcaSolutions\WebBundle\Services;

use ArcaSolutions\MultiDomainBundle\Doctrine\DoctrineRegistry;
use ArcaSolutions\WebBundle\Entity\Accountprofilecontact;
use Symfony\Component\HttpFoundation\RequestStack;

class UserLogin
{
    /**
     * Edir Session name. It is set in sitemgr
     */
    const SESSION_EDIR = 'SESS_ACCOUNT_ID';

    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var DoctrineRegistry
     */
    private $doctrine;
    /**
     * @var Accountprofilecontact
     */
    private $user;
    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * UserLogin constructor.
     * @param DoctrineRegistry $doctrine
     * @param RequestStack $request
     */
    public function __construct(DoctrineRegistry $doctrine, RequestStack $request)
    {
        $this->request = $request;
        $this->doctrine = $doctrine;
    }

    /**
     * @return Accountprofilecontact|false
     */
    public function getUser()
    {
        if (!$this->initialized) {
            $this->setUserFromEdirectory();
        }

        return $this->user;
    }

    /**
     * @return void
     */
    private function setUserFromEdirectory()
    {
        /* getting session from edirectory */
        $id = $this->request->getCurrentRequest()->getSession()->get($this::SESSION_EDIR);
        if ($id) {
            $this->user = $this->doctrine->getRepository('WebBundle:Accountprofilecontact')->find($id);
        }

        $this->initialized = true;
    }
}
