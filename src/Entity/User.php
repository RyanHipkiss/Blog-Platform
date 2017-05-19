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

	/**
	 * @ManyToMany(targetEntity="Role", inversedBy="users")
	 * @JoinTable(name="user_to_roles")
	 **/	
	protected $roles;

	public function __construct($email, $password)
	{
		$this->setEmail($email);
		$this->setPassword($password);
		$this->roles = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	public function getId()
	{
		return $this->id;
	}

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
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = password_hash($password, PASSWORD_BCRYPT);
	}

	public function addRole(Role $role)
	{
		$role->addUser($this);
		$this->roles[] = $role;
	}

	public function getRoles()
	{
		return $this->roles;
	}
}