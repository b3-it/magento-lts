<?php

/**
 * Lädt TKonnekt SDK Config
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */
class TKonnekt_SDK_Config
{
    static private $instance = null;
    private $config = null;

    private function __construct() {
    }

    static public function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self;

            // Set default values
            self::$instance->setConfig('CURLOPT_CAINFO', null);
            self::$instance->setConfig('CURLOPT_SSL_VERIFYPEER', TRUE);
            self::$instance->setConfig('CURLOPT_SSL_VERIFYHOST', 2);
            self::$instance->setConfig('CURLOPT_CONNECTTIMEOUT', 3);

            // Optional proxy parameters
            self::$instance->setConfig('CURLOPT_PROXY', null);
            self::$instance->setConfig('CURLOPT_PROXYPORT', null);
            self::$instance->setConfig('CURLOPT_PROXYUSERPWD', null);

            // Debug mode and log
            self::$instance->setConfig('DEBUG_MODE', FALSE);
            self::$instance->setConfig('DEBUG_LOG_PATH', dirname(__FILE__) . '/log');

            self::$instance->setConfig('BASE_REQUEST', null);
        }
        return self::$instance;
    }

    /**
     * Getter für Konfigurationswerte
     *
     * @param $key
     * @return null
     */
    public function getConfig($key) {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return null;
    }

    /**
     * Setter für Konfigurationswerte
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function setConfig($key, $value) {

        switch ($key) {
            //curl options
            case 'CURLOPT_CAINFO':
            case 'CURLOPT_SSL_VERIFYPEER':
            case 'CURLOPT_SSL_VERIFYHOST':
            case 'CURLOPT_CONNECTTIMEOUT':

                // Proxy
            case 'CURLOPT_PROXY':
            case 'CURLOPT_PROXYPORT':
            case 'CURLOPT_PROXYUSERPWD':

                // Debug
            case 'DEBUG_LOG_PATH':
            case 'DEBUG_MODE':
                // Base Request
            case 'BASE_REQUEST':
                $this->config[$key] = $value;
                return true;
                break;

            default:
                return false;
        }
    }

    private function __clone() {
    }

}