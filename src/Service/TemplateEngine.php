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

		$functions = $this->getFunctions();

		if(!empty($functions)) {
			foreach($functions as $function) {
				$this->engine->addFunction($function);
			}
		}
	}

	private function getFunctions()
	{
		return [
			new \Twig_SimpleFunction('asset', function($string) {
				return '/assets/' . $string;
			})
		];
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