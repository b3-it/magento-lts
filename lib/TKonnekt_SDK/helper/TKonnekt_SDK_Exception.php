<?php
/**
 * Klasse für Exceptions
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */
class TKonnekt_SDK_Exception extends Exception
{

    /**
     * TKonnekt_SDK_Exception Konstruktor
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message = null, $code = 0)
    {
        $Config = TKonnekt_SDK_Config::getInstance();

        if ($Config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->LogException($message);
        }
        parent::__construct($message, $code);
    }
}