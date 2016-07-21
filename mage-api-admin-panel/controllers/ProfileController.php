<?php

namespace controllers;

use core\View;

class ProfileController
{
    
    public $view;

    public function __construct()
    {
        session_start();
        $this->view = new View();
    }

    public function actionIndex()
    {
        $this->view->render('profile/index');
    }

}