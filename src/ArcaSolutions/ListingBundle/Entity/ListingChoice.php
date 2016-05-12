<?php

namespace ArcaSolutions\ListingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListingChoice
 *
 * @ORM\Table(name="Listing_Choice", indexes={@ORM\Index(name="EditorChoice_has_Listing_FKIndex1", columns={"editor_choice_id"}), @ORM\Index(name="EditorChoice_has_Listing_FKIndex2", columns={"listing_id"})})
 * @ORM\Entity
 */
class ListingChoice
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
     * @ORM\Column(name="editor_choice_id", type="integer", nullable=false)
     */
    private $editorChoiceId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="listing_id", type="integer", nullable=false)
     */
    private $listingId = '0';



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
     * Set editorChoiceId
     *
     * @param integer $editorChoiceId
     * @return ListingChoice
     */
    public function setEditorChoiceId($editorChoiceId)
    {
        $this->editorChoiceId = $editorChoiceId;

        return $this;
    }

    /**
     * Get editorChoiceId
     *
     * @return integer
     */
    public function getEditorChoiceId()
    {
        return $this->editorChoiceId;
    }

    /**
     * Set listingId
     *
     * @param integer $listingId
     * @return ListingChoice
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
}
