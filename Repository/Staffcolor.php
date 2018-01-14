<?php

namespace Charlotte\StaffBundle\Repository;

use Doctrine\ORM\EntityRepository;

class Staffcolor extends EntityRepository
{
	//	Renvoi toutes les couleurs non utilisées
    public function findAllNotUsed($filters) 
    {
        $queryBuilder = $this->createQueryBuilder('sc');

        $queryBuilder->leftJoin('CharlotteStaffBundle:Staff', 's', \Doctrine\ORM\Query\Expr\Join::WITH, 's.color = sc.hexa');

    	if(isset($filters['staffid']))
    	{
			$queryBuilder->where("(s.id = ".$filters['staffid']." OR s.color IS NULL) AND sc.enabled = 1 AND sc.archived = 0");
    	}
    	else
    	{
			$queryBuilder->where("s.color IS NULL AND sc.enabled = 1 AND sc.archived = 0");
    	}

        $result = $queryBuilder->getQuery()->getResult();

        return $result;
    }
}
