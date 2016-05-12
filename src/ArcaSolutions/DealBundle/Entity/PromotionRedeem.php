<?php

namespace ArcaSolutions\DealBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromotionRedeem
 *
 * @ORM\Table(name="Promotion_Redeem", indexes={@ORM\Index(name="promotion_info", columns={"account_id", "promotion_id"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\DealBundle\Repository\PromotionRedeemRepository")
 */
class PromotionRedeem
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
     * @ORM\Column(name="account_id", type="integer", nullable=false)
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_name", type="string", length=100, nullable=false)
     */
    private $profileName;

    /**
     * @var integer
     *
     * @ORM\Column(name="promotion_id", type="integer", nullable=false)
     */
    private $promotionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="twittered", type="integer", nullable=false)
     */
    private $twittered;

    /**
     * @var integer
     *
     * @ORM\Column(name="facebooked", type="integer", nullable=false)
     */
    private $facebooked;

    /**
     * @var string
     *
     * @ORM\Column(name="network_response", type="string", length=250, nullable=false)
     */
    private $networkResponse;

    /**
     * @var string
     *
     * @ORM\Column(name="redeem_code", type="string", length=250, nullable=false)
     */
    private $redeemCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false)
     */
    private $datetime;

    /**
     * @var integer
     *
     * @ORM\Column(name="used", type="smallint", nullable=false)
     */
    private $used = '0';



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
     * Set accountId
     *
     * @param integer $accountId
     * @return PromotionRedeem
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set profileName
     *
     * @param string $profileName
     * @return PromotionRedeem
     */
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;

        return $this;
    }

    /**
     * Get profileName
     *
     * @return string
     */
    public function getProfileName()
    {
        return $this->profileName;
    }

    /**
     * Set promotionId
     *
     * @param integer $promotionId
     * @return PromotionRedeem
     */
    public function setPromotionId($promotionId)
    {
        $this->promotionId = $promotionId;

        return $this;
    }

    /**
     * Get promotionId
     *
     * @return integer
     */
    public function getPromotionId()
    {
        return $this->promotionId;
    }

    /**
     * Set twittered
     *
     * @param integer $twittered
     * @return PromotionRedeem
     */
    public function setTwittered($twittered)
    {
        $this->twittered = $twittered;

        return $this;
    }

    /**
     * Get twittered
     *
     * @return integer
     */
    public function getTwittered()
    {
        return $this->twittered;
    }

    /**
     * Set facebooked
     *
     * @param integer $facebooked
     * @return PromotionRedeem
     */
    public function setFacebooked($facebooked)
    {
        $this->facebooked = $facebooked;

        return $this;
    }

    /**
     * Get facebooked
     *
     * @return integer
     */
    public function getFacebooked()
    {
        return $this->facebooked;
    }

    /**
     * Set networkResponse
     *
     * @param string $networkResponse
     * @return PromotionRedeem
     */
    public function setNetworkResponse($networkResponse)
    {
        $this->networkResponse = $networkResponse;

        return $this;
    }

    /**
     * Get networkResponse
     *
     * @return string
     */
    public function getNetworkResponse()
    {
        return $this->networkResponse;
    }

    /**
     * Set redeemCode
     *
     * @param string $redeemCode
     * @return PromotionRedeem
     */
    public function setRedeemCode($redeemCode)
    {
        $this->redeemCode = $redeemCode;

        return $this;
    }

    /**
     * Get redeemCode
     *
     * @return string
     */
    public function getRedeemCode()
    {
        return $this->redeemCode;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return PromotionRedeem
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set used
     *
     * @param integer $used
     * @return PromotionRedeem
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * Get used
     *
     * @return integer
     */
    public function getUsed()
    {
        return $this->used;
    }
}
