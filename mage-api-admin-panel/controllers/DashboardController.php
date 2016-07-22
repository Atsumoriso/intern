<?php

namespace controllers;

use core\View;
use components\Database;
use components\Validate;
use components\Paginator;
use models\Product;

class DashboardController
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
        $this->view->render('dashboard/index',[
            'message' => isset($message) ? $message : null,
        ]);
    }

    public function actionEdit()
    {
        $productId = Validate::cleanInput($_GET['id']);
        $product = new Product($this->_connection);
        $product->load($productId);

        if(!empty($_POST)) {
            $productId = Validate::cleanInput($_GET['id']);

            $name = $_POST['name'];
            $sku = $_POST['sku'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $status = $_POST['status'];

            $name = Validate::cleanInput($name);
            $sku = Validate::cleanInput($sku);
            $description = Validate::cleanInput($description);
            $price = abs(Validate::cleanInput($price));
            if ($status == 0) {
                $status = 0;
            } else {
                $status = 1;
            }


            if (empty($name) || empty($sku) || empty($description)) {
                View::$errorMessage = Validate::$message['all_fields_required'];

            } elseif (Validate::validateMaxLength($name, 65535) === false) { //todo this 65000 is strange!
                View::$errorMessage = Validate::$message['max_lengh_65535_name'];

            } elseif (Validate::validateMaxLength($description, 65535) === false) { //todo this 65000 is strange!
                View::$errorMessage = Validate::$message['max_lengh_65535_name'];

            } elseif (Validate::validateMaxLength($sku, 255) === false) {
                View::$errorMessage = Validate::$message['max_lengh_255_sku'];

            } elseif(Validate::validatePrice($price) === false){
                View::$errorMessage = Validate::$message['price_is_float'];
            }

            if(isset(View::$errorMessage)){
                $this->view->render('dashboard/edit',[
                    'product'       => $product,
                    //values from post
                    'name'          => $name,
                    'sku'           => $sku,
                    'description'   => $description,
                    'price'         => $price,
                    'status'        => $status,
                ]);
            } else {
                $product = new Product($this->_connection);
                $product->load($productId);
                $product->setName($name);
//            $product->setSku(); //todo - do we really need to change SKU?
                $product->setStatus($status);
                $product->setDescription($description);
                $product->setPrice($price);
                $product->save();

                $_SESSION['edited_successfully'] = Validate::$message['edited_successfully'];
                header('Location:'. SITE_URL . '/dashboard/list');
            }
        }
        $this->view->render('dashboard/edit',[
            'product' => $product,
        ]);
    }

    /**
     * Retrieves products using Customer account via Magento REST API. OAuth authorization is used.
     *
     */
    public function actionRetrieve()
    {
        $base_url = $_SESSION['base_url'];
        $callbackUrl = SITE_URL. "/dashboard/retrieve";
        $temporaryCredentialsRequestUrl = $base_url . "/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
        $adminAuthorizationUrl = $base_url . '/oauth/authorize';
        $accessTokenRequestUrl = $base_url . '/oauth/token';
        $apiUrl = $base_url . Product::API_REST_PRODUCTS_URL . '?limit=100';
        $consumerKey = '7e3407909c8553ef3bc85b324113caba';
        $consumerSecret = 'c4fc9cf575afae8be7ed521c4fd844a9';

        if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
            $_SESSION['state'] = 0;
        }
        try {
            $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
            $oauthClient = new \OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
            $oauthClient->enableDebug();

            if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
                $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
                $_SESSION['secret'] = $requestToken['oauth_token_secret'];
                $_SESSION['state'] = 1;
                header('Location: ' . $adminAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
                exit;
            } else if ($_SESSION['state'] == 1) {
                $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
                $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
                $_SESSION['state'] = 2;
                $_SESSION['token'] = $accessToken['oauth_token'];
                $_SESSION['secret'] = $accessToken['oauth_token_secret'];
                header('Location: ' . $callbackUrl);
                exit;
            } else {
                $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);
                $resourceUrl = "$apiUrl";

                $oauthClient->fetch($resourceUrl, array(), 'GET', array("Content-Type" => "application/json","Accept" => "*/*"));
                //$oauthClient->fetch($resourceUrl);
                $productsList = json_decode($oauthClient->getLastResponse());

                //convert productsList object to array of objects
                $objArray=Product::object_to_array($productsList);

                foreach ($objArray as $oneProduct){
                    $product = new Product($this->_connection);
                    if(!empty($product->checkIfRecordExists($oneProduct->sku))){
                        $currentProductId = $product->checkIfRecordExists($oneProduct->sku)['id'];
                        $product->updateData($oneProduct, $currentProductId);
                    } else {
                        $product->saveData($oneProduct);
                    }
                }
                $_SESSION['imported_successfully'] = Validate::$message['imported_successfully'];
                //deleting cookie if had been set previously
                setcookie('sort', '', time() - 100000,'/');
                setcookie('direction', '', time() - 100000,'/');
                setcookie('page', '', time() - 100000,'/');

                header('Location:'. SITE_URL . '/dashboard/list');
            }
        } catch (OAuthException $e) {
            print_r($e);
        }
    }

    public function actionImport()
    {
        if(!empty($_POST)){
            $_SESSION['base_url'] = $_POST['magento_base_url'];
            header('Location:'. SITE_URL . '/dashboard/retrieve');
        }
        $this->view->render('dashboard/import');
    }

    public function actionList()
    {
        $product = new Product($this->_connection);

        //checking GET or COOKIE to keep sorting choice
        if (isset($_GET['sort']) && isset($_GET['direction'])) {
            $sort = $_GET['sort'];
            $direction = $_GET['direction'];

            setcookie("sort", $sort, time() + 36000, "/");
            setcookie("direction", $direction, time() + 36000, "/");

        } elseif (isset($_COOKIE['sort']) && isset($_COOKIE['direction'])) {
            $sort = $_COOKIE['sort'];
            $direction = $_COOKIE['direction'];
        } else {
            $sort = 'price';
            $direction = 'desc';
        }


        //check current page #
        if (isset($_GET['page'])) {
            $currentPage = $_GET['page'];
            setcookie("page", $currentPage, time() + 36000, "/");
        } elseif (isset($_COOKIE['page'])) {
            $currentPage  = $_COOKIE['page'];
        } else {
            $currentPage  = 1;
        }

        //get paginator
        $productsCount = $product->findAllAndCount();
        $paginator = new Paginator((int)$productsCount['count']); //optional second parameter - number of pages, 10 by default
        $paginator->setCurrentPage($currentPage);

        //get products with sorting options
        $products = $product->findAllAndSortByParam($sort, $direction, $currentPage, $paginator->getItemsPerPage());

        $this->view->render('dashboard/list', [
            'products'         => $products,
            'sort'             => $sort,
            'direction'        => $direction,
            'paginator'        => $paginator,
            ]);
    }

    
}