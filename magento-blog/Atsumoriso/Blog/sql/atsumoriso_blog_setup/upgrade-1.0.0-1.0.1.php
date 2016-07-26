<?php
/**
 * Atsumoriso
 *
 * Table for binded products in blog posts
 *
 */

$installer = $this;
/* @var $installer Atsumoriso_Blog_Model_Resource_Setup */

$installer->startSetup();

/**
 * Creating table 'blog/post_binded_product'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/productbinded'))
    ->addColumn('post_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'post_product_id')
    ->addColumn('post_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Post ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Product ID')
    ->setComment('Blog posts\' binded products\' table');

$installer->getConnection()->createTable($table);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('blog/productbinded', 'post_id', 'blog/post', 'post_id'),
    $installer->getTable('blog/productbinded'), 'post_id',
    $installer->getTable('blog/post'), 'post_id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('blog/productbinded', 'product_id', 'catalog/product', 'entity_id'),
    $installer->getTable('blog/productbinded'), 'product_id',
    $installer->getTable('catalog/product'), 'entity_id'
);

$installer->endSetup();
