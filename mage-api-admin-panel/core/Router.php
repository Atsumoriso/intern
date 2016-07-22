<?php

namespace core;

/**
 * Class Router.
 * Class for url parsing and routing
 *
 * @package core
 */
class Router
{

    public $configMain;

    public function __construct()
    {
        $this->configMain = require_once __DIR__ . '/../config/main.php';
    }

    public function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
            $uri = trim($_SERVER['REQUEST_URI']);
            return $uri;
        }
    }

    public function run()
    {
        $uri = $this->getURI();

        $parts = $this->parseUrl($uri);
       // $classNamePath = $this->getClassNamePath($parts);

        $className = $this->getClassName($parts);
        $controllerPath = '\\controllers\\' . $className;

        $methodName = $this->getMethodName($parts);
        $paramName = $this->getParamName($parts);

//        if(file_exists($className)){

        if (is_callable([$controllerPath, $methodName])) {
            $controllerInstance = new $controllerPath;
            if (isset($paramName)) {
                $controllerInstance->$methodName($paramName);
            } else {
                $controllerInstance->$methodName();
            }
        } else {
            header("Location:" . $this->configMain['local_domain_path'] . '/404.php');
        }
//      }
    }


    public function getClassName($uri)
    {
        if (!empty($uri[0])){
            return  ucfirst(strtolower($uri[0])) . 'Controller';
        } else {
            return 'AdminController';
        }

    }

//    public function getClassNamePath($uri)
//    {
//        if (!empty($uri[0])){
//            return  '\\controllers\\'. ucfirst(strtolower($uri[0])) . 'Controller.php';
//        } else {
//            return '\\controllers\\AdminController.php';
//        }
//
//    }

    public function getMethodName($uri)
    {
        if(!empty($uri[1])){
            return  'action' . ucfirst(strtolower($uri[1]));
        } else {
            return 'actionIndex';
        }
    }

    public function getParamName($uri)
    {
        if(!empty($uri[3])){
            return  $uri[3];
        } else {
            return null;
        }
    }

    public function parseUrl($url)
    {
        $part1 = strtok($url,'/');
        $part2 = strtok('/');
        $part3 = strtok('/');
        if($part3 == false) {

            $part2 = strtok($part2,'?');
            $part3 = strtok('?');
        }
        $parts=[];
        $parts[] = $part1;
        $parts[] = $part2;
        $parts[] = $part3;
        return $parts;
    }
}