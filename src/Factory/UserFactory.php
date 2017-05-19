<?php

namespace App\Factory;

use Doctrine\ORM\EntityManager;
use App\FactoryInterface\UserFactoryInterface;
use App\Entity\User;
use App\Service\Logger;

class UserFactory implements UserFactoryInterface 
{
	protected $entityManager;

	public function __construct(
		EntityManager $entityManager
	) {
		$this->entityManager = $entityManager;
	}

	public function create(array $user)
	{
		try {
			$user = new User($user['email'], $user['password']);
			
			$this->entityManager->persist($user);
			$this->entityManager->flush();
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}

		return true;
	}
}