<?php

class Atsumoriso_Top3productswidget_Block_Topwidget
                extends Mage_Core_Block_Template
                implements Mage_Widget_Block_Interface
{
    /**
     * Gets collection of top products.
     * @return mixed
     */
    public function getTop3ProductsData()
    {
//        $model = new Atsumoriso_Top3productswidget_Model_Topwidget;
//        $products = $model->getTopProducts();
        $products = Mage::getModel('atsumoriso_top3productswidget/topwidget')->getTopProducts();
        return $products;
    }

}
