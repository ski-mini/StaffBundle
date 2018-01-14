<?php

namespace Charlotte\StaffBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="Charlotte\StaffBundle\Repository\Team")
 */
class Team extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function removeAllRoles(){
        return $this->roles = array();
    }

    /**
     * @VirtualProperty
     * Get All roles from the team and sort them by type
     * @return ArrayCollection
     */
    public function allteamroles()
    {
        $roles = array();

        global $kernel;

        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }

        $service = $kernel->getContainer()->get('charlotte_staff.rolesdescription');

        $rolesdescription = $service->allDescription();

        foreach ((array)$this->getRoles() as $role) {

            $explode = explode('_', $role);

            $type = $explode[1];
            $key = $explode[2];
            $value = $explode[3];

            if(isset($roles[$type]) && array_key_exists($key, $roles[$type])) {
                if($value > $roles[$type][$key]) {
                    $roles[$type][$key]['value'] = $value;
                    $roles[$type][$key]['comment'] = $rolesdescription['ROLE_'.$type.'_'.$key];
                }
            }
            else {
                $roles[$type][$key]['value'] = $value;
                $roles[$type][$key]['comment'] = $rolesdescription['ROLE_'.$type.'_'.$key];
            }
        }

        uksort($roles, "strnatcasecmp");

        return $roles;

    }
}