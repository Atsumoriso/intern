<?php

class Atsumoriso_Pricegrid_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function cleanDigitInput($value)
    {
        $value             = str_replace(",", ".", $value);
        $value             = (float)abs($value);
        return $value;
    }

    public function validateValueForMultiplication($value)
    {
        if($value < 0.01)
            return false;
        else
            return true;
    }

    public function performOperationSubstruction($price, $value)
    {
        if ($value > $price) {
            $newPrice = 0;
        } else {
            $newPrice = $price - $value;
        }
        return $newPrice;
    }

    public function performOperationAddition($price, $value)
    {
        return $price + $value;
    }

    public function performOperationAddPercent($price, $value)
    {
        return $price + ($price * $value) / 100;
    }

    public function performOperationSubstructPercent($price, $value)
    {
        if($value >100){
            $newPrice = 0;
        } else {
            $newPrice = $price - ($price * $value) / 100;
        }
        return $newPrice;
    }

    public function performOperationMultiplication($price, $value)
    {
        return $price * $value;
    }

}