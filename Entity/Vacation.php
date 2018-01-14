<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * Vacation / Vacances
 * 
 * @ORM\Table(name="vacation")
 * @ORM\Entity
 */
class Vacation
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
     * @var date
     * @ORM\Column(name="datestart", type="date", length=50, nullable=true, options={"comment":"Date de début du congé"})
     */
    private $datestart;

    /**
     * @var date
     * @ORM\Column(name="dateend", type="date", length=50, nullable=true, options={"comment":"Date de fin du congé"})
     */
    private $dateend;
    
    /**
     * @var float
     * @ORM\Column(name="numberofpeningday", type="float", length=50, nullable=true, options={"comment":"Nombre de jour ouvert du congé"})
     */
    private $numberofopeningday;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Staff", inversedBy="vacation")
     * @ORM\JoinColumn(name="staff_id", referencedColumnName="id", nullable=true)
     */
    private $staff;

    /**
     * @var text
     * @ORM\Column(name="comment", type="text", nullable=true, options={"comment":"Commentaire du congé"})
     */
    private $comment;

    /**
     * @var integer
     * @ORM\Column(name="morning", type="integer", length=1, nullable=true, options={"comment":"Matinée sélectionnée du congé"})
     */
    private $morning;

    /**
     * @var integer
     * @ORM\Column(name="afternoon", type="integer", length=1, nullable=true, options={"comment":"Après-midi sélectionnée du congé"})
     */
    private $afternoon;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Vacationtype")
     * @ORM\JoinColumn(name="vacationtype_id", referencedColumnName="id", nullable=true)
     */
    protected $vacationtype;

    /**
     * @var integer
     * @ORM\Column(name="validated", type="integer", options={"comment":"Congé validé"})
     */
    private $validated;

    /**
     * @var date
     * @ORM\Column(name="datevalidated", type="date", length=50, nullable=true, options={"comment":"Date de validation du congé"})
     */
    private $datevalidated;

    /**
     * @var integer
     * @ORM\Column(name="recovered", type="integer", length=1, nullable=true, options={"comment":"Congé récupéré"})
     */
    private $recovered;

    /**
     * @var date
     * @ORM\Column(name="daterecovered", type="date", length=50, nullable=true, options={"comment":"Date de la récupération du congé"})
     */
    private $daterecovered;

    /**
     * @var integer
     * @ORM\Column(name="enabled", type="integer", options={"comment":"Congé actif"})
     */
    private $enabled;

    /**
     * @var integer
     * @ORM\Column(name="archived", type="integer", options={"comment":"Congé archivé"})
     */
    private $archived;

    public function __construct()
    {
        $this->validated    =   false;
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
     * Set datestart
     *
     * @param string $datestart
     * @return Vacation
     */
    public function setDatestart($datestart)
    {
        $this->datestart = $datestart;

        return $this;
    }

    /**
     * Get datestart
     *
     * @return string
     */
    public function getDatestart()
    {
        return $this->datestart;
    }

    /**
     * Set dateend
     *
     * @param string $dateend
     * @return Vacation
     */
    public function setDateend($dateend)
    {
        $this->dateend = $dateend;

        return $this;
    }

    /**
     * Get dateend
     *
     * @return string
     */
    public function getDateend()
    {
        return $this->dateend;
    }


    /**
     * Set numberofopeningday
     *
     * @param string $numberofopeningday
     * @return Vacation
     */
    public function setNumberofopeningday($numberofopeningday)
    {
        $this->numberofopeningday = $numberofopeningday;

        return $this;
    }

    /**
     * Get numberofopeningday
     *
     * @return string
     */
    public function getNumberofopeningday()
    {
        return $this->numberofopeningday;
    }

    /**
     * Set staff
     *
     * @param string $staff
     * @return Vacation
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * Get staff
     *
     * @return string
     */
    public function getStaff()
    {
        return $this->staff;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Vacation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set morning
     *
     * @param string $morning
     * @return Vacation
     */
    public function setMorning($morning)
    {
        $this->morning = $morning;

        return $this;
    }

    /**
     * Get morning
     *
     * @return string
     */
    public function getMorning()
    {
        return $this->morning;
    }

    /**
     * Set afternoon
     *
     * @param string $afternoon
     * @return Vacation
     */
    public function setAfternoon($afternoon)
    {
        $this->afternoon = $afternoon;

        return $this;
    }

    /**
     * Get afternoon
     *
     * @return string
     */
    public function getAfternoon()
    {
        return $this->afternoon;
    }

    /**
     * Set vacationtype
     *
     * @param string $vacationtype
     * @return Vacation
     */
    public function setVacationtype($vacationtype)
    {
        $this->vacationtype = $vacationtype;

        return $this;
    }

    /**
     * Get vacationtype
     *
     * @return string
     */
    public function getVacationtype()
    {
        return $this->vacationtype;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return Vacation
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set datevalidated
     *
     * @param boolean $datevalidated
     * @return Vacation
     */
    public function setDatevalidated($datevalidated)
    {
        $this->datevalidated = $datevalidated;

        return $this;
    }

    /**
     * Get datevalidated
     *
     * @return boolean
     */
    public function getDatevalidated()
    {
        return $this->datevalidated;
    }

    /**
     * Set recovered
     *
     * @param boolean $recovered
     * @return Vacation
     */
    public function setRecovered($recovered)
    {
        $this->recovered = $recovered;

        return $this;
    }

    /**
     * Get recovered
     *
     * @return boolean
     */
    public function getRecovered()
    {
        return $this->recovered;
    }

    /**
     * Set daterecovered
     *
     * @param boolean $daterecovered
     * @return Vacation
     */
    public function setDaterecovered($daterecovered)
    {
        $this->daterecovered = $daterecovered;

        return $this;
    }

    /**
     * Get daterecovered
     *
     * @return boolean
     */
    public function getDaterecovered()
    {
        return $this->daterecovered;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
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
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }
    
}