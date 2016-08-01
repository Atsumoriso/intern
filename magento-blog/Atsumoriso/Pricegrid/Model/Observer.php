<?php

class Atsumoriso_Pricegrid_Model_Observer
{
    const OPERATION_ADDITION              = 1; //'+';
    const OPERATION_SUBTRACTION           = 2; //'-';
    const OPERATION_ADD_PERCENT           = 3; //'+%';
    const OPERATION_SUBSTRUCT_PERCENT     = 4; //'-%';
    const OPERATION_MULTIPLICATION        = 5; //'*';


    /**
     * Retrieve operations array
     *
     * @return array
     */
    public static function getOperationsArray()
    {
        return array(
            self::OPERATION_ADDITION             => Mage::helper('atsumoriso_blog')->__('Add'),
            self::OPERATION_SUBTRACTION          => Mage::helper('atsumoriso_blog')->__('Substruct'),
            self::OPERATION_ADD_PERCENT          => Mage::helper('atsumoriso_blog')->__('Add percent'),
            self::OPERATION_SUBSTRUCT_PERCENT    => Mage::helper('atsumoriso_blog')->__('Substruct percent'),
            self::OPERATION_MULTIPLICATION       => Mage::helper('atsumoriso_blog')->__('Multiplicate'),
        );
    }

    public function addMassAction($observer)
    {

        $block = $observer->getEvent()->getBlock();
        if(get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction'
            && $block->getRequest()->getControllerName() == 'catalog_product')
        {

            $block->setMassactionIdField('update_price');
//            $block->getMassactionBlock()->setFormFieldName('update_price');


            $operations = self::getOperationsArray();

            array_unshift($operations, array('label'=>'', 'value'=>''));

            $block->addItem('update_price', array(
                'label'=> Mage::helper('atsumoriso_blog')->__('Update price'),
                'url'  => $block->getUrl('adminhtml/price'), //array('_current'=>true) adds key to url?
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