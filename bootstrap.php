<?php

require __DIR__ . '/vendor/autoload.php';

session_start();

$app = new App\Bootstrap;
$container = $app->build();
