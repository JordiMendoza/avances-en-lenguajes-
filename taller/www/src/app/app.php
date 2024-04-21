<?php

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../../vendor/autoload.php';


$container = new Container();

// Set container to create App with on AppFactory
AppFactory::setContainer($container);


$app = AppFactory::create();

require_once 'conexion.php';
require_once 'routes.php';
require 'config.php';

$app->run();