<?php

namespace ArcaSolutions\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="Profile")
 * @ORM\Entity(repositoryClass="ArcaSolutions\CoreBundle\Repository\ProfileRepository")
 */
class Profile
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
     * @ORM\Column(name="nickname", type="string", length=100, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=false)
     */
    private $friendlyUrl = 'MD5(account_id)';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entered", type="datetime", nullable=false)
     */
    private $entered;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="personal_message", type="string", length=250, nullable=true)
     */
    private $personalMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_account", type="string", length=100, nullable=true)
     */
    private $twitterAccount;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_uid", type="string", length=250, nullable=false)
     */
    private $facebookUid;

    /**
     * @var integer
     *
     * @ORM\Column(name="fb_post", type="smallint", nullable=false)
     */
    private $fbPost;

    /**
     * @var integer
     *
     * @ORM\Column(name="tw_post", type="smallint", nullable=false)
     */
    private $twPost;

    /**
     * @var integer
     *
     * @ORM\Column(name="usefacebooklocation", type="smallint", nullable=false)
     */
    private $usefacebooklocation;

    /**
     * @var string
     *
     * @ORM\Column(name="tw_oauth_token", type="string", length=250, nullable=false)
     */
    private $twOauthToken;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=250, nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="tw_oauth_token_secret", type="string", length=250, nullable=false)
     */
    private $twOauthTokenSecret;

    /**
     * @var string
     *
     * @ORM\Column(name="tw_screen_name", type="string", length=250, nullable=false)
     */
    private $twScreenName;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_complete", type="string", length=1, nullable=false)
     */
    private $profileComplete = 'n';



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
     * Set imageId
     *
     * @param integer $imageId
     * @return Profile
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

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
     * Set facebookImage
     *
     * @param string $facebookImage
     * @return Profile
     */
    public function setFacebookImage($facebookImage)
    {
        $this->facebookImage = $facebookImage;

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
     * Set facebookImageHeight
     *
     * @param integer $facebookImageHeight
     * @return Profile
     */
    public function setFacebookImageHeight($facebookImageHeight)
    {
        $this->facebookImageHeight = $facebookImageHeight;

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
     * Set facebookImageWidth
     *
     * @param integer $facebookImageWidth
     * @return Profile
     */
    public function setFacebookImageWidth($facebookImageWidth)
    {
        $this->facebookImageWidth = $facebookImageWidth;

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
     * Set nickname
     *
     * @param string $nickname
     * @return Profile
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

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
     * Set friendlyUrl
     *
     * @param string $friendlyUrl
     * @return Profile
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
     * Set entered
     *
     * @param \DateTime $entered
     * @return Profile
     */
    public function setEntered($entered)
    {
        $this->entered = $entered;

        return $this;
    }

    /**
     * Get entered
     *
     * @return \DateTime 
     */
    public function getEntered()
    {
        return $this->entered;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Profile
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set personalMessage
     *
     * @param string $personalMessage
     * @return Profile
     */
    public function setPersonalMessage($personalMessage)
    {
        $this->personalMessage = $personalMessage;

        return $this;
    }

    /**
     * Get personalMessage
     *
     * @return string 
     */
    public function getPersonalMessage()
    {
        return $this->personalMessage;
    }

    /**
     * Set twitterAccount
     *
     * @param string $twitterAccount
     * @return Profile
     */
    public function setTwitterAccount($twitterAccount)
    {
        $this->twitterAccount = $twitterAccount;

        return $this;
    }

    /**
     * Get twitterAccount
     *
     * @return string 
     */
    public function getTwitterAccount()
    {
        return $this->twitterAccount;
    }

    /**
     * Set facebookUid
     *
     * @param string $facebookUid
     * @return Profile
     */
    public function setFacebookUid($facebookUid)
    {
        $this->facebookUid = $facebookUid;

        return $this;
    }

    /**
     * Get facebookUid
     *
     * @return string 
     */
    public function getFacebookUid()
    {
        return $this->facebookUid;
    }

    /**
     * Set fbPost
     *
     * @param integer $fbPost
     * @return Profile
     */
    public function setFbPost($fbPost)
    {
        $this->fbPost = $fbPost;

        return $this;
    }

    /**
     * Get fbPost
     *
     * @return integer 
     */
    public function getFbPost()
    {
        return $this->fbPost;
    }

    /**
     * Set twPost
     *
     * @param integer $twPost
     * @return Profile
     */
    public function setTwPost($twPost)
    {
        $this->twPost = $twPost;

        return $this;
    }

    /**
     * Get twPost
     *
     * @return integer 
     */
    public function getTwPost()
    {
        return $this->twPost;
    }

    /**
     * Set usefacebooklocation
     *
     * @param integer $usefacebooklocation
     * @return Profile
     */
    public function setUsefacebooklocation($usefacebooklocation)
    {
        $this->usefacebooklocation = $usefacebooklocation;

        return $this;
    }

    /**
     * Get usefacebooklocation
     *
     * @return integer 
     */
    public function getUsefacebooklocation()
    {
        return $this->usefacebooklocation;
    }

    /**
     * Set twOauthToken
     *
     * @param string $twOauthToken
     * @return Profile
     */
    public function setTwOauthToken($twOauthToken)
    {
        $this->twOauthToken = $twOauthToken;

        return $this;
    }

    /**
     * Get twOauthToken
     *
     * @return string 
     */
    public function getTwOauthToken()
    {
        return $this->twOauthToken;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Profile
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set twOauthTokenSecret
     *
     * @param string $twOauthTokenSecret
     * @return Profile
     */
    public function setTwOauthTokenSecret($twOauthTokenSecret)
    {
        $this->twOauthTokenSecret = $twOauthTokenSecret;

        return $this;
    }

    /**
     * Get twOauthTokenSecret
     *
     * @return string 
     */
    public function getTwOauthTokenSecret()
    {
        return $this->twOauthTokenSecret;
    }

    /**
     * Set twScreenName
     *
     * @param string $twScreenName
     * @return Profile
     */
    public function setTwScreenName($twScreenName)
    {
        $this->twScreenName = $twScreenName;

        return $this;
    }

    /**
     * Get twScreenName
     *
     * @return string 
     */
    public function getTwScreenName()
    {
        return $this->twScreenName;
    }

    /**
     * Set profileComplete
     *
     * @param string $profileComplete
     * @return Profile
     */
    public function setProfileComplete($profileComplete)
    {
        $this->profileComplete = $profileComplete;

        return $this;
    }

    /**
     * Get profileComplete
     *
     * @return string 
     */
    public function getProfileComplete()
    {
        return $this->profileComplete;
    }
}
