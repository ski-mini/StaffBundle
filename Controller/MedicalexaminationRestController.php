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

/**
 * @Prefix("medicalexamination")
 */
class MedicalexaminationRestController extends FOSRestController
{

    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id de la visite médicale")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Medicalexamination",
     *  description="Retourne un visite médicale"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $medicalexamination   =   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Medicalexamination')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($medicalexamination))
        {
            return new View("Aucune visite médicale trouvée.", 204);
        }

        return new View($medicalexamination, 200);
    }

    /**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Medicalexamination",
     *  description="Retourne toutes les visites médicales"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {

        $medicalexaminations    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Medicalexamination')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($medicalexaminations) || empty($medicalexaminations)){
            return new View("Aucune visite médicale trouvée.", 204);
        }

        return new View($medicalexaminations, 200);
    }


     /**
     * Mise à jour/ Création d'une visite médicale
     *
     *
     * @ApiDoc(
     *   section = "Medicalexamination",
     *   description = "Mise à jour d'une visite médicale",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     * )
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     * @RequestParam(name="id", strict=FALSE, description="Id de la visite médicale")
     * @RequestParam(name="date", strict=FALSE, description="Date de la visite médicale")
     * @RequestParam(name="result", strict=FALSE, description="Résultat de la visite médicale")
     * @RequestParam(name="enabled", strict=FALSE, description="Actif")
     * @RequestParam(name="archived", strict=FALSE, description="Archivé")
     * 
     * @RequestParam(name="staff_id", strict=FALSE, description="Identifiant staff")
     * 
     * @Route("/edit")
     */
    public function postEditAction(ParamFetcher $paramFetcher)
    {
        $em         =   $this->getDoctrine()->getManager();

        //  Update
        if($paramFetcher->get('id'))
        {
            $medicalexamination     =   $em->getRepository('CharlotteStaffBundle:Medicalexamination')->findOneBy(array('id' => $paramFetcher->get('id')));
        }
        else    //  Insert
        {
            $medicalexamination     =   new \Charlotte\StaffBundle\Entity\Medicalexamination();
        }

        if(!is_object($medicalexamination))
        {
            return new View("Aucune visite médicale trouvée.", 204);
        }

        if(!is_null($paramFetcher->get('result')))      {   $medicalexamination->setResult($paramFetcher->get('result'));                           }
        if(!is_null($paramFetcher->get('date')))        {   $medicalexamination->setDate(Date::encodeDateToDatetime($paramFetcher->get('date')));   }
        if(!is_null($paramFetcher->get('enabled')))     {   $medicalexamination->setEnabled($paramFetcher->get('enabled'));                         }
        if(!is_null($paramFetcher->get('archived')))    {   $medicalexamination->setArchived($paramFetcher->get('archived'));                        }

        if(isset($_FILES['file']))
        {
            $title  =   \Tool\ToolBundle\Helpers\String::normalize('medicalexamination-'.$paramFetcher->get('staff_id').'-'.rand(0, 999999999).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if(move_uploaded_file($_FILES['file']['tmp_name'], '../web/uploads/staff/medicalexamination/'.$title))
            {
                $medicalexamination->setFile($title);
            }
        }

        if($paramFetcher->get('id'))    //  Update
        {
            $json   =   array('editResult' => true, 'isInsert' => false, 'medicalexamination' => $medicalexamination);
        }
        else                            //  Insert
        {
            $staff  =   $em->getRepository('CharlotteStaffBundle:Staff')->findOneBy(array('id' => $paramFetcher->get('staff_id')));

            $staff->addMedicalexamination($medicalexamination);
            $em->persist($staff);

            $json   =   array('editResult' => true, 'isInsert' => true, 'medicalexamination' => $medicalexamination);
        }

        $em->persist($medicalexamination);
        $em->flush();

        return $json;
   }                 

}
