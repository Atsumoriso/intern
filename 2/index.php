<?php
//
use entity\User;
//
include_once __DIR__ . '/Autoloader.php';
////$config = require __DIR__ . '/config/config.php';
$autoloader = new Autoloader();
$autoloader->register();



$user3 = new User();
var_dump($user3); //пустой объект

echo '3333  AFTER=================================';
//$user3->__call('setLastname', 'Ivan');

//$user3->load(9);
$user3->setLastname('Ivanov');
//$user3->setFirstname('Petya');
//echo $user3->getFirstname();
$user3->save();
var_dump($user3);
var_dump($user3->_createNewRow());
var_dump($user3->_loadAttrubitesDataFromDB(9));






//$user3->delete();
//echo $user3->getId();//несуществующая запись



