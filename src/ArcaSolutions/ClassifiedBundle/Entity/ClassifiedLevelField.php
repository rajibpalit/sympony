<?php

namespace ArcaSolutions\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassifiedLevelField
 *
 * @ORM\Table(name="ClassifiedLevel_Field", indexes={@ORM\Index(name="theme", columns={"theme", "level"})})
 * @ORM\Entity(repositoryClass="ArcaSolutions\ClassifiedBundle\Repository\ClassifiedLevelFieldRepository")
 */
class ClassifiedLevelField
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
     * @ORM\Column(name="theme", type="string", length=30, nullable=false)
     */
    private $theme;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=20, nullable=false)
     */
    private $field;



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
     * Set theme
     *
     * @param string $theme
     * @return ClassifiedLevelField
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return ClassifiedLevelField
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set field
     *
     * @param string $field
     * @return ClassifiedLevelField
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return string 
     */
    public function getField()
    {
        return $this->field;
    }
}
