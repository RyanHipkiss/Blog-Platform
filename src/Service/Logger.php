<?php

namespace App\SErvice;

class Logger 
{
	private static $file = 'error.log';

	public static function send($error)
	{
		$error = date('[jS M Y - H:i:s]') . ' ' . $error;
		error_log($error . PHP_EOL, 3, self::getFile());
	}

	public static function all()
	{
		return file_get_contents(self::getFile());
	}

	private static function getFile()
	{
		return __DIR__ . '/../../logs/' . self::$file;
	}
}