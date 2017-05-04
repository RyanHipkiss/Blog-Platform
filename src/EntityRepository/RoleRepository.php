<?php

namespace App\EntityRepository;

use Doctrine\ORM\EntityRepository;
use App\EntityInterface\RoleInterface;

class RoleRepository extends EntityRepository implements RoleInterface 
{
    public function findAll()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        
        $roles = 
            $query
                ->select('r')
                ->from('\App\Entity\Role', 'r')
                ->getQuery()
                ->getAll();

		return $roles;
    }
}