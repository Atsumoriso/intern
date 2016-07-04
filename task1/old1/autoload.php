<?php

//вариант 3
//один метод для автозагрузки, заменяет вариант 1
spl_autoload_register('addFilePath'); //работает!

function addFilePath($className)
{
    $className = str_replace('\\',DIRECTORY_SEPARATOR , $className);
    $fileName = $className . '.php';
    include  $fileName;
}




//вариант 1
//обычная автозагрузка без неймспейсов - работает!
//spl_autoload_register('logger');
//spl_autoload_register('common');
//
//function logger($className){
//    $fileName = 'logger/' . $className . '.php';
//    include  $fileName;
//}
//
//function common($className){
//    $fileName = 'common/' . $className . '.php';
//    include  $fileName;
//}



//вариант 2
//попытка реализации через скан директории.... не удалось
//$dirsToSkip = ['.' , '..' , 'logs', 'config'];
//$files = scandir(__DIR__);
//$dirs = [];
//    foreach ($files as $file) {
//        if(!in_array($file,$dirsToSkip) && is_dir($file)){
//            $dirs[] = $file;
//        }
//    }
//    foreach($dirs as $dir){
//        $fileName = $dir . DIRECTORY_SEPARATOR . $className . '.php';
//
//    }