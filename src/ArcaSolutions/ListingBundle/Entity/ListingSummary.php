<?php

namespace ArcaSolutions\ListingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListingSummary
 *
 * @ORM\Table(name="Listing_Summary", indexes={@ORM\Index(name="title", columns={"title"}), @ORM\Index(name="title_keywords_seokeywords", columns={"status", "title"}), @ORM\Index(name="id_status", columns={"id", "status"}), @ORM\Index(name="clicktocall_number", columns={"clicktocall_number"}), @ORM\Index(name="Listing_Promotion", columns={"level", "promotion_id", "account_id", "title", "id"}), @ORM\Index(name="rating_filter", columns={"level", "status", "avg_review"}), @ORM\Index(name="price_filter", columns={"level", "status", "price"}), @ORM\Index(name="fulltextsearch_keyword", columns={"fulltextsearch_keyword"}), @ORM\Index(name="fulltextsearch_where", columns={"fulltextsearch_where"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\TestBundle\Entity\ListingSummaryRepository")
 */
class ListingSummary
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
     * @var integer
     *
     * @ORM\Column(name="location_1", type="integer", nullable=false)
     */
    private $location1;

    /**
     * @var string
     *
     * @ORM\Column(name="location_1_title", type="string", length=255, nullable=false)
     */
    private $location1Title;

    /**
     * @var string
     *
     * @ORM\Column(name="location_1_abbreviation", type="string", length=100, nullable=false)
     */
    private $location1Abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="location_1_friendly_url", type="string", length=255, nullable=false)
     */
    private $location1FriendlyUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_2", type="integer", nullable=false)
     */
    private $location2;

    /**
     * @var string
     *
     * @ORM\Column(name="location_2_title", type="string", length=255, nullable=false)
     */
    private $location2Title;

    /**
     * @var string
     *
     * @ORM\Column(name="location_2_abbreviation", type="string", length=100, nullable=false)
     */
    private $location2Abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="location_2_friendly_url", type="string", length=255, nullable=false)
     */
    private $location2FriendlyUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_3", type="integer", nullable=false)
     */
    private $location3;

    /**
     * @var string
     *
     * @ORM\Column(name="location_3_title", type="string", length=255, nullable=false)
     */
    private $location3Title;

    /**
     * @var string
     *
     * @ORM\Column(name="location_3_abbreviation", type="string", length=100, nullable=false)
     */
    private $location3Abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="location_3_friendly_url", type="string", length=255, nullable=false)
     */
    private $location3FriendlyUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_4", type="integer", nullable=false)
     */
    private $location4;

    /**
     * @var string
     *
     * @ORM\Column(name="location_4_title", type="string", length=255, nullable=false)
     */
    private $location4Title;

    /**
     * @var string
     *
     * @ORM\Column(name="location_4_abbreviation", type="string", length=100, nullable=false)
     */
    private $location4Abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="location_4_friendly_url", type="string", length=255, nullable=false)
     */
    private $location4FriendlyUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_5", type="integer", nullable=false)
     */
    private $location5;

    /**
     * @var string
     *
     * @ORM\Column(name="location_5_title", type="string", length=255, nullable=false)
     */
    private $location5Title;

    /**
     * @var string
     *
     * @ORM\Column(name="location_5_abbreviation", type="string", length=100, nullable=false)
     */
    private $location5Abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="location_5_friendly_url", type="string", length=255, nullable=false)
     */
    private $location5FriendlyUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     */
    private $imageId;

    /**
     * @var string
     *
     * @ORM\Column(name="friendly_url", type="string", length=255, nullable=false)
     */
    private $friendlyUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="show_email", type="string", nullable=false)
     */
    private $showEmail = 'y';

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="display_url", type="string", length=255, nullable=false)
     */
    private $displayUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=50, nullable=false)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=10, nullable=false)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="zip5", type="string", length=10, nullable=false)
     */
    private $zip5 = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=50, nullable=false)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=50, nullable=false)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="maptuning", type="string", length=255, nullable=false)
     */
    private $maptuning;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=false)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="attachment_file", type="string", length=255, nullable=false)
     */
    private $attachmentFile;

    /**
     * @var string
     *
     * @ORM\Column(name="attachment_caption", type="string", length=255, nullable=false)
     */
    private $attachmentCaption;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="renewal_date", type="date", nullable=false)
     */
    private $renewalDate = '0000-00-00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="level", type="boolean", nullable=false)
     */
    private $level = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="random_number", type="bigint", nullable=false)
     */
    private $randomNumber = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="claim_disable", type="string", length=1, nullable=false)
     */
    private $claimDisable = 'n';

    /**
     * @var string
     *
     * @ORM\Column(name="locations", type="text", nullable=false)
     */
    private $locations;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="text", nullable=false)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keywords", type="string", length=255, nullable=false)
     */
    private $seoKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="fulltextsearch_keyword", type="text", nullable=false)
     */
    private $fulltextsearchKeyword;

    /**
     * @var string
     *
     * @ORM\Column(name="fulltextsearch_where", type="text", nullable=false)
     */
    private $fulltextsearchWhere;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox0", type="string", length=1, nullable=false)
     */
    private $customCheckbox0;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox1", type="string", length=1, nullable=false)
     */
    private $customCheckbox1;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox2", type="string", length=1, nullable=false)
     */
    private $customCheckbox2;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox3", type="string", length=1, nullable=false)
     */
    private $customCheckbox3;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox4", type="string", length=1, nullable=false)
     */
    private $customCheckbox4;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox5", type="string", length=1, nullable=false)
     */
    private $customCheckbox5;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox6", type="string", length=1, nullable=false)
     */
    private $customCheckbox6;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox7", type="string", length=1, nullable=false)
     */
    private $customCheckbox7;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox8", type="string", length=1, nullable=false)
     */
    private $customCheckbox8;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_checkbox9", type="string", length=1, nullable=false)
     */
    private $customCheckbox9;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown0", type="string", length=255, nullable=false)
     */
    private $customDropdown0;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown1", type="string", length=255, nullable=false)
     */
    private $customDropdown1;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown2", type="string", length=255, nullable=false)
     */
    private $customDropdown2;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown3", type="string", length=255, nullable=false)
     */
    private $customDropdown3;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown4", type="string", length=255, nullable=false)
     */
    private $customDropdown4;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown5", type="string", length=255, nullable=false)
     */
    private $customDropdown5;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown6", type="string", length=255, nullable=false)
     */
    private $customDropdown6;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown7", type="string", length=255, nullable=false)
     */
    private $customDropdown7;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown8", type="string", length=255, nullable=false)
     */
    private $customDropdown8;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_dropdown9", type="string", length=255, nullable=false)
     */
    private $customDropdown9;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text0", type="string", length=255, nullable=false)
     */
    private $customText0;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text1", type="string", length=255, nullable=false)
     */
    private $customText1;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text2", type="string", length=255, nullable=false)
     */
    private $customText2;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text3", type="string", length=255, nullable=false)
     */
    private $customText3;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text4", type="string", length=255, nullable=false)
     */
    private $customText4;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text5", type="string", length=255, nullable=false)
     */
    private $customText5;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text6", type="string", length=255, nullable=false)
     */
    private $customText6;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text7", type="string", length=255, nullable=false)
     */
    private $customText7;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text8", type="string", length=255, nullable=false)
     */
    private $customText8;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_text9", type="string", length=255, nullable=false)
     */
    private $customText9;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc0", type="string", length=255, nullable=false)
     */
    private $customShortDesc0;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc1", type="string", length=255, nullable=false)
     */
    private $customShortDesc1;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc2", type="string", length=255, nullable=false)
     */
    private $customShortDesc2;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc3", type="string", length=255, nullable=false)
     */
    private $customShortDesc3;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc4", type="string", length=255, nullable=false)
     */
    private $customShortDesc4;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc5", type="string", length=255, nullable=false)
     */
    private $customShortDesc5;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc6", type="string", length=255, nullable=false)
     */
    private $customShortDesc6;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc7", type="string", length=255, nullable=false)
     */
    private $customShortDesc7;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc8", type="string", length=255, nullable=false)
     */
    private $customShortDesc8;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_short_desc9", type="string", length=255, nullable=false)
     */
    private $customShortDesc9;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc0", type="text", nullable=false)
     */
    private $customLongDesc0;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc1", type="text", nullable=false)
     */
    private $customLongDesc1;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc2", type="text", nullable=false)
     */
    private $customLongDesc2;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc3", type="text", nullable=false)
     */
    private $customLongDesc3;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc4", type="text", nullable=false)
     */
    private $customLongDesc4;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc5", type="text", nullable=false)
     */
    private $customLongDesc5;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc6", type="text", nullable=false)
     */
    private $customLongDesc6;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc7", type="text", nullable=false)
     */
    private $customLongDesc7;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc8", type="text", nullable=false)
     */
    private $customLongDesc8;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_long_desc9", type="text", nullable=false)
     */
    private $customLongDesc9;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_views", type="integer", nullable=false)
     */
    private $numberViews = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="avg_review", type="integer", nullable=false)
     */
    private $avgReview = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="promotion_start_date", type="date", nullable=false)
     */
    private $promotionStartDate = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="promotion_end_date", type="date", nullable=false)
     */
    private $promotionEndDate = '0000-00-00';

    /**
     * @var integer
     *
     * @ORM\Column(name="thumb_id", type="integer", nullable=false)
     */
    private $thumbId;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb_type", type="string", nullable=false)
     */
    private $thumbType = 'JPG';

    /**
     * @var integer
     *
     * @ORM\Column(name="thumb_width", type="smallint", nullable=false)
     */
    private $thumbWidth = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="thumb_height", type="smallint", nullable=false)
     */
    private $thumbHeight = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="listingtemplate_id", type="integer", nullable=false)
     */
    private $listingtemplateId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="template_layout_id", type="integer", nullable=false)
     */
    private $templateLayoutId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="template_cat_id", type="string", length=255, nullable=false)
     */
    private $templateCatId;

    /**
     * @var string
     *
     * @ORM\Column(name="template_title", type="string", length=255, nullable=false)
     */
    private $templateTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="template_status", type="string", length=255, nullable=false)
     */
    private $templateStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="template_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $templatePrice = '0.00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entered", type="datetime", nullable=false)
     */
    private $entered;

    /**
     * @var integer
     *
     * @ORM\Column(name="promotion_id", type="integer", nullable=true)
     */
    private $promotionId;

    /**
     * @var string
     *
     * @ORM\Column(name="backlink", type="string", length=1, nullable=false)
     */
    private $backlink = 'n';

    /**
     * @var string
     *
     * @ORM\Column(name="clicktocall_number", type="string", length=15, nullable=true)
     */
    private $clicktocallNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="clicktocall_extension", type="integer", nullable=true)
     */
    private $clicktocallExtension;



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
     * @return ListingSummary
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
     * Set location1
     *
     * @param integer $location1
     * @return ListingSummary
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
     * Set location1Title
     *
     * @param string $location1Title
     * @return ListingSummary
     */
    public function setLocation1Title($location1Title)
    {
        $this->location1Title = $location1Title;

        return $this;
    }

    /**
     * Get location1Title
     *
     * @return string
     */
    public function getLocation1Title()
    {
        return $this->location1Title;
    }

    /**
     * Set location1Abbreviation
     *
     * @param string $location1Abbreviation
     * @return ListingSummary
     */
    public function setLocation1Abbreviation($location1Abbreviation)
    {
        $this->location1Abbreviation = $location1Abbreviation;

        return $this;
    }

    /**
     * Get location1Abbreviation
     *
     * @return string
     */
    public function getLocation1Abbreviation()
    {
        return $this->location1Abbreviation;
    }

    /**
     * Set location1FriendlyUrl
     *
     * @param string $location1FriendlyUrl
     * @return ListingSummary
     */
    public function setLocation1FriendlyUrl($location1FriendlyUrl)
    {
        $this->location1FriendlyUrl = $location1FriendlyUrl;

        return $this;
    }

    /**
     * Get location1FriendlyUrl
     *
     * @return string
     */
    public function getLocation1FriendlyUrl()
    {
        return $this->location1FriendlyUrl;
    }

    /**
     * Set location2
     *
     * @param integer $location2
     * @return ListingSummary
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
     * Set location2Title
     *
     * @param string $location2Title
     * @return ListingSummary
     */
    public function setLocation2Title($location2Title)
    {
        $this->location2Title = $location2Title;

        return $this;
    }

    /**
     * Get location2Title
     *
     * @return string
     */
    public function getLocation2Title()
    {
        return $this->location2Title;
    }

    /**
     * Set location2Abbreviation
     *
     * @param string $location2Abbreviation
     * @return ListingSummary
     */
    public function setLocation2Abbreviation($location2Abbreviation)
    {
        $this->location2Abbreviation = $location2Abbreviation;

        return $this;
    }

    /**
     * Get location2Abbreviation
     *
     * @return string
     */
    public function getLocation2Abbreviation()
    {
        return $this->location2Abbreviation;
    }

    /**
     * Set location2FriendlyUrl
     *
     * @param string $location2FriendlyUrl
     * @return ListingSummary
     */
    public function setLocation2FriendlyUrl($location2FriendlyUrl)
    {
        $this->location2FriendlyUrl = $location2FriendlyUrl;

        return $this;
    }

    /**
     * Get location2FriendlyUrl
     *
     * @return string
     */
    public function getLocation2FriendlyUrl()
    {
        return $this->location2FriendlyUrl;
    }

    /**
     * Set location3
     *
     * @param integer $location3
     * @return ListingSummary
     */
    public function setLocation3($location3)
    {
        $this->location3 = $location3;

        return $this;
    }

    /**
     * Get location3
     *
     * @return integer
     */
    public function getLocation3()
    {
        return $this->location3;
    }

    /**
     * Set location3Title
     *
     * @param string $location3Title
     * @return ListingSummary
     */
    public function setLocation3Title($location3Title)
    {
        $this->location3Title = $location3Title;

        return $this;
    }

    /**
     * Get location3Title
     *
     * @return string
     */
    public function getLocation3Title()
    {
        return $this->location3Title;
    }

    /**
     * Set location3Abbreviation
     *
     * @param string $location3Abbreviation
     * @return ListingSummary
     */
    public function setLocation3Abbreviation($location3Abbreviation)
    {
        $this->location3Abbreviation = $location3Abbreviation;

        return $this;
    }

    /**
     * Get location3Abbreviation
     *
     * @return string
     */
    public function getLocation3Abbreviation()
    {
        return $this->location3Abbreviation;
    }

    /**
     * Set location3FriendlyUrl
     *
     * @param string $location3FriendlyUrl
     * @return ListingSummary
     */
    public function setLocation3FriendlyUrl($location3FriendlyUrl)
    {
        $this->location3FriendlyUrl = $location3FriendlyUrl;

        return $this;
    }

    /**
     * Get location3FriendlyUrl
     *
     * @return string
     */
    public function getLocation3FriendlyUrl()
    {
        return $this->location3FriendlyUrl;
    }

    /**
     * Set location4
     *
     * @param integer $location4
     * @return ListingSummary
     */
    public function setLocation4($location4)
    {
        $this->location4 = $location4;

        return $this;
    }

    /**
     * Get location4
     *
     * @return integer
     */
    public function getLocation4()
    {
        return $this->location4;
    }

    /**
     * Set location4Title
     *
     * @param string $location4Title
     * @return ListingSummary
     */
    public function setLocation4Title($location4Title)
    {
        $this->location4Title = $location4Title;

        return $this;
    }

    /**
     * Get location4Title
     *
     * @return string
     */
    public function getLocation4Title()
    {
        return $this->location4Title;
    }

    /**
     * Set location4Abbreviation
     *
     * @param string $location4Abbreviation
     * @return ListingSummary
     */
    public function setLocation4Abbreviation($location4Abbreviation)
    {
        $this->location4Abbreviation = $location4Abbreviation;

        return $this;
    }

    /**
     * Get location4Abbreviation
     *
     * @return string
     */
    public function getLocation4Abbreviation()
    {
        return $this->location4Abbreviation;
    }

    /**
     * Set location4FriendlyUrl
     *
     * @param string $location4FriendlyUrl
     * @return ListingSummary
     */
    public function setLocation4FriendlyUrl($location4FriendlyUrl)
    {
        $this->location4FriendlyUrl = $location4FriendlyUrl;

        return $this;
    }

    /**
     * Get location4FriendlyUrl
     *
     * @return string
     */
    public function getLocation4FriendlyUrl()
    {
        return $this->location4FriendlyUrl;
    }

    /**
     * Set location5
     *
     * @param integer $location5
     * @return ListingSummary
     */
    public function setLocation5($location5)
    {
        $this->location5 = $location5;

        return $this;
    }

    /**
     * Get location5
     *
     * @return integer
     */
    public function getLocation5()
    {
        return $this->location5;
    }

    /**
     * Set location5Title
     *
     * @param string $location5Title
     * @return ListingSummary
     */
    public function setLocation5Title($location5Title)
    {
        $this->location5Title = $location5Title;

        return $this;
    }

    /**
     * Get location5Title
     *
     * @return string
     */
    public function getLocation5Title()
    {
        return $this->location5Title;
    }

    /**
     * Set location5Abbreviation
     *
     * @param string $location5Abbreviation
     * @return ListingSummary
     */
    public function setLocation5Abbreviation($location5Abbreviation)
    {
        $this->location5Abbreviation = $location5Abbreviation;

        return $this;
    }

    /**
     * Get location5Abbreviation
     *
     * @return string
     */
    public function getLocation5Abbreviation()
    {
        return $this->location5Abbreviation;
    }

    /**
     * Set location5FriendlyUrl
     *
     * @param string $location5FriendlyUrl
     * @return ListingSummary
     */
    public function setLocation5FriendlyUrl($location5FriendlyUrl)
    {
        $this->location5FriendlyUrl = $location5FriendlyUrl;

        return $this;
    }

    /**
     * Get location5FriendlyUrl
     *
     * @return string
     */
    public function getLocation5FriendlyUrl()
    {
        return $this->location5FriendlyUrl;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ListingSummary
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
     * Set imageId
     *
     * @param integer $imageId
     * @return ListingSummary
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
     * Set friendlyUrl
     *
     * @param string $friendlyUrl
     * @return ListingSummary
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
     * Set email
     *
     * @param string $email
     * @return ListingSummary
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set showEmail
     *
     * @param string $showEmail
     * @return ListingSummary
     */
    public function setShowEmail($showEmail)
    {
        $this->showEmail = $showEmail;

        return $this;
    }

    /**
     * Get showEmail
     *
     * @return string
     */
    public function getShowEmail()
    {
        return $this->showEmail;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ListingSummary
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set displayUrl
     *
     * @param string $displayUrl
     * @return ListingSummary
     */
    public function setDisplayUrl($displayUrl)
    {
        $this->displayUrl = $displayUrl;

        return $this;
    }

    /**
     * Get displayUrl
     *
     * @return string
     */
    public function getDisplayUrl()
    {
        return $this->displayUrl;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return ListingSummary
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return ListingSummary
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return ListingSummary
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set zip5
     *
     * @param string $zip5
     * @return ListingSummary
     */
    public function setZip5($zip5)
    {
        $this->zip5 = $zip5;

        return $this;
    }

    /**
     * Get zip5
     *
     * @return string
     */
    public function getZip5()
    {
        return $this->zip5;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return ListingSummary
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return ListingSummary
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set maptuning
     *
     * @param string $maptuning
     * @return ListingSummary
     */
    public function setMaptuning($maptuning)
    {
        $this->maptuning = $maptuning;

        return $this;
    }

    /**
     * Get maptuning
     *
     * @return string
     */
    public function getMaptuning()
    {
        return $this->maptuning;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return ListingSummary
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return ListingSummary
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ListingSummary
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set attachmentFile
     *
     * @param string $attachmentFile
     * @return ListingSummary
     */
    public function setAttachmentFile($attachmentFile)
    {
        $this->attachmentFile = $attachmentFile;

        return $this;
    }

    /**
     * Get attachmentFile
     *
     * @return string
     */
    public function getAttachmentFile()
    {
        return $this->attachmentFile;
    }

    /**
     * Set attachmentCaption
     *
     * @param string $attachmentCaption
     * @return ListingSummary
     */
    public function setAttachmentCaption($attachmentCaption)
    {
        $this->attachmentCaption = $attachmentCaption;

        return $this;
    }

    /**
     * Get attachmentCaption
     *
     * @return string
     */
    public function getAttachmentCaption()
    {
        return $this->attachmentCaption;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ListingSummary
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

    /**
     * Set renewalDate
     *
     * @param \DateTime $renewalDate
     * @return ListingSummary
     */
    public function setRenewalDate($renewalDate)
    {
        $this->renewalDate = $renewalDate;

        return $this;
    }

    /**
     * Get renewalDate
     *
     * @return \DateTime
     */
    public function getRenewalDate()
    {
        return $this->renewalDate;
    }

    /**
     * Set level
     *
     * @param boolean $level
     * @return ListingSummary
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return boolean
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set randomNumber
     *
     * @param integer $randomNumber
     * @return ListingSummary
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
     * Set claimDisable
     *
     * @param string $claimDisable
     * @return ListingSummary
     */
    public function setClaimDisable($claimDisable)
    {
        $this->claimDisable = $claimDisable;

        return $this;
    }

    /**
     * Get claimDisable
     *
     * @return string
     */
    public function getClaimDisable()
    {
        return $this->claimDisable;
    }

    /**
     * Set locations
     *
     * @param string $locations
     * @return ListingSummary
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;

        return $this;
    }

    /**
     * Get locations
     *
     * @return string
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return ListingSummary
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set seoKeywords
     *
     * @param string $seoKeywords
     * @return ListingSummary
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

    /**
     * Set fulltextsearchKeyword
     *
     * @param string $fulltextsearchKeyword
     * @return ListingSummary
     */
    public function setFulltextsearchKeyword($fulltextsearchKeyword)
    {
        $this->fulltextsearchKeyword = $fulltextsearchKeyword;

        return $this;
    }

    /**
     * Get fulltextsearchKeyword
     *
     * @return string
     */
    public function getFulltextsearchKeyword()
    {
        return $this->fulltextsearchKeyword;
    }

    /**
     * Set fulltextsearchWhere
     *
     * @param string $fulltextsearchWhere
     * @return ListingSummary
     */
    public function setFulltextsearchWhere($fulltextsearchWhere)
    {
        $this->fulltextsearchWhere = $fulltextsearchWhere;

        return $this;
    }

    /**
     * Get fulltextsearchWhere
     *
     * @return string
     */
    public function getFulltextsearchWhere()
    {
        return $this->fulltextsearchWhere;
    }

    /**
     * Set customCheckbox0
     *
     * @param string $customCheckbox0
     * @return ListingSummary
     */
    public function setCustomCheckbox0($customCheckbox0)
    {
        $this->customCheckbox0 = $customCheckbox0;

        return $this;
    }

    /**
     * Get customCheckbox0
     *
     * @return string
     */
    public function getCustomCheckbox0()
    {
        return $this->customCheckbox0;
    }

    /**
     * Set customCheckbox1
     *
     * @param string $customCheckbox1
     * @return ListingSummary
     */
    public function setCustomCheckbox1($customCheckbox1)
    {
        $this->customCheckbox1 = $customCheckbox1;

        return $this;
    }

    /**
     * Get customCheckbox1
     *
     * @return string
     */
    public function getCustomCheckbox1()
    {
        return $this->customCheckbox1;
    }

    /**
     * Set customCheckbox2
     *
     * @param string $customCheckbox2
     * @return ListingSummary
     */
    public function setCustomCheckbox2($customCheckbox2)
    {
        $this->customCheckbox2 = $customCheckbox2;

        return $this;
    }

    /**
     * Get customCheckbox2
     *
     * @return string
     */
    public function getCustomCheckbox2()
    {
        return $this->customCheckbox2;
    }

    /**
     * Set customCheckbox3
     *
     * @param string $customCheckbox3
     * @return ListingSummary
     */
    public function setCustomCheckbox3($customCheckbox3)
    {
        $this->customCheckbox3 = $customCheckbox3;

        return $this;
    }

    /**
     * Get customCheckbox3
     *
     * @return string
     */
    public function getCustomCheckbox3()
    {
        return $this->customCheckbox3;
    }

    /**
     * Set customCheckbox4
     *
     * @param string $customCheckbox4
     * @return ListingSummary
     */
    public function setCustomCheckbox4($customCheckbox4)
    {
        $this->customCheckbox4 = $customCheckbox4;

        return $this;
    }

    /**
     * Get customCheckbox4
     *
     * @return string
     */
    public function getCustomCheckbox4()
    {
        return $this->customCheckbox4;
    }

    /**
     * Set customCheckbox5
     *
     * @param string $customCheckbox5
     * @return ListingSummary
     */
    public function setCustomCheckbox5($customCheckbox5)
    {
        $this->customCheckbox5 = $customCheckbox5;

        return $this;
    }

    /**
     * Get customCheckbox5
     *
     * @return string
     */
    public function getCustomCheckbox5()
    {
        return $this->customCheckbox5;
    }

    /**
     * Set customCheckbox6
     *
     * @param string $customCheckbox6
     * @return ListingSummary
     */
    public function setCustomCheckbox6($customCheckbox6)
    {
        $this->customCheckbox6 = $customCheckbox6;

        return $this;
    }

    /**
     * Get customCheckbox6
     *
     * @return string
     */
    public function getCustomCheckbox6()
    {
        return $this->customCheckbox6;
    }

    /**
     * Set customCheckbox7
     *
     * @param string $customCheckbox7
     * @return ListingSummary
     */
    public function setCustomCheckbox7($customCheckbox7)
    {
        $this->customCheckbox7 = $customCheckbox7;

        return $this;
    }

    /**
     * Get customCheckbox7
     *
     * @return string
     */
    public function getCustomCheckbox7()
    {
        return $this->customCheckbox7;
    }

    /**
     * Set customCheckbox8
     *
     * @param string $customCheckbox8
     * @return ListingSummary
     */
    public function setCustomCheckbox8($customCheckbox8)
    {
        $this->customCheckbox8 = $customCheckbox8;

        return $this;
    }

    /**
     * Get customCheckbox8
     *
     * @return string
     */
    public function getCustomCheckbox8()
    {
        return $this->customCheckbox8;
    }

    /**
     * Set customCheckbox9
     *
     * @param string $customCheckbox9
     * @return ListingSummary
     */
    public function setCustomCheckbox9($customCheckbox9)
    {
        $this->customCheckbox9 = $customCheckbox9;

        return $this;
    }

    /**
     * Get customCheckbox9
     *
     * @return string
     */
    public function getCustomCheckbox9()
    {
        return $this->customCheckbox9;
    }

    /**
     * Set customDropdown0
     *
     * @param string $customDropdown0
     * @return ListingSummary
     */
    public function setCustomDropdown0($customDropdown0)
    {
        $this->customDropdown0 = $customDropdown0;

        return $this;
    }

    /**
     * Get customDropdown0
     *
     * @return string
     */
    public function getCustomDropdown0()
    {
        return $this->customDropdown0;
    }

    /**
     * Set customDropdown1
     *
     * @param string $customDropdown1
     * @return ListingSummary
     */
    public function setCustomDropdown1($customDropdown1)
    {
        $this->customDropdown1 = $customDropdown1;

        return $this;
    }

    /**
     * Get customDropdown1
     *
     * @return string
     */
    public function getCustomDropdown1()
    {
        return $this->customDropdown1;
    }

    /**
     * Set customDropdown2
     *
     * @param string $customDropdown2
     * @return ListingSummary
     */
    public function setCustomDropdown2($customDropdown2)
    {
        $this->customDropdown2 = $customDropdown2;

        return $this;
    }

    /**
     * Get customDropdown2
     *
     * @return string
     */
    public function getCustomDropdown2()
    {
        return $this->customDropdown2;
    }

    /**
     * Set customDropdown3
     *
     * @param string $customDropdown3
     * @return ListingSummary
     */
    public function setCustomDropdown3($customDropdown3)
    {
        $this->customDropdown3 = $customDropdown3;

        return $this;
    }

    /**
     * Get customDropdown3
     *
     * @return string
     */
    public function getCustomDropdown3()
    {
        return $this->customDropdown3;
    }

    /**
     * Set customDropdown4
     *
     * @param string $customDropdown4
     * @return ListingSummary
     */
    public function setCustomDropdown4($customDropdown4)
    {
        $this->customDropdown4 = $customDropdown4;

        return $this;
    }

    /**
     * Get customDropdown4
     *
     * @return string
     */
    public function getCustomDropdown4()
    {
        return $this->customDropdown4;
    }

    /**
     * Set customDropdown5
     *
     * @param string $customDropdown5
     * @return ListingSummary
     */
    public function setCustomDropdown5($customDropdown5)
    {
        $this->customDropdown5 = $customDropdown5;

        return $this;
    }

    /**
     * Get customDropdown5
     *
     * @return string
     */
    public function getCustomDropdown5()
    {
        return $this->customDropdown5;
    }

    /**
     * Set customDropdown6
     *
     * @param string $customDropdown6
     * @return ListingSummary
     */
    public function setCustomDropdown6($customDropdown6)
    {
        $this->customDropdown6 = $customDropdown6;

        return $this;
    }

    /**
     * Get customDropdown6
     *
     * @return string
     */
    public function getCustomDropdown6()
    {
        return $this->customDropdown6;
    }

    /**
     * Set customDropdown7
     *
     * @param string $customDropdown7
     * @return ListingSummary
     */
    public function setCustomDropdown7($customDropdown7)
    {
        $this->customDropdown7 = $customDropdown7;

        return $this;
    }

    /**
     * Get customDropdown7
     *
     * @return string
     */
    public function getCustomDropdown7()
    {
        return $this->customDropdown7;
    }

    /**
     * Set customDropdown8
     *
     * @param string $customDropdown8
     * @return ListingSummary
     */
    public function setCustomDropdown8($customDropdown8)
    {
        $this->customDropdown8 = $customDropdown8;

        return $this;
    }

    /**
     * Get customDropdown8
     *
     * @return string
     */
    public function getCustomDropdown8()
    {
        return $this->customDropdown8;
    }

    /**
     * Set customDropdown9
     *
     * @param string $customDropdown9
     * @return ListingSummary
     */
    public function setCustomDropdown9($customDropdown9)
    {
        $this->customDropdown9 = $customDropdown9;

        return $this;
    }

    /**
     * Get customDropdown9
     *
     * @return string
     */
    public function getCustomDropdown9()
    {
        return $this->customDropdown9;
    }

    /**
     * Set customText0
     *
     * @param string $customText0
     * @return ListingSummary
     */
    public function setCustomText0($customText0)
    {
        $this->customText0 = $customText0;

        return $this;
    }

    /**
     * Get customText0
     *
     * @return string
     */
    public function getCustomText0()
    {
        return $this->customText0;
    }

    /**
     * Set customText1
     *
     * @param string $customText1
     * @return ListingSummary
     */
    public function setCustomText1($customText1)
    {
        $this->customText1 = $customText1;

        return $this;
    }

    /**
     * Get customText1
     *
     * @return string
     */
    public function getCustomText1()
    {
        return $this->customText1;
    }

    /**
     * Set customText2
     *
     * @param string $customText2
     * @return ListingSummary
     */
    public function setCustomText2($customText2)
    {
        $this->customText2 = $customText2;

        return $this;
    }

    /**
     * Get customText2
     *
     * @return string
     */
    public function getCustomText2()
    {
        return $this->customText2;
    }

    /**
     * Set customText3
     *
     * @param string $customText3
     * @return ListingSummary
     */
    public function setCustomText3($customText3)
    {
        $this->customText3 = $customText3;

        return $this;
    }

    /**
     * Get customText3
     *
     * @return string
     */
    public function getCustomText3()
    {
        return $this->customText3;
    }

    /**
     * Set customText4
     *
     * @param string $customText4
     * @return ListingSummary
     */
    public function setCustomText4($customText4)
    {
        $this->customText4 = $customText4;

        return $this;
    }

    /**
     * Get customText4
     *
     * @return string
     */
    public function getCustomText4()
    {
        return $this->customText4;
    }

    /**
     * Set customText5
     *
     * @param string $customText5
     * @return ListingSummary
     */
    public function setCustomText5($customText5)
    {
        $this->customText5 = $customText5;

        return $this;
    }

    /**
     * Get customText5
     *
     * @return string
     */
    public function getCustomText5()
    {
        return $this->customText5;
    }

    /**
     * Set customText6
     *
     * @param string $customText6
     * @return ListingSummary
     */
    public function setCustomText6($customText6)
    {
        $this->customText6 = $customText6;

        return $this;
    }

    /**
     * Get customText6
     *
     * @return string
     */
    public function getCustomText6()
    {
        return $this->customText6;
    }

    /**
     * Set customText7
     *
     * @param string $customText7
     * @return ListingSummary
     */
    public function setCustomText7($customText7)
    {
        $this->customText7 = $customText7;

        return $this;
    }

    /**
     * Get customText7
     *
     * @return string
     */
    public function getCustomText7()
    {
        return $this->customText7;
    }

    /**
     * Set customText8
     *
     * @param string $customText8
     * @return ListingSummary
     */
    public function setCustomText8($customText8)
    {
        $this->customText8 = $customText8;

        return $this;
    }

    /**
     * Get customText8
     *
     * @return string
     */
    public function getCustomText8()
    {
        return $this->customText8;
    }

    /**
     * Set customText9
     *
     * @param string $customText9
     * @return ListingSummary
     */
    public function setCustomText9($customText9)
    {
        $this->customText9 = $customText9;

        return $this;
    }

    /**
     * Get customText9
     *
     * @return string
     */
    public function getCustomText9()
    {
        return $this->customText9;
    }

    /**
     * Set customShortDesc0
     *
     * @param string $customShortDesc0
     * @return ListingSummary
     */
    public function setCustomShortDesc0($customShortDesc0)
    {
        $this->customShortDesc0 = $customShortDesc0;

        return $this;
    }

    /**
     * Get customShortDesc0
     *
     * @return string
     */
    public function getCustomShortDesc0()
    {
        return $this->customShortDesc0;
    }

    /**
     * Set customShortDesc1
     *
     * @param string $customShortDesc1
     * @return ListingSummary
     */
    public function setCustomShortDesc1($customShortDesc1)
    {
        $this->customShortDesc1 = $customShortDesc1;

        return $this;
    }

    /**
     * Get customShortDesc1
     *
     * @return string
     */
    public function getCustomShortDesc1()
    {
        return $this->customShortDesc1;
    }

    /**
     * Set customShortDesc2
     *
     * @param string $customShortDesc2
     * @return ListingSummary
     */
    public function setCustomShortDesc2($customShortDesc2)
    {
        $this->customShortDesc2 = $customShortDesc2;

        return $this;
    }

    /**
     * Get customShortDesc2
     *
     * @return string
     */
    public function getCustomShortDesc2()
    {
        return $this->customShortDesc2;
    }

    /**
     * Set customShortDesc3
     *
     * @param string $customShortDesc3
     * @return ListingSummary
     */
    public function setCustomShortDesc3($customShortDesc3)
    {
        $this->customShortDesc3 = $customShortDesc3;

        return $this;
    }

    /**
     * Get customShortDesc3
     *
     * @return string
     */
    public function getCustomShortDesc3()
    {
        return $this->customShortDesc3;
    }

    /**
     * Set customShortDesc4
     *
     * @param string $customShortDesc4
     * @return ListingSummary
     */
    public function setCustomShortDesc4($customShortDesc4)
    {
        $this->customShortDesc4 = $customShortDesc4;

        return $this;
    }

    /**
     * Get customShortDesc4
     *
     * @return string
     */
    public function getCustomShortDesc4()
    {
        return $this->customShortDesc4;
    }

    /**
     * Set customShortDesc5
     *
     * @param string $customShortDesc5
     * @return ListingSummary
     */
    public function setCustomShortDesc5($customShortDesc5)
    {
        $this->customShortDesc5 = $customShortDesc5;

        return $this;
    }

    /**
     * Get customShortDesc5
     *
     * @return string
     */
    public function getCustomShortDesc5()
    {
        return $this->customShortDesc5;
    }

    /**
     * Set customShortDesc6
     *
     * @param string $customShortDesc6
     * @return ListingSummary
     */
    public function setCustomShortDesc6($customShortDesc6)
    {
        $this->customShortDesc6 = $customShortDesc6;

        return $this;
    }

    /**
     * Get customShortDesc6
     *
     * @return string
     */
    public function getCustomShortDesc6()
    {
        return $this->customShortDesc6;
    }

    /**
     * Set customShortDesc7
     *
     * @param string $customShortDesc7
     * @return ListingSummary
     */
    public function setCustomShortDesc7($customShortDesc7)
    {
        $this->customShortDesc7 = $customShortDesc7;

        return $this;
    }

    /**
     * Get customShortDesc7
     *
     * @return string
     */
    public function getCustomShortDesc7()
    {
        return $this->customShortDesc7;
    }

    /**
     * Set customShortDesc8
     *
     * @param string $customShortDesc8
     * @return ListingSummary
     */
    public function setCustomShortDesc8($customShortDesc8)
    {
        $this->customShortDesc8 = $customShortDesc8;

        return $this;
    }

    /**
     * Get customShortDesc8
     *
     * @return string
     */
    public function getCustomShortDesc8()
    {
        return $this->customShortDesc8;
    }

    /**
     * Set customShortDesc9
     *
     * @param string $customShortDesc9
     * @return ListingSummary
     */
    public function setCustomShortDesc9($customShortDesc9)
    {
        $this->customShortDesc9 = $customShortDesc9;

        return $this;
    }

    /**
     * Get customShortDesc9
     *
     * @return string
     */
    public function getCustomShortDesc9()
    {
        return $this->customShortDesc9;
    }

    /**
     * Set customLongDesc0
     *
     * @param string $customLongDesc0
     * @return ListingSummary
     */
    public function setCustomLongDesc0($customLongDesc0)
    {
        $this->customLongDesc0 = $customLongDesc0;

        return $this;
    }

    /**
     * Get customLongDesc0
     *
     * @return string
     */
    public function getCustomLongDesc0()
    {
        return $this->customLongDesc0;
    }

    /**
     * Set customLongDesc1
     *
     * @param string $customLongDesc1
     * @return ListingSummary
     */
    public function setCustomLongDesc1($customLongDesc1)
    {
        $this->customLongDesc1 = $customLongDesc1;

        return $this;
    }

    /**
     * Get customLongDesc1
     *
     * @return string
     */
    public function getCustomLongDesc1()
    {
        return $this->customLongDesc1;
    }

    /**
     * Set customLongDesc2
     *
     * @param string $customLongDesc2
     * @return ListingSummary
     */
    public function setCustomLongDesc2($customLongDesc2)
    {
        $this->customLongDesc2 = $customLongDesc2;

        return $this;
    }

    /**
     * Get customLongDesc2
     *
     * @return string
     */
    public function getCustomLongDesc2()
    {
        return $this->customLongDesc2;
    }

    /**
     * Set customLongDesc3
     *
     * @param string $customLongDesc3
     * @return ListingSummary
     */
    public function setCustomLongDesc3($customLongDesc3)
    {
        $this->customLongDesc3 = $customLongDesc3;

        return $this;
    }

    /**
     * Get customLongDesc3
     *
     * @return string
     */
    public function getCustomLongDesc3()
    {
        return $this->customLongDesc3;
    }

    /**
     * Set customLongDesc4
     *
     * @param string $customLongDesc4
     * @return ListingSummary
     */
    public function setCustomLongDesc4($customLongDesc4)
    {
        $this->customLongDesc4 = $customLongDesc4;

        return $this;
    }

    /**
     * Get customLongDesc4
     *
     * @return string
     */
    public function getCustomLongDesc4()
    {
        return $this->customLongDesc4;
    }

    /**
     * Set customLongDesc5
     *
     * @param string $customLongDesc5
     * @return ListingSummary
     */
    public function setCustomLongDesc5($customLongDesc5)
    {
        $this->customLongDesc5 = $customLongDesc5;

        return $this;
    }

    /**
     * Get customLongDesc5
     *
     * @return string
     */
    public function getCustomLongDesc5()
    {
        return $this->customLongDesc5;
    }

    /**
     * Set customLongDesc6
     *
     * @param string $customLongDesc6
     * @return ListingSummary
     */
    public function setCustomLongDesc6($customLongDesc6)
    {
        $this->customLongDesc6 = $customLongDesc6;

        return $this;
    }

    /**
     * Get customLongDesc6
     *
     * @return string
     */
    public function getCustomLongDesc6()
    {
        return $this->customLongDesc6;
    }

    /**
     * Set customLongDesc7
     *
     * @param string $customLongDesc7
     * @return ListingSummary
     */
    public function setCustomLongDesc7($customLongDesc7)
    {
        $this->customLongDesc7 = $customLongDesc7;

        return $this;
    }

    /**
     * Get customLongDesc7
     *
     * @return string
     */
    public function getCustomLongDesc7()
    {
        return $this->customLongDesc7;
    }

    /**
     * Set customLongDesc8
     *
     * @param string $customLongDesc8
     * @return ListingSummary
     */
    public function setCustomLongDesc8($customLongDesc8)
    {
        $this->customLongDesc8 = $customLongDesc8;

        return $this;
    }

    /**
     * Get customLongDesc8
     *
     * @return string
     */
    public function getCustomLongDesc8()
    {
        return $this->customLongDesc8;
    }

    /**
     * Set customLongDesc9
     *
     * @param string $customLongDesc9
     * @return ListingSummary
     */
    public function setCustomLongDesc9($customLongDesc9)
    {
        $this->customLongDesc9 = $customLongDesc9;

        return $this;
    }

    /**
     * Get customLongDesc9
     *
     * @return string
     */
    public function getCustomLongDesc9()
    {
        return $this->customLongDesc9;
    }

    /**
     * Set numberViews
     *
     * @param integer $numberViews
     * @return ListingSummary
     */
    public function setNumberViews($numberViews)
    {
        $this->numberViews = $numberViews;

        return $this;
    }

    /**
     * Get numberViews
     *
     * @return integer
     */
    public function getNumberViews()
    {
        return $this->numberViews;
    }

    /**
     * Set avgReview
     *
     * @param integer $avgReview
     * @return ListingSummary
     */
    public function setAvgReview($avgReview)
    {
        $this->avgReview = $avgReview;

        return $this;
    }

    /**
     * Get avgReview
     *
     * @return integer
     */
    public function getAvgReview()
    {
        return $this->avgReview;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return ListingSummary
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set promotionStartDate
     *
     * @param \DateTime $promotionStartDate
     * @return ListingSummary
     */
    public function setPromotionStartDate($promotionStartDate)
    {
        $this->promotionStartDate = $promotionStartDate;

        return $this;
    }

    /**
     * Get promotionStartDate
     *
     * @return \DateTime
     */
    public function getPromotionStartDate()
    {
        return $this->promotionStartDate;
    }

    /**
     * Set promotionEndDate
     *
     * @param \DateTime $promotionEndDate
     * @return ListingSummary
     */
    public function setPromotionEndDate($promotionEndDate)
    {
        $this->promotionEndDate = $promotionEndDate;

        return $this;
    }

    /**
     * Get promotionEndDate
     *
     * @return \DateTime
     */
    public function getPromotionEndDate()
    {
        return $this->promotionEndDate;
    }

    /**
     * Set thumbId
     *
     * @param integer $thumbId
     * @return ListingSummary
     */
    public function setThumbId($thumbId)
    {
        $this->thumbId = $thumbId;

        return $this;
    }

    /**
     * Get thumbId
     *
     * @return integer
     */
    public function getThumbId()
    {
        return $this->thumbId;
    }

    /**
     * Set thumbType
     *
     * @param \string $thumbType
     * @return ListingSummary
     */
    public function setThumbType($thumbType)
    {
        $this->thumbType = $thumbType;

        return $this;
    }

    /**
     * Get thumbType
     *
     * @return \string
     */
    public function getThumbType()
    {
        return $this->thumbType;
    }

    /**
     * Set thumbWidth
     *
     * @param integer $thumbWidth
     * @return ListingSummary
     */
    public function setThumbWidth($thumbWidth)
    {
        $this->thumbWidth = $thumbWidth;

        return $this;
    }

    /**
     * Get thumbWidth
     *
     * @return integer
     */
    public function getThumbWidth()
    {
        return $this->thumbWidth;
    }

    /**
     * Set thumbHeight
     *
     * @param integer $thumbHeight
     * @return ListingSummary
     */
    public function setThumbHeight($thumbHeight)
    {
        $this->thumbHeight = $thumbHeight;

        return $this;
    }

    /**
     * Get thumbHeight
     *
     * @return integer
     */
    public function getThumbHeight()
    {
        return $this->thumbHeight;
    }

    /**
     * Set listingtemplateId
     *
     * @param integer $listingtemplateId
     * @return ListingSummary
     */
    public function setListingtemplateId($listingtemplateId)
    {
        $this->listingtemplateId = $listingtemplateId;

        return $this;
    }

    /**
     * Get listingtemplateId
     *
     * @return integer
     */
    public function getListingtemplateId()
    {
        return $this->listingtemplateId;
    }

    /**
     * Set templateLayoutId
     *
     * @param integer $templateLayoutId
     * @return ListingSummary
     */
    public function setTemplateLayoutId($templateLayoutId)
    {
        $this->templateLayoutId = $templateLayoutId;

        return $this;
    }

    /**
     * Get templateLayoutId
     *
     * @return integer
     */
    public function getTemplateLayoutId()
    {
        return $this->templateLayoutId;
    }

    /**
     * Set templateCatId
     *
     * @param string $templateCatId
     * @return ListingSummary
     */
    public function setTemplateCatId($templateCatId)
    {
        $this->templateCatId = $templateCatId;

        return $this;
    }

    /**
     * Get templateCatId
     *
     * @return string
     */
    public function getTemplateCatId()
    {
        return $this->templateCatId;
    }

    /**
     * Set templateTitle
     *
     * @param string $templateTitle
     * @return ListingSummary
     */
    public function setTemplateTitle($templateTitle)
    {
        $this->templateTitle = $templateTitle;

        return $this;
    }

    /**
     * Get templateTitle
     *
     * @return string
     */
    public function getTemplateTitle()
    {
        return $this->templateTitle;
    }

    /**
     * Set templateStatus
     *
     * @param string $templateStatus
     * @return ListingSummary
     */
    public function setTemplateStatus($templateStatus)
    {
        $this->templateStatus = $templateStatus;

        return $this;
    }

    /**
     * Get templateStatus
     *
     * @return string
     */
    public function getTemplateStatus()
    {
        return $this->templateStatus;
    }

    /**
     * Set templatePrice
     *
     * @param string $templatePrice
     * @return ListingSummary
     */
    public function setTemplatePrice($templatePrice)
    {
        $this->templatePrice = $templatePrice;

        return $this;
    }

    /**
     * Get templatePrice
     *
     * @return string
     */
    public function getTemplatePrice()
    {
        return $this->templatePrice;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return ListingSummary
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
     * Set entered
     *
     * @param \DateTime $entered
     * @return ListingSummary
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
     * Set promotionId
     *
     * @param integer $promotionId
     * @return ListingSummary
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
     * Set backlink
     *
     * @param string $backlink
     * @return ListingSummary
     */
    public function setBacklink($backlink)
    {
        $this->backlink = $backlink;

        return $this;
    }

    /**
     * Get backlink
     *
     * @return string
     */
    public function getBacklink()
    {
        return $this->backlink;
    }

    /**
     * Set clicktocallNumber
     *
     * @param string $clicktocallNumber
     * @return ListingSummary
     */
    public function setClicktocallNumber($clicktocallNumber)
    {
        $this->clicktocallNumber = $clicktocallNumber;

        return $this;
    }

    /**
     * Get clicktocallNumber
     *
     * @return string
     */
    public function getClicktocallNumber()
    {
        return $this->clicktocallNumber;
    }

    /**
     * Set clicktocallExtension
     *
     * @param integer $clicktocallExtension
     * @return ListingSummary
     */
    public function setClicktocallExtension($clicktocallExtension)
    {
        $this->clicktocallExtension = $clicktocallExtension;

        return $this;
    }

    /**
     * Get clicktocallExtension
     *
     * @return integer
     */
    public function getClicktocallExtension()
    {
        return $this->clicktocallExtension;
    }
}
