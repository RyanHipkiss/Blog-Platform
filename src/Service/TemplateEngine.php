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
			new \Twig_SimpleFunction('route', function($string) {
				return \App\Service\Router::getUriFromName($string);
			}),
			new \Twig_SimpleFunction('csrf', function() {
				return \App\Service\Session::generateCsrf();
			}),
			new \Twig_SimpleFunction('recaptcha', function() {
				return \App\Service\Recaptcha::getSiteKey();
			})
		];
	}

	private function getEngine()
	{
		return $this->engine;
	}

	public static function render($response, $template, array $viewData = [])
	{
		$engine = new static();

		$response->getBody()->write(
			$engine->getEngine()->render($template, $viewData)
		);
		
		return $response;
	}
}