<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_SubstractPercent
    extends Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Abstract
{
    public function calculate($oldPrice, $valueToUpdate){
        return $this->performOperationSubstractPercent($oldPrice, $valueToUpdate);
    }

    protected function performOperationSubstractPercent($oldPrice, $valueToUpdate)
    {
        return $oldPrice - ($oldPrice * $valueToUpdate) / 100;
    }
}