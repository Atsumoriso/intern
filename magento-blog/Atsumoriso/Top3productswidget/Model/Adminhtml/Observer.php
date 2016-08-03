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
                    'align'       => 'center',
                    'name'        => 'is_top',
                    'index'       => 'is_top',
                    'type'        => 'options',
                    'options'     => $options,
                ));

                break;
        }

    }

    public function onEavLoadBefore(Varien_Event_Observer $observer) {
        $collection = $observer->getCollection();

        if (!isset($collection)) return;

        if (is_a($collection, 'Mage_Catalog_Model_Resource_Product_Collection')) {
            //adding attribute 'is_top' to products grid
            $collection->addAttributeToSelect('is_top');
        }
    }
}