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
 * @Prefix("staffcolor")
 */
class StaffcolorRestController extends FOSRestController
{
    /**
     * @QueryParam(name="id", requirements="\d+", description="Id de la couleur")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Staffcolor",
     *  description="Retourne une couleur d\'utilisateur"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view 		= 	View::create();

        $staffcolor =   $this->getDoctrine()
                          	->getManager()
                          	->getRepository('CharlotteStaffBundle:Staffcolor')
                          	->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($staffcolor))
        {
            return new View("Aucune couleur trouvée.", 204);
        }

        return new View($staffcolor, 200);
    }

    /**
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Staffcolor",
     *  description="Retourne toutes les couleurs d\'utilisateur"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $staffcolors    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Staffcolor')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()), array('hexa' => 'ASC'));


        if(!is_array($staffcolors) || empty($staffcolors))
        {
            return new View("Aucun couleur trouvé.", 204);
        }

        return new View($staffcolors, 200);
    }


    /**
     * @QueryParam(name="staffid", strict=FALSE, description="id du staff")
     * 
     * @ApiDoc(
     *  section = "Staffcolor",
     *  description="Retourne toutes les couleurs d\'utilisateur non utilisées"
     * )
     */
    public function getAllNotUsedAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $repository     =   $this->getDoctrine()->getManager()->getRepository('CharlotteStaffBundle:Staffcolor');

        $staffcolors    =   $repository->findAllNotUsed(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($staffcolors) || empty($staffcolors))
        {
            return new View("Aucun couleur trouvé.", 204);
        }

        return new View($staffcolors, 200);
    }

    /**
     * Mise à jour/ Création d'un staffcolor
     *
     * @ApiDoc(
     *   section = "Staffcolor",
     *   description = "Mise à jour d'une couleur d\'utilisateur",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     * )
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="id", strict=FALSE, description="Id de la couleur d\'utilisateur")
     * @RequestParam(name="value", strict=FALSE, description="Nom de la couleur")
     * @RequestParam(name="hexa", strict=FALSE, description="Code hexadecimal de la couleur")
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
            $staffcolor  =   $em->getRepository('CharlotteStaffBundle:Staffcolor')->findOneBy(array('id' => $paramFetcher->get('id')));
        }
        else    //  Insert
        {
            $staffcolor  =   new \Charlotte\StaffBundle\Entity\Staffcolor();
        }

        if(!is_object($staffcolor))
        {
            throw $this->createNotFoundException();
        }

        if(!is_null($paramFetcher->get('value'))) 		{   $staffcolor->setValue($paramFetcher->get('value')); 			}
        if(!is_null($paramFetcher->get('hexa'))) 		{   $staffcolor->setHexa($paramFetcher->get('hexa')); 				}
 
        if(!is_null($paramFetcher->get('enabled'))) 	{   $staffcolor->setEnabled($paramFetcher->get('enabled')); 		}
        if(!is_null($paramFetcher->get('archived')))	{   $staffcolor->setArchived($paramFetcher->get('archived')); 		}

        $em->persist($staffcolor);
        $em->flush();

        //  Update
        if($paramFetcher->get('id'))
        {
            $json   =   array('editResult' => true, 'isInsert' => false, 'staffcolor' => $staffcolor);
        }
        else    //  Insert
        {
            $json   =   array('editResult' => true, 'isInsert' => true, 'staffcolor' => $staffcolor);
        }

        return $json;
    }

}