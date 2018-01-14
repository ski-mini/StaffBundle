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
 * @Prefix("stafffunction")
 */
class StafffunctionRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id d\'une fonction d\'utilisateur")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Stafffunction",
     *  description="Retourne une fonction d\'utilisateur"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $staff_function =   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Stafffunction')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($staff_function))
        {
            return new View("Aucune fonction d'utilisateur trouvée.", 204);
        }

        return new View($staff_function, 200);
    }

 	/**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Stafffunction",
     *  description="Retourne toutes les fonctions d\'utilisateur"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $staff_functions    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Stafffunction')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($staff_functions) || empty($staff_functions))
        {
            return new View("Aucune fonction d'utilisateur trouvée.", 204);
        }

        return new View($staff_functions, 200);
    }
    
    /**
     * @RequestParam(name="id", strict=FALSE, description="Id")
     * @RequestParam(name="value", strict=false, description="Nom de la fonction utilisateur")
     * @RequestParam(name="enabled", strict=false, description="Actif")
     * @RequestParam(name="archived", strict=false, description="Archivé")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Stafffunction",
     *  description="Création / Modification d\'une fonction d\'utilisateur",
     *  statusCodes={
     *         200="Retourné quand il y a une réponse"
     *     }
     * )
     * @Route("/edit")
     */
    public function postEditAction(ParamFetcher $paramFetcher)
    {
        $em         =   $this->getDoctrine()->getManager();

        //  Update
        if($paramFetcher->get('id'))
        {
            $staff_function   =   $em->getRepository('CharlotteStaffBundle:Stafffunction')->findOneBy(array('id' => $paramFetcher->get('id')));
        }
        else    //  Insert
        {
            $staff_function   =   new \Charlotte\StaffBundle\Entity\Stafffunction();
        }

        if(!is_object($staff_function))
        {
            throw $this->createNotFoundException();
        }

        if(!is_null($paramFetcher->get('value'))) 				{   $staff_function->setValue($paramFetcher->get('value')); 					}
        if(!is_null($paramFetcher->get('enabled')))             {   $staff_function->setEnabled($paramFetcher->get('enabled'));					}
        if(!is_null($paramFetcher->get('archived'))) 			{   $staff_function->setArchived($paramFetcher->get('archived')); 				}

        $em->persist($staff_function);
        $em->flush();

        if($paramFetcher->get('id'))
        {
            $json   =   array('editResult' => true, 'isInsert' => false, 'stafffunction' => $staff_function);
        }
        else    //  Insert
        {
            $json   =   array('editResult' => true, 'isInsert' => true, 'stafffunction' => $staff_function);
        }

        return $json;
    }


}
