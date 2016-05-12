<?php

namespace ArcaSolutions\MultiDomainBundle\EventListener;


use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class DatabaseListener
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Container $container
     * @param Connection $connection
     */
    public function __construct(Container $container, Connection $connection)
    {
        $this->container = $container;
        $this->connection = $connection;
    }

    public function onKernelRequest($event)
    {
        $request = $event->getRequest();

        $domain_locale = $this->container->get('multi_domain.information')->getLocale();
        $this->container->get('translator')->setLocale($domain_locale);
        $request->setLocale($request->getPreferredLanguage([$domain_locale]));

        $connection = $this->connection;
        $params = $this->connection->getParams();
        $dbname = $this->container->get('multi_domain.information')->getDatabase();

        if ($dbname != $params['dbname']) {
            $params['dbname'] = $dbname;
            if ($connection->isConnected()) {
                $connection->close();
            }

            $connection->__construct($params, $connection->getDriver(), $connection->getConfiguration(),
                $connection->getEventManager());

            try {
                $connection->connect();
            } catch (\Exception $e) {
                $this->container->get('logger')->error('Error on change the database name');
            }
        }

    }
}
