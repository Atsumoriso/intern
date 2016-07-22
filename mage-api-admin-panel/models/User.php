<?php

namespace models;

use modules\ormatsumoriso\EntityCommonModelAbstract;
use modules\ormatsumoriso\components\EntityInterface;
use modules\ormatsumoriso\components\FindInterface;

/**
 * User Model
 * Class to work with table api_user
 *
 * @package Entity
 */
class User extends EntityCommonModelAbstract
    implements EntityInterface,
               FindInterface
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


    /**
     * Checks if record with this email exists, and returns this record or null.
     * @param $email
     * @return null
     */
    public function checkUserEmail($email)
    {
        if(!empty($this->_getEmailFromDb($email))){
            $res = $this->_getEmailFromDb($email);
            return $res;
        }
        return null;
    }

    /**
     * Gets record from Db using email.
     * @param $email
     * @return mixed
     */
    private function _getEmailFromDb($email)
    {
        $query = '
            SELECT *
            FROM '
            . $this->getTableName() . '
            WHERE `email` =  
            :email ';

        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(":email",$email);
        $stmt->execute();
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $res;
    }
    
}