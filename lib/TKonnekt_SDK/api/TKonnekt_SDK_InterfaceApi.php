<?php
/**
 * Interface API muss implementiert werden, wenn eine neue Zahlungsmethode angelegt werden soll.
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */

interface TKonnekt_SDK_InterfaceApi
{

    /**
     * Gibt alle API-Aufrufparameterfelder in der richtigen Reihenfolge zurück.
     *
     * @param mixed[] $params
     */
    public function getSubmitParams($params);

    /**
     * Gibt alle Antwortparameterfelder in der richtigen Reihenfolge zurück.
     *
     * @param mixed[] $response
     */
    public function checkResponse($response);

    /**
     * Gibt alle Benachrichtigungsparameterfelder in der richtigen Reihenfolge zurück.
     *
     * @param mixed[] $notify
     */
    public function checkNotification($notify);

    /**
     * Gibt true zurück, wenn dem API-Aufruf ein Hash hinzugefügt werden soll.
     */
    public function needsHash();

    /**
     * Gibt die URL des API Request zurück, an den der Aufruf geschickt werden soll.
     */
    public function getRequestURL();

    /**
     * Legt die URL des Basis-API-Requests fest, an den der Aufruf gesendet werden soll.
     *
     * @param string $url
     *
     * @return string
     */
    public function setBaseRequestURL($url);

    /**
     * Gibt true zurück, wenn die API eine Benachrichtigungs-URL benötigt, an die das Transaktionsergebnis gesendet werden soll.
     */
    public function hasNotifyURL();

    /**
     * Gibt true zurück, wenn die API eine Redirect-URL benötigt, an die der Kunde nach der Zahlung geschickt werden muss.
     */
    public function hasRedirectURL();

    /**
     * Gibt den ResultCode einer erfolgreichen Transaktion zurück.
     */
    public function getTransactionSuccessfulCode();

    /**
     * Gibt den Parameternamen des Hash im API-Aufruf von TKonnekt zurück.
     */
    public function getNotifyHashName();

    /**
     * Führt einige spezielle Validierungen für diese Zahlungsmethode durch.
     *
     * @param array $params
     * @param string $strError string[OUT] Feldname im Fehlerfall
     */
    public function validateParams($params, &$strError);
} 