<?php
/**
 * Stellt die Konfiguration für einen Debitkarten-API-Aufruf bereit.
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 */

class TKonnekt_SDK_DebitCardTransaction extends TKonnekt_SDK_AbstractApi implements TKonnekt_SDK_InterfaceApi
{

    /**
     * Enthält ein beliebiges Parameterfeld des API-Aufrufs. TRUE Parameter sind obligatorisch, FALSE Parameter sind optional.
     * Weitere Informationen finden Sie in der API-Dokumentation.
     *
     * @var array
     */
    protected $_paramFields = array(
        'merchantId' => TRUE,
        'userId' => TRUE,
        'terminalId' => FALSE,
        'merchantTxId' => TRUE,
        'amount' => TRUE,
        'currency' => TRUE,
        'purpose' => TRUE,
        'locale' => FALSE,
        'urlRedirect' => TRUE,
        'urlNotify' => TRUE,
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
        'redirect' => FALSE,
    );

    /**
     * Enthält alle Benachrichtigungsparameter der API.
     *
     * @var array
     */
    protected $_notifyFields = array(
        'tkReference' => TRUE,
        'tkMerchantTxId' => TRUE,
        'tkBackendTxId' => TRUE,
        'tkAmount' => TRUE,
        'tkCurrency' => TRUE,
        'tkResultPayment' => TRUE,
        'tkResultMessage' => TRUE,
        'tkResultLocale' => TRUE,
        'tkCustomerReceipt' => FALSE,
        'tkMerchantReceipt' => FALSE,
        'tkHash' => TRUE,
    );

    /**
     * TRUE, wenn ein Hash benötigt wird. Dieser wird automatisch zu den Postdaten hinzugefügt.
     *
     * @var bool
     */
    protected $_needsHash = TRUE;

    /**
     * Der Feldname, in dem der Hash an die Benachrichtigungs- oder Weiterleitungsseite gesendet wird.
     *
     * @var string
     */
    protected $_notifyHashName = 'tkHash';

    /**
     * Die Request-URL der TKonnekt-API für diese Anfrage.
     *
     * @var string
     */
    protected $_requestURL = "/api/v1/transaction/start";

    /**
     * Wenn true benötigt die Methode eine Benachrichtigungsseite (notify), um das Transaktionsergebnis zu erhalten.
     *
     * @var bool
     */
    protected $_hasNotifyURL = TRUE;

    /**
     * Wenn true benötigt die Anfragemethode eine Weiterleitungsseite, auf der der Kunde an den Händler zurückgeschickt wird.
     *
     * @var bool
     */
    protected $_hasRedirectURL = TRUE;

    /**
     * Die Ergebniscodenummer einer erfolgreichen Transaktion
     *
     * @var int
     */
    protected $_paymentSuccessfulCode = 4000;
}