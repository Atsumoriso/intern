<?php
//
use models\User;
use components\Database;
use components\Autoloader;

include_once __DIR__ . '/components/Autoloader.php';

$autoloader = new Autoloader();
$autoloader->register();

$db = Database::getInstance();
$dbConnection = $db->getDbConnection();

$user1 = new User($dbConnection);
$user5 = new User($dbConnection);
$user6 = new User($dbConnection);
$user7 = new User($dbConnection);
var_dump($user6); //пустой объект

$user6->load(15);

echo "<br>";
echo $user5->getId();
echo $user5->getFirstname();
echo $user5->getLastname();
echo $user5->getEmail();
$user6->load(12);
$user7->load(10);
echo $user6->getFirstname();
echo $user6->getLastname();
echo $user6->getEmail();


echo "<br>";

$user6->setLastname('Vr');
$user6->setFirstname('Loooo');
$user6->setEmail('ber@test.ru');

$user6->save();


echo '3333  DO=================================';
var_dump($user6);
//$user3->delete();
//unset($user3);
//$user3->load(23);


echo '3333  AFTER=================================';
//$user3->__call('setLastname', 'Ivan');


//$user3->setLastname('Creigh');
//$user3->setFirstname('Dick');
//$user3->setEmail('dddddiiick@test.ru');
//
//$user3->save();
////echo $user3->getFirstname();
//$user3->save();
//$user3->delete();
//$user3->load(17);
//var_dump($user3);
//$user3->load(5);
var_dump($user6);
//var_dump($user3->_createNewRow());
//var_dump($user3->_loadAttrubitesDataFromDB(9));







//$user3->delete();
//echo $user3->getId();//несуществующая запись



