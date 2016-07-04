<?php

namespace logger\models;

use common\Db;
use logger\components\LoggerAbstract;


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
     * Destroys Db connection 
     */
    public function __destruct()
    {
        unset($this->_dbh);
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