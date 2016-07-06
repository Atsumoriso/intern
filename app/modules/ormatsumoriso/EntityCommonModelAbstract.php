<?php

namespace modules\ormatsumoriso;

use modules\ormatsumoriso\components\EntityInterface;
use modules\ormatsumoriso\components\FindAllInterface;

/**
 * Class EntityCommonModelAbstract.
 * Abstract class to work with models - DB Entities.
 *
 * @package entity\common
 */
abstract class EntityCommonModelAbstract
    implements EntityInterface,
               FindAllInterface
{
    /**
     * Name of the table.
     *
     * @var string
     */
    protected $_tableName;

    /**
     * 'Id' identifier of the table, for example 'user_id', 'product_id'
     * Generated automatically when table name is set for the table.
     *
     * @var string
     */
    protected $_idIdentifier;

    /**
     * Table column values.
     * Generated automatically when table name is set for the table.
     *
     * @var array
     */
    protected $_tableColumns = [];

    /**
     * Object Properties
     *
     * @var array
     */
    protected $_properties = [];

    /**
     * Data received from set methods.
     * Temporary array, keeps data before save() method calls. When save() method called, data is saved to Db
     * and to object properties and finally removed from this array
     *
     * @var array
     */
    protected $_propertiesFromSetter = [];

    /* Connection to Db */
    protected $_connection;
    
    /**
     * EntityCommonModelAbstract constructor.
     * If tableName is set when creating Model for Db Table, attributes of this table will be automatically initialized.
     *
     * @param $dbConnection
     * @return void
     */
    public function __construct($dbConnection)
    {
        $this->_connection = $dbConnection;
        $this->_tableName   = $this->getTableName();
        $this->_idIdentifier = $this->getIdIdentifier();
        $this->_tableColumns = $this->getTableColumns();
    }


    /**
     * Gets name of the table, to which this Class belongs to.
     * SHOULD BE SET BY CHILD CLASS.
     * You need to set tableName attribute when creating class for your table.
     *
     * @return mixed
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * Gets unique 'id' identifier, i.e. primary key.
     *
     * @return mixed
     */
    public function getIdIdentifier()
    {
        $sql = "SHOW COLUMNS FROM " . $this->getTableName() . " WHERE `key`='pri'";
        $stmt = $this->_connection->prepare($sql);
        $stmt->execute();
        $res  = $stmt->fetch(\PDO::FETCH_COLUMN);
        return $res;
    }


    /**
     * Represents an array of Table column values.
     * In order to get attributes' values, you need to set value of the tableName.
     *
     * @return array   = names of table columns.
     */
    public function getTableColumns()
    {
        $sql  = 'SHOW FIELDS FROM ' . $this->getTableName();
        $stmt = $this->_connection->prepare($sql);
        $stmt->execute();
        $res  = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $res;
    }

    /**
     * @inheritdoc
     *
     */
    public function load($id = null)
    {
        if($id != null && $this->_loadDataFromDB($id) != false){
            $this->_properties = $this->_loadDataFromDB($id);
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
       return $this->_getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        $this->_deleteRow();
    }


    /**
     * @inheritdoc
     */
    public function save()
    {
        $this->_checkData();
    }

    /**
     * @inheritdoc
     */
    public function findAll()
    {
        $query = '
            SELECT * 
            FROM '
            . $this->getTableName() ;

        $stmt = $this->_connection->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_OBJ); //массив объектов
        return $res;
    }

    /**
     * Checks function names (getters and setters), and compares with table columns names. If such property exist,
     * adds it (setter) or returns (getter).
     * Substitues usual getters and setters (I hope).
     *
     * @param $getterSetterName
     * @param $propertyValue
     * @return mixed
     */
    public function __call($getterSetterName, $propertyValue)
    {

        if(substr($getterSetterName,0,3) == 'set'){
            $setterName = $this->_processStringValue($getterSetterName);

            // if value is in array of table columns and not equal to Id indentifier
            // adds to propertiesFromSetter array
            if(in_array($setterName, $this->getTableColumns()) 
                && $setterName != $this->getIdIdentifier()){

                $this->_propertiesFromSetter[$setterName] = $propertyValue[0];
            }

        }  elseif(substr($getterSetterName,0,3) == 'get') {

            $getterName = $this->_processStringValue($getterSetterName);
            if(in_array($getterName, $this->getTableColumns())
                && isset($this->_properties[$getterName])){
                return $this->_properties[$getterName];
            }
        }
    }

    /**
     * Deletes first 3 letters (get or set), converts CamelCase to underscore.
     *
     * @param $string - 'string' value to change
     * @return string - changed value
     */
    protected function _processStringValue($string)
    {
        $setterName = substr($string,3);
        //convert CamelCase to underline
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $setterName)), '_'); //$0 matched text
    }

    /**
     * Loads data from Db.
     *
     * @param $id            'id' of the Db record
     * @return mixed         array of data
     */
    protected function _loadDataFromDB($id)
    {
        $query = '
            SELECT * 
            FROM '
            . $this->getTableName() . '
            WHERE '
            . $this->getIdIdentifier() . " =  
            :id ";

        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $res = $stmt->fetch(\PDO::FETCH_ASSOC); //array key-value
        return $res;
    }


    /**
     * Checks if id is set or not.
     * If set - calls update mathod, if not - calls create method.
     *
     * @return void
     */
    protected function _checkData()
    {
        if(empty($this->getId()) || $this->getId() == null){
            $this->_createNewRecord();
            //get last inserted id and add to properties
            $this->_properties[$this->getIdIdentifier()] = $this->_connection->lastInsertId();
            // add new properies (from set methods)
            $this->_properties = array_replace($this->_properties, $this->_propertiesFromSetter);
            // unset properties From Setters array
            $this->_propertiesFromSetter = [];
        } else {
            $this->_updateRecord();
            $this->_properties = array_replace($this->_properties, $this->_propertiesFromSetter);
            $this->_propertiesFromSetter = [];
        }
    }


    /**
     * Creates new record.
     *
     * @return void
     */
    protected function _createNewRecord()
    {
        $dataToInsert = $this->_propertiesFromSetter;
        $query = "
            INSERT INTO  `"
            . $this->getTableName() . "` ("
            . implode(
                ", ",
                array_keys(
                    $dataToInsert
                ))
            . ")  
            VALUES  ("
            . implode(
                ",",
                array_fill(
                    1, //start index
                    count($dataToInsert),
                    '?'
                )
            ) . ")";

        $stmt = $this->_connection->prepare($query);

        $counter = 1;
        foreach ($dataToInsert as $value){
            $stmt->bindValue($counter++, $value);
        }

        $stmt->execute();
    }


    /**
     * Updates existing record in the Database.
     *
     * @return void
     */
    protected function _updateRecord()
    {
        $dataToInsert = $this->_propertiesFromSetter;
        $query = "
            UPDATE "
            . $this->getTableName() . "
            SET "
            . implode(
                ", ", 
                array_map(function ($key) {
                        return $key . " = ? ";
                    },
                    array_keys($dataToInsert)
                )
            ) . "
             WHERE "
            . $this->getIdIdentifier() . " = "
            . $this->getId();

        $stmt = $this->_connection->prepare($query);

        $counter = 1;
        foreach ($dataToInsert as $value){
            $stmt->bindValue($counter++, $value);
        }
        $stmt->execute();
    }

    /**
     * Checks if id exists.
     *
     * @return null | 'id'        - null or id value
     */
    protected function _getPrimaryKey()
    {
        $id = $this->getIdIdentifier();
        if(!empty($this->_properties) && isset($this->_properties[$id]) ){
            $a = $this->_properties[$id];
            return $a;
        }
    }

    /**
     * If id is set, calls delete record method and unsets Object.
     *
     * @return void
     */
    protected function _deleteRow()
    {
        $id = $this->getId();
        if(isset($id)){
            $this->_deleteRowQuery($this->getId());
            //unset($this);
            $this->_properties = [];
            $this->_connection = null;
        }
    }

    /**
     * Deleting record from Database.
     *
     * @param $id   = id of the record to delete.
     * @return void
     */
    protected function _deleteRowQuery($id)
    {
        $query = '
            DELETE 
            FROM '
            . $this->getTableName() . '
            WHERE '
            . $this->getIdIdentifier() . ' = 
            :id ' ;
        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
    }

}