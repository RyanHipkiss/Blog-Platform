<?php

require_once 'vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\Bootstrap;

$app = new Bootstrap;

return ConsoleRunner::createHelperSet($app->getEntityManager());