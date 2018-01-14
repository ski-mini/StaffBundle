<?php

namespace Charlotte\StaffBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Charlotte\StaffBundle\Form\TableRole;
use Charlotte\StaffBundle\Form\TableForm;
use Charlotte\StaffBundle\Form\OthersroleForm;
use Charlotte\StaffBundle\Form\StaffListForm;
use Charlotte\StaffBundle\Form\GroupListForm;

use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{

    public function indexAction(){
        return $this->render('CharlotteStaffBundle:Default:index.html.twig'
                            )
        ;
    }

    public function searchAction(Request $request){
        if(!empty($request->query->get('roleId'))){

            $em = $this->getDoctrine()->getManager();

            //get rolesdescription by id
            $rolesdescription = $em->getRepository('CharlotteStaffBundle:Rolesdescription')
                                   ->find($request->query->get('roleId'));

            //get tous les services qui possèdent le role
            $teamuser = $em->getRepository('CharlotteStaffBundle:Team')
                            ->findByRole($rolesdescription->getName().'_');

            //get tous les users qui possèdent le role
            $staffuser = $em->getRepository('CharlotteStaffBundle:Staff')
                            ->findByUserRole($rolesdescription->getName().'_');

            return $this->render('CharlotteStaffBundle:Role:result.html.twig', array(
                                    'role' => $rolesdescription->getName(),
                                    'roledescription' => $rolesdescription,
                                    'staffuser' => $staffuser,
                                    'teamuser' => $teamuser
                                ))
            ;
        }

        return $this->render('CharlotteStaffBundle:Role:search.html.twig'
                            )
        ;
    }

    public function newAction(Request $request)
    {
        $session = $request->getSession();

        $table = new TableRole();
        $form = $this->createForm(new TableForm(), $table);

        $OthersroleForm = $this->createForm(new OthersroleForm());

        $form->handleRequest($request);
        $OthersroleForm->handleRequest($request);

        $bundle = ucfirst($form->getData()->getBundle());
        $entity = ucfirst($form->getData()->getEntity());

        if ($form->isValid()) {
            if(file_exists(__DIR__.'/../../'.$bundle.'Bundle/Entity/'.$entity.'.php')) {
                $repository = $this->getDoctrine()->getManager()
                                   ->getClassMetadata('Charlotte\\'.$bundle.'Bundle\\Entity\\'.$entity);

                return $this->render('CharlotteStaffBundle:Role:index.html.twig', array(
                    'repository' => $repository,
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'OthersroleForm' => $OthersroleForm->createView()
                ));
            }
            return $this->render('CharlotteStaffBundle:Role:index.html.twig', array(
                'form' => $form->createView(),
                'OthersroleForm' => $OthersroleForm->createView()
            ));
        }
        else if($OthersroleForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $data = $OthersroleForm->getData();
            $type = strtoupper($data['type']);
            $name = strtoupper($data['name']);
            $description = $data['description'];

            $rolesdescription = $em->getRepository('CharlotteStaffBundle:Rolesdescription')
                                   ->findOneByName('ROLE_'.$type.'_'.$name);

            if(!is_object($rolesdescription)) {
                //si n'existe pas alors on crée dans roledescription
                $rolesdescription = new \Charlotte\StaffBundle\Entity\Rolesdescription();
                $rolesdescription->setName('ROLE_'.$type.'_'.$name);
                $rolesdescription->setDescription($description);
                $em->persist($rolesdescription);
                $em->flush();

                //on ajoute dans les groupes
                $team = $em->getRepository('CharlotteStaffBundle:Team')
                           ->findAll();

                foreach ($team as $t) {
                    if($t->getName() == "ADMIN")
                        $t->addRole('ROLE_'.$type.'_'.$name.'_77');
                    else
                        $t->addRole('ROLE_'.$type.'_'.$name.'_00');
                    $em->persist($t);
                }

                $em->flush();

                $session->getFlashBag()->add('valid', 'Role enregistré !');
            }
            else {
                //si il existe on update juste le com et on met archive à 0
                $olddescription = $rolesdescription->getDescription();
                $rolesdescription->setDescription($description);
                $rolesdescription->setArchived(FALSE);
                $em->persist($rolesdescription);
                $em->flush();

                $session->getFlashBag()->add('error', 'Ce role existait déjà ! La description a été changé de "'.$olddescription.'" pour "'.$description.'"');
            }


            return $this->render('CharlotteStaffBundle:Role:index.html.twig', array(
                'form' => $form->createView(),
                'OthersroleForm' => $OthersroleForm->createView()
            ));
        }

        return $this->render('CharlotteStaffBundle:Role:index.html.twig', array(
            'form' => $form->createView(),
            'OthersroleForm' => $OthersroleForm->createView()
        ));
    }

    public function createAction(Request $request)
    {
        foreach ($request->request->all() as $key => $value) {

            $em = $this->getDoctrine()->getManager();

            $temp  = explode('~', $key);
            $table = strtoupper($temp[0]);
            $field = strtoupper($temp[1]);
            $description = $temp[2] ? $temp[2] : '';

            $rolesdescription = $em->getRepository('CharlotteStaffBundle:Rolesdescription')
                                   ->findOneByName('ROLE_'.$table.'_'.$field);

            if(!is_object($rolesdescription)) {
                //si n'existe pas alors on crée dans role + on ajoute dans le groupe ADMIN qui possède tous les roles en 77
                $rolesdescription = new \Charlotte\StaffBundle\Entity\Rolesdescription();
                $rolesdescription->setName('ROLE_'.$table.'_'.$field);
                $rolesdescription->setDescription($description);
                $em->persist($rolesdescription);
                $em->flush();

                $team = $em->getRepository('CharlotteStaffBundle:Team')
                           ->findOneByName('ADMIN');
                $team->addRole('ROLE_'.$table.'_'.$field.'_77');
                $em->persist($team);
                $em->flush();
            }
            else {
                //si il existe on update juste le com et on met archive à 0
                $rolesdescription->setDescription($description);
                $rolesdescription->setArchived(FALSE);
                $em->persist($rolesdescription);
                $em->flush();
            }

        }

        $request->getSession()->getFlashBag()->add('valid', 'Roles enregistrés !');

        return $this->redirect($this->generateUrl('CharlotteStaffBundle_role_new'));
    }

    public function removegroupAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $staffRepository = $em->getRepository('CharlotteStaffBundle:Staff');
        $staff = $staffRepository->findOneById($request->request->get('staffId'));

        $teamRepository = $em->getRepository('CharlotteStaffBundle:Team');
        $team = $teamRepository->findOneById($request->request->get('teamId'));

        $staff->removeGroup($team);
        $em->persist($staff);
        $em->flush();
        $session->getFlashBag()->add('success', 'Les modifications ont étés correctement appliquées.');
        $session->set('staffId', $staff->getId());
        return $this->redirect($this->generateUrl('CharlotteStaffBundle_role_staff'));
    }

    public function stafflistAction(Request $request)
    {
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();

        $StaffListForm = $this->createForm(new StaffListForm());
        $StaffListForm->handleRequest($request);

        $GroupListForm = $this->createForm(new GroupListForm());
        $GroupListForm->handleRequest($request);

        if($StaffListForm->isValid()) {
            $data = $StaffListForm->getData();
            return $this->render('CharlotteStaffBundle:Staff:editrole.html.twig', array(
                'staff' => $data['staff'],
                'GroupListForm' => $GroupListForm->createView()
            ));
        }
        else if(!empty($session->get('staffId'))){
            $staffRepository = $em->getRepository('CharlotteStaffBundle:Staff');
            $staff = $staffRepository->findOneById($session->get('staffId'));
            $session->remove('staffId');
            return $this->render('CharlotteStaffBundle:Staff:editrole.html.twig', array(
                'staff' => $staff,
                'GroupListForm' => $GroupListForm->createView()
            ));
        }
        else if($GroupListForm->isValid()) {
            $team = $GroupListForm->get('team')->getData();
            $staffId = $GroupListForm->get('staffId')->getData();

            $staffRepository = $em->getRepository('CharlotteStaffBundle:Staff');

            $staff = $staffRepository->findOneById($staffId);

            $hasGroup = false;
            foreach ($staff->getGroups() as $val) {
                if($val->getId() == $team->getId())
                    $hasGroup = true;
            }

            if($hasGroup){
                $session->getFlashBag()->add('error', ' Il possède déjà ce groupe espèce de boloss.');
            }
            else{
                $staff->addGroup($team);
                $em->persist($staff);
                $em->flush();
                $session->getFlashBag()->add('success', 'Les modifications ont étés correctement appliquées.');
            }

            return $this->render('CharlotteStaffBundle:Staff:editrole.html.twig', array(
                'staff' => $staff,
                'GroupListForm' => $GroupListForm->createView()
            ));
        }

        return $this->render('CharlotteStaffBundle:Staff:list.html.twig', array(
            'StaffListForm' => $StaffListForm->createView()
        ));
    }

    public function staffeditAction(Request $request)
    {
        $session = $request->getSession();

        $StaffListForm = $this->createForm(new StaffListForm());
        $StaffListForm->handleRequest($request);

        if($StaffListForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $data = $StaffListForm->getData();
            var_dump($data);
            // $type = strtoupper($data['type']);
            // $name = strtoupper($data['name']);
            // $description = $data['description'];

            // $rolesdescription = $em->getRepository('CharlotteStaffBundle:Rolesdescription')
            //                        ->findOneByName('ROLE_'.$type.'_'.$name);

            return $this->render('CharlotteStaffBundle:Staff:editrole.html.twig', array(
                'StaffListForm' => $StaffListForm->createView()
            ));
        }

        return $this->render('CharlotteStaffBundle:Staff:list.html.twig', array(
            'StaffListForm' => $StaffListForm->createView()
        ));
    }

}