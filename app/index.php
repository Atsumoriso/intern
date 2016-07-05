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

//$loggerDb = new LoggerToDb($dbConnection);
//$loggerDb->error('haha');
//$loggerFile = new LoggerToFileSystem();
//$loggerFile->error('Error occured');

$user = new User($dbConnection);
$user->load(3);
//$user->delete(); //deleting record


echo $user->getId();
echo $user->getFirstname();
echo $user->getLastname();
echo $user->getEmail();

$user->setReloadAclFlag(4);
$user->setApiKey('2376gsjhef634');
$user->setLastname('Brown');
$user->setFirstname('Leo');
//$user->save(); //update record

$user2 = new User($dbConnection);

echo $user2->getId(); // ''
$user2->setApiKey('1222sdrg');
$user2->setReloadAclFlag(4);
$user2->setLastname('Yanukovich');

//$user2->save(); //saving new record

$user3 = new User($dbConnection);
$user3->load(32);
$user3->setApiKey(13);
//$user3->save();
//var_dump($user);
//var_dump($user2);
//var_dump($user3);
//===================================

$user6 = new User($dbConnection);

$user6->load();      // no required parameter
$user6->load(10500); //record does not exist
$user6->load(15);
echo $user6->getId();
$user6->setLastname('Grey');
$user6->setFirstname('Leo');
$user6->save();
//$user6->delete();
//$user6->load(32);
var_dump($user6);

//$product = new \models\Product($dbConnection);
//var_dump($product);
////$product->setName('pants');
////$product->setCategoryId(2);
////$product->save();
//$product->load(1);
//var_dump($product);

$user123 = new User($dbConnection);
$allUsers = $user123->findById(120);
var_dump($allUsers);
unset($db);
