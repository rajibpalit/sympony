<?php

namespace ArcaSolutions\BannersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bannerlevel
 *
 * @ORM\Table(name="BannerLevel")
 * @ORM\Entity(repositoryClass="ArcaSolutions\BannersBundle\Repository\BannerlevelRepository")
 */
class Bannerlevel
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
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price = '0.00';

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=false)
     */
    private $width = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=false)
     */
    private $height = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="impression_block", type="integer", nullable=false)
     */
    private $impressionBlock = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="impression_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $impressionPrice = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=1, nullable=false)
     */
    private $active = 'y';

    /**
     * @var string
     *
     * @ORM\Column(name="popular", type="string", length=1, nullable=false)
     */
    private $popular;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="displayName", type="string", length=255, nullable=false)
     */
    private $displayname;



    /**
     * Set value
     *
     * @param integer $value
     * @return Bannerlevel
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
     * @return Bannerlevel
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
     * @return Bannerlevel
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
     * @return Bannerlevel
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
     * Set price
     *
     * @param string $price
     * @return Bannerlevel
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
     * Set width
     *
     * @param integer $width
     * @return Bannerlevel
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Bannerlevel
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set impressionBlock
     *
     * @param integer $impressionBlock
     * @return Bannerlevel
     */
    public function setImpressionBlock($impressionBlock)
    {
        $this->impressionBlock = $impressionBlock;

        return $this;
    }

    /**
     * Get impressionBlock
     *
     * @return integer
     */
    public function getImpressionBlock()
    {
        return $this->impressionBlock;
    }

    /**
     * Set impressionPrice
     *
     * @param string $impressionPrice
     * @return Bannerlevel
     */
    public function setImpressionPrice($impressionPrice)
    {
        $this->impressionPrice = $impressionPrice;

        return $this;
    }

    /**
     * Get impressionPrice
     *
     * @return string
     */
    public function getImpressionPrice()
    {
        return $this->impressionPrice;
    }

    /**
     * Set active
     *
     * @param string $active
     * @return Bannerlevel
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
     * Set popular
     *
     * @param string $popular
     * @return Bannerlevel
     */
    public function setPopular($popular)
    {
        $this->popular = $popular;

        return $this;
    }

    /**
     * Get popular
     *
     * @return string
     */
    public function getPopular()
    {
        return $this->popular;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Bannerlevel
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
     * Set displayname
     *
     * @param string $displayname
     * @return Bannerlevel
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname
     *
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }
}
