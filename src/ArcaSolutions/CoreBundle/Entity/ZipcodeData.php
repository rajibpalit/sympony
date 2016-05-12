<?php

namespace ArcaSolutions\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZipcodeData
 *
 * @ORM\Table(name="ZipCode_Data", indexes={@ORM\Index(name="Country", columns={"Country"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\CoreBundle\Repository\ZipcodeDataRepository")
 */
class ZipcodeData
{
    /**
     * @var string
     *
     * @ORM\Column(name="ZipCode", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="Country", type="string", length=2, nullable=false)
     */
    private $country;

    /**
     * @var float
     *
     * @ORM\Column(name="Latitude", type="float", precision=10, scale=6, nullable=false)
     */
    private $latitude = '0.000000';

    /**
     * @var float
     *
     * @ORM\Column(name="Longitude", type="float", precision=10, scale=6, nullable=false)
     */
    private $longitude = '0.000000';



    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return ZipcodeData
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return ZipcodeData
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return ZipcodeData
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
