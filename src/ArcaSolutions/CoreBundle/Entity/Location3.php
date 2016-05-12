<?php

namespace ArcaSolutions\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location3
 *
 * @ORM\Table(name="Location_3", indexes={@ORM\Index(name="friendly_url", columns={"friendly_url"}), @ORM\Index(name="state_id", columns={"location_2"}), @ORM\Index(name="name", columns={"name"}), @ORM\Index(name="location_2_level", columns={"location_1", "location_2"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\CoreBundle\Repository\Location3Repository")
 */
class Location3
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
     * @ORM\Column(name="location_2", type="integer", nullable=false)
     */
    private $location2 = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="location_1", type="integer", nullable=false)
     */
    private $location1 = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="abbreviation", type="string", length=100, nullable=false)
     */
    private $abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=false)
     */
    private $friendlyUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_description", type="string", length=255, nullable=false)
     */
    private $seoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keywords", type="string", length=255, nullable=false)
     */
    private $seoKeywords;



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
     * Set location2
     *
     * @param integer $location2
     * @return Location3
     */
    public function setLocation2($location2)
    {
        $this->location2 = $location2;

        return $this;
    }

    /**
     * Get location2
     *
     * @return integer 
     */
    public function getLocation2()
    {
        return $this->location2;
    }

    /**
     * Set location1
     *
     * @param integer $location1
     * @return Location3
     */
    public function setLocation1($location1)
    {
        $this->location1 = $location1;

        return $this;
    }

    /**
     * Get location1
     *
     * @return integer 
     */
    public function getLocation1()
    {
        return $this->location1;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Location3
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
     * Set abbreviation
     *
     * @param string $abbreviation
     * @return Location3
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string 
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * Set friendlyUrl
     *
     * @param string $friendlyUrl
     * @return Location3
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
     * Set seoDescription
     *
     * @param string $seoDescription
     * @return Location3
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
     * Set seoKeywords
     *
     * @param string $seoKeywords
     * @return Location3
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
}
