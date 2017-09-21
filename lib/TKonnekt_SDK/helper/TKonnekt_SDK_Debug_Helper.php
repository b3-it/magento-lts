<?php
/**
 * Helferklasse, die das Debug-Log behandelt
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */

class TKonnekt_SDK_Debug_Helper
{

    /**
     * Statische Instanz der Debug-Klasse (Singelton-Muster)
     */
    private static $__instance = null;

    /**
     * Eindeutiger Logfilename
     */
    private static $__logFileName;

    /**
     * Logfile Resource
     */
    private static $__fp;

    /**
     * Log Templates
     */
    private $debugStrings = array(
        'start' => "[start @%s]\r\n\r\n",
        'php-ini' => "[PHP ini]\r\n\r\nPHP version: %s\r\ncURL: %s\r\nssl: %s\r\n\r\n\r\n",
        'transaction' => "[transaction @%s]\r\nZahlart: %s\r\n\r\n\r\n",
        'params set' => "[params set @%s]\r\n%s\r\n\r\n",
        'curlRequest' => "[cURL request @%s]\r\nparams:\r\n%s\r\nCurlInfo:\r\n%s\r\n\r\n",
        'curlReply' => "[cURL reply @%s]\r\nresult:%s\r\ncurl_error log:%s\r\n\r\n",
        'replyParams' => "[reply params @%s]\r\n%s\r\n\r\n",
        'notifyInput' => "[notify input @%s]\r\n%s\r\n\r\n",
        'notifyParams' => "[notify params @%s]\r\n%s\r\n\r\n",
        'notifyOutput' => "[notify output]\r\n%s\r\n\r\n",
        'exception' => "[exception @%s]\r\n%s\r\n\r\n",
    );


    private function __construct() {
    }

    /**
     * Methode, um die Debug-Instanz zu erzeugen (Singelton-Muster)
     */
    public static function getInstance() {

        if (null === self::$__instance) {
            self::$__instance = new self();
        }

        return self::$__instance;
    }

    /**
     * Initialisierung des Debug-Protokolls, speichert Informationen über die Umgebung
     *
     * @param string $logFilePrefix
     *
     * @return void
     */
    public function init($logFilePrefix) {
        self::$__logFileName = date('Y-m-d_H-i-s') . '-' . ucfirst($logFilePrefix) . '-' . md5(time()) . '.log';
        $ssl = null;

        $this->writeLog(sprintf($this->debugStrings['start'], date('Y-m-d H:i:s')));

        if (in_array('curl', get_loaded_extensions())) {
            $curl_version = curl_version();
            $curl = $curl_version['version'];
            $ssl = $curl_version['ssl_version'];
        } else {
            $curl = 'no';
        }

        if (!$ssl && in_array('openssl', get_loaded_extensions())) {
            $ssl = 'yes';
        }

        if (!$ssl) {
            $ssl = 'no';
        }

        $this->writeLog(sprintf($this->debugStrings['php-ini'], PHP_VERSION, $curl, $ssl));
    }

    /**
     * schreibt Log ins Logfile
     */
    public function writeLog($string) {
        $_config = TKonnekt_SDK_Config::getInstance();
        $_path = str_replace('\\', '/', $_config->getConfig('DEBUG_LOG_PATH'));

        if (!is_dir($_path)) {
            if (!mkdir($_path)) {
                error_log('Log directory does not exist. Please create directory: ' . $_path . '.');
            }
            //write .htaccess to log directory
            $htfp = fopen($_path . '/.htaccess', 'w');
            fwrite($htfp, "Order allow,deny\nDeny from all");
            fclose($htfp);
        }

        if (!self::$__fp) {
            self::$__fp = fopen($_path . '/' . self::$__logFileName, 'a');
            if (!self::$__fp) {
                error_log('Log File (' . $_path . '/' . self::$__logFileName . ') is not writeable.');
            }
        }

        fwrite(self::$__fp, $string);
    }

