<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_Observer
{
    /** @array array of possible price update operations */
    protected $operations = [];

    public function __construct()
    {
        $this->operations = Mage::getModel('atsumoriso_pricegrid/adminhtml_updatePrice_lib_operations')->getOperations();
    }

    public function addMassAction($observer)
    {
        $block = $observer->getEvent()->getBlock();
        $helper = Mage::helper('atsumoriso_pricegrid');

        if(get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction'
            && $block->getRequest()->getControllerName() == 'catalog_product') {

            $block->setMassactionIdField('update_price');

            $block->addItem('update_price', array(
                'label'=> $helper->__('Update price'),
                'url'  => $block->getUrl('adminhtml/price'),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'operation',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => $helper->__('Operation'),
                        'values' => $this->operations,
                    ),
                    'value' => array(
                        'name' => 'value',
                        'type' => 'text',
                        'class' => 'required-entry',
                        'label' => $helper->__('Value'),
                    )
                )

            ));
        }
    }


}