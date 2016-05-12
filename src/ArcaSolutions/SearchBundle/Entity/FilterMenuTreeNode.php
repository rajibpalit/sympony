<?php

namespace ArcaSolutions\SearchBundle\Entity;

class FilterMenuTreeNode {
    /**
     * The Parent node
     * @var FilterMenuTreeNode|null $parent
     */
    public $parent;
    /**
     * The Parent node Id
     * @var string
     */
    public $parentId;
    /**
     * An array of children
     * @var FilterMenuTreeNode[]
     */
    public $children;
    /**
     * An array of all children Ids
     * @var string[]
     */
    public $childrenId;
    /**
     * The category title
     * @var string
     */
    public $title;
    /**
     * The category friendly url token
     * @var string
     */
    public $friendlyUrl;
    /**
     * The module name
     * @var string
     */
    public $module;
    /**
     * The category Id
     * @var string
     */
    public $id;
    /**
     * Whether or not this category was selected and is actively filtering
     * @var bool
     */
    public $isSelected;
    /**
     * Whether or not this category is a parent of a selected category
     * @var bool
     */
    public $isParentOfSelected;
    /**
     * The relative URL to toggle this filter
     * @var string
     */
    public $searchPageUrl;
    /**
     * The amount of results within this category
     * @var int
     */
    public $resultCount;

    function __construct($parent, $children, $title, $friendlyUrl, $module, $id, $isSelected, $searchPageUrl, $resultCount, $isParentOfSelected = false)
    {
        $this->parentId = $parent;
        $this->childrenId = (array)$children;
        $this->title = $title;
        $this->friendlyUrl = $friendlyUrl;
        $this->module = $module;
        $this->id = $id;
        $this->isSelected = $isSelected;
        $this->searchPageUrl = $searchPageUrl;
        $this->resultCount = (int)$resultCount;
        $this->isParentOfSelected = $isParentOfSelected;
    }
}
