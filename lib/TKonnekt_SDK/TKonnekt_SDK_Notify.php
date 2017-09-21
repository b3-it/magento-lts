<?php
/**
 * Dient zur Benachrichtigung und Weiterleitung von Anrufen von TKonnekt an den Händler.
 *
 * - Benachrichtigen bedeutet, dass TKonnekt das Endergebnis einer eingeleiteten Transaktion sendet.
 * - Redirect bedeutet, dass der Kunde an den Händler zurückgeschickt wird, wenn er zu einem Ort außerhalb der Händler-Website weitergeleitet wurde.
 *
 * Verwendung (siehe Beispielabschnitt):
 *
 * 1. Instanziieren Sie eine neue Notify-Klasse und übergeben Sie dem Konstruktor eine Api-Methode.
 * 2. Parsen Sie die Benachrichtigung nach gegebenem Array einschließlich der GET-Parameter.
 * 3. Überprüfen Sie den Erfolg der Transaktion.
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */

class TKonnekt_SDK_Notify
{

    /**
     * Speichert alle an TKonnekt gesendeten, bestätigten Benachrichtigungsparameter
     *
     * @var array
     */
    private $__notifyParams = array();

    /**
     * Speichert das Geheimnis
     *
     * @var string
     */
    private $__secret = '';

    /**
     * Speichert das API Request-Method-Object
     */
    private $__requestMethod;

    /**
     * Speichert das API Notify-Response
     */
    private $__notifyResponse = array();


    /**
     * Instanziierung der Benachrichtigung
     *
     * muss eine Request-Methodeninstanz übergeben werden (siehe Beispielabschnitt)
     *
     * @param TKonnekt_SDK_InterfaceApi|String $apiCallMethod
     *
     * @throws Exception Wenn keine Benachrichtigung möglich ist
     */
    function __construct($apiCallMethod) {
        $_config = TKonnekt_SDK_Config::getInstance();

        if (is_object($apiCallMethod)) {
            if ($_config->getConfig('DEBUG_MODE')) {
                $_callMethod = str_replace("TKonnekt_SDK_", '', get_class($apiCallMethod));
                TKonnekt_SDK_Debug_Helper::getInstance()->init('notify-' . $_callMethod);
                TKonnekt_SDK_Debug_Helper::getInstance()->logTransaction($_callMethod);
            }
            $this->__requestMethod = $apiCallMethod;
        } elseif (is_string($apiCallMethod)) {
            if ($_config->getConfig('DEBUG_MODE')) {
                TKonnekt_SDK_Debug_Helper::getInstance()->init('notify-' . $apiCallMethod);
                TKonnekt_SDK_Debug_Helper::getInstance()->logTransaction($apiCallMethod);
            }
            $this->__requestMethod = TKonnekt_SDK_TransactionType_Helper::getTransactionTypeByName($apiCallMethod);

            if (is_null($this->__requestMethod))
                throw new TKonnekt_SDK_Exception('Failure: API call method unknown');
        }

        if (!$this->__requestMethod->hasNotifyURL() && !$this->__requestMethod->hasRedirectURL()) {
            if ($_config->getConfig('DEBUG_MODE')) TKonnekt_SDK_Debug_Helper::getInstance()->init('notify-' . $apiCallMethod);
            throw new TKonnekt_SDK_Exception('Failure: notify or redirect not possible with this api call');
        }
    }

    /**
     * Gibt die Daten des angegebenen Parameters zurück
     *
     * @param String $param Response Parameterschlüssel
     *
     * @return String-Daten des angegebenen Responseschlüssels
     */
    public function getResponseParam($param) {
        if (isset($this->__notifyParams[$param]))
            return $this->__notifyParams[$param];
        return null;
    }


    /**
     * Gibt die gesamten Notification-Parameter-Daten zurück
     *
     * @return mixed[] array der Daten
     */
    public function getResponseParams() {
        if (isset($this->__notifyParams)) {
            return $this->__notifyParams;
        }
        return null;
    }

