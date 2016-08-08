<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Addition
    extends Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Abstract
{

    public function calculate($oldPrice, $valueToUpdate){
        $a = $this->performOperationAddition($oldPrice, $valueToUpdate);
        return $a;
    }

    /**
     * Performs operation Addition.
     * @param $oldPrice
     * @param $valueToUpdate
     * @return mixed
     */
    protected function performOperationAddition($oldPrice, $valueToUpdate)
    {
        $newPrice = $oldPrice + $valueToUpdate;
        return $newPrice;
    }
}