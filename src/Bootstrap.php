<?php

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \App\Service\TemplateEngine;
use \Whoops\Handler\Handler;

class Bootstrap
{

	private $config = [];
	private $builder;
	private $router;

	function __construct()
	{
		$this->config = require_once __DIR__ . '/../config/app.php';

		$this->errorHandling();
	}

	public function getEntityManager()
	{
		$config  = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src"), true);

		$connection = array(
		  'driver' => $this->config['database']['driver'],
		  'host'   => $this->config['database']['host'],
		  'dbname' => $this->config['database']['name'],
		  'user'   => $this->config['database']['user'],
		  'password' => $this->config['database']['pass'],
		);

		return EntityManager::create($connection, $config);
	}

	public function build()
	{
		$this->builder = new \DI\ContainerBuilder;
		$this->builder->addDefinitions(
			[
				'response' => \DI\object(\Zend\Diactoros\Response::class),

		        'request' => function () {
		            return \Zend\Diactoros\ServerRequestFactory::fromGlobals(
		                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES

				    );
		        },

		        'emitter' => \DI\object(\Zend\Diactoros\Response\SapiEmitter::class),

		        \Doctrine\ORM\EntityManager::class => function() {
		            return $this->getEntityManager();
		        },

		        \App\FactoryInterface\UserFactoryInterface::class => \DI\object(\App\Factory\UserFactory::class),
				\App\FactoryInterface\RoleFactoryInterface::class => \DI\object(\App\Factory\RoleFactory::class),
			]
		);

		return $this->builder->build();
	}

	private function errorHandling()
	{
		$error = new \Whoops\Run;

		if('dev' == $this->config['app']['environment']) {
			$error->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		} else {
			$error->pushHandler(function($exception, $inspector, $run) {
				echo TemplateEngine::render('error.html', [
					'message' => 'Whoops! An error has occured.',
					'code'    => $exception->getStatusCode()
				]);

				return Handler::DONE;
			});
		}

		return $error->register();
	}
}
