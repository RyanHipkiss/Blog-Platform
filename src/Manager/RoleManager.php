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

    public function findByName($name)
    {
        return $this->entityManager->getRepository('App\Entity\Role')->findOneByName($name);
    }

    public function save(array $input, $roleID = null)
    {
        if(!Validator::minLength($input['name'], 1)) {
            return [
                'status'  => 'error',
                'message' => 'Please input a name for the role.'
            ];
        }

        if(empty($roleID)) {
            $created = $this->roleFactory->create($input);

            if($created) {
                return [
                    'status'  => 'success',
                    'message' => 'Role created successfully',
                    'id' => $this->findByName($input['name'])->getId()
                ];
            }

            return [
                'status'  => 'error',
                'message' => 'Error creating role.'
            ];
        }

        $updated = $this->roleFactory->update($input, $roleID);

        if($updated) {
            return [
                'status'  => 'success',
                'message' => 'Role updated successfully',
                'id' => $this->findByName($input['name'])->getId()
            ];
        }

        return [
            'status'  => 'error',
            'message' => 'Error updating role.'
        ];
    }

    public function delete($id) {
        $deleted = $this->roleFactory->delete($id);

        if(!$deleted) {
            return [
                'status'  => 'error',
                'message' => 'Sorry, there was an error deleting your role.'
            ];
        }

        return [
            'status'  => 'success',
            'message' => 'Role deleted successfully'
        ];
    }
}