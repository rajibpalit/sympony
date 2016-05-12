<?php

namespace ArcaSolutions\ListingBundle\Sample;

use ArcaSolutions\CoreBundle\Sample\Location1Sample;
use ArcaSolutions\CoreBundle\Sample\Location2Sample;
use ArcaSolutions\CoreBundle\Sample\Location3Sample;
use ArcaSolutions\CoreBundle\Sample\Location4Sample;
use ArcaSolutions\CoreBundle\Sample\Location5Sample;
use ArcaSolutions\DealBundle\Sample\PromotionSample;
use ArcaSolutions\ImageBundle\Sample\GalleryImageSample;
use ArcaSolutions\ListingBundle\Entity\Listing;
use ArcaSolutions\WebBundle\Sample\CheckinSample;
use ArcaSolutions\WebBundle\Sample\ReviewSample;

class ListingSample extends Listing
{
    /**
     * Quantity of reviews in this sample
     *
     * @var int
     */
    private $reviewCount = 4;

    /**
     * Quantity of checkins in this sample
     *
     * @var int
     */
    private $checkinCount = 4;

    /**
     * Quantity of category in this sample
     *
     * @var int
     */
    private $categoriesCount = 2;

    /*
     * @var misc
     */
    private $translator;

    /**
     * ListingSample constructor.
     *
     * @param misc $translator
     * @param int $level
     */
    public function __construct($translator, $level = 0)
    {
        $this->translator = $translator;
        $this->setTitle($this->translator->trans('Listing Title'))
            ->setLongDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque luctus enim ac diam malesuada vestibulum vitae at tortor. Nullam nec porttitor arcu. Pellentesque laoreet lorem egestas felis lobortis eu tincidunt nulla tempor. Phasellus adipiscing fringilla tempus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sed sapien ut eros porta volutpat et quis leo. Aenean tincidunt ipsum quis nisl blandit nec placerat eros consectetur. Morbi convallis, est quis venenatis fermentum, sapien nibh auctor arcu, auctor mattis justo nisi tincidunt neque. Quisque cursus luctus congue. Quisque vel nulla vitae arcu faucibus placerat. Curabitur iaculis molestie sagittis.')
            ->setDescription('Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas.')
            ->setHoursWork($this->translator->trans('Sun 8:00 am - 6:00 pm'))
            ->setAvgReview(rand() % 5 + 1)
            ->setEmail($this->translator->trans('youremail@yoursite.com'))
            ->setPhone($this->translator->trans('000.000.0000'))
            ->setClicktocallNumber('000')
            ->setFax($this->translator->trans('000.000.0000'))
            ->setAddress($this->translator->trans('Address'))
            ->setUrl('javascript:void(0);')
            ->setFeatures('Lorem ipsu
            Claritas processus
            Mutationem consuetudium')
            ->setLatitude($this->translator->trans('-22.3344628'))
            ->setLongitude($this->translator->trans('-49.068844'))
            ->setLocations($this->translator->trans('Location Reference'))
            ->setZipCode($this->translator->trans('Zipcode'))
            ->setVideoSnippet('sample')
            ->setFacebookPage('sample')
            ->setLevel($level)
            ->setFriendlyUrl('listing-sample-title')
            ->setDeal(new PromotionSample($this->translator))
            ->setAttachmentFile('sample')
            ->setAttachmentCaption($this->translator->trans('Click here to see more info!'))
            ->setAccount(true);
    }

    /**
     * Gets gallery images sample
     *
     * @param int $qtde_level
     *
     * @return array
     */
    public function getGallery($qtde_level = 0)
    {
        $array = [];
        for ($i = 0; $i < $qtde_level; $i++) {
            $galleryImage = new GalleryImageSample(640, 480, $this->translator->trans('Placeholder'));
            if (0 == $i) {
                $galleryImage->setImageDefault('y');
            }
            $array[] = $galleryImage;
        }

        return $array;
    }

    /**
     * Gets reviews for sample
     *
     * @return array
     */
    public function getReviews()
    {
        $array = [];
        for ($i = 0; $i < $this->reviewCount; $i++) {
            $array[] = new ReviewSample($this->translator, 'listing');
        }

        return $array;
    }

    /**
     * Get quantity of reviews in sample
     *
     * @return int
     */
    public function getReviewCount()
    {
        $reviewCount = array();
        $reviewCount[1] = $this->reviewCount;
        return $reviewCount;
    }

    /**
     * Gets checkins for sample
     *
     * @return array
     */
    public function getCheckins()
    {
        $array = [];
        for ($i = 0; $i < $this->checkinCount; $i++) {
            $array[] = new CheckinSample($this->translator, 'listing');
        }

        return $array;
    }

    /**
     * Gets categories sample
     *
     * @return array
     */
    public function getCategories()
    {
        $array = [];
        for ($i = 0; $i < $this->categoriesCount; $i++) {
            $array[] = new CategorySample($this->translator, $i);
        }

        return $array;
    }

    /**
     * Gets location samples
     *
     * @return array
     */
    public function getLocationObjects()
    {
        return [
            1 => new Location5Sample($this->translator),
            2 => new Location4Sample($this->translator),
            3 => new Location3Sample($this->translator),
            4 => new Location2Sample($this->translator),
            5 => new Location1Sample($this->translator),
        ];
    }

    /**
     * Gets ID location following 'getLocationObjects' function
     * It is like this to work with location macro in detail
     *
     * @return array
     */
    public function getFakeLocationsIds()
    {
        return [1, 2, 3, 4, 5];
    }
}
