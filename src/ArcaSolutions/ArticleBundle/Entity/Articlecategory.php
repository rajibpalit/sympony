<?php

namespace ArcaSolutions\ArticleBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Articlecategory
 *
 * @ORM\Table(name="ArticleCategory", indexes={@ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="active_article", columns={"active_article"}), @ORM\Index(name="title1", columns={"title"}), @ORM\Index(name="friendly_url1", columns={"friendly_url"}), @ORM\Index(name="keywords", columns={"keywords", "title"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\ArticleBundle\Repository\ArticlecategoryRepository")
 */
class Articlecategory
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
     * @ORM\Column(name="active_article", type="integer", nullable=false)
     */
    private $activeArticle = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="string", length=1, nullable=false)
     */
    private $enabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_sub", type="integer", nullable=false)
     */
    private $countSub;

    /**
     * @var ArticleCategory
     *
     * @ORM\OneToMany(targetEntity="ArcaSolutions\ArticleBundle\Entity\ArticleCategory", mappedBy="parent")
     * @ORM\OrderBy({"title" = "ASC"})
     */
    private $children;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\ArticleBundle\Entity\ArticleCategory", inversedBy="children")
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
     * Set title
     *
     * @param string $title
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * @return Articlecategory
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
     * Set activeArticle
     *
     * @param integer $activeArticle
     * @return Articlecategory
     */
    public function setActiveArticle($activeArticle)
    {
        $this->activeArticle = $activeArticle;

        return $this;
    }

    /**
     * Get activeArticle
     *
     * @return integer
     */
    public function getActiveArticle()
    {
        return $this->activeArticle;
    }

    /**
     * Set enabled
     *
     * @param string $enabled
     * @return Articlecategory
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
     * Set countSub
     *
     * @param integer $countSub
     * @return Articlecategory
     */
    public function setCountSub($countSub)
    {
        $this->countSub = $countSub;

        return $this;
    }

    /**
     * Get countSub
     *
     * @return integer
     */
    public function getCountSub()
    {
        return $this->countSub;
    }

    /**
     * Set parentId
     *
     * @param ArticleCategory $parent
     * @return ArticleCategory
     */
    public function setParent(ArticleCategory $parent)
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
     * @return ArticleCategory|ArrayCollection
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
        return $this->activeArticle;
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
}
