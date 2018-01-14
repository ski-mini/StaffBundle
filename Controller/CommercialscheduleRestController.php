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
 * @Prefix("commercialschedule")
 */
class CommercialscheduleRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id d\'une vacances")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Commercialschedule",
     *  description="Retourne une vacance"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $vacation 	=   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Commercialschedule')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($vacation))
        {
            return new View("Aucune vacances trouvée.", 204);
        }

        return new View($vacation, 200);
    }

 	/**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Commercialschedule",
     *  description="Retourne toutes les vacances"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $vacations    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Commercialschedule')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($vacations) || empty($vacations))
        {
            return new View("Aucune vacance trouvée.", 204);
        }

        return new View($vacations, 200);
    }


    


    /**
     * @RequestParam(name="id", strict=FALSE, description="Id")
     * @RequestParam(name="weektype", strict=false, description="Type de semaine")
     * @RequestParam(name="comment", strict=false, description="Comment")
     * @RequestParam(name="enabled", strict=false, description="Actif")
     * @RequestParam(name="archived", strict=false, description="Archivé")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Commercialschedule",
     *  description="Création / Modification d\'une semaine",
     *  statusCodes={
     *         200="Retourné quand il y a une réponse"
     *     }
     * )
     * @Route("/edit")
     */
    public function postEditAction(ParamFetcher $paramFetcher)
    {
        $view                   =   View::create();
        $em                     =   $this->getDoctrine()->getManager();

        //  Update
        if($paramFetcher->get('id'))
        {
             $commercialschedule  =   $em->getRepository('CharlotteStaffBundle:Commercialschedule')->findOneBy(array('id' => $paramFetcher->get('id')));
             $json   =   array('editResult' => true, 'isInsert' => false  );
        }

        if($paramFetcher->get('weektype'))      
        {   
            $weektype       =   $em->getRepository('CharlotteStaffBundle:Weektype')->findOneBy(array('id' => $paramFetcher->get('weektype')));
            $commercialschedule->setWeektype($weektype);
        }

        if(!is_null($paramFetcher->get('comment'))){    $commercialschedule->setComment($paramFetcher->get('comment'));                     }

        $em->persist($commercialschedule);
        $em->flush();

        $view->setStatusCode(200)->setData($json);

        return $view;
    }

    /**
     * @RequestParam(name="staff", strict=false, description="Utilisateur / Commercial")
     * @RequestParam(name="weekid", strict=false, description="Numéro de semaine")
     * @RequestParam(name="weektype", strict=false, description="Type de semaine")
     * @RequestParam(name="enabled", strict=false, description="Actif")
     * @RequestParam(name="archived", strict=false, description="Archivé")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Commercialschedule",
     *  description="Création / Modification d\'une semaine",
     *  statusCodes={
     *         200="Retourné quand il y a une réponse"
     *     }
     * )
     * @Route("/edit/all")
     */
    public function postEditAllAction(ParamFetcher $paramFetcher)
    {
        $view                   =   View::create();
        $em                     =   $this->getDoctrine()->getManager();

        $year   =   2015;
        $week   =   $paramFetcher->get('weekid');


        //  On supprime les anciens enregistrements de cette semaine
        $time   =   strtotime("1 January $year", time());
        $day    =   date('w', $time);
        $time   +=  ((7*$week)+1-$day)*24*3600;


        $toDel[0] = date('d/m/Y', $time);
        
        $time       +=  1*24*3600;
        $toDel[1]   =   date('d/m/Y', $time);

        $time       +=  1*24*3600;
        $toDel[2]   =   date('d/m/Y', $time);

        $time       +=  1*24*3600;
        $toDel[3]   =   date('d/m/Y', $time);
              
        $time       +=  1*24*3600;
        $toDel[4]   =   date('d/m/Y', $time);

        $time       +=  1*24*3600;
        $toDel[5]   =   date('d/m/Y', $time);

        foreach ($toDel as $key => $value) 
        {
            $commercialschedule  =   $em->getRepository('CharlotteStaffBundle:Commercialschedule')->findOneBy(array('staff' => $paramFetcher->get('staff'), 'dateschedule' => Date::encodeDateToDatetime($value)));
            
            if(!is_null($commercialschedule))
            {
                $em->remove($commercialschedule);
                $em->flush(); 
            }
        }

        //  On ajoute les nouveaux enregistrements de cette semaine
        $time   =   strtotime("1 January $year", time());
        $day    =   date('w', $time);
        $time   +=  ((7*$week)+1-$day)*24*3600;


        $return[0] = date('d/m/Y', $time);
        
        $time += 1*24*3600;
        $return[1] = date('d/m/Y', $time);

        $time += 1*24*3600;
        $return[2] = date('d/m/Y', $time);

        $time += 1*24*3600;
        $return[3] = date('d/m/Y', $time);
              
        $time += 1*24*3600;
        $return[4] = date('d/m/Y', $time);

        $time += 1*24*3600;
        $return[5] = date('d/m/Y', $time);

        foreach ($return as $key => $value) 
        {
            $commercialschedule     =   new \Charlotte\StaffBundle\Entity\Commercialschedule();

            if($paramFetcher->get('staff'))
            {
                $staff          =   $em->getRepository('CharlotteStaffBundle:Staff')->findOneBy(array('id' => $paramFetcher->get('staff')));
                $commercialschedule->setStaff($staff);
            }

            if($paramFetcher->get('weektype'))
            {
                if($key == 5)
                {
                    $weektype          =   $em->getRepository('CharlotteStaffBundle:Weektype')->findOneBy(array('id' => 5));
                    $commercialschedule->setWeektype($weektype);
                }
                else
                {
                    $weektype          =   $em->getRepository('CharlotteStaffBundle:Weektype')->findOneBy(array('id' => $paramFetcher->get('weektype')));
                    $commercialschedule->setWeektype($weektype);
                }


            }

            $commercialschedule->setDateschedule(Date::encodeDateToDatetime($value)); 
    
            $em->persist($commercialschedule);
            $em->flush();
        }

        $json                   =   array('editResult' => true, 'isInsert' => true  );

        $view->setStatusCode(200)->setData($json);

        return $view;
    }
}
