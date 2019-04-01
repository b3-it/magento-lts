<?php

require_once "Uuid/bootstrap.php";

if (version_compare(phpversion(), '5.5.0', '>')) {
    spl_autoload_register(array('AtomFeed_Autoloader', 'load'), TRUE, TRUE);
} else {
    die("Your PHP version is not supported!");
}

class AtomFeed_Autoloader
{
    public static function load($classname)
    {
        $classname = str_replace('AtomFeed', '', $classname);
        $basePath = str_replace(' ', DIRECTORY_SEPARATOR, ucwords(str_replace('_', ' ', $classname)));
        $classname = basename($basePath);
        $basePath = dirname($basePath);
        $filename = $classname.'.php';

        $pathToFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $basePath . DIRECTORY_SEPARATOR . $filename;

        if (file_exists($pathToFile)) {
            require_once $pathToFile;
            return true;
        }

        return false;
    }
}