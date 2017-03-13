<?php

namespace App\Service;

class Validator {

	public static function email($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function minLength($string, $length)
	{
		return (strlen($string) >= $length);
	}

	public static function maxLength($string, $length)
	{
		return (strlen($string) <= $length);
	}
}