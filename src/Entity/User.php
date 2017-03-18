<?php

namespace App\Entity;

/**
 * @Entity
 **/

class User 
{

	/**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue(strategy="AUTO")
	 **/
	protected $id;

	/**
	 * @Column(type="string", length=255, unique=true, nullable=false)
	 **/
	protected $email;

	/**
	 * @Column(type="string", length=255, nullable=false)
	 **/
	protected $password;
		

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getPassword()
	{
		return $this->getPassword();
	}

	public function setPassword($password)
	{
		$this->password = password_hash($password, PASSWORD_BCRYPT);
	}
}