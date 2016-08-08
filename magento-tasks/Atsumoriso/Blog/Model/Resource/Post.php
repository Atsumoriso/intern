<?php

class Atsumoriso_Blog_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('blog/post', 'post_id');
    }

    /**
     * Adds join statements when using load($id).
     *
     * @param string $field
     * @param mixed $value
     * @param Mage_Core_Model_Abstract $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        $select->join(array('ce1' => 'customer_entity_varchar'),'ce1.entity_id = author_id AND ce1.attribute_id = 5', 'ce1.value as firstname');
        $select->join(array('ce2' => 'customer_entity_varchar'),'ce2.entity_id = author_id AND ce2.attribute_id = 7', 'ce2.value as lastname');
        $select->columns(new Zend_Db_Expr("CONCAT(`ce1`.`value`, ' ',`ce2`.`value`) AS fullname"));
        return $select;
    }

}