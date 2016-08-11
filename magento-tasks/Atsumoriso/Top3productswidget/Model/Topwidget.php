<?php

class Atsumoriso_Top3productswidget_Model_Topwidget extends Mage_Core_Model_Abstract
{
    const OPTION_NOT_TOP          = 0;
    const OPTION_TOP              = 1;

    /**
     * Retrieve operations array
     *
     * @return array
     */
    public static function getOptionsArray()
    {
        return array(
            self::OPTION_TOP        => Mage::helper('atsumoriso_top3productswidget')->__('Top'),
            self::OPTION_NOT_TOP    => Mage::helper('atsumoriso_top3productswidget')->__('Not top'),
        );
    }


    public function getTopProducts()
    {
        $products = Mage::getModel('catalog/product')->getCollection()
            ->addFieldToFilter('is_top',['eq'=> self::OPTION_TOP])
            ->addAttributeToSelect('name')
//            ->addAttributeToSelect('url_path')
            ->addAttributeToSelect('url_key')
            ->addAttributeToSelect('thumbnail');
        $products->getSelect()->order(new Zend_Db_Expr('RAND()'));


        return $products;
    }
}