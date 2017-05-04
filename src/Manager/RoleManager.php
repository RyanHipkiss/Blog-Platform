<?php

namespace App\Manager;

use Doctrine\ORM\EntityManager;
use App\FactoryInterface\RoleFactoryInterface;
use App\Service\Validator;

class RoleManager 
{
	protected $entityManager;
	protected $roleFactory; 

    public function __construct(
        EntityManager $entityManager,
        RoleFactoryInterface $roleFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->roleFactory   = $roleFactory;
    }

    public function findAll()
    {
         return $this->entityManager->getRepository('App\Entity\Role')->findAll();
    }

    public function findById($id)
    {
        return $this->entityManager->getRepository('App\Entity\Role')->findOneById($id);
    }

    public function save(array $input, $roleID)
    {
        if(!Validator::minLength($input['name'], 1)) {
            return [
                'status'  => 'error',
                'message' => 'Please input a name for the role.'
            ];
        }

        if(empty($roleID)) {
            return $this->roleFactory->create($input);
        }

        return $this->roleFactory->update($input, $roleID);
    }
}