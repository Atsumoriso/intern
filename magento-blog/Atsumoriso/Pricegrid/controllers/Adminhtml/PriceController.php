<?php


class Atsumoriso_Pricegrid_Adminhtml_PriceController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();

        $productsIdsArray = $params['product'];
        $operation        = $params['operation'];
        $value            = $params['value'];

        $value = Mage::getModel('atsumoriso_pricegrid/adminhtml_validate')->cleanDigitInput($value);
        $errorMessage = Mage::getModel('atsumoriso_pricegrid/adminhtml_validate')->checkIfErrorsExist($operation,$value);

        if(!empty($errorMessage)){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('atsumoriso_pricegrid')->__($errorMessage));

        } elseif(Mage::getModel('atsumoriso_pricegrid/adminhtml_updateprice')->saveNewPriceToProductCollection($productsIdsArray, $operation, $value) == true){
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('atsumoriso_pricegrid')->__(
                'Totally %d record(s) have been changed.', count($productsIdsArray))
            );
        }

        $this->_redirect('adminhtml/catalog_product');
    }


}
