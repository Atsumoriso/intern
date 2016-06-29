<?php

namespace v\models;

class Query
{
    private $_dbh;

    public function __construct()
    {
        $connection = new Db();
        $this->_dbh = $connection->connectToDb();
    }

    public function __destruct()
    {
        unset($this->_dbh);
    }

    public function chooseDb($dbName)
    {
        $query = 'use  `' . $dbName .'`;';
        $stmt = $this->_dbh->prepare($query);
        $stmt->execute();
    }

    public function createNewTable($tableName)
    {
        $query = '
            CREATE 
            IF NOT EXISTS
            TABLE  `'
            . $tableName . '`;
            ';
        $stmt = $this->_dbh->prepare($query);
        $stmt->execute();
//        $res = $stmt->fetchAll();
//        //$stmt = null;
//        return $res;
    }

    public function getAllData($tableName)
    {
        $query = 'SELECT * 
            FROM '
            . $tableName ;

        $stmt = $this->_dbh->prepare($query);
        $stmt->execute();
        //$res = $stmt->fetchAll(); //массив+ по умолч. с индексами нумерованными и ассоциат
        $res = $stmt->fetchAll(PDO::FETCH_OBJ); //массив объектов

        //$stmt = null;
        return $res;
    }

    public function getColumnDataByParam($tableName, $param, $paramValue)
    {
        $query = "SELECT * 
            FROM 
            $tableName 
            WHERE $param = :paramValue";
        $stmt = $this->_dbh->prepare($query);

        //$stmt->bindParam(":tableName",$tableName);
        //$stmt->bindParam(":param",$param);
        $stmt->bindParam(":paramValue",$paramValue);

        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);

        //$stmt = null;
        return $res;
    }


    public function findAll()
    {
        ;
    }
}