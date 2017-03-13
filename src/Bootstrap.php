<?php

namespace App;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Bootstrap {
	
	private $config = [];
	private $builder;

	function __construct()
	{
		$this->config = require_once __DIR__ . '/../config/app.php';
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

		        \App\EntityInterface\UserInterface::class => \DI\object(\App\EntityRepository\UserRepository::class),

		        \App\FactoryInterface\UserFactoryInterface::class => \DI\object(\App\Factory\UserFactory::class),
			]
		);

		return $this->builder->build();
	}
}