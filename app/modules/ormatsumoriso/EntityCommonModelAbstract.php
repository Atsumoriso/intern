<?php

namespace modules\ormatsumoriso;

use modules\ormatsumoriso\components\EntityInterface;

use components\Database;

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
     *
     * @var mixed
     */
    private $_tableName;

    /**
     * Represents an array of Table column values.
     *
     * @var array
     */
    protected $_attributes = [];

    /**
     * Data loaded from Db.
     *
     * @var array
     */
    protected $_attributesLoaded = [];

    /* Connection to Db */
    protected $_connection;

    /**
     * EntityCommonModelAbstract constructor.
     * If tableName is set when creating Model for Db Table, attributes of this table will automatically initialized.
     *
     * @return void
     */
    public function __construct($dbConnection)
    {
        $this->_tableName   = $this->getTableName();
        $this->_connection = $dbConnection;
        $this->_attributes = $this->getAttributes();
    }

    /**
     * Gets name of the table, to which this Class belongs to
     *
     * @return mixed
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * Represents an array of Table column values.
     * In order to get attributes' values, you need to set value of the tableName.
     *
     * @return array   = names of table columns.
     */
    public function getAttributes()
    {
        $sql  = 'SHOW FIELDS FROM ' . $this->getTableName();
        $stmt = $this->_connection->prepare($sql);
        $stmt->execute();
        $res  = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        return $res;
    }

    /**
     * Sets loaded attributes to array.
     *
     * @param array $value         list of properties/attributes.
     */
    protected function _setAttributesLoaded(Array $value)
    {
        $this->_attributesLoaded = $value;
    }

    /**
     * @inheritdoc
     *
     * @param int|string $id      @inheritdoc
     */
    public function load($id)
    {
        $this->_loadNewPropertiesAndValues($id);
    }

    /**
     * @inheritdoc
     *
     * @return null
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
     * Gets attributes values as KEYS and property values from Db as VALUES and sets correspondent properties for this object.
     * First writes loaded data to array, then to Objects properties.
     *
     * @param $id              id of loaded data from Db to an Object
     * @return void
     */
    protected function _loadNewPropertiesAndValues($id)
    {
        if($this->_loadAttrubitesDataFromDB($id) != null){
            $this->_setAttributesLoaded($this->_loadAttrubitesDataFromDB($id));

            $propertyFromDbArray = $this->_loadAttrubitesDataFromDB($id);
            if(!empty($propertyFromDbArray)){
                foreach ($this->getAttributes() as $attribute) {
                    $this->_setProperty($attribute,array_shift($propertyFromDbArray));
                }
            }
        }
    }

    /**
     * Loads data from Db.
     *
     * @param $id            'id' of the Db record
     * @return mixed         array of data
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
            $this->_createNewRow();
        } else {
            $this->_insertDataToDb();
        }
    }


    /**
     * Creates new record.
     *
     * @return void
     */
    protected function _createNewRow()
    {
        $dataSetByUser = $this->_getUserSetData();
        $query = "
            INSERT INTO  `"
            . $this->getTableName() . "` ("
            . implode(
                ", ",
                array_keys(
                    $dataSetByUser
                ))
            . ")  
            VALUES  ("
            . implode(
                ",",
                array_fill(
                    1,
                    count($dataSetByUser),
                    '?'
                )
            ) . ")";

        $stmt = $this->_connection->prepare($query);

        $counter = 1;
        foreach ($dataSetByUser as $value){
            $stmt->bindValue($counter, $value);
            $counter++;
        }

        $stmt->execute();
    }

    /**
     * Checks if data is set for an object.
     * First, deleting properties, that come not from table, but from this abstract class and
     * secondly  deleting null values
     *
     * @return array   = not null properties/attributes
     */
    protected function _getUserSetData()
    {
        $objProperties = get_object_vars($this);

        foreach ($objProperties as $key=>$value){
            if(!in_array($key, $this->getAttributes())){
                unset ($objProperties{$key});
            }
        }

        foreach ($objProperties as $key=>$value){
            if($value == null){
                unset ($objProperties{$key});
            }
        }
        return $objProperties;
    }

    /**
     * Updates existing record in the Database.
     *
     * @return void
     */
    protected function _insertDataToDb()
    {
        $dataSetByUser = $this->_getUserSetData();
        $idIdentifier = $this->getAttributes()[0]; //todo
        foreach ($dataSetByUser as $key=>$value){
            if($key == $idIdentifier){
                unset($dataSetByUser{$key});
            }
        }

        $query = "
            UPDATE "
            . $this->getTableName() . "
            SET " ;
        $queryTemp = '';
        foreach ($dataSetByUser as $key=>$value){
            $queryTemp .= $key. ' = \'' . $value . "', ";

        }
        $query .= substr(trim($queryTemp), 0, -1); //delete last ', '
        $query .=
            "WHERE "
            . $idIdentifier . " = "
            . $this->getId();

        $stmt = $this->_connection->prepare($query);

        $counter = 1;
        foreach ($dataSetByUser as $value){
            $stmt->bindValue($counter, $value);
            $counter++;
        }
        $stmt->execute();
    }


    /**
     * Checks if id exists.
     *
     * @return null | 'id'        - null or id
     */
    protected function _getPrimaryKey()
    {
        $id = $this->getAttributes()[0]; //todo may be some other variant??
        $objProperties = get_object_vars($this);
        if(!empty($objProperties[$id]) && $objProperties[$id] != null){
            return $objProperties[$id];
        } else {
            return null;
        }
    }



    /**
     * Calls delete record method, if id is set and unsets Object.
     *
     * @return void
     */
    protected function _deleteRow()
    {
        $id = $this->getId();
        if(isset($id)){
            $this->_deleteRowQuery($this->getId());
            unset($this);
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
            . $this->getAttributes()[0] . ' = '
            . $id ;
        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
    }

    /**
     * Set property for loaded attributes/properties.
     *
     * @param $property         - name of property
     * @param $value            - value of property
     */
    protected function _setProperty($property, $value) {
        $this->$property = $value;
    }



//    public function __set($property, $value) {
//        if(in_array($property, $this->getAttributes())){
//            $this->property = $value;
//        }
//    }

//todo
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

}