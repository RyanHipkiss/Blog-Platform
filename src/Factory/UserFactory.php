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
				$user->setRoles([$role]);
			}
			
			$this->entityManager->persist($user);
			$this->entityManager->flush();

			return true;
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}
	}

	public function update(array $input, $id)
	{
		try {
			$user = $this->entityManager->getReference('App\Entity\User', $id);
			$role = $this->entityManager->getReference('App\Entity\Role', $input['roles']);
			$user->setRoles([$role]);
			$user->setEmail($input['email']);
			$user->setPassword($input['password']);

			$this->entityManager->persist($user);
			$this->entityManager->flush();
			return true;
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}
	}

	public function delete($id) 
	{
		try {
			$user = $this->entityManager->getReference('App\Entity\User', $id);
			$this->entityManager->remove($user);
			$this->entityManager->flush();

			return true;
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}
	}
}