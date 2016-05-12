<?php

namespace ArcaSolutions\MultiDomainBundle\Services;

use ArcaSolutions\CoreBundle\Entity\Domain;
use Symfony\Component\DependencyInjection\Container;

class Settings
{
    /**
     * @var array
     */
    protected $hostConfig = [];
    /**
     * @var string|null
     */
    protected $activeHost = null;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     * @param array $hostsConfig
     */
    public function __construct(Container $container, $hostsConfig)
    {
        $this->setHostConfig($hostsConfig);
        $this->container = $container;
        $domain = $this->container->get("kernel")->getDomain() and $this->setActiveHost($domain);
    }

    /**
     * @return array
     */
    protected function getHostConfig()
    {
        return $this->hostConfig;
    }

    /**
     * @param array $hostConfig
     */
    protected function setHostConfig($hostConfig)
    {
        $this->hostConfig = $hostConfig;
    }

    /**
     * @return null
     */
    public function getActiveHost()
    {
        return $this->activeHost;
    }

    /**
     * @param null $activeHost
     * @throws \Exception
     */
    public function setActiveHost($activeHost)
    {
        $activeHost = str_replace('-', '_', $activeHost);

        if (isset($this->hostConfig[$activeHost])) {
            $this->activeHost = $activeHost;
        } else {
            $this->container->get('logger')->critical("[MultiDomain/Settings] - Unable to set Active Host.");
            throw new \Exception(sprintf('Cannot find host %s for this eDirectory installation', $activeHost));
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getSetting("id");
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getSetting($name)
    {
        $returnValue = null;

        if ($this->hostConfig and $this->activeHost and isset($this->hostConfig[$this->activeHost])) {
            $returnValue = $this->hostConfig[$this->activeHost][$name];
        }

        return $returnValue;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getSetting("path");
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->getSetting("template");
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->getSetting("locale");
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->getSetting("database");
    }

    /**
     * @return string
     */
    public function getElastic()
    {
        return $this->getSetting("elastic");
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getSetting("title");
    }

    /**
     * @return string
     */
    public function getBranded()
    {
        return $this->getSetting("branded");
    }
}
