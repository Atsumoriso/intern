<?php

class Atsumoriso_Shippingcost_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{

    /** Total amount for additional shipping cost */
    protected $_additionalShippingCost;

    public function __construct()
    {
        $this->setCode('atsumoriso_shippingcost');
    }

    public function getLabel()
    {
        return Mage::helper('atsumoriso_shippingcost')->__('Additional shipping');
    }
    /**
     * Collect total amount for 'additional shipping cost'
     *
     * @return  Mage_Sales_Model_Quote_Address $address
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $this->_additionalShippingCost = 0;
        if (($address->getAddressType() == 'billing')) {
            return $this;
        }

        $cart = Mage::getModel('checkout/cart')->getQuote();
        foreach ($cart->getAllItems() as $item) {
            $this->_additionalShippingCost += ($item->getAdditionalShippingCost() * $item->getQty());
        }

        if ($this->_additionalShippingCost) {
            $this->_addAmount($this->_additionalShippingCost);
            $this->_addBaseAmount($this->_additionalShippingCost);
        }

        return $this;
    }


    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (($address->getAddressType() == 'billing')) {

            if ($this->_additionalShippingCost != 0) {
                $address->addTotal(array(
                    'code'  => $this->getCode(),
                    'title' => $this->getLabel(),
                    'value' =>  $this->_additionalShippingCost,
                ));
            }
        }
        return $this;
    }
}