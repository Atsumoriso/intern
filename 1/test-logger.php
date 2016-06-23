<?php
include_once __DIR__ . '/LoggerToDb.php';
include_once __DIR__ . '/LoggerToFileSystem.php';
include_once __DIR__ . '/LogEntry.php';
$config = require __DIR__ . '/config/config.php';



$loggerToFileSystem = new LoggerToFileSystem();
$loggerToDb = new LoggerToDb();

//if DEV mode, write all logs
if ($config['mode'] == LogEntry::MODE_DEV){

    //writing logs to log file
    $loggerToFileSystem->warning('Achtung! Warning!');
    $loggerToFileSystem->notice('Achtung! Notice!');
    $loggerToFileSystem->error('Achtung! Error!');

    //writing logs to Db
    $loggerToDb->error('Error occured');
    $loggerToDb->warning('Warning');
    $loggerToDb->notice('This is Notice');


} //if PROD mode, writing error logs only
elseif ($config['mode'] == LogEntry::MODE_PROD) {
    $loggerToFileSystem->error('Achtung, please! Warning!');
    $loggerToDb->error('Error occured');
}

