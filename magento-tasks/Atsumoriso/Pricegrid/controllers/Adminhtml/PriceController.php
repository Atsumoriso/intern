<?php


class Atsumoriso_Pricegrid_Adminhtml_PriceController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();

        $validator = Mage::getModel('atsumoriso_pricegrid/adminhtml_validate');
        $session = Mage::getSingleton('adminhtml/session');
        $helper = Mage::helper('atsumoriso_pricegrid');

        $productsIdsArray = $params['product'];
        $operation        = $validator->cleanInputValue($params['operation']);
        $valueToUpdate    = $validator->cleanInputValue($params['value']);

        $updatePrice = Mage::getModel('atsumoriso_pricegrid/adminhtml_updateprice', $operation);

//        if(!in_array($operation, Mage::getModel('atsumoriso_pricegrid/adminhtml_updatePrice_lib_operations')->getOperations())){
//            $errorMessage = 'Operation does not exist';
        //} else
        if ($validator->checkIfNumeric($valueToUpdate) === false){
            $errorMessage = 'Only numbers allowed. ' . ucfirst(gettype($valueToUpdate)) . ' given.';
        } elseif ($validator->checkIfPositive($valueToUpdate) === false){
            $errorMessage = 'Values smaller than 0.01 are not allowed';
        }

        if(!empty($errorMessage)){
            $session->addError($helper->__($errorMessage));
        } elseif($updatePrice->save($productsIdsArray, $valueToUpdate)) {
            $session->addSuccess($helper->__(
                'Totally %d record(s) have been changed.', count($productsIdsArray))
            );
        }

        $this->_redirect('adminhtml/catalog_product');
    }


}
