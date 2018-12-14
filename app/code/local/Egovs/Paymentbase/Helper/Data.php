<?php
/**
 * Basishelperklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * Hier finden unter anderem die WebService-Aufrufe statt.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011-2016 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Helper_Data extends Mage_Payment_Helper_Data
{
	/**
	 * ePayBL Kundennummer
	 *
	 * @var string
	 */
	const ATTRIBUTE_EPAYBL_CUSTOMER_ID = 'epaybl_customer_id';
	/**
	 * Mandatsreferenz für SEPA Mandate
	 * 
	 * @var string
	 */
	const ATTRIBUTE_SEPA_MANDATE_ID = 'sepa_mandate_id';

    /**
     * Datum des Abrufs des Zahlungseingangs von der ePayBL
     */
    const ATTRIBUTE_EPAYBL_CAPTURE_DATE = 'epaybl_capture_date';

    /**
     * Status für den automatischen Zahlungsabruf
     */
    const ATTRIBUTE_EPAYBL_APR_STATUS = 'epaybl_apr_status';

    /**
     * Anzahl Fehler seit letztem erfolgreichem Abruf
     */
    const ATTRIBUTE_EPAYBL_APR_ERROR_COUNT = 'epaybl_apr_error_count';
	
	const ATTRIBUTE_SEPA_ADDITIONAL = 'sepa_additional_data';
	
	const EPAYBL_3_X_VERSION = 3;
	
	const EPAYBL_2_X_VERSION = 2;

    /**
	 * Client zur Soap - Kommunikation
	 *
	 * @var SOAP_Client
	 */
	private $__objSOAPClientBfF = null;

	/**
	 * Kunde aus ePayBL
	 * 
	 * @var Egovs_Paymentbase_Model_Webservice_Types_Kunde
	 */
	protected $_eCustomerObject = null;
	
	/**
	 * Flag um doppeltes Hinzufügen des Header zu vermeiden
	 *
	 * Die Helper-Klasse wird immer als Singleton geladen
	 *
	 * @var bool
	 */
	protected $_headerAdded = false;

	/**
	 * Gibt an ob der Kunde nach jeder Transaktion gelöscht werden soll
	 *
	 * @var bool
	 */
	protected $_nonVolatile = false;

	/**
	 * Assoziatives Array für bereits gelöschte Kunden IDs
	 *
	 * Format
	 * <p>
	 * ID => Result
	 * </p>
	 *
	 * @var array
	 */
	protected $_lastDeletedECustomerIds = array();

	/**
	 * Optionaler Adapter für spezifische Funktionen/Bedingungen eines Kassensystem
	 *
	 * @var Egovs_Paymentbase_Model_Adapter_Abstract
	 */
	protected $_adapter = null;
	
	/**
	 * Liste von ePayBL Error-Codes bei denen keine Mail an den Admin gesendet werden soll.
	 * 
	 * @var array
	 */
	protected $_omitMailToAdmin = array();
	

	/**
	 * Bezeichnung für Zahlmodul
	 *
	 * @var string
	 */
	protected $_code = 'paymentbase';

	/**
	 * Gibt den Pfad zum etc-Verzeichnis zurück
	 *
	 * @return string
	 */
	protected static function _getEtcPath() {
		$f = dirname(__FILE__);			// Get the path of this file
		$f = substr($f, 0, -6);			// Remove the "Helper" dir
		$f = $f.'etc/';					// Add the "etc" dir
		$f = str_replace("\\", "/", $f);	// change slashes
	
		//echo $f; exit;
	
		return $f;
	}
	
	/**
	 * Ermittelt den Banknamen über die BIC
	 *
	 * Die Dateien können von folgenden Quellen aktualisiert werden:<br/>
	 * BLZ: http://www.bundesbank.de/Redaktion/DE/Standardartikel/Aufgaben/Unbarer_Zahlungsverkehr/bankleitzahlen_download.html
	 * BIC: Wurden bisher immer von Herrn Flügge (KKR) geliefert
	 *
	 * fgetcsv nutzt die lokalen Systemeinstellungen für das Charakter-Encoding!
	 *
	 * @param string  $bic BIC
	 * @param boolean $bicIsBlz True falls BIC eine BLZ ist.
	 *
	 * @return string
	 */
	public static function getBankname($bic, $bicIsBlz = false) {
		$name = '';
		if (strlen(trim($bic)) > 0) {
			$path = self::_getEtcPath();
				
			if ($bicIsBlz) {
				$files = array(
						'blz.csv' => array(
								'bic' => 0,
								'name' => 2
						),
				);
			} else {
				$files = array(
						'blz.csv' => array(
								'bic' => 7,
								'name' => 2
						),
						'bics.csv' => array(
								'bic' => 0,
								'name' => 1
						)
				);
			}
			$bicsToCheck = array($bic);
			if (strtoupper(substr($bic, -3, 3)) == 'XXX') {
				$bicsToCheck[] = substr($bic, -4);
			}
			foreach ($files as $file => $ref) {
				$file = $path.$file;
                /** @noinspection SuspiciousLoopInspection */
                foreach ($bicsToCheck as $bic) {
					// Open file
					$fp = fopen($file, 'rb');
	
					while ($data = fgetcsv($fp, 1024, ";")) {
						if (trim($data[$ref['bic']]) == $bic) {
							$name = trim($data[$ref['name']]);
							break;
						}
					}
					fclose($fp);
						
					if (!empty($name)) {
						break 2;
					}
				}
			}
		}
		if (empty($name)) {
			return Mage::helper('paymentbase')->__('Not found');
		}
	
		return $name;
	}
	
	/**
	 * Liefert die BLZ einer DE IBAN
	 * 
	 * @param string $iban
	 * 
	 * @return string|false
	 */
	public static function getBlzFromIban($iban = false) {
		if (!$iban) {
			return false;
		}
		/*
		 * Die IBAN beginnt immer mit dem Länderkennzeichen (z.B. DE für Deutschland) und der zweistelligen Prüfsumme für die gesamte IBAN,
		 * die aufgrund einer genau festgelegten Formel berechnet werden kann.
		 * Es folgen die 8 Stellen lange Bankleitzahl und die max. 10-stellige Kontonummer (hat die Kontonummer keine 10 Stellen,
		 * werden die fehlenden Stellen von vorn mit Nullen aufgefüllt).
		 */
		return substr($iban, 4, 8);
	}

	/**
	 * Prüft ob $result in der Ausnahmeliste zum Senden von Admin-Mails enthalten ist
	 * 
	 * @param mixed $result Int, String oder ePayBL-Objekt
	 * @return boolean
	 */
	public function omitMailToAdmin($result) {
		$code = null;
		
		if (!$result) {
			return false;
		}
		
		if (isset($result->ergebnis) && isset($result->ergebnis->code)) {
			$result = $result->ergebnis->code;
		}
		if (isset($result->ergebnis) && isset($result->ergebnis->text)) {
			$result = $result->ergebnis->text;
		}
		if (isset($result->text)) {
			$result = $result->text;
		}
		if (isset($result->code)) {
			$result = $result->code;
		}
		if (is_string($result)) {
			$result = intval($result);
		}
		if (is_numeric($result)) {
			$code = $result;
		}
		
		if (!is_null($code) && isset($this->_omitMailToAdmin[$code])) {
			return true;
		}
		
		return false;
	}
	
   /**
    *  Liefert die Saferpay Service URL
	*
	* @return string | https://www.saferpay.com/hosting/
	*/
	public function getSaferpayServiceUrl() {
		$_url = Mage::getStoreConfig("payment_services/saferpay/service_url");
		$_urlParts = parse_url($_url);
	
		if ($_urlParts === false || empty($_url)) {
			return "https://www.saferpay.com/hosting/";
		}
		if (isset($_urlParts['port'])) {
			$_url = sprintf("%s://%s:%s/%s", $_urlParts['scheme'], $_urlParts['host'], $_urlParts['port'], $_urlParts['path']);
		} else {
			$_url = sprintf("%s://%s/%s", $_urlParts['scheme'], $_urlParts['host'], $_urlParts['path']);
		}
	
		if (strripos($_url, '/') != strlen($_url) - 1) {
			$_url += '/';
		}
	
		return $_url;
	}
	
	
	/**
	 * Gibt die Ausnahmeliste zum Senden von Admin-Mails zurück
	 * 
	 * @return array
	 */
	public function getOmitMailToAdminList() {
		return $this->_omitMailToAdmin;
	}
	
	/**
	 * Fügt die Elmente in $list zur Ausnahmeliste hinzu
	 * 
	 * Vorhandene Einträge werden überschrieben.
	 * 
	 * @param array $list Ausnahmeliste
	 * 
	 * @return Egovs_Paymentbase_Helper_Data
	 */
	public function addOmitMailToAdminList($list) {
		if (!is_array($list)) {
			return $this;
		}
		foreach ($list as $k => $v) {
			$this->_omitMailToAdmin[$k] = $v;
		}
		
		return $this;
	}
	
	/**
	 * Ersetzt die vorhandene Ausnahmeliste durch $list
	 * 
	 * @param array $list Neue Ausnahmeliste
	 * 
	 * @return Egovs_Paymentbase_Helper_Data
	 */
	public function setOmitMailToAdminList($list) {
		if (!is_array($list)) {
			return $this;
		}
		
		$this->_omitMailToAdmin = $list;
		
		return $this;
	}
	
	/**
	 * Gibt den existierenten SOAP-Client zurück oder erstellt ihn neu.
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_PaymentServices Soap client
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_PaymentServices
	 */
	public function getSoapClient() {
		if (!$this->__objSOAPClientBfF) {
			//Damit PaymentService überladbar wird
			$this->__objSOAPClientBfF = Mage::getSingleton('paymentbase/webservice_paymentServices'); //new Egovs_Paymentbase_Model_Webservice_PaymentServices();
		}

		return $this->__objSOAPClientBfF;
	}

	/**
	 * Gibt den Adapter für eine spezifische Anbindung eines Kassensystems zurück
	 *
	 * @return Egovs_Paymentbase_Model_Adapter_Abstract
	 */
	public function getAdapter() {
		if (is_null($this->_adapter)) {
			$adapters = $this->getAvailableAdapters();

			$adapterCode = Mage::getStoreConfig('payment_services/paymentbase/adapter');

			if (empty($adapterCode)) {
				$adapterCode = 'default';
			}

			foreach ($adapters as $adapter) {
				if ($adapter->getCode() == $adapterCode) {
					$this->_adapter = $adapter;
					break;
				}
			}
		}

		return $this->_adapter;
	}
	/**
	 * Salt für Encryption
	 *
	 * @var string
	 */
	private $__salt = null;
	/**
	 * Gibt den Salt zurück
	 *
	 * MD5 magento crypt key.
	 *
	 * @param String $key Key
	 *
	 * @return string
	 */
	public function getSalt($key = null) {
		if (!$this->__salt) {
			if (null === $key) {
				$key = (string)Mage::getConfig()->getNode('global/crypt/key');
			}
			$this->__salt = md5($key);
		}
		return $this->__salt;
	}

	/**
	 * Gibt an ob der Kunde nach jeder Transaktion gelöscht werden soll
	 *
	 * @return boolean
	 */
	public function isNonVolatile() {
		return $this->_nonVolatile;
	}
	
	/**
	 * Gibt an ob der Nachname bei Firmenaccounts Pflicht ist.
	 * 
	 * @return boolean
	 */
	public function isCompanyLastNameRequired() {
		return Mage::getStoreConfigFlag('payment_services/paymentbase/company_lastname');
	}

	/**
	 * Liefert die Kundeninformationen vom ePayBL Server
	 *
	 * @param string|Egovs_Paymentbase_Model_Webservice_Types_Kunde $customer ePayBL   Kunden ID oder Kundenobjekt
	 * @param bool													$ignoreIfNotExists Keinen Fehler ausgeben, falls Kunde nicht existiert
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis|NULL
	 */
	public function getCustomerFromEPayment($customer, $ignoreIfNotExists = false) {
		// prüfen, ob Kunde mit seiner Kundennummer schon im ePayment existiert
		if (is_string($customer)) {
			$customer = new Egovs_Paymentbase_Model_Webservice_Types_Kunde($customer);
		} elseif (!($customer instanceof Egovs_Paymentbase_Model_Webservice_Types_Kunde)) {
			$customer = new Egovs_Paymentbase_Model_Webservice_Types_Kunde($this->getECustomerId());
		}

		$this->_eCustomerObject = null;
		$objResult = null;
		try {
			$objResult = $this->getSoapClient()->lesenKunde($customer);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
			$objResult = $e;
		}

		if (!is_null($objResult)
			&& $objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis
			&& $objResult->kunde instanceof Egovs_Paymentbase_Model_Webservice_Types_Kunde
			&& $objResult->ergebnis->istOk
		) {
			$customer = $objResult->kunde;
			$this->_eCustomerObject = $customer;
			Mage::log("paymentbase::Got customer information from customer (ID: {$customer->EShopKundenNr})", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

			return $objResult;
		}

		if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis
			&& $objResult->ergebnis->getCodeAsInt() == -199
			&& $ignoreIfNotExists
		) {
			return $objResult;
		}

		// Mail an Webmaster senden
		$sMailText = "Während der Kommunikation mit dem ePayment-Server bzgl. der Daten eines Kunden trat folgender Fehler auf:\n\n";
		if ($objResult instanceof SoapFault || $objResult instanceof Exception) {
			$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
		} elseif ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
			$sMailText .= $this->getErrorStringFromObjResult($objResult->ergebnis);
		}
		//Kundennummer
		if ($customer instanceof Egovs_Paymentbase_Model_Webservice_Types_Kunde) {
			$sMailText .= "Kundennummer: {$customer->EShopKundenNr}\n";
		} else {
			$sMailText .= "Kundennummer: {$this->__('Not available')}\n";
		}
		$backtrace = $this->_getBacktrace();
		Mage::log("paymentbase::$sMailText\r\n$backtrace", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		
		if (!$this->omitMailToAdmin($objResult)) {
			$this->sendMailToAdmin("Fehler in WebService-Funktion: lesenKunde:\n".$sMailText);
		}

		return null;
	}
	
	/**
	 * Getting backtrace
	 *
	 * @param int $ignore ignore calls
	 *
	 * @return string
	 */
	protected function _getBacktrace($ignore = 0) {
		$trace = '';
		foreach (debug_backtrace() as $k => $v) {
			if ($k < $ignore) {
				continue;
			}
	
			//$trace .= '#' . ($k - $ignore) . ' ' . $v['file'] . '(' . $v['line'] . '): ' . (isset($v['class']) ? $v['class'] . '->' : '') . $v['function'] . '(' . implode(', ', $v['args']) . ')' . "\n";
			$trace .= '#' . ($k - $ignore) . ' ' . $v['file'] . '(' . $v['line'] . '): ' . (isset($v['class']) ? $v['class'] . '->' : '') . $v['function'] . "\n";
		}
	
		return $trace;
	}

	/**
	 * Kundennummer im WebShop
	 *
	 * @var int
	 */
	private $__customerId = null;
	/**
	 * Liefert die Kundennummer aus Magento
	 *
	 * @param int|Mage_Customer_Model_Customer $customer Customer, customer id or null
	 *
	 * @return int Magento Kundennummer
	 */
	public function getCustomerId($customer = null) {
		if ($customer instanceof Mage_Customer_Model_Customer) {
			$customer = $customer->getId();
		} elseif (!is_numeric($customer)) {
			$quote = Mage::getSingleton('checkout/session')->getQuote();
			if (!$quote) {
				$customer = Mage::getSingleton('customer/session');
			} else {
				$customer = $quote->getCustomer();
			}

			if (!$customer || !$customer->getId()) {
				$customer = 0;
			} else {
				$customer = $customer->getId();
			}
		}

		if (!$this->__customerId) {
			$this->__customerId = $customer;
		}

		return $this->__customerId;
	}
	/**
	 * Kundenummer an der ePayment Plattform
	 *
	 * @var string
	 */
	private $__eCustomerId = null;

	/**
	 * Liefert die flüchtige Kundennummer für die ePayment Plattform
	 *
	 * Die Kundennummer kann maximal 100 Zeichen lang sein.
	 *
	 * @param int|Mage_Customer_Model_Customer $customer         Customer, customer id or null
	 * @param bool                             $throwIfNotExists Soll eine Exception erzeugt werden falls die Kundennummer nicht existiert. (default = false)
	 *
	 * @return String ePayment Kundennummer
	 *
	 * @see Egovs_Paymentbase_Helper_Data::getECustomerIdRandom
	 * @see Egovs_Paymentbase_Helper_Data::getECustomerIdNonVolatile
	 * @see Egovs_Paymentbase_Helper_Data::getCustomerId
	 * @see Egovs_Paymentbase_Model_Abstract::_getECustomerId
	 * @see Egovs_PayplacePaypage_Model_Paypage::_anlegenKassenzeichenPaypage
	 * @see Egovs_PayplacePaypage_Model_Paypage::getPaypageUrl
	 *
	 * @deprecated Egovs_Paymentbase_Helper_Data::getECustomerIdRandom
	 */
	public function getECustomerId($customer = null, $throwIfNotExists = false) {
		if ($this->__eCustomerId) {
			return $this->__eCustomerId;
		}
		if (is_numeric($customer)) {
			$customer = Mage::getModel('customer/customer')->load($customer, array(self::ATTRIBUTE_EPAYBL_CUSTOMER_ID));
		}
		if ($customer instanceof Mage_Customer_Model_Customer) {
			if ($customer->hasData(self::ATTRIBUTE_EPAYBL_CUSTOMER_ID)) {
				return $this->getECustomerIdNonVolatile($customer, $throwIfNotExists);
			}
		} elseif ($customer instanceof Egovs_Paymentbase_Model_Webservice_Types_Kunde && isset($customer->EShopKundenNr)) {
			return $customer->EShopKundenNr;
		}
		return $this->getECustomerIdRandom($customer, $throwIfNotExists);
	}
	
	/**
	 * Liefert ein eCustomer Objekt falls vorhanden.
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Kunde|null
	 * 
	 * @see Egovs_Paymentbase_Helper_Data::createCustomerForPayment
	 * @see Egovs_Paymentbase_Helper_Data::getCustomerFromEPayment
	 */
	public function getECustomer() {
		return $this->_eCustomerObject;
	}
	/**
	 * Liefert die flüchtige Kundennummer für die ePayment Plattform
	 *
	 * Die Kundennummer kann maximal 100 Zeichen lang sein.
	 * Hier ist sie 32 Zeichen lang und wird wie folgt erzeugt:
	 * <p>
	 * adapter->hash(BewirtschafterNr+WebShopDesMandanten+CustomerId+Zufallszahl+Zufallszahl+Zeit+SALT)
	 * md5(BewirtschafterNr+WebShopDesMandanten+CustomerId+Zufallszahl+Zufallszahl+Zeit+SALT)
	 * </p>
	 *
	 * @param int|Mage_Customer_Model_Customer $customer         Customer, customer id or null
	 * @param bool                             $throwIfNotExists Soll eine Exception erzeugt werden falls die Kundennummer nicht existiert. (default = false)
	 *
	 * @return String ePayment Kundennummer
	 *
	 * @see Egovs_Paymentbase_Helper_Data::getCustomerId
	 * @see Egovs_PayplacePaypage_Model_Paypage::_anlegenKassenzeichenPaypage
	 * @see Egovs_PayplacePaypage_Model_Paypage::getPaypageUrl
	 * @see Egovs_Paymentbase_Model_Adapter_Abstract::hash
	 */
	public function getECustomerIdRandom($customer = null, $throwIfNotExists = false) {
		$customer = $this->getCustomerId($customer);

		if (!$this->__eCustomerId && !$throwIfNotExists) {
			if ($this->getAdapter()) {
				$this->__eCustomerId = $this->getAdapter()->hash($this->getBewirtschafterNr() . $this->getWebShopDesMandanten() . $this->getCustomerId() . mt_rand() . mt_rand() . time() . $this->getSalt());
			} else {
				$this->__eCustomerId = substr(md5($this->getBewirtschafterNr() . $this->getWebShopDesMandanten() . $this->getCustomerId() . mt_rand() . mt_rand() . time() . $this->getSalt()), -32);
			}
			Mage::log('paymentbase::getECustomerIdRandom():: Generated customer ID for ePayBL: '.$this->__eCustomerId, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} elseif (!$this->__eCustomerId && $throwIfNotExists) {
			Mage::log("The programmer make an assert that the customer exists already, but the customer doesn't exists!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			self::parseAndThrow("The ePayment customer doesn't exist, but the customer must exist! This is a exception thrown by an assert.");
		}
		return $this->__eCustomerId;
	}

	/**
	 * Liefert die nicht flüchtige Kundennummer für die ePayment Plattform
	 *
	 * Die Kundennummer kann maximal 100 Zeichen lang sein.
	 * Hier wird sie wie folgt erzeugt:
	 * <p>
	 * "WebShopDesMandanten-getECustomerIdRandom()"
	 * </p>
	 * Falls kein Customer angegeben wird, wird dieser aus der Quote bzw. der Session ermittelt.
	 *
	 * @param int|Mage_Customer_Model_Customer $customer         Customer, customer id or null
	 * @param boolean                          $throwIfNotExists Dieser Parameter ist hier ohne Funktion!
	 *
	 * @return String ePayment Kundennummer
	 *
	 * @see Egovs_Paymentbase_Model_Abstract::_getECustomerId
	 */
	public function getECustomerIdNonVolatile($customer = null, $throwIfNotExists = false) {
		$customerId = null;
		if (!$this->__eCustomerId) {
			/* @var $customer Mage_Customer_Model_Customer */
			if ($customer instanceof Mage_Customer_Model_Customer) {
				Mage::log('paymentbase::getECustomerIdNonVolatile():: Customer is Mage_Customer_Model_Customer.', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				$customerId = $customer->getId();
			} else {
				if (is_numeric($customer) && $customer > 0) {
					$customerId = $customer;
				}
				$quote = Mage::getSingleton('checkout/session')->getQuote();
				if (!$quote) {
					Mage::log("paymentbase::getECustomerIdNonVolatile():: No quote available using customer session", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					$customer = Mage::getSingleton('customer/session')->getCustomer();
				} else {
					$customer = $quote->getCustomer();
				}
				if (isset($customerId) &&  ($customer->getId() != $customerId)) {
					Mage::log(sprintf("paymentbase::getECustomerIdNonVolatile():: Customer from session with ID %s isn't equal to given ID %s, reloading...", $customer->getId(), $customerId), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					$customer = Mage::getModel('customer/customer')->load($customerId);
				}

				if (!$customer) {
					Mage::throwException($this->__("No customer available or customer not logged in!"));
				}

				$customerId = $this->getCustomerId($customer);
			}
			Mage::log("paymentbase::getECustomerIdNonVolatile():: Customer ID: $customerId", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

			$this->_nonVolatile = true;
			if (!$customer->hasData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID) && !$customer->isEmpty()) {
				$customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID, "{$this->getWebShopDesMandanten()}-{$this->getECustomerIdRandom($customerId)}");
				Mage::log('paymentbase::getECustomerIdNonVolatile():: Generated customer ID for ePayBL: '.$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				$this->__eCustomerId = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
				if ($customer->getId() > 0 && !$customer->getDeleteOnPlatform()) {
					/* @var $resource Mage_Customer_Model_Resource_Customer */
					$resource = $customer->getResource();
					$resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
				}
			} elseif ($customer->hasData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID)) {
				$this->__eCustomerId = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
				Mage::log('paymentbase::getECustomerIdNonVolatile():: Customer ID for ePayBL: '.$this->__eCustomerId, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			} else {
				$this->__eCustomerId = $this->getECustomerIdRandom($customerId);
				$this->_nonVolatile = false;
			}
		}

		return $this->__eCustomerId;
	}

	/**
	 * Setzt die eCustomer ID zurück auf null.
	 *
	 * Da Mage::getHelper() die Helper in einem Array cached, kann ein Reset nötig sein.
	 *
	 * @return void
	 */
	public function resetECustomerId() {
		
		Mage::log('paymentbase::Resetting eCustomer ID: '.$this->__eCustomerId , Zend_Log::INFO, Egovs_Helper::LOG_FILE);
		$this->__eCustomerId = null;
	}
	/**
	 * Mandantennummer an der ePayment Plattform
	 *
	 * @var string
	 */
	private $__mandantNr = null;

    /**
     * Aktueller Store
     *
     * @var Mage_Core_Model_Store
     */
	private $__store = null;
	/**
	 * Liefert die Mandanten-Nr für die ePayment Plattform
	 *
	 * Die Mandanten-Nr wird vom ePayment vergeben
	 *
	 * @return string
	 */
	public function getMandantNr() {
		if (!$this->__mandantNr || $this->__store !== Mage::app()->getStore()) {
			if (strlen(Mage::getStoreConfig('payment_services/paymentbase/mandantnr')) <= 0) {
				$msg = $this->__('MandantNr not set');
				$session = Mage::getSingleton("admin/session");
				if ($session && $session->isLoggedIn()) {
					if (!$this->_headerAdded) {
						$this->_headerAdded = true;
						$session->addError($this->__('Invalid ePayBL configuration:'));
					}
					$session->addError($msg);
				}
				Mage::log('paymentbase::'.$msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
				$this->sendMailToAdmin('Fehler in ePayment Konfiguration: \n'. $msg);
			} else {
			    $this->__store = Mage::app()->getStore();
				$this->__mandantNr = Mage::getStoreConfig('payment_services/paymentbase/mandantnr');
			}
		}

		return $this->__mandantNr;
	}
	/**
	 * Bewirtschafternummer an der ePayment Plattform
	 *
	 * @var string
	 */
	private $__bewirtschfterNr = null;
	/**
	 * Liefert die Bewirtschafter Nummer
	 *
	 * Die Bewirtschafter-Nr wird von der Bundeskasse vergeben und muss
	 * im ePayment für den Mandanten konfiguriert werden
	 *
	 * @return string
	 */
	public function getBewirtschafterNr() {
		if (!$this->__bewirtschfterNr || $this->__store !== Mage::app()->getStore()) {
			if (strlen(Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')) <= 0) {
				$msg = $this->__('BewirtschafterNr not set');
				$session = Mage::getSingleton("admin/session");
				if ($session && $session->isLoggedIn()) {
					if (!$this->_headerAdded) {
						$this->_headerAdded = true;
						$session->addError($this->__('Invalid ePayBL configuration:'));
					}
					$session->addError($msg);
				}
				Mage::log('paymentbase::'.$msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
				$this->sendMailToAdmin('Fehler in ePayment Konfiguration: \n'. $msg);
			} else {
                $this->__store = Mage::app()->getStore();
				$this->__bewirtschfterNr = trim(Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr'));
			}
		}
		return $this->__bewirtschfterNr;
	}
	/**
	 * Bezeichnung/ID des WebShops des Mandanten
	 *
	 * @var string
	 */
	private $__webshopDesMandanten = null;
	/**
	 * Liefert die 4-stellige Webshop-ID des Mandanten
	 *
	 * Die 4stellige Bezeichnung des Webshops dient der eindeutigen Identifikation
	 * von Kunden mit doppelten Kundennummern in unterschiedlichen Webshops des gleichen
	 * Mandanten; sie identifiziert also gleichzeitig den Bewirtschafter
	 *
	 * @return string
	 */
	public function getWebShopDesMandanten() {
		if (!$this->__webshopDesMandanten || $this->__store !== Mage::app()->getStore()) {
			if (strlen(Mage::getStoreConfig('payment_services/paymentbase/webshopdesmandanten')) <= 0) {
				$msg = $this->__('Webshopdesmandanten not set');
				$session = Mage::getSingleton("admin/session");
				if ($session && $session->isLoggedIn()) {
					if (!$this->_headerAdded) {
						$this->_headerAdded = true;
						$session->addError($this->__('Invalid ePayBL configuration:'));
					}
					$session->addError($msg);
				}
				Mage::log('paymentbase::'.$msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
				$this->sendMailToAdmin('Fehler in ePayment Konfiguration: \n'. $msg);
			} else {
                $this->__store = Mage::app()->getStore();
				$this->__webshopDesMandanten = trim(substr(Mage::getStoreConfig('payment_services/paymentbase/webshopdesmandanten'), 0, 4));
			}
		}

		return $this->__webshopDesMandanten;
	}

	/**
	 * Liefert aus der Order die Kundeninformationen
	 *
	 * Primär wird versucht die Daten aus der Rechnungsadresse der Bestellung zu extrahieren, falls dies nicht funktioniert
	 * werden die Daten direkt aus der Order benutzt.
	 * <strong>Die Daten für Firma können nur aus der Rechnungsadresse geholt werden!</strong>
	 *
	 * @param Mage_Sales_Model_Order|Mage_Customer_Model_Address_Abstract $src Quelle für Daten
	 *
	 * @return Varien_Object
	 */
	public function extractCustomerInformation($src) {
		if ($this->getAdapter()) {
			return $this->getAdapter()->extractCustomerInformation($src);
		}

		//Fallback => sollte durch Default-Adapter eigentlich obsolet sein!
		if (!($src instanceof Mage_Sales_Model_Order) && !($src instanceof Mage_Customer_Model_Address_Abstract)) {
			Mage::throwException($this->__('No order or address available'));
		}

		if ($src instanceof Mage_Sales_Model_Order) {
			$address = $src->getBillingAddress();
		} else {
			$address = $src;
		}

		if (!($address instanceof Mage_Customer_Model_Address_Abstract)) {
			Mage::throwException($this->__('No billing address available'));
		}

		$data = new Varien_Object();
		//TODO: customer_company steht noch nicht zur Verfügung
		if (strlen($address->getCompany()) > 0) {
			//Firma
			$data->setPrefix($this->__('Company'));
			$company = trim(sprintf('%s %s %s', $address->getCompany(), $address->getCompany2(), $address->getCompany3()));
			//20140304::Frank Rochlitzer
			//META Daten für bessere Behandlung von Firmen setzen
			$data->setIsCompany(true);
			$data->setCompany($company);
			$data->setCompanyRepresented(sprintf("%s %s", $address->getFirstname(), $address->getLastname()));
			
			if (mb_strlen($company, 'UTF-8') > 27) {
				if (mb_strlen($company, 'UTF-8') > 54) {
					Mage::log($this->__('There are only 54 characters allowed for company, truncating string to match requirements.'), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
					$company = mb_substr($company, 0, 54, 'UTF-8');
				}
				//Company ist max 54 Zeichen lang
				$len = ceil(mb_strlen($company, 'UTF-8') / 2);
				//20120808:Frank Rochlitzer
				//ePayBL übergibt Namensdaten in der Form: 'Nachname Vorname' an SaxMBS
				$data->setLastname(mb_substr($company, 0, $len, 'UTF-8'));
				$data->setFirstname(mb_substr($company, $len, mb_strlen($company, 'UTF-8')-$len, 'UTF-8'));
			} else {
				//Company wird in Lastname gespeichert
				$data->setLastname($company);
			}
		} else {
			//Person
			// Anrede
			// Magento unterscheidet nicht zwischen Titel und Anrede
			if (strlen($address->getPrefix()) > 0) {
				$data->setPrefix($address->getPrefix());
			} else {
				if ($src instanceof Mage_Sales_Model_Order && strlen($src->getCustomerPrefix()) > 0) {
					$data->setPrefix($src->getCustomerPrefix());
				} elseif ($address instanceof Mage_Customer_Model_Address && $address->getCustomer() != false) {
					$data->setPrefix($address->getCustomer()->getPrefix());
				}
			}
			// Vorname => optional && <= 27 Zeichen
			if (strlen($address->getFirstname()) > 0) {
				$data->setFirstname($address->getFirstname());
			} else {
				if ($src instanceof Mage_Sales_Model_Order && strlen($src->getCustomerFirstname()) > 0) {
					$data->setFirstname($src->getCustomerFirstname());
				} elseif ($address instanceof Mage_Customer_Model_Address && $address->getCustomer() != false) {
					$data->setFirstname($address->getCustomer()->getFirstname());
				}
			}
			// Nachname
			if (strlen($address->getLastname()) > 0) {
				$data->setLastname($address->getLastname());
			} else {
				if ($src instanceof Mage_Sales_Model_Order && strlen($src->getCustomerLastname()) > 0) {
					$data->setLastname($src->getCustomerLastname());
				} elseif ($address instanceof Mage_Customer_Model_Address && $address->getCustomer() != false) {
					$data->setLastname($address->getCustomer()->getLastname());
				} else {
					Mage::throwException($this->__('Lastname is a required field'));
				}
			}
		}

		return $data;
	}
	/**
	 * Erstellt einen Kunden für die ePayment Transaktion.
	 *
	 * Der Kunde wird entweder anonym oder mit den übergebenen Daten erstellt.
	 * Falls der Kunde schon existiert, wird dieser verwendet.
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>lesenKunde</li>
	 *  <li>anlegenKunde</li>
	 * </ul>
	 *
	 * @param int           $customer Kunden ID von ePayBL oder null
	 * @param Varien_Object $data     Objekt mit Kundendaten
	 *
	 * @return	boolean TRUE otherwise Exception is thrown
	 *
	 * @throws	Exception
	 *
	 * @see Egovs_Paymentbase_Helper_Data::parseAndThrow
	 */
	public function createCustomerForPayment($customer = null, $data = null) {
		$objKunde = new Egovs_Paymentbase_Model_Webservice_Types_Kunde($customer);

		$objResult = null;
		try {
			$objResult = $this->getSoapClient()->lesenKunde($objKunde);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}

		// wenn SOAP-Fehler
		if (!$objResult || $objResult instanceof SoapFault) {

			$res = "";
			if (!$objResult) {
				$res = 'ERROR:UNKNOWN SOAP ERROR';
				if (isset($e)) {
					$res .= sprintf("\n%s\n", $e->getMessage());
				}
			} else {
				$res = 'ERROR:'.$objResult->getMessage();
			}

			Mage::log("paymentbase::".$this->__($res), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);

			// Mail an Webmaster senden
			$sMailText = "Fehler in der Logik:\n";
			$sMailText .= "Kundennummer (eGov): $customer\n";
			$sMailText .= "Kundennummer (Shop): {$this->getCustomerId()}\n";
			$sMailText .= "Module: ".get_class($this)."\n";
			$message = $objResult instanceof SoapFault ? $objResult->getMessage() : "Unknown payment error: SoapFault";
			$message .= "\n$res";
			$sMailText .= "Message: $message";
			$sMailText .= "\n\n";

			$this->sendMailToAdmin("Fehler bei lesenKunde:\n\n".$sMailText);
			self::parseAndThrow($res);
		}
		// wenn noch nicht vorhanden dann anlegen
		if ((!$objResult->ergebnis->isOk()) && ($objResult->ergebnis->getCodeAsInt() == -199)) {
			Mage::log("paymentbase::Kunde ist noch nicht vorhanden", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			$objKunde = new Egovs_Paymentbase_Model_Webservice_Types_Kunde(
				// EShopKundenNr, wie sie innerhalb der eGov-Plattform gefuehrt werden soll
				$customer,
				// Sprache
				'de',
				// Titel
				null,
				// Anrede
				$data && $data->hasPrefix() ? $data->getPrefix() : null,
				// Vorname
				$data && $data->hasFirstname() ? $data->getFirstname() : null,
				// Nachname
				$data && $data->hasLastname() ? $data->getLastname() : null,
				// EMailAdresse
				$data && $data->hasEmail() ? $data->getEmail() : null,
				// RechnungsAdresse
				$data && $data->hasInvoiceAddress() ? $data->getInvoiceAddress() : null,
				// Geburtsdatum
				null,
				// Bankverbindung
				$data && $data->hasBankverbindung() ? $data->getBankverbindung() : null,
				// Geschlecht
				null,
				// TelefonNrPrivat
				null,
				// TelefonNrJob
				null,
				// TelefonNrMobil
				null,
				// BonitaetsLevelUeberweisung
				null,
				// BonitaetsLevelLastschrift
				null,
				// BonitaetsLevelKreditkarte
				null
				// Ende Konstruktoraufruf Kunde
			);
			// Kundennummer
			$sText = "Versuche Kunden anzulegen:\n";
			$sText .= "Kundennummer (eGov): $customer\n";
			$sText .= "Kundennummer (Shop): {$this->getCustomerId()}\n";
			Mage::log($this->__($sText), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

			try {
				$objResult = $this->getSoapClient()->anlegenKunde($objKunde);
			} catch (Exception $e) {
				$objResult = null;
				Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				Mage::logException($e);
			}
		} elseif ($objResult->ergebnis->istOk == true) {
			$this->_eCustomerObject = $objResult->kunde;
			// wenn Kunde schon vorhanden
			if ($this->isNonVolatile()) {
				// Kundennummer
				$sMailText = "Kundennummer (eGov): $customer\n";
				$sMailText .= "Kundennummer (Shop): {$this->getCustomerId()}\n";
				Mage::log("paymentbase::Kunde bereits vorhanden:\n". $sMailText, Zend_Log::INFO, Egovs_Helper::LOG_FILE);
				return true;
			}
			// Mail an Webmaster senden
			$sMailText = "Der Kunde ist schon vorhanden und kann nicht doppelt angelegt werden:\n\n";
			// Kundennummer
			$sMailText .= "Kundennummer (eGov): $customer\n";
			$sMailText .= "Kundennummer (Shop): {$this->getCustomerId()}\n";
			Mage::log("paymentbase::Doppelte Kundennummer bei: lesenKunde \n". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);

			$this->sendMailToAdmin("paymentbase::Doppelte Kundennummer bei: 'lesenKunde'\n". $sMailText);

			// Umleitung zu Zahlungsseite
			Mage::throwException(Mage::helper('paymentbase')->__('CUSTOMER_ALREADY_EXISTS', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} else {
			// wenn Fehler

			// Mail an Webmaster senden
			$sMailText = "Während der Kommunikation trat ein Fehler auf!\n\n";

			// Kundennummer
			$sMailText .= "Kundennummer (eGov): $customer\n";
			$sMailText .= "Kundennummer (Shop): {$this->getCustomerId()}\n";
			if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
				$message = isset($objResult->ergebnis) &&  $objResult->ergebnis->getLongText() ? $objResult->ergebnis->getLongText() : "Unknown payment error";
			} elseif ($objResult instanceof SoapFault) {
				$message = $objResult->getMessage();
			} else {
				$message = 'Unknown payment error.';
			}
			$sMailText .= "Message: $message";

			Mage::log("paymentbase::Fehler in Prepayment und bei: lesenKunde ". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);

			if (!$this->omitMailToAdmin($objResult)) {
				$this->sendMailToAdmin("paymentbase::Fehler in Prepayment und bei: 'lesenKunde'\n". $sMailText);
			}

			// Fehlermeldung
			if ($objResult instanceof SoapFault) {
				self::parseAndThrow('ERROR:-999989');
			} elseif ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
				self::parseAndThrow('ERROR_'.$objResult->ergebnis->getCode());
			} else {
				self::parseAndThrow();
			}
		}

		// wenn Fehler dann Mail an Admin und zurück zur Zahlseite + Fehler anzeigen
		if (!$objResult || $objResult instanceof SoapFault || $objResult->ergebnis->istOk != true ) {

			// Mail an Webmaster senden
			$sMailText = "Während der Kommunikation mit dem ePayment-Server trat folgender Fehler auf:\n\n";
			if (!$objResult) {
				$sMailText .= "SOAP: Unknown error, see previous error messages\n\n";
				if (isset($e)) {
					$sMailText .= $e->getMessage()."\n";
				}
			} elseif ($objResult instanceof SoapFault) {
				$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
			} else {
				$sMailText .= $this->getErrorStringFromObjResult($objResult->ergebnis);
			}

			// Kundennummer
			$sMailText .= "Kundennummer (eGov): $customer\n";
			$sMailText .= "Kundennummer (Shop): {$this->getCustomerId()}\n";
			$sMailText .= "Methode: 'anlegenKunde'\n";

			if (!$this->omitMailToAdmin($objResult)) {
				$this->sendMailToAdmin("paymentbase::Fehler in WebService-Funktion: anlegenKunde ". $sMailText);
			}

			Mage::log("paymentbase::Fehler in WebService-Funktion: anlegenKunde ". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			// Fehlermeldung
			if ($objResult instanceof SoapFault) {
				self::parseAndThrow('ERROR_-999989');
			} else {
				self::parseAndThrow('ERROR_STANDARD');
			}
		}

		// wenn Kunde angelegt werden konnte
		if ($objResult->ergebnis->istOk == true) {
			$this->_eCustomerObject = $objResult->kunde;
			Mage::log("paymentbase::Kunde wurde angelegt", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}

		return true;
	}

	/**
	 * Liefert eine Liste verfügbarer Adapter
	 *
	 * @param string $modelClass Kurzname aus Config für Models
	 *
	 * @return array<Egovs_Paymentbase_Model_Adapter_Abstract>
	 */
	public function getAvailableAdapters($modelClass = 'paymentbase') {
		$modelClassName = Mage::getConfig()->getModelClassName($modelClass.'/');
		$moduleName = explode('_', $modelClassName, 3);
		$result = array();
		if (count($moduleName) < 3) {
			return $result;
		}
		$modelPart = '_'.$moduleName[2];
		unset($moduleName[2]);
		$moduleName = implode('_', $moduleName);
		$moduleDir = Mage::getModuleDir(null, $moduleName);
		$modelPart .= '_Adapter';
		$moduleDir .= str_replace('_', DS, $modelPart);
		try {
			$handle = opendir($moduleDir);
		} catch (Exception $e) {
			return $result;
		}
		if (!$handle) {
			return $result;
		}
		while (false !== ($file = readdir($handle))) {
			if ($file == '.' || $file == '..' || is_dir($moduleDir.DS.$file)) {
				continue;
			}

			if (function_exists('fnmatch')) {
				if (!fnmatch('*.php', $file) || fnmatch('Abstract.php', $file)) {
					continue;
				}
			} else {
				continue;
			}

			$file = str_replace('.php', '', $file);
			if (false === function_exists('lcfirst')) {
				if (isset($file[0])) {
					$file[0] = strtolower($file[0]);
				}
				$file = sprintf('%s/adapter_%s', $modelClass, $file);
			} else {
				$file = sprintf('%s/adapter_%s', $modelClass, lcfirst($file));
			}

			try {
				$model = Mage::getModel($file);
				if ($model instanceof Egovs_Paymentbase_Model_Adapter_Abstract) {
					$result[] = $model;
				} else {
					Mage::log(sprintf('paymentbase::Model \'%s\' is not type of Adapter', get_class($model)), Zend_Log::WARN, Egovs_Helper::LOG_FILE );
				}
			} catch (Exception $e) {
				//nothing
			}
		}
		closedir($handle);

		return $result;
	}

	/**
	 * Gibt die neue Kundenadresse oder false zurück.
	 *
	 * @param Mage_Customer_Model_Customer $customer Kunde
	 *
	 * @return Mage_Customer_Model_Address|false
	 */
	public function getChangedCustomerAddress($customer) {
		if (!$customer instanceof Mage_Customer_Model_Customer) {
			return false;
		}

		if (!$customer || $customer->getId() < 1) {
			return false;
		}

		$new = $customer->getDefaultBilling();
		$orig = $customer->getOrigData('default_billing');

		if (!isset($new) && !isset($orig)) {
			return false;
		}

		$address = null;
		if ($new == $orig || !is_numeric($new)) {
			//Es existiert keine default Adresse mehr
			if (!isset($new)) {
				/*
				 * $customer->getAddresses() cached Daten, daher nicht nutzen
				*/
				$addresses = array();
				$collection = $customer->getAddressCollection()
					->setCustomerFilter($customer)
					->addAttributeToSelect('*')
					->load()
				;
				foreach ($collection as $address) {
					$addresses[] = $address;
				}

				if (is_array($addresses) && count($addresses) > 0) {
					$address = current($addresses);
				} else {
					//Wenn keine Adressen verfügbar sind
					return false;
				}
			} elseif (is_numeric($orig) && $new == $orig) {
				$address = $customer->getDefaultBillingAddress();
				
				$id = (string) $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
				if (!$id) { 
					return false;
				}
				$this->getCustomerFromEPayment($id, true);
				$eCustomer = $this->getECustomer();
				if (!$eCustomer) {
					//Müsste eigentlich durch vorherige Prüfungen unmöglich sein, es sei denn der Kunde wurde direkt an der ePayBL gelöscht!
					Mage::log(sprintf("paymentbase::getCustomerFromEPayment:Kunde nicht vorhanden!\nID=%s\nePayBL-ID=%s", $customer->getId(), $id), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
					return false;
				}
				if (isset($eCustomer->status) && isset($eCustomer->status->code) && $eCustomer->status->code != 'AKTIV') {
					Mage::log(sprintf("paymentbase::getCustomerFromEPayment:Kunde nicht mehr aktiv (STATUS:%s)!\nID=%s\nePayBL-ID=%s", $eCustomer->status->code, $customer->getId(), $id), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
					if ($eCustomer->status->code == 'GESPERRT') {
						return false;
					}
					$address->setECustomerIsDeleted(true);
					return $address;
				}
				$ePyBLAdr = $eCustomer->rechnungsAdresse;
				$hasChanged = false;
				if ($address instanceof Mage_Customer_Model_Address_Abstract) {
					$addressData = $this->extractCustomerInformation($address);
				} else {
					$addressData = $address;
				}
				$map = array("lastname"=>"nachname", "firstname"=>"vorname", "prefix"=>"anrede");
				
				foreach ($map as $key => $keyTwo) {
					if ($addressData->getData($key) != $eCustomer->$keyTwo) {
						$hasChanged = true;
						break;
					}
				}				
				
				$map = array("street"=>"strasse","city"=>"ort","country_id"=>"land","postcode"=>"PLZ");
				
				foreach ($map as $key => $keyTwo) {
					if (!$ePyBLAdr || $address->getData($key) != $ePyBLAdr->$keyTwo) {
						$hasChanged = true;
						break;
					}
				}
				if (!$hasChanged) {
					return false;
				}
			} else {
				return false;
			}
		} else {
			/* @var $address Mage_Customer_Model_Address */
			$address = $customer->getDefaultBillingAddress();
		}
		if (!$address) {
			return false;
		}

		return $address;
	}

	/**
	 * Gibt einen Adressänderung an die ePayment-Plattform weiter.
	 *
	 * Wird nach dem speichern eines Kunden aufgerufen.<br>
	 * Falls keine Adresse mehr am Kunden existiert, wird der Kunde an der Plattform gelöscht.
	 *
	 * @param Mage_Customer_Model_Customer $customer Kunde
	 *
	 * @return Egovs_Paymentbase_Helper_Data
	 */
	public function changeCustomerAddressOnPlattform($customer) {
		if (!$customer instanceof Mage_Customer_Model_Customer) {
			return $this;
		}

		if (!$customer || $customer->getId() < 1) {
			return $this;
		}

		if (!$customer->hasData(self::ATTRIBUTE_EPAYBL_CUSTOMER_ID) || !$customer->getData(self::ATTRIBUTE_EPAYBL_CUSTOMER_ID)) {
			return $this;
		}

		$address = $this->getChangedCustomerAddress($customer);
		if (!$address) {
			return $this;
		}

		if ($address->getECustomerIsDeleted()) {
			// TODO :: Fehlerbehandlung implementieren!
		}

		$data = $this->extractCustomerInformation($address);
		$data->setInvoiceAddress($address);

		$code = 0;
		try {
			$code = $this->modifyCustomerOnEPayment($customer, $data, true);
		} catch (Egovs_Paymentbase_Exception_Validation $e) {
			throw $e;
		} catch (Exception $e) {
			$code = -9999;
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}
		

		//Falls Fehler
		if (intval($code) < 0) {
			switch (intval($code)) {
				case -120:
					//Kunde zum Löschen markiert
					/* @var $resource Mage_Customer_Model_Resource_Customer */
					Mage::log(sprintf("paymentbase::Removing eCustomerID (%s) from Customer (ID: %s). eCustomer is marked for deletion on ePayBL.", $customer->getData(self::ATTRIBUTE_EPAYBL_CUSTOMER_ID), $customer->getId()), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
					$resource = $customer->getResource();
					$customer->unsetData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
					$resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
					$this->resetECustomerId();
					break;
				case -199:
				    //Kunde nicht vorhanden
                    $customerId = $customer ? $customer->getId() : "0";
				    Mage::log("paymentbase::The customer doesn't exist on the ePayment server (ID: $customerId)", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
					break;
				default:
					self::parseAndThrow($code);
					break;
			}
		}

		return $this;
	}

	/**
	 * Ändert einen Kunden an der ePayment Plattform.
	 *
	 * Der Kunde wird entweder anonym oder mit den übergebenen Daten erstellt.
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>aendernKunde</li>
	 * </ul>
	 *
	 * @param int|Mage_Customer_Model_Customer $customer       Customer, Customer ID oder null
	 * @param Varien_Object                    $data           Objekt mit Kundendaten
	 * @param bool                             $ignoreNotExist Ignoriere Errors falls Kunde nicht existiert
	 *
	 * @return	int ePayment code, '+0000' if OK
	 *
	 */
	public function modifyCustomerOnEPayment($customer = null, $data = null, $ignoreNotExist = false) {

		if ($customer instanceof Egovs_Paymentbase_Model_Webservice_Types_Kunde) {
			$objKunde = $customer;
		} else {
			// komplett anonym oder mit daten
			$objKunde = new Egovs_Paymentbase_Model_Webservice_Types_Kunde(
				// EShopKundenNr, wie sie innerhalb der eGov-Plattform gefuehrt werden soll
				$this->getECustomerId($customer),
				// Sprache
				'de',
				// Titel
				null,
				// Anrede
				$data && $data->hasPrefix() ? $data->getPrefix() : null,
				// Vorname
				$data && $data->hasFirstname() ? $data->getFirstname() : null,
				// Nachname
				$data && $data->hasLastname() ? $data->getLastname() : null,
				// EMailAdresse
				$data && $data->hasEmail() ? $data->getEmail() : null,
				// RechnungsAdresse
				$data && $data->hasInvoiceAddress() ? $data->getInvoiceAddress() : null,
				// Geburtsdatum
				null,
				// Bankverbindung
				null,
				// Geschlecht
				null,
				// TelefonNrPrivat
				null,
				// TelefonNrJob
				null,
				// TelefonNrMobil
				null,
				// BonitaetsLevelUeberweisung
				null,
				// BonitaetsLevelLastschrift
				null,
				// BonitaetsLevelKreditkarte
				null
				// Ende Konstruktoraufruf Kunde
			);
		}

		try {
			$objResult = $this->getSoapClient()->aendernKunde($objKunde);
		} catch (Exception $e) {
			$objResult = null;
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}

		// wenn Fehler dann Mail an Admin und zurück zur Zahlseite + Fehler anzeigen
		if ((!$objResult || $objResult instanceof SoapFault || $objResult->ergebnis->istOk != true)
			&& !($objResult && $objResult->ergebnis->getCodeAsInt() == -199 && $ignoreNotExist)
		) {
			// Mail an Webmaster senden
			$sMailText = "Während der Kommunikation mit dem ePayment-Server trat folgender Fehler auf:\n\n";
			if (!$objResult) {
				$sMailText .= "SOAP: Unknown error, see previous error messages\n\n";
			} elseif ($objResult instanceof SoapFault) {
				$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
			} else {
				$sMailText .= $this->getErrorStringFromObjResult($objResult->ergebnis);
				switch ($objResult->ergebnis->getCodeAsInt()) {
					case -120:
						/*
						 * Code: -0120
						 * Titel: Kunden nicht änderbar
						 * Beschreibung: Der Kunde ist zum Löschen markiert, änderungen seiner Daten sind nicht mehr möglich.
						 */
						$sMailText .= sprintf("Das Errorlogfile '%s' enthält weitere Informationen. Der Fehler kann unter Umständen ignoriert werden.\n", Egovs_Helper::EXCEPTION_LOG_FILE);
						break;
					case -440:
					    $_bankverbindung = $objKunde->getBankverbindung();
						if ($objKunde && isset($_bankverbindung)) {
							if ($_bankverbindung instanceof Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung) {
								$sMailText .= sprintf("BIC: %s\n", $_bankverbindung->getBic());
							} elseif ($_bankverbindung instanceof stdClass) {
								if (isset($_bankverbindung->BIC)) {
									$sMailText .= sprintf("BIC: %s\n", $_bankverbindung->BIC);
								} else {
								    $sMailText .= sprintf("Keine BIC verfügbar!\n");
                                }
							}
							//$sMailText .= sprintf("Bankverbindung:\n%s\n", var_export($_bankverbindung, true));
						} else {
						    $sMailText .= "Keine Bankverbindung verfügbar!\n";
                        }
						break;
				}
				$sMailText .= "\n";
			}

			// Kundennummer
			$sMailText .= "Kundennummer (eGov): {$this->getECustomerId($customer)}\n";
			$sMailText .= "Kundennummer (Shop): {$this->getCustomerId($customer)}\n";

			if (!$this->omitMailToAdmin($objResult)) {
				$this->sendMailToAdmin("paymentbase::Fehler in WebService-Funktion: aendernKunde\n$sMailText");
			}
			
			if ($data instanceof Varien_Object) {
				$sMailText .= sprintf("Data to change:\n%s\n", print_r($data->getData(), true));
			} elseif (is_array($data)) {
				$sMailText .= sprintf("Data to change:\n%s\n", print_r($data, true));
			}

			$sMailText .= $this->_logTrace()."\n";
			Mage::log("paymentbase::Fehler in WebService-Funktion: aendernKunde ". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			// Fehlermeldung
			if (!$objResult || $objResult instanceof SoapFault) {
				return 'ERROR:-999989';
			}

			return $objResult->ergebnis->getCode();
		}

		// wenn Kunde angelegt werden konnte
		if ($objResult->ergebnis->istOk == true) {
			$this->_eCustomerObject = $objResult->kunde;
			Mage::log("paymentbase::Kunde wurde geändert", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}

		return $objResult->ergebnis->getCode();
	}

	/**
	 * Return the output from a backtrace
	 *
	 * @param string $message Optional message that will be sent the the error_log before the backtrace
	 */
	protected function _logTrace($message = '') {
		$logMsg = '';
		if (version_compare(phpversion(), '5.3.6', '<')) {
			$trace = debug_backtrace(false);
		} else {
			$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		}
		if ($message) {
			$logMsg = sprintf("%s:\n", $message);
		}
		$caller = array_shift($trace);
		$function_name = $caller['function'];
		$logMsg .= sprintf("%s: Called from %s:%s\n", $function_name, $caller['file'], $caller['line']);
		foreach ($trace as $entry_id => $entry) {
			$entry['file'] = $entry['file'] ? '' : '-';
			$entry['line'] = $entry['line'] ? $entry['line'] : '-';
			if (empty($entry['class'])) {
				$logMsg .= sprintf("%s %3s. %s() %s:%s\n", $function_name, $entry_id + 1, $entry['function'], $entry['file'], $entry['line']);
			} else {
				$logMsg .= sprintf("%s %3s. %s->%s() %s:%s\n", $function_name, $entry_id + 1, $entry['class'], $entry['function'], $entry['file'], $entry['line']);
			}
		}
		return $logMsg;
	}

	/**
	 * Löscht den Kunden an der ePayment Plattform
	 *
	 * Das Löschen des Kunden wird im Fehlerfall nicht mit einer Exception beendet!
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>loeschenKunde</li>
	 * </ul>
	 *
	 * @param Mage_Customer_Model_Customer|int $customer    Kunde oder Kunden-Id
	 * @param String                           $code        Helper Name (default = paymentbase)
	 * @param bool							   $nonVolatile Kundennummer ist nicht flüchtig? (default = false)
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis Ergebnis
	 *
	 * @see Egovs_Paymentbase_Helper_Data::getECustomerId
	 */
	public function loeschenKunde($customer = null, $code = 'paymentbase', $nonVolatile = false) {
		// Webservice aufrufen
		$objResult = null;
		$eCustomerId = $this->getECustomerId($customer);

		if (array_key_exists($eCustomerId, $this->_lastDeletedECustomerIds)) {
			return $this->_lastDeletedECustomerIds[$eCustomerId];
		}
		try {
			$objResult = $this->getSoapClient()->loeschenKunde($eCustomerId);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}
		// wenn Fehler dann Mail an Admin und zurück zur Zahlseite + Fehler anzeigen
		if (!$objResult || $objResult instanceof SoapFault || $objResult->ergebnis->istOk != true) {

			// Mail an Webmaster senden
			$sendMail = true;
			$sMailText = "Während der Kommunikation mit dem ePayment-Server trat folgender Fehler auf:\n\n";
			if ($objResult instanceof SoapFault) {
				$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
			} elseif (!$objResult || (!($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis) && !($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Kundenergebnis))) {
				$sMailText .= $this->__("Error: Couldn't delete the customer on the ePayment server, no result returned!")."\n";
			} else {
				if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Kundenergebnis) {
					$objResult = $objResult->ergebnis;
				}
				$sMailText .= $this->getErrorStringFromObjResult($objResult);
				
				if ($objResult->getCodeAsInt() == -199) {
					$sendMail = false;
				}
			}
			// neue Kundennummer
			$sMailText .= "Kundennummer (eGov): $eCustomerId\n"; //Kundennummer ist hier zwischengespeichert
			$sMailText .= "Kundennummer (Shop): {$this->getCustomerId($customer)}\n";

			Mage::log("$code::Fehler in WebService-Funktion: loeschenKunde\n". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);

			if ($sendMail && !$this->omitMailToAdmin($objResult)) {
				$this->sendMailToAdmin("Fehler in WebService-Funktion: 'loeschenKunde'\n". $sMailText);
			}
		} else {
			$this->_lastDeletedECustomerIds[$eCustomerId] = $objResult;
			Mage::log("$code::{$this->__('Customer on ePayment server successfully deleted')}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}

		$this->resetECustomerId();

		return $objResult;
	}

	/**
	 * Ist ePayBL verfügbar?
	 *
	 * @param string $mandantNr Mandantennummer
	 *
	 * @return Egovs_Paymentbase_Helper_Data
	 *
	 * @throws Exception
	 */
	public function isAlive($mandantNr = null) {
		// Webservice aufrufen
		$objResult = null;
		$code = 'paymentbase';

		try {
			$objResult = $this->getSoapClient()->isAlive($mandantNr);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw $e;
		}

		// wenn Fehler
		if (!$objResult || $objResult instanceof SoapFault || $objResult->istOk != true) {
			$sErrorText = "Während der Kommunikation mit dem ePayment-Server trat folgender Fehler auf:\n\n";
			if ($objResult instanceof SoapFault) {
				$sErrorText .= "SOAP: " . $objResult->getMessage() . "\n\n";
			} elseif (!$objResult) {
				$sErrorText .= $this->__("Error: Couldn't check status of ePayment server, no result returned!")."\n";
			} else {
				$sErrorText .= $this->getErrorStringFromObjResult($objResult);
			}

			Mage::log("$code::Fehler in WebService-Funktion: 'isAlive'\n". $sErrorText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw new Exception("$code::Fehler in WebService-Funktion: 'isAlive'\n". $sErrorText);
		} else {
			Mage::log("$code::{$this->__('ePayment server is alive')}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}

		return $this;
	}

	/**
	 * Liefert die Bankverbidnung des Bewirtschafters der ePayBL zurück.
	 *
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>leseBankverbindungBewirtschafter</li>
	 * </ul>
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis
	 */
	public function leseBankverbindungBewirtschafter() {
	
		$objResult = null;
		$code = 'paymentbase';
	
		try {
			$objResult = $this->getSoapClient()->leseBankverbindungBewirtschafter();
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw $e;
		}
	
		// wenn Fehler
		if (!$objResult || $objResult instanceof SoapFault || !($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis) || $objResult->ergebnis->istOk != true) {
			$sErrorText = "Während der Kommunikation mit dem ePayment-Server trat folgender Fehler auf:\n\n";
			if ($objResult instanceof SoapFault) {
				$sErrorText .= "SOAP: " . $objResult->getMessage() . "\n\n";
			} elseif (!$objResult) {
				$sErrorText .= $this->__("Error: Couldn't check status of ePayment server, no result returned!")."\n";
			} else {
				$sErrorText .= $this->getErrorStringFromObjResult($objResult);
			}
	
			Mage::log("$code::Fehler in WebService-Funktion: 'leseBankverbindungBewirtschafter'\n". $sErrorText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw new Exception("$code::Fehler in WebService-Funktion: 'leseBankverbindungBewirtschafter'\n". $sErrorText);
		}
		
		return $objResult;
	}
	
	/**
	 * Liefert Informationen zum übergebenen Kassenzeichen am ePayBL
	 *
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>lesenKassenzeichenInfo</li>
	 * </ul>
	 *
	 * @param string $kzeichen Kassenzeichen
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis beinhaltet einerseits den Returncode einer Abfrage nach
	 * einer Liste der verbuchten Zahlungseingänge zu Kassenzeichen des anfragenden
	 * Mandanten und andererseits wird die Liste der von ZÜV zurückgemeldeten Zahlungseingangselemente zurückgegeben
	 */
	public function lesenKassenzeichenInfo($kzeichen) {

		// Webservice-Client holen
		$objSOAPClientBfF = Mage::helper('paymentbase')->getSoapClient();

		// Pruefung von Parametern
		if ((!isset ($kzeichen)) || (strlen(trim($kzeichen)) <= 0)
				|| !$this->getMandantNr()
				|| strlen($this->getMandantNr()) <= 0
		) {
			// Mail an Webmaster senden
			$sMailText = "In der Parameterbestimmung für den ePayment-Server liegt ein Fehler vor!\n\n";
			$sMailText .= "Bestimmung der eingegangenen Zahlungen bei Hilfsfunktion lesenKassenzeichenInfo() \n";
			$sMailText .= "Kassenzeichen: $kzeichen: MandantNr.: {Mage::helper('paymentbase')->getMandantNr()}\n";

			Mage::log("paymentbase:: $sMailText", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);

			return -9999;
		}

		// Liste abfragen
		$arrResult = null;
		try {
			$arrResult = $objSOAPClientBfF->lesenKassenzeichenInfo($kzeichen);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
			/* @var $arrResult Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis */
			$arrResult = Mage::getModel('paymentbase/webservice_types_response_kassenzeichenInfoErgebnis');
			$arrResult->ergebnis = Mage::getModel('paymentbase/webservice_types_response_ergebnis');
			$arrResult->ergebnis->istOK = false;
			$arrResult->ergebnis->setLongText($e->getMessage());
			$arrResult->ergebnis->setCode(-9999);
		}
		
		if ($arrResult instanceof SoapFault) {
			$e = $arrResult;
			/* @var $arrResult Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis */
			$arrResult = Mage::getModel('paymentbase/webservice_types_response_kassenzeichenInfoErgebnis');
			$arrResult->ergebnis = Mage::getModel('paymentbase/webservice_types_response_ergebnis');
			$arrResult->ergebnis->istOK = false;
			$arrResult->ergebnis->setLongText($e->getMessage());
			if ($e->getCode()) {
				$arrResult->ergebnis->setCode($e->getCode());
			} else {
				$arrResult->ergebnis->setCode(-9999);
			}
		}

		// wenn SOAP-Fehler
		if (!$arrResult || !is_object($arrResult)) {
			// dann Abbruch mit Fehler
			return -9999;
		}

		return $arrResult;
	}

	/**
	 * Parsed den übergbenen "ERROR:1234" oder "1234" oder "ERROR_1234" ERROR code und wirft eine Exception
	 *
	 * Diese Methode löst immer eine Exception aus!
	 * Es wird keine E-Mail erstellt oder gesendet.
	 *
	 * @param string $error Error-Message
	 * @param string $code  Name für Helper
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public static function parseAndThrow($error, $code = 'paymentbase') {
		if (!isset($error)) {
			$error = '';
		}

		if (substr($error, 0, 5) == 'ERROR') {
			switch (intval(substr($error, 6))) {
				case -611:
					Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR_-0611', Mage::helper('paymentbase')->getCustomerSupportMail()));
				default :
					$base = 'TEXT_PROCESS_'. $error;
					$translate = Mage::helper($code)->__($base, Mage::helper('paymentbase')->getCustomerSupportMail());
					if ($base == $translate) {
						$base = str_ireplace("ERROR:", "ERROR_", $error);
						$translate = Mage::helper($code)->__($base, Mage::helper('paymentbase')->getCustomerSupportMail());
						if ($base == $translate) {
							Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR:UNKNOWN SOAP ERROR', Mage::helper('paymentbase')->getCustomerSupportMail()));
						} else {
							Mage::throwException($translate);
						}
					} else {
						Mage::throwException($translate);
					}
			}
		}

		$base = 'TEXT_PROCESS_ERROR:'. $error;
		$translate = Mage::helper($code)->__($base, Mage::helper('paymentbase')->getCustomerSupportMail());
		if ($base == $translate) {
			$base = str_ireplace("ERROR:", "ERROR_", $error);
			$translate = Mage::helper($code)->__($base, Mage::helper('paymentbase')->getCustomerSupportMail());
			if ($base == $translate) {
				Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR:UNKNOWN SOAP ERROR', Mage::helper('paymentbase')->getCustomerSupportMail()));
			} else {
				Mage::throwException($translate);
			}
		} else {
			Mage::throwException($translate);
		}
	}

	/**
	 * Gibt die ePayment Adminmailadresse aus der Adminkonfiguration zurück.
	 *
	 * @return string
	 */
	public  function getAdminMail() {
		$mail = Mage::getStoreConfig('payment_services/paymentbase/adminemail');
		if (strlen($mail) > 0) {
			return $mail;
		}
		return $this->getCustomerSupportMail();
	}
	/**
	 * Liefert ein Options-Array (PaymentCode => PaymentTitel) zurück
	 *
	 * @return array
	 */
	public function getActivePaymentMethods()
	{
		$payments = Mage::getSingleton('payment/config')->getActiveMethods();

		$methods = array();

		foreach ($payments as $paymentCode=>$paymentModel) {
			$paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
			$methods[$paymentCode] = $paymentTitle;
		}

		asort($methods);

		return $methods;
	}
	/**
	 * Gibt die Kundensupport Mailadresse aus der Adminkonfiguration zurück.
	 *
	 * @param string $module Name für Helper
	 *
	 * @return string
	 */
	public function getCustomerSupportMail($module = "paymentbase") {
		//trans_email/ident_support/email
		$mail = Mage::getStoreConfig('trans_email/ident_support/email');
		if (strlen($mail) > 0) {
			return $mail;
		}

		return Mage::helper($module)->__("Mail address not set")."!";
	}

	/**
	 * Liefert den Allgemeinen Kontakt des Shops als array
	 *
	 * Format:</br>
	 * array (
	 * 	name => Name
	 * 	mail => Mail
	 * )
	 *
	 * @param string $module Modulname
	 *
	 * @return array <string, string>
	 */
	public function getGeneralContact($module = "paymentbase") {
		/* Sender Name */
		$name = Mage::getStoreConfig('trans_email/ident_general/name');
		if (strlen($name) < 1) {
			$name = 'Shop';
		}
		/* Sender Email */
		$mail = Mage::getStoreConfig('trans_email/ident_general/email');
		if (strlen($mail) < 1) {
			$mail = 'dummy@shop.de';
		}

		return array('name' => $name, 'mail' => $mail);
	}

	/**
	 * Sendet eine Mail mit $body als Inhalt an den Administrator
	 *
	 * @param string $body    Body der Mail
	 * @param string $subject Betreff
	 * @param string $module  Modulname für Übersetzungen
	 *
	 * @return void
	 */
	public function sendMailToAdmin($body, $subject="WS Fehler:", $module="paymentbase") {
		if (strlen(Mage::getStoreConfig('payment_services/paymentbase/adminemail')) > 0
			&& strlen($body) > 0
		) {
			$mailTo = $this->getAdminMail();
			$mailTo = explode(';', $mailTo);
			/* @var $mail Mage_Core_Model_Email */
			$mail = Mage::getModel('core/email');
			$shopName = Mage::getStoreConfig('general/imprint/shop_name');
			$body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
			$mail->setBody($body);
			$mailFrom = $this->getGeneralContact($module);
			$mail->setFromEmail($mailFrom['mail']);
			$mail->setFromName($mailFrom['name']);
			$mail->setToEmail($mailTo);

			$sdm = Mage::getStoreConfig('payment_services/paymentbase/webshopdesmandanten');
			$subject = sprintf("%s::%s", $sdm, $subject);
			$mail->setSubject($subject);
			try {
				$mail->send();
			}
			catch(Exception $ex) {
				$error = Mage::helper($module)->__('Unable to send email.');

				if (isset($ex)) {
					Mage::log($error.": {$ex->getTraceAsString()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				} else {
					Mage::log($error, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				}

				//TODO: Im Frontend sollte diese Meldung nicht zu sehen sein!
				//Mage::getSingleton('core/session')->addError($error);
			}
		}
	}

	/**
	 * Prüft ob die URI in der Proxy-Ausnahmeliste enthalten ist.
	 *
	 * @param string $uri     URI
	 * @param array  &$config Config array mit Key => Value Paaren
	 *
	 * @return void
	 */
	public static function checkForProxyExcludes($uri = null, &$config = null) {
    	$excludeList = null;
    	try {
    		$excludeList = Mage::getStoreConfig('web/proxy/exclude_list');
    	} catch (Exception $e) {
    		return;
    	}

    	$excludeArray = explode("\n", $excludeList);

    	if (empty($excludeArray) || empty($uri)) {
    		return;
    	}

    	$match = false;
    	foreach ($excludeArray as $exclude) {
    		if (stripos($uri, trim($exclude)) !== false) {
    			$match = true;
    			break;
    		}
    	}

    	if (!$match) {
    		return;
    	}

    	//Proxy deaktivieren
    	if ($config === false || is_null($config) || !is_array($config)) {
    		$config = array();
    	}
    	foreach ($config as $k => $v) {
    		if (stripos($k, 'proxy') === false) {
    			continue;
    		}

    		unset($config[$k]);
    	}
    }
    
    /**
     * Liefert einen 40 Zeichen SHA1 Hash
     *
     * Der Hash wird über die Mandatsreferenz und die ePayBL-Kunden-ID erzeugt.
     *
     * @param Mage_Customer_Model_Customer $customer   Customer
     * @param String                       $mandate_id Mandats-ID
     *  
     * @return string
     *
     * @throws Egovs_Paymentbase_Exception_Code
     */
    public function getPdfMandateName($customer, $mandate_id = null) {
    	if (!($customer instanceof Mage_Customer_Model_Customer)) {
    		throw new Egovs_Paymentbase_Exception_Code($this->__('Customer instance expected'));
    	}
    	if ($mandate_id === null) {
    		if (!$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)) {
    			throw new Egovs_Paymentbase_Exception_Code($this->__('The customer have no mandate reference, but a mandate reference is required!'));
    		} else {
    			$mandate_id = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
    		}
    	}
    	if (!$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID)) {
    		throw new Egovs_Paymentbase_Exception_Code($this->__('The customer have no ePayBL-ID, but ID is required!'));
    	}
    	$hash = sha1($mandate_id.$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID));
    	$hash .= '.pdf';
    	return $hash;
    }
    
    /**
     * Gibt den Speicherort für erzeugte PDF-Mandate an
     *
     * Das Magento Media-Verzeichnis wird immer der EInstellung aus
     * der Konfiguration vorangesetzt. <br/>
     * Ein möglicher DIRECTORY_SEPARATOR am Ende wird entfernt.
     *
     * @return string;
     */
    public function getMandatePdfTemplateStore() {
    	$store = Mage::getStoreConfig("payment_services/paymentbase/mandate_pdf_template_store");
    	if (strpos($store, DIRECTORY_SEPARATOR) !== 0) {
    		$store = DIRECTORY_SEPARATOR.$store;
    	}
    	$length = strlen($store);
    	if ($length > 1 && strpos($store, DIRECTORY_SEPARATOR) === $length - 1) {
    		$store = substr($store, 0, strlen($store) - 1);
    	}
    
    	$store = Mage::getBaseDir('media').$store;
    	return $store;
    }
    
    
    /**
     * Daten für SEPA Mandat in zusätzlichen Feldern speichern
     * 
     * @param Mage_Customer_Model_Customer $customer Customer
     * @param String                       $key      Key
     * 
     * @return Varien_Object|null
     */
    public function getAdditionalCustomerMandateData($customer, $key = null) {
    	$data = $customer->getData(self::ATTRIBUTE_SEPA_ADDITIONAL);
    	if ($data) {
    		$data = unserialize($data);
    	}
    	
    	if ($key) {
    		if (isset($data[$key])) {
    			return $data[$key];
    		}
    		
    		return null;
    	}
    
    	return $data;
    }
    
    /**
     * Daten für SEPA Mandat in zusätzlichen Feldern speichern
     * 
     * @param Mage_Customer_Model_Customer $customer Customer
     * @param array                        $data     Array
     * 
     * @return Egovs_Paymentbase_Helper_Data
     */    
    public function setAdditionalCustomerMandateData($customer, $data) {
    	if ($data) {
    		$data = serialize($data);
    	}
    	$customer->setData(self::ATTRIBUTE_SEPA_ADDITIONAL, $data);
    
    	$resource = $customer->getResource();
    	$resource->saveAttribute($customer, self::ATTRIBUTE_SEPA_ADDITIONAL);
    	
    	return $this;
    }
    
    /**
     * Daten für SEPA Mandat in zusätzlichen Feldern speichern
     * 
     * @param Mage_Customer_Model_Customer $customer Customer
     * @param array                        $data     Array
     * 
     * @return Egovs_Paymentbase_Helper_Data
     */    
    public function changeAdditionalCustomerMandateData($customer, $data) {
    	$old = $this->getAdditionalCustomerMandateData($customer);
    	if (!$old) {
    		$old = array();
    	}
    
    	$data = array_merge($old, $data);
    
    	$this->setAdditionalCustomerMandateData($customer, $data);
    
    	return $this;
    }
    
    /**
     * Daten für SEPA Mandat in zusätzlichen Feldern entfernen
     * 
     * @param Mage_Customer_Model_Customer $customer Customer
     * @param string                       $key      Key
     * 
     * @return Egovs_Paymentbase_Helper_Data
     */
    public function unsAdditionalCustomerMandateData($customer, $key = null) {
    	if ($key == null) {
    		return $this;
    	}
    	
    	$data = $this->getAdditionalCustomerMandateData($customer);
    	if (!$data) {
    		return $this;
    	}
    
    	if (isset($data[$key])) {
    		unset($data[$key]);
    		$this->setAdditionalCustomerMandateData($customer, $data);
    	}
     
    	return $this;
    }
    
    public function epayblErrorHandler($errno, $errstr, $errfile, $errline) {
    	if (strpos($errstr, 'DateTimeZone::__construct')!==false) {
    		// there's no way to distinguish between caught system exceptions and warnings
    		return false;
    	}
    
    	if (!defined('E_STRICT')) {
    		define('E_STRICT', 2048);
    	}
    	if (!defined('E_RECOVERABLE_ERROR')) {
    		define('E_RECOVERABLE_ERROR', 4096);
    	}
    	if (!defined('E_DEPRECATED')) {
    		define('E_DEPRECATED', 8192);
    	}
    
    	// PEAR specific message handling
    	if (stripos($errfile.$errstr, 'pear') !== false) {
    		// ignore strict and deprecated notices
    		if (($errno == E_STRICT) || ($errno == E_DEPRECATED)) {
    			return true;
    		}
    		// ignore attempts to read system files when open_basedir is set
    		if ($errno == E_WARNING && stripos($errstr, 'open_basedir') !== false) {
    			return true;
    		}
    	}
    
    	$errorMessage = '';
    
    	switch($errno){
    		case E_ERROR:
    			$errorMessage .= "Error";
    			break;
    		case E_WARNING:
    			$errorMessage .= "Warning";
    			break;
    		default:
    			return false;
    	}
    
    	$errorMessage .= ": {$errstr}  in {$errfile} on line {$errline}";
    
    	Mage::log(
    	sprintf("SOAP: %s", $errstr),
    	Zend_Log::ERR,
    	Egovs_Helper::EXCEPTION_LOG_FILE
    	);
    	 
    	throw new Exception($errorMessage);
    }
    
    
    /**
     * Ermitteln des Wertes eines Haushaltsparameters anhand einer Id
     * @param Id des Haushaltparameters $id
     * @return string
     */
    public function getHaushaltsparameter($id)
    {
    	$obj = Mage::getModel('paymentbase/haushaltsparameter')->load($id);
    	if($obj)
    	{
    		return $obj->getValue();
    	}
    	return "";
    	
    }
    
    /**
     * Gibt die verwendete ePayBL Version zurück
     * 
     * @param int|Mage_Core_Model_Store $store
     * 
     * @return NULL|string
     */
    public function getEpayblVersionInUse($store = null) {
    	return Mage::getStoreConfig('payment_services/paymentbase/epaybl_to_use', $store);
    }
    
    /**
     * Liefert einen String aus einem Ergebnis-Objekt
     * 
     * @param Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis $objResult
     * 
     * @return string
     */
    public function getErrorStringFromObjResult(Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis $objResult) {
    	if (!$objResult) {
    		return 'No error object available!';
    	}
    	$sErrorText = "Code: {$objResult->getCode()}\n";
    	$sErrorText .= "Titel: {$objResult->getShortText()}\n";
    	$sErrorText .= "Beschreibung: {$objResult->getLongText()}\n";
    	$sErrorText .= "ePaymentId: {$objResult->EPaymentId}\n";
    	$sErrorText .= "ePaymentTimestamp: {$objResult->EPaymentTimestamp}\n\n";
    	
    	return $sErrorText;
    }
}