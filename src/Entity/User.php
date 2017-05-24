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

	public function setId($id)
	{
		$this->id = $id;
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
		if($this->roles->contains($role)) {
			return;
		}

		$this->roles->add($role);
		$role->addUser($this);
	}

	public function removeRole(Role $role) 
	{
		if(!$this->roles->contains($role)) {
			return;
		}

		$this->roles->removeElement($role);
		$role->removeUser($this);
	}

	public function getRoles()
	{
		return $this->roles;
	}
}