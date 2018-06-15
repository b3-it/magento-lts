<?php
/**
 * Basisklasse für ePayBL Webservices
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 -2017 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @method bool 																			 	    isAlive(string $mandantNr)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis    lesenKassenzeichenInfo(string $kzeichen)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis 	    ueberweisenVorLieferung(string $mandantenNr, string $customerID, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $buchungsListe)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis 	    ueberweisenVorLieferungMitBLP(string $customerID, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $buchungsListe, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet $buchungsListeParameter)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis 	    ueberweisenNachLieferung(string $mandantenNr, string $customerID, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $buchungsListe)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis 	    ueberweisenNachLieferungMitBLP(string $customerID, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $buchungsListe, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet $buchungsListeParameter)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis       leseBankverbindungBewirtschafter()
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis 		        lesenKunde(Egovs_Paymentbase_Model_Webservice_Types_Kunde $customer)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis       pruefenKontonummer(Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis           anlegenSEPAMandat(Egovs_Paymentbase_Model_Webservice_Types_SepaMandat $mandat)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis           deaktiviernSEPAMandat(string $eShopKundenNr, string $mandatReferenz)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis           leseSEPAMandat(string $mandatReferenz)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_EinzugsermaechtigungErgebnis vervollstaendigenSEPAMandat(string $mandatReferenz, string $datumUnterschrift, string $ortUnterschrift)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis 	    abbuchenMitSEPAMandatMitBLP(string $customerID, Egovs_Paymentbase_Model_Webservice_Types_SepaMandat $mandat, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $buchungsListe, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet $buchungsListeParameterSet)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis 	    abbuchenMitSEPAMandatreferenzMitBLP(string $customerID, string $mandat, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $buchungsListe, string $pin,Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet $buchungsListeParameterSet)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis 	    anlegenKassenzeichenMitZahlverfahrenlisteMitBLP(string $customerID, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $buchungsListe, $lieferAdresse, string $buchungsText, $zahlverfahrenListe, Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet|array $buchungsListeParameter)
 * @method SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis                     aktiviereTempKassenzeichen(string $wId, string $saferpayReferenzID, string $typZahlung)
 *
 */
class Egovs_Paymentbase_Model_Webservice_PaymentServices extends Varien_Object
{
	const EPAYMENT_NAMESPACE = 'http://www.bff.bund.de/ePayment';
	
	/**
	 * SOAP Client
	 * 
	 * @var Zend_Soap_Client
	 */
	protected $_soapClient = null;

    /**
     * Aktueller Store
     *
     * @var Mage_Core_Model_Store
     */
	private $__store = null;

	/**
	 * Flag für Reset SoapClient
	 * 
	 * Siehe #1876
	 * 
	 * @var boolean
	 */
	protected static $_alwaysResetSoapClient = false;

    /**
     * Zeigt an ob das Ergebnis aus dem Cache stammt.
     *
     * @var bool
     */
	protected $_isCachedResult = false;
	
	/**
	 * Mapped die WSDL Klassen zu PHP-Klassen für ePayBL 2.x
	 * 
	 * Funktioniert nur im WSDL-Modus des SoapClients
	 * 
	 * @var array
	 */
	protected $_classmap = array(
			'Adresse' => 'Egovs_Paymentbase_Model_Webservice_Types_Adresse',
			'LieferAdresse' => 'Egovs_Paymentbase_Model_Webservice_Types_LieferAdresse',
			'Buchung' => 'Egovs_Paymentbase_Model_Webservice_Types_Buchung',
			'BuchungsListe' => 'Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe',
			'BuchungsListeParameter' => 'Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter',
			'BuchungsListeParameterSet' => 'Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet',
			'Kunde' => 'Egovs_Paymentbase_Model_Webservice_Types_Kunde',
			'KundenErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis',
			'Ergebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis',
			'BuchungsListeErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis',
			'BankverbindungErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis',
			'KassenzeichenInfoErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis',
			'ReservierungsErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_ReservierungsErgebnis',
			'ZahlungsInfo' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_ZahlungsInfo',
			'Bankverbindung' => 'Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung',
			'Bank' => 'Egovs_Paymentbase_Model_Webservice_Types_Bank',
			'Text' => 'Egovs_Paymentbase_Model_Webservice_Types_Text',
			'SepaMandatErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis',
			'SepaMandat' => 'Egovs_Paymentbase_Model_Webservice_Types_SepaMandat',
			'SepaAmendment' => 'Egovs_Paymentbase_Model_Webservice_Types_SepaAmendment',
			'EinzugsermaechtigungErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_EinzugsermaechtigungErgebnis',
			
	);
	
	/**
	 * Mapped die zusätzlichen WSDL Klassen zu PHP-Klassen für ePayBL 3.x
	 *
	 * Funktioniert nur im WSDL-Modus des SoapClients
	 *
	 * @var array
	 */
	protected $_classmapV3 = array(
			'BankList' => 'Egovs_Paymentbase_Model_Webservice_Types_BankList',
			'BuchungList' => 'Egovs_Paymentbase_Model_Webservice_Types_BuchungList',
			'BuchungsListeParameterList' => 'Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterList',
			'KundenStatusAenderungsList' => 'Egovs_Paymentbase_Model_Webservice_Types_KundenStatusAenderungList',
			'KundenStatusAenderungsErgebnis' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_KundenStatusAenderungsErgebnis',
			'StringList' => 'Egovs_Paymentbase_Model_Webservice_Types_StringList',
			'Zahlungseingaenge' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_Zahlungseingaenge',
			'ZahlungseingangsElement' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_ZahlungseingangsElement',
			'ZahlungseingangsElementList' => 'Egovs_Paymentbase_Model_Webservice_Types_Response_ZahlungseingangsElementList',
	);
	
	protected $_deniedMethods = array (
			'_getClientCertificate', '_getSoapClient, _writeLog', '_parseCallingMethodName', '_toSoapParam',
			'_getCaCertificate',
	);
	
	protected $_uri = null;
	protected $_location = null;
	protected $_options = array();
	protected $_clientCert = null;
	protected $_caCert = null;
	
	/**
	 * Kunden Ergbnisse von ePayBL
	 *
	 * Struktur:
	 * <p>
	 *  KundenID => Ergebnis
	 * </p>
	 * @var array
	 */
	protected  $_eCustomerResult = array();
	
