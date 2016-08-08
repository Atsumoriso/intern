<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_AddPercent
    extends Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Abstract
{
    public function calculate($oldPrice, $valueToUpdate){
        return $this->performOperationAddPercent($oldPrice, $valueToUpdate);
    }

    protected function performOperationAddPercent($oldPrice, $valueToUpdate)
    {
        return $oldPrice + ($oldPrice * $valueToUpdate) / 100;
    }
}