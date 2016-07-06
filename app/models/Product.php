<?php

namespace models;

use modules\ormatsumoriso\EntityCommonModelAbstract;
use modules\ormatsumoriso\components\EntityInterface;
use modules\ormatsumoriso\components\FindAllInterface;

/**
 * Product Model
 *
 * Class to work with table product
 *
 * @package Entity
 */
class Product extends EntityCommonModelAbstract
    implements EntityInterface,
               FindAllInterface
{
    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return 'product';
    }

}