<?php

namespace ArcaSolutions\WebBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Accountprofilecontact
 *
 * @ORM\Table(name="AccountProfileContact", indexes={@ORM\Index(name="image_id", columns={"image_id", "has_profile"})})
 * @ORM\Entity
 */
class Accountprofilecontact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=100, nullable=false)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=false)
     */
    private $friendlyUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     */
    private $imageId;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_image", type="string", length=255, nullable=false)
     */
    private $facebookImage;

    /**
     * @var integer
     *
     * @ORM\Column(name="facebook_image_height", type="integer", nullable=false)
     */
    private $facebookImageHeight;

    /**
     * @var integer
     *
     * @ORM\Column(name="facebook_image_width", type="integer", nullable=false)
     */
    private $facebookImageWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="has_profile", type="string", length=1, nullable=false)
     */
    private $hasProfile;

    /**
     * @ORM\OneToMany(targetEntity="ArcaSolutions\WebBundle\Entity\Checkin", mappedBy="profile")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="member_id")
     */
    private $checkins;

    /**
     * @ORM\OneToMany(targetEntity="ArcaSolutions\BlogBundle\Entity\Comments", mappedBy="profile")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="member_id")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="ArcaSolutions\WebBundle\Entity\Review", mappedBy="profile")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="member_id")
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity="ArcaSolutions\ListingBundle\Entity\Listing", mappedBy="account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="account_id")
     */
    private $listings;

    /**
     * @ORM\OneToMany(targetEntity="ArcaSolutions\ArticleBundle\Entity\Article", mappedBy="account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="account_id")
     */
    private $articles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->checkins = new ArrayCollection();
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
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Accountprofilecontact
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Accountprofilecontact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Accountprofilecontact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Accountprofilecontact
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

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
     * Set friendlyUrl
     *
     * @param string $friendlyUrl
     *
     * @return Accountprofilecontact
     */
    public function setFriendlyUrl($friendlyUrl)
    {
        $this->friendlyUrl = $friendlyUrl;

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
     * Set imageId
     *
     * @param integer $imageId
     *
     * @return Accountprofilecontact
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Get facebookImage
     *
     * @return string
     */
    public function getFacebookImage()
    {
        return $this->facebookImage;
    }

    /**
     * Set facebookImage
     *
     * @param string $facebookImage
     *
     * @return Accountprofilecontact
     */
    public function setFacebookImage($facebookImage)
    {
        $this->facebookImage = $facebookImage;

        return $this;
    }

    /**
     * Get facebookImageHeight
     *
     * @return integer
     */
    public function getFacebookImageHeight()
    {
        return $this->facebookImageHeight;
    }

    /**
     * Set facebookImageHeight
     *
     * @param integer $facebookImageHeight
     *
     * @return Accountprofilecontact
     */
    public function setFacebookImageHeight($facebookImageHeight)
    {
        $this->facebookImageHeight = $facebookImageHeight;

        return $this;
    }

    /**
     * Get facebookImageWidth
     *
     * @return integer
     */
    public function getFacebookImageWidth()
    {
        return $this->facebookImageWidth;
    }

    /**
     * Set facebookImageWidth
     *
     * @param integer $facebookImageWidth
     *
     * @return Accountprofilecontact
     */
    public function setFacebookImageWidth($facebookImageWidth)
    {
        $this->facebookImageWidth = $facebookImageWidth;

        return $this;
    }

    /**
     * Get hasProfile
     *
     * @return string
     */
    public function getHasProfile()
    {
        return $this->hasProfile;
    }

    /**
     * Set hasProfile
     *
     * @param string $hasProfile
     *
     * @return Accountprofilecontact
     */
    public function setHasProfile($hasProfile)
    {
        $this->hasProfile = $hasProfile;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCheckins()
    {
        return $this->checkins;
    }

    /**
     * @param mixed $checkins
     */
    public function setCheckins($checkins)
    {
        $this->checkins = $checkins;
    }

    /**
     * Add checkins
     *
     * @param \ArcaSolutions\WebBundle\Entity\Checkin $checkins
     *
     * @return Accountprofilecontact
     */
    public function addCheckin(\ArcaSolutions\WebBundle\Entity\Checkin $checkins)
    {
        $this->checkins[] = $checkins;

        return $this;
    }

    /**
     * Remove checkins
     *
     * @param \ArcaSolutions\WebBundle\Entity\Checkin $checkins
     */
    public function removeCheckin(\ArcaSolutions\WebBundle\Entity\Checkin $checkins)
    {
        $this->checkins->removeElement($checkins);
    }

    /**
     * @return mixed
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param mixed $reviews
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * @return mixed
     */
    public function getListings()
    {
        return $this->listings;
    }

    /**
     * @param mixed $listings
     */
    public function setListings($listings)
    {
        $this->listings = $listings;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }
}