    /**
     * Protokolliert Transaktionsinformationen
     *
     * @param string $apiCallName
     *
     * @return void
     */
    public function logTransaction($apiCallName) {
        $this->writeLog(sprintf($this->debugStrings['transaction'], date('Y-m-d H:i:s'), $apiCallName));
    }

    /**
     * Protokolliert vor dem Senden gesetzte Parameter
     *
     * @param string $paramsArray
     *
     * @return void
     */
    public function logParamsSet($paramsArray) {
        $_paramsString = '';

        foreach ($paramsArray as $k => $v) {
            $_paramsString .= "$k=$v\r\n";
        }

        $this->writeLog(sprintf($this->debugStrings['params set'], date('Y-m-d H:i:s'), $_paramsString));
    }

    /**
     * Speichert Request-Daten (Parameter, Curl-Info)
     *
     * @param mixed $curlInfo
     * @param array $params
     *
     * @return void
     */
    public function logRequest($curlInfo, $params) {
        $_paramsString = '';
        $_curlInfoString = '';

        foreach ($params as $k => $v) {
            $_paramsString .= "$k=$v\r\n";
        }

        foreach ($curlInfo as $k => $v) {
            if (!is_array($v))
                $_curlInfoString .= "$k=$v\r\n";
            else {
                $_curlInfoString .= "$k {\r\n";

                foreach ($v as $k2 => $v2) {
                    $_curlInfoString .= "$k2=$v2\r\n";
                }

                $_curlInfoString .= "}\r\n";
            }
        }

        $this->writeLog(sprintf($this->debugStrings['curlRequest'], date('Y-m-d H:i:s'), $_paramsString, $_curlInfoString));
    }

    /**
     * Protokolliert Server-Antwortdaten (Header und Body)
     *
     * @param string $result
     * @param string $curlError
     *
     * @return void
     */
    public function logReply($result, $curlError) {
        $this->writeLog(sprintf($this->debugStrings['curlReply'], date('Y-m-d H:i:s'), $result, $curlError));
    }

    /**
     * Protokolliert prozessierte Antwortparameter aus einem Json-Array
     *
     * @param array $params
     *
     * @return void
     */
    public function logReplyParams($params) {
        $_paramsString = '';

        foreach ($params as $k => $v) {
            $_paramsString .= "$k=" . print_r($v, true) . "\r\n";
        }

        $this->writeLog(sprintf($this->debugStrings['replyParams'], date('Y-m-d H:i:s'), $_paramsString));
    }

    /**
     * Protokolliert im Benachrichtigungs-Input-Format
     * 
     * @param array $paramsArray
     * 
     * @return void
     */
    public function logNotificationInput($paramsArray) {
        $this->writeLog(sprintf($this->debugStrings['notifyInput'], date('Y-m-d H:i:s'), print_r($paramsArray, 1)));
    }

    /**
     * Protokolliert Parameter, die für die Benachrichtigung verwendet wurden
     * 
     * @param array $paramsArray
     *
     * @return void
     */
    public function logNotificationParams($paramsArray) {
        $this->writeLog(sprintf($this->debugStrings['notifyParams'], date('Y-m-d H:i:s'), print_r($paramsArray, 1)));
    }

    /**
     * Protokolliert im Benachrichtigungs-Output-Format
     * 
     * @param string $outputType
     * 
     * @return void
     */
    public function logNotificationOutput($outputType) {
        $this->writeLog(sprintf($this->debugStrings['notifyOutput'], date('Y-m-d H:i:s'), $outputType));
    }

    /**
     * Protokolliert im Exception-Format
     * 
     * @param string $message
     * 
     * @return void
     */
    public function logException($message) {
        $this->writeLog(sprintf($this->debugStrings['exception'], date('Y-m-d H:i:s'), $message));
    }

    private function __clone() {
    }
}