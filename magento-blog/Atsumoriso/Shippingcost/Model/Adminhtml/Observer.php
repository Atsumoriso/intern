<?php

class Atsumoriso_Shippingcost_Model_Adminhtml_Observer
{
    /**
     * Adds menu item to products grid on catalog_product/index.
     * @param Varien_Event_Observer $observer
     */
    public function onBlockHtmlBefore(Varien_Event_Observer $observer) {
        $block = $observer->getBlock();
        if (!isset($block)) return;

        switch ($block->getType()) {
            case 'adminhtml/catalog_product_grid':
                $block->addColumn('additional_shipping_cost', array(
                    'header'        => Mage::helper('atsumoriso_top3productswidget')->__('Additional Shipping Cost'),
                    'width'         => '40px',
                    'align'         => 'center',
                    'name'          => 'additional_shipping_cost',
                    'index'         => 'additional_shipping_cost',
                    'filter_index'  => 'additional_shipping_cost',
                ));
                $block->sortColumnsByOrder();

                break;
        }
    }

    /**
     * Loads 'additional_shipping_cost' to collection.
     * @param Varien_Event_Observer $observer
     */
    public function onEavLoadBefore(Varien_Event_Observer $observer) {
        $collection = $observer->getCollection();

        if (!isset($collection)) return;

        if (is_a($collection, 'Mage_Catalog_Model_Resource_Product_Collection')) {
            $collection->addAttributeToSelect('additional_shipping_cost');
        }
    }
}