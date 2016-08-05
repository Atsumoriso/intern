<?php

class Atsumoriso_Shippingcost_Block_Adminhtml_Sales_Order_Totals extends  Mage_Sales_Block_Order_Totals
{

    /** @var Calculated amount for additional shipping cost  */
    protected $_additionalShippingCost;


    /**
     * Initialize order totals array.
     * And adds 'additional shipping cost' to it.
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();

        $a = $this->_order;

        $this->_additionalShippingCost = 0; //if not written, counts twice
        $params = $this->getRequest()->getParams();
        $order = Mage::getModel('sales/order_item')->getCollection();
        $order->addFieldToFilter('order_id',['eq' => $params['order_id']]);

        foreach ($order as $item) {
            $this->_additionalShippingCost += $item->getAdditionalShippingCost();
        }


        $this->addTotalBefore(new Varien_Object(array(
            'code'      => 'atsumoriso_shippingcost',
            'value'     => $this->_additionalShippingCost,
            'base_value'=> $this->_additionalShippingCost,
            'label'     => $this->__('Additional Shipping Cost'),
        ), array('shipping', 'tax')));

        return $this;
    }

}
