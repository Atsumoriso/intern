<?php

namespace controllers;

use models\User;
use core\View;
use core\Validate;

class AdminController
{
    
    public $view;
    protected $_connection;

    public function __construct()
    {
        session_start();
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
                View::$errorMessage = View::$message['all_fields_required'];

            } elseif (!empty($email) && Validate::validateEmail($email) == false){
                View::$errorMessage = View::$message['email_not_valid'];

            } elseif (!empty($password) && Validate::validateMinLength($password, 6) == false){
                View::$errorMessage = View::$message['password_is_short'];
                
            } elseif (!empty($user->checkUserEmail($email))){
                $userData = $user->checkUserEmail($email);
                $passwordHash = md5($password);
                if($passwordHash != $userData['password_hash']){
                    View::$errorMessage = View::$message['email_pass_are_not_correct'];
                } else {
                    $_SESSION['authorized'] = 1;
                    $_SESSION['user_email'] = $userData['email'];
                    $_SESSION['user_name'] = $userData['lastname']. " " .$userData['firstname'];

//                    header('Location:' . SITE_URL . '/dashboard');
                    View::$successMessage = View::$message['signed_in'];
                    $this->view->render('dashboard/index', [
                        'message' => View::$successMessage,
                    ]);
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
            session_unset();
            session_destroy();
            header('Location:' . SITE_URL . '/admin' );
        }
        header('Location:' . SITE_URL . '/dashboard' );
    }
    
}