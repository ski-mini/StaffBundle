<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Publicholiday / Jour férié
 * 
 * @ORM\Table(name="publicholiday")
 * @ORM\Entity
 */
class Publicholiday
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
     * 
     * Nom du jour férié
     * 
     * @ORM\Column(name="name", type="string", nullable=false, options={"comment": "Nom du jour férié"})
     */
    protected $name;

    /**
     * @var \DateTime
     * 
     * Date du jour férié
     * 
     * @ORM\Column(name="dateholiday", type="datetime", nullable=true, options={"comment":"Date du jour férié"})
     */
    protected $dateholiday;

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
        $this->name 	= 	"Non renseigné";
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
     * Set dateholiday
     *
     * @param string $dateholiday
     * @return Publicholiday
     */
    public function setDateholiday($dateholiday)
    {
        $this->dateholiday = $dateholiday;
        return $this;
    }

    /**
     * Get dateholiday
     *
     * @return string
     */
    public function getDateholiday()
    {
        return $this->dateholiday;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Publicholiday
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     * @return Publicholiday
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
     * @return Publicholiday
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