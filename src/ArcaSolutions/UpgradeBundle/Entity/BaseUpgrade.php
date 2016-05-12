<?php

namespace ArcaSolutions\UpgradeBundle\Entity;

use ArcaSolutions\UpgradeBundle\Services\Upgrade;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Yaml\Parser;

abstract class BaseUpgrade
{
    /**
     * @var string
     */
    protected $version;
    /**
     * @var Upgrade
     */
    protected $upgradeService;
    /**
     * @var object
     */
    protected $domainInfo;

    /**
     * @param Upgrade $upgradeService
     * @param $domainInfo
     */
    public function __construct(Upgrade $upgradeService, $domainInfo)
    {
        $this->upgradeService = $upgradeService;
        $this->domainInfo = $domainInfo;
    }

    /**
     * Returns this patch's version
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Runs code required to make more specific and delicate changes to the program structure or database.
     * @return bool
     */
    abstract public function execute();

    /**
     * Writes either to the output, if exists, or to the error log files.
     * @param $text
     */
    protected function logError($text)
    {
        if ($output = $this->upgradeService->getOutput()) {
            $output->writeln("<error>[ERROR]</error> Upgrade [Version {$this->version}] : " . $text);
        } else {
            $this->upgradeService->getContainer()->get("logger")->error("[ERROR] Upgrade [Version {$this->version}] : " . $text);
        }
    }

    /**
     * Writes either to the output, if exists, or to the info log files.
     * @param $text
     */
    protected function logInfo($text)
    {
        if ($output = $this->upgradeService->getOutput()) {
            $output->writeln("<info>[INFO]</info> Upgrade [Version {$this->version}] : " . $text);
        } else {
            $this->upgradeService->getContainer()->get("logger")->error("[ERROR] Upgrade [Version {$this->version}] : " . $text);
        }
    }

    /**
     * Resets elasticsearch index
     */
    protected function rebuildElasticsearchIndex()
    {
        $this->logInfo("Rebuilding Elasticsearch Index.");
        $searchEngine = $this->upgradeService->getContainer()->get("search.engine");
        $domainConfigurationFile = $this->upgradeService->getConfigurationFolder() . DIRECTORY_SEPARATOR . "domain.yml";

        if (file_exists($domainConfigurationFile)) {
            /* Loads domain Settings in order to get ES index name */
            $yaml = new Parser();
            $domainSettings = $yaml->parse(file_get_contents($domainConfigurationFile));

            /* Loads elasticsearch configuration in order to get server address and port */
            $elasticServers = $searchEngine->getElasticsearchServers();

            /* Path to River Files */
            $s = DIRECTORY_SEPARATOR;
            $jsonBasePath = $this->upgradeService->getRootFolder() . "{$s}ElasticConfigs{$s}RiverConfigs{$s}JSON";
            $riverFiles = [
                'badges'     => $jsonBasePath . "{$s}badges.json",
                'categories' => $jsonBasePath . "{$s}categories.json",
                'modules'    => $jsonBasePath . "{$s}modules.json",
            ];

            /* Setting necessary URLS and variables */
            $indexName = $domainSettings['multi_domain']['hosts'][$this->domainInfo->url]['elastic'];
            $indexHost = $elasticServers['servers']['server1']['host'];
            $indexPort = $elasticServers['servers']['server1']['port'];

            $url = "http://{$indexHost}:{$indexPort}/{$indexName}";
            $riverUrl = "http://{$indexHost}:{$indexPort}/_river/{$indexName}";

            /* Removes all elasticsearch content prior to rebuilding */
            $this->logInfo("Clearing rivers...");
            foreach ($riverFiles as $river => $file) {
                if ($this->sendCurl('delete', $riverUrl . $river)) {
                    $this->logInfo("River {$river} is GONE...");
                } else {
                    $this->logError("Failed to delete {$river} river.");
                }
            }

            if ($this->sendCurl('delete', $url)) {
                $this->logInfo("Index {$indexName} is GONE...");
            } else {
                $this->logError("Failed to delete {$indexName} index.");
            }

            /* Creates new index */
            $indexCreationFile = $jsonBasePath . DIRECTORY_SEPARATOR . "IndexCreation.json";

            $this->logInfo("Creating new index...");
            if (file_exists($indexCreationFile)) {
                $indexCreationContent = file_get_contents($indexCreationFile);

                /* Get active language for current domain */
                $domainConnection = $this->upgradeService->getDomainConnection();
                $result = $domainConnection->query("SELECT id FROM `Lang` WHERE `lang_enabled` = 'y'");

                if ($languageEntry = $result->fetchObject()) {
                    $language = $languageEntry->id;
                    $this->logInfo("Language found : {$language}");
                } else {
                    $language = "en_us";
                    $this->logError("Language not found. Using 'en_US' as default");
                }

                /* Replaces analyzer language in index creation script */
                $analyzerLanguage = $searchEngine->getAnalyzerForLanguage($language);
                $indexCreationContent = str_replace("%language%", $analyzerLanguage, $indexCreationContent);

                /* Attempts to create index */
                if ($this->sendCurl('post', $url, ['body' => $indexCreationContent])) {
                    $this->logInfo("New index created");

                    $this->logInfo("Rebuilding ES location index... This may take some minutes, so hold on...");
                    $this->upgradeService->getContainer()->get("location.synchronization")->generateAllLocations();
                    $this->logInfo("ES Location index successfully populated. Thanks for waiting.");

                    foreach ($riverFiles as $river => $file) {
                        if (file_exists($file)) {
                            $this->logInfo("Found river : {$river}.");

                            /* Replaces configuration variables */
                            $body = str_replace(
                                [
                                    '%mysql_host%',
                                    '%mysql_user%',
                                    '%mysql_pass%',
                                    '%mysql_database%',
                                    '%elastic_index%',

                                ],
                                [
                                    $this->domainInfo->database_host,
                                    $this->domainInfo->database_username,
                                    $this->domainInfo->database_password,
                                    $this->upgradeService->getDomainDatabaseName(),
                                    $indexName,
                                ],
                                file_get_contents($file)
                            );

                            if ($this->sendCurl('post', $riverUrl . $river . '/_meta', ['body' => $body])) {
                                $this->logInfo("River [{$river}] successfully registered.");
                            } else {
                                $this->logError("Failed to register [{$river}] river.");
                            }
                        } else {
                            $this->logError("River [{$river}] file could not be located.");
                        }
                    }
                } else {
                    $this->logError("Failed to create Index.");
                }
            } else {
                $this->logError("Index creation file is missing. ({$indexCreationFile})");
            }
        } else {
            $this->logError("Domain configuration file is missing. ({$domainConfigurationFile})");
        }
    }

    /**
     * Pushes up a curl request of $type to the $url specified
     *
     * @param $type
     * @param $url
     * @param array $options
     * @return bool
     */
    protected function sendCurl($type, $url, array $options = [])
    {
        $return = false;
        $guzzleClient = new Client();

        try {
            switch ($type) {
                case 'get':
                    $guzzleClient->get($url, $options);
                    $return = true;
                    break;
                case 'post':
                    $guzzleClient->post($url, $options);
                    $return = true;
                    break;
                case 'delete':
                    $guzzleClient->delete($url);
                    $return = true;
                    break;
            }
        } catch (RequestException $e) {
        }

        return $return;
    }
}
