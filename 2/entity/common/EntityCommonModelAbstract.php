<?php

namespace entity\common;

use ormatsumoriso\components\EntityInterface;

use common\Db;

/**
 * Class EntityCommonModelAbstract.
 *
 * Abstract class to work with models - DB Entities
 *
 * @package entity\common
 */
abstract class EntityCommonModelAbstract implements EntityInterface
{
    /**
     * Name of the table.
     * You need to set tableName attribute when creating class for your table.
     * @var mixed
     */
    protected $_tableName;

    /**
     * Represents an array of Table column values.
     * @var array
     */
    protected $_attributes = [];

    /**
     * Data loaded from Db
     * @var array
     */
    protected $_attributesLoaded = [];

    //protected $_newAttributes = [];

    /* Connection to Db */
    protected $_dbh;


    /**
     * EntityCommonModelAbstract constructor.
     * If tableName is set when creating Model for Db Table, attributes of this table will automatically initialized.
     * @void
     */
    public function __construct()
    {
        $this->_tableName   = $this->getTableName();
        $this->_attributes = $this->getAttributes();
    }

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    protected function _setAttributesLoaded(Array $value)
    {
        $this->_attributesLoaded = $value;
    }

    /**
     * Represents an array of Table column values.
     * In order to get attributes' values, you need to set value of the tableName.
     * @return array
     */
    public function getAttributes()
    {
        $sql  = 'SHOW FIELDS FROM ' . $this->getTableName();
        $dbh  = $this->_establishDbConnection();
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $res  = $stmt->fetchAll(7); //array
        $stmt = null;
        $dbh  = null;
        $this->_dbh  = null;
        return $res;
    }

    public function setNewAttributes($value)
    {
        array_push($this->_newAttributes, $value);
        //$this->_newAttributes[] =  $value;
    }

    public function load($id)
    {
        $this->_loadNewPropertiesAndValues($id);
    }

    /**
     * Gets attributes values as KEYS and property values from Db as VALUES and sets correspondent properties for this object.
     * @param $id
     * @return boolean
     */
    protected function _loadNewPropertiesAndValues($id)
    {
        //записываем загруженные данные в массив
        $this->_setAttributesLoaded($this->_loadAttrubitesDataFromDB($id));
        //записываем загруженные данные в свойства объекта
        $propertyFromDbArray = $this->_loadAttrubitesDataFromDB($id);
        if(!empty($propertyFromDbArray)){
            foreach ($this->getAttributes() as $attribute) {
                $this->_setProperty($attribute,array_shift($propertyFromDbArray));
            }
        } else {
            return false;
        }

    }

    protected function _setProperty($property, $value) {
        $this->$property = $value;
    }

//    public function __set($property, $value) {
//        if(in_array($property, $this->getAttributes())){
//            $this->property = $value;
//        }
//    }

//    public function __call($functionName, $arguments)
//    {
//        $testVar = $functionName;
//        if(substr($testVar,0,3) == 'set'){
//            $functionName = substr($testVar,3);
//            $functionName = strtolower($functionName);
//            if(in_array($functionName, $this->getAttributes())){
//                foreach ($this->_newAttributes as $key=>$value){
//                    $key = $functionName;
//                    $value[0] = $arguments[0];
//                }
//                //array_push($this->_newAttributes, $functionName, $arguments[0]);
//                //$this->_setProperty($functionName, $arguments[0]);
//                //
//                //$this->setNewAttributes($arguments);
//            }
//        }
//        //var_dump($this->_newAttributes);
//    }



    public function save()
    {
        $this->_checkData();
    }

