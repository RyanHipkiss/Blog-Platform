<?php

namespace App\Factory;

use App\FactoryInterface\UserFactoryInterface;
use App\EntityInterface\UserInterface;
use App\Entity\User;

class UserFactory implements UserFactoryInterface {

	protected $userInterface;
	protected $user;

	public function __construct(
		UserInterface $userInterface, 
		User $user
	) {
		$this->userInterface = $userInterface;
		$this->user = $user;
	}

	public function create(array $user)
	{
		try {
			$this->user->setEmail($user['email']);
			$this->user->setPassword($user['password']);

			$this->userInterface->add($this->user);
			$this->userInterface->getEntityManager()->flush();
		} catch(\Exception $e) {
			//Log error
			return false;
		}

		return true;
	}
}