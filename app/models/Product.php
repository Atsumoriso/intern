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
class Product extends EntityCommonModelAbstract implements EntityInterface
{
    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return 'product';
    }

}