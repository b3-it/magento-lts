<?php
/**
 * Stellt die Konfiguration für einen Get-Transaktionsaufruf bereit.
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */

class TKonnekt_SDK_Tools_IsAlive extends TKonnekt_SDK_AbstractApi implements TKonnekt_SDK_InterfaceApi
{

    /**
     * Enthält ein beliebiges Parameterfeld des API-Aufrufs. TRUE Parameter sind obligatorisch, FALSE Parameter sind optional.
     * Weitere Informationen finden Sie in der API-Dokumentation.
     *
     * @var array
     */
    protected $_paramFields = array(
        'merchantId' => TRUE,
        'notifyUrl' => TRUE,
    );


    /**
     * Enthält alle Antwortfeldparameter des API.
     *
     * @var array
     */
    protected $_responseFields = array(
        'rc' => TRUE,
        'msg' => TRUE,
    );

    /**
     * Enthält alle Benachrichtigungsparameter der API.
     *
     * @var array
     */
    protected $_notifyFields = array(
        'tkResult' => TRUE,
        'tkResultMessage' => TRUE,
        'tkResultLocale' => TRUE,
        'tkHash' => TRUE,
    );

    /**
     * Der Feldname, in dem der Hash an die Benachrichtigungs- oder Weiterleitungsseite gesendet wird.
     *
     * @var string
     */
    protected $_notifyHashName = 'tkHash';

    /**
     * Der Feldname, in dem das Result an die Benachrichtigungs- oder Weiterleitungsseite gesendet wird.
     *
     * @var string
     */
    protected $_notifyResultName = 'tkResult';

    /**
     * TRUE, wenn ein Hash benötigt wird. Dieser wird automatisch zu den Postdaten hinzugefügt.
     *
     * @var bool
     */
    protected $_needsHash = TRUE;

    /**
     * Die Request-URL der TKonnekt-API für diese Anfrage.
     *
     * @var sting
     */
    protected $_requestURL = "/api/v1/transaction/alive";

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
    protected $_hasRedirectURL = FALSE;

    /**
     * Die Ergebniscodenummer einer erfolgreichen Transaktion
     *
     * @var int
     */
    protected $_paymentSuccessfulCode = 4000;
}