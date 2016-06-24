<?php

namespace logger\components;

/**
 * Class LoggerAbstract
 * Abstract class for Loggers
 * Declares abstract method for writing log data to Db
 */
Abstract class LoggerAbstract implements LoggerInterface
{
    /**
     * Writes warning to Db
     * @param $message
     */
    public function warning($message){
        $this->_writeLogData($message, LogEntry::TYPE_WARNING);
    }

    /**
     * Writes ERROR to DB
     * @param $message
     */
    public function error($message){
        $this->_writeLogData($message, LogEntry::TYPE_ERROR);
    }

    /**
     * Writes NOTICE to Db
     * @param $message
     */
    public function notice($message){
        $this->_writeLogData($message, LogEntry::TYPE_NOTICE);
    }

    /**
     * Stands for writing log data to Db
     * @param $logMessage
     * @param $logType
     */
    protected abstract function _writeLogData($logMessage, $logType);
}

