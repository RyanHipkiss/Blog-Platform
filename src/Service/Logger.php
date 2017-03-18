<?php

namespace App\SErvice;

class Logger 
{
	const FILE = __DIR__ . '/../../logs/error.log';
	public static function send($error)
	{
		$error = date('[jS M Y - H:i:s]') . ' ' . $error;
		error_log($error . PHP_EOL, 3, self::FILE);
	}

	public static function all()
	{
		return file_get_contents(self::FILE);
	}
}