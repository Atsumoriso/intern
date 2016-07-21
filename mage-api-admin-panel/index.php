<?php

use core\Autoloader;

include_once __DIR__ . '/core/Autoloader.php';

$configMain = include_once __DIR__ . '/config/main.php';

define('SITE_URL',$configMain['local_site']);

$autoloader = new Autoloader();
$autoloader->register();

$router = new \core\Router();
$router->run();


