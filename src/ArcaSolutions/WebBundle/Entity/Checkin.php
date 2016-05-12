<?php

namespace ArcaSolutions\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Checkin
 *
 * @ORM\Table(name="CheckIn", indexes={@ORM\Index(name="listing_id", columns={"item_id"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\WebBundle\Repository\CheckinRepository")
 */
class Checkin
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
     * @ORM\Column(name="item_id", type="integer", nullable=false)
     */
    private $itemId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="item_type", type="string", length=10, nullable=false)
     */
    private $itemType = 'listing';

    /**
     * @var integer
     *
     * @ORM\Column(name="member_id", type="integer", nullable=false)
     */
    private $memberId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added", type="datetime", nullable=false)
     */
    private $added = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=20, nullable=true)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="quick_tip", type="text", nullable=true)
     */
    private $quickTip;

    /**
     * @var string
     *
     * @ORM\Column(name="checkin_name", type="string", length=255, nullable=true)
     */
    private $checkinName;

    /**
     * @ORM\ManyToOne(targetEntity="ArcaSolutions\WebBundle\Entity\Accountprofilecontact", inversedBy="checkins")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="account_id")
     */
    private $profile;

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
     * Set itemId
     *
     * @param integer $itemId
     * @return Checkin
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set itemType
     *
     * @param string $itemType
     * @return Checkin
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;

        return $this;
    }

    /**
     * Get itemType
     *
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * Set memberId
     *
     * @param integer $memberId
     * @return Checkin
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * Get memberId
     *
     * @return integer
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Set added
     *
     * @param \DateTime $added
     * @return Checkin
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * Get added
     *
     * @return \DateTime
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Checkin
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set quickTip
     *
     * @param string $quickTip
     * @return Checkin
     */
    public function setQuickTip($quickTip)
    {
        $this->quickTip = $quickTip;

        return $this;
    }

    /**
     * Get quickTip
     *
     * @return string
     */
    public function getQuickTip()
    {
        return $this->quickTip;
    }

    /**
     * Set checkinName
     *
     * @param string $checkinName
     * @return Checkin
     */
    public function setCheckinName($checkinName)
    {
        $this->checkinName = $checkinName;

        return $this;
    }

    /**
     * Get checkinName
     *
     * @return string
     */
    public function getCheckinName()
    {
        return $this->checkinName;
    }

    /**
     * Set profile
     *
     * @param \ArcaSolutions\WebBundle\Entity\Accountprofilecontact $profile
     * @return Checkin
     */
    public function setProfile(\ArcaSolutions\WebBundle\Entity\Accountprofilecontact $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \ArcaSolutions\WebBundle\Entity\Accountprofilecontact
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
