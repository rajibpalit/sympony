<?php

namespace ArcaSolutions\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocationFeatured
 *
 * @ORM\Table(name="Location_Featured")
 * @ORM\Entity(repositoryClass="ArcaSolutions\CoreBundle\Repository\LocationFeaturedRepository")
 */
class LocationFeatured
{
    /**
     * @var integer
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $domainId;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_level", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $locationLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $locationId;



    /**
     * Set domainId
     *
     * @param integer $domainId
     * @return LocationFeatured
     */
    public function setDomainId($domainId)
    {
        $this->domainId = $domainId;

        return $this;
    }

    /**
     * Get domainId
     *
     * @return integer 
     */
    public function getDomainId()
    {
        return $this->domainId;
    }

    /**
     * Set locationLevel
     *
     * @param integer $locationLevel
     * @return LocationFeatured
     */
    public function setLocationLevel($locationLevel)
    {
        $this->locationLevel = $locationLevel;

        return $this;
    }

    /**
     * Get locationLevel
     *
     * @return integer 
     */
    public function getLocationLevel()
    {
        return $this->locationLevel;
    }

    /**
     * Set locationId
     *
     * @param integer $locationId
     * @return LocationFeatured
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;

        return $this;
    }

    /**
     * Get locationId
     *
     * @return integer 
     */
    public function getLocationId()
    {
        return $this->locationId;
    }
}
