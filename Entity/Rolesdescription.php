<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Roledescription / Droit utilisateur
 * 
 * @ORM\Table(name="rolesdescription")
 * @ORM\Entity(repositoryClass="Charlotte\StaffBundle\Repository\Rolesdescription")
 */
class Rolesdescription
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
     * Nom du droit utilisateur
     * 
     * @ORM\Column(name="name", type="string", nullable=false, options={"comment": "Nom du droit utilisateur"})
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true, options={"default": NULL})
     */
    protected $description;

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean", nullable=false, options={"default": FALSE})
     */
    protected $archived;


    public function __construct()
    {
        $this->archived     = false;
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
     * Set name
     *
     * @param string $name
     * @return Rolesdescription
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
     * Set description
     *
     * @param string $description
     * @return Rolesdescription
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return Rolesdescription
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