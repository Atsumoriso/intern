<?php

namespace ormatsumoriso\models;

use ormatsumoriso\components\OrmDbMysqlAbstract;

/**
 * Class User
 * 
 * Class to work with table User
 */
class User extends OrmDbMysqlAbstract
{
    protected $tableName = 'api_user';

    protected $columnId = 'user_id';


    public function findByParam()
    {
        // TODO: Implement _findByParam() method.
    }
}