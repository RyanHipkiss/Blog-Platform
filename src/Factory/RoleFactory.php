<?php

namespace App\Factory;

use Doctrine\ORM\EntityManager;
use App\FactoryInterface\RoleFactoryInterface;
use App\Entity\Role;
use App\Service\Logger;

class RoleFactory implements RoleFactoryInterface 
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
			$role = new Role($input['name']);
			
			$this->entityManager->persist($role);
			$this->entityManager->flush();
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}

		return true;
	}

	public function update(array $input, $roleID)
	{
		$role = $this->entityManager->getRepository('App\Entity\Role')->findOneById($roleID);

		try {
			$role->setName($input['name']);
			
			$this->entityManager->persist($role);
			$this->entityManager->flush();
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}

		return true;
	}

	public function delete($id)
	{
		try {
			$role = $this->entityManager->getReference('App\Entity\Role', $id);
			$this->entityManager->remove($role);
			$this->entityManager->flush();
		} catch(\Exception $e) {
			Logger::send($e->getMessage());
			return false;
		}

		return true;
	}
}