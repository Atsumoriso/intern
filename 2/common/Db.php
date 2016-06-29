<?php


namespace common;


/**
 * Class Db - common class to work with Database
 *
 */
class Db
{
    /* dbname & host for Db connection*/
    private $_dsn;

    /* user for Db connection*/
    private $_user;

    /* user password for Db connection*/
    private $_password;

    /* PDO connection to Db */
    private $_dbh;

    /**
     * Db constructor.
     * Initialazes variables for Db connection
     */
    public function __construct()
    {
        $this->_dsn =  'mysql:dbname='
            . $this->_getDbConfig()['dbName']
            . ';host='
            . $this->_getDbConfig()['host'];
        $this->_user = $this->_getDbConfig()['user'];
        $this->_password = $this->_getDbConfig()['password'];
    }


    /**
     * Establishes connection with Database
     * @param $dsn
     * @param $user
     * @param $password
     * @return PDO
     */
    public function connectToDb(){
        return $this->_dbh = new \PDO($this->_dsn, $this->_user, $this->_password);
    }

    /**
     * Gets config data to connect to Db
     * @return mixed
     */
    private function _getDbConfig(){
        return $configDb = require __DIR__ . '/../../1/config/configDb.php';
    }

}