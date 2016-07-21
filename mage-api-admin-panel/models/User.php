<?php

namespace models;

use modules\ormatsumoriso\EntityCommonModelAbstract;
use modules\ormatsumoriso\components\EntityInterface;

/**
 * User Model
 * 
 * Class to work with table api_user
 *
 * @package Entity
 */
class User extends EntityCommonModelAbstract
    implements EntityInterface
{

    const STATUS_NON_ACTIVE = 0;
    const STATUS_ACTIVE     = 1;

    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return 'api_user';
    }


    public function checkUserEmail($email)
    {
        if(!empty($this->_getEmailFromDb($email))){
            $res = $this->_getEmailFromDb($email);
            return $res;
        }
        return null;
    }

    public function getConnection()
    {
        return $this->_connection;
    }


    private function _getEmailFromDb($email)
    {
        $query = '
            SELECT *
            FROM '
            . $this->getTableName() . '
            WHERE `email` =  
            :email ';

        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(":email",$email);
        $stmt->execute();
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $res;
    }
    
}