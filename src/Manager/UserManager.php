<?php

namespace App\Manager;

use Doctrine\ORM\EntityManager;
use App\FactoryInterface\UserFactoryInterface;
use App\Service\Validator;
use App\Service\Session;

class UserManager 
{
	const MIN_PASSWORD_LENGTH = 7;
	const MAX_PASSWORD_LENGTH = 26;

	protected $entityManager;
	protected $userFactory;

	public function __construct(
		EntityManager $entityManager,
		UserFactoryInterface $userFactory
	) {
		$this->entityManager = $entityManager;
		$this->userFactory   = $userFactory;
	}

	public function findById($id)
	{
		return $this->entityManager->getRepository('App\Entity\User')->findOneById($id);
	}

	public function findAll()
	{
		return $this->entityManager->getRepository('App\Entity\User')->findAll();
	}

	public function findByEmail($email)
	{
        return $this->entityManager->getRepository('App\Entity\User')->findOneByEmail($email);
	}

	public function register(array $input, $id = null)
	{
		if(!Validator::email($input['email'])) {
			return [
				'status'  => 'error',
				'message' => 'This is not a valid email address.'
			];
		}

		if(
			(!Validator::minLength($input['password'], self::MIN_PASSWORD_LENGTH) || 
			!Validator::maxLength($input['password'], self::MAX_PASSWORD_LENGTH)) &&
			(empty($id) || !empty($id) && strlen($input['password']) > 0)
		) {
			return [
				'status'  => 'error',
				'message' => 'Password needs to be between ' . self::MIN_PASSWORD_LENGTH . ' and ' . self::MAX_PASSWORD_LENGTH
			];
		}

		if(empty($id)) {
			$user = $this->userFactory->create($input);

			if(false === $user) {
				return [
					'status'  => 'error',
					'message' => 'There was an error creating your account.'
				];
			}

			return [
				'status'  => 'success',
				'message' => 'Account created succesfully.',
				'id'      => $this->findByEmail($input['email'])->getId()
			];
		}

		$user = $this->userFactory->update($input, $id);

		if(false === $user) {
			return [
				'status'  => 'error',
				'message' => 'Sorry, there was an error updating your account'
			];
		}

		return [
			'status'  => 'success',
			'message' => 'Account updated successfully',
			'id'      => $id
		];
	}

	public function login(array $user)
	{
		if(!Validator::email($user['email'])) {
			return [
				'status'  => 'error',
				'message' => 'This is not a valid email address.'
			];
		}

		if(!Validator::minLength($user['password'], 7)) {
			return [
				'status'  => 'error',
				'message' => 'Password is too short.'
			];
		}

		$foundUser = $this->entityManager->getRepository('App\Entity\User')->findOneByEmail($user['email']);
	
		$match = password_verify($user['password'], $foundUser->getPassword());

		if(!$match) {
			return [
				'status'  => 'error',
				'message' => 'Details are incorrect.'
			];
		}

		Session::login([
			'email' => $user['email']
		]);
		
		return true;
	}

	public function logout()
	{
		return Session::logout();
	}
}