    protected function _checkData()
    {
        if(empty($this->getId()) || $this->getId() == null){
            $this->_createNewRow();
        } else {
            //$this->_insertDataToDb();
        }
    }

//    protected function _saveData()
//    {
//        $objectProperties = get_object_vars($this);
//        foreach($objectProperties as $item){
//            if(in_array($this->getAttributes(),$objectProperties)){
//
//            }
//
//        }
//
//        if(isset ($this->newAttributes) &&  $this->newAttributes != null){
//            var_dump( $this->newAttributes);
//        }
//    }

//    public function _createNewRow()
//    {
//        $query = '
//            INSERT INTO '
//            . $this->getTableName() . '(';
//
//        $count = count($keys);
//        $counter = 1;
//        foreach ($keys as $key) {
//            if ($counter < $count) {
//                $query .= "`$key`, ";
//            } else {
//                $query .= "`$key`";
//            }
//            $counter++;
//        }
//        $query .= ') VALUES (';
//        foreach ($values as $value) {
//            if ($counter < $count) {
//                $query .= "`$value`, ";
//            } else {
//                $query .= "`$value";
//            }
//            $counter++;
//        }
//        $query .= ')';
//
//        $statement = $this->_establishDbConnection()->prepare($query);
//        $statement->execute();
//        $this->_dbh = null;
//
//
//
////        $propertiesLoadedFromDb = $this->_attributesLoaded;
////
////        if(isset($objProperties[$id]) && $objProperties[$id] != null){
////
////        } else {
////
////        }
//
//
//        foreach($this->getAttributes() as $attribute){
//            $attribute = 1;
//        }
//
//
//        $query = "INSERT ";
//    }

    protected function _insertDataToDb()
    {

        $dataToInsert = ['lastname' => 'Alina', 'email' => 'email@mail.ru'];

        $tableName = $this->getTableName();
        $keys = $this->getArrayKeys($dataToInsert);
        $values = $this->getArrayValues($dataToInsert);
        $query = "INSERT INTO `$tableName` (";

        $count = count($keys);
        $counter = 1;
        foreach ($keys as $key) {
            if ($counter < $count) {
                $query .= "`$key`, ";
            } else {
                $query .= "`$key`";
            }
            $counter++;
        }
        $query .= ') VALUES (';
        foreach ($values as $value) {
            if ($counter < $count) {
                $query .= "`$value`, ";
            } else {
                $query .= "`$value";
            }
            $counter++;
        }
        $query .= ')';

        $statement = $this->_establishDbConnection()->prepare($query);
        $statement->execute();
        $this->_dbh = null;
    }

    public function _question(){
        foreach ($this->getArrayValues() as $item){
            return '?,';
        }
    }

    protected function getArrayValues($dataToInsert)
    {
        $res = array_values($dataToInsert);
        return $res;
    }

    protected function getArrayKeys($dataToInsert)
    {
        $res = array_keys($dataToInsert);
        return $res;
    }


    public function getId()
    {
        return $this->_getPrimaryKey();
    }

    protected function _getPrimaryKey()
    {
        $id = $this->getAttributes()[0];
        $objProperties = get_object_vars($this);
        if(isset($objProperties[$id]) && $objProperties[$id] != null){
            return $objProperties[$id];
        } else {
            return null;
        }
    }

    
    public function delete()
    {
        $this->_deleteRow();
    }

    private function _deleteRow()
    {
        $id = $this->getId();
        if(isset($id)){
            $this->_deleteRowQuery($this->getId());
        }
    }

    private function _deleteRowQuery($id)
    {
        $query = '
            DELETE 
            FROM '
            . $this->getTableName() . '
            WHERE '
            . $this->getAttributes()[0] . ' = '
            . $id ;
        $stmt = $this->_establishDbConnection()->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $this->_dbh = null;
    }


    /**
     * Loads data from Db
     *
     * @param $id           - id
     * @return mixed        - array of data
     */
    public function _loadAttrubitesDataFromDB($id)
    {
        $query = '
            SELECT * 
            FROM '
            . $this->getTableName() . '
            WHERE '
            . $this->getAttributes()[0] . ' = '
            . $id ;

        $stmt = $this->_establishDbConnection()->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $res = $stmt->fetch(2); //2 - ассоциат.массив ключ=знач 3 - array of data with numeric keys

        $stmt = null; $this->_dbh = null; //todo check DB connection
        return $res;
    }

    /**
     * Establishes connection to DB.
     * @return \common\PDO
     */
    protected function _establishDbConnection()
    {
        $connection = new Db();
        $this->_dbh = $connection->connectToDb();
        return $this->_dbh;
    }

}