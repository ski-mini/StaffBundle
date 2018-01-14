<?php

namespace Charlotte\StaffBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

/**
  * Classe Rolesdescription
  */
class Rolesdescription
{
    protected $em;

    public function setEntityManager(ObjectManager $em)
    {
       $this->em = $em;
    }

    /*
     *  Fonction qui a pour but de renvoyer la liste des commentaires en fonctions des roles (en clef du tableau)
     *  @return array
     */
    public function allDescription()
    {
      return $rolesdescription = $this->em->getRepository('CharlotteStaffBundle:Rolesdescription')
                                          ->findAllDescription();
    }

}