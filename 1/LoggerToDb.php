<?php

include_once 'LoggerInterface.php';

class LoggerToDb implements LoggerInterface
{
//    public $warningMessage = 'Warning!';
//    public $errorMessage   = 'Error!';
//    public $noticeMessage  = 'Notice!';

//    public function __construct($message){
//        $this->message = $message;
//    }

    public function warning($message){
        $dbh = $this->connectToDb();


        $statement = $dbh->prepare("INSERT INTO `log` (`message`, `type`, `creation_date`) values (?, ?, ?)");
        $inserted = $statement->execute([$message, 'warning', date('Y-m-d H:i:s')]);
        //todo вместо warning лучше просто 1-2-3 указать

        print("$inserted lines added.\n");
    }

    public function error($message){
        $dbh = $this->connectToDb();

        $statement = $dbh->prepare("INSERT INTO `log` (`message`, `type`, `creation_date`) values (?, ?, ?)");
        $inserted = $statement->execute([$message, 'error', date('Y-m-d H:i:s')]);

        print("$inserted lines added.\n");
    }

    public function notice($message){
        $dbh = $this->connectToDb();

        $statement = $dbh->prepare("INSERT INTO `log` (`message`, `type`, `creation_date`) values (?, ?, ?)");
        $inserted = $statement->execute([$message, 'notice', date('Y-m-d H:i:s')]);

        print("$inserted lines added.\n");
    }

    private function connectToDb(){
        $dsn = 'mysql:dbname=test;host=127.0.0.1';
        $user = 'root';
        $password = '';

        $dbh = new PDO($dsn, $user, $password);
        return $dbh;
    }

}