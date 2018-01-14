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
 * @Prefix("maritalstatus")
 */
class MaritalstatusRestController extends FOSRestController
{
    /**
     *
     * @QueryParam(name="enabled", requirements="(0|1)", default=1, description="Actif")
     * @QueryParam(name="archived", requirements="(0|1)", default=0, description="Supprime")
     *
     * @ApiDoc(
     *  section = "Maritalstatus",
     *  description="Retourne tous les états civils"
     * )
     */
    public function getAllAction(ParamFetcher $paramFetcher)
    {

        $maritalStatus    =   $this->getDoctrine()
                           ->getManager()
                           ->getRepository('CharlotteStaffBundle:Maritalstatus')
                           ->findBy(RestFunction::CleanNull($paramFetcher->all()));

        if(!is_array($maritalStatus) || empty($maritalStatus)){
            throw $this->createNotFoundException();
        }

        return $maritalStatus;
    }

}
