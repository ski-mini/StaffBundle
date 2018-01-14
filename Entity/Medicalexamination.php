<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * Medicalexamination / Visite médicale
 * 
 * @ORM\Table(name="medicalexamination")
 * @ORM\Entity
 */
class Medicalexamination
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
     * @var \DateTime
     * 
     * Date de la visite médicale
     * 
     * @ORM\Column(name="medate", type="datetime", nullable=true, options={"comment":"Date de la visite médicale"})
     */
    private $date;

    /**
     * @var string
     * 
     * Résultat de la visite médicale
     * 
     * @ORM\Column(name="result", type="string", length=50, nullable=true, options={"comment":"Résultat de la visite médicale"})
     */
    private $result;

    /**
     * @var string
     * 
     * Fichier de la visite médicale
     * 
     * @ORM\Column(name="file", type="string", length=255, nullable=true, options={"comment":"Fichier de la visite médicale"})
     */
    private $file;
    
    /**
     * @var integer
     * @ORM\Column(name="enabled", type="integer", nullable=false)
     */
    private $enabled;

    /**
     * @var integer
     * @ORM\Column(name="archived", type="integer", nullable=false)
     */
    private $archived;

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
     * Set date
     *
     * @param string $date
     * @return Medicalexamination
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getDate()
    {
        return $this->result;
    }



    /**
     * Set result
     *
     * @param string $result
     * @return Medicalexamination
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }



    /**
     * Set file
     *
     * @param string $file
     * @return Medicalexamination
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }



    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Medicalexamination
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
     * @param integer $archived
     * @return Medicalexamination
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