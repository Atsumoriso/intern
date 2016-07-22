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
