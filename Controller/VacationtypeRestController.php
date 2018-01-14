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
 * @Prefix("vacationtype")
 */
class VacationtypeRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id du type de vacances")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Vacationtype",
     *  description="Retourne un types de vacances"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $vacationtype 	=   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Vacationtype')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($vacationtype))
        {
            return new View("Aucun type de vacances trouvé.", 204);
        }

        return new View($vacationtype, 200);
    }

 	/**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Vacationtype",
     *  description="Retourne tous les types de vacances"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $vacationtypes    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Vacationtype')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($vacationtypes) || empty($vacationtypes))
        {
            return new View("Aucun type de vacances trouvé.", 204);
        }

        return new View($vacationtypes, 200);
    }


}
