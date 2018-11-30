<?php

/**
 * Request-Klasse die API-Aufrufe an TKonnekt verwaltet
 *
 * Verwendung (siehe Beispielabschnitt):
 *
 * 1. Instanziieren Sie eine neue Request-Klasse und übergeben Sie dem Konstruktor eine Api-Methode.
 * 2. Übergeben Sie die Submit-Parameter (siehe API-Dokumentation) und rufen Sie submit() auf.
 * 3. Benutzen Sie den getResponseParam, um das Ergebnis abzurufen.
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */
class TKonnekt_SDK_Request
{
    /**
     * Speichert jeden Parameter, der an TKonnekt gesendet werden soll.
     *
     * @var array
     */
    private $__params = array();

    /**
     * Speichert alle Antwortparameter der TKonnekt-Antwort
     *
     * @var array
     */
    private $__response = array();

    /**
     * Speichert die RAW-Antwort von TKonnekt
     *
     * @var string
     */
    private $__responseRaw = '';

    /**
     * Speichert das Geheimnis
     *
     * @var string
     */
    private $__secret = '';

    /**
     * stores the api call request method object
     *
     * @var TKonnekt_SDK_InterfaceApi
     */
    private $__requestMethod;


    /**
     * Instantiiert Anfrage
     *
     * Es muss eine Request-Methodeninstanz übergeben werden (siehe Beispielabschnitt)
     *
     * @param TKonnekt_SDK_InterfaceApi|string $apiCallMethod
     *
     * @throws TKonnekt_SDK_Exception
     */
    function __construct($apiCallMethod) {
        $_config = TKonnekt_SDK_Config::getInstance();

        if (is_object($apiCallMethod)) {
            $this->__requestMethod = $apiCallMethod;

            if ($_config->getConfig('DEBUG_MODE')) {
                $_callMethod = str_replace("TKonnekt_SDK_", '', get_class($apiCallMethod));

                TKonnekt_SDK_Debug_Helper::getInstance()->init('request-' . $_callMethod);
                TKonnekt_SDK_Debug_Helper::getInstance()->logTransaction($_callMethod);
            }
        } elseif (is_string($apiCallMethod)) {
            if ($_config->getConfig('DEBUG_MODE')) {
                TKonnekt_SDK_Debug_Helper::getInstance()->init('request-' . $apiCallMethod);
                TKonnekt_SDK_Debug_Helper::getInstance()->logTransaction($apiCallMethod);
            }

            $this->__requestMethod = TKonnekt_SDK_TransactionType_Helper::getTransactionTypeByName($apiCallMethod);

            if (is_null($this->__requestMethod)) {
                throw new TKonnekt_SDK_Exception('Failure: API call method unknown');
            }
        }

        if (($_baseRequest = $_config->getConfig('BASE_REQUEST'))) {
            $this->__requestMethod->setBaseRequestURL($_baseRequest);
        }
    }

    /**
     * Fügt der Parameter-Variablen ein Schlüsselwertpaar hinzu. Wird verwendet, um die Anforderung mit Daten zu füllen.
     *
     * @param string $param key
     * @param string $value value
     *
     * @return TKonnekt_SDK_Request $this own instance
     *
     * @throws TKonnekt_SDK_Exception
     */
    public function addParam($param, $value) {
        if (!$this->__requestMethod->hasParam($param)) {
            throw new TKonnekt_SDK_Exception('Failure: param "' . $param . '" not valid or misspelled. Please check API Params List.');
        }

        $this->__params[$param] = $value;

        return $this;
    }

    /**
     * Entfernt ein Schlüsselwertpaar aus der Parameter-Variablen.
     *
     * @param string $param key
     *
     * @return TKonnekt_SDK_Request $this own instance
     */
    public function unsetParam($param) {
        unset($this->__params[$param]);
        return $this;
    }

    /**
     * Gibt den Wert der Parameter-Variablen mit dem angegebenen Schlüssel zurück.
     *
     * @param string $param key
     *
     * @return String $value value assigned to the given key
     */
    public function getParam($param) {
        if (isset($this->__params[$param])) {
            return $this->__params[$param];
        }
        return null;
    }

    /**
     * Gibt den Wert aus der Antwort der Anfrage zurück.
     *
     * @param string $param key
     *
     * @return null|string $value Wert, der dem angegebenen Schlüssel zugeordnet ist
     */
    public function getResponseParam($param) {
        if (isset($this->__response[$param])) {
            return $this->__response[$param];
        }
        return null;
    }

    /**
     * Gibt ein Array aller Werte aus der Antwort der Anfrage zurück.
     *
     * @return array Antwortwerte
     */
    public function getResponseParams() {
        return $this->__response;
    }

    /**
     * Gibt die RAW-Antwort der Anfrage zurück.
     *
     * @return string RAW Antwortwerte
     */
    public function getResponseRaw() {
        return $this->__responseRaw;
    }

    /**
     * Legt das Geheimnis fest, das für die Hash-Generierung oder den Hash-Vergleich verwendet wird.
     *
     * @param string $secret
     *
     * @return TKonnekt_SDK_Request $this
     */
    public function setSecret($secret) {
        $this->__secret = $secret;
        return $this;
    }

