<?php

class Atsumoriso_Blog_Model_Resource_Productbinded_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('blog/productbinded', 'post_product_id');
    }

}