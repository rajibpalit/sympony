<?php

namespace ArcaSolutions\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blogcategory
 *
 * @ORM\Table(name="BlogCategory", uniqueConstraints={@ORM\UniqueConstraint(name="legacy_id", columns={"legacy_id"})}, indexes={@ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="active_post", columns={"active_post"}), @ORM\Index(name="title1", columns={"title"}), @ORM\Index(name="friendly_url1", columns={"friendly_url"}), @ORM\Index(name="level", columns={"level"}), @ORM\Index(name="keywords", columns={"keywords", "title"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\BlogBundle\Repository\BlogcategoryRepository")
 */
class Blogcategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="root_id", type="integer", nullable=false)
     */
    private $rootId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="left", type="integer", nullable=false)
     */
    private $left = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="right", type="integer", nullable=false)
     */
    private $right = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $categoryId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="thumb_id", type="integer", nullable=false)
     */
    private $thumbId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     */
    private $imageId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="featured", type="string", length=1, nullable=false)
     */
    private $featured = 'n';

    /**
     * @var string
     *
     * @ORM\Column(name="summary_description", type="string", length=255, nullable=false)
     */
    private $summaryDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_description", type="string", length=255, nullable=false)
     */
    private $seoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="page_title", type="string", length=255, nullable=false)
     */
    private $pageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=false)
     */
    private $friendlyUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=255, nullable=false)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keywords", type="string", length=255, nullable=false)
     */
    private $seoKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="active_post", type="integer", nullable=false)
     */
    private $activePost = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="full_friendly_url", type="text", nullable=true)
     */
    private $fullFriendlyUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="legacy_id", type="string", length=255, nullable=false)
     */
    private $legacyId;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="string", length=1, nullable=false)
     */
    private $enabled;

    /**
     * @var BlogCategory
     *
     * @ORM\OneToMany(targetEntity="ArcaSolutions\BlogBundle\Entity\BlogCategory", mappedBy="parent")
     * @ORM\OrderBy({"title" = "ASC"})
     */
    private $children;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\BlogBundle\Entity\BlogCategory", inversedBy="children")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToOne(targetEntity="ArcaSolutions\ImageBundle\Entity\Image", fetch="EAGER")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

    /**
     * Constructor
     *
     * ArrayCollection
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rootId
     *
     * @param integer $rootId
     * @return Blogcategory
     */
    public function setRootId($rootId)
    {
        $this->rootId = $rootId;

        return $this;
    }

    /**
     * Get rootId
     *
     * @return integer
     */
    public function getRootId()
    {
        return $this->rootId;
    }

    /**
     * Set left
     *
     * @param integer $left
     * @return Blogcategory
     */
    public function setLeft($left)
    {
        $this->left = $left;

        return $this;
    }

    /**
     * Get left
     *
     * @return integer
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set right
     *
     * @param integer $right
     * @return Blogcategory
     */
    public function setRight($right)
    {
        $this->right = $right;

        return $this;
    }

    /**
     * Get right
     *
     * @return integer
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Blogcategory
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return Blogcategory
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set thumbId
     *
     * @param integer $thumbId
     * @return Blogcategory
     */
    public function setThumbId($thumbId)
    {
        $this->thumbId = $thumbId;

        return $this;
    }

    /**
     * Get thumbId
     *
     * @return integer
     */
    public function getThumbId()
    {
        return $this->thumbId;
    }

    /**
     * Set imageId
     *
     * @param integer $imageId
     * @return Blogcategory
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Get imageId
     *
     * @return integer
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set featured
     *
     * @param string $featured
     * @return Blogcategory
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return string
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set summaryDescription
     *
     * @param string $summaryDescription
     * @return Blogcategory
     */
    public function setSummaryDescription($summaryDescription)
    {
        $this->summaryDescription = $summaryDescription;

        return $this;
    }

    /**
     * Get summaryDescription
     *
     * @return string
     */
    public function getSummaryDescription()
    {
        return $this->summaryDescription;
    }

    /**
     * Set seoDescription
     *
     * @param string $seoDescription
     * @return Blogcategory
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    /**
     * Get seoDescription
     *
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * Set pageTitle
     *
     * @param string $pageTitle
     * @return Blogcategory
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set friendlyUrl
     *
     * @param string $friendlyUrl
     * @return Blogcategory
     */
    public function setFriendlyUrl($friendlyUrl)
    {
        $this->friendlyUrl = $friendlyUrl;

        return $this;
    }

    /**
     * Get friendlyUrl
     *
     * @return string
     */
    public function getFriendlyUrl()
    {
        return $this->friendlyUrl;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Blogcategory
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set seoKeywords
     *
     * @param string $seoKeywords
     * @return Blogcategory
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seoKeywords = $seoKeywords;

        return $this;
    }

    /**
     * Get seoKeywords
     *
     * @return string
     */
    public function getSeoKeywords()
    {
        return $this->seoKeywords;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Blogcategory
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set activePost
     *
     * @param integer $activePost
     * @return Blogcategory
     */
    public function setActivePost($activePost)
    {
        $this->activePost = $activePost;

        return $this;
    }

    /**
     * Get activePost
     *
     * @return integer
     */
    public function getActivePost()
    {
        return $this->activePost;
    }

    /**
     * Set fullFriendlyUrl
     *
     * @param string $fullFriendlyUrl
     * @return Blogcategory
     */
    public function setFullFriendlyUrl($fullFriendlyUrl)
    {
        $this->fullFriendlyUrl = $fullFriendlyUrl;

        return $this;
    }

    /**
     * Get fullFriendlyUrl
     *
     * @return string
     */
    public function getFullFriendlyUrl()
    {
        return $this->fullFriendlyUrl;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Blogcategory
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set legacyId
     *
     * @param string $legacyId
     * @return Blogcategory
     */
    public function setLegacyId($legacyId)
    {
        $this->legacyId = $legacyId;

        return $this;
    }

    /**
     * Get legacyId
     *
     * @return string
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     * Set enabled
     *
     * @param string $enabled
     * @return Blogcategory
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set parentId
     *
     * @param BlogCategory $parent
     * @return BlogCategory
     */
    public function setParent(BlogCategory $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get Parent
     *
     * @return ArrayCollection
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get Children
     *
     * @return BlogCategory|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get active Items into category
     */
    public function getActive()
    {
        return $this->activePost;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Add children
     *
     * @param \ArcaSolutions\BlogBundle\Entity\BlogCategory $children
     * @return Blogcategory
     */
    public function addChild(\ArcaSolutions\BlogBundle\Entity\BlogCategory $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \ArcaSolutions\BlogBundle\Entity\BlogCategory $children
     */
    public function removeChild(\ArcaSolutions\BlogBundle\Entity\BlogCategory $children)
    {
        $this->children->removeElement($children);
    }
}
