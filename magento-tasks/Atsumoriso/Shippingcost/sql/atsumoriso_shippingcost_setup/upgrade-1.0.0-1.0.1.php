<?php
$installer = $this;
/* @var $installer Atsumoriso_Blog_Model_Resource_Setup */
$installer->startSetup();// = new Mage_Sales_Model_Resource_Setup('core_setup');
/**
 * Add 'additional_shipping_cost' attribute for tables:
 *                                     sales_flat_quote_item, sales_flat_order_item
 */
$entities = array(
    'quote_item',
    'order_item'
);


$options = array(
    'type'     => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'visible'  => true,
    'required' => false
);
foreach ($entities as $entity) {
    $installer->addAttribute($entity, 'additional_shipping_cost', $options);
}
$installer->endSetup();