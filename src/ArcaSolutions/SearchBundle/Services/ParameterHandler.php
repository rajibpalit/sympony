<?php

namespace ArcaSolutions\SearchBundle\Services;


use ArcaSolutions\CoreBundle\Services\Utility;
use ArcaSolutions\ReportsBundle\Services\ReportHandler;
use ArcaSolutions\SearchBundle\Exceptions\InvalidRoutePathException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ParameterHandler
{
    /**
     * @var string
     */
    private static $routePattern = '/\w+(?=_search_(\d+))/i';

    /**
     * @var array
     */
    private $routeParameters = [];
    /**
     * @var array
     */
    private $queryParameters = [];
    /**
     * @var string
     */
    private $routePrefix;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var int
     */
    private $originalRouteParameterCount;
    /**
     * @var \string[]
     */
    private $urlFormat;

    /**
     * @param ContainerInterface $container
     *
     * @throws InvalidRoutePathException
     */
    function __construct(ContainerInterface $container)
    {
        $searchEngine = $container->get("search.engine");
        $this->urlFormat = $searchEngine->getFriendlyUrlOrder();

        $this->container = $container;

        $request = $container->get("request");
        $this->routeParameters["keyword"] = [];

        if (!preg_match(self::$routePattern, $request->get("_route"), $routeMatches)) {
            $this->routePrefix = "global";
            $this->originalRouteParameterCount = 0;
        } else {
            $this->routePrefix = reset($routeMatches);
            $this->originalRouteParameterCount = (int)end($routeMatches);

            $activeModules = $searchEngine->getActiveModules();

            $dateFormatString = $this->container->get('languagehandler')->getDateFormat();
            $dateFormat = preg_replace("/[^\w]/", "-", $dateFormatString);

            for ($i = 0; $i < $this->originalRouteParameterCount; $i++) {
                $parameterString = strtolower($request->get("a{$i}"));
                $parameterInformation = Utility::convertStringToArray($parameterString);
                $parameterType = "keyword";

                if (empty($this->routeParameters["module"]) and $modules = array_intersect($parameterInformation, $activeModules)) {
                    $parameterType = "module";
                    $parameterInformation = $modules;
                } else if (empty($this->routeParameters["startDate"]) and $date = \DateTime::createFromFormat($dateFormat, $parameterString)) {
                    $parameterType = "startDate";
                    $parameterInformation = $parameterString;
                } else if (empty($this->routeParameters["endDate"]) and $date = \DateTime::createFromFormat($dateFormat, $parameterString)) {
                    $parameterType = "endDate";
                    $parameterInformation = $parameterString;
                } else {
                    if ($elasticType = $searchEngine->getFriendlyUrlType($parameterInformation) and empty($this->routeParameters[$elasticType])) {
                        $parameterType = $elasticType;
                    }
                }

                /* Keyword is treated differently in order to avoid overriding the information
                 * In effect, this basically treats everything repeated or unknown as keywords,
                 * even if its already set */
                if ($parameterType == "keyword") {
                    $this->routeParameters["keyword"] = array_merge($parameterInformation,
                        $this->routeParameters[$parameterType]);
                } else {
                    $this->routeParameters[$parameterType] = $parameterInformation;
                }
            }
        }

        foreach ($this->container->get("request")->query->all() as $key => $value) {
            $this->queryParameters[$key] = Utility::convertStringToArray($value, "-");
        }
    }

    //region RouteParameter
    /**
     * @param string $node
     *
     * @return array
     */
    public function getRouteParameter($node = null)
    {
        if ($node) {
            $return = isset($this->routeParameters[$node]) ? $this->routeParameters[$node] : [];
        } else {
            $return = $this->routeParameters;
        }

        return $return;
    }

    public function toggleRouteParameter($node, $information)
    {
        if (isset($this->routeParameters[$node]) && in_array($information, $this->routeParameters[$node])) {
            $this->removeRouteParameter($node, $information);
        } else {
            $this->addRouteParameter($node, $information);
        }
    }

    /**
     * @param string $node
     * @param string $information
     */
    public function removeRouteParameter($node, $information = null)
    {
        if (isset($this->routeParameters[$node])) {
            if ($information === null) {
                unset($this->routeParameters[$node]);
            } else {
                $this->routeParameters[$node] = array_diff($this->routeParameters[$node], [$information]);
            }
        }
    }

    /**
     * @param string $node
     * @param array $information
     */
    public function addRouteParameter($node, $information)
    {
        $this->routeParameters[$node][] = $information;
    }

    /**
     * @param string $node
     */
    public function clearRouteParameter($node)
    {
        unset($this->routeParameters[$node]);
    }

    public function clearAllRouteParameters()
    {
        $this->routeParameters = [];
    }
    //endregion

    //region QueryParameter

    /**
     * @param string $node
     *
     * @return array
     */
    public function getQueryParameter($node = null)
    {
        if ($node) {
            $return = isset($this->queryParameters[$node]) ? $this->queryParameters[$node] : [];
        } else {
            $return = $this->queryParameters;
        }

        return $return;
    }

    public function toggleQueryParameter($node, $information)
    {
        if (!empty($this->queryParameters[$node]) && in_array($information, $this->queryParameters[$node])) {
            $this->removeQueryParameter($node, $information);
        } else {
            $this->addQueryParameter($node, $information);
        }
    }

    /**
     * @param string $node
     * @param string $information
     */
    public function removeQueryParameter($node, $information = null)
    {
        if (!empty($this->queryParameters[$node])) {
            if ($information === null) {
                unset($this->queryParameters[$node]);
            } else {
                $this->queryParameters[$node] = array_diff($this->queryParameters[$node], [$information]);
            }
        }
    }

    /**
     * @param string $node
     * @param array $information
     */
    public function addQueryParameter($node, $information)
    {
        $this->queryParameters[$node][] = $information;
    }

    /**
     * @param string $node
     */
    public function clearQueryParameter($node)
    {
        unset($this->queryParameters[$node]);
    }

    public function clearAllQueryParameters()
    {
        $this->queryParameters = [];
    }

    //endregion

    public function buildPathTo($page = 1)
    {
        $return = null;
        $router = $this->container->get("router");

        /* This removes all empty arrays withing the information array, so they won't count towads the URL parameters */
        $information = array_filter($this->routeParameters);

        if ($count = count($information)) {
            $route = "global_search_{$count}";

            $routeParameters = [
                "page" => $this->container->get("search.engine")->convertToPaginationFormat($page)
            ];

            $parameterNumber = 0;

            foreach ($this->urlFormat as $urlitem) {
                if (isset($information[$urlitem])) {
                    $routeParameters["a{$parameterNumber}"] = implode(",", (array)$information[$urlitem]);
                    $parameterNumber++;
                }
            }

            $queryParametersArray = array_filter($this->queryParameters);

            $queryParameters = array_map(function ($a) {
                return implode("-", $a);
            }, $queryParametersArray);

            /* Route parameters are more important than query parameters. So they are passed as the second argument
             * to the merge function in order to retain their value in case a query parameter accidentally overwrote one */
            $routeParameters = array_merge($queryParameters, $routeParameters);
        } else {
            $route = "{$this->routePrefix}_homepage";
            $routeParameters = [];
        }

        return $router->generate($route, $routeParameters);
    }

    /**
     * @return string
     */
    public function getReportModule()
    {
        switch ($this->routePrefix) {
            case "article":
                $return = ReportHandler::SEARCH_SECTION_ARTICLE;
                break;
            case "blog":
                $return = ReportHandler::SEARCH_SECTION_BLOG;
                break;
            case "classified":
                $return = ReportHandler::SEARCH_SECTION_CLASSIFIED;
                break;
            case "listing":
                $return = ReportHandler::SEARCH_SECTION_LISTING;
                break;
            case "event":
                $return = ReportHandler::SEARCH_SECTION_EVENT;
                break;
            case "deal":
                $return = ReportHandler::SEARCH_SECTION_DEAL;
                break;
            case "global":
            default:
                $return = ReportHandler::SEARCH_SECTION_GLOBAL;
                break;
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getRoutePrefix()
    {
        return $this->routePrefix;
    }

    /**
     * @param string $routePrefix
     */
    public function setRoutePrefix($routePrefix)
    {
        $this->routePrefix = $routePrefix;
    }
}

