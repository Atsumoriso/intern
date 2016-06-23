<?php

include_once 'LoggerAbstract.php';

class LoggerToFileSystem extends LoggerAbstract
{
    /**
     * Writing data to Log file
     * @param $logMessage
     * @param $logType
     */
    protected function _writeLogData($logMessage, $logType)
    {
        $message = $this->_getLogMessage($logMessage, $logType);
        file_put_contents($this->_getLogFilePath(),$message."\n",FILE_APPEND);
    }

    /**
     * States format of message
     * @param $logMessage
     * @param $logType
     * @return string
     */
    protected function _getLogMessage($logMessage, $logType)
    {
        return date('Y-m-d H:i:s') . ' - ' . $logType . ' - ' . $logMessage;
    }

    /**
     * Gets log File path
     * @return mixed
     */
    private function _getLogFilePath(){
        $config = require __DIR__ . '/config.php';
        return $config['pathToLogFile'];
    }
    
}