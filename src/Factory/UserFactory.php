<?php

namespace App\Factory;

use Doctrine\ORM\EntityManager;
use App\FactoryInterface\UserFactoryInterface;
use App\Entity\User;
use App\Service\Logger;

class UserFactory implements UserFactoryInterface 
{

	protected $entityManager;
	protected $user;

	public function __construct(
		EntityManager $entityManager, 
		User $user
	) {
		$this->entityManager = $entityManager;
		$this->user = $user;
	}

	public function create(array $user)
	{
		try {
			$this->user->setEmail($user['email']);
			$this->user->setPassword($user['password']);
			
			$this->entityManager->persist($this->user);
			$this->entityManager->flush();
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}

		return true;
	}
}