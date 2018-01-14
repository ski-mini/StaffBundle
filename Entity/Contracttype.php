<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contracttype / Type de contrat
 * 
 * @ORM\Table(name="contracttype")
 * @ORM\Entity
 */
class Contracttype
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * 
     * Nom du type de contrat (CDI, CDD, Stage, etc)
     * 
     * @ORM\Column(name="value", type="string", length=50, nullable=false, options={"comment":"Nom du type de contrat (CDI, CDD, Stage, etc)"})
     */
    private $value;

    /**
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean", length=1, nullable=false, options={"default":1})
     */
    private $enabled;

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean", length=1, nullable=false, options={"default":0})
     */
    private $archived;

    public function __construct()
    {
        $this->enabled  =   true;
        $this->archived =   false;
        //$this->staffs   =   new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set value
     *
     * @param string $value
     * @return Contracttype
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Contracttype
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return Contracttype
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }
}