<?php

namespace Charlotte\StaffBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Charlotte\StaffBundle\Form\TeamForm;
use Charlotte\StaffBundle\Form\TeamListForm;
use Charlotte\StaffBundle\Entity\Team;

use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{

    public function resetAllAction(Request $request) {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $rolesdescription = $em->getRepository('CharlotteStaffBundle:Rolesdescription')->findBy(array('archived' => 0));
        $group = $em->getRepository('CharlotteStaffBundle:Team')->findOneById($request->request->get('team'));

        $group->removeAllRoles();

        $em->flush();

        foreach ($rolesdescription as $role) {
            $group->addRole($role->getName().'_'.$request->request->get('rights'));
        }

        $em->flush();

        $session->getFlashBag()->add('valid', 'Reset effectué !');

        return $this->redirect($this->generateUrl('CharlotteStaffBundle_role'));
    }

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $session = $request->getSession();

        $TeamForm = $this->createForm(new TeamForm());
        $TeamForm->handleRequest($request);

        $TeamListForm = $this->createForm(new TeamListForm());
        $TeamListForm->handleRequest($request);

        if($TeamForm->isValid()) {

            $name = strtoupper($TeamForm->getData()['name']);
            $team = $TeamForm->getData()['team'];

            if(!empty($team)) {
                $rolesdescription = $this->container->get('charlotte_staff.rolesdescription')->allDescription();

                return $this->render('CharlotteStaffBundle:Team:edit.html.twig', array(
                    'team' => $team,
                    'TeamListForm' => $TeamListForm->createView()
                ));
            }
            else if(!empty($name)) {
                $team = $em->getRepository('CharlotteStaffBundle:Team')
                           ->findOneByName($name);

                if(!is_object($team)) {
                    //si n'existe pas alors on crée
                    $team = new Team($name);
                    $team->setName($name);
                    $em->persist($team);
                    $em->flush();

                    $session->getFlashBag()->add('valid', 'Nouveau groupe d\'utilisateur créé !');
                }
                else {
                    $session->getFlashBag()->add('error', 'Ce groupe existe déjà !');
                }

                return $this->render('CharlotteStaffBundle:Team:index.html.twig', array(
                    'TeamForm' => $TeamForm->createView()
                ));
            }
        }
        elseif($TeamListForm->isValid()) {
            $teamToUpdate = $em->getRepository('CharlotteStaffBundle:Team')
                               ->findOneById($TeamListForm->getData()['teamId']);

            $teamToUpdate->removeAllRoles();
            foreach ($TeamListForm->getData()['team']->getRoles() as $roles) {
                $teamToUpdate->addRole($roles);
            }
            $em->persist($teamToUpdate);
            $em->flush();

            return $this->render('CharlotteStaffBundle:Team:edit.html.twig', array(
                'team' => $teamToUpdate,
                'TeamListForm' => $TeamListForm->createView()
            ));
        }

        return $this->render('CharlotteStaffBundle:Team:index.html.twig', array(
            'TeamForm' => $TeamForm->createView()
        ));
    }

    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $group = $em->getRepository('CharlotteStaffBundle:Team')->findOneByName($request->request->get('team'));

        $new = $request->request->get('new');
        $role = $request->request->get('role');

        foreach ($role as $key => $value) {
            if($new[$key] !== $value) {
                $group->removeRole($key.'_'.$value);
                $group->addRole($key.'_'.$new[$key]);
            }
        }

        $em->flush();

        return $this->render('CharlotteStaffBundle:Team:valid.html.twig');
    }

}