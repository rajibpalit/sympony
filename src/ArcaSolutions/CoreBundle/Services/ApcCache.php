<?php
namespace ArcaSolutions\CoreBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class ApcCache extends \Doctrine\Common\Cache\ApcCache
{
    /**
     * @var RequestStack
     */
    private $request;

    /**
     * Used to prepend ids to divide caches files
     *
     * @var string
     */
    private $prepend;

    /**
     * ApcCache constructor.
     *
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request;

        /* caches per domain */
        $this->prepend = $this->request->getCurrentRequest()->getHost();
    }

    /**
     * {@inheritdoc}
     */
    public function contains($id)
    {
        return parent::contains($this->appendDomainInformationInID($id));
    }

    /**
     * @param $id
     *
     * @return string
     */
    private function appendDomainInformationInID($id)
    {
        return $this->prepend . $id;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($id)
    {
        return parent::fetch($this->appendDomainInformationInID($id));
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        return parent::delete($this->appendDomainInformationInID($id));
    }

    /**
     * {@inheritdoc}
     */
    public function save($id, $data, $lifeTime = 0)
    {
        return parent::save($this->appendDomainInformationInID($id), $data, $lifeTime);
    }
}