    /**
     * Sendet die Anfrage mit der angegebenen Requestmethode an die TKonnekt API.
     * Verwendet alle angegebenen und benötigten Parameter in der richtigen Reihenfolge.
     *
     * @return boolean
     *
     * @throws TKonnekt_SDK_Exception
     */
    public function submit() {
        $header = array();
        $body = '';
        $_config = TKonnekt_SDK_Config::getInstance();

        if ($_config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->logParamsSet($this->__params);
        }

        if ($_config->getConfig('BASE_REQUEST')) {
            $this->__requestMethod->setBaseRequestURL($_config->getConfig('BASE_REQUEST'));
        }

        try {
            $_submitParams = $this->__requestMethod->getSubmitParams($this->__params);

            // Some special validations
            $_strError = "";
            if (!$this->__requestMethod->validateParams($_submitParams, $_strError)) {
                throw new TKonnekt_SDK_Exception('Parameter error: ' . $_strError);
            }

            if ($this->__requestMethod->needsHash()) {
                $_submitParams['hash'] = TKonnekt_SDK_Hash_Helper::getHMACSHA256Hash($this->__secret, $_submitParams);
            }

            $_submitParams['sourceId'] = $this->getHostSourceId() . ';' . $this->getSDKSourceId() . ';';

            if (isset($this->__params['sourceId'])) {
                $_submitParams['sourceId'] .= $this->__params['sourceId'];
            } else {
                $_submitParams['sourceId'] .= ';';
            }

            // Send additional info fields for support reasons
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $_submitParams['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
            }
            if (isset($this->__params['orderId'])) {
                $_submitParams['orderId'] = $this->__params['orderId'];
            }
            if (isset($this->__params['customerId'])) {
                $_submitParams['customerId'] = $this->__params['customerId'];
            }

            list($header, $body) = TKonnekt_SDK_Curl_Helper::submit($this->__requestMethod->getRequestURL(), $_submitParams);
            $this->__responseRaw = print_r($header, TRUE) . "\n$body";

            $_response = TKonnekt_SDK_Curl_Helper::getJSONResponseToArray($body);

            /*
             * Kommunikationsfehler werden im rc Parameter im Bereich 5000 <= rc < 6000 festgelegt
             * und bedürfen keinem hash Parameter (technisch nicht möglich!)
             */
            if ($_response['rc'] >= 5000 && $_response['rc'] < 6000) {
                $msg = sprintf("%s[%s]", $_response['msg'], $_response['rc']);
                throw new TKonnekt_SDK_Exception("communication failure: $msg");
            } elseif (!isset($header['hash'])) {
                throw new TKonnekt_SDK_Exception('hash in response is missing');
            } elseif (isset($header['hash']) && !hash_equals($header['hash'], TKonnekt_SDK_Hash_Helper::getHMACSHA256HashString($this->__secret, $body))) {
                throw new TKonnekt_SDK_Exception('hash mismatch in response');
            } else {
                $this->__response = $this->__requestMethod->checkResponse($_response);
                if ($_config->getConfig('DEBUG_MODE')) {
                    TKonnekt_SDK_Debug_Helper::getInstance()->logReplyParams($this->__response);
                }
            }
        } catch (Exception $e) {
            $_header = array();
            foreach ($header as $k => $v) {
                $_header[] = "$k=$v";
            }
            $header = $_header;
            throw new TKonnekt_SDK_Exception('Failure: ' . $e->getMessage() . "\n" . implode("\r\n", $header) ."\r\n". $body);
        }

        return TRUE;
    }

    /**
     * Liefert sourceId des Hosts zurück
     *
     * @return string  sourceId des Hosts
     */
    public function getHostSourceId() {
        if (isset($_SERVER['SERVER_NAME'])) {
            return $_SERVER['SERVER_NAME'];
        }
        return '';
    }

    /**
     * Liefert sourceId dieses SDKs zurück
     *
     * @return string  Version Information von diesem SDK
     */
    public function getSDKSourceId() {
        return 'PHP ' . __TKONNEKT_SDK_VERSION__;
    }

    /**
     * Modifiziert Header um Redirect Adresse zu senden
     */
    public function redirectCustomerToPaymentProvider() {
        if (isset($this->__response['redirect'])) {
            header('location:' . $this->__response['redirect']);
            exit;
        } elseif (isset($this->__response['url'])) {
            header('location:' . $this->__response['url']);
            exit;
        }
    }

    /**
     * Liefert Antwort-Message aus dem Response
     *
     * @return string
     */
    public function getResponseMessage() {
        return $this->getResponseParam('msg');
    }

    /**
     * Gibt true zurück, wenn der Zahlungsvorgang erfolgreich war
     *
     * @return boolean result of payment
     */
    public function paymentSuccessful() {
        if ($this->requestHasSucceeded() && $this->__requestMethod->isDirectPayment()) {
            return $this->__requestMethod->getTransactionSuccessfulCode() == $this->__response['resultPayment'];
        }

        return false;
    }

    /**
     * Gibt true zurück, wenn die Anfrage erfolgreich war und die Antwort keinen ErrorCode hatte.
     * Es prüft nicht, ob die Transaktion oder Zahlung erfolgreich war.
     *
     * @return bool
     */
    public function requestHasSucceeded() {
        if (isset($this->__response['rc'])
            && $this->__response['rc'] == 0
        ) {
            return TRUE;
        }

        return FALSE;
    }
}