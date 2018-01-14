<?php

namespace Charlotte\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\PreSerialize;

/**
 * Staff / Utilisateur
 *
 * @ORM\Table(name="staff")
 * @ORM\Entity(repositoryClass="Charlotte\StaffBundle\Repository\Staff")
 */

class Staff extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"comment":"Identifiant unique de l\'utilisateur"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Charlotte\StaffBundle\Entity\Team")
     * @ORM\JoinTable(name="staff_team",
     *      joinColumns={@ORM\JoinColumn(name="staff_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")}
     * )
     * @Exclude
     */
    protected $groups;

    /**
     * @ORM\ManyToMany(targetEntity="Charlotte\MainBundle\Entity\Phone")
     * @ORM\JoinTable(name="staff_phone",
     *      joinColumns={@ORM\JoinColumn(name="phone_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="staffphone_id", referencedColumnName="id")}
     * )
     */
    protected $phones;

    /**
     * @ORM\ManyToMany(targetEntity="Charlotte\MainBundle\Entity\Email")
     * @ORM\JoinTable(name="staff_email",
     *      joinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="staff_id", referencedColumnName="id")}
     * )
     */
    protected $emails;

    /**
     * @ORM\ManyToMany(targetEntity="Charlotte\StaffBundle\Entity\Medicalexamination")
     * @ORM\JoinTable(name="staff_medicalexamination",
     *      joinColumns={@ORM\JoinColumn(name="medicalexamination_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="staff_id", referencedColumnName="id")}
     * )
     */
    protected $medicalexaminations;

    /**
     * @ORM\OneToMany(targetEntity="Charlotte\MessagingBundle\Entity\AccountStaff", mappedBy="staffId")
     * @Exclude
     */
    private $messagingAccountStaffs;

    /**
     * The salt to use for hashing
     * @Exclude
     * @var string
     */
    protected $salt;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Contracttype")
     * @ORM\JoinColumn(name="contracttype_id", referencedColumnName="id", nullable=true)
     */
    protected $contracttype;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\MainBundle\Entity\Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
     */
    protected $company;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\MainBundle\Entity\Nation")
     * @ORM\JoinColumn(name="nation_id", referencedColumnName="id", nullable=true)
     */
    protected $nation;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Serviceoffice")
     * @ORM\JoinColumn(name="serviceoffice_id", referencedColumnName="id", nullable=true)
     */
    protected $serviceoffice;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Stafffunction")
     * @ORM\JoinColumn(name="stafffunction_id", referencedColumnName="id", nullable=true)
     */
    protected $stafffunction;

    /**
     * @ORM\OneToMany(targetEntity="Charlotte\StaffBundle\Entity\Vacation", mappedBy="staff")
     **/
    private $vacation;

    /**
     * @var string
     * @ORM\Column(name="initials", type="string", length=4, nullable=true, options={"comment":"Initial de l\'utilisateur"})
     */
    protected $initials;

    /**
     * @var string
     * @ORM\Column(name="gender", type="string", length=15, nullable=true, options={"comment":"Civilité de l\'utilisateur"})
     */
    protected $gender;

    /**
     * @var string
     * @ORM\Column(name="firstname", type="string", length=25, nullable=true, options={"comment":"Prénom de l\'utilisateur"})
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(name="marriedname", type="string", length=25, nullable=true, options={"comment":"Nom marital"})
     */
    protected $marriedname;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=25, nullable=true, options={"comment":"Nom de famille de l\'utilisateur"})
     */
    protected $lastname;

    /**
     * @var string
     * @ORM\Column(name="postcode", type="string", length=50, nullable=true, options={"comment":"Code postal de l\'utilisateur"})
     */
    protected $postcode;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=100, nullable=true, options={"comment":"Ville de l\'utilisateur"})
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(name="number", type="string", length=10, nullable=true, options={"comment":"Numéro de la rue"})
     */
    protected $number;

    /**
     * @var string
     * @ORM\Column(name="extension", type="string", length=10, nullable=true, options={"comment":"Extension de la rue"})
     */
    protected $extension;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\DealBundle\Entity\Waytype")
     * @ORM\JoinColumn(name="waytype_id", referencedColumnName="id", nullable=true)
     */
    protected $waytype;

    /**
     * @var string
     * @ORM\Column(name="address1", type="string", length=255, nullable=true, options={"comment":"Adresse (1) de l\'utilisateur"})
     */
    protected $address1;

    /**
     * @var string
     * @ORM\Column(name="address2", type="string", length=255, nullable=true, options={"comment":"Adresse (2) de l\'utilisateur"})
     */
    protected $address2;

    /**
     * @var string
     * @ORM\Column(name="professionalphone", type="string", length=255, nullable=true, options={"comment":"Téléphone fixe pro de l\'utilisateur"})
     */
    protected $professionalphone;

    /**
     * @var string
     * @ORM\Column(name="professionalmobile", type="string", length=255, nullable=true, options={"comment":"Téléphone mobile pro de l\'utilisateur"})
     */
    protected $professionalmobile;

    /**
     * @var string
     * @ORM\Column(name="professionalfax", type="string", length=255, nullable=true, options={"comment":"Fax pro de l\'utilisateur"})
     */
    protected $professionalfax;

    /**
     * @var string
     * @ORM\Column(name="professionalmail", type="string", length=255, nullable=true, options={"comment":"Email pro de l\'utilisateur"})
     */
    protected $professionalmail;

    /**
     * @var string
     * @ORM\Column(name="profesionnalcopymail", type="string", length=255, nullable=true, options={"comment":"Email pro copie de l\'utilisateur"})
     */
    protected $profesionnalcopymail;

    /**
     * @var integer
     * @ORM\Column(name="internalphone", type="integer", length=4, nullable=true, options={"comment":"Numéro de téléphone interne de l\'utilisateur"})
     */
    protected $internalphone;

    /**
     * @var string
     * @ORM\Column(name="personnalmail", type="string", length=255, nullable=true, options={"comment":"Email personnel de l\'utilisateur"})
     */
    protected $personnalmail;

    /**
     * @var string
     * @ORM\Column(name="personnalphone", type="string", length=255, nullable=true, options={"comment":"Numéro de téléphone fixe personnel de l\'utilisateur"})
     */
    protected $personnalphone;

    /**
     * @var string
     * @ORM\Column(name="personnalmobile", type="string", length=255, nullable=true, options={"comment":"Numéro de téléphone mobile personnel de l\'utilisateur"})
     */
    protected $personnalmobile;

    /**
     * @var boolean
     * @ORM\Column(name="menucolapsedbydefault", length=1, nullable=true, options={"comment":"Défini si le menu est fermé ou ouvert"})
     */
    protected $menucolapsedbydefault;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateofbirth", type="datetime", nullable=true, options={"comment":"Date de naissance"})
     */
    protected $dateofbirth;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateofstart", type="datetime", nullable=true, options={"comment":"Date d\'embauche"})
     */
    protected $dateofstart;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateofend", type="datetime", nullable=true, options={"comment":"Date de départ"})
     */
    protected $dateofend;

    /**
     * @var string
     * @ORM\Column(name="contracthour", type="string", length=255, nullable=true, options={"comment":"Nombre d\'heure par semaine mentionné par le contrat"})
     */
    protected $contracthour;

    /**
     * @var integer
     * @ORM\Column(name="contractvacation", type="integer", length=10, nullable=true, options={"comment":"Nombre de jour de congé annuel mentionné par le contrat"})
     */
    protected $contractvacation;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", length=255, nullable=true, options={"comment":"Photo de l\'utilisateur"})
     */
    protected $picture;

    /**
     * @var string
     * @ORM\Column(name="socialsecuritynumber", type="string", length=50, nullable=true, options={"comment":"Numéro de sécurité sociale"})
     */
    protected $socialsecuritynumber;

    /**
     * @var string
     * @ORM\Column(name="registrationnumber", type="string", length=50, nullable=true, options={"comment":"Numéro de Matricule"})
     */
    protected $registrationnumber;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Maritalstatus")
     * @ORM\JoinColumn(name="maritalstatus_id", referencedColumnName="id")
     */
    protected $maritalstatus;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Charlotte\StaffBundle\Entity\Staff")
     * @ORM\JoinColumn(name="responsible_id", referencedColumnName="id")
     */
    protected $responsible;

    /**
     * @var string
     * @ORM\Column(name="idcard", type="string", length=255, nullable=true, options={"comment":"Pièce d\'identité"})
     */
    protected $idcart;

    /**
     * @var string
     * @ORM\Column(name="rib", type="string", length=255, nullable=true, options={"comment":"Releve d\'identite bancaire"})
     */
    protected $rib;

    /**
     * @var string
     * @ORM\Column(name="imageright", type="string", length=255, nullable=true, options={"comment":"Droit à l\'image"})
     */
    protected $imageright;

    /**
     * @var string
     * @ORM\Column(name="color", type="string", length=255, nullable=true, options={"comment":"Couleur"})
     */
    protected $color;

    /**
     * @var string
     * @ORM\Column(name="mutuality", type="string", length=255, nullable=true, options={"comment":"Mutuelle"})
     */
    protected $mutuality;

    /**
     * @var \DateTime
     * @ORM\Column(name="datemutualityaffiliate", type="datetime", nullable=true, options={"comment":"Date de d\'affiliation"})
     */
    protected $datemutualityaffiliate;

    /**
     * @var \DateTime
     * @ORM\Column(name="datemutualityexemption", type="datetime", nullable=true, options={"comment":"Date de dispense"})
     */
    protected $datemutualityexemption;

    /**
     * @var string
     * @ORM\Column(name="filemutualityaffiliate", type="string", length=255, nullable=true, options={"comment":"Fichier d\'affiliation"})
     */
    protected $filemutualityaffiliate;

    /**
     * @var string
     * @ORM\Column(name="filemutualityexemption", type="string", length=255, nullable=true, options={"comment":"Fichier de dispense"})
     */
    protected $filemutualityexemption;

    /**
     * @var string
     * @ORM\Column(name="filestageconvention", type="string", length=255, nullable=true, options={"comment":"Fichier de convention de stage"})
     */
    protected $filestageconvention;

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean", nullable=false, options={"default": FALSE, "comment":"Utilisateur archivé ou pas"})
     */
    protected $archived;

    /*
    * Champ calculé : jours de congé restant
    */
    protected $remaingdaysofvacation;

    /*
    * Champ calculé : jours de congé sur le mois courant
    */
    protected $vacationcurrentmonth;

    /*
    * Champ calculé : nombre de champ non rempli
    */
    protected $unsetfield;

    public function __construct()
    {
        parent::__construct();
        $this->unsetfield           =   0;
        $this->contractvacation     =   0;
        $this->enabled              =   true;
        $this->archived             =   false;
        $this->groups               =   new ArrayCollection();
        $this->phones               =   new ArrayCollection();
        $this->emails               =   new ArrayCollection();
        $this->vacation             =   new ArrayCollection();
    }

    //=====Functions

    //=====End functions

    /**
     * Add groups
     *
     * @param \FOS\UserBundle\Model\GroupInterface $groups
     * @return Staff
     */
    public function addGroup(\FOS\UserBundle\Model\GroupInterface $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \FOS\UserBundle\Model\GroupInterface $groups
     */
    public function removeGroup(\FOS\UserBundle\Model\GroupInterface $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
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
     * Set initials
     *
     * @param string $initials
     * @return Staff
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * Get initials
     *
     * @return string
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Staff
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Staff
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set marriedname
     *
     * @param string $marriedname
     * @return Staff
     */
    public function setMarriedname($marriedname)
    {
        $this->marriedname = $marriedname;

        return $this;
    }

    /**
     * Get marriedname
     *
     * @return string
     */
    public function getMarriedname()
    {
        return $this->marriedname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Staff
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Staff
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Staff
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Staff
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Staff
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set waytype
     *
     * @param string $waytype
     * @return Staff
     */
    public function setWaytype($waytype)
    {
        $this->waytype = $waytype;

        return $this;
    }

    /**
     * Get waytype
     *
     * @return string
     */
    public function getWaytype()
    {
        return $this->waytype;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Staff
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Staff
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set professionalphone
     *
     * @param string $professionalphone
     * @return Staff
     */
    public function setProfessionalphone($professionalphone)
    {
        $this->professionalphone = $professionalphone;

        return $this;
    }

    /**
     * Get professionalphone
     *
     * @return string
     */
    public function getProfessionalphone()
    {
        return $this->professionalphone;
    }

    /**
     * Set professionalmobile
     *
     * @param string $professionalmobile
     * @return Staff
     */
    public function setProfessionalmobile($professionalmobile)
    {
        $this->professionalmobile = $professionalmobile;

        return $this;
    }

    /**
     * Get professionalmobile
     *
     * @return string
     */
    public function getProfessionalmobile()
    {
        return $this->professionalmobile;
    }

    /**
     * Set professionalfax
     *
     * @param string $professionalfax
     * @return Staff
     */
    public function setProfessionalfax($professionalfax)
    {
        $this->professionalfax = $professionalfax;

        return $this;
    }

    /**
     * Get professionalfax
     *
     * @return string
     */
    public function getProfessionalfax()
    {
        return $this->professionalfax;
    }

    /**
     * Set professionalmail
     *
     * @param string $professionalmail
     * @return Staff
     */
    public function setProfessionalmail($professionalmail)
    {
        $this->professionalmail = $professionalmail;

        return $this;
    }

    /**
     * Get professionalmail
     *
     * @return string
     */
    public function getProfessionalmail()
    {
        return $this->professionalmail;
    }

    /**
     * Set profesionnalcopymail
     *
     * @param string $profesionnalcopymail
     * @return Staff
     */
    public function setProfesionnalcopymail($profesionnalcopymail)
    {
        $this->profesionnalcopymail = $profesionnalcopymail;

        return $this;
    }

    /**
     * Get profesionnalcopymail
     *
     * @return string
     */
    public function getProfesionnalcopymail()
    {
        return $this->profesionnalcopymail;
    }

    /**
     * Set internalphone
     *
     * @param integer $internalphone
     * @return Staff
     */
    public function setInternalphone($internalphone)
    {
        $this->internalphone = $internalphone;

        return $this;
    }

    /**
     * Get internalphone
     *
     * @return integer
     */
    public function getInternalphone()
    {
        return $this->internalphone;
    }

    /**
     * Set personnalmail
     *
     * @param string $personnalmail
     * @return Staff
     */
    public function setPersonnalmail($personnalmail)
    {
        $this->personnalmail = $personnalmail;

        return $this;
    }

    /**
     * Get personnalmail
     *
     * @return string
     */
    public function getPersonnalmail()
    {
        return $this->personnalmail;
    }

    /**
     * Set personnalphone
     *
     * @param string $personnalphone
     * @return Staff
     */
    public function setPersonnalphone($personnalphone)
    {
        $this->personnalphone = $personnalphone;

        return $this;
    }

    /**
     * Get personnalphone
     *
     * @return string
     */
    public function getPersonnalphone()
    {
        return $this->personnalphone;
    }

    /**
     * Set personnalmobile
     *
     * @param string $personnalmobile
     * @return Staff
     */
    public function setPersonnalmobile($personnalmobile)
    {
        $this->personnalmobile = $personnalmobile;

        return $this;
    }

    /**
     * Get personnalmobile
     *
     * @return string
     */
    public function getPersonnalmobile()
    {
        return $this->personnalmobile;
    }

    /**
     * Set menucolapsedbydefault
     *
     * @param string $menucolapsedbydefault
     * @return Staff
     */
    public function setMenucolapsedbydefault($menucolapsedbydefault)
    {
        $this->menucolapsedbydefault = $menucolapsedbydefault;

        return $this;
    }

    /**
     * Get menucolapsedbydefault
     *
     * @return string
     */
    public function getMenucolapsedbydefault()
    {
        return $this->menucolapsedbydefault;
    }

    /**
     * Set dateofbirth
     *
     * @param \DateTime $dateofbirth
     * @return Staff
     */
    public function setDateofbirth($dateofbirth)
    {
        $this->dateofbirth = $dateofbirth;

        return $this;
    }

    /**
     * Get dateofbirth
     *
     * @return \DateTime
     */
    public function getDateofbirth()
    {
        return $this->dateofbirth;
    }

    /**
     * Set dateofstart
     *
     * @param \DateTime $dateofstart
     * @return Staff
     */
    public function setDateofstart($dateofstart)
    {
        $this->dateofstart = $dateofstart;

        return $this;
    }

    /**
     * Get dateofstart
     *
     * @return \DateTime
     */
    public function getDateofstart()
    {
        return $this->dateofstart;
    }

    /**
     * Set dateofend
     *
     * @param \DateTime $dateofend
     * @return Staff
     */
    public function setDateofend($dateofend)
    {
        $this->dateofend = $dateofend;

        return $this;
    }

    /**
     * Get dateofend
     *
     * @return \DateTime
     */
    public function getDateofend()
    {
        return $this->dateofend;
    }

    /**
     * Set contracthour
     *
     * @param String $contracthour
     * @return Staff
     */
    public function setContracthour($contracthour)
    {
        $this->contracthour = $contracthour;

        return $this;
    }

    /**
     * Get contracthour
     *
     * @return String
     */
    public function getContracthour()
    {
        return $this->contracthour;
    }

    /**
     * Set contractvacation
     *
     * @param String $contractvacation
     * @return Staff
     */
    public function setContractvacation($contractvacation)
    {
        $this->contractvacation = $contractvacation;

        return $this;
    }

    /**
     * Get contractvacation
     *
     * @return String
     */
    public function getContractvacation()
    {
        return $this->contractvacation;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Staff
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set socialsecuritynumber
     *
     * @param string $socialsecuritynumber
     * @return Staff
     */
    public function setSocialsecuritynumber($socialsecuritynumber)
    {
        $this->socialsecuritynumber = $socialsecuritynumber;

        return $this;
    }

    /**
     * Get socialsecuritynumber
     *
     * @return string
     */
    public function getSocialsecuritynumber()
    {
        return $this->socialsecuritynumber;
    }

    /**
     * Set registrationnumber
     *
     * @param string $registrationnumber
     * @return Staff
     */
    public function setRegistrationnumber($registrationnumber)
    {
        $this->registrationnumber = $registrationnumber;

        return $this;
    }

    /**
     * Get registrationnumber
     *
     * @return string
     */
    public function getRegistrationnumber()
    {
        return $this->registrationnumber;
    }

    /**
     * Set idcart
     *
     * @param string $idcart
     * @return Staff
     */
    public function setIdcart($idcart)
    {
        $this->idcart = $idcart;

        return $this;
    }

    /**
     * Get idcart
     *
     * @return string
     */
    public function getIdcart()
    {
        return $this->idcart;
    }

    /**
     * Set rib
     *
     * @param string $rib
     * @return Staff
     */
    public function setRib($rib)
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * Get rib
     *
     * @return string
     */
    public function getRib()
    {
        return $this->rib;
    }

    /**
     * Set imageright
     *
     * @param string $imageright
     * @return Staff
     */
    public function setImageright($imageright)
    {
        $this->imageright = $imageright;

        return $this;
    }

    /**
     * Get imageright
     *
     * @return string
     */
    public function getImageright()
    {
        return $this->imageright;
    }

    /**
     * Set color
     *
     * @param boolean $color
     * @return Staff
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return boolean
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return Staff
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

    /**
     * Add messagingAccountStaffs
     *
     * @param \Charlotte\MessagingBundle\Entity\AccountStaff $messagingAccountStaffs
     * @return Staff
     */
    public function addMessagingAccountStaff(\Charlotte\MessagingBundle\Entity\AccountStaff $messagingAccountStaffs)
    {
        $this->messagingAccountStaffs[] = $messagingAccountStaffs;

        return $this;
    }

    /**
     * Remove messagingAccountStaffs
     *
     * @param \Charlotte\MessagingBundle\Entity\AccountStaff $messagingAccountStaffs
     */
    public function removeMessagingAccountStaff(\Charlotte\MessagingBundle\Entity\AccountStaff $messagingAccountStaffs)
    {
        $this->messagingAccountStaffs->removeElement($messagingAccountStaffs);
    }

    /**
     * Get messagingAccountStaffs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessagingAccountStaffs()
    {
        return $this->messagingAccountStaffs;
    }

    /**
     * Set contracttype
     *
     * @param \Charlotte\StaffBundle\Entity\Contracttype $contracttype
     * @return Staff
     */
    public function setContracttype(\Charlotte\StaffBundle\Entity\Contracttype $contracttype = null)
    {
        $this->contracttype = $contracttype;

        return $this;
    }

    /**
     * Get contracttype
     *
     * @return \Charlotte\StaffBundle\Entity\Contracttype
     */
    public function getContracttype()
    {
        return $this->contracttype;
    }

    /**
     * Set company
     *
     * @param \Charlotte\MainBundle\Entity\Company $company
     * @return Staff
     */
    public function setCompany(\Charlotte\MainBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Charlotte\MainBundle\Entity\company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set nation
     *
     * @param \Charlotte\MainBundle\Entity\Nation $nation
     * @return Staff
     */
    public function setNation(\Charlotte\MainBundle\Entity\Nation $nation = null)
    {
        $this->nation = $nation;

        return $this;
    }

    /**
     * Get nation
     *
     * @return \Charlotte\MainBundle\Entity\Nation
     */
    public function getNation()
    {
        return $this->nation;
    }

    /**
     * Set serviceoffice
     *
     * @param \Charlotte\StaffBundle\Entity\Serviceoffice $serviceoffice
     * @return Staff
     */
    public function setServiceoffice(\Charlotte\StaffBundle\Entity\Serviceoffice $serviceoffice = null)
    {
        $this->serviceoffice = $serviceoffice;

        return $this;
    }

    /**
     * Get serviceoffice
     *
     * @return \Charlotte\StaffBundle\Entity\Serviceoffice
     */
    public function getServiceoffice()
    {
        return $this->serviceoffice;
    }


    /**
     * Set stafffunction
     *
     * @param \Charlotte\StaffBundle\Entity\Stafffunction $stafffunction
     * @return Staff
     */
    public function setStaffFunction(\Charlotte\StaffBundle\Entity\Stafffunction $stafffunction = null)
    {
        $this->stafffunction = $stafffunction;

        return $this;
    }

    /**
     * Get stafffunction
     *
     * @return \Charlotte\StaffBundle\Entity\Stafffunction
     */
    public function getStaffFunction()
    {
        return $this->stafffunction;
    }

    /**
     * Set maritalstatus
     *
     * @param \Charlotte\StaffBundle\Entity\Maritalstatus $maritalstatus
     * @return Staff
     */
    public function setMaritalstatus(\Charlotte\StaffBundle\Entity\Maritalstatus $maritalstatus = null)
    {
        $this->maritalstatus = $maritalstatus;

        return $this;
    }

    /**
     * Get maritalstatus
     *
     * @return \Charlotte\StaffBundle\Entity\Maritalstatus
     */
    public function getMaritalstatus()
    {
        return $this->maritalstatus;
    }

    /**
     * Set responsible
     *
     * @param \Charlotte\StaffBundle\Entity\Staff $staff
     * @return Staff
     */
    public function setResponsible(\Charlotte\StaffBundle\Entity\Staff $responsible = null)
    {
        $this->responsible = $responsible;

        return $this;
    }

    /**
     * Get responsible
     *
     * @return \Charlotte\StaffBundle\Entity\Staff
     */
    public function getResponsible()
    {
        return $this->responsible;
    }

    /**
     * Add phone
     *
     * @return \Charlotte\StaffBundle\Entity\Staff
     */
    public function addPhone(\Charlotte\MainBundle\Entity\Phone $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * Add email
     *
     * @return \Charlotte\StaffBundle\Entity\Staff
     */
    public function addEmail(\Charlotte\MainBundle\Entity\Email $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Add email
     *
     * @return \Charlotte\StaffBundle\Entity\Staff
     */
    public function addMedicalexamination(\Charlotte\StaffBundle\Entity\Medicalexamination $medicalexamination)
    {
        $this->medicalexaminations[] = $medicalexamination;

        return $this;
    }

    /**
     * Set mutuality
     *
     * @param string
     * @return Staff
     */
    public function setMutuality($mutuality)
    {
        $this->mutuality = $mutuality;

        return $this;
    }

    /**
     * Get mutuality
     *
     * @return string
     */
    public function getMutuality()
    {
        return $this->mutuality;
    }


    /**
     * Set datemutualityaffiliate
     *
     * @param Datetime
     * @return Staff
     */
    public function setDatemutualityaffiliate($datemutualityaffiliate)
    {
        $this->datemutualityaffiliate = $datemutualityaffiliate;

        return $this;
    }

    /**
     * Get datemutualityaffiliate
     *
     * @return string
     */
    public function getDatemutualityaffiliate()
    {
        return $this->datemutualityaffiliate;
    }


    /**
     * Set datemutualityexemption
     *
     * @param Datetime
     * @return Staff
     */
    public function setDatemutualityexemption($datemutualityexemption)
    {
        $this->datemutualityexemption = $datemutualityexemption;

        return $this;
    }

    /**
     * Get datemutualityexemption
     *
     * @return string
     */
    public function getDatemutualityexemption()
    {
        return $this->datemutualityexemption;
    }


    /**
     * Set filemutualityaffiliate
     *
     * @param string
     * @return Staff
     */
    public function setFilemutualityaffiliate($filemutualityaffiliate)
    {
        $this->filemutualityaffiliate = $filemutualityaffiliate;

        return $this;
    }

    /**
     * Get filemutualityaffiliate
     *
     * @return string
     */
    public function getFilemutualityaffiliate()
    {
        return $this->datemutualityexemption;
    }

    /**
     * Set filemutualityexemption
     *
     * @param string
     * @return Staff
     */
    public function setFilemutualityexemption($filemutualityexemption)
    {
        $this->filemutualityexemption = $filemutualityexemption;

        return $this;
    }

    /**
     * Get filemutualityexemption
     *
     * @return string
     */
    public function getFilemutualityexemption()
    {
        return $this->filemutualityexemption;
    }

    /**
     * Set filestageconvention
     *
     * @param string
     * @return Staff
     */
    public function setFilestageconvention($filestageconvention)
    {
        $this->filestageconvention = $filestageconvention;

        return $this;
    }

    /**
     * Get filestageconvention
     *
     * @return string
     */
    public function getFilestageconvention()
    {
        return $this->filestageconvention;
    }

    /**
     *  @PreSerialize
     *
     *  @return le nombre de jours de congé restant de l'année courante (31 mai au 1er Juin)
     *
     */
    public function getRemaingdaysofvacation()
    {
        if(date('m') <= 5)
        {
            $year1  =   date('Y') - 1;
            $year2  =   date('Y');
        }
        else
        {
            $year1  =   date('Y');
            $year2  =   date('Y') + 1;
        }

        $totalday =   0;

        foreach ($this->vacation as $key => $value)
        {
            $datestart  =   $value->getDatestart()->format('Y-m-d');
            $dateend    =   $value->getDateend()->format('Y-m-d');

            if(strtotime($datestart) >= strtotime($year1."-05-31") && strtotime($dateend) <= strtotime($year2."-06-01") )
            {
                if($value->getValidated() == 1 && $value->getEnabled() == 1 && $value->getArchived() == 0 && $value->getVacationtype()->getIscounted() == 1 && $value->getDateend() >= "2016-06-01" )
                {
                    //  Demi journée ou pas
                    if( $value->getMorning() == 1 && $value->getAfternoon() == 1  )
                    {
                        $totalday += $value->getNumberofopeningday();
                    }
                    else
                    {
                        $totalday += ($value->getNumberofopeningday() / 2);

                    }
                }
            }
        }

        return $this->remaingdaysofvacation = $this->getContractvacation() - $totalday;
    }

    /**
     *  @PreSerialize
     *
     *  @return le nombre de jours de congé restant de l'année courante (31 mai au 1er Juin)
     *
     */
    public function getVacationcurrentmonth()
    {

        //  Todo rendre la liste dynamique
        $result     =   array();

        $result['Congé sans solde']             =   0;
        $result['Congé exceptionel']            =   0;
        $result['Congé payé']                   =   0;
        $result['Congé paternité/maternité']    =   0;
        $result['Congé maladie']                =   0;

        if(date('m') <= 5)
        {
            $year1  =   date('Y') - 1;
            $year2  =   date('Y');
        }
        else
        {
            $year1  =   date('Y');
            $year2  =   date('Y') + 1;
        }

        $totalday =   0;

        foreach ($this->vacation as $key => $value)
        {
            $datestart  =   $value->getDatestart()->format('Y-m-d');
            $dateend    =   $value->getDateend()->format('Y-m-d');

            if(strtotime($datestart) >= strtotime(date('Y')."-".date('m')."-01") && strtotime($dateend) <= strtotime(date('Y')."-".date('m')."-31") )
            {
                if($value->getValidated() == 1 && $value->getEnabled() == 1 && $value->getArchived() == 0 && $value->getVacationtype()->getIscounted() == 1 && $value->getDateend() >= "2016-06-01" )
                {
                    //  Demi journée ou pas
                    if( $value->getMorning() == 1 && $value->getAfternoon() == 1  )
                    {
                        $result[$value->getVacationtype()->getValue()] +=  $value->getNumberofopeningday();

                    }
                    else
                    {
                        $result[$value->getVacationtype()->getValue()] += ($value->getNumberofopeningday() / 2);

                    }
                }
            }
        }

        return $this->vacationcurrentmonth = $result;
    }


    /**
    *  @PreSerialize
    *
    *  @return le pourcentage de champ complété
    *
    */
    public function getUnsetField()
    {
        $this->unsetfield   =   0;

        if(is_null($this->gender))                  $this->unsetfield++;
        if(is_null($this->firstname))               $this->unsetfield++;
        if(is_null($this->lastname))                $this->unsetfield++;
        if(is_null($this->initials))                $this->unsetfield++;
        if(is_null($this->dateofbirth))             $this->unsetfield++;
        if(is_null($this->color))                   $this->unsetfield++;

        if(is_null($this->internalphone))           $this->unsetfield++;
        if(is_null($this->professionalphone))       $this->unsetfield++;
        if(is_null($this->professionalmobile))      $this->unsetfield++;
        if(is_null($this->personnalphone))          $this->unsetfield++;
        if(is_null($this->personnalmobile))         $this->unsetfield++;

        if(is_null($this->professionalmail))        $this->unsetfield++;

        if(is_null($this->number))                  $this->unsetfield++;
        if(is_null($this->address1))                $this->unsetfield++;
        if(is_null($this->address2))                $this->unsetfield++;
        if(is_null($this->postcode))                $this->unsetfield++;
        if(is_null($this->city))                    $this->unsetfield++;
        if(is_null($this->nation))                  $this->unsetfield++;

        if(is_null($this->contracttype))            $this->unsetfield++;
        if(is_null($this->serviceoffice))           $this->unsetfield++;
        if(is_null($this->responsible))             $this->unsetfield++;
        if(is_null($this->dateofstart))             $this->unsetfield++;
        //if(is_null($this->dateofend))               $this->unsetfield++;
        if(is_null($this->company))                 $this->unsetfield++;
        if(is_null($this->contracthour))            $this->unsetfield++;
        if(is_null($this->contractvacation))        $this->unsetfield++;

        if(is_null($this->mutuality))               $this->unsetfield++;

        if(is_null($this->socialsecuritynumber))    $this->unsetfield++;
        if(is_null($this->registrationnumber))      $this->unsetfield++;
        if(is_null($this->maritalstatus))           $this->unsetfield++;
        if(is_null($this->idcart))                  $this->unsetfield++;
        if(is_null($this->rib))                     $this->unsetfield++;

        //  Total : 33
        $this->unsetfield   =   (100 - (round(($this->unsetfield / 33) * 100)));

        return $this->unsetfield;
    }

}