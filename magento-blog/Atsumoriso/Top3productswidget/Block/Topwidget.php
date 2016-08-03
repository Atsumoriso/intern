<?php

class Atsumoriso_Top3productswidget_Block_Topwidget
                extends Mage_Core_Block_Template
                implements Mage_Widget_Block_Interface
{
    public function getTop3ProductsData()
    {
        $model = new Atsumoriso_Top3productswidget_Model_Topwidget;
        $products = $model->getTopProducts();
        return $products;
    }

}
