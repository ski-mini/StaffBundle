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
 * @Prefix("weekcomment")
 */
class WeekcommentRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id du type de semaine")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Weekcomment",
     *  description="Retourne un type de semaine"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $weekcomment 	=   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Weekcomment')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($weekcomment))
        {
            return new View("Aucun commentaire de semaine trouvé.", 204);
        }

        return new View($weekcomment, 200);
    }

 	/**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Weekcomment",
     *  description="Retourne tous les types de semaine"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $weekcomments    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Weekcomment')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($weekcomments) || empty($weekcomments))
        {
            return new View("Aucun commentaire de semaine trouvé.", 204);
        }

        return new View($weekcomments, 200);
    }

    /**
     * @RequestParam(name="id", strict=false, description="Id du congé")
     * @RequestParam(name="value", strict=false, description="Commentaire")
     * @RequestParam(name="year", strict=false, description="année du commentaire")
     * @RequestParam(name="weeknumber", strict=false, description="numéro de semaine du commentaire")
     * @RequestParam(name="enabled", strict=false, description="Actif")
     * @RequestParam(name="archived", strict=false, description="Archivé")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Weekcomment",
     *  description="Création / Modification d'un commentaire d'une semaine",
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
            $weekcomment       =   $em->getRepository('CharlotteStaffBundle:Weekcomment')->findOneBy(array('id' => $paramFetcher->get('id')));
            $json           =   array('editResult' => true, 'isInsert' => false  );
        }
        else    //  Insert
        {
            $weekcomment       =   new \Charlotte\StaffBundle\Entity\Weekcomment();
            $json           =   array('editResult' => true, 'isInsert' => true  );
        }

        if(!is_null($paramFetcher->get('value'))) 		{   $weekcomment->setValue($paramFetcher->get('value')); 			}
        if(!is_null($paramFetcher->get('year')))     	{   $weekcomment->setYear($paramFetcher->get('year')); 				}
        if(!is_null($paramFetcher->get('weeknumber'))) 	{   $weekcomment->setWeeknumber($paramFetcher->get('weeknumber')); 	}
        if(!is_null($paramFetcher->get('enabled')))     {   $weekcomment->setEnabled($paramFetcher->get('enabled')); 		}
        if(!is_null($paramFetcher->get('archived')))    {   $weekcomment->setArchived($paramFetcher->get('archived')); 		}

        $em->persist($weekcomment);
        $em->flush();

        $view->setStatusCode(200)->setData($json);

        return $view;
    }



    /**
     * @RequestParam(name="id", strict=false, description="Id du congé")
     * @RequestParam(name="value", strict=false, description="Commentaire")
     * @RequestParam(name="year", strict=false, description="année du commentaire")
     * @RequestParam(name="weeknumber", strict=false, description="numéro de semaine du commentaire")
     * @RequestParam(name="enabled", strict=false, description="Actif")
     * @RequestParam(name="archived", strict=false, description="Archivé")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Weekcomment",
     *  description="Création / Modification d'un commentaire d'une semaine par year/weeknumber",
     *  statusCodes={
     *         200="Retourné quand il y a une réponse"
     *     }
     * )
     * @Route("/editbis")
     */
    public function postEditBisAction(ParamFetcher $paramFetcher)
    {
        $view           =   View::create();
        $em             =   $this->getDoctrine()->getManager();
        
        $weekcomment 	=   $em->getRepository('CharlotteStaffBundle:Weekcomment')->findOneBy(array('year' => $paramFetcher->get('year'), 'weeknumber' => $paramFetcher->get('weeknumber')));
        $json 			=   array('editResult' => true, 'isInsert' => false  );
        
        if(empty($weekcomment))
        {
            $weekcomment 	=   new \Charlotte\StaffBundle\Entity\Weekcomment();
            $json           =   array('editResult' => true, 'isInsert' => true  );
        }
       
        if(!is_null($paramFetcher->get('value'))) 		{   $weekcomment->setValue($paramFetcher->get('value')); 			}
        if(!is_null($paramFetcher->get('year')))     	{   $weekcomment->setYear($paramFetcher->get('year')); 				}
        if(!is_null($paramFetcher->get('weeknumber'))) 	{   $weekcomment->setWeeknumber($paramFetcher->get('weeknumber')); 	}
        if(!is_null($paramFetcher->get('enabled')))     {   $weekcomment->setEnabled($paramFetcher->get('enabled')); 		}
        if(!is_null($paramFetcher->get('archived')))    {   $weekcomment->setArchived($paramFetcher->get('archived')); 		}

        $em->persist($weekcomment);
        $em->flush();

        $view->setStatusCode(200)->setData($json);

        return $view;
    }

}