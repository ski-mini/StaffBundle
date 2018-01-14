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
 * @Prefix("vacation")
 */
class VacationRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id d\'une vacances")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Vacation",
     *  description="Retourne une vacance"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $vacation 	=   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Vacation')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($vacation))
        {
            return new View("Aucune vacances trouvée.", 204);
        }

        return new View($vacation, 200);
    }

 	/**
     *
     * @QueryParam(name="validated", requirements="(0|1)", description="Validé")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Vacation",
     *  description="Retourne toutes les vacances"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $vacations    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Vacation')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($vacations) || empty($vacations))
        {
            return new View("Aucune vacance trouvée.", 204);
        }

        return new View($vacations, 200);
    }


    /**
     * @QueryParam(name="datestart", nullable=false, strict=false, description="Date de début de congé")
     * @QueryParam(name="dateend", nullable=false, strict=false, description="Date de fin de congé")
     * @QueryParam(name="validated", requirements="(0|1)", description="Validé")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Vacation",
     *  description="Retourne toutes les vacances par utilisateur"
     * )
     */
    public function getAllBystaffAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        /*
        $vacations    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Vacation')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));
        */
  

        $datestart  =   $paramFetcher->get('datestart');
        $dateend    =   $paramFetcher->get('dateend');

        $em         =   $this->getDoctrine()->getManager();
        $query      =   $em->createQuery("SELECT s FROM CharlotteStaffBundle:Staff s WHERE s.enabled = 1 AND s.archived = 0  ");
        $vacations  =   $query->getResult();

        $html       =   '<html>';
        $html       .=      '<head>';
        $html       .=      '</head>';
        $html       .=      '<body>';

        $html       .=          '<strong>Congé pris pour la période '.date('m/Y').'</strong>';

        foreach ($vacations as $key => $value) 
        {
            $html   .=      '<table>';
            $html   .=          '<tr>';
            $html   .=              '<td>';
            $html   .=                  '<strong>'.$value->getFirstname().' '.$value->getLastname().'</strong>';
            $html   .=                  '<table>';
            foreach ($value->getVacationcurrentmonth() as $key2 => $value2) 
            {
                $html   .=                  '<tr>';
                $html   .=                      '<td>';
                $html   .=                          $key2;
                $html   .=                      '</td>';                
                $html   .=                      '<td>';
                $html   .=                          $value2;
                $html   .=                      '</td>';
                $html   .=                  '</tr>';
            }    
            $html   .=                  '</table>';
            $html   .=              '</td>';
            $html   .=          '</tr>';
            $html   .=      '</table>';
                            
        }

        $html       .=      '</body>';
        $html       .=  '</html>';


        $html2pdf   =   $this->get('html2pdf_factory')->create();
        $html2pdf->WriteHTML($html);

        $filename   =   'export-'.date('Y-m-d-H-i-s').'.pdf';

        $result     =   $html2pdf->Output('uploads/export/'.$filename, 'F');

        if(!is_array($vacations) || empty($vacations))
        {
            return new View("Aucune vacance trouvée.", 204);
        }
        else
        {
            $json =   array('export' => true, 'filename' => $filename);
        }

   

        return new View($json, 200);
    }


    /**
     * @RequestParam(name="id", strict=false, description="Id du congé")
     * @RequestParam(name="staff_id", nullable=false, strict=false, description="Utilisateur")
     * @RequestParam(name="vacationtype_id", nullable=false, strict=false, description="Type de congé")
     * @RequestParam(name="datestart", nullable=false, strict=false, description="Date de début de congé")
     * @RequestParam(name="dateend", strict=false, description="Date de fin de congé")
     * @RequestParam(name="numberofopeningday", strict=false, description="Nombre de jour de congé réellement pris")
     * @RequestParam(name="comment", strict=false, description="Commentaire")
     * @RequestParam(name="morning", strict=false, description="Matinée")
     * @RequestParam(name="afternoon", strict=false, description="Après-midi")
     * @RequestParam(name="validated", strict=false, description="Validé")
     * @RequestParam(name="datevalidated", strict=false, description="Date de la validation")
     * @RequestParam(name="recovered", strict=false, description="Récupéré")
     * @RequestParam(name="daterecovered", strict=false, description="Date de la Récup")
     * @RequestParam(name="enabled", strict=false, description="Actif")
     * @RequestParam(name="archived", strict=false, description="Archivé")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Vacation",
     *  description="Création / Modification d\'un congé",
     *  statusCodes={
     *         200="Retourné quand il y a une réponse"
     *     }
     * )
     * @Route("/edit")
     */
    public function postEditAction(ParamFetcher $paramFetcher)
    {
        $view           =   View::create();
        $em             =   $this->getDoctrine()->getManager();
    
        //  Update
        if($paramFetcher->get('id'))
        {
            $vacation       =   $em->getRepository('CharlotteStaffBundle:Vacation')->findOneBy(array('id' => $paramFetcher->get('id')));
            $json           =   array('editResult' => true, 'isInsert' => false  );
        }
        else    //  Insert
        {
            $vacation       =   new \Charlotte\StaffBundle\Entity\Vacation();
            $json           =   array('editResult' => true, 'isInsert' => true  );
        }

        if($paramFetcher->get('staff_id'))
        {
            $staff          =   $em->getRepository('CharlotteStaffBundle:Staff')->findOneBy(array('id' => $paramFetcher->get('staff_id')));
            $vacation->setStaff($staff);
        }

        if($paramFetcher->get('vacationtype_id'))
        {
            $vacationtype   =   $em->getRepository('CharlotteStaffBundle:Vacationtype')->findOneBy(array('id' => $paramFetcher->get('vacationtype_id')));
            $vacation->setVacationtype($vacationtype);
        }

        if($paramFetcher->get('datestart'))             {   $vacation->setDatestart(Date::encodeDateToDatetime($paramFetcher->get('datestart')));           }
        if($paramFetcher->get('dateend'))               {   $vacation->setDateend(Date::encodeDateToDatetime($paramFetcher->get('dateend')));               }
        if($paramFetcher->get('numberofopeningday'))    {   $vacation->setNumberofopeningday($paramFetcher->get('numberofopeningday'));                     }

        if($paramFetcher->get('comment'))               {   $vacation->setComment($paramFetcher->get('comment'));                                           }
        if(!is_null($paramFetcher->get('morning')))     {   $vacation->setMorning($paramFetcher->get('morning'));                                           }
        if(!is_null($paramFetcher->get('afternoon')))   {   $vacation->setAfternoon($paramFetcher->get('afternoon'));                                       }
        if($paramFetcher->get('datevalidated'))         {   $vacation->setDatevalidated($paramFetcher->get('datevalidated'));                               }

        if(!is_null($paramFetcher->get('recovered')))   {   $vacation->setRecovered($paramFetcher->get('recovered'));                                       }
        if($paramFetcher->get('daterecovered'))         {   $vacation->setDaterecovered(Date::encodeDateToDatetime($paramFetcher->get('daterecovered')));   }

        if(!is_null($paramFetcher->get('enabled')))     {   $vacation->setEnabled($paramFetcher->get('enabled'));                                           }
        if(!is_null($paramFetcher->get('archived')))    {   $vacation->setArchived($paramFetcher->get('archived'));                                         }


        if(!is_null($paramFetcher->get('validated')))   
        {   
            $vacation->setValidated($paramFetcher->get('validated'));            

            if($paramFetcher->get('validated') == 1)
            {
                if(!is_null($vacation->getStaff()))
                {
                    //  Récupération du mail - Validation
                    $em                 =   $this->getDoctrine()->getManager();
                    $template           =   new \Charlotte\TemplateBundle\Helper\TemplateFactory($em, 13);
                    $htmlMail           =   $template->getHtmlMail();
                    $myDate             =   $vacation->getDatestart()->format('d/m/Y') . " - " . $vacation->getDateend()->format('d/m/Y');;

                    //  Envoi du mail via Tipimail
                    $myTipimailMessage  =   new \Charlotte\MessagingBundle\Model\MyTipimailMessage();
                    $myTipimailMessage->setFrom('contact@auto-ici.fr','Charlotte');
                    $myTipimailMessage->setReplyTo('contact@auto-ici.fr','Charlotte');
                    $myTipimailMessage->addTo($vacation->getStaff()->getProfessionalmail(), $vacation->getStaff()->getFirstname()." ".$vacation->getStaff()->getLastname());
                    $myTipimailMessage->setSubject('Validation demande de congé : '.$myDate);
                    $myTipimailMessage->setHtml($htmlMail);
                    $myTipimailMessage->send();
                }
            }                           
        }

        if(!is_null($paramFetcher->get('enabled')) && !is_null($paramFetcher->get('archived')))
        {
            if($paramFetcher->get('enabled') == 0 && $paramFetcher->get('archived') == 1)
            {
                if(!is_null($vacation->getStaff()))
                {
                    //  Récupération du mail - Refus
                    $em                 =   $this->getDoctrine()->getManager();
                    $template           =   new \Charlotte\TemplateBundle\Helper\TemplateFactory($em, 14);
                    $htmlMail           =   $template->getHtmlMail();
                    $myDate             =   $vacation->getDatestart()->format('d/m/Y') . " - " . $vacation->getDateend()->format('d/m/Y');;

                    //  Envoi du mail via Tipimail
                    $myTipimailMessage  =   new \Charlotte\MessagingBundle\Model\MyTipimailMessage();
                    $myTipimailMessage->setFrom('contact@auto-ici.fr','Charlotte');
                    $myTipimailMessage->setReplyTo('contact@auto-ici.fr','Charlotte');
                    $myTipimailMessage->addTo($vacation->getStaff()->getProfessionalmail(), $vacation->getStaff()->getFirstname()." ".$vacation->getStaff()->getLastname());                
                    $myTipimailMessage->setSubject('Refus demande de congé : '.$myDate);
                    $myTipimailMessage->setHtml($htmlMail);
                    $myTipimailMessage->send();
                }
            }
        }

        $em->persist($vacation);
        $em->flush();

        $view->setStatusCode(200)->setData($json);

        return $view;
    }
}
