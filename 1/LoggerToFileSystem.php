<?php

include_once 'LoggerInterface.php';

class LoggerToFileSystem implements LoggerInterface
{
    public $filePath = 'log.txt';
//    public $warningMessage = 'Warning!';
//    public $errorMessage   = 'Error!';
//    public $noticeMessage  = 'Notice!';

    public function warning($message){
        $message = "$message\n";
        $this->_writeLogTofile($message);
        echo "Warning added to log file successfully";
    }

    public function error($message){
        $message = "$message\n";
        $this->_writeLogTofile($message);
        echo "Error added to log file successfully";
    }

    public function notice($message){
        $message = "$message\n";
        $this->_writeLogTofile($message);
        echo "Notice added to log file successfully";
    }

    private function _writeLogTofile($message){
        file_put_contents($this->filePath,$message,FILE_APPEND);
    }

}