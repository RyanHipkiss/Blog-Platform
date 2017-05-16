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
			}),
			new \Twig_SimpleFunction('route', function($string, array $arguments = null) {
				return \App\Service\Router::getUriFromName($string, $arguments);
			}),
			new \Twig_SimpleFunction('csrf', function() {
				return \App\Service\Session::generateCsrf();
			}),
			new \Twig_SimpleFunction('recaptcha', function() {
				return \App\Service\Recaptcha::getSiteKey();
			}),
			new \Twig_SimpleFunction('auth', function() {
				return (!empty(\App\Service\Session::user()));
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
