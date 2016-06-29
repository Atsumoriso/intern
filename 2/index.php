<?php

use ormatsumoriso\models\User;

include_once __DIR__ . '/Autoloader.php';
//$config = require __DIR__ . '/config/config.php';
$autoloader = new Autoloader();
$autoloader->register();

$user = new User;

//$res = $user->findAll();
$res = $user->findById('2; drop table test1;');



var_dump($res);

