<?php

return [
	'app' => [
		'environment' => 'dev',
		'log_send_mail' => true
	],

	'database' => [
		'driver' => 'pdo_mysql',
		'host'   => '192.168.1.220',
		'name'   => 'testing',
		'user'   => 'wmm',
		'pass'   => 'wmmuser589'
	],

	'recaptcha' => [
		'siteKey'   => '',
		'secretKey' => ''
	],
];
