<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_Updateprice
{
    const OPERATION_ADDITION              = 1; //'+';
    const OPERATION_SUBSTRACTION          = 2; //'-';
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
            self::OPERATION_ADDITION             => Mage::helper('atsumoriso_pricegrid')->__('Add'),
            self::OPERATION_SUBSTRACTION          => Mage::helper('atsumoriso_pricegrid')->__('Substruct'),
            self::OPERATION_ADD_PERCENT          => Mage::helper('atsumoriso_pricegrid')->__('Add percent'),
            self::OPERATION_SUBSTRUCT_PERCENT    => Mage::helper('atsumoriso_pricegrid')->__('Substruct percent'),
            self::OPERATION_MULTIPLICATION       => Mage::helper('atsumoriso_pricegrid')->__('Multiplicate'),
        );
    }

    /**
     * Performs operation Addition.
     *
     * @param $price
     * @param $valueToChangePrice
     * @return mixed
     */
    public function performOperationAddition($price, $valueToChangePrice)
    {
        return $price + $valueToChangePrice;
    }

    /**
     * Performs operation Substruction.
     *
     * @param $price
     * @param $valueToChangePrice
     * @return int
     */
    public function performOperationSubstruction($price, $valueToChangePrice)
    {
        if ($valueToChangePrice > $price) {
            $newPrice = $price;
        } else {
            $newPrice = $price - $valueToChangePrice;
        }
        return $newPrice;
    }

    /**
     * Performs operation Percent addition.
     *
     * @param $price
     * @param $percent
     * @return mixed
     */
    public function performOperationAddPercent($price, $percent)
    {
        return $price + ($price * $percent) / 100;
    }

    /**
     * Performs operation Percent substruction.
     *
     * @param $price
     * @param $percent
     * @return mixed
     */
    public function performOperationSubstructPercent($price, $percent)
    {
        return $price - ($price * $percent) / 100;

    }

    public function saveNewPriceToProductCollection($productsIdsArray, $operation, $value)
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('entity_id', ['in' => $productsIdsArray])
            ->addAttributeToSelect('price');

        if($productCollection = $this->setNewPriceToCollection($productCollection, $operation, $value)){
            $productCollection->save();
            return true;
        } else {
            return false;
        }
    }


    /**
     * Performs operation Multiplication.
     *
     * @param $price
     * @param $value
     * @return mixed
     */
    public function performOperationMultiplication($price, $value)
    {
        return $price * $value;
    }

    public function setNewPriceToCollection($productCollection, $operation, $value)
    {
        foreach ($productCollection as $product) {
            $price = $product->getPrice();

            if($operation == self::OPERATION_SUBSTRACTION
                && Mage::getModel('atsumoriso_pricegrid/adminhtml_validate')->checkIfValueSmallerThanPrice($price, $value) == false ) {

                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('atsumoriso_pricegrid')->__(
                    'Product with ID %d \'s current price is smaller than value. No changed have been applied.', $product->getId())
                );
                return false;
            }

            switch ($operation) {
                case self::OPERATION_ADDITION:
                    $newPrice = $this->performOperationAddition($price, $value);
                    break;

                case self::OPERATION_SUBSTRACTION:
                    $newPrice = $this->performOperationSubstruction($price, $value);
                    break;

                case self::OPERATION_ADD_PERCENT:
                    $newPrice = $this->performOperationAddPercent($price, $value);
                    break;

                case self::OPERATION_SUBSTRUCT_PERCENT:
                    $newPrice = $this->performOperationSubstructPercent($price, $value);
                    break;

                case self::OPERATION_MULTIPLICATION:
                    $newPrice = $this->performOperationMultiplication($price, $value);
                    break;
            }

            $product->setPrice($newPrice);

        }
        return $productCollection;
    }
}