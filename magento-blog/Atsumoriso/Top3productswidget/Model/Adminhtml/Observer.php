<?php

class Atsumoriso_Top3productswidget_Model_Adminhtml_Observer
{

    public function onBlockHtmlBefore(Varien_Event_Observer $observer) {
        $block = $observer->getBlock();
        if (!isset($block)) return;

        $options = Atsumoriso_Top3productswidget_Model_Topwidget::getOptionsArray();

        switch ($block->getType()) {
            case 'adminhtml/catalog_product_grid':
                /* @var $block Mage_Adminhtml_Block_Catalog_Product_Grid */
                $block->addColumn('is_top', array(
                    'header'      => Mage::helper('atsumoriso_top3productswidget')->__('Top rated products'),
                    'width'       => '30px',
                    //'align'     => 'left',
                    'name'        => 'is_top',
                    'index'       => 'is_top',
                    'type'        => 'options',
                    'options'     => $options,
                ));
                break;
        }

    }

}