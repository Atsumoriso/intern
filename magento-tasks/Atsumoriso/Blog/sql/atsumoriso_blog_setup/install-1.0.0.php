<?php
/**
 * Atsumoriso
 *
 * Table for blog posts
 *
 */

$installer = $this;
/* @var $installer Atsumoriso_Blog_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'blog/post'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('blog/post'))
    ->addColumn('post_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Post ID')
    ->addColumn('headline', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'unsigned'  => false,
        'nullable'  => false,
    ), 'Headline')
    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ), 'Text')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        'default'   => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ), 'Creation Time')
    ->addColumn('author_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => false,
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Post ID')
    ->addColumn('photo_path', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'unsigned'  => false,
        'nullable'  => true,
    ), 'Photo path')
    ->setComment('Blog posts table');

$installer->getConnection()->createTable($table);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('blog/post', 'author_id', 'customer/entity', 'entity_id'),
    $installer->getTable('blog/post'), 'author_id',
    $installer->getTable('customer/entity'), 'entity_id'
);

$installer->endSetup();
