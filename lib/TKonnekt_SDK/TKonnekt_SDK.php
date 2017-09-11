<?php
/**
 * TKonnekt SDK.
 *
 * Es muss nur diese Datei eingefügt werden um das gesamte SDK nutzen zu können. Es lädt alle erforderlichen Dateien, um das SDK zu verwenden.
 *
 * @package TKonnekt
 * @author	Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0
 */
define('__TKONNEKT_SDK_VERSION__', '1.0.0.0');

if (version_compare(phpversion(), '5.3.0', '<')) {
    // Don't use third parameter for PHP < 5.3
    spl_autoload_register(array('TKonnekt_SDK_Autoloader', 'load'), TRUE);
} else {
    spl_autoload_register(array('TKonnekt_SDK_Autoloader', 'load'), TRUE, TRUE);
}

if (defined('__TKONNEKT_SDK_DEBUG__') && __TKONNEKT_SDK_DEBUG__ === TRUE) {
    TKonnekt_SDK_Config::getInstance()->setConfig('DEBUG_MODE', TRUE);
}

class TKonnekt_SDK_Autoloader
{
    public static function load($classname)
    {
        $filename = $classname . '.php';
        $pathsArray = array('api',
            'helper',
            './',
            'api/tools',
            'api/debitcard',
        );

        foreach ($pathsArray as $path) {
            if ($path == './') {
                $pathToFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $filename;
            } else {
                $pathToFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $filename;
            }

            if (file_exists($pathToFile)) {
                require_once $pathToFile;
                return true;
            } else {
                continue;
            }
        }
        return false;
    }
}