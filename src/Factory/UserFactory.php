<?php

namespace App\Factory;

use Doctrine\ORM\EntityManager;
use App\FactoryInterface\UserFactoryInterface;
use App\Entity\User;
use App\Entity\Role;
use App\Service\Logger;

class UserFactory implements UserFactoryInterface 
{
	protected $entityManager;

	public function __construct(
		EntityManager $entityManager
	) {
		$this->entityManager = $entityManager;
	}

	public function create(array $input)
	{
		try {
			$user = new User($input['email'], $input['password']);

			if(!empty($input['role'])) {
				$role = $this->entityManager->getReference('App\Entity\Role', $id);
				$user->addRole($role);
			}
			
			$this->entityManager->persist($user);
			$this->entityManager->flush();
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}

		return true;
	}

	public function update(array $input, $id)
	{
		try {
			$user = $this->entityManager->getReference('App\Entity\User', $id);
			$role = $this->entityManager->getReference('App\Entity\Role', $input['roles']);
			$user->addRole($role);
			$user->setEmail($input['email']);
			$user->setPassword($input['password']);

			$this->entityManager->persist($user);
			$this->entityManager->flush();
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}
	}
}