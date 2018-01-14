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
 * @Prefix("role")
 */
class RoleRestController extends FOSRestController
{

    /**
     * Par défaut Charlotte (l'utilisateur, dans Staff) possède tous les rôles. Ainsi lorsqu'un rôle existe mais n'est assigné à personne on peut le retrouver.
     * Ce qui permet aussi de récupérer une liste des rôles existants très simplement.
     *
     * @ApiDoc(
     *  section = "Role",
     *  description="Retourne tous les rôles",
     *  statusCodes={
     *         200="Retourné quand ok",
     *         404="Retourné quand erreur"
     *     }
     * )
     */
    public function getAllAction()
    {
        $view = View::create();

        $user    =   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Staff')
                          ->findOneById(999);

        if(!is_object($user)){
            $view->setStatusCode(404)->setData("Problème détecté.");

            return $view;
        }

        $view->setStatusCode(200)->setData($user->getRoles());

        return $view;
    }

    /**
     * Par défaut Charlotte (l'utilisateur, dans Staff) possède tous les rôles (voir getAllAction). On ajoute donc tout nouveau rôle à Charlotte.
     *
     * @RequestParam(name="role", nullable=false, strict=true, description="Nouveau rôle à ajouter")
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @ApiDoc(
     *  section = "Role",
     *  description="Crée un nouveau rôle",
     *  statusCodes={
     *         200="Retourné quand ok",
     *         404="Retourné quand erreur"
     *     }
     * )
     * @Route("/new")
     */
    public function postNewAction(ParamFetcher $paramFetcher)
    {
        $view = View::create();

        $user    =   $this->getDoctrine()
                          ->getManager()
                          ->getRepository('CharlotteStaffBundle:Staff')
                          ->findOneById(999);

        if(!is_object($user)){
            $view->setStatusCode(404)->setData("Problème détecté.");

            return $view;
        }

        $em = $this->getDoctrine()->getManager();
        for ($i=0; $i < 1000; $i++) {
            $user->addRole($paramFetcher->get('role').$i);
        }

        $em->persist($user);
        $em->flush();

        $view->setStatusCode(200)->setData("Ok");

        return $view;
    }

}
