<?php

abstract class Atsumoriso_Pricegrid_Model_Adminhtml_UpdatePrice_Lib_Abstract
{
    protected abstract function calculate($oldPrice, $valueToUpdate);
}