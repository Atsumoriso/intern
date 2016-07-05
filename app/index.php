<?php

use models\User;
use components\Database;
use modules\logger\models\LoggerToDb;
use modules\logger\models\LoggerToFileSystem;

include_once __DIR__ . '/Autoloader.php';

$autoloader = new Autoloader();
$autoloader->register();

$db = Database::getInstance();
$dbConnection = $db->getDbConnection();

$loggerDb = new LoggerToDb($dbConnection);
$loggerDb->error('haha');
$loggerFile = new LoggerToFileSystem();
$loggerFile->error('Error occured');

$user = new User($dbConnection);
$user->load(3);
//$user->delete(); //deleting record


echo $user->getId();
echo $user->getFirstname();
echo $user->getLastname();
echo $user->getEmail();
echo $user->setReloadAclFlag(4);
echo $user->setApiKey('2376gsjhef634');
echo $user->setLastname('Brown');
echo $user->setFirstname('Leo');
$user->save(); //update record

$user2 = new User($dbConnection);

echo $user2->getId(); // ''
$user2->setApiKey('1222sdrg');
$user2->setReloadAclFlag(4);
$user2->setLastname('Yanukovich');

$user2->save(); //saving new record

$user3 = new User($dbConnection);
$user3->load(32);
$user3->setApiKey(13);
$user3->save();

var_dump($user);
var_dump($user2);
var_dump($user3);

unset($db);
