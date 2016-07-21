<?php

namespace components;

/**
 * Class Db - common class to work with Database.
 *
 */
class Database
{
    /* dbname & host for Db connection*/
    private $_dsn;

    /* user for Db connection*/
    private $_user;

    /* user password for Db connection*/
    private $_password;

    /* PDO connection to Db */
    private $_connection;

    /* Instance of the class */
    private static $_instance;

    /**
     * Db constructor.
     *
     * Initialazes variables for Db connection and establishes Db connection.
     * @return void
     */
    private function __construct()
    {
        $this->_dsn =  'mysql:dbname='
            . $this->_getDbConfig()['dbName']
            . ';host='
            . $this->_getDbConfig()['host'];
        $this->_user = $this->_getDbConfig()['user'];
        $this->_password = $this->_getDbConfig()['password'];

        $this->_connection = new \PDO($this->_dsn, $this->_user, $this->_password);
    }

    /**
     * Gets an instance of Database - \PDO Object, if instance is null
     *
     * @return null|\PDO        - \PDO Object
     */
    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Establishes connection with Database.
     *
     * @return \PDO      -  PDO Object
     */
    public function getDbConnection(){
        return $this->_connection;
    }

    /**
     * Gets config data to connect to Db
     * @return mixed
     */
    private function _getDbConfig(){
        return $configDb = require __DIR__ . '/../../app/config/db.php';
    }

    private function _clone()
    {
    }

    private function _wakeup()
    {
        throw \Exception("Action is not allowed");
    }
}