	/**
	 * Liefert das Client-Certifiacte
	 * 
	 * @return string
	 */
	protected function _getClientCertificate() {
		if ($this->_clientCert == null || $this->__store !== Mage::app()->getStore()) {
			$this->_clientCert = Mage::getStoreConfig('payment_services/paymentbase/client_certificate');
			if (empty($this->_clientCert)) {
				throw new Zend_Soap_Client_Exception(Mage::helper('paymentbase')->__('No client certificate for ePayBL specified!'));
			}
            $this->__store = Mage::app()->getStore();
			$this->_clientCert = Mage::getBaseDir().$this->_clientCert;
		}
		
		return $this->_clientCert;
	}
	
	/**
	 * Liefert das CA-Certifiacte
	 *
	 * @return string
	 */
	protected function _getCaCertificate() {
		if ($this->_caCert == null || $this->__store !== Mage::app()->getStore()) {
			$this->_caCert = Mage::getStoreConfig('payment_services/paymentbase/ca_certificate');
			if (empty($this->_caCert)) {
				throw new Zend_Soap_Client_Exception(Mage::helper('paymentbase')->__('No CA certifacte for ePayBL specified!'));
			}
            $this->__store = Mage::app()->getStore();
			$this->_caCert = Mage::getBaseDir().$this->_caCert;
		}
	
		return $this->_caCert;
	}
	
	protected function _parseCallingMethodName($method) {
		//Führenden '_' entfernen
		if (($pos = strpos($method, '::_')) !== false && $pos+3 < strlen($method)) {
			$method = substr($method, $pos+3);
		}
		
		return $method;
	}
	
	/**
	 * Wandelt die Parameter in SoapParam um
	 * 
	 * @param array $parameter Assoziatives Array
	 * 
	 * @return array
	 */
	protected function _toSoapParam($parameter) {
		foreach ($parameter as $key => $value) {
			if ($value instanceof Egovs_Paymentbase_Model_Webservice_Types_Abstract) {
				$parameter[$key] = $value->toSoap();
			} elseif (is_float($value)) {
				//Float muss als XSD:DECIMAL übergeben werden!
				$parameter[$key] = new SoapVar($value, XSD_DECIMAL);
			}
			
			if (is_string($key)) {
				$parameter[] = new SoapParam($parameter[$key], $key);
			} else {
				$parameter[] = $parameter[$key];
			}
			unset($parameter[$key]);
		}
		
		return $parameter; 
	}
	
	/**
	 * Liefert den Stream Context für SSL
	 * 
	 * @return resource
	 */
	protected function _getStreamContext() {
		return stream_context_create(
			array(
				'ssl' => array(
					'verify_peer' => true,
					'cafile' => $this->_getCaCertificate(),
					'local_cert' => $this->_getClientCertificate(),
					/*
					 * 20141105::Frank Rochlitzer
					 * Proxy funktioniert nicht mit SNI!
					 * http://stackoverflow.com/questions/15021180/bad-request-while-getting-wsdl-with-soapclient-through-proxy-in-php
					 */
					'SNI_enabled' => false
				),
// 				'http' => array(
// 					'proxy' => 'tcp://name:port'
// 				)
			)
		);
	}
	
	/**
	 * Gibt den SOAP Client zurück
	 *
	 * @return Zend_Soap_Client
	 */
	protected function _getSoapClient() {
		if (!$this->_soapClient || $this->__store !== Mage::app()->getStore()) {
	
			if (Mage::getStoreConfig('web/proxy/use_proxy') == true
				&& Mage::getStoreConfig('web/proxy/use_proxy_egovs_payments') == true
			) {
				$proxyHost = Mage::getStoreConfig('web/proxy/proxy_name');
				$proxyPort = Mage::getStoreConfig('web/proxy/proxy_port');
				$proxyUser = Mage::getStoreConfig('web/proxy/proxy_user');
				$proxyPass = Mage::getStoreConfig('web/proxy/proxy_user_pwd');
			}
			
			$_location = $this->_location;
			$parsedUrl = parse_url($_location);
			if (isset($parsedUrl['host'])) {
				$_location .= '?wsdl';
			}
			if (isset ($proxyHost) && trim($proxyHost) != '' && isset ($proxyPort) && trim($proxyPort) != '') {
				$this->_soapClient = new Egovs_Paymentbase_Model_Webservice_Soap_Client($_location, array (
						'proxy_port' => intval(trim($proxyPort)),
						'proxy_host' => trim($proxyHost),
						'proxy_login' => trim($proxyUser),
						'proxy_password' => trim($proxyPass),
						'cache_wsdl' => WSDL_CACHE_MEMORY,
						//'timeout' => $this->getTimeout(),
// 						'uri' => $this->_uri,
// 						'location' => $this->_location,
// 						'local_cert' => $this->_getClientCertificate(), <== 20141105::Frank Rochlitzer:Funktioniert nicht mit Proxy -> stream context muss genutzt werden
						'stream_context' => $this->_getStreamContext(),
				));
			} else {
				$this->_soapClient = new Egovs_Paymentbase_Model_Webservice_Soap_Client($_location, array (
						//'timeout' => $this->getTimeout(),
						//'uri' => $this->_uri,
						//'location' => $this->_location,
						'cache_wsdl' => WSDL_CACHE_MEMORY,
						'local_cert' => $this->_getClientCertificate(),
						'stream_context' => $this->_getStreamContext(),
				));			
			}
            $this->__store = Mage::app()->getStore();

			//ePayBL unterstützt nur Soap < 1.2
			$this->_soapClient->setSoapVersion(SOAP_1_1);
			$_classmap = $this->_classmap;
			if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
				$_classmap = array_merge($_classmap, $this->_classmapV3);
			}
			$this->_soapClient->setClassmap($_classmap);
		}
	
