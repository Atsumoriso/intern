<?php

use core\Autoloader;
use core\Router;

include_once __DIR__ . '/core/Autoloader.php';

$configMain = include_once __DIR__ . '/config/main.php';

define('SITE_URL',$configMain['local_site']);

$autoloader = new Autoloader();
$autoloader->register();

$router = new Router();
$router->run();


