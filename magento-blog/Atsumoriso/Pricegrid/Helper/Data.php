<?php

class Atsumoriso_Pricegrid_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function cleanDigitInput($value)
    {
        $value             = str_replace(",", ".", $value);
        $value             = (float)abs($value);
        return $value;
    }

    /**
     * Checks value before multiplication
     * @param $value
     * @return bool
     */
    public function validateValueForMultiplication($value)
    {
        if($value < 0.01)
            return false;
        else
            return true;
    }

    /**
     * Performs operation Addition.
     *
     * @param $price
     * @param $valueToChangePrice
     * @return mixed
     */
    public function performOperationAddition($price, $valueToChangePrice)
    {
        return $price + $valueToChangePrice;
    }

    /**
     * Performs operation Substruction.
     *
     * @param $price
     * @param $valueToChangePrice
     * @return int
     */
    public function performOperationSubstruction($price, $valueToChangePrice)
    {
        if ($valueToChangePrice > $price) {
            $newPrice = 0;
        } else {
            $newPrice = $price - $valueToChangePrice;
        }
        return $newPrice;
    }

    /**
     * Performs operation Percent addition.
     *
     * @param $price
     * @param $percent
     * @return mixed
     */
    public function performOperationAddPercent($price, $percent)
    {
        return $price + ($price * $percent) / 100;
    }

    /**
     * Performs operation Percent substruction.
     *
     * @param $price
     * @param $percent
     * @return mixed
     */
    public function performOperationSubstructPercent($price, $percent)
    {
        if($percent >100){
            $newPrice = 0;
        } else {
            $newPrice = $price - ($price * $percent) / 100;
        }
        return $newPrice;
    }

    /**
     * Performs operation Multiplication.
     *
     * @param $price
     * @param $value
     * @return mixed
     */
    public function performOperationMultiplication($price, $value)
    {
        return $price * $value;
    }

}