		return $this->_soapClient;
	}
	
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		$args = func_get_args();
		if (empty($args[0])) {
			$args[0] = Mage::getStoreConfig('payment_services/paymentbase/service');
		}
		
		if (empty($args[0])) {
			Mage::throwException(Mage::helper('paymentbase')->__('No service location available, please check the configuration.'));
		}
		
		if (count($args) > 1 && empty($args[1])) {
			$args[1] = array();
		} elseif (count($args) < 2) {
			$args[1] = array();
		}
		
		$this->_location = $args[0];
		$this->_uri = self::EPAYMENT_NAMESPACE;
		$this->_options = $args[1];
		
		/*
		 * PHP 5.2.x hat Probleme mit keep-alive siehe #1876
		 * Mit PHP 5.3.x (getestet mit 5.3.3 und 5.3.10) treten diese Probleme nicht auf
		 */
		if (version_compare(phpversion(), '5.3', '<')===true) {
			self::$_alwaysResetSoapClient = true;
		}
	}
	
	/**
     * Set/Get attribute wrapper
     *
     * @param string $method Methodenname
     * @param array $args    Parameter
     * 
     * @return mixed
     */
    public function __call($method, $args) {
    	/*
    	 * PHP 5.2.x hat Probleme mit keep-alive siehe #1876
    	 * Mit PHP 5.3.x (getestet mit 5.3.3 und 5.3.10) treten diese Probleme nicht auf 
    	 */
    	if (self::$_alwaysResetSoapClient || version_compare(phpversion(), '5.3', '<')===true) {
    		$this->_soapClient = false;
    	}

    	//Reset cache result flag
        $this->_isCachedResult = false;

    	if (array_search(sprintf("_%s", $method), $this->_deniedMethods) === false && method_exists($this, sprintf("_%s", $method))) {
    		$paramA = isset($args[0]) && !is_object($args[0]) && !is_array($args[0])? $args[0] : '';
    		$this->_writeLog($method, "Mandant: {$this->getMandantNr()}, Param 0: $paramA");
    		
    		try {
    			$erg = call_user_func_array(array($this, sprintf("_%s", $method)), $args);
    		} catch (SoapFault $sf) {
    			$lastRequest = $this->_getSoapClient()->getLastRequest();
    			//Format XML to save indented tree rather than one line
    			$prettyXml = $lastRequest;
    			if (!empty($lastRequest)) {
				  	$dom = new DOMDocument('1.0');
				  	$dom->preserveWhiteSpace = false;
				  	$dom->formatOutput = true;
				  	$dom->loadXML($lastRequest);
				  	$prettyXml = $dom->saveXML();
    			}
    			
    			Mage::log(
	    			sprintf("Exception::%s\nsoap::RequestHeader:%s\nRequest:\n%s\nResponse:\n%s",
	    				$sf->__toString(),
	    				$this->_getSoapClient()->getLastRequestHeaders(),
	    				$prettyXml,
	    				$this->_getSoapClient()->getLastResponse()
	    			),
    				Zend_Log::ERR,
    				Egovs_Helper::EXCEPTION_LOG_FILE
    			);
    			
    			$erg = $sf;
    		} catch (Exception $e) {
    			$lastRequest = $this->_getSoapClient()->getLastRequest();
    			//Format XML to save indented tree rather than one line
    			$prettyXml = $lastRequest;
    			if (!empty($lastRequest)) {
				  	$dom = new DOMDocument('1.0');
				  	$dom->preserveWhiteSpace = false;
				  	$dom->formatOutput = true;
				  	$dom->loadXML($lastRequest);
				  	$prettyXml = $dom->saveXML();
    			}
    			
    			Mage::log(
    				sprintf("Exception::%s\nsoap::RequestHeader:%s\nRequest:\n%s\nResponse:\n%s",
    					$e->__toString(),
		    			$this->_getSoapClient()->getLastRequestHeaders(),
		    			$prettyXml,
		    			$this->_getSoapClient()->getLastResponse()
		    		),
    				Zend_Log::ERR,
    				Egovs_Helper::EXCEPTION_LOG_FILE
    			);
    			throw $e;
    		}
    		if (Mage::getStoreConfig('dev/log/log_level') == Zend_Log::DEBUG) {
    		    if ($this->_isCachedResult()) {
                    Mage::log(
                        sprintf("Returning cached value! This would only log an already logged result!"),
                        Zend_Log::DEBUG,
                        Egovs_Helper::LOG_FILE
                    );
                } else {
                    $lastRequest = $this->_getSoapClient()->getLastRequest();
                    if (!empty($lastRequest)) {
                        //Format XML to save indented tree rather than one line
                        $dom = new DOMDocument('1.0');
                        $dom->preserveWhiteSpace = false;
                        $dom->formatOutput = true;
                        $dom->loadXML($lastRequest);

                        Mage::log(
                            sprintf("soap::Request:\n%s\nResponse:\n%s",
                                $dom->saveXML(),
                                $this->_getSoapClient()->getLastResponse()
                            ),
                            Zend_Log::DEBUG,
                            Egovs_Helper::LOG_FILE
                        );
                    }
                }
    		}
    		
    		if ($erg instanceof SoapFault) {
    			$this->_writeLog($method, 'SOAP-Error: ' . $erg->getMessage());
    		} else {
    			if (isset($erg) && isset($erg->ergebnis)) {
    				$kassenzeichen = isset($erg->buchungsListe) ? ", Kassenzeichen: {$erg->buchungsListe->kassenzeichen}" : '';
    				$this->_writeLog($method, "istOK: {$erg->ergebnis->istOk}, Code: {$erg->ergebnis->getCode()}, Nachricht: {$erg->ergebnis->getShortText()} $kassenzeichen");
    			} elseif (isset($erg) && $erg->isOk()) {
    				$this->_writeLog($method, "istOK: {$erg->isOk()}, Code: {$erg->getCode()}, Nachricht: {$erg->getShortText()}");
    			} else {
    				$this->_writeLog($method, 'Unkown error');
    			}
    		}
    		
    		return $erg;
    	}
        
        return parent::__call($method, $args);
    }
	
    /**
     * Kann zum Logging verwendet werden
     * 
     * Aktuell wird hier nichts geloggt.
     * 
     * @param string $method  Methode
     * @param string $message Message
     * 
     * @return Egovs_Paymentbase_Model_Webservice_PaymentServices
     */
	protected function _writeLog($method, $message) {
		return $this;
	}
	
	public function getMandantNr() {
		return Mage::helper('paymentbase')->getMandantNr();
	}
	
	public function getBewirtschafterNr() {
		return Mage::helper('paymentbase')->getBewirtschafterNr();
	}
	
	/**
	 * Prüft ob der ePayBL-Server erreichbar ist
	 * 
	 * @param string $mandantNr Mandanten Nummer
	 * 
	 * @return SoapFault|bool
	 */
	protected function _isAlive($mandantNr) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		$erg = $this->_getSoapClient()->isAlive($mandantNr);
			
		return $erg;
	}
	
	/*
	 * Kundenfunktionen
	 * #########################################################################################
	 */
	
	/**
	 * Liefert Kundeninformationen vom ePayBL - Server
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Kunde $kunde Kunde
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis|SoapFault
	 */
	protected function _lesenKunde($kunde) {
		if (!($kunde instanceof Egovs_Paymentbase_Model_Webservice_Types_Kunde)) {
			throw new Zend_Soap_Client_Exception(Mage::helper('paymentbase')->__('The parameter must be type of Egovs_Paymentbase_Model_Webservice_Types_Kunde'));
		}
		if (!empty($this->_eCustomerResult)) {
			if (array_key_exists($kunde->EShopKundenNr, $this->_eCustomerResult)) {
				if ($this->_eCustomerResult[$kunde->EShopKundenNr] instanceof Exception) {
					throw $this->_eCustomerResult[$kunde->EShopKundenNr];
				} elseif ($this->_eCustomerResult[$kunde->EShopKundenNr] instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
					$this->_isCachedResult = true;
				    return $this->_eCustomerResult[$kunde->EShopKundenNr];
				}
				
				unset($this->_eCustomerResult[$kunde->EShopKundenNr]);
			}
		}
		$erg = null;
		try {
			$erg = $this->_getSoapClient()->lesenKunde($this->getMandantNr(), $kunde->toSoap());
		} catch (Exception $e) {
			$this->_eCustomerResult[$kunde->EShopKundenNr] = $e;
			throw $e;
		}
		
		if ($erg instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
			if ($erg->ergebnis->getCodeAsInt() == -199) {
				$erg->kunde = $kunde;
			}
			
			$this->_eCustomerResult[$kunde->EShopKundenNr] = $erg;
		} else {
			unset($this->_eCustomerResult[$kunde->EShopKundenNr]);
		}
		
		return $erg;
	}
	
	protected function _loeschenKunde($eShopKundenNr) {
		$erg = $this->_getSoapClient()->loeschenKunde($this->getMandantNr(), $this->getBewirtschafterNr(), $eShopKundenNr);
		unset($this->_eCustomerResult[$eShopKundenNr]);
		
		return $erg;
	}
	
	protected function _anlegenKunde($kunde) {
		$erg = $this->_getSoapClient()->anlegenKunde($this->getMandantNr(), $this->getBewirtschafterNr(), $kunde->toSoap());
		unset($this->_eCustomerResult[$kunde->EShopKundenNr]);
		return $erg;
	}
	
	protected function _aendernKunde($kunde) {		
		$erg = $this->_getSoapClient()->aendernKunde($this->getMandantNr(), $this->getBewirtschafterNr(), $kunde->toSoap());
			
		return $erg;
	}
	
	/*
	 * Paypage-Funktionen
	 * ##########################################################################################################################
	 */
	
	/**
	 * Anlegen eines Temporären Kassenzeichens
	 *
	 * @param string        $eShopKundenNr    ePayBL Kunden ID
	 * @param object        $objBuchungsListe Buchungsliste
	 * @param string        $lieferAdresse	  Lieferadresse
	 * @param string        $buchungsText     Text für Buchung
	 * @param string|array  $zahlverfahren    Vorgesehenes Zahlverfahren für diese Buchung (Feld kann durch Angabe von null leer gelassen werden). Mögliche Werte sind: 'UEBERWEISUNGVOR', 'UEBERWEISUNGNACH', 'LASTSCHRIFTMIT', 'LASTSCHRIFTOHNE', 'GIROPAY' und 'KREDITKARTE'.
	 *
	 * @return stdClass|SoapFault
	 *
	 * @deprecated Use SOAP_BfF::anlegenKassenzeichenMitZahlverfahrenlisteMitBLP
	 */
	protected function _anlegenKassenzeichen($eShopKundenNr, $objBuchungsListe, $lieferAdresse, $buchungsText, $zahlverfahren) {
		$parameter = array ();
		$parameter['mandantNr'] = $this->getMMandantNr();
		$parameter['eShopKundenNr'] = (string) $eShopKundenNr;
		$parameter['buchungsListe'] = $objBuchungsListe;
	
		if (!is_null($lieferAdresse))
			$parameter['lieferAdresse'] = $lieferAdresse;
		if (!is_null($buchungsText))
			$parameter['buchungsText'] = $buchungsText;
		if (!is_null($zahlverfahren))
			$parameter['zahlverfahren'] = $zahlverfahren;
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $parameter);
	
		return $erg;
	}
	
	/**
	 * Anlegen eines Temporären Kassenzeichens
	 *
	 * @param string                          $eShopKundenNr          ePayBL Kunden ID
	 * @param object                          $objBuchungsListe       Buchungsliste
	 * @param string                          $lieferAdresse		  Lieferadresse
	 * @param string                          $buchungsText           Text für Buchung
	 * @param string|array                    $zahlverfahrenListe     Liste der vorgesehenes Zahlverfahren für diese Buchung (Feld kann durch Angabe von null leer gelassen werden). Mögliche Werte sind: 'UEBERWEISUNGVOR', 'UEBERWEISUNGNACH', 'LASTSCHRIFTMIT', 'LASTSCHRIFTOHNE', 'GIROPAY' und 'KREDITKARTE'.
	 * @param array                           $buchungsListeParameter Zusätzliche Parameter für ePayBL
	 *
	 * @return SoapFault|stdClass
	 */
	protected function _anlegenKassenzeichenMitZahlverfahrenlisteMitBLP($eShopKundenNr, $objBuchungsListe, $lieferAdresse, $buchungsText, $zahlverfahrenListe, $buchungsListeParameter) {
		if (!($buchungsListeParameter instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameter);
		}
	
		$parameter = array ();
		$parameter['mandantNr'] = $this->getMandantNr();
		$parameter['eShopKundenNr'] = (string) $eShopKundenNr;
		$parameter['buchungsListe'] = $objBuchungsListe;
	
		if (!is_null($lieferAdresse)) {
			$parameter['lieferAdresse'] = $lieferAdresse;
		} else {
			$parameter['lieferAdresse'] = null;
		}
		if (!is_null($buchungsText)) {
			$parameter['buchungsText'] = mb_substr($buchungsText, 0, 100, 'UTF-8');
		} else {
			$parameter['buchungsText'] = null;
		}
		if (!is_null($zahlverfahrenListe)) {
			if (is_string($zahlverfahrenListe)) {
				if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
					$zahlverfahrenListe = new Egovs_Paymentbase_Model_Webservice_Types_StringList($zahlverfahrenListe);
				} else {
					//ePayBL 2.x
					$zahlverfahrenListe = array($zahlverfahrenListe);
				}
			}
			$parameter['zahlverfahrenListe'] = empty($zahlverfahrenListe) ? null : $zahlverfahrenListe;
		}
		$parameter['buchungslisteParameterSet'] = $buchungsListeParameter->isEmpty() ? null : $buchungsListeParameter;
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $this->_toSoapParam($parameter));
			
		return $erg;
	}
	/**
	 * 
	 * @param string $wId
	 * @param string $mandantNr
	 * @param string $saferpayReferenzID
	 * @param string $kartenTyp
	 * 
	 * @return mixed
	 * 
	 * @deprecated since ePayBL 3.x
	 */
	protected function _aktiviereTempKreditkartenKassenzeichen($wId, $mandantNr, $saferpayReferenzID, $kartenTyp = null) {
		$parameter = array ();
		$parameter['wId'] = (string) $wId;
		$parameter['mandantNr'] = (string) $this->getMandantNr();		
		$parameter['saferpayReferenzID'] = (string) $saferpayReferenzID;
	
		if (!is_null($kartenTyp))
			$parameter['kartenTyp'] = (string) $kartenTyp;
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $this->_toSoapParam($parameter));
	
		return $erg;
	}
	
	/**
	 * 
	 * @param string $wId
	 * @param string $mandantNr
	 * @param string $saferpayReferenzID
	 * 
	 * @return mixed
	 * 
	 * @deprecated since ePayBL 3.x
	 */
	protected function _aktiviereTempGiropayKassenzeichen($wId, $mandantNr, $saferpayReferenzID) {	
		$parameter = array ();
		$parameter['wId'] = (string) $wId;
		$parameter['mandantNr'] = (string) $this->getMandantNr();
		$parameter['saferpayReferenzID'] = (string) $saferpayReferenzID;
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $this->_toSoapParam($parameter));
	
		return $erg;
	}
	
	protected function _aktiviereTempKassenzeichen($wId, $saferpayReferenzID, $typZahlung) {
		$parameter = array ();
		$parameter['wId'] = (string) $wId;
		$parameter['mandantNr'] = (string) $this->getMandantNr();
		$parameter['saferpayReferenzID'] = (string) $saferpayReferenzID;
		$parameter['typZahlung'] = (string) $typZahlung;
		
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $this->_toSoapParam($parameter));
		
		return $erg;
	}
	
	/*
	 * Vorkasse und Rechnung
	 * ###################################################################################################
	 */
	
	/**
	 * Überweisen nach Lieferung (Rechnung)
	 * 
	 * @param string $CustomerID Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $Buchungsliste Buchungsliste
	 *
	 * @return SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis
	 *
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::_ueberweisenNachLieferungMitBLP}
	 */
	protected function _ueberweisenNachLieferung($CustomerID, $Buchungsliste) {
		$CustomerID = (string) $CustomerID;
	
		$erg = $this->_getSoapClient()->__call(
				$this->_parseCallingMethodName(__METHOD__), 
				$this->_toSoapParam(
						array (
							'mandantNr' => $this->getMandantNr(),
							'eShopKundenNr' => $CustomerID,
							'buchungsListe' => $Buchungsliste
					)
				)
		);
	
		return $erg;
	}
	/**
	 * Überweisen nach Lieferung mit Buchungslistenparameter (BLP)
	 *
	 * @param string                          										   $CustomerID             ePayBL Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe                   $Buchungsliste          Buchungsliste
	 * @param array|Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet $buchungsListeParameter Parameter für Buchungsliste
	 *
	 * @return SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis
	 */
	protected function _ueberweisenNachLieferungMitBLP($CustomerID, $Buchungsliste, $buchungsListeParameter) {
		$CustomerID = (string) $CustomerID;
		
		if (!($buchungsListeParameter instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameter);
		}
	
		if (!$buchungsListeParameter->isEmpty()) {
			$params = array (
					'mandantNr' => $this->getMandantNr(),
					'eShopKundenNr' => $CustomerID,
					'buchungsListe' => $Buchungsliste,
					'lieferAdresse' => null,
					'buchungslisteParameterSet' => $buchungsListeParameter
			);
		} else {
			$params = array (
					'mandantNr' => $this->getMandantNr(),
					'eShopKundenNr' => $CustomerID,
					'buchungsListe' => $Buchungsliste,
					'lieferAdresse' => null,
					'buchungslisteParameterSet' => null,
			);
		}
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $this->_toSoapParam($params));
	
		return $erg;
	}
	
	/**
	 * Überweisen vor Lieferung (Vorkasse)
	 * 
	 * @param string        										 $CustomerID    Kundennummer
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $Buchungsliste Buchungsliste
	 *
	 * @return SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis
	 *
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::_ueberweisenVorLieferungMitBLP}
	 */
	protected function _ueberweisenVorLieferung($CustomerID, $Buchungsliste) {
		$CustomerID = (string) $CustomerID;
	
		$erg = $this->_getSoapClient()->__call(
				$this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
						'mandantNr' => $this->getMandantNr(),
						'eShopKundenNr' => $CustomerID,
						'buchungsListe' => $Buchungsliste
					)
				)
		);
	
		return $erg;
	}
	
	/**
	 * Überweisen vor Lieferung (Vorkasse)
	 * 
	 * @param string                          										   $CustomerID             ePayBL Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe                   $Buchungsliste          Buchungsliste
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet|array $buchungsListeParameter Parameter für Buchungsliste
	 *
	 * @return SoapFault|Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis
	 */
	protected function _ueberweisenVorLieferungMitBLP($CustomerID, $Buchungsliste, $buchungsListeParameter) {
		$CustomerID = (string) $CustomerID;
	
		if (!($buchungsListeParameter instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameter);
		}
	
		if (!$buchungsListeParameter->isEmpty()) {
			$params = array (
					'mandantNr' => $this->getMandantNr(),
					'eShopKundenNr' => $CustomerID,
					'buchungsListe' => $Buchungsliste,
					'buchungslisteParameterSet' => $buchungsListeParameter
			);
		} else {
			$params = array (
					'mandantNr' => $this->getMandantNr(),
					'eShopKundenNr' => $CustomerID,
					'buchungsListe' => $Buchungsliste,
					'buchungslisteParameterSet' => null,
			);
		}
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $this->_toSoapParam($params));
	
		return $erg;
	}
	
	/*
	 * Lastschriftverfahren
	 * ################################################################################################
	 */
	
	/**
	 * Autorisiert die PIN
	 * 
	 * @param string $mandantNr  Mandant
	 * @param string $customerId Kunden ID
	 * @param string $pin        PIN
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_ZahlungsInfo|SoapFault
	 */
	protected function _autorisierePIN($mandantNr, $customerId, $pin) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				array (
					'mandantNr' => $mandantNr,
					'eShopKundenNr' => (string) $customerId,
					'pin' => $pin
				)
		);
	
		return $erg;
	}
	
	/**
	 * Prüft ob die übergebene PIN noch die initale PIN ist
	 * 
	 * @param string $mandantNr  Mandant
	 * @param string $customerId Kunden ID
	 * @param string $pin        PIN
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis|SoapFault
	 */
	protected function _pruefenPinObInitial($mandantNr, $customerId, $pin) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				array (
					'mandantNr' => $mandantNr,
					'eShopKundenNr' => (string) $customerId,
					'pin' => $pin
				)
		);
	
		return $erg;
	}
	
	/**
	 * Ändert die PIN für die Bankverbindung des Kunden
	 *
	 * @param string 												  $mandantNr  	  Mandant
	 * @param string 												  $customerId 	  Kunden ID
	 * @param string 												  $neuePIN     	  Neue PIN
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung Bankverbindung des Kunden
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis|SoapFault
	 */
	protected function _aendernPIN($mandantNr, $customerId, $neuePIN, $bankverbindung) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
							'mandantNr' => (string) $mandantNr,
							'eShopKundenNr' => (string) $customerId,
							'pin' => (string) $neuePIN,
							'bankverbindung' => $bankverbindung
						)
				)
		);
	
		return $erg;
	}
	
	/**
	 * Prüft die Bankverbindung auf Gültigkeit
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung Bankverbindung
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis|SoapFault
	 *
	 */
	protected function _pruefenKontonummer($bankverbindung) {
		$mandantNr = $this->getMandantNr();
		$bewirtschafterNr = $this->getBewirtschafterNr();
		
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
								'mandantNr' => (string) $mandantNr,
								'bewirtschafterNr' => (string) $bewirtschafterNr,
								'bankverbindung' => $bankverbindung
						)
				)
		);
		
		return $erg;
	}
	
	/**
	 * Prüft ob Laschrift ohne Einzugsermächtigung möglich ist
	 * 
	 * @param string 												  $mandantNr  	    Mandant
	 * @param string 												  $bewirtschafterNr Bewirtschafter
	 * @param string 												  $sEKundenNr 	    Kunden ID
	 * @param float 												  $amount        	Betrag
	 * @param string 												  $waehrungskennz 	Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung   Bankverbindung des Kunden
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_ReservierungsErgebnis|SoapFault
	 */
	protected function _pruefenLastschriftOhneEinzugsermaechtigung($mandantNr, $bewirtschafterNr, $sEKundenNr, $amount, $waehrungskennz, $bankverbindung) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		if (!$bewirtschafterNr) {
			$bewirtschafterNr = $this->getBewirtschafterNr();
		}
		
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
							'mandantNr' => (string) $mandantNr,
							'bewirtschafterNr' => (string) $bewirtschafterNr,
							'eShopKundenNr' => (string) $sEKundenNr,
							'betrag' => $amount,
							'waehrungskennzeichen' => (string) $waehrungskennz,
							'lieferAdresse' => null,
							'bankverbindung' => $bankverbindung
						)
				)
		);
	
		return $erg;
	}
	
	/**
	 * Abbuchen mit schriftlicher Einzugsermächtigung
	 *
	 * @param string 												 $mandantNr        Mandantennummer
	 * @param string 												 $customerId       ePayBL Kunden ID
	 * @param string 												 $pin              PIN
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $objBuchungsliste Buchungsliste
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 *
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::abbuchenMitEinzugsermaechtigungMitBLP}
	 */
	protected function _abbuchenMitEinzugsermaechtigung($mandantNr, $customerId, $pin, $objBuchungsliste) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
							'mandantNr' => $mandantNr,
							'eShopKundenNr' => $customerId,
							'pin' => (string)$pin,
							'buchungsListe' => $objBuchungsliste
						)
				)
		);
	
		return $erg;
	}
	
	/**
	 * Abbuchen mit schriftlicher Einzugsermächtigung
	 *
	 * @param string                          										   $customerId             ePayBL Kunden ID
	 * @param string                          										   $pin                    PIN
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe                   $objBuchungsliste       Buchungsliste
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungslisteParameterSet|array $buchungsListeParameter Zusätzliche Parameter für Buchungsliste
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 */
	protected function _abbuchenMitEinzugsermaechtigungMitBLP($customerId, $pin, $objBuchungsliste, $buchungsListeParameter) {
		if (!($buchungsListeParameter instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameter);
		}
			
		$erg = $this->_getSoapClient()->__call(
				$this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
								'mandantNr' => $this->getMandantNr(),
								'eShopKundenNr' => $customerId,
								'pin' => (string)$pin,
								'buchungsListe' => $objBuchungsliste,
								'buchungslisteParameterSet' => $buchungsListeParameter->isEmpty() ? null : $buchungsListeParameter
						)
				)
		);
	
		return $erg;
	}
	
	/**
	 * SEPA Direct Debit - Abbuchen mit SEPA Mandat
	 *
	 * Darf nur mit <strong>externer</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param string 												 $customerId       ePayBL Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_SepaMandat	 $mandat           SEPA Mandat
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $objBuchungsliste Buchungsliste
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_PaymentServices::_abbuchenMitSEPAMandatreferenzMitBLP
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::_abbuchenMitSEPAMandatMitBLP}
	 */
	protected function _abbuchenMitSEPAMandat($customerId, $mandat, $objBuchungsliste) {
		$mandantNr = $this->getMandantNr();
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
								'mandantNr' => $mandantNr,
								'eShopKundenNr' => $customerId,
								'mandat' => $mandat,
								'buchungsListe' => $objBuchungsliste
						)
				)
		);
	
		return $erg;
	}
	
	/**
	 * SEPA Direct Debit - Abbuchen mit SEPA Mandat und Buchungslistenparametern
	 * 
	 * Darf nur mit <strong>externer</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param string 																   $customerId       	      ePayBL Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_SepaMandat					   $mandat           	      SEPA Mandat
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe				   $objBuchungsliste	      Buchungsliste
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungslisteParameterSet|array $buchungsListeParameterSet Zusätzliche Parameter für Buchungsliste
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_PaymentServices::_abbuchenMitSEPAMandatreferenzMitBLP
	 */
	protected function _abbuchenMitSEPAMandatMitBLP($customerId, $mandat, $objBuchungsliste, $buchungsListeParameterSet) {
		if (!($buchungsListeParameterSet instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameterSet = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameterSet);
		}
		
		$mandantNr = $this->getMandantNr();
		
		$mandat->eShopKundenNr = $customerId;
		
		$parms = $this->_toSoapParam(
				array (
						'mandantNr' => $mandantNr,
						'eShopKundenNr' => $customerId,
						'mandat' => $mandat,
						'buchungsListe' => $objBuchungsliste,
						'buchungslisteParameterSet' => $buchungsListeParameterSet->isEmpty() ? null : $buchungsListeParameterSet
				)
		);
		
		
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),$parms);
		
	
		return $erg;
	}
	
	/**
	 * SEPA Direct Debit - Abbuchen mit SEPA Mandatreferenz
	 *
	 * Darf nur mit <strong>interner</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param string 												 $customerId       ePayBL Kunden ID
	 * @param string												 $mandatReferenz   SEPA Mandatreferenz
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe $objBuchungsliste Buchungsliste
	 * @param string												 $pin              PIN für Autorisierung (Optional)
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_PaymentServices::_abbuchenMitSEPAMandatMitBLP
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::_abbuchenMitSEPAMandatreferenzMitBLP}
	 */
	protected function _abbuchenMitSEPAMandatreferenz($customerId, $mandatReferenz, $objBuchungsliste, $pin) {
		$mandantNr = $this->getMandantNr();
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
								'mandantNr' => $mandantNr,
								'eShopKundenNr' => $customerId,
								'mandatReferenz' => $mandatReferenz,
								'buchungsListe' => $objBuchungsliste,
								'pin'	=> (string)$pin
						)
				)
		);
	
		return $erg;
	}
	
	/**
	 * SEPA Direct Debit - Abbuchen mit SEPA Mandatreferenz mit Buchungslisten Parametern
	 *
	 * Darf nur mit <strong>interner</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param string 																   $customerId                ePayBL Kunden ID
	 * @param string																   $mandatReferenz            SEPA Mandatreferenz
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe				   $objBuchungsliste          Buchungsliste
	 * @param string																   $pin                       PIN für Autorisierung (Optional)
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungslisteParameterSet|array $buchungsListeParameterSet Zusätzliche Parameter für Buchungsliste
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_PaymentServices::_abbuchenMitSEPAMandatMitBLP
	 */
	protected function _abbuchenMitSEPAMandatreferenzMitBLP($customerId, $mandatReferenz, $objBuchungsliste, $pin, $buchungsListeParameterSet) {
		if (!($buchungsListeParameterSet instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameterSet = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameterSet);
		}
		$mandantNr = $this->getMandantNr();
	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
								'mandantNr' => $mandantNr,
								'eShopKundenNr' => $customerId,
								'mandatReferenz' => $mandatReferenz,
								'buchungsListe' => $objBuchungsliste,
								'pin'	=> (string)$pin,
								'buchungslisteParameterSet' => $buchungsListeParameterSet->isEmpty() ? null : $buchungsListeParameterSet
						)
				)
		);
	
		return $erg;
	}
	
	
	protected function _anlegenKassenzeichenMitSEPAMandatMitBLP($customerId, $mandat, $lieferadresse, $objBuchungsliste, $buchungsListeParameterSet) {
		if (!($buchungsListeParameterSet instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameterSet = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameterSet);
		}
		$mandantNr = $this->getMandantNr();
	
		$mandat->eShopKundenNr = $customerId;
		
		$parms = $this->_toSoapParam(
						array (
								'mandantNr' => $mandantNr,
								'eShopKundenNr' => $customerId,
								'mandat' => $mandat,
								'buchungsListe' => $objBuchungsliste,
								'lieferAdresse' => $lieferadresse,
								'buchungstext' => null,
								'buchungslisteParameterSet' => $buchungsListeParameterSet->isEmpty() ? null : $buchungsListeParameterSet
						)
				);
		
		
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), $parms);
	
		return $erg;
	}
	
	
	
	/**
	 * Anlegen SEPA Mandat
	 * 
	 * Darf nur mit <strong>interner</strong> Mandatsverwaltung genutzt werden!
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_SepaMandat $mandat SEPA Mandat
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis|SoapFault
	 */
	protected function _anlegenSEPAMandat($mandat) {
		$erg = $this->_getSoapClient()->anlegenSEPAMandat($this->getMandantNr(), $this->getBewirtschafterNr(), $mandat->toSoap());
			
		return $erg;
	}
	
	/**
	 * Lesen eines SEPA Mandats
	 *
	 * Darf nur mit <strong>interner</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param string $mandatReferenz SEPA Mandatreferenz
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis|SoapFault
	 */
	protected function _leseSEPAMandat($mandatReferenz) {
		$erg = $this->_getSoapClient()->leseSEPAMandat($this->getMandantNr(), $mandatReferenz);
			
		return $erg;
	}
	
	/**
	 * Vervollständigen eines SEPA Mandats
	 *
	 * Darf nur mit <strong>interner</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param string $mandatReferenz    SEPA Mandatreferenz
	 * @param string $datumUnterschrift Datum der Unterschrift
	 * @param string $ortUnterschrift   Ort der Unterschrift
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_EinzugsermaechtigungErgebnis|SoapFault
	 */
	protected function _vervollstaendigenSEPAMandat($mandatReferenz, $datumUnterschrift, $ortUnterschrift) {
		$erg = $this->_getSoapClient()->vervollstaendigenSEPAMandat($this->getMandantNr(), $mandatReferenz, $datumUnterschrift, $ortUnterschrift);
			
		return $erg;
	}
	
	/**
	 * Deaktivieren eines SEPA Mandats
	 *
	 * Darf nur mit <strong>interner</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param string $customerId     eShopKundennummer an ePayBL
	 * @param string $mandatReferenz SEPA Mandatreferenz
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis|SoapFault
	 */
	protected function _deaktiviernSEPAMandat($customerId, $mandatReferenz) {
		$erg = $this->_getSoapClient()->deaktiviernSEPAMandat($this->getMandantNr(), $customerId, $mandatReferenz);
			
		return $erg;
	}
	
	/**
	 * Abbuchen ohne schriftlicher Einzugsermächtigung
	 *
	 * @param string 												  $mandantNr        Mandantennummer
	 * @param string 												  $sEKundenNr       ePayBL Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung   Bankverbindung
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe  $objBuchungsliste Buchungsliste
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 *
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::abbuchenOhneEinzugsermaechtigungMitBLP}
	 */
	protected function _abbuchenOhneEinzugsermaechtigung($mandantNr, $sEKundenNr, $bankverbindung, $objBuchungsliste) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		
		$erg = $this->_getSoapClient()->__call(
				$this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
							'mandantNr' => (string)$mandantNr,
							'eShopKundenNr' => (string)$sEKundenNr,
							'lieferAdresse' => null,
							'bankverbindung' => $bankverbindung,
							'buchungsListe' => $objBuchungsliste
						)
				)
		);
			
		return $erg;
	}
	
	/**
	 * Abbuchen ohne schriftlicher Einzugsermächtigung
	 *
	 * @param string 												  				   $sEKundenNr             ePayBL Kunden ID
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung 				   $bankverbindung         Bankverbindung
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe  				   $objBuchungsliste       Buchungsliste
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungslisteParameterSet|array $buchungsListeParameter Zusätzliche Parameter für Buchungsliste
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis|SoapFault
	 */
	protected function _abbuchenOhneEinzugsermaechtigungMitBLP($sEKundenNr, $bankverbindung, $objBuchungsliste, $buchungsListeParameter) {
		if (!($buchungsListeParameter instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet)) {
			$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet($buchungsListeParameter);
		}
	
		$erg = $this->_getSoapClient()->__call(
				$this->_parseCallingMethodName(__METHOD__),
				$this->_toSoapParam(
						array (
							'mandantNr' => $this->getMandantNr(),
							'eShopKundenNr' => (string)$sEKundenNr,
							'lieferAdresse' => null,
							'bankverbindung' => $bankverbindung,
							'buchungsListe' => $objBuchungsliste,
							'buchungslisteParameterSet' => $buchungsListeParameter->isEmpty() ? null : $buchungsListeParameter
						)
				)
		);
	
		return $erg;
	}
	
	/*
	 * Allgemeines
	 * #################################################################################################
	 */
	/**
	 * Liefert die Bankverbidnung des Bewirtschafters zurück.
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis|SoapFault
	 */
	protected function _leseBankverbindungBewirtschafter() {
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				array (
						'mandantNr' => $this->getMandantNr(),
						'bewirtschafterNr' => $this->getBewirtschafterNr()
				)
		);
	
		return $erg;
	}
	
	/**
	 * Liefert Informationen zu einem Kassenzeichen
	 * 
	 * @param string $kzeichen Kassenzeichen
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis|SoapFault
	 */
	protected function _lesenKassenzeichenInfo($kzeichen) {	
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				array (
					'mandantNr' => $this->getMandantNr(),
					'Kassenzeichen' => $kzeichen
				)
		);
	
		return $erg;
	}
	
	protected function _lesenTransaktion($eShopTransaktionsNr) {
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__),
				array (
						'mandantNr' => $this->getMandantNr(),
						'eShopTransaktionsNr' => $eShopTransaktionsNr
				)
		);
	
		return $erg;
	}
	
	/**
	 * Listet alle ungelesenen Kassenzeichen
	 * 
	 * @param string $mandantNr Mandant
	 * 
	 * @return mixed
	 * 
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::_lesenKassenzeichenInfo}
	 */
	protected function _listeUngeleseneZahlungseingaenge($mandantNr) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		
		$erg = $this->_getSoapClient()->__call(
				$this->_parseCallingMethodName(__METHOD__),
				array (
					'mandantNr' => $mandantNr
				)
		);
	
		return $erg;
	}
	
	/**
	 * Bestätigt gelesene Kassenzeichen
	 *
	 * @param string $mandantNr Mandant
	 * @param string $ePaymentID Transaktions-ID
	 *
	 * @return mixed
	 *
	 * @deprecated Use {@link Egovs_Paymentbase_Model_Webservice_PaymentServices::_lesenKassenzeichenInfo}
	 */
	protected function _bestaetigenGeleseneZahlungseingaenge($mandantNr, $ePaymentID) {
		if (!$mandantNr) {
			$mandantNr = $this->getMandantNr();
		}
		
		$erg = $this->_getSoapClient()->__call(
				$this->_parseCallingMethodName(__METHOD__),
				array (
					'mandantNr' => $mandantNr,
					'ePaymentId' => $ePaymentID
				)
		);
	
		return $erg;
	}

	protected function _isCachedResult() {
	    return $this->_isCachedResult;
    }
}