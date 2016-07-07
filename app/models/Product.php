<?php

namespace models;

use modules\ormatsumoriso\EntityCommonModelAbstract;
use modules\ormatsumoriso\components\EntityInterface;

/**
 * Product Model
 *
 * Class to work with table product
 *
 * @package Entity
 */
class Product extends EntityCommonModelAbstract
    implements EntityInterface
{
    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return 'product';
    }

}