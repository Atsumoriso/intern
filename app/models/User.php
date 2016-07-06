<?php

namespace models;

use modules\ormatsumoriso\EntityCommonModelAbstract;
use modules\ormatsumoriso\components\EntityInterface;
use modules\ormatsumoriso\components\FindAllInterface;

/**
 * User Model
 * 
 * Class to work with table api_user
 *
 * @package Entity
 */
class User extends EntityCommonModelAbstract
    implements EntityInterface,
               FindAllInterface
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
    
}