<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * Serviceoffice / Service bureau
 * 
 * @ORM\Table(name="serviceoffice")
 * @ORM\Entity
 */
class Serviceoffice
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
     * Nom service
     * 
     * @ORM\Column(name="value", type="string", length=50, nullable=true, options={"comment": "Nom service"})
     */
    private $value;

    /**
     * @var string
     * 
     * Raccourci nom service
     * 
     * @ORM\Column(name="shortcut", type="string", length=50, nullable=true, options={"comment": "Raccourci nom service."})
     */
    private $shortcut;

    /**
     * @var integer
     * 
     * Offset utile pour le tri
     * 
     * @ORM\Column(name="offset", type="integer", length=2, options={"comment": "Offset utile pour le tri"})
     */
    private $offset;

    /**
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived;

    public function __construct()
    {
        $this->enabled  =   true;
        $this->archived =   false;
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
     * @return Serviceoffice
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
     * Set shortcut
     *
     * @param string $shortcut
     * @return Serviceoffice
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    /**
     * Get shortcut
     *
     * @return string
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * Set offset
     *
     * @param string $offset
     * @return Serviceoffice
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Get offset
     *
     * @return string
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Serviceoffice
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
     * @return Serviceoffice
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