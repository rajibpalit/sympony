<?php

namespace ArcaSolutions\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locationfulltextwherelist
 *
 * @ORM\Table(name="LocationFulltextwhereList", uniqueConstraints={@ORM\UniqueConstraint(name="table_item_id_domain_id", columns={"item_id", "domain_id", "item_table"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\CoreBundle\Repository\LocationfulltextwherelistRepository")
 */
class Locationfulltextwherelist
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
     * @var string
     *
     * @ORM\Column(name="item_table", type="string", length=60, nullable=false)
     */
    private $itemTable = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="item_id", type="integer", nullable=false)
     */
    private $itemId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false)
     */
    private $domainId = '0';



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
     * Set itemTable
     *
     * @param string $itemTable
     * @return Locationfulltextwherelist
     */
    public function setItemTable($itemTable)
    {
        $this->itemTable = $itemTable;

        return $this;
    }

    /**
     * Get itemTable
     *
     * @return string 
     */
    public function getItemTable()
    {
        return $this->itemTable;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     * @return Locationfulltextwherelist
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
     * Set domainId
     *
     * @param integer $domainId
     * @return Locationfulltextwherelist
     */
    public function setDomainId($domainId)
    {
        $this->domainId = $domainId;

        return $this;
    }

    /**
     * Get domainId
     *
     * @return integer 
     */
    public function getDomainId()
    {
        return $this->domainId;
    }
}
