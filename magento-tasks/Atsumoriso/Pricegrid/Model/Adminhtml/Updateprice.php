<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_Updateprice
{
    public $updatePriceAction;


    public function __construct($operation)
    {
        $this->updatePriceAction = new Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Strategy($operation);
    }


    public function save($productsIdsArray, $valueToUpdate)
    {
        $this->setNewPriceToCollection($productsIdsArray, $valueToUpdate);
    }


    protected function getProductCollection($productsIdsArray)
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('entity_id', ['in' => $productsIdsArray])
            ->addAttributeToSelect('price');
        return $productCollection;
    }


    protected function setNewPriceToCollection($productsIdsArray, $valueToUpdate)
    {
        $productCollection = $this->getProductCollection($productsIdsArray);

        foreach ($productCollection as $product) {
            $oldPrice = $product->getPrice();
            $newPrice = $this->updatePriceAction->calculateNewPrice($oldPrice, $valueToUpdate);

            try {

                //check if newPrice is valid
                if(Mage::getModel('atsumoriso_pricegrid/adminhtml_validate')->checkIfPositive($newPrice)){
                    $product->setPrice($newPrice);
                } else {
                    Mage::throwException('Product with ID' . $product->getId() . ' \'s current price is smaller than input value. No changed have been applied.');
                }

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addException($e, $e->getMessage());
            }

        }
        $productCollection->save();

    }

}