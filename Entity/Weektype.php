<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * Weektype / type de semaine
 * 
 * @ORM\Table(name="weektype")
 * @ORM\Entity
 */
class Weektype
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
     * Valeur du type de semaine
     * 
     * @ORM\Column(name="value", type="string", length=50, options={"comment":"Valeur du type de semaine"})
     */
    private $value;

    /**
     * @var string
     * 
     * Couleur du type de semaine
     * 
     * @ORM\Column(name="color", type="string", length=50, options={"comment":"Couleur du type de semaine"})
     */
    private $color;

    /**
     * @var string
     * 
     * horaire de départ de la semaine
     * 
     * @ORM\Column(name="start", type="string", length=50, options={"comment":"horaire de départ de la semaine"})
     */
    private $start;

    /**
     * @var string
     * 
     * horaire de fin de la semaine
     * 
     * @ORM\Column(name="end", type="string", length=50, options={"comment":"horaire de fin de la semaine"})
     */
    private $end;
    
    /**
     * @var integer
     * @ORM\Column(name="enabled", type="integer", options={"comment":"Type de semaine active"})
     */
    private $enabled;

    /**
     * @var integer
     * @ORM\Column(name="archived", type="integer", options={"comment":"Type de semaine archivé"})
     */
    private $archived;

    public function __construct()
    {
        $this->enabled      =   true;
        $this->archived     =   false;
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
     * @return Vacation
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
     * Set color
     *
     * @param string $color
     * @return Vacation
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

	/**
     * Set start
     *
     * @param string $start
     * @return Vacation
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

	/**
     * Set end
     *
     * @param string $end
     * @return Vacation
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     * @return Vacation
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
     * @return Vacation
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