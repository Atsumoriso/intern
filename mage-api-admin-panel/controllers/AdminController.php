<?php

namespace controllers;

use core\View;
use components\Database;
use components\Validate;
use models\User;

class AdminController
{
    
    public $view;
    protected $_connection;

    public function __construct()
    {
        session_start();
        $this->_connection = Database::getInstance()->getDbConnection();
        $this->view = new View();
    }

    public function actionIndex()
    {
        if(!empty($_POST)){
            $user = new User($this->_connection);

            $email    = $_POST['email'];
            $password = $_POST['password'];
            $email    = Validate::cleanInput($email);
            $password = Validate::cleanInput($password);

            if(empty($email) || empty($password)){
                View::$errorMessage = Validate::$message['all_fields_required'];

            } elseif (!empty($email) && Validate::validateEmail($email) == false){
                View::$errorMessage = Validate::$message['email_not_valid'];

            } elseif (!empty($password) && Validate::validateMinLength($password, 6) == false){
                View::$errorMessage = Validate::$message['password_is_short'];
                
            } elseif (!empty($user->checkUserEmail($email))){
                $userData = $user->checkUserEmail($email);
                $passwordHash = md5($password);
                if($passwordHash != $userData['password_hash']){
                    View::$errorMessage = Validate::$message['email_pass_are_not_correct'];
                } else {
                    $_SESSION['authorized'] = 1;
                    $_SESSION['user_email'] = $userData['email'];
                    $_SESSION['user_name'] = $userData['lastname']. " " .$userData['firstname'];

                    $_SESSION['signed_in'] = Validate::$message['signed_in'];
                    header('Location:' . SITE_URL . '/dashboard');

                }
            }
            $this->view->renderAdminPage('admin/index');
        }

        $this->view->renderAdminPage('admin/index');
    }


    public function actionLogout()
    {
        $post = $_POST['logout'];
        if(!empty($post) && $post == 'logout' ){
            setcookie('sort', '', time() - 100000,'/');
            setcookie('direction', '', time() - 100000,'/');
            setcookie('page', '', time() - 100000,'/');

            session_unset();
            session_destroy();

            session_start();
            $_SESSION['logged_out'] = Validate::$message['logged_out'];
            header('Location:' . SITE_URL . '/admin' );
        }
        header('Location:' . SITE_URL . '/dashboard' );
    }
    
}