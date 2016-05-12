<?php

namespace ArcaSolutions\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassifiedLocationcounter
 *
 * @ORM\Table(name="Classified_LocationCounter")
 * @ORM\Entity(repositoryClass="ArcaSolutions\ClassifiedBundle\Repository\ClassifiedLocationcounterRepository")
 */
class ClassifiedLocationcounter
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
     * @ORM\Column(name="location_level", type="integer", nullable=false)
     */
    private $locationLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer", nullable=false)
     */
    private $locationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="full_friendly_url", type="string", length=255, nullable=false)
     */
    private $fullFriendlyUrl;



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
     * Set locationLevel
     *
     * @param integer $locationLevel
     * @return ClassifiedLocationcounter
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
     * @return ClassifiedLocationcounter
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

    /**
     * Set count
     *
     * @param integer $count
     * @return ClassifiedLocationcounter
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ClassifiedLocationcounter
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
     * Set fullFriendlyUrl
     *
     * @param string $fullFriendlyUrl
     * @return ClassifiedLocationcounter
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
}
