<?php

return [
	'app' => [
		'environment' => 'dev',
		'log_send_mail' => true
	],

	'database' => [
		'driver' => 'pdo_mysql',
		'host'   => '127.0.0.1',
		'name'   => 'scotchbox',
		'user'   => 'root',
		'pass'   => 'root'
	],

	'recaptcha' => [
		'siteKey'   => '',
		'secretKey' => ''
	],
];