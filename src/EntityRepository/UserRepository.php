<?php

namespace App\EntityRepository;

use Doctrine\ORM\EntityRepository;
use App\EntityInterface\UserInterface;
use App\Entity\User;

class UserRepository extends EntityRepository implements UserInterface 
{
	public function findByEmail($email)
	{
		$query = $this->getEntityManager()->createQueryBuilder();

		$user = $query
			->select('u')
			->from('\App\Entity\User', 'u')
			->where('u.email = :email')
			->setParameter('email', $email)
			->getQuery()
			->getOneOrNullResult();

		return $user;
	}
}