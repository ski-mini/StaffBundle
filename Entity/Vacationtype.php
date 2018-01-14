<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * @ORM\Table(name="vacationtype")
 * @ORM\Entity
 */
class Vacationtype
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
     * @ORM\Column(name="value", type="string", length=50, nullable=true)
     */
    private $value;

    /**
     * @var string
     * @ORM\Column(name="color", type="string", length=7, nullable=true)
     */
    private $color;

    /**
     * @var integer
     * @ORM\Column(name="iscounted", type="integer", length=1, nullable=true, options={"comment":"Est un congé a prendre en compte dans la comptabilité"})
     */
    private $iscounted;

    /**
     * @var integer
     * @ORM\Column(name="enabled", type="integer")
     */
    private $enabled;

    /**
     * @var integer
     * @ORM\Column(name="archived", type="integer")
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
     * @return Vacationtype
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
     * Set iscounted
     *
     * @param boolean $iscounted
     * @return Vacationtype
     */
    public function setIscounted($iscounted)
    {
        $this->iscounted = $iscounted;

        return $this;
    }

    /**
     * Get iscounted
     *
     * @return boolean
     */
    public function getIscounted()
    {
        return $this->iscounted;
    }






    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Vacationtype
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
     * @return Vacationtype
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