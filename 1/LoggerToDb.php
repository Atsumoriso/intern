<?php

include_once __DIR__ . '/LoggerAbstract.php';
include_once __DIR__ . '/Db.php';

/**
 * Class LoggerToDb
 *
 * Writes log messages to Db
 *
 */
class LoggerToDb extends LoggerAbstract
{
    /*Connection to Db*/
    private $_dbh;

    /**
     * LoggerToDb constructor.
     * Establishing Db connection
     */
    public function __construct()
    {
        $connection = new Db();
        $this->_dbh = $connection->connectToDb();
    }

    /**
     * Writes log data to Db
     * @param $logMessage
     * @param $logType
     */
    protected function _writeLogData($logMessage, $logType)
    {
        $statement = $this->_dbh->prepare("
            INSERT 
            INTO `log` (
                 `message`, 
                 `type`, 
                 `creation_date`
                 ) 
            VALUES (?, ?, ?)
            ");
        $statement->execute([$logMessage, $logType, date('Y-m-d H:i:s')]);
    }
}