<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Abstract extends Mage_Payment_Model_Method_Abstract
{
	const SOAP_METHOD_NOT_AVAILABLE = 'is not a valid method for this service';
	const SOAP_METHOD_NOT_AVAILABLE_HTTP = 'curl_exec error 22 The requested URL returned error: 500';
	
	/**
	 * Client zur SOAP - Kommunikation
	 * 
	 * @var SOAP_Client
	 */
	private $__objSOAPClientBfF = null;
	
	protected $_code = 'paymentbase';
	
	/**
	 * Cache für ePayment-Parameter
	 * 
	 * @var array
	 */
	protected $_ePaymentParams = null; 
	
	/**
	 * Übersetzt den übergebenen String
	 * 
	 * @return string
	 *  
	 */
	public function __() {
		$args = func_get_args();
		$expr = new Mage_Core_Model_Translate_Expr(array_shift($args), $this->getCode());
		array_unshift($args, $expr);
		return Mage::app()->getTranslator()->translate($args);
	}
	/**
	 * Retrieve model helper
	 *
	 * @return Egovs_Paymentbase_Helper_Data
	 */
	protected function _getHelper() {
		
		return Mage::helper($this->getCode());
	}
	
	/**
	 * Aktuelle Kundennummer im WebShop
	 * 
	 * @var int
	 */
	private $__customerId = null;

	/**
	 * Liefert die Magento Kundennummer
	 *
	 * Falls die Customer ID nicht gesetzt ist, wird die Bestellnummer verwendet (INCREMENT ID)
	 *
	 * @return integer Customer ID
	 */
	protected function _getCustomerId() {
		if (!$this->__customerId) {
			$customerId = null;
			if ($this->_getOrder()) {
				$customerId = $this->_getOrder()->getCustomerId();
			} elseif ($quote = $this->getInfoInstance()->getQuote()) {
				$customerId = $quote->getCustomerId();
			}
			
			
			if (!isset($customerId) || strlen(trim($customerId)) <= 0) {
				Mage::log($this->__(sprintf('%s::No customer ID available, using quote/order increment ID', $this->getCode())), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
				if ($this->_getOrder()) {
					$customerId = $this->_getOrder()->getIncrementId();
				} else {
					$quote = $this->getInfoInstance()->getQuote();
					if($quote)
					{
						$customerId = $quote->getIncrementId();
					}
				}
			}
				
			$this->__customerId = $customerId;
		}
		 
		return $this->__customerId;
	}
	/**
	 * Kundennummer an ePayment Plattform
	 * 
	 * @var string
	 */
	private $__eCustomerId = null;

	/**
	 * Liefert die Kundennummer für die ePayment Plattform
	 *
	 * Die Kundennummer kann maximal 100 Zeichen lang sein und wird abhängig von der Konfiguration (stabil oder zufällig) erzeugt.
	 * 
	 * <strong>Stabil:</strong>
	 * <p>
     * "WebShopDesMandanten-CustomerId"
     * </p>
     * <strong>Zufällig:</strong>
	 * <p>Hier ist sie 15 Zeichen lang und wird wie folgt erzeugt:
	 * <p>
	 * md5(BewirtschafterNr+WebShopDesMandanten+CustomerId+Zufallszahl+Zufallszahl+Zeit+SALT)
	 * </p>
	 * </p>
	 *
	 * @param bool $throwIfNotExists Soll eine Exception erzeugt werden falls die Kundennummer nicht existiert. (default = false)
	 *
	 * @return String ePayment Kundennummer
	 *
	 * @see Egovs_Paymentbase_Helper_Data::getECustomerId
	 */
	protected function _getECustomerId($throwIfNotExists = false) {
		if (!$this->__eCustomerId) {
			if (Mage::getStoreConfigFlag("payment/{$this->getCode()}/delete_customer_after_transaction")) {
				Mage::log($this->__(sprintf('%s::Random ePayBL customer ID', $this->getCode())), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				$this->__eCustomerId = Mage::helper('paymentbase')->getECustomerIdRandom($this->_getCustomerId(), $throwIfNotExists);
			} else {
				Mage::log($this->__(sprintf('%s::Non volatile ePayBL customer ID', $this->getCode())), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
				$this->__eCustomerId = Mage::helper('paymentbase')->getECustomerIdNonVolatile($this->_getCustomerId(), $throwIfNotExists);
			}
		}
		 
		return $this->__eCustomerId;
	}

	/**
	 * Get the current soap client or if no one exist create it.
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_PaymentServices Soap client
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_PaymentServices
	 * @see Egovs_Paymentbase_Helper_Data::getSoapClient
	 */
	protected function _getSoapClient() {
		if (!$this->__objSOAPClientBfF) {
			$this->__objSOAPClientBfF = Mage::helper('paymentbase')->getSoapClient();
		}

		return $this->__objSOAPClientBfF;
	}

	/**
	 * Mandantennummer an ePayment Plattform
	 * 
	 * @var string
	 */
	private $__mandantNr = null;
	/**
	 * Liefert die Mandanten-Nr
	 *
	 * Die Mandanten-Nr wird vom ePayment vergeben
	 *
	 * @return string
	 * 
	 * @see Egovs_Paymentbase_Helper_Data::getMandantNr
	 *
	 */
	protected function _getMandantNr() {
		if (!$this->__mandantNr) {
			$this->__mandantNr = Mage::helper('paymentbase')->getMandantNr();
		}

		return $this->__mandantNr;
	}
	/**
	 * Bewirtschafternummer an der ePayment Plattform
	 */
	private $__bewirtschfterNr = null;
	/**
	 * Liefert die Bewirtschafter Nummer für die ePayment Plattform
	 *
	 * @return string
	 * 
	 * @see Egovs_Paymentbase_Helper_Data::getBewirtschafterNr
	 */
	protected function _getBewirtschafterNr() {
		if (!$this->__bewirtschfterNr) {
			$this->__bewirtschfterNr = Mage::helper('paymentbase')->getBewirtschafterNr();
		}
		return $this->__bewirtschfterNr;
	}
	/**
	 * Name des WebShops des Mandanten
	 * 
	 * @var string
	 */
	private $__webshopDesMandanten = null;
	/**
	 * Liefert die 4-stellige Webshop-ID des Mandanten
	 * 
	 * @return string
	 * 
	 * @see  Egovs_Paymentbase_Helper_Data::getWebShopDesMandanten
	 *
	 */
	protected function _getWebShopDesMandanten() {
		if (!$this->__webshopDesMandanten) {
			$this->__webshopDesMandanten = Mage::helper('paymentbase')->getWebShopDesMandanten();
		}

		return $this->__webshopDesMandanten;
	}
	
	/**
	 * Aktuelle Order
	 * 
	 * @var Mage_Sales_Model_Order
	 */
	private $__order = null;

	/**
	 * Get the current order
	 *
	 * @return Mage_Sales_Model_Order
	 */
	protected function _getOrder() {
		if (!$this->__order) {
			$_order = $this->getInfoInstance()->getOrder();
			
			if (!$_order) {
				/** @var $_quote Mage_Sales_Model_Quote */
				$_quote = $this->getInfoInstance()->getQuote();
				$_reservedOrderId = $_quote->getReservedOrderId();
				$this->__order = Mage::getModel('sales/order')->loadByIncrementId($_reservedOrderId);
				if (!$this->__order->getId()) {
					$this->__order = null;
				}
			} else {
				$this->__order = $_order;
			}
		}
		return $this->__order;
	}
	/**
	 * Löscht den Kunden an der ePayment Plattform
	 *
	 * Das Löschen des Kunden wird im Fehlerfall nicht mit einer Exception beendet!
	 *  
	 * @return object|boolean Result object oder true falls Kunde nicht gelöscht werden soll.
	 *
	 * @see Egovs_Paymentbase_Helper_Data::loeschenKunde
	 */
	public function loeschenKunde() {
		//DebitPIN ist von der Kunden-Lösch-Transaktions-Regelung ausgenommen!
		if ($this->getCode() == "debitpin") {
			return Mage::helper('debitpin')->loeschenKunde($this->_getCustomerId(), 'debitpin');
		}
		
		if (Mage::getStoreConfigFlag("payment/{$this->getCode()}/delete_customer_after_transaction")) {
			return Mage::helper('paymentbase')->loeschenKunde($this->_getCustomerId(), $this->getCode());		
		}
		
		Mage::helper('paymentbase')->resetECustomerId();
		Mage::log($this->__(sprintf('%s::Omit customer deletion on ePayBL server', $this->getCode())), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		return true;
	}

	/**
	 * Validates the $objResult from the SOAP call
	 *
	 * It is possible to define a custom error handler with '_customErrorHandler' as function name.
	 *
	 * @param object $objResult        SOAP object result
	 * @param object $objBuchungsliste Accounting list
	 * @param string $soapFunction     Name of the called SOAP function
	 * @param bool	 $keepCustomer     Don't delete the customer (default=false)
	 * 
	 * @return TRUE | throw Exception
	 *
	 * @throws Exception
	 * @see Egovs_Debit_Model_Debit::_customErrorHandler
	 */
	public function validateSoapResult($objResult, $objBuchungsliste, $soapFunction = '', $keepCustomer = false) {
		// wenn Fehler dann Mail an Admin und zurück zur Zahlseite, Kunde löschen und Fehler anzeigen
		if (!$objResult
			|| is_null($objResult)
			|| $objResult instanceof SoapFault
			|| (isset($objResult) && isset($objResult->ergebnis) && $objResult->ergebnis->istOk != true)
		) {

			// Mail an Webmaster senden
			$sMailText = "Während der Kommunikation mit dem ePayment-Server trat folgender Fehler auf:\n\n";
			$sMailText .= sprintf("Shop Name: %s\n", Mage::getStoreConfig('general/imprint/shop_name'));
			$sMailText .= sprintf("Store Name: %s\n\n", Mage::getStoreConfig('general/store_information/name'));
			if ($this->_getOrder()->getId()) {
				$sMailText .= "Order ID: {$this->_getOrder()->getId()}\n";
			}
			$sMailText .= "Order #: {$this->_getOrder()->getIncrementId()}\n";
			$sMailText .= "Quote ID: {$this->_getOrder()->getQuoteId()}\n";
				
			/** @var $_adminHelper Mage_Adminhtml_Helper_Data */
            $_adminHelper = Mage::helper('adminhtml');

            $sMailText .= "ePayBL-Mandant: {$this->_getMandantNr()}\n";
            $sMailText .= "ePayBL-Bewirtschafter: {$this->_getBewirtschafterNr()}\n";
			$sMailText .= "ePayBL-Kundennummer: {$this->_getECustomerId()}\n";
			if (($customer = $this->_getOrder()->getCustomer()) && $customer->getId() > 0) {
				$backendUrl = $_adminHelper->getUrl('adminhtml/customer/edit', array('id' => $this->_getCustomerId()));
				$sMailText .= "Kundennummer: {$this->_getCustomerId()} $backendUrl\n";
				$sMailText .= "Name: {$customer->getFirstname()} {$customer->getLastname()}\n\n";
			} else {
				$customer = $this->_getCustomerId();
				if ($customer > 0) {
					$customer = Mage::getModel('customer/customer')->load($customer);
					if ($customer instanceof Mage_Customer_Model_Customer && !$customer->isEmpty()) {
						$sMailText .= "Name: {$customer->getFirstname()} {$customer->getLastname()}\n\n";
					} else {
						$customer = false;
					}
				} else {
					$customer = false;
				}
				
				if (!$customer) {
					$sMailText .= "Name: Unbekannt\n\n";
				}
			}

            if ($objResult instanceof SoapFault) {
                $sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
            } elseif (!$objResult || is_null($objResult) || !isset($objResult->ergebnis)) {
                $sMailText .= "Error: No result returned\n";
            } else {
                $sMailText .= Mage::helper('paymentbase')->getErrorStringFromObjResult($objResult->ergebnis);
            }

            $sMailText .= "Order Items:\n";
            foreach ($this->_getOrder()->getAllItems() as $item) {
                /* @var $item Mage_Sales_Model_Order_Item */
                $sMailText .= "Order item ID: {$item->getId()}\n";
                $sMailText .= "Base Discount: {$item->getBaseDiscountAmount()}\n";
                $sMailText .= "Hidden Tax Amount: {$item->getBaseHiddenTaxAmount()}\n";
                $sMailText .= "Row total: {$item->getBaseRowTotal()}\n";
                $sMailText .= "MwSt: {$item->getBaseTaxAmount()}\n\n";
            }

			$sMailText .= "Liste der Produkte:\n";
			foreach ($this->_getOrder()->getAllVisibleItems() as $item) {
				/** @var $item Mage_Sales_Model_Order_Item */
				$backendUrl = $_adminHelper->getUrl('adminhtml/catalog_product/edit', array('id' => $item->getProductId()));
				$sMailText .= "SKU: {$item->getSku()} ID: {$item->getProductId()} $backendUrl\n";
			}
			$sMailText .= "\n";
			$sMailText .= "Buchungsliste ePayment: " . var_export($objBuchungsliste, true) . "\n";

			Mage::helper("paymentbase")->sendMailToAdmin("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n\n".$sMailText);
				
			Mage::log("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				
			if (!$keepCustomer) {
				// Kunde nun auf jeden Fall loeschen
				$this->loeschenKunde();
			}

			// Fehlermeldung
			if (method_exists($this, '_customErrorHandler')) {
				call_user_func(array($this,'_customErrorHandler'), $objResult);
			} else {
				if ($objResult && isset($objResult->ergebnis) && Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_'.$objResult->ergebnis->getCode()) != 'TEXT_PROCESS_ERROR_'.$objResult->ergebnis->getCode()) {
					$this->parseAndThrow('ERROR:'.$objResult->ergebnis->getCode());
				} elseif ($objResult instanceof SoapFault) {
					$this->parseAndThrow('ERROR_-999989');
				} else {
					$this->parseAndThrow('ERROR_STANDARD');
				}
			}
		} else {
			Mage::log("{$this->getCode()}::SOAP Result OK", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			
			if (isset($objResult->buchungsListe) && isset($objResult->buchungsListe->kassenzeichen)) {
				$bkz = $objResult->buchungsListe->kassenzeichen;
				Mage::log(
						sprintf(
								"%s::SOAP Result OK: Kassenzeichen: %s, Order: %s",
								$this->getCode(),
								$bkz,
								$this->getInfoInstance()->getOrder()->getIncrementId()
						),
						Zend_Log::NOTICE,
						Egovs_Helper::LOG_FILE
				);
			}
		}
		 
		return true;
	}

	/**
	 * Parse the given "ERROR:1234" or "1234" or "ERROR_1234" ERROR code and throws a Exception
	 *
	 * This function throws always an Exception! There would be no admin mail created or send.
	 *
	 * @param string $error Error
	 * 
	 * @return void
	 * 
	 * @throws Exception
	 */
	public function parseAndThrow($error) {
		Egovs_Paymentbase_Helper_Data::parseAndThrow($error, $this->getCode());
	}

	/**
	 * Authorize --TEMPLATE-METHOD--
	 *
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @return Mage_Payment_Model_Method_Abstract
	 * 
	 * @see Egovs_Paymentbase_Model_Paymentbase::_authorize
	 */
	public final function authorize(Varien_Object $payment, $amount)
	{
		parent::authorize($payment, $amount);
		 
		// Prüfung von Parametern
		if (!($this->_getMandantNr())
			|| !($this->_getBewirtschafterNr())
			|| !($this->_getWebShopDesMandanten())
			|| strlen($this->_getMandantNr()) <= 0
			|| strlen($this->_getBewirtschafterNr()) <= 0
			|| strlen($this->_getWebShopDesMandanten()) <= 0
		) {
			// Mail an Webmaster senden
			$sMailText = "In der Parameterbestimmung für den ePayment-Server liegt ein Fehler vor!\n\n";
			$sMailText .= "Bestimmung der Kundennummer(n)\n";
			$sMailText .= "MandantNr: {$this->_getMandantNr()}\n";
			$sMailText .= "BewirtschafterNr: {$this->_getBewirtschafterNr()}\n";
			$sMailText .= "WebShopDesMandanten: {$this->_getWebShopDesMandanten()}\n";
			$sMailText .= "Customer ID: {$this->_getCustomerId()}\n";
				
			Mage::log("{$this->getCode()}::PARAMETER FEHLT MandantNr: {$this->_getMandantNr()}, BewirtschafterNr: {$this->_getBewirtschafterNr()}, WebShopDesMandanten: {$this->_getWebShopDesMandanten()}", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			// Umleitung zu Zahlungsseite
			Mage::throwException("{$this->getCode()}::".Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD99989', Mage::helper("paymentbase")->getAdminMail()));
		}

		if ($this->hasKassenzeichen()) {
			Mage::log("paymentbase::The Kassenzeichen exists already: {$this->getKassenzeichen()}", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
			return $this;
		}
		try {
		        $this->_authorize($payment, $amount);
		} catch (Exception $e) {
			//Möglichen Kunden löschen
			$this->loeschenKunde();
			Mage::logException($e);
			throw $e;
		}
		
		if ($payment->hasData('kassenzeichen')) {
			/*
			 * Es geht hier nur darum das Kassenzeichen bis zum ersten speichern der Order zu sichern.
			 * Bei Gatewayzahlungen (Saferpay) ist die Zahlung zwar erst nach der der Rückkehr vom Gateway gültig, das
			 * Kassenzeichen wurde aber schon vorher in der Order gespeichert. 
			 */
			/* @var $transaction Egovs_Paymentbase_Model_Transaction */
			$transaction = Mage::getModel('paymentbase/transaction');
			$transaction->setId($payment->getKassenzeichen());
			$transaction->setQuoteId($payment->getOrder()->getQuoteId());
			$transaction->setPaymentMethod($this->getCode());
			try {
				$transaction->save();
			} catch (Exception $e) {
				Mage::log(
						sprintf(
								"%s::Can't save transaction with Kassenzeichen: %s for Order: %s. See exception log for further information!",
								$this->getCode(),
								$payment->getKassenzeichen(),
								$payment->getOrder()->getIncrementId()								
						),
						Zend_Log::ERR,
						Egovs_Helper::EXCEPTION_LOG_FILE
				);
				Mage::logException($e);
			}
		}
		
		return $this;
	}

	/**
	 * Modulspezifische Implementation der authorize Methode.
	 *
	 * Hier wird die eigentliche Buchung am ePayment durchgeführt.<br>
	 * <p>
	 * In der Regel sollte der Ablauf wie folgt sein:
	 * </p>
	 * <ol>
	 * 	<li>Der Kunde wird an der ePayment-Plattform angelegt</li>
	 *  <li>Die Buchungsliste wird erstellt</li>
	 *  <li>Das Ergebnis des WebService-Aufrufs wird validiert</li>
	 *  <li>Der Kunde wird wieder vom ePayment-System gelöscht</li>
	 *  <li>Das Kassenzeichen wird in der PaymentInfo gespeichert</li>
	 * </ol>
	 *
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag 
	 * 
	 * @return Mage_Payment_Model_Method_Abstract
	 *
	 * @see	Egovs_Paymentbase_Model_Abstract::authorize
	 * @see Egovs_Paymentbase_Model_Abstract::createAccountingListParts
	 * @see Egovs_Paymentbase_Model_Abstract::validateSoapResult
	 * @see Egovs_Paymentbase_Model_Abstract::loeschenKunde
	 */
	protected abstract function _authorize(Varien_Object $payment, $amount);

	/**
	 * Liefert die Kundeninformationen vom ePayBL Server
	 *
	 * @param string|Egovs_Paymentbase_Model_Webservice_Types_Kunde $customer Kunden ID oder Kundenobjekt
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis|null
	 * 
	 * @see Egovs_Paymentbase_Helper_Data::getCustomerFromEPayment
	 */
	public function getCustomerFromEPayment($customer) {
		return Mage::helper('paymentbase')->getCustomerFromEPayment($customer);
	}

	/**
	 * Erstellt einen Kunden am ePayment-Server für eine Transaktion.
	 *
	 * Der Kunde wird anonym erstellt oder mit den übergebenen Angaben.
	 * Falls der Kunde schon existiert, wird dieser verwendet.
	 * 
	 * @param Varien_Object $data An object with the customers data
	 * 
	 * @return boolean TRUE otherwise Exception is thrown
	 * 
	 * @throws Exception
	 *
	 * @see Egovs_Paymentbase_Helper_Data::createCustomerForPayment
	 * @see Egovs_DebitPIN_Block_Payment_Form_Debitpin::_ePaymentActivateDebitEntry
	 */
	public function createCustomerForPayment($data = null) {
		if (empty($data) && Mage::getStoreConfig(sprintf('payment/%s/include_personal_data', $this->getCode()))) {
			Mage::log($this->getCode().'::Include personal data for customers', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			if ($this->_getOrder()) {
				/*
				 * Der Kunde soll mit einem Kompletten Datensatz zur Mahnung angelegt werden
				 */
				$data = new Varien_Object();
				$errors = array();
				$address = $this->_getOrder()->getBillingAddress();

				if (!($address instanceof Mage_Customer_Model_Address_Abstract)) {
					Mage::throwException($this->__('No billing address available'));
				}
				
				try {
					$data = Mage::helper($this->getCode())->extractCustomerInformation($this->_getOrder());
				} catch (Exception $e) {
					$errors[] = $e->getMessage();
				}
				// Kunde mit richtigen Adressdaten aus DB anlegen
				$objRechnungsAdresse = new Varien_Object();

				//Straße
				if (strlen($address->getStreetFull()) > 0) {
					$objRechnungsAdresse->setStrasse($address->getStreetFull());
				} else {
					$errors[] = $this->__('Street is a required field');
				}
				//Land
				if (strlen($address->getCountryId()) > 0) {
					$objRechnungsAdresse->setLand($address->getCountryId());
				} else {
					$errors[] = $this->__('Country is a required field');
				}
				//PLZ
				$plz = $address->getPostcode();
				$plz = trim($plz);
				if (strlen($plz) > 0) {
					$isPlzOk = true;
					if ($address->getCountryId() == 'DE' || $address->getCountryId() == 'de') {
						/*
						 * ePayBL Bedingung:
						* -0202: Die Postleitzahl ist nicht gültig: sie muss gefüllt sein und darf maximal 10 Zeichen lang
						* sein. Deutsche Postleitzahlen müssen fünfstellig und nummerisch sowie größer als 00000 sein.
						*/
						if (intval($plz) == 0) {
							$errors[] = $this->__("Postcode can't be 0");
							$isPlzOk = false;
						}
						if (strlen($plz) != 5 || !is_numeric($plz)) {
							$errors[] = $this->__("German postal codes must be five digits.");
							$isPlzOk = false;
						}
					}
					if ($isPlzOk) {
						$objRechnungsAdresse->setData('PLZ', $plz);
					}					
				} else {
					$errors[] = $this->__('Postcode is a required field');
				}
				//Stadt
				if (strlen($address->getCity()) > 0) {
					$objRechnungsAdresse->setOrt($address->getCity());
				} else {
					$errors[] = $this->__('City is a required field');
				}

				if (!empty($errors)) {
					$errors = implode('<br/>', $errors);
					Mage::throwException($errors);
				}
				
				$data->setInvoiceAddress($objRechnungsAdresse);
			} else {
				Mage::log($this->getCode().'::No Order instance available!', Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			}
		}
		return Mage::helper('paymentbase')->createCustomerForPayment($this->_getECustomerId(), $data);
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
		return Mage::helper('paymentbase')->getECustomer();
	}

	/**
	 * Ermittelt die Steuerschlüssel aus den angewandten Steuerregeln
	 * 
	 * @return array Array mit Steuerschlüsseln pro Quote Item Id
	 */
	protected function _getTaxKeysForAppliedTaxes() {
		$_order = $this->_getOrder();
		$_quote = $_order->getQuote();
		if (!$_quote || $_quote->isEmpty()) {
			$_quote = Mage::getModel('sales/quote')->load($_order->getQuoteId());
		}
		if (!$_quote || $_quote->isEmpty()) {
			return array();
		}
		$getTaxesForItems   = $_quote->getTaxesForItems();
		$taxes = $this->_getOrder()->getAppliedTaxes();
		
		$ratesIdQuoteItemId = array();
		if (!is_array($getTaxesForItems)) {
			$getTaxesForItems = array();
		}
		foreach ($getTaxesForItems as $quoteItemId => $taxesArray) {
			foreach ($taxesArray as $rates) {
				if (count($rates['rates']) == 1) {
					$ratesIdQuoteItemId[$rates['id']][] = array(
							'id'        => $quoteItemId,
							'percent'   => $rates['percent'],
							'code'      => $rates['rates'][0]['code']
					);
				} else {
					foreach ($rates['rates'] as $rate) {
						$ratesIdQuoteItemId[$rates['id']][] = array(
								'id'        => $quoteItemId,
								'percent'   => $rate['percent'],
								'code'      => $rate['code']
						);
					}
				}
			}
		}
		
		$taxKeysByQuoteItemId = array();
		foreach ($taxes as $id => $row) {
			foreach ($row['rates'] as $tax) {
				if (isset($ratesIdQuoteItemId[$id])) {
					foreach ($ratesIdQuoteItemId[$id] as $quoteItemId) {
						if ($quoteItemId['code'] == $tax['code']) {
							$item = $this->_getOrder()->getItemByQuoteItemId($quoteItemId['id']);
							if ($item) {
								//$item ist hier noch nicht gespeichert und hat damit noch keine eigene ID!
								if (!isset($taxKeysByQuoteItemId[$quoteItemId['id']])) {
									$taxKeysByQuoteItemId[$quoteItemId['id']] = array();
								}
								if (isset($tax['tax_key'])) {
									$taxKeysByQuoteItemId[$quoteItemId['id']][] = trim($tax['tax_key']);
								}
							}
						}
					}
				}
			}
		}
		
		return $taxKeysByQuoteItemId;
	}
	
	/**
	 * Erstellt die Teileinträge der Buchungsliste
	 *
	 * @return array Array of {@link Buchung}
	 */
	public function createAccountingListParts() {
		$items = $this->_getOrder()->getAllItems();
		
		$taxKeysByQuoteItemId = $this->_getTaxKeysForAppliedTaxes();
		
		// Buchungsliste erstellen
		$arrBuchungsliste = array ();
		/* @var $item Mage_Sales_Model_Order_Item */
		foreach ($items as $item) {
			
			//20140205::Frank Rochlitzer
			//Sonst tauchen z. B. Bundle-Produkte selbst und Ihre Kinder in der Buchung auf!
			//Das führt dann zu Gesamtbetrag != Summe(Einzelbeträge) [Code: -0506, Titel: Gesamtbetrag falsch]
			if ($item instanceof Mage_Sales_Model_Order_Item && $item->isDummy()) {
				continue;
			} elseif ($item instanceof Mage_Sales_Model_Quote_Item_Abstract) {
				/* 20140226::Frank Rochlitzer
				 * isDummy steht bei Quote-Items nicht zur Verfügung wird aber für die Warenkorbbegrenzung benötigt.
				 * @see Mage_Sales_Model_Order_Item::isDummy()
				 */
				if ($item->getHasChildren() && $item->isChildrenCalculated()) {
					continue;
				}
				
				if ($item->getParentItem() && !$item->isChildrenCalculated()) {
					continue;
				}
			}
			
			$product = $item->getProduct();
			$haushaltsstelle = Mage::helper('paymentbase')->getHaushaltsparameter($product->getData('haushaltsstelle'));
			$objektnummer = Mage::helper('paymentbase')->getHaushaltsparameter($product->getData('objektnummer'));
			$objektnummerMwst = Mage::helper('paymentbase')->getHaushaltsparameter($product->getData('objektnummer_mwst'));
			$href = Mage::helper('paymentbase')->getHaushaltsparameter($product->getData('href'));
			$hrefMwst = Mage::helper('paymentbase')->getHaushaltsparameter($product->getData('href_mwst'));
			$buchungstext = Mage::helper('paymentbase')->getHaushaltsparameter($product->getData('buchungstext'));
			$buchungstextMwst = Mage::helper('paymentbase')->getHaushaltsparameter($product->getData('buchungstext_mwst'));
			
			
			$taxKeys = array();
			foreach ($taxKeysByQuoteItemId as $id => $tax) {
				if ($id != $item->getQuoteItemId() || empty($tax)) {
					continue;
				}
				$taxKeys = array_merge($taxKeys, $tax);
			}
			unset($taxKeysByQuoteItemId[$item->getQuoteItemId()]);
			if(count($taxKeys)> 0)
			{
				if (!empty($href)) {
					$href .= ';';
				}
				$href .= sprintf('STS=%s', implode(';', $taxKeys));
			}
			
			/*
			 * HIDDEN TAX AMOUNT ist der Steuerbetrag des Rabatts
			 * HIDDEN TAX AMOUNT existiert nur unter folgenden Bedingungen:
			 * 	- Katalogpreise enthalten Steuern
			 *  - Kundensteuer Nach Rabatt
			 *  - Rabattbetrag!!
			 *  oder
			 *  - Katalogpreise enthalten Steuern
			 *  - Kundensteuer Nach Rabatt
			 *  - Rabatt auf Preise inklusive Steuern anwenden
			 *  - prozentualer Rabatt!!
			 */
			$hiddenTaxAmount = $item->getHiddenTaxAmount() > 0
				? $item->getHiddenTaxAmount() // entspricht Mage::helper('tax')->getCalculator()->calcTaxAmount($item->getDiscountAmount(), $item->getTaxPercent(), true)
				: 0.0
			;
				
			/////////////////////////////////////////////////////////////
			// Netto verbuchen wenn vorhanden
			/////////////////////////////////////////////////////////////
			$baseRowTotalWithDiscount = round(($item->getBaseRowTotal() - $item->getBaseDiscountAmount()) + $hiddenTaxAmount, 2);
			if ($baseRowTotalWithDiscount > 0) {
				$arrBuchungsliste[] = new Egovs_Paymentbase_Model_Webservice_Types_Buchung(
					// Haushaltsstelle
					(string)$haushaltsstelle,
					// Objektnummer
					(string)$objektnummer,
					// Buchungstext
					(string)$buchungstext,
					// Betrag
					(float) $baseRowTotalWithDiscount,
					// belegNr, NULL oder ''
					null,
					// HREF, z. B. $arrProduktInfo['products_name'] oder $arrProduktInfo['products_unterstelle']
					$href
				);
			}

			/////////////////////////////////////////////////////////////
			// MWST verbuchen wenn vorhanden
			/////////////////////////////////////////////////////////////
			if ($item->getBaseTaxAmount() > 0.0) {
				$arrBuchungsliste[] = new Egovs_Paymentbase_Model_Webservice_Types_Buchung(
					// Haushaltsstelle
					(string)$haushaltsstelle,
					// Objektnummer
					(string)$objektnummerMwst,
					// Buchungstext
					(string)$buchungstextMwst,
					// Betrag
					(float) $item->getBaseTaxAmount(),
					// belegNr
					null,
					// HREF
					$hrefMwst
				);
			}
		}

		/////////////////////////////////////////////////////////////
		// Versandkosten verbuchen wenn vorhanden
		/////////////////////////////////////////////////////////////

		if ($this->_getOrder()->getBaseShippingInclTax() > 0) {

			$storeId = $this->getStore();
			$haushaltsstelle =  Mage::getStoreConfig('payment_services/paymentbase/haushaltsstelle', $storeId);
			$objektnummer =  Mage::getStoreConfig('payment_services/paymentbase/objektnummer', $storeId);
			$buchungstext =  Mage::getStoreConfig('payment_services/paymentbase/buchungstext', $storeId);
			$href =  Mage::getStoreConfig('payment_services/paymentbase/href', $storeId);
				
			$arrBuchungsliste[] = new Egovs_Paymentbase_Model_Webservice_Types_Buchung(
				// Haushaltsstelle
				(string)$haushaltsstelle,
				// Objektnummer
				(string)$objektnummer,
				// Buchungstext
				(string)$buchungstext,
				// Betrag
				(float) ($this->_getOrder()->getBaseShippingInclTax()),
				// BelegNr
				null,
				// HREF
				$href
			);
		}

		return $arrBuchungsliste;
	}
	
	/**
	 * Erstellt eine Buchungsliste
	 * 
	 * @param Mage_Payment_Model_Info $payment 			Bezahlinstanz
	 * @param float 				  $amount 			Betrag
	 * @param string 				  $bkz 				Buchungskennzeichen
	 * @param string 				  $maturity 		Zahlunsziel
	 * @param array 				  $arrBuchungsliste Buchungsliste
	 * @param float 				  $grandTotal 		Gesamtbetrag
	 * @param string 				  $currency 		Währung
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe
	 */
	public function createAccountingList($payment, $amount, $bkz = null, $maturity = null, $arrBuchungsliste = null, $grandTotal = null, $currency = null) {
		// Objekt für Buchungsliste erstellen
		if (is_null($arrBuchungsliste)) {
			$arrBuchungsliste = $this->createAccountingListParts();
		}
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			$arrBuchungsliste = new Egovs_Paymentbase_Model_Webservice_Types_BuchungList($arrBuchungsliste);
		}
		$objBuchungsliste = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe(
				// Gesamtsumme
				is_null($grandTotal) ? (float) $this->_getOrder()->getBaseGrandTotal() : $grandTotal,
				// derzeit wird nur EUR vom ePayment-Server unterstützt
				is_null($currency) ? 'EUR' : $currency,
				// Fälligkeit
				is_null($maturity) ? strftime('%Y-%m-%dT%H:%M:%SZ') : $maturity,
				// Buchungsliste
				$arrBuchungsliste,
				// Bewirtschafter
				$this->_getBewirtschafterNr(),
				// Kennzeichen Mahnverfahren aus Konfiguration
				$this->getKennzeichenMahnverfahren($payment, $amount),
				// Kassenzeichen wird normalerweise vom ePayment-Server generiert
				$bkz
		);
		
		return $objBuchungsliste;
	}

	/**
	 * Liefert ein assoziatives Array mit Buchungslistenparametern
	 * 
	 * @param Mage_Sales_Model_Order_Payment $payment Payment
	 * @param float                          $amount  Betrag
	 * 
	 * @return array
	 */
	public function getBuchungsListeParameter($payment, $amount) {
		if (!$this->_ePaymentParams) {
			$params = array();
			if (!$payment) {
				Mage::throwException(Mage::helper('paymentbase')->__('No payment set, please contact the developer!'));
			}
			if ($this->_getOrder()) {
				$params = Mage::getModel('paymentbase/localparams')->getParamList($this->_getOrder()->getCustomerGroupId(), $payment->getMethod(), $amount);
				$params = array_merge($params, $this->_getOrderDate());
				$params = array_merge($params, $this->_getOrderIncrementId());
			}
			
			Mage::log(
				sprintf(
					"Order ID: %s ePayment parameters:\n%s",
					$this->_getOrder()->getIncrementId(),
					var_export($params, true)
				),
				Zend_Log::NOTICE,
				Egovs_Helper::LOG_FILE
			);
			
			$this->_ePaymentParams = $params;
		}
		
		return $this->_ePaymentParams;
	}
	
	/**
	 * Liefert das Kennzeichen für Mahnverfahren
	 * 
	 * Falls keine gültige Konfiguration über die Parameter vorliegt,
	 * wird ein Fallback aus den alten Einstellungen versucht.
	 * 
	 * @param Mage_Sales_Model_Order_Payment $payment Payment
	 * @param float 						 $amount  Betrag
	 * 
	 * @return string
	 */
	public function getKennzeichenMahnverfahren($payment, $amount) {
		$params = $this->getBuchungsListeParameter($payment, $amount);
		
		$localParams = Mage::getModel('paymentbase/localparams');
		/* @var $localParams Egovs_Paymentbase_Model_Localparams */
		if (array_key_exists($code = $localParams->getKennzeichenMahnverfahrenCode(), $params)) {
			return $params[$code];
		}
				
		//deprecated
		$dep = Mage::getStoreConfig('payment_services/paymentbase/kennz_mahn');
		Mage::log(sprintf('%s::Benutze deprecated Kennzeichen-Mahnverfahren:', $this->getCode(), $dep), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
		return $dep;
	}
	
	/**
	 * Liefert ein Key - Value Paar für das Bestelldatum
	 * 
	 * <p>
	 * Struktur:
	 * array( 'key_name' => 'd.M.Y')<br/>
	 * </p>
	 * 
	 * Der DEFAULT key_name ist bestelldat. Der Name kann in der config.xml unter global/payment/attributes/mapping/created_at frei konfiguriert werden.
	 * 
	 * @return array Key-Value Paar
	 */
	protected function _getOrderDate() {
		if ($this->_getOrder()->hasCreatedAt()) {
			$date = $this->_getOrder()->getCreatedAtStoreDate();
		} else {
			$date = null;
		}
		if (is_null($date)) {
			$date = Mage::app()->getLocale()->date(Mage::getSingleton('core/date')->gmtTimestamp(), null, null);
		} elseif (!$date instanceof Zend_Date) {
			$date = Mage::app()->getLocale()->date(!empty($date) ? strtotime($date) : Mage::getSingleton('core/date')->gmtTimestamp(), null, null, true);
		}		
// 		$format = Mage::app()->getLocale()->getDateTimeFormat($format);				
// 		$date = $date->toString($format);
		/*
		 * 22.05.2012::R. Stefaniak
		 * Datum und Zeit werden in folgender Weise vom Webshop übergeben werden:
		 * TT.MM.JJJJ hh:mm:ss
		 * Als Trennzeichen wird das Leerzeichen verwendet. Die Zeitangabe entspricht immer MEZ bzw. MESZ. Magento stellt das intern sicher. 
		 * 
		 * 24.05.2012::F. Rochlitzer
		 * Wie telefonisch mit Herrn Stefaniak besprochen, wird das Bestelldatum nun noch nur als Datum übergeben:
		 * TT.MM.JJJJ
		 * Ursache:
		 * Das Bestelldatum wird erst nach dem Speichern der Bestellung (Order) von Magento erzeugt. Zum Zeitpunkt der Zahlung liegt die Bestellung jedoch nur als Objektinstanz vor.

		 */
		/* @var $date Zend_Date */
		$date = $date->toString('d.M.Y');
		
		$node = Mage::getConfig()->getNode('global/payment/attributes/mapping/created_at');
		if (empty($node)) {
			$node = 'bestelldat';
		}
		return array(((string)$node) => $date);
	}
	
	/**
	 * Liefert ein Key - Value Paar für die Bestellnummer
	 *
	 * <p>
	 * Struktur:
	 * array( 'key_name' => string)<br/>
	 * </p>
	 *
	 * Der DEFAULT key_name ist bestellnr. Der Name kann in der config.xml unter global/payment/attributes/mapping/increment_id frei konfiguriert werden.
	 *
	 * @return array Key-Value Paar
	 */
	protected function _getOrderIncrementId() {
		$node = Mage::getConfig()->getNode('global/payment/attributes/mapping/increment_id');
		if (empty($node)) {
			$node = 'bestellnr';
		}
		return array(((string)$node) => (string)$this->_getOrder()->getIncrementId());
	}
	
	/**
	 * Prüft ob schon ein Kassenzeichen vorhanden ist.
	 * 
	 * @param Varien_Object $payment Payment
	 * 
	 * @return boolean
	 */
	public function hasKassenzeichen(Varien_Object $payment = null) {
		if (is_null($payment) || !$payment) {
			$payment = $this->_getOrder()->getPayment();
				
			if (is_null($payment) || !$payment) {
				return false;
			}
		}
			
		return $payment->hasData('kassenzeichen');
	}

	/**
	 * Gibt den Titel aus den Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getCODTitle() {
		return $this->getConfigData('title');
	}

	/**
	 * Gibt einen einstellbaren Text aus den Admineinstellungen zurück
	 *
	 * @return string
	 */
	public function getCustomText() {
		return $this->getConfigData('customtext');
	}
}