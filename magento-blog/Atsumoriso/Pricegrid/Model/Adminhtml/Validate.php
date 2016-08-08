<?php

class Atsumoriso_Pricegrid_Model_Adminhtml_Validate
{
    /**
     * Cleans input value and checks for php, html tags, etc.
     * @param $value
     * @return mixed
     */
    public function cleanInputValue($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }


    /**
     * Checks if input valus is numeric.
     * @param $value
     * @return bool
     */
    public function checkIfNumeric($value)
    {
        if(is_numeric($value))
            return true;
        else
            return false;
    }

    /**
     * Checks if input value is more than 0.01.
     * @param $value
     * @return bool
     */
    public function checkIfPositive($value)
    {
        if($value < 0.01)
            return false;
        else
            return true;
    }

}