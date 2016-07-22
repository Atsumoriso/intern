<?php

namespace components;

/**
 * Class Validate.
 * Class used for validation.
 *
 * @package components
 */
class Validate
{
    public static $message = [
        //common
        'all_fields_required'               => 'All fields are required.',

        //admin panel log in validation messages
        'email_not_valid'                   => 'Email is not valid. E-mail should be in the format "example@test.com".',
        'password_is_short'                 => 'Password should be not less than 6 symbols',
        'email_pass_are_not_correct'        => 'Email or password are not correct.',
        'signed_in'                         => 'You have just signed in successfully!',
        'logged_out'                        => 'Bye! See you soon!',

        //product validation messages
        'max_lengh_255_sku'                 => 'SKU length should be less than 255 symbols!',
        'max_lengh_65535_name'              => 'Name field is TOOOOOO big! Please make it shorter',
        'max_lengh_65535_description'       => 'Description field is TOOOOOO big! Please make it shorter',
        'price_is_float'                    => 'Price should contain digits only! Maximum 12 digits before dot (.) and maximum 2 after dot, in the format 999 or 999.77',
        'digits_only'                       => 'Only digits allowed.',
        'edited_successfully'               => 'Product has been edited successfully!',
        'imported_successfully'             => 'Products have been imported successfully!',
    ];


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
        if (preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price)) {
            return true;
        }
        return false;
    }

}

