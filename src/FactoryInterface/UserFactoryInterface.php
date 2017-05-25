<?php

namespace App\FactoryInterface;

interface UserFactoryInterface {
	public function create(array $user);
	public function update(array $user, $id);
	public function delete($id);
}