<?php


class Atsumoriso_Pricegrid_Adminhtml_PriceController extends Mage_Adminhtml_Controller_Action
{


    public function indexAction()
    {
        $params = $this->getRequest()->getParams();

        $productsIdsArray  = $params['product'];
        $operation         = $params['operation'];
        $value             = $params['value'];

        $value             = str_replace(",", ".", $value);
        $value             = (float)abs($value);

        if ($operation == Atsumoriso_Pricegrid_Model_Observer::OPERATION_MULTIPLICATION && $value == 0){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('atsumoriso_pricegrid')->__('Operation is not allowed. '));

        } else {
            $productCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', ['in' => $productsIdsArray])
                ->addAttributeToSelect('price');

            foreach ($productCollection as $product){
                $price = $product->getPrice();

                switch ($operation){
                    case Atsumoriso_Pricegrid_Model_Observer::OPERATION_ADDITION:
                        $newPrice = $price + $value;
                        break;

                    case Atsumoriso_Pricegrid_Model_Observer::OPERATION_SUBTRACTION:
                        if($value > $price){
                            $newPrice = 0.01;
                        } else {
                            $newPrice = $price - $value;
                        }
                        break;

                    case Atsumoriso_Pricegrid_Model_Observer::OPERATION_ADD_PERCENT:
                        $newPrice = $price + ($price * $value)/100;
                        break;

                    case Atsumoriso_Pricegrid_Model_Observer::OPERATION_SUBSTRUCT_PERCENT:
                        $newPrice = $price - ($price * $value)/100;
                        break;

                    case Atsumoriso_Pricegrid_Model_Observer::OPERATION_MULTIPLICATION:
                        $newPrice = $price * $value;
                        break;
                }

                $product->setPrice($newPrice);
                $product->save();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('atsumoriso_pricegrid')->__(
                    'Totally %d record(s) have been changed.', count($productsIdsArray)
                )
            );
        }



        $this->_redirect('adminhtml/catalog_product');

    }

}
