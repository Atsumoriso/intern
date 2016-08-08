<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Substraction
    extends Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Abstract
{
    public function calculate($oldPrice, $valueToUpdate){
        return $this->performOperationSubstraction($oldPrice, $valueToUpdate);
    }

    protected function performOperationSubstraction($oldPrice, $valueToUpdate)
    {
        return $oldPrice - $valueToUpdate;
    }
}