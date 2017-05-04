<?php

namespace App\Factory;

use Doctrine\ORM\EntityManager;
use App\FactoryInterface\RoleFactoryInterface;
use App\Entity\Role;
use App\Service\Logger;

class RoleFactory implements RoleFactoryInterface 
{

	protected $entityManager;
	protected $role;

	public function __construct(
		EntityManager $entityManager, 
		Role $role
	) {
		$this->entityManager = $entityManager;
		$this->role = $role;
	}

	public function create(array $input)
	{
		try {
			$this->role->setName($input['name']);
			
			$this->entityManager->persist($this->role);
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
}