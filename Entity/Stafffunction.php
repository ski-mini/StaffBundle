<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Staff Function / Fonction de l'utilisateur
 * 
 * @ORM\Table(name="stafffunction")
 * @ORM\Entity
 */
class Stafffunction
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
     * Nom de la fonction de l'utilisateur
     * 
     * @ORM\Column(name="value", type="string", length=50, nullable=false, options={"comment":"Nom de la fonction de l\'utilisateur"})
     */
    private $value;

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
     * Set value
     *
     * @param string $value
     * @return Contracttype
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
     * Set enabled
     *
     * @param integer $enabled
     * @return Contracttype
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
     * @return Contracttype
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