    /**
     * Gibt Antwort-Message
     *
     * @return string
     */
    public function getResponseMessage() {
        return $this->getResponseParam('tkResultMessage');
    }

    /**
     * Legt das Geheimnis fest, das für die Hash-Generierung oder den Hash-Vergleich verwendet wird.
     *
     * @param string $secret
     *
     * @return string $this own instance
     */
    public function setSecret($secret) {
        $this->__secret = $secret;
        return $this;
    }

    /**
     * Parst das angegebene Notification-Array
     *
     * @param mixed[] $params Parst das $_GET-Array oder validierte Eingabe
     *
     * @return boolean Wenn kein Fehler auftritt
     *
     * @throws Exception Wenn ein Fehler auftritt
     */
    public function parseNotification($params) {
        $_config = TKonnekt_SDK_Config::getInstance();

        if ($_config->getConfig('DEBUG_MODE')) TKonnekt_SDK_Debug_Helper::getInstance()->logNotificationInput($params);

        if (!is_array($params) || empty($params)) {
            throw new TKonnekt_SDK_Exception('no data given');
        }
        try {
            $this->__notifyParams = $this->__requestMethod->checkNotification($params);

            if ($_config->getConfig('DEBUG_MODE')) {
                TKonnekt_SDK_Debug_Helper::getInstance()->logNotificationParams($this->__notifyParams);
            }

            if (!$this->checkHash()) {
                throw new TKonnekt_SDK_Exception('hash mismatch');
            }
        } catch (Exception $e) {
            throw new TKonnekt_SDK_Exception('Failure: ' . $e->getMessage() . "\n");
        }

        return TRUE;
    }

    /**
     * Validiert den übergebenen Hash durch Vergleich mit einem selbst generierten Hash
     *
     * @return boolean true Falls Hash-Test bestanden wurde
     */
    public function checkHash() {
        $string = '';
        $_hashFieldName = $this->__requestMethod->getNotifyHashName();

        foreach ($this->__notifyParams as $k => $v) {
            if ($k !== $_hashFieldName)
                $string .= $v;
        }

        if ($this->__notifyParams[$_hashFieldName] === hash_hmac('sha256', $string, $this->__secret)) {
            return true;
        }

        return false;
    }

    /**
     * Gibt true zurück, wenn der Zahlungsvorgang erfolgreich war
     *
     * @return boolean Zahlungsergebnis
     */
    public function paymentSuccessful() {
        if ($this->__requestMethod->getTransactionSuccessfulCode() != null) {
            return $this->__requestMethod->getTransactionSuccessfulCode() == $this->__notifyParams['tkResultPayment'];
        }

        return false;
    }

    /**
     * Sendet Header mit OK-Status 200
     */
    public function sendOkStatus() {
        $_config = TKonnekt_SDK_Config::getInstance();

        if ($_config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->logNotificationOutput('sendOkStatus');
        }
        header('HTTP/1.1 200 OK');
    }

    /**
     * Sendet Header mit Bad Request Status 400
     */
    public function sendBadRequestStatus() {
        $_config = TKonnekt_SDK_Config::getInstance();

        if ($_config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->logNotificationOutput('sendBadRequestStatus');
        }
        header('HTTP/1.1 400 Bad Request');
    }

    /**
     * Sendet Header mit Service Unavailable-Status 503
     */
    public function sendServiceUnavailableStatus() {
        $_config = TKonnekt_SDK_Config::getInstance();

        if ($_config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->logNotificationOutput('sendServiceUnavailableStatus');
        }
        header('HTTP/1.1 503 Service Unavailable');
    }

    /**
     * Sendet Header mit Status Not Found (nicht gefunden) 404
     */
    public function sendOtherStatus() {
        $_config = TKonnekt_SDK_Config::getInstance();

        if ($_config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->logNotificationOutput('sendOtherStatus');
        }
        header('HTTP/1.1 404 Not Found');
    }
}