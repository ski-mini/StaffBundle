<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * Maritalstatus / Statut marital
 * 
 * @ORM\Table(name="maritalstatus")
 * @ORM\Entity
 */
class Maritalstatus
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
     * Etat civil (Célibataire, Marié, etc)
     * 
     * @ORM\Column(name="value", type="string", length=50, nullable=true, options={"comment":"Etat civil"})
     */
    private $value;

    /**
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean", nullable=false, options={"default": TRUE})
     */
    private $enabled;

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean", nullable=false, options={"default": FALSE})
     */
    private $archived;

    public function __construct()
    {
        $this->enabled = true;
        $this->archived = false;
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
     * @return Maritalstatus
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
     * @return Maritalstatus
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
     * @return Maritalstatus
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