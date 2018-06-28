<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im TKonnekt-Verfahren (Debitkarten).
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 */
class Egovs_Paymentbase_Helper_Tkonnekt_Factory
{
    private static $__instance = null;

    private function __construct() {
        $libDIR = Mage::getBaseDir('lib');
        $classPath = $libDIR . '/TKonnekt_SDK/TKonnekt_SDK.php';
        if (is_file($classPath)) {
            require_once $classPath;
        }

        $config = TKonnekt_SDK_Config::getInstance();
        $_debug = self::getDebug() > 0 ? true : false;
        $config->setConfig('DEBUG_MODE', $_debug);
        $config->setConfig('DEBUG_PATH', Mage::getBaseDir('var') . DS . 'log');
        //TODO: Pfad zu CA Bundle setzen
        //FIXME: Pfad muss vor allem für Windows per INI_SET oder in PHP INI gesetzt werden
        //https://curl.haxx.se/docs/sslcerts.html
        //https://curl.haxx.se/docs/caextract.html
        //curl.cainfo =
        $config->setConfig('CURLOPT_CAINFO', null);

        $config->setConfig('BASE_REQUEST', self::getServerUrl());
    }

    public static function initTkonnekt() {
        if (is_null(self::$__instance)) {
            self::$__instance = new self;
        }
        return self::$__instance;
    }

    /**
     * Liefert Debug-Level
     *
     * @return int
     *
     * @see Gka_Tkonnektpay_Model_Adminhtml_System_Config_Source_Debug
     */
    public static function getDebug() {
        return Mage::getStoreConfigFlag('payment/gka_tkonnektpay_debitcard/debug_level');
    }

    /**
     * Get Server URL
     *
     * @return string
     */
    public static function getServerUrl() {
        $serverUrl = Mage::getStoreConfig('payment/gka_tkonnektpay_debitcard/server_url');

        return $serverUrl;
    }

}