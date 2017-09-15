<?php

/**
 * Abstrakte API-Klasse für alle TKonnekt API-Aufrufe.
 * Bietet die meisten Schnittstellenfunktionen. Eine neue Zahlungsmethode sollte diese Klasse verwenden.
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */
class TKonnekt_SDK_AbstractApi implements TKonnekt_SDK_InterfaceApi
{

    /**
     * Nur für Entwicklungszwecke
     */
    function __construct() {
        try {
            if ((function_exists('apache_getenv') && strlen(apache_getenv('TKONNEKT_SERVER'))) ||
                (getenv('TKONNEKT_SERVER'))
            ) {
                $url = parse_url($this->_requestURL);

                if (function_exists('apache_getenv') && strlen(apache_getenv('TKONNEKT_SERVER'))) {
                    $this->_requestURL = apache_getenv('TKONNEKT_SERVER') . $url['path'];
                } else {
                    $this->_requestURL = getenv('TKONNEKT_SERVER') . $url['path'];
                }
            }
        } catch (Exception $e) {
        }
    }

    /**
     * Prüft, ob der Parameter vorhanden ist. Groß- und Kleinschreibung wird beachtet.
     *
     * @param string $param
     *
     * @return boolean true if param exists
     */
    public function hasParam($paramName) {
        if (isset($this->_paramFields[$paramName])) {
            return true;
        } elseif ('sourceId' === $paramName) {
            return true;
        } //default field due to support issues
        elseif ('userAgent' === $paramName) {
            return true;
        }
        //TODO: checkt to remove
        //default field due to support issues
        elseif ('orderId' === $paramName) {
            return true;
        } //default field due to support issues
        elseif ('customerId' === $paramName) {
            return true;
        } //default field due to support issues
        return false;
    }


    /**
     * Gibt alle API-Aufrufparameterfelder in der richtigen Reihenfolge zurück.
     * Beanstandet, wenn ein Pflichtfeld nicht vorhanden oder leer ist.
     *
     * @param mixed[] $params
     *
     * @return mixed[] $submitParams
     * @throws Exception if one of the mandatory fields is not set
     */
    public function getSubmitParams($params) {

        foreach ($this->_paramFields as $k => $mandatory) {
            if (isset($params[$k]) && strlen($params[$k]) > 0) {
                $_submitParams[$k] = $params[$k];
            } elseif ((!isset($params[$k]) || strlen($params[$k]) == 0) && $mandatory) {
                throw new Exception('mandatory field ' . $k . ' is unset or empty');
            }
        }

        return $_submitParams;
    }

    /**
     * Gibt alle Antwortparameterfelder in der richtigen Reihenfolge zurück.
     *
     * @param mixed[] $response
     * @return mixed[] $responseParams
     * @throws Exception if one of the mandatory fields is not set
     */
    public function checkResponse($response) {
        if (!is_array($response)) {
            return FALSE;
        }

        foreach ($this->_responseFields as $k => $mandatory) {
            if (isset($response[$k])) {
                $_responseParams[$k] = $response[$k];
            } elseif (!isset($response[$k]) && $mandatory) {
                throw new Exception('expected response field ' . $k . ' is missing');
            }
        }

        return $_responseParams;
    }

    /**
     * Gibt alle Benachrichtigungsparameterfelder in der richtigen Reihenfolge zurück.
     *
     * @param mixed[] $notify
     *
     * @return mixed[] $notifyParams
     * @throws Exception Wenn eines der Pflichtfelder nicht gesetzt ist
     */
    public function checkNotification($notify) {
        if (!is_array($notify)) {
            return FALSE;
        }

        foreach ($this->_notifyFields as $k => $mandatory) {

            if (isset($notify[$k])) {
                $_notifyParams[$k] = $notify[$k];
            } elseif (!isset($notify[$k]) && $mandatory) {
                throw new Exception('expected notification field ' . $k . ' is missing');
            }
        }

        return $_notifyParams;
    }

    /**
     * Gibt true zurück, wenn dem API-Aufruf ein Hash hinzugefügt werden soll.
     *
     * @return boolean
     */
    public function needsHash() {
        return $this->_needsHash;
    }

    /**
     * Gibt die URL des API Request zurück, an den der Aufruf geschickt werden soll.
     *
     * @return string requestURL
     */
    public function getRequestURL() {
        if (!$this->_baseRequestUrl) {
            throw new TKonnekt_SDK_Exception('No base request URL specified!');
        }
        return $this->_baseRequestUrl . $this->_requestURL;
    }

    /**
     * Legt die URL des Basis-API-Requests fest, an den der Aufruf gesendet werden soll.
     *
     * Meistens handelt es sich dabei um den Server mit TKonnekt
     *
     * @param string $url
     *
     * @return String requestURL
     * @throws TKonnekt_SDK_Exception
     */
    public function setBaseRequestURL($url) {
        if (!$url || !is_string($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new TKonnekt_SDK_Exception("Please enter a valid URL");
        }

        if (stripos($url, "http") !== 0 && stripos($url, "https") !== 0) {
            throw new TKonnekt_SDK_Exception("Only http or https protocol is allowed!");
        }

        $size = strlen($url) - 1;
        if (strrpos($url, '/') == $size) {
            $this->_baseRequestUrl = substr($url, 0, $size);
        } else {
            $this->_baseRequestUrl = $url;
        }

        return $this->_baseRequestUrl;
    }

    /**
     * Gibt true zurück, wenn die API eine Benachrichtigungs-URL benötigt, an die das Transaktionsergebnis gesendet werden soll.
     *
     * @return String notifyURL
     */
    public function hasNotifyURL() {
        return $this->_hasNotifyURL;
    }

    /**
     * Gibt true zurück, wenn die API eine Redirect-URL benötigt, an die der Kunde nach der Zahlung geschickt werden muss.
     *
     * @return String redirectURL
     */
    public function hasRedirectURL() {
        return $this->_hasRedirectURL;
    }

    /**
     * Gibt den ResultCode einer erfolgreichen Transaktion zurück.
     *
     * @return int/null notifyURL
     */
    public function getTransactionSuccessfulCode() {
        if (isset($this->_paymentSuccessfulCode)) {
            return $this->_paymentSuccessfulCode;
        }
        return NULL;
    }

    /**
     * Gibt den Parameternamen des Hash im API-Aufruf von TKonnekt zurück.
     *
     * @return int/null notifyURL
     */
    public function getNotifyHashName() {
        if (isset($this->_notifyHashName)) {
            return $this->_notifyHashName;
        }

        return NULL;
    }

    /**
     * Liefert true, wenn die API direkt bezahlt wird (ohne Init- und Zahlungsseite)
     *
     * @return bool
     */
    public function isDirectPayment() {
        return isset($this->_responseFields['resultPayment']);
    }

    /**
     * Führt einige spezielle Validierungen für diese Zahlungsmethode durch.
     *
     * @param array $params Array der Parameter aus dem Shop
     * @param $strError String [OUT] Feldname im Fehlerfall
     * @return bool TRUE wenn ok, FALSE wenn Validierungsfehler.
     */
    public function validateParams($params, &$strError) {
        $strError = "";
        return TRUE;
    }
}