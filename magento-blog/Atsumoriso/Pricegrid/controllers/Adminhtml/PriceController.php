<?php


class Atsumoriso_Pricegrid_Adminhtml_PriceController extends Mage_Adminhtml_Controller_Action
{


    public function indexAction()
    {
        $params = $this->getRequest()->getParams();

        $productsIdsArray  = $params['product'];
        $operation         = $params['operation'];
        $value             = $params['value'];

        $value = Mage::helper('atsumoriso_pricegrid')->cleanDigitInput($value);

        if ($operation == Atsumoriso_Pricegrid_Model_Observer::OPERATION_MULTIPLICATION
            && Mage::helper('atsumoriso_pricegrid')->validateValueForMultiplication($value) == true){

            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('atsumoriso_pricegrid')->__(
                'Not valid value for selected operation.'));

        } elseif($this->_saveNewPriceToProductCollection($productsIdsArray, $operation, $value) == true) {

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('atsumoriso_pricegrid')->__(
                'Totally %d record(s) have been changed.', count($productsIdsArray))
            );
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('atsumoriso_pricegrid')->__(
                'Something went wrong...  Please try again.'));
        }

        $this->_redirect('adminhtml/catalog_product');
    }



    protected function _saveNewPriceToProductCollection($productsIdsArray, $operation, $value)
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('entity_id', ['in' => $productsIdsArray])
            ->addAttributeToSelect('price');

        $productCollection = $this->_setNewPriceToCollection($productCollection, $operation, $value);
        $productCollection->save();

        if($productCollection->save())
            return true;
        else
            return false;
    }

    protected function _setNewPriceToCollection($productCollection, $operation, $value)
    {
        foreach ($productCollection as $product) {
            $price = $product->getPrice();

            switch ($operation) {
                case Atsumoriso_Pricegrid_Model_Observer::OPERATION_ADDITION:
                    $newPrice = Mage::helper('atsumoriso_pricegrid')->performOperationAddition($price, $value);
                    break;

                case Atsumoriso_Pricegrid_Model_Observer::OPERATION_SUBTRACTION:
                    $newPrice = Mage::helper('atsumoriso_pricegrid')->performOperationSubstruction($price, $value);
                    break;

                case Atsumoriso_Pricegrid_Model_Observer::OPERATION_ADD_PERCENT:
                    $newPrice = Mage::helper('atsumoriso_pricegrid')->performOperationAddPercent($price, $value);
                    break;

                case Atsumoriso_Pricegrid_Model_Observer::OPERATION_SUBSTRUCT_PERCENT:
                    $newPrice = Mage::helper('atsumoriso_pricegrid')->performOperationSubstructPercent($price, $value);
                    break;

                case Atsumoriso_Pricegrid_Model_Observer::OPERATION_MULTIPLICATION:
                    $newPrice = Mage::helper('atsumoriso_pricegrid')->performOperationMultiplication($price, $value);
                    break;
            }

            $product->setPrice($newPrice);

        }
        return $productCollection;
    }

}
