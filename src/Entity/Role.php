<?php

namespace App\Entity;

/**
 * @Entity
 **/

class Role
{
    /**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue(strategy="AUTO")
	 **/
	protected $id;

    /**
     * @Column(type="string", length=255)
     **/
    protected $name;

    /**
     * @ManyToMany(targetEntity="User", mappedBy="roles")
     **/
    protected $users;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;
    }
}