<?php

/**
 * Class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Operations.
 *
 * Retrieves operations array from configuration.
 *
 */
class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Operations
{
    protected $operations;

    /**
     * Returns operations array.
     *
     * @return array
     */
    public function getOperations()
    {
        return $this->retrieveOperations();
    }

    /**
     * Retrieves operations array from configuration.
     */
    protected function retrieveOperations()
    {
        $operationsArray = [];
        $config = Mage::getConfig()->getNode('global/update_price_mass_action/operations')->asArray();
        foreach ($config as $key=>$value){
            $operationsArray[$key] = $value['label'];
        }
        return $operationsArray;
    }
}