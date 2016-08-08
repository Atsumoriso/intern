<?php
/**
 * Atsumoriso
 *
 */

$installer = $this;

/**
 * Creates new product attribute called "is_top"
 *
 */

$installer->startSetup();

$installer->addAttribute('catalog_product', 'is_top',  array(
        'group'             => 'Education', //adds new tab to product information on admin/catalog_product/edit
        'type'              => 'int',
        'backend'           => '',
        'frontend'          => '',
        'label'             => 'Is in top list',
        'input'             => 'boolean',
        'class'             => '',
        'source'            => 'eav/entity_attribute_source_boolean',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'           => true,
        'required'          => false,
        'user_defined'      => false,
        'default'           => 0,
        'searchable'        => false,
        'filterable'        => false,
        'comparable'        => false,
        'visible_on_front'  => true,
        'unique'            => false,
        'apply_to'          => '',
        'is_configurable'   => false,

    )
);


$installer->endSetup();
