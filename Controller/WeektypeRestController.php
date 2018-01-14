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
 * @Prefix("weektype")
 */
class WeektypeRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="id", requirements="\d+", description="Id du type de semaine")
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Weektype",
     *  description="Retourne un type de semaine"
     * )
     */
    public function getOneAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $weektype 	=   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Weektype')
                          ->findOneBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_object($weektype))
        {
            return new View("Aucun type de semaine trouvé.", 204);
        }

        return new View($weektype, 200);
    }

 	/**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Weektype",
     *  description="Retourne tous les types de semaine"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $weektypes    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Weektype')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($weektypes) || empty($weektypes))
        {
            return new View("Aucun type de semaine trouvé.", 204);
        }

        return new View($weektypes, 200);
    }


}
