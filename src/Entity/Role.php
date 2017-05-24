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

    public function __construct($name)
    {
        $this->setName($name);
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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
        if($this->users->contains($user)) {
            return;
        }

        $this->users->add($user);
        $user->addRole($this);
    }

    public function removeUser(User $user)
    {
        if(!$this->users->contains($user)) {
            return;
        }

        $this->users->removeElement($user);
        $user->removeRole($this);
    }

    public function getUsers()
    {
        return $this->users;
    }
}