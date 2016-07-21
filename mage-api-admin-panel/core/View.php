<?php

namespace core;

/**
 * Class View.
 * Class to work with views.
 *
 * @package core
 */
class View
{
    public $viewsBaseDir = __DIR__ . '/../views/';

    public static $successMessage;
    public static $errorMessage;

    public static $message = [
        //common
        'all_fields_required'               => 'All fields are required.',

        //admin panel log in validation messages
        'email_not_valid'                   => 'Email is not valid. E-mail should be in the format "example@test.com".',
        'password_is_short'                 => 'Password should be not less than 6 symbols',
        'email_pass_are_not_correct'        => 'Email or password are not correct.',
        'signed_in'                         => 'You have just signed in successfully!',

        //product validation messages
        'max_lengh_255_sku'                 => 'SKU length should be less than 255 symbols!',
        'max_lengh_65535_name'              => 'Name field is TOOOOOO big! Please make it shorter',
        'max_lengh_65535_description'       => 'Description field is TOOOOOO big! Please make it shorter',
        'price_is_float'                    => 'Price should contain digits only! Maximum 12 digits before dot (.) and maximum 2 after dot, in the format 999 or 999.77',
    ];


    function render($page, $data = null)
    {
        if(isset($data)) extract($data);

        include_once $this->viewsBaseDir . 'layouts/header.php';
        include_once $this->viewsBaseDir . 'layouts/panel.php';

        include_once $this->viewsBaseDir . $page. '.php';

        include_once $this->viewsBaseDir . 'layouts/footer.php';
    }

    function renderAdminPage($page)
    {
        include_once $this->viewsBaseDir . $page. '.php';
    }

}
