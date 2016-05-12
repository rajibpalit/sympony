<?php

namespace ArcaSolutions\ListingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListingFeaturedtemp
 *
 * @ORM\Table(name="Listing_FeaturedTemp", indexes={@ORM\Index(name="Listing_FeaturedTemp", columns={"listing_level", "status", "listing_id", "random_number"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\TestBundle\Entity\ListingFeaturedtempRepository")
 */
class ListingFeaturedtemp
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
     * @ORM\Column(name="listing_id", type="integer", nullable=false)
     */
    private $listingId;

    /**
     * @var integer
     *
     * @ORM\Column(name="listing_level", type="integer", nullable=false)
     */
    private $listingLevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="random_number", type="bigint", nullable=false)
     */
    private $randomNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status;



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
     * Set listingId
     *
     * @param integer $listingId
     * @return ListingFeaturedtemp
     */
    public function setListingId($listingId)
    {
        $this->listingId = $listingId;

        return $this;
    }

    /**
     * Get listingId
     *
     * @return integer
     */
    public function getListingId()
    {
        return $this->listingId;
    }

    /**
     * Set listingLevel
     *
     * @param integer $listingLevel
     * @return ListingFeaturedtemp
     */
    public function setListingLevel($listingLevel)
    {
        $this->listingLevel = $listingLevel;

        return $this;
    }

    /**
     * Get listingLevel
     *
     * @return integer
     */
    public function getListingLevel()
    {
        return $this->listingLevel;
    }

    /**
     * Set randomNumber
     *
     * @param integer $randomNumber
     * @return ListingFeaturedtemp
     */
    public function setRandomNumber($randomNumber)
    {
        $this->randomNumber = $randomNumber;

        return $this;
    }

    /**
     * Get randomNumber
     *
     * @return integer
     */
    public function getRandomNumber()
    {
        return $this->randomNumber;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ListingFeaturedtemp
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
