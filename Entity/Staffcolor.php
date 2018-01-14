<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Staffcolor / couleur staff 
 * 
 * @ORM\Table(name="staffcolor")
 * @ORM\Entity(repositoryClass="Charlotte\StaffBundle\Repository\Staffcolor")
 */
class Staffcolor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="value", type="string", length=10, nullable=false, options={"comment": "Nom de la couleur"})
     */
    protected $value;

    /**
     * @var string
     * @ORM\Column(name="hexa", type="string", length=10, nullable=false, options={"comment": "Code hexadecimal de la couleur"})
     */
    protected $hexa;

    /**
     * @var integer
     * @ORM\Column(name="enabled", type="integer", nullable=false)
     */
    protected $enabled;

    /**
     * @var integer
     * @ORM\Column(name="archived", type="integer", nullable=false)
     */
    protected $archived;


    public function __construct()
    {
        $this->enabled 	= 	1;
        $this->archived = 	0;
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
     * @param integer $value
     * @return Staffcolor
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set hexa
     *
     * @param integer $hexa
     * @return Staffcolor
     */
    public function setHexa($hexa)
    {
        $this->hexa = $hexa;

        return $this;
    }

    /**
     * Get hexa
     *
     * @return string
     */
    public function getHexa()
    {
        return $this->hexa;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     * @return Staffcolor
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return integer
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set archived
     *
     * @param integer $archived
     * @return Staffcolor
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return integer
     */
    public function getArchived()
    {
        return $this->archived;
    }
}