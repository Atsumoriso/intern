<?php
/**
 * Atsumoriso
 *
 */

$installer = $this;

/**
 * Creates new product attribute called "is_top"
 *
 * Possible values of attributes check in
 * SELECT * FROM magento.eav_attribute where backend_type = 'int';
 *
 * after adding check if added in admin/catalog_product_attribute/index
 *
 * examples of adding attributes
 * /home/ppi/www/magento-1.local/web/app/code/core/Mage/Catalog/sql/catalog_setup/upgrade-1.6.0.0.1-1.6.0.0.2.php
 * /home/ppi/www/magento-1.local/web/app/code/core/Mage/Catalog/sql/catalog_setup/mysql4-upgrade-1.4.0.0.28-1.4.0.0.29.php
 * /home/ppi/www/magento-1.local/web/app/code/core/Mage/Catalog/sql/catalog_setup/upgrade-1.6.0.0-1.6.0.0.1.php
 *
 */

$installer->startSetup();

$installer->addAttribute('catalog_product', 'is_top',  array(
        'group'             => 'Education', //admin/catalog_product/edit adds new tab to product information
        'type'              => 'int',
        'backend'           => '',
//        'backend'       => 'catalog/product_attribute_backend_media',
        'frontend'          => '',
        'label'             => 'Is in top list',
        'input'             => 'select',
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
