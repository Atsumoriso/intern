<?php

namespace ormatsumoriso\components;

use common\Db;

//use ormuniverse\components\BaseMethodInterface;

/**
 * Class OrmDbMysqlAbstract
 *
 * Allows to work with Mysql - to connect to Db
 */
abstract class OrmDbMysqlAbstract implements BaseMethodInterface
{
    /*Connection to Db*/
    protected $_dbh;

    /*Name of the table in DB*/
    protected $tableName;

    protected $columnId;

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

    public function findAll()
    {
        $query = '
            SELECT * 
            FROM '
            . $this->tableName ;

        $stmt = $this->_dbh->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_OBJ); //массив объектов

        return $res;

    }

    public function findById($id)
    {
        $id = (int)$id;
        $query = "
            SELECT *
            FROM
            $this->tableName
            WHERE  $this->columnId = $id";
//        $query = '
//            SELECT *
//            FROM '
//            . $this->tableName . '
//            WHERE $this->columnId = '
//            . $id;

        $stmt = $this->_dbh->prepare($query);
        $stmt->bindParam(":$this->columnId",$id);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_OBJ);
        //$stmt = null;
        return $res;
    }
}