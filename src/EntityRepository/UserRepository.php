<?php

namespace App\EntityRepository;

use Doctrine\ORM\EntityManager;
use App\EntityInterface\UserInterface;
use App\Entity\User;

class UserRepository implements UserInterface 
{
	protected $em;
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function getEntityManager()
	{
		return $this->em;
	}

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