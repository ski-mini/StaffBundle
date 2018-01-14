<?php

namespace Charlotte\StaffBundle\Controller;

use Tool\ToolBundle\Services\RestFunction;
use Tool\ToolBundle\Helpers\Date;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Section;

use Paradigma\Bundle\ImageBundle\Libs\ImageSize;
use Paradigma\Bundle\ImageBundle\Libs\ImageResizer;

use Charlotte\StaffBundle\Entity\Staff as User;
use Charlotte\StaffBundle\Form\StaffType;

/**
 * @Prefix("staff")
 */
class StaffRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id de l'utilisateur")
     * @QueryParam(name="username", description="Pseudo de l'utilisateur")
     * @QueryParam(name="professionalmail", description="Email de l'utilisateur")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Staff",
     *  description="Retourne un utilisateur"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $user   =   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Staff')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($user))
        {
            return new View("Aucun utilisateur trouvé.", 204);
        }

        return new View($user, 200);
    }

    /**
     *
     * @QueryParam(name="serviceoffice", description="Actif")
     * @QueryParam(name="gender", strict=FALSE, description="Civilité")
     * @QueryParam(name="lastname", strict=FALSE, description="Nom de famille")
     * @QueryParam(name="initials", strict=FALSE, description="Initiales")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Staff",
     *  description="Retourne tous les utilisateurs"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $users    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Staff')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()), array('lastname' => 'ASC'));

        if(!is_array($users) || empty($users))
        {
            return new View("Aucun utilisateur trouvé.", 204);
        }

        return new View($users, 200);
    }


    /**
     *
     * @ApiDoc(
     *  section = "Staff",
     *  description="Retourne tous les utilisateurs avec un profil non complété"
     * )
     */
    public function getAllUncompleteAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $users    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Staff')
                           ->findBy(array('enabled' => 1, 'archived' => 0, 'initials' => null ));

        if(!is_array($users) || empty($users))
        {
            return new View("Aucun utilisateur trouvé.", 204);
        }

        return new View($users, 200);
    }


    /**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprimé")
     *
     * @ApiDoc(
     *  section = "Staff",
     *  description="Retourne toutes données utiles à l'édition d'un staff / Permet de gagner du temps  "
     * )
     */
    public function getFullInfoAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $companies      =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteMainBundle:Company')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()), array('value' => 'ASC'));

        $return['companies']        =   $companies;

        $contracttypes  =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Contracttype')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        $return['contracttypes']    =   $contracttypes;

        $nations        =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteMainBundle:Nation')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()), array('sort' => 'ASC' ,'value' => 'ASC'));

        $return['nations']          =   $nations;

        $serviceoffices =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Serviceoffice')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        $return['serviceoffices']    =   $serviceoffices;

        $maritalStatus  =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Maritalstatus')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        $return['maritalstatus']    =   $maritalStatus;

        $staffs         =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Staff')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()), array('lastname' => 'ASC'));

        $return['staffs']           =   $staffs;


        $staffcolors    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Staffcolor')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()), array('hexa' => 'ASC'));

        $return['staffcolors']      =   $staffcolors;

        $stafffunctions =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Stafffunction')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        $return['stafffunctions']      =   $stafffunctions;

        $waytypes       =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteDealBundle:Waytype')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        $return['waytypes']      =   $waytypes;

        return new View($return, 200);
    }

    /**
     * Mise à jour/ Création d'un staff
     *
     *
     * @ApiDoc(
     *   section = "Staff",
     *   description = "Mise à jour d'un staff",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     * )
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="id", strict=FALSE, description="Id de l'utilisateur")
     * @RequestParam(name="gender", strict=FALSE, description="Civilité")
     * @RequestParam(name="firstname", strict=FALSE, description="Prénom")
     * @RequestParam(name="marriedname", strict=FALSE, description="Nom marital")
     * @RequestParam(name="lastname", strict=FALSE, description="Nom")
     * @RequestParam(name="initials", strict=FALSE, description="Initiale")
     * @RequestParam(name="login", strict=FALSE, description="Login")
     * @RequestParam(name="dateofbirth", strict=FALSE, description="Date d'anniversaire")
     * @RequestParam(name="color", strict=FALSE, description="Couleur")
     *
     * @RequestParam(name="internalphone", strict=FALSE, description="Téléphone Interne")
     * @RequestParam(name="professionalphone", strict=FALSE, description="Téléphone Pro Fixe")
     * @RequestParam(name="professionalmobile", strict=FALSE, description="Téléphone Pro Mobile")
     * @RequestParam(name="personnalphone", strict=FALSE, description="Téléphone Perso Fixe")
     * @RequestParam(name="personnalmobile", strict=FALSE, description="Téléphone Perso Mobile")
     *
     * @RequestParam(name="professionalmail", strict=FALSE, description="Mail Pro")
     * @RequestParam(name="personnalmail", strict=FALSE, description="Mail Perso")
     *
     * @RequestParam(name="number", strict=FALSE, description="Numéro")
     * @RequestParam(name="extension", strict=FALSE, description="Extension")
     * @RequestParam(name="waytype_id", strict=FALSE, description="Type de route")
     * @RequestParam(name="address1", strict=FALSE, description="Addresse 1")
     * @RequestParam(name="address2", strict=FALSE, description="Addresse 2")
     * @RequestParam(name="postcode", strict=FALSE, description="Code Postal")
     * @RequestParam(name="city", strict=FALSE, description="Ville")
     * @RequestParam(name="nation_id", strict=FALSE, description="Pays")
     *
     * @RequestParam(name="contracttype_id", strict=FALSE, description="Type de contrat")
     * @RequestParam(name="serviceoffice_id", strict=FALSE, description="Service")
     * @RequestParam(name="stafffunction_id", strict=FALSE, description="Fonction utilisateur")
     * @RequestParam(name="dateofstart", strict=FALSE, description="Date d'embauche")
     * @RequestParam(name="dateofend", strict=FALSE, description="Date de départ")
     * @RequestParam(name="company_id", strict=FALSE, description="Société")
     * @RequestParam(name="contracthour", strict=FALSE, description="Nombre d\'heure hebdomadaire")
     * @RequestParam(name="contractvacation", strict=FALSE, description="Nombre de jour de congé annuel")
     *
     * @RequestParam(name="mutuality", strict=FALSE, description="Mutuelle")
     * @RequestParam(name="datemutualityaffiliate", strict=FALSE, description="Date d\'affiliation à la mutuelle")
     * @RequestParam(name="datemutualityexemption", strict=FALSE, description="Date de dispense à la mutuelle")
     * @RequestParam(name="filemutualityaffiliate", strict=FALSE, description="Fichier d\'affiliation à la mutuelle")
     * @RequestParam(name="filemutualityexemption", strict=FALSE, description="Fichier de dispense à la mutuelle")
     *
     * @RequestParam(name="socialsecuritynumber", strict=FALSE, description="Numéro de sécurité sociale")
     * @RequestParam(name="registrationnumber", strict=FALSE, description="Numéro de matricule")
     * @RequestParam(name="maritalstatus_id", strict=FALSE, description="Etat civil")
     * @RequestParam(name="responsible_id", strict=FALSE, description="Responsable hiérarchique")
     *
     * @RequestParam(name="phone", strict=FALSE, description="Téléphone dynamique")
     * @RequestParam(name="email", strict=FALSE, description="Mail dynamique")
     *
     * @RequestParam(name="enabled", strict=FALSE, description="Actif")
     * @RequestParam(name="archived", strict=FALSE, description="Archivé")
     *
     * @Route("/edit")
     */
    public function postEditAction(ParamFetcher $paramFetcher)
    {
        $em         =   $this->getDoctrine()->getManager();

        //  Update
        if($paramFetcher->get('id'))
        {
            $staff  =   $em->getRepository('CharlotteStaffBundle:Staff')->findOneBy(array('id' => $paramFetcher->get('id')));
        }
        else    //  Insert
        {
            $staff  =   new \Charlotte\StaffBundle\Entity\Staff();
        }

        if(!is_object($staff))
        {
            throw $this->createNotFoundException();
        }

        //  Informations Principales
        if(!is_null($paramFetcher->get('gender')))                  {   $staff->setGender($paramFetcher->get('gender'));                                                                }
        if(!is_null($paramFetcher->get('firstname')))               {   $staff->setFirstname($paramFetcher->get('firstname'));                                                          }
        if(!is_null($paramFetcher->get('marriedname')))             {   $staff->setMarriedname($paramFetcher->get('marriedname'));                                                      }
        if(!is_null($paramFetcher->get('lastname')))                {   $staff->setLastname($paramFetcher->get('lastname'));                                                            }
        if(!is_null($paramFetcher->get('initials')))                {   $staff->setInitials($paramFetcher->get('initials'));                                                            }
        if(!is_null($paramFetcher->get('dateofbirth')))             {   $staff->setDateofbirth(Date::encodeDateToDatetime($paramFetcher->get('dateofbirth')));                          }
        if(!is_null($paramFetcher->get('color')))                   {   $staff->setColor($paramFetcher->get('color'));                                                                  }

        //  Informations de contact - Téléphone
        if(!is_null($paramFetcher->get('internalphone')))           {   $staff->setInternalphone($paramFetcher->get('internalphone'));                                                  }
        if(!is_null($paramFetcher->get('professionalphone')))       {   $staff->setProfessionalphone($paramFetcher->get('professionalphone'));                                          }
        if(!is_null($paramFetcher->get('professionalmobile')))      {   $staff->setProfessionalmobile($paramFetcher->get('professionalmobile'));                                        }
        if(!is_null($paramFetcher->get('personnalphone')))          {   $staff->setPersonnalphone($paramFetcher->get('personnalphone'));                                                }
        if(!is_null($paramFetcher->get('personnalmobile')))         {   $staff->setPersonnalmobile($paramFetcher->get('personnalmobile'));                                              }

        //  Informations de contact - Email
        if(!is_null($paramFetcher->get('professionalmail')))        {   $staff->setProfessionalmail($paramFetcher->get('professionalmail'));                                            }
        if(!is_null($paramFetcher->get('personnalmail')))           {   $staff->setPersonnalmail($paramFetcher->get('personnalmail'));                                                  }

        //  Adresse privée
        if(!is_null($paramFetcher->get('number')))                  {   $staff->setNumber($paramFetcher->get('number'));                                                                }
        if(!is_null($paramFetcher->get('extension')))               {   $staff->setExtension($paramFetcher->get('extension'));                                                          }
        if(!is_null($paramFetcher->get('address1')))                {   $staff->setAddress1($paramFetcher->get('address1'));                                                            }
        if(!is_null($paramFetcher->get('address2')))                {   $staff->setAddress2($paramFetcher->get('address2'));                                                            }
        if(!is_null($paramFetcher->get('postcode')))                {   $staff->setPostcode($paramFetcher->get('postcode'));                                                            }
        if(!is_null($paramFetcher->get('city')))                    {   $staff->setCity($paramFetcher->get('city'));                                                                    }
        
        if($paramFetcher->get('waytype_id'))
        {
            $waytype      =   $em->getRepository('CharlotteDealBundle:Waytype')->findOneBy(array('id' => $paramFetcher->get('waytype_id')));
            $staff->setWaytype($waytype);
        }

        if($paramFetcher->get('nation_id'))
        {
            $nation      =   $em->getRepository('CharlotteMainBundle:Nation')->findOneBy(array('id' => $paramFetcher->get('nation_id')));
            $staff->setNation($nation);
        }

        //  Informations Contrat
        if($paramFetcher->get('contracttype_id'))
        {
            $contracttype       =   $em->getRepository('CharlotteStaffBundle:Contracttype')->findOneBy(array('id' => $paramFetcher->get('contracttype_id')));
            $staff->setContracttype($contracttype);
        }

        if($paramFetcher->get('serviceoffice_id'))
        {
            $serviceoffice      =   $em->getRepository('CharlotteStaffBundle:Serviceoffice')->findOneBy(array('id' => $paramFetcher->get('serviceoffice_id')));
            $staff->setServiceoffice($serviceoffice);
        }

        if(!is_null($paramFetcher->get('dateofstart')))             {   $staff->setDateofstart(Date::encodeDateToDatetime($paramFetcher->get('dateofstart')));                          }
        if(!is_null($paramFetcher->get('dateofend')))               {   $staff->setDateofend(Date::encodeDateToDatetime($paramFetcher->get('dateofend')));                              }

        if($paramFetcher->get('company_id'))
        {
            $company      =   $em->getRepository('CharlotteMainBundle:Company')->findOneBy(array('id' => $paramFetcher->get('company_id')));
            $staff->setCompany($company);
        }

        if($paramFetcher->get('contracthour'))                      {   $staff->setContracthour($paramFetcher->get('contracthour'));                                                    }
        if($paramFetcher->get('contractvacation'))                  {   $staff->setContractvacation($paramFetcher->get('contractvacation'));                                            }

        //  Informations mutuelles
        if(!is_null($paramFetcher->get('mutuality')))               {   $staff->setMutuality($paramFetcher->get('mutuality'));                                                          }
        if(!is_null($paramFetcher->get('datemutualityaffiliate')))  {   $staff->setDatemutualityaffiliate(Date::encodeDateToDatetime($paramFetcher->get('datemutualityaffiliate')));    }
        if(!is_null($paramFetcher->get('datemutualityexemption')))  {   $staff->setDatemutualityexemption(Date::encodeDateToDatetime($paramFetcher->get('datemutualityexemption')));    }

        //  Informations Privées
        if(!is_null($paramFetcher->get('socialsecuritynumber')))    {   $staff->setSocialsecuritynumber($paramFetcher->get('socialsecuritynumber'));                                    }
        if(!is_null($paramFetcher->get('registrationnumber')))      {   $staff->setRegistrationnumber($paramFetcher->get('registrationnumber'));                                        }

        if($paramFetcher->get('maritalstatus_id'))
        {
            $maritalstatus      =   $em->getRepository('CharlotteStaffBundle:Maritalstatus')->findOneBy(array('id' => $paramFetcher->get('maritalstatus_id')));
            $staff->setMaritalstatus($maritalstatus);
        }

        if($paramFetcher->get('stafffunction_id'))
        {
            $staff_function     =   $em->getRepository('CharlotteStaffBundle:Stafffunction')->findOneBy(array('id' => $paramFetcher->get('stafffunction_id')));
            $staff->setStafffunction($staff_function);
        }

        if($paramFetcher->get('responsible_id'))
        {
            $responsible      =   $em->getRepository('CharlotteStaffBundle:Staff')->findOneBy(array('id' => $paramFetcher->get('responsible_id')));
            $staff->setResponsible($responsible);
        }
        elseif(is_null($paramFetcher->get('responsible_id')))
        {
            $staff->setResponsible(null);
        }

        //  Dynamic Fields - Phone
        if($paramFetcher->get('phone'))
        {
            $phone  =   json_decode($paramFetcher->get('phone'));

            foreach($phone as $key => $value)
            {
                if($value->id)  //  Update
                {
                    $staffphone  =   $em->getRepository('CharlotteMainBundle:Phone')->findOneBy(array('id' => $value->id));
                }
                else            //  Insert
                {
                    $staffphone  =   new \Charlotte\MainBundle\Entity\Phone();
                }

                if(isset($value->type))     {   $staffphone->setType($value->type);         }
                if(isset($value->value))    {   $staffphone->setValue($value->value);       }
                if(isset($value->comment))  {   $staffphone->setComment($value->comment);   }

                $em->persist($staffphone);
                $em->flush();

                if(!$value->id)  //  insert uniquement
                {
                    $staff->addPhone($staffphone);
                }
            }
        }

        //  Dynamic Fields - Mail
        if($paramFetcher->get('email'))
        {
            $email  =   json_decode($paramFetcher->get('email'));

            foreach($email as $key => $value)
            {
                if($value->id)  //  Update
                {
                    $staffemail  =   $em->getRepository('CharlotteMainBundle:Email')->findOneBy(array('id' => $value->id));
                }
                else            //  Insert
                {
                    $staffemail  =   new \Charlotte\MainBundle\Entity\Email();
                }

                if(isset($value->type))     {   $staffemail->setType($value->type);         }
                if(isset($value->type))     {   $staffemail->setValue($value->value);       }
                if(isset($value->type))     {   $staffemail->setComment($value->comment);   }

                $em->persist($staffemail);
                $em->flush();

                if(!$value->id)  //  insert uniquement
                {
                    $staff->addEmail($staffemail);
                }
            }
        }

        //  Statut
        if(!is_null($paramFetcher->get('enabled'))) {   $staff->setEnabled($paramFetcher->get('enabled'));                                      }
        if(!is_null($paramFetcher->get('archived'))){   $staff->setArchived($paramFetcher->get('archived'));                                    }

        //  Si la date de fin de contrat et renseigné -> on archive le compte
        if(!is_null($paramFetcher->get('dateofend')))
        {   
            if(strlen($paramFetcher->get('dateofend')) != 0)
            {
                $staff->setEnabled(0);                                      
                $staff->setArchived(1);                                    
            }
        }

        //  Files -- Picture
        if(isset($_FILES['staff_picture']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize($staff->getId().'-'.$staff->getLastname().'-'.$staff->getFirstname()).'.'.pathinfo($_FILES['staff_picture']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['staff_picture']['tmp_name'], '../web/uploads/staff/'.$title))
            {
                $staff->setPicture($title);

                //  Resize image for thumb-30-30
                $resize = $this->get('image_resizer')->resize('../web/uploads/staff/'.$title, '../web/uploads/staff/thumbnail-30-30-'.$title, new ImageSize(30, 30), ImageResizer::RESIZE_TYPE_CROP);
            }
        }
        //  Files -- idcart
        if(isset($_FILES['staff_idcart']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize('ID-'.$staff->getId().'-'.$staff->getLastname().'-'.$staff->getFirstname()).'.'.pathinfo($_FILES['staff_idcart']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['staff_idcart']['tmp_name'], '../web/uploads/staff/'.$title))
            {
                $staff->setIdcart($title);
            }
        }
        //  Files -- rib
        if(isset($_FILES['staff_rib']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize('RIB-'.$staff->getId().'-'.$staff->getLastname().'-'.$staff->getFirstname()).'.'.pathinfo($_FILES['staff_rib']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['staff_rib']['tmp_name'], '../web/uploads/staff/'.$title))
            {
                $staff->setRib($title);
            }
        }
        //  Files -- imageright / droit à l'image
        if(isset($_FILES['staff_imageright']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize('IMAGERIGHT-'.$staff->getId().'-'.$staff->getLastname().'-'.$staff->getFirstname()).'.'.pathinfo($_FILES['staff_imageright']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['staff_imageright']['tmp_name'], '../web/uploads/staff/'.$title))
            {
                $staff->setImageright($title);
            }
        }
        //  Files -- Fichier d'affiliation
        if(isset($_FILES['staff_filemutualityaffiliate']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize('FILEMUTUALITYAFFILIATE-'.$staff->getId().'-'.$staff->getLastname().'-'.$staff->getFirstname()).'.'.pathinfo($_FILES['staff_filemutualityaffiliate']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['staff_filemutualityaffiliate']['tmp_name'], '../web/uploads/staff/'.$title))
            {
                $staff->setFilemutualityaffiliate($title);
            }
        }
        //  Files -- Fichier de dispense
        if(isset($_FILES['staff_filemutualityexemption']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize('FILEMUTUALITYEXEMPTION-'.$staff->getId().'-'.$staff->getLastname().'-'.$staff->getFirstname()).'.'.pathinfo($_FILES['staff_filemutualityexemption']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['staff_filemutualityexemption']['tmp_name'], '../web/uploads/staff/'.$title))
            {
                $staff->setFilemutualityexemption($title);
            }
        }
        //  Files -- Fichier de convention de stage
        if(isset($_FILES['staff_filestageconvention']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize('FILESTAGECONVENTION-'.$staff->getId().'-'.$staff->getLastname().'-'.$staff->getFirstname()).'.'.pathinfo($_FILES['staff_filestageconvention']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['staff_filestageconvention']['tmp_name'], '../web/uploads/staff/'.$title))
            {
                $staff->setFilestageconvention($title);
            }
        }

        $em->persist($staff);
        $em->flush();

        //  Update
        if($paramFetcher->get('id'))
        {
            $json   =   array('editResult' => true, 'isInsert' => false, 'staff' => $staff);
        }
        else    //  Insert
        {
            $json   =   array('editResult' => true, 'isInsert' => true, 'staff' => $staff);
        }

        return $json;
    }

    /**
     *
     * @RequestParam(name="username", nullable=false, strict=true, description="Nom utilisateur utilisé pour la connexion")
     * @RequestParam(name="password", nullable=false, strict=true, description="Mot de passe")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Staff",
     *  description="Connexion d'un utilisateur",
     *  statusCodes={
     *         200="Retourné quand l'utilisateur se connecte",
     *         401={
     *           "Mauvais mot de passe",
     *           "Mauvais nom d'utilisateur"
     *         }
     *     }
     * )
     * @Route("/login")
     *
     */
    public function postLoginAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($paramFetcher->get('username'));

        $factory = $this->get('security.encoder_factory');

        if (!$user instanceof User)
        {
            $view->setStatusCode(401)->setData("Nom d'utilisateur incorrect.");

            return $view;
        }
        else if (!$factory->getEncoder($user)->isPasswordValid($user->getPassword(), $paramFetcher->get('password'), $user->getSalt())) {
            $view->setStatusCode(401)->setData("Mot de passe incorrect.");

            return $view;
        }

        //Ajoute les rôles
        $roles = $this->getDoctrine()->getManager()->getRepository('CharlotteStaffBundle:Staff')->findAllRoles($user);

        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($paramFetcher->get('password'), $user->getSalt());
        $header = $this->generateToken($paramFetcher->get('username'), $password);
        $data = array('X-WSSE' => $header, 'staff' => $user, 'roles' => $roles);
        $view->setHeader("Authorization", 'WSSE profile="UsernameToken"');
        $view->setHeader("X-WSSE", $header);
        $view->setStatusCode(200)->setData($data);

        return $view;
    }

    /**
     * Generate token for username given
     *
     * @param  string $username username
     * @param  string $password password with salt included
     * @return string
     */
    private function generateToken($username, $password)
    {
        $created = date('c');
        $nonce = substr(md5(uniqid('nonce_', true)), 0, 16);
        $nonceSixtyFour = base64_encode($nonce);
        $passwordDigest = base64_encode(sha1($nonce . $created . $password, true));

        $token = sprintf(
            'UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
            $username,
            $passwordDigest,
            $nonceSixtyFour,
            $created
        );

        return $token;
    }
}