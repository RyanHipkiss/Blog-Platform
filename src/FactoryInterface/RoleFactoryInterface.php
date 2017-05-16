<?php

namespace App\FactoryInterface;

interface RoleFactoryInterface {
    public function create(array $input);
    public function update(array $input, $roleID);
    public function delete($id);
}