<?php

namespace ArcaSolutions\ElasticsearchBundle\Services\Synchronization;


use ArcaSolutions\CoreBundle\Search\BaseConfiguration;
use ArcaSolutions\ElasticsearchBundle\Services\Synchronization\Modules\BaseSynchronizable;
use Elastica\Document;
use Elastica\Script;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Synchronization
{
    /**
     * Enumerator for main database
     */
    const DATABASE_MAIN = 1;
    /**
     * Enumerator for domain database
     */
    const DATABASE_DOMAIN = 2;
    /**
     * Limit of items upon which a bulk will be sent
     */
    const BULK_THRESHOLD = 250;

    private $synchronizables = [];
    /**
     * @var ContainerInterface
     */
    protected $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    function __destruct()
    {
        $this->synchronize();
    }

    /**
     * @param $module BaseSynchronizable
     * Inserts or updates itens into elasticsearch
     */
    public function upsertES($module)
    {
        try {
            if ($ids = $module->getUpsertStash()) {
                $elasticaClient = $this->container->get("search.engine")->getElasticaClient();

                if ($module->getUpsertFormat() === BaseSynchronizable::ID_UPSERT) {
                    /* @var $databaseConnection string */
                    $query = $this->getQuery($module);
                    /* @var $configuration BaseConfiguration */
                    $configuration = $this->container->get($module->getConfigurationService());
                    /* @var $databaseConnection \PDO */
                    $databaseConnection = $this->getDatabase($module->getDatabaseType());

                    if ($configuration and $databaseConnection and $query) {

                        $fullQuery = str_replace("%s", implode(", ", $ids), $query);

                        if ($response = $databaseConnection->query($fullQuery)) {

                            $indexName = $this->container->get("search.engine")->getElasticIndexName();

                            $documentsToUpdate = [];

                            while ($element = $response->fetch(\PDO::FETCH_ASSOC)) {

                                if ($jsonObject = $module->extractFromResult($element)) {
                                    $document = new Document(
                                        $jsonObject["_id"],
                                        $jsonObject,
                                        $configuration->getElasticType(),
                                        $indexName
                                    );

                                    $document->setDocAsUpsert(true);

                                    $documentsToUpdate[] = $document;
                                }

                                if (count($documentsToUpdate) > Synchronization::BULK_THRESHOLD) {
                                    $elasticaClient->updateDocuments($documentsToUpdate);
                                    $documentsToUpdate = [];
                                }
                            }

                            $documentsToUpdate and $elasticaClient->updateDocuments($documentsToUpdate);
                        }
                    }
                } else {
                    $elasticaClient->updateDocuments($module->getUpsertStash());
                }

                $module->clearUpsertStash();
            }
        } catch (\Exception $e) {
            $this->container->get("logger")->critical("Elasticsearch Synchronization Failure", ["exception" => $e ]);
        }
    }

    /**
     * @param $module BaseSynchronizable
     * Removes items from elasticsearch
     */
    public function deleteES($module)
    {
        try {
            if ($ids = $module->getDeleteStash()) {

                /* @var BaseConfiguration $configuration */
                $configuration = $this->container->get($module->getConfigurationService());
                $elasticaClient = $this->container->get("search.engine")->getElasticaClient();
                $indexName = $this->container->get("search.engine")->getElasticIndexName();

                $elasticaClient->getIndex($indexName)->getType($configuration->getElasticType())->deleteIds($ids);

                $module->clearDeleteStash();
            }

        } catch (\Exception $e) {
            $this->container->get("logger")->critical("Elasticsearch Synchronization Failure", ["exception" => $e ]);
        }
    }

    /**
     * @param $module BaseSynchronizable
     * Updates the view count of items in Elasticsearch
     */
    public function updateViewsES($module)
    {
        try {
            if ($ids = $module->getViewUpdateStash()) {
                /* @var BaseConfiguration $configuration */
                $configuration = $this->container->get($module->getConfigurationService());
                $indexName = $this->container->get("search.engine")->getElasticIndexName();
                $elasticaClient = $this->container->get("search.engine")->getElasticaClient();

                $documentsToUpdate = [];
                $data = new Script("updateView");

                foreach ($ids as $id) {
                    $documentsToUpdate[] = new Document(
                        $id,
                        $data,
                        $configuration->getElasticType(),
                        $indexName
                    );
                }

                $documentsToUpdate and $elasticaClient->updateDocuments($documentsToUpdate);

                $module->clearViewUpdateStash();
            }

        } catch (\Exception $e) {
        }
    }

    /**
     * @param $module BaseSynchronizable
     * Sets the average review for items in elasticsearch
     */
    public function updateAverageReviewES($module)
    {
        try {
            if ($ids = $module->getAverageReviewUpdateStash()) {
                /* @var BaseConfiguration $configuration */
                $configuration = $this->container->get($module->getConfigurationService());
                $indexName = $this->container->get("search.engine")->getElasticIndexName();
                $elasticaClient = $this->container->get("search.engine")->getElasticaClient();

                $documentsToUpdate = [];

                foreach ($ids as $id => $reviewValue) {
                    $data = ["averageReview" => $reviewValue];

                    $documentsToUpdate[] = new Document(
                        $id,
                        $data,
                        $configuration->getElasticType(),
                        $indexName
                    );
                }

                $documentsToUpdate and $elasticaClient->updateDocuments($documentsToUpdate);

                $module->clearAverageReviewUpdateStash();
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * @param $module BaseSynchronizable
     * @return null|string
     */
    private function getQuery($module)
    {
        $returnValue = [];

        $filename = $this->getSQLFileRoot() . $module->getSQLQueryFile();

        if (file_exists($filename)) {
            $returnValue[] = file_get_contents($filename);

            if ($condition = $module->getSQLConditional()) {
                $returnValue[] = $condition;
            }
        }

        return implode(" ", $returnValue);
    }

    /**
     * @param $id
     * @return null|\PDO
     */
    private function getDatabase($id)
    {
        $connection = null;

        switch ($id) {
            case self::DATABASE_DOMAIN:
                $connection = \DatabaseHandler::getDomainConnection();
                break;
            case self::DATABASE_MAIN:
                $connection = \DatabaseHandler::getMainConnection();
                break;
        }

        return $connection;
    }

    /**
     * @return string
     */
    public function getSQLFileRoot()
    {
        return $this->container->get("kernel")->getRootDir() . "/../ElasticConfigs/RiverConfigs/SQL/";
    }

    /**
     * @param string $item
     */
    public function addItem($item)
    {
        if (!in_array($item, $this->synchronizables)) {
            $this->synchronizables[] = $item;
        }
    }

    /**
     * Performs stored operations on Elasticsearch.
     */
    public function synchronize()
    {
        foreach ($this->synchronizables as $synchronizable) {
            $this->upsertES($synchronizable);
            $this->deleteES($synchronizable);
            $this->updateViewsES($synchronizable);
            $this->updateAverageReviewES($synchronizable);
        }
    }
}
