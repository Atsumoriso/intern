<?php
/**
 * Atsumoriso Top3productswidget
 *
 * Adding default attribute 'is_top' values for already existed products.
 *
 */
$installer = $this;


$products = Mage::getModel('catalog/product')->getCollection();

foreach($products as $product)
{
    $product->setIsTop(0);
    $product->getResource()->saveAttribute($product, 'is_top');

}


$installer->endSetup();