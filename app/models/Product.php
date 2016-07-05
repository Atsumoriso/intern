<?php

namespace models;

use modules\ormatsumoriso\EntityCommonModelAbstract;
use modules\ormatsumoriso\components\EntityInterface;
use modules\ormatsumoriso\components\BaseMethodInterface;

/**
 * Product Model
 *
 * Class to work with table product
 *
 * @package Entity
 */
class Product extends EntityCommonModelAbstract
    implements EntityInterface,
               BaseMethodInterface
{
    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return 'product';
    }

}