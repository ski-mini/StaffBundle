<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commercialschedule / planning commercial 
 * 
 * @ORM\Table(name="commercialschedule")
 * @ORM\Entity
 */
class Commercialschedule
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
     * Date du planning
     * 
     * @ORM\Column(name="dateschedule", type="datetime", length=50, nullable=true, options={"comment":"Date du planning"})
     */
    private $dateschedule;

    /**
     * @var text
     * 
     * Commentaire
     * 
     * @ORM\Column(name="comment", type="text", nullable=true, options={"comment":"Commentaire"})
     */
    private $comment;

    /**
     * @var integer
     * 
     * Jointure sur le type de semaine (A,B,C,D, etc) (Foreign Key)
     * 
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Weektype")
     * @ORM\JoinColumn(name="weektype_id", referencedColumnName="id", nullable=true)
     */
    private $weektype;

    /**
     * @var integer
     * 
     * Jointure sur le staff (Foreign Key)
     * 
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Staff", inversedBy="vacation")
     * @ORM\JoinColumn(name="staff_id", referencedColumnName="id", nullable=true)
     */
    private $staff;

    /**
     * @var integer
     * @ORM\Column(name="enabled", type="integer", length=1, nullable=false, options={"default":1})
     */
    private $enabled;

    /**
     * @var integer
     * @ORM\Column(name="archived", type="integer", length=1, nullable=false, options={"default":0})
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
     * Set dateschedule
     *
     * @param string $dateschedule
     * @return Commercialschedule
     */
    public function setDateschedule($dateschedule)
    {
        $this->dateschedule = $dateschedule;

        return $this;
    }

    /**
     * Get dateschedule
     *
     * @return string
     */
    public function getDateschedule()
    {
        return $this->dateschedule;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Commercialschedule
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
     * Set weektype
     *
     * @param string $weektype
     * @return Commercialschedule
     */
    public function setWeektype($weektype)
    {
        $this->weektype = $weektype;

        return $this;
    }

    /**
     * Get weektype
     *
     * @return string
     */
    public function getWeektype()
    {
        return $this->weektype;
    }




    /**
     * Set staff
     *
     * @param string $staff
     * @return Commercialschedule
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
     * Set enabled
     *
     * @param integer $enabled
     * @return Commercialschedule
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
     * @return Commercialschedule
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