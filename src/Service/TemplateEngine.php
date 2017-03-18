<?php

namespace App\Service;

class TemplateEngine
{
	private $engine;

	private function __construct()
	{
		$twig = new \Twig_Loader_Filesystem(__DIR__.'/../../views');
		$twig = new \Twig_Environment($twig, [
			'cache' => false
		]);
		
		$this->engine = $twig;
	}

	private function getEngine()
	{
		return $this->engine;
	}

	public static function render($template, array $viewData = [])
	{
		$engine = new static();
		return $engine->getEngine()->render($template, $viewData);
	}
}