<?php

namespace ArcaSolutions\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articlelevel
 *
 * @ORM\Table(name="ArticleLevel")
 * @ORM\Entity
 */
class Articlelevel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $value = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=30, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $theme = 'default';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="defaultlevel", type="string", length=1, nullable=false)
     */
    private $defaultlevel = 'n';

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=1, nullable=false)
     */
    private $detail = 'y';

    /**
     * @var integer
     *
     * @ORM\Column(name="images", type="integer", nullable=false)
     */
    private $images = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=1, nullable=false)
     */
    private $active = 'y';

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="featured", type="string", length=1, nullable=false)
     */
    private $featured = 'y';



    /**
     * Set value
     *
     * @param integer $value
     * @return Articlelevel
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return Articlelevel
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Articlelevel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set defaultlevel
     *
     * @param string $defaultlevel
     * @return Articlelevel
     */
    public function setDefaultlevel($defaultlevel)
    {
        $this->defaultlevel = $defaultlevel;

        return $this;
    }

    /**
     * Get defaultlevel
     *
     * @return string 
     */
    public function getDefaultlevel()
    {
        return $this->defaultlevel;
    }

    /**
     * Set detail
     *
     * @param string $detail
     * @return Articlelevel
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set images
     *
     * @param integer $images
     * @return Articlelevel
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return integer 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Articlelevel
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set active
     *
     * @param string $active
     * @return Articlelevel
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Articlelevel
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
     * Set featured
     *
     * @param string $featured
     * @return Articlelevel
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
}
