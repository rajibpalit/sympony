<?php

namespace ArcaSolutions\CoreBundle\Kernel;

use ArcaSolutions\MultiDomainBundle\HttpFoundation\MultiDomainRequest;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Yaml\Parser;

/**
 * eDirectory base application kernel.
 *
 * @package ArcaSolutions\CoreBundle\Kernel
 * @author Diego Mosela <diego.mosela@arcasolutions.com>
 */
abstract class Kernel extends BaseKernel
{
    protected $domain = null;

    const VERSION = '11.0.0';
    const VERSION_ID = '11000';
    const MAJOR_VERSION = '11';
    const MINOR_VERSION = '0';
    const RELEASE_VERSION = '00';
    const EXTRA_VERSION = '';

    const ENV_DEV = 'dev';
    const ENV_PROD = 'prod';
    const ENV_TEST = 'test';
    const ENV_STAGING = 'staging';

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \ArcaSolutions\CoreBundle\CoreBundle(),
            new \ArcaSolutions\MultiDomainBundle\MultiDomainBundle(),
            new \ArcaSolutions\SearchBundle\SearchBundle(),
            new \ArcaSolutions\ElasticsearchBundle\ElasticsearchBundle(),
            new \ArcaSolutions\ImageBundle\ImageBundle(),
            new \ArcaSolutions\WebBundle\WebBundle(),
            new \ArcaSolutions\ListingBundle\ListingBundle(),
            new \ArcaSolutions\ClassifiedBundle\ClassifiedBundle(),
            new \ArcaSolutions\EventBundle\EventBundle(),
            new \ArcaSolutions\ArticleBundle\ArticleBundle(),
            new \ArcaSolutions\DealBundle\DealBundle(),
            new \ArcaSolutions\BlogBundle\BlogBundle(),
            new \ArcaSolutions\BannersBundle\BannersBundle(),
            new \ArcaSolutions\ReportsBundle\ReportsBundle(),
            new \ArcaSolutions\UpgradeBundle\UpgradeBundle(),
            new \Liip\ThemeBundle\LiipThemeBundle(),
            new \Liip\ImagineBundle\LiipImagineBundle(),
            new \Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new \Ivory\GoogleMapBundle\IvoryGoogleMapBundle(),
            new \Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new \JMS\TranslationBundle\JMSTranslationBundle(),
        ];

        return $bundles;
    }

    /**
     * Returns the current selected domain. Attempts to get info from Request or from the database, if the former fails.
     * @return null|string
     * @throws \Exception
     */
    public function getDomain()
    {
        if ($this->domain === null) {
            /* If there's a request, get data from the request */
            if ($request = MultiDomainRequest::createFromGlobals() and $host = $request->getHost()) {
                $this->domain = $host;
            } else {
                /* No request data... Let's try our database */
                $s = DIRECTORY_SEPARATOR;
                $parametersPath = $this->getRootDir() . "{$s}config{$s}parameters.yml";

                if (file_exists($parametersPath)) {
                    try {
                        /* Parsing and retrieving information from parameters.yml */
                        $yaml = new Parser();
                        $parsedParameterArray = $yaml->parse(file_get_contents($parametersPath));
                        $parameters = $parsedParameterArray["parameters"];

                        $dbHost = $parameters["database_host"];
                        $dbName = $parameters["database_name"];
                        $dbUser = $parameters["database_user"];
                        $dbPassword = $parameters["database_password"];
                        $dbCharset = $parameters["database_charset"];

                        /* Connection creation */
                        $connection = new \PDO(
                            "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}",
                            $dbUser,
                            $dbPassword
                        );

                        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                        /* If we DO have this constant defined, let's use it's value */
                        if (defined("SELECTED_DOMAIN_ID")) {
                            $statement = $connection->prepare("SELECT `url` FROM `Domain` WHERE `id` = :id");
                            $statement->bindValue("id", SELECTED_DOMAIN_ID);
                            $statement->execute();

                            if ($selectedDomain = $statement->fetchObject()) {
                                $this->domain = $selectedDomain->url;
                            }
                        }

                        /* Both Request and SELECTED_DOMAIN_ID are missing. */
                        if ($this->domain === null) {
                            $statement = $connection->query("SELECT `url` FROM `Domain` WHERE `status` = 'A'");

                            /* Let's try to get this info from the Database still, hoping there's only one active domain */
                            if ($statement->rowCount() == 1 and $selectedDomain = $statement->fetchObject()) {
                                $this->domain = $selectedDomain->url;
                            }
                        }
                    } catch (\Exception $e) {
                    }
                } else {
                    throw new \Exception("Unable to find parameters configuration file.");
                }
            }
        }

        return $this->domain;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $rootDir = $this->getRootDir();

        if ($domain = $this->getDomain()) {
            /*
             * Imports config files config/domains/<domain>.ext.yml
             */
            $configurationFileExtensionList = ['configs', 'payment', 'route'];

            foreach ($configurationFileExtensionList as $ext) {
                $loader->load($rootDir . '/config/domains/' . $domain . '.' . $ext . '.yml');
            }
        }

        $loader->load($rootDir . '/config/config_' . $this->environment . '.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        $domain = empty($_SERVER['SERVER_NAME']) ? false : $_SERVER['SERVER_NAME'];

        if (!$domain && defined("SELECTED_DOMAIN_ID")) {
            $s = DIRECTORY_SEPARATOR;
            require_once EDIRECTORY_ROOT . "{$s}classes{$s}class_DatabaseHandler.php";
            $db = \DatabaseHandler::getMainConnection();

            $statement = $db->prepare("SELECT `url` FROM `Domain` WHERE `id` = :id");
            $statement->execute([":id" => SELECTED_DOMAIN_ID]);

            if ($result = $statement->fetchObject()) {
                $domain = $result->url;
            }
        }

        $domain = str_replace('www.', '', $domain);

        if ($this->isVagrantEnvironment()) {
            return '/dev/shm/edirectory/cache/' . $this->environment . '/' . $domain;
        }

        return $this->rootDir . '/cache/' . $this->environment . '/' . $domain;
    }

    /**
     * @return boolean
     */
    protected function isVagrantEnvironment()
    {
        return (getenv('HOME') === '/home/vagrant' || getenv('VAGRANT') === 'VAGRANT') && is_dir('/dev/shm');
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        if ($this->isVagrantEnvironment()) {
            return '/dev/shm/edirectory/logs';
        }

        return parent::getLogDir();
    }
}
