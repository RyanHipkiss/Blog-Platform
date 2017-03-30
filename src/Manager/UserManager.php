<?php

namespace App\Manager;

use App\EntityInterface\UserInterface;
use App\FactoryInterface\UserFactoryInterface;
use App\Service\Validator;
use App\Service\Session;

class UserManager 
{
	const MIN_PASSWORD_LENGTH = 7;
	const MAX_PASSWORD_LENGTH = 26;

	protected $userEntityRepository;
	protected $userFactory;

	public function __construct(
		UserInterface $userEntityRepository,
		UserFactoryInterface $userFactory
	) {
		$this->userEntityRepository = $userEntityRepository;
		$this->userFactory = $userFactory;
	}

	public function register(array $user)
	{
		if(!Validator::email($user['email'])) {
			return [
				'status'  => 'error',
				'message' => 'This is not a valid email address.'
			];
		}

		if(
			!Validator::minLength($user['password'], self::MIN_PASSWORD_LENGTH) || 
			!Validator::maxLength($user['password'], self::MAX_PASSWORD_LENGTH)
		) {
			return [
				'status'  => 'error',
				'message' => 'Password needs to be between ' . self::MIN_PASSWORD_LENGTH . ' and ' . self::MAX_PASSWORD_LENGTH
			];
		}

		$user = $this->userFactory->create($user);

		if(false === $user) {
			return [
				'status'  => 'error',
				'message' => 'There was an error creating your account.'
			];
		}

		return [
			'status'  => 'success',
			'message' => 'Account created succesfully.'
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

		$password = $this->userEntityRepository->getPasswordByEmail($user['email']);

		$match = password_verify($user['password'], $password);

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
}