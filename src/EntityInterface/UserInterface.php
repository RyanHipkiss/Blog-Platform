<?php

namespace App\EntityInterface;

interface UserInterface {
	public function findByEmail($email);
}