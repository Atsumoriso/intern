<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_Validate
{
    /**
     * Converts coma to dot
     * @param $value
     * @return mixed
     */
    public function cleanDigitInput($value)
    {
        return str_replace(",", ".", $value);
    }

    /**
     * Checks value before multiplication.
     * @param $value
     * @return bool
     */
    public function checkValueForMultiplication($value)
    {
        if($value < 0.001)
            return false;
        else
            return true;
    }

    /**
     * Checks if percent is valid, i.e. not bigger than 100% , for operation substruction.
     * @param $percent
     * @return bool
     */
    public function checkIfValidPercent($percent)
    {
        if($percent > 100)
            return false;
        else
            return true;
    }

    /**
     * Checks if value from user is smaller than current product's price.
     * @param $oldPrice
     * @param $value
     * @return bool
     */
    public function checkIfValueSmallerThanPrice($oldPrice, $value)
    {
        if($value < $oldPrice)
            return true;
        else
            return false;
    }

    /**
     * Checks if value from user is valid, if not, returns error message.
     * @param $operation
     * @param $value
     * @return string
     */
    public function checkIfErrorsExist($operation, $value)
    {
        if (!is_numeric($value)){
            $errorMessage = 'Only numbers allowed. ' . ucfirst(gettype($value)) . ' given.';

        } elseif ($value < 0){
            $errorMessage = 'Negative values are not allowed';

        } elseif ($operation == Atsumoriso_Pricegrid_Model_Adminhtml_Updateprice::OPERATION_MULTIPLICATION
            && $this->checkValueForMultiplication($value) == false){
            $errorMessage = 'Invalid value for selected operation. It is not allowed to multiply by zero.';

        } elseif ($operation == Atsumoriso_Pricegrid_Model_Adminhtml_Updateprice::OPERATION_SUBSTRUCT_PERCENT
            && $this->checkIfValidPercent($value) == false){
            $errorMessage = 'You are not allowed to substruct more than 100 %.';

        }
        return $errorMessage;
    }

}