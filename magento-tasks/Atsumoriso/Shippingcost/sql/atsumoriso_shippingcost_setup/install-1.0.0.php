<?php
/**
 * Atsumoriso
 *
 */

$installer = $this;

/**
 * Creates new product attribute called "additional_shipping_cost".
 */

$installer->startSetup();

$installer->addAttribute('catalog_product', 'additional_shipping_cost',  array(
        'group'             => 'General',
        'type'              => Varien_Db_Ddl_Table::TYPE_DECIMAL,
        'backend'           => 'catalog/product_attribute_backend_price',
        'frontend'          => '',
        'label'             => 'Additional shipping cost',
        'input'             => 'price',
        'class'             => '',
        'source'            => '',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'           => true,
        'required'          => false,
        'user_defined'      => true,
        'default'           => 0,
        'searchable'        => true,
        'filterable'        => true,
        'comparable'        => true,
        'visible_on_front'  => true,
        'unique'            => false,
        'apply_to'          => '',
        'is_configurable'   => false,

    )
);

$installer->endSetup();
