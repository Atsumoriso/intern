<?php
include_once 'LoggerToDb.php';
include_once 'LoggerToFileSystem.php';

//$loggerToDb = new LoggerToDb();
//$loggerToDb->notice('notice error');

$loggerToFileSystem = new LoggerToFileSystem();
$loggerToFileSystem->warning('Achtung! Warning!');