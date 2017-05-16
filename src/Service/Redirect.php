<?php

namespace App\Service;

use App\Service\Session;
use App\Service\Router;

class Redirect {
	
	public static function to($url)
	{
		header('Location: ' . $url);
		exit;
	}

	public static function route($name, array $arguments = null , array $notifyData = null) 
	{
		$route = Router::getUriFromName($name, $arguments);

		if(!empty($notifyData)) {
			Session::setNotify($notifyData);
		}

		self::to($route);
	}
}