<?php


class Atsumoriso_Pricegrid_Adminhtml_PriceController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();

        $productsIdsArray = $params['product'];
        $operation        = $params['operation'];
        $value            = $params['value'];

        $validator = Mage::getModel('atsumoriso_pricegrid/adminhtml_validate');
        $session = Mage::getSingleton('adminhtml/session');
        $helper = Mage::helper('atsumoriso_pricegrid');
        $updatePrice = Mage::getModel('atsumoriso_pricegrid/adminhtml_updateprice');

        $value = $validator->cleanDigitInput($value);
        $errorMessage = $validator->checkIfErrorsExist($operation,$value);

        if(!empty($errorMessage)){
            $session->addError($helper->__($errorMessage));

        } elseif($updatePrice->saveNewPriceToProductCollection($productsIdsArray, $operation, $value) == true){
            $session->addSuccess($helper->__(
                'Totally %d record(s) have been changed.', count($productsIdsArray))
            );
        }

        $this->_redirect('adminhtml/catalog_product');
    }


}
