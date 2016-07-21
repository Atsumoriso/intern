<?php

namespace core;

/**
 * Class Validate.
 * Class used for validation.
 *
 * @package core
 */
class Validate
{
    public static function cleanInput($value = "")
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    public static function validateEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $email))
            return false;
        else
            return true;
    }

    public static function validateMinLength($item, $min)
    {
        if (strlen($item) < $min)
            return false;
        else
            return true;
    }

    public static function validateMaxLength($item, $max)
    {
        if (strlen($item) > $max)
            return false;
        else
            return true;
    }

    public static function validatePrice($price) {
        if(is_numeric($price)){
            if (preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price)) {
                return true;
            }
            return false;
        }
        return false;
    }

}

