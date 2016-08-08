<?php

/**
 * Class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Strategy.
 *
 * Chooses math operation (strategy) and returns correspondent class name.
 */
class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Strategy
{
    private $strategy;

    public function __construct($strategy){
        $config = Mage::getConfig()->getNode('global/update_price_mass_action/operations/' . $strategy);
        $this->strategy = Mage::getModel($config->class);
    }

    /**
     * Calculates new price.
     * @param $oldPrice
     * @param $valueToUpdate
     * @return mixed
     */
    public function calculateNewPrice($oldPrice, $valueToUpdate)
    {
        return $this->strategy->calculate($oldPrice, $valueToUpdate);
    }
}