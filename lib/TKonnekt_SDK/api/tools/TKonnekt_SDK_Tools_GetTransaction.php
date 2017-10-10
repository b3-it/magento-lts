<?php
/**
 * Stellt die Konfiguration für einen Get-Transaktionsaufruf bereit.
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */

class TKonnekt_SDK_Tools_GetTransaction extends TKonnekt_SDK_AbstractApi implements TKonnekt_SDK_InterfaceApi
{

    /**
     * Enthält ein beliebiges Parameterfeld des API-Aufrufs. TRUE Parameter sind obligatorisch, FALSE Parameter sind optional.
     * Weitere Informationen finden Sie in der API-Dokumentation.
     *
     * @var array
     */
    protected $_paramFields = array(
        'merchantId' => TRUE,
        'reference' => TRUE,
    );


    /**
     * Enthält alle Antwortfeldparameter des API.
     *
     * @var array
     */
    protected $_responseFields = array(
        'rc' => TRUE,
        'msg' => TRUE,
        'reference' => FALSE,
        'merchantTxId' => FALSE,
        'backendTxId' => FALSE,
        'amount' => FALSE,
        'currency' => FALSE,
        'resultPayment' => FALSE,
    );

    /**
     * TRUE, wenn ein Hash benötigt wird. Dieser wird automatisch zu den Postdaten hinzugefügt.
     *
     * @var bool
     */
    protected $_needsHash = TRUE;

    /**
     * Die Request-URL der TKonnekt-API für diese Anfrage.
     *
     * @var string
     */
    protected $_requestURL = "/api/v1/transaction/status";

    /**
     * Wenn true benötigt die Methode eine Benachrichtigungsseite (notify), um das Transaktionsergebnis zu erhalten.
     *
     * @var bool
     */
    protected $_hasNotifyURL = FALSE;

    /**
     * Wenn true benötigt die Anfragemethode eine Weiterleitungsseite, auf der der Kunde an den Händler zurückgeschickt wird.
     *
     * @var bool
     */
    protected $_hasRedirectURL = FALSE;

    /**
     * Die Ergebniscodenummer einer erfolgreichen Transaktion
     *
     * @var int
     */
    protected $_paymentSuccessfulCode = 4000;
}