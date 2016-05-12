<?php

namespace ArcaSolutions\SearchBundle\Entity\Elasticsearch;

use Elastica\Result;

class Category
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $friendlyUrl;
    /**
     * @var string
     */
    private $module;
    /**
     * @var string
     */
    private $parentId;
    /**
     * @var array
     */
    private $subCategoryId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $content;
    /**
     * @var array
     */
    private $seo;
    /**
     * @var string
     */
    private $description;

    function __construct($id, $content, $friendlyUrl, $module, $parentId, $subCategoryId, $title, $seo, $description)
    {
        $this->id = $id;
        $this->friendlyUrl = $friendlyUrl;
        $this->module = $module;
        $this->parentId = $parentId;
        $this->subCategoryId = $subCategoryId;
        $this->title = $title;
        $this->content = $content;
        $this->seo = $seo;
        $this->description = $description;
    }

    /**
     * @param $result Result
     * @return Category
     */
    public static function buildFromElasticResult($result)
    {
        $return = null;

        /* @var $id string */
        /* @var $content string */
        /* @var $title string */
        /* @var $module string */
        /* @var $friendlyUrl string */
        /* @var $parentId string */
        /* @var $subCategoryId array */
        /* @var $description array */
        /* @var $seo array */
        extract($result->getData());

        if ($id = $result->getId()) {
            $return = new Category(
                $id,
                $content,
                $friendlyUrl,
                $module,
                $parentId,
                (array)$subCategoryId,
                $title,
                $seo,
                $description
            );
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFriendlyUrl()
    {
        return $this->friendlyUrl;
    }

    /**
     * @param string $friendlyUrl
     */
    public function setFriendlyUrl($friendlyUrl)
    {
        $this->friendlyUrl = $friendlyUrl;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param string $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return array
     */
    public function getSubCategoryId()
    {
        return $this->subCategoryId;
    }

    /**
     * @param array $subCategoryId
     */
    public function setSubCategoryId($subCategoryId)
    {
        $this->subCategoryId = $subCategoryId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * @param array $seo
     */
    public function setSeo($seo)
    {
        $this->seo = $seo;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
