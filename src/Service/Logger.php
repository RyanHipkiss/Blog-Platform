<?php

namespace App\SErvice;

class Logger 
{

	public static function send($error)
	{
		die($error);
	}
}