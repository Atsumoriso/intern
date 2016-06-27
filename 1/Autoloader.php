<?php

/**
 * Class Autoloader
 * Simple autoloader to load classes
 */
class Autoloader
{
    /**
     * Registers function for loading classes
     * void
     */
    public function register()
    {
        spl_autoload_register([$this,'addFilePath']);
    }

    /**
     * Changes back slash - \ to common slash - / in order to make correct route for files
     * @param $className
     */
    protected function addFilePath($className)
    {
        $className = str_replace('\\',DIRECTORY_SEPARATOR , $className);
        $fileName = $className . '.php';
        include  $fileName;
    }
}