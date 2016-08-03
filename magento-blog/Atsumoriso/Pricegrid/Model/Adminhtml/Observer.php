<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_Observer
{

    public function addMassAction($observer)
    {
        $block = $observer->getEvent()->getBlock();
        if(get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction'
            && $block->getRequest()->getControllerName() == 'catalog_product') {

            $block->setMassactionIdField('update_price');
            $operations = Atsumoriso_Pricegrid_Model_Adminhtml_Updateprice::getOperationsArray();
            array_unshift($operations, array('label'=>'', 'value'=>''));

            $block->addItem('update_price', array(
                'label'=> Mage::helper('atsumoriso_blog')->__('Update price'),
                'url'  => $block->getUrl('adminhtml/price'),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'operation',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('atsumoriso_blog')->__('Operation'),
                        'values' => $operations
                    ),
                    'value' => array(
                        'name' => 'value',
                        'type' => 'text',
                        'class' => 'required-entry',
                        'label' => Mage::helper('atsumoriso_blog')->__('Value'),
                    )
                )

            ));
        }
    }
}