<?php

namespace App\Service;

class Session {

	public static function login(array $user)
	{
		$_SESSION['user'] = $user;
	}

	public static function logout()
	{
		unset($_SESSION['user']);
	}

	public static function user()
	{
		if(!isset($_SESSION['user'])) {
			return [];
		}
		
		return array_shift($_SESSION['user']);
	}

	public static function generateCsrf()
	{
		if(!empty($_SESSION['token'])) {
			return $_SESSION['token'];
		}

		if(function_exists('mcrypt_create_iv')) {
			$_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		} else {
			$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
		}

		return $_SESSION['token'];
	}

	public static function verifyCsrf($token)
	{
		return hash_equals($_SESSION['token'], $token);
	}

	public static function getNotify()
	{
		return (isset($_SESSION['notify'])) ? $_SESSION['notify'] : [];
	}

	public static function setNotify(array $data)
	{
		$_SESSION['notify'] = $data;
	}
}
