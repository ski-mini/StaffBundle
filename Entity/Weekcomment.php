<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * Weekcomment / Commentaire pour les semaines (planning)
 * 
 * @ORM\Table(name="weekcomment")
 * @ORM\Entity
 */
class Weekcomment
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
     * @var text
     * 
     * Commentaire pour la semaine
     * 
     * @ORM\Column(name="value", type="text", nullable=true, options={"comment":"Commentaire pour la semaine"})
     */
    private $value;

    /**
     * @var integer
     * 
     * Année
     * 
     * @ORM\Column(name="year", type="integer", options={"comment":"Année"})
     */
    private $year;

    /**
     * @var integer
     * 
     * Numéro de semaine
     * 
     * @ORM\Column(name="weeknumber", type="integer", options={"comment":"Numéro de semaine"})
     */
    private $weeknumber;

    /**
     * @var integer
     * @ORM\Column(name="enabled", type="integer", options={"comment":"Commentaire actif"})
     */
    private $enabled;

    /**
     * @var integer
     * @ORM\Column(name="archived", type="integer", options={"comment":"Commentaire archivé"})
     */
    private $archived;

    public function __construct()
    {
        $this->enabled      =   1;
        $this->archived     =   0;
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
     * Set year
     *
     * @param string $year
     * @return Vacation
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

	/**
     * Set weeknumber
     *
     * @param string $weeknumber
     * @return Vacation
     */
    public function setWeeknumber($weeknumber)
    {
        $this->weeknumber = $weeknumber;

        return $this;
    }

    /**
     * Get weeknumber
     *
     * @return string
     */
    public function getWeeknumber()
    {
        return $this->weeknumber;
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