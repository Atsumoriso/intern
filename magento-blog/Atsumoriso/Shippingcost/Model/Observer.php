<?php


class Atsumoriso_Shippingcost_Model_Observer
{
    /**
     * Calculates amount for 'additional shipping cost' and sets for products in Quote.
     * @param $observer
     */
    public function calculateTotalShippingCostForQuoteProducts($observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $product = Mage::getModel('catalog/product')->load($quoteItem->getProduct()->getId());
        $quoteItem->setAdditionalShippingCost($product->getAdditionalShippingCost());
    }

}