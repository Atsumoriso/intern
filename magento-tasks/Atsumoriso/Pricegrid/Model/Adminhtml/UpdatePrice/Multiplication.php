<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Multiplication
    extends Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Abstract
{
    public function calculate($oldPrice, $valueToUpdate){
        return $this->performOperationMultiplicate($oldPrice, $valueToUpdate);
    }

    protected function performOperationMultiplicate($oldPrice, $valueToUpdate)
    {
        return $oldPrice * $valueToUpdate;
    }
}