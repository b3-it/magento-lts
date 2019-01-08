<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im SEPA-Debit-Verfahren (Lastschrift).
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_SepaDebit extends Egovs_Paymentbase_Model_Debit
{
	/**
	 * Debugmodus
	 * 
	 * @var bool
	 */
	protected $_isDebug = null;
	/**
	 * Gläubiger ID
	 * 
	 * @var string
	 */
	protected $_creditorId = null;
	/**
	 * Interne/Externe Mandatsverwaltung
	 * 
	 * @var bool
	 */
	protected $_isInternalManagement = null;
	/**
	 * Mandat Objekt
	 * 
	 * @var Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	private $__mandate = null;
	
	/**
	 * Magento Customer
	 * 
	 * @var Mage_Customer_Model_Customer
	 */
	protected $_customer = null;
	/**
	 * BIC und IBAN an ePayBL validieren
	 * 
	 * @var bool
	 */
	protected $_validateBicIbanWithEpaybl = null;
	
	/**
	 * Flag ob der Aufruf der authorize Methode erlaubt ist
	 *
	 * Authorize wird in der Regel bei der Bestellerstellung aufgerufen.
	 *
	 * @var boolean $_canAuthorize
	 */
	protected $_canAuthorize = true;
	/**
	 * Flag ob der Aufruf der capture Methode erlaubt ist
	 *
	 * Capture wird in der Regel bei der Rechnungserstellung aufgerufen.
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canCapture = true;
	/**
	 * Flag ob die Erstellung von Teilrechnungen erlaubt ist
	 *
	 * @var boolean $_canCapturePartial
	 */
	protected $_canCapturePartial = false;
	/**
	 * Gibt an ob auch eine externe Mandatsverwaltung untersützt wird.
	 * 
	 * @var bool
	 */
	protected $_canExternalMandateManagement = false;
	/**
	 * Gibt an ob die interne ePayBL Mandatsverwaltung untersützt wird.
	 * 
	 * @var bool
	 */
	protected $_canInternalMandateManagement = true;
	
	/**
	 * Liefert die Einstellung ob IBAN Only erlaubt ist.
	 *
	 * @return boolean
	 */
	public function getIbanOnly() {
		return Mage::getStoreConfigFlag(sprintf('payment/%s/iban_only', $this->getCode()));
	}
	/**
	 * Prüft ob die Bezahlform verfügbar ist.
	 *
	 * Folgende Bedingungen werden geprüft:
	 * <ul>
	 *  <li>Der Gesamtwarenkorbbetrag muss größer 0 sein</li>
	 * </ul>
	 *
	 * Weitere Bedingungen aus der Vererbung werden ebenfalls geprüft.
	 *
	 * @param Mage_Sales_Model_Quote $quote Warenkrob
	 *
	 * @return boolean
	 */
	public function isAvailable($quote=null)
	{
		if (parent::isAvailable($quote)) {
			//Der Paymentfilter übergibt eine leere Quote
			if (!$quote) {
				return true;
			}
			
			if ($quote->getGrandTotal() <= 0.0000001) {
				return false;
			}
			
			$mandate = null;
			
			//Bei automatischen Bestellungen prüfen ob Mandate aktuell
			if ($quote->getIsBatchOrder()) {
				
					try {
						$nr = $quote->getCustomer()->getSepaMandateId();
						$mandate = $this->getMandate($nr);
					} catch(Exception $ex) {
						//Mage::logException($ex);
					}
					
					if (($mandate) && ($mandate->isActive())) {
						return true;
					}
				
				return false;
			}
			
			if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
				return false;
			}
			
			
			return true;
		}
		return false;
	}
	
	/**
	 * Muss diese Zahlart noch initialisiert werden
	 * 
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 * @see Mage_Payment_Model_Method_Abstract::isInitializeNeeded()
	 */
	public function isInitializeNeeded() {
		/*
		 * Prüfen ob Mandat aktiv und valide ist.
		 * Falls ja, dann keine Initialisierung nötig sonst initialisieren
		 */
		return false;
	}
	
	/**
	 * Preprocessing für BIC-Eingaben
	 * 
	 * Die BIC wird optional mit X für die letzten 3 Stellen befüllt und in Großbuchstbaben gewandelt.
	 * 
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 */
	protected function _preprocessBic() {
		$payment = $this->getInfoInstance();
		$bic = $this->getBic();
		
		$bic = strtoupper($bic);
		if (strlen($bic) >=8 && strlen($bic) < 11) {
			$bic .= "XXX";
			$bic = substr($bic, 0, 11);
		}
		
		if ($bic != $this->getBic()) {
			$payment->setCcType($bic);
		}
		
		return $this;
	}
	
	/**
	 * Daten validierieren
	 * 
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 * @see Mage_Payment_Model_Method_Abstract::validate()
	 */
	public function validate() {
		parent::validate();
		
		//TODO : Prüfung muss im Backend Konfigurierbar sein!
		//TODO : Beim Anlegen von Mandaten müssen alle notwendigen Infos eingegeben werden!
// 		if ($this->getIsDebug()) {
// 			return $this;
// 		}
		$payment = $this->getInfoInstance();
		if (($this->getIbanOnly() || $payment->getData('cc_type')) && $payment->getData('cc_number')) {
			$this->_validateBankdata();
			
			$change = Mage::helper('paymentbase')->getAdditionalCustomerMandateData($this->getCustomer(),'change_mandate');
			$mandateref = $this->getMandateReferenceFromCustomer();
			if (isset($change) && ($change != $mandateref) ) {
				if (!$this->_canChange($change)) {
						Mage::throwException("You can not change your Mandate! Please contact store owner!");
				}
				$this->_changeMandate($change, $payment);
				Mage::helper('paymentbase')->unsAdditionalCustomerMandateData($this->getCustomer(),"change_mandate");
				if ($payment->hasAdditionalInformation('change_mandate')) {
					$payment->unsAdditionalInformation('change_mandate');
				}
			}
				
			
			$mandate = $this->getMandate();
			if (!$this->getIsInternalManagement()) {
				$this->_validateExternal();
			}
			$payment->setCcNumberEnc($payment->encrypt($payment->getCcNumber()));
		}
		
		if ($this->getMandateReferenceFromCustomer()) {
			//Notwendig um Payment zu befüllen!
			$this->getMandate();
		}
		
		
		if ($payment->getAdditionalInformation('change_mandate')) {
			$mandateref = $this->getMandateReferenceFromCustomer();
			if(!$this->_canChange($mandateref))
			{
				Mage::throwException("You can not change your Mandate! Please contact store owner!");
			}
			Mage::helper('paymentbase')->changeAdditionalCustomerMandateData($this->getCustomer(),array("change_mandate"=>$mandateref));
			$this->removeCurrentMandate();
			
			if ($payment->hasAdditionalInformation('change_mandate')) {
				$payment->unsAdditionalInformation('change_mandate');
				$payment->save();
			}	
			throw new Egovs_Paymentbase_Exception_Validation($this->__('Customer requested to create a new mandate'));
		} else {
			$ref = Mage::helper('paymentbase')->getAdditionalCustomerMandateData($this->getCustomer(),"change_mandate");
			if ($ref) {
				$this->getCustomer()->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $ref);
				$resource = $this->getCustomer()->getResource();
				$resource->saveAttribute($this->getCustomer(), Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
				Mage::helper('paymentbase')->unsAdditionalCustomerMandateData($this->getCustomer(),"change_mandate");
				$this->_getSession()->addNotice(Mage::helper('paymentbase')->__("Input is missing. Your old Mandate has been reactivated!"));
			}
			 
		}
		
		return $this;
	}
	
	protected function _validateBankdata() {
		$sBankCheck = 0;
		if ($iban = $this->getIban()) {
			$iban = strtoupper($iban);
			$this->getInfoInstance()->setCcNumber($iban);
		}
		if (!$this->getIbanOnly()) {
			$this->_preprocessBic();
			if (!preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $this->getBic())) {
				$sBankCheck = -416;
			}
			if ($sBankCheck >= 0 && $this->getValidateBicIbanWithEpaybl()) {
				$bankverbindung = new Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung(
						array(
								'BIC' => (string) $this->getBic(),
								'IBAN' => (string) $this->getIban(),
								// 								'kontoinhaber' => $payment->getCcOwner(),
						)
				);
			
				$sBankCheck = $this->_ePaymentCheckBankData($bankverbindung);
			}
		}
			
		// SOAP Error
		if ($sBankCheck == '-9999') {
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_SOAP', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif ($sBankCheck == '-999989') {
			Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR_'.$sBankCheck, Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -402) {
			// Die angegebene Bankleitzahl ist zu kurz oder zu lang
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_BLZ_TOO_SHORT', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -406) {
			// Die angegebene Verbindung ist in der Blacklist
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_BLACKLIST', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -403) {
			// Die angegebene Kontonummer ist zu kurz oder zu lang
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_KTO_TOO_SHORT', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -410) {
			// Die Bankverbindung konnte nicht validiert werden
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_BANK_NOT_VERIF', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -415) {
			// Für den Kunden liegt keine Einzugsermächtigung vor, deshalb darf keine elektronische
			// Lastschrift durchgeführt werden
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_EZE_PRESENT', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -416) {
			// BIC ungültig
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_BIC_INVALID', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -417) {
			// IBAN ungültig
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_IBAN_INVALID', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -420 || intval($sBankCheck) == -401) {
			// Die Bankverbindung konnte nicht validiert werden
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_NOT_VALID', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) == -702) {
			// Die Bankverbindung konnte nicht validiert werden
			Mage::throwException(Mage::helper('paymentbase')->__('ERROR_DEBIT_ENTRY_BLZ_INVALID', Mage::helper("paymentbase")->getCustomerSupportMail()));
		} elseif (intval($sBankCheck) < 0) {
			// anderer Fehler
			$msg = "{$this->getCode()}::Lastschrift: Fehler bei Bankprüfung, Code:".$sBankCheck;
			Mage::helper("paymentbase")->sendMailToAdmin($msg);
			Mage::log($msg, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
		}
		
		return $this;
	}
	
	protected function _getSession() {
		return Mage::getSingleton('core/session');
	}
	
	protected function _canChange($mandateref)
	{
		return true;
	}
	
	
	protected function _changeMandate($MandatReferenceToChange = null, $payment = null)
	{
		//abstract
		return $this;
	}
	
	
	/**
	 * Gibt den Pfad zum etc-Verzeichnis zurück
	 *
	 * @return string
	 */
	protected static function _getEtcPath() {
		$f = dirname(__FILE__);			// Get the path of this file
		$f = substr($f, 0, -5);			// Remove the "Model" dir
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
		return Egovs_Paymentbase_Helper_Data::getBankname($bic, $bicIsBlz);
	}
	
	public function getBlzFromIban($iban = false) {
		if (!$iban) {
			$iban = $this->getIban();
		}
		
		return Egovs_Paymentbase_Helper_Data::getBlzFromIban($iban);
	}
	
	/**
	 * Liefert den entsprechenden Banknamen zur BLZ
	 *
	 * @return String Bankname
	 * 
	 * @see Egovs_Debit_Model_Debit::getAccountBLZ
	 */
	public function getAccountBankname() {
		$_ibanOnly = $this->getIbanOnly();
		if ($_ibanOnly) {
			//BLZ geht nur für deutsche Banken!
			if (strpos($this->getIban(), "DE") !== 0) {
				return false;
			}
			$bic = $this->getBlzFromIban();
		} else {
			$bic  = $this->getBic();
		}
		return self::getBankname($bic, $_ibanOnly);
	}
	
	/**
	 * Gibt den Speicherort für erzeugte PDF-Mandate an
	 * 
	 * Das Magento Media-Verzeichnis wird immer der angegebenen Einstellung aus
	 * der Konfiguration vorangesetzt. <br/>
	 * Ein möglicher DIRECTORY_SEPARATOR am Ende wird entfernt.
	 * 
	 * @return string;
	 */
	public function getMandatePdfTemplateStore() {
		return Mage::helper($this->getCode())->getMandatePdfTemplateStore();
	}
	
	/**
	 * Liefert einen 40 Zeichen SHA1 Hash
	 * 
	 * Der Hash wird über die Mandatsreferenz und die ePayBL-Kunden-ID erzeugt.
	 * 
	 * @return string
	 * 
	 * @throws Egovs_Paymentbase_Exception_Code
	 */
	public function getPdfMandateName() {
		$customer = $this->getCustomer();
		return Mage::helper($this->getCode())->getPdfMandateName($customer);
	}
	
	/**
	 * Gibt die Template ID zur Erzeugung von PDF-Mandaten an
	 * 
	 * @return int
	 */
	public function getMandatePdfTemplateId() {
		return Mage::getStoreConfig("payment/{$this->getCode()}/mandate_pdf_template");
	}
	
	/**
	 * Liefert den Kunden der Quote, Order oder der aktuellen Session.
	 * 
	 * @return Mage_Customer_Model_Customer
	 */
	public function getCustomer() {
		if (!$this->_customer) {
			$info = null;
			try {
				$info = $this->getInfoInstance();
			} catch (Exception $e) {
				
			}
			if ($info instanceof Mage_Sales_Model_Quote_Payment) {
				$this->_customer = $info->getQuote()->getCustomer();
			} elseif ($info instanceof Mage_Sales_Model_Order_Payment) {
				$customer = $info->getOrder()->getCustomer();
				if ($customer instanceof Mage_Customer_Model_Customer) {
					$this->_customer = $customer;
				}
				else 
				{
					$this->_customer = Mage::getModel('customer/customer')->load($info->getOrder()->getCustomerId());
				}
				
			} else {
				$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
			}
		}
		
		return $this->_customer;
	}
	
	public function setCustomer($customer) {
		if (!($customer instanceof Mage_Customer_Model_Customer)) {
			throw new Egovs_Paymentbase_Exception_Code('Customer instance expected');
		}
		$this->_customer = $customer;
	}
	
	protected function _validateExternal($payment = null) {
		return $this;
	}
	
	/**
	 * Entfernt das aktuelle Mandat des Kunden
	 * 
	 * Entfernt werden:
	 * <ul>
	 * 	<li>Refernenz am Kunden</li>
	 * 	<li>PDF Mandat in Ablage (Store)</li>
	 * 	<li>Mandat wird an MV deaktiviert</li>
	 * </ul>
	 * 
	 * @param string $ref Mandatsreferenz
	 * 
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 */
	public function removeCurrentMandate($ref = null) {
		if (!$ref) {
			$_mandate = $this->getMandateReferenceFromCustomer();
		} else {
			$_mandate = $ref;
		}
		if (!$_mandate) {
			return $this;
		}
		try {
			$this->_removeCurrentMandate($_mandate);
		} catch (Exception $e) {
			Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper($this->getCode())->getCustomerSupportMail()));
		}
		
		if ($this->getRemoveMandateFile()) {
			$path = $this->getMandatePdfTemplateStore();
			$file = $this->getPdfMandateName();
			
			$ioObject = new Varien_Io_File();
			$ioObject->open(array('path' => $path));
			
			if ($ioObject->fileExists($file)) {
				if (!$ioObject->rm($file)) {
					$path = $path.DIRECTORY_SEPARATOR.$file;
					$msg = Mage::helper('paymentbase')->__("Can't delete PDF mandate: %s", $path);
					Mage::helper('paymentbase')->sendMailToAdmin("paymentbase::".$msg);
					Mage::log('paymentbase::'.$msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				}
			}
		}
		
		$customer = $this->getCustomer();
		$customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, '');
		if ($customer->getId() > 0) {
			/* @var $resource Mage_Customer_Model_Resource_Customer */
			$resource = $customer->getResource();
			$resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		}
		
		$this->__mandate = null;
		
		return $this;
	}
	
	/**
	 * Entfernt das aktuelle Mandat des Kunden an der konkreten MV
	 * 
	 * @param string $mandate Mandatsreferenz
	 * 
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 */
	protected abstract function _removeCurrentMandate($mandate);
	
	/**
	 * Gibt die Mandatsrefrenz vom Magento-Kundenkonto zurück
	 * 
	 * @return string|null
	 */
	public function getMandateReferenceFromCustomer() {
		$customer = $this->getCustomer();
		if (!$customer || $customer->isEmpty()) {
			return null;
		}
		$_mandateReference = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		if (!$_mandateReference) {
			return null;
		}
		
		return $_mandateReference;
	}
	
	/**
	 * Ein SEPA Mandat aus Mandatsverwaltung lesen
	 * 
	 * @param string $_mandateReference Mandatsreferenz
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
	 * @throws Exception
	 */
	protected abstract function _getMandate($_mandateReference);
	
	/**
	 * Ein SEPA Mandat einlesen
	 *
	 * Erstellt ein gekapseltes SEPA-Mandat das für interne und externe Mandate verwendet werden kann
	 * 
	 * @param string $_mandateReference Mandatsreferenz
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 * @throws Egovs_Paymentbase_Exception_Validation
	 */
	public final function getMandate($_mandateReference = null) {
		$customer = $this->getCustomer();
		if (!$_mandateReference) {
			$_mandateReference = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		}
		if ($this->__mandate && ($_mandateReference != null && $this->__mandate->getReference() != $_mandateReference)) {
			$this->__mandate = null;
		}
		if (!$this->__mandate) {
			$payment = null;
			try {
				$payment = $this->getInfoInstance();
			} catch (Exception $e) {
				$payment = new Varien_Object();
			}
			if (!$_mandateReference || ($payment && $payment->getAdditionalInformation('mandate_reference') && $payment->getAdditionalInformation('mandate_reference') != $_mandateReference)) {
				//Neues Mandat anlegen
				$bankingAccount = null;
				$mandate = $this->constructSepaMandate();
				if (!$mandate->getAccountholderDiffers()) {
					if ($this->getIsInternalManagement()) {
						$bankingAccount = $this->_checkBankDataModifyOnDemand();
						
						//Kunde wurde entweder neu erstellt oder ein bestehender Kunde wurde geladen.
						//Jetzt müssen die Daten nochmals geprüft werden
						$eCustomer = $this->getECustomer();
						if (!$mandate->addressesEqual(null, $eCustomer->getRechnungsAdresse())
							|| (!$mandate->getIsCompany() && $eCustomer->nachname != $mandate->getDebitorSurname())
							|| (!$mandate->getIsCompany() && $eCustomer->vorname != $mandate->getDebitorName())
							|| $mandate->getBankingAccount()->getIban() != $bankingAccount->getIban()
						) {
							//muss vor setAccountholderDiffers stehen!
							$ba = $mandate->getBankingAccount();
							
							$mandate->setAccountholderDiffers(true);
							$mandate->setAccountholderAddress($mandate->getDebitorAddress());
							$mandate->setAccountholderName($mandate->getDebitorName());
							if ($mandate->getIsCompany()) {
								if (strlen($mandate->getDebitorSurname()) < 1) {
									$mandate->setAccountholderSurname($this->__(' '));
								}
								if (!$mandate->getAccountholderIban()) {
									$mandate->setBankingAccount($ba);
									$mandate->setAccountholderBankname($this->getAccountBankname());
								}
							} else {
								$mandate->setAccountholderSurname($mandate->getDebitorSurname());
							}
						}
					}
				}
				
				$mandate = $this->createSepaMandate($mandate);
				$customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $mandate->getReference());
				if ($customer->getId() > 0 && !$customer->getDeleteOnPlatform()) {
					/* @var $resource Mage_Customer_Model_Resource_Customer */
					$resource = $customer->getResource();
					$resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
				}
				if ($mandate->getAccountholderDiffers()) {
					$payment->setCcOwner($mandate->getAccountholderFullname());
				} else {
					$payment->setCcOwner($mandate->getDebitorFullname());
				}
				if (!$this->getIbanOnly()) {
					$payment->setCcType($mandate->getBankingAccount()->getBic());
				}
				$payment->setCcNumber($mandate->getBankingAccount()->getIban());
				$payment->setCcNumberEnc($this->encrypt($mandate->getBankingAccount()->getIban()));
				$payment->setAdditionalInformation('mandate_reference', $mandate->getReference());
				$mandate->setIsNew(true);
			} else {
				$mandate = $this->_getMandate($_mandateReference);
				$this->__mandate = $this->createNewAdapterMandate($mandate);
				if ($this->__mandate->getReference() != $_mandateReference
					|| $this->__mandate->isCancelled()
				) {
					if ($payment->hasAdditionalInformation('mandate_reference')) {
						$payment->unsAdditionalInformation('mandate_reference');
					}
					$msg = Mage::helper($this->getCode())->__('Mandate reference is invalid! You have to create a new mandate.');
					if ($this->__mandate->isCancelled()) {
						$msg = Mage::helper($this->getCode())->__('Mandate was cancelled, you have to create a new mandate.');
						if (!$this->__mandate->isActive() && $this->__mandate->getSequenceType() == Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF) {
							$msg = Mage::helper($this->getCode())->__('Current mandate was for single use only, you have to create a new mandate.');
						}
					}
					
					$this->removeCurrentMandate($_mandateReference);
					
					$this->__mandate = null;
					//Mage::throwException($msg);
					$ve = new Egovs_Paymentbase_Exception_Validation($msg);
					$ve->addMessage(Mage::getModel('core/message_notice', $msg));
					throw $ve;
				} else {
					$this->_getReferencedInformation($this->__mandate);
					
					if ($this->__mandate->getAccountholderDiffers()) {
						$payment->setCcOwner($this->__mandate->getAccountholderFullname());
					} else {
						$payment->setCcOwner($this->__mandate->getDebitorFullname());
					}
					if (!$this->getIbanOnly()) {
						$payment->setCcType($this->__mandate->getBankingAccount()->getBic());
					}
					$payment->setCcNumber($this->__mandate->getBankingAccount()->getIban());
					$payment->setCcNumberEnc($this->encrypt($this->__mandate->getBankingAccount()->getIban()));
					$payment->setAdditionalInformation('mandate_reference', $this->__mandate->getReference());
				}
			}
		}
		
		return $this->__mandate;
	}
	
	/**
	 * Sammelt referenzierte Informationen zusammen und speichert diese im Mandat
	 * 
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface $mandate Mandat
	 * 
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 */
	protected function _getReferencedInformation($mandate) {
		if (!$this->getIsInternalManagement()) {
			return $this;
		}
		
		if (!$mandate->getAccountholderDiffers()) {
			$_eCustomer = null;
			try {
				//$this->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID)
				$_eCustomer = $this->getCustomerFromEPayment((string) $mandate->getAdapteeMandate()->eShopKundenNr);
			} catch (Exception $e) {
				Mage::logException($e);
				Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper($this->getCode())->getCustomerSupportMail()));
			}
			if (!$_eCustomer || !isset($_eCustomer->ergebnis) || !$_eCustomer->ergebnis->istOk) {
				if (isset($_eCustomer->ergebnis)) {
					Mage::log('Error while read customer from ePayBL: %s', $_eCustomer->ergebnis->langText);
				}
				Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper($this->getCode())->getCustomerSupportMail()));
			}
			$_eCustomer = $_eCustomer->kunde;
			
			$bank = $mandate->getBankingAccount();
			$bank->setIban($_eCustomer->bankverbindung->getIban());
			if (!$this->getIbanOnly()) {
				$bank->setBic($_eCustomer->bankverbindung->getBic());
			}
			
			if (isset($_eCustomer->bankverbindung->kontoinhaber)) {
				$mandate->setAccountholderSurname($_eCustomer->bankverbindung->kontoinhaber);
			} else {
				$mandate->setAccountholderSurname($_eCustomer->nachname);
				$mandate->setAccountholderName($_eCustomer->vorname);
			}
		}
		//Workaround um auf Firma zu prüfen --> ePayBL unterstützt keine Firmen!!!
		if ($this->isCustomerCompany()) {
			$mandate->setIsCompany(true);
		}
		
		return $this;
	}
	
	public function isCustomerCompany() {
		$customer = $this->getCustomer();
		if ($customer && !$customer->isEmpty() && strlen($customer->getCompany()) > 0) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Erstellt das Mandats-Objekt mit individuellen Erweiterungen
	 * 
	 * Die eShopKundennummer wird nicht gesetzt!</br>
	 * Die dateOfLastUsage wird nicht gesetzt!
	 * 
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface $mandate Mandat als Adapter
	 * @param Mage_Payment_Model_Info                        $payment Payment
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_SepaMandat
	 * @throws Exception
	 */
	protected abstract function _constructSepaMandate($mandate, $payment = null);
	
	/**
	 * Erstellt das Mandats-Objekt mit Daten
	 *
	 * Die eShopKundennummer wird nicht gesetzt!</br>
	 * Die dateOfLastUsage wird nicht gesetzt!
	 *
	 * @param Mage_Payment_Model_Info $payment Payment
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 * @throws Exception
	 */
	public final function constructSepaMandate($payment = null) {
		if (!$payment) {
			$payment = $this->getInfoInstance();
		}
		$mandate = $this->createNewAdapterMandate();
		
		/*
		 * $mandate ist eigentlich vom Typ Egovs_Paymentbase_Model_Sepa_Mandate_Interface
		 * da die Magicmethoden genutzt werden, implementiert es automatisch Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
		 */
		
		$data = null;
		try {
			$address = $this->_getBillingAddress();
			$data = Mage::helper($this->getCode())->extractCustomerInformation($address);
		} catch (Exception $e) {
			Mage::logException($e);
		}
		if (!$data || $data->isEmpty()) {
			Mage::throwException($this->__("Can't get debitor name information"));
		}
		
		/*
		 * Wird für Längenauswertung des berechtigten Zeichners benötigt!
		 */
		if ($data->getIsCompany()) {
			$mandate->setIsCompany(true);
		}
		
		$mandate->importData($payment, $this->getCreditorId(), $this->getAllowOneoff(), $this->_extractDebitorAddress() );		
		
		if ($data->getIsCompany()) {
			if ($mandate->getAccountholderDiffers()) {
				$mandate->setCompany($mandate->getAccountholderSurname());
				$mandate->setDebitorName($data->getCompany());
			} else {
				$mandate->setCompany($data->getCompany());
				$mandate->setDebitorName($data->getCompany());
			}
		} else {
			$mandate->setDebitorName($data->getFirstname());
			$mandate->setDebitorSurname($data->getLastname());
		}
		
		$ba = Egovs_Paymentbase_Model_Sepa_Mandate_Abstract::createNewBankingAccount($mandate);
		$ba->setIban($this->getIban());
		if (!$this->getIbanOnly()) {
			$ba->setBic($this->getBic());
		}
		$mandate->setBankingAccount($ba);
		
		/* Anpassungen je nach verwendeter Mandatsverwaltung */
		$mandate = $this->_constructSepaMandate($mandate, $payment);
		
		//return Mage::getModel('paymentbase/sepa_mandate', array('mandate' => $mandate));
		return $mandate;
	}
	
	/**
	 * Erstellt einen Mandatsadapter
	 * 
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee $mandate Mandate
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	public final function createNewAdapterMandate(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee $mandate = null) {
		if ($mandate != null && !($mandate instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee)) {
			Mage::throwException('Mandate have to be instance of Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee');
		}
		$_mandate = $this->_createNewAdapterMandate($mandate);
		if (!($_mandate instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Interface)) {
			Mage::throwException('Mandate have to be instance of Egovs_Paymentbase_Model_Sepa_Mandate_Interface');
		}
		if ($mandate && !$_mandate->hasMandate()) {
			$_mandate->setMandate($mandate);
		}
		return $_mandate;
	}
	
	/**
	 * Liefert eine Mandatsinstanz
	 * 
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee $mandate Mandate
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	protected abstract function _createNewAdapterMandate($mandate);
	
	/**
	 * Erstellt das Mandat an der Mandatsverwaltung
	 * 
	 * Hier ist die anbindungshabängige Implementierung lokalisiert 
	 * 
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee $mandate Mandat
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee Sepa-Mandat mit Referenz
	 * @throws Exception
	 */
	protected abstract function _createSepaMandate($mandate);
	
	/**
	 * Erstellt das Mandat an der Mandatsverwaltung
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface $mandate Mandat
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface Sepa-Mandat mit Referenz
	 * @throws Exception
	 */
	public final function createSepaMandate($mandate = null) {
		if (!($mandate instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Interface)) {
			$mandate = $this->__mandate;
		}
		
		if (!$mandate) {
			Mage::throwException('No mandate instance available!');
		}
		$_adapteeMandate = $this->_createSepaMandate($mandate->getAdapteeMandate());
		$mandate->setAdapteeMandate($_adapteeMandate);
		$this->__mandate = $mandate;
		
		$this->addMandateToHistory($mandate, $this->getCustomer());
		
		
		
		return $this->__mandate;
	}
	
	
	public function addMandateToHistory($mandate, $customer)
	{
		//speichern der History
		$history = Mage::getModel('paymentbase/sepa_mandate_history');
		$history->setData('customer_id',$this->getCustomer()->getId());
		$history->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID,$mandate->getReference());
		$history->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID,$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID));
		
		$history->setData('created_at',now());
		$history->setData('updated_at',now());
		$history->save();
	}
	
	/**
	 * Vervollständigt das Mandat an der ePayBL
	 * 
	 * Darf nur mit <strong>interner</strong> Mandatsverwaltung genutzt werden!
	 *
	 * @param Egovs_Paymentbase_Model_Webservice_Types_SepaMandat $mandate Mandat
	 * 
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 * @throws Exception
	 */
	protected function _completeSepaMandate($mandate) {
		if ($mandate instanceof Egovs_Paymentbase_Model_Webservice_Types_SepaMandat) {
			$mandate = $mandate->referenz;
		} elseif (!is_string($mandate)) {
			Mage::log("{$this->getCode()}::Fehler Funktion:_completeSepaMandate()\nMandat oder Mandatsreferenz erwartet", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
		}

		$soapFunction = 'vervollstaendigenSepaMandat()';
		Mage::log("{$this->getCode()}::Rufe auf $soapFunction: Mandant Nr.: {$this->_getMandantNr()} , EKundenNr: {$this->_getECustomerId()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	
		$objResult = null;
		try {
			$datumUnterschrift = Mage::app()->getLocale()->date()->toString('dd.MM.yyyy');
			$src = $this->getInfoInstance()->getOrder();
			$city = $this->__('Unknown');
			if (!$src) {
				$src = $this->getInfoInstance()->getQuote();
			}
			if ($src) {
				$address = $src->getBillingAddress();
				if ($address) {
					$city = $address->getCity();
				}
			}
			$objResult = $this->_getSoapClient()->vervollstaendigenSEPAMandat($mandate, $datumUnterschrift, $city);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}
		$sMailText = '';
		$result = -9999;
		if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_EinzugsermaechtigungErgebnis) {
			if ($objResult->ergebnis->istOk) {
				return $this;
			}
			$sMailText .= Mage::helper('paymentbase')->getErrorStringFromObjResult($objResult->ergebnis);
			$result = $objResult->ergebnis->getCode();
		} elseif ($objResult instanceof SoapFault) {
			$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
		} else {
			$sMailText .= "Error: No result returned\n";
		}
		Mage::helper("paymentbase")->sendMailToAdmin("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n\n".$sMailText);
		Mage::log("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		switch ($result) {
			case -117:
				Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_-0117', Mage::helper("paymentbase")->getCustomerSupportMail()));
		}
		Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
	}
	
	public function getIsDebug() {
		if (is_null($this->_isDebug)) {
			$this->_isDebug = Mage::getStoreConfig('payment/sepadebitbund/is_debug');
		}
		
		return $this->_isDebug;
	}
	
	public function getCreditorId() {
		if (is_null($this->_creditorId)) {
			$this->_creditorId = Mage::getStoreConfig('payment/sepadebitbund/creditor_id');
		}
	
		return $this->_creditorId;
	}
	
	/**
	 * Gibt an ob die interne Mandatsverwaltung der ePayBL oder eine externe genutzt wird.
	 * 
	 * @return bool
	 */
	public function getIsInternalManagement() {
		if (!$this->canExternalMandateManagement()) {
			return true;
		}
		
		if (is_null($this->_isInternalManagement)) {
			/*
			 * 0 = internal
			 * 1 = external
			 */
			$this->_isInternalManagement = Mage::getStoreConfig("payment/{$this->getCode}/type_management_mandate") == 0 ? true : false;
		}
		
		return $this->_isInternalManagement;
	}
	
	/**
	 * Gibt an ob die Bankdaten an der ePayBL überprüft werden sollen
	 * 
	 * @return bool
	 */
	public function getValidateBicIbanWithEpaybl() {
		if (is_null($this->_validateBicIbanWithEpaybl)) {
			$this->_validateBicIbanWithEpaybl = Mage::getStoreConfig("payment/{$this->getCode}/validate_bic_iban_with_epaybl");
		}
	
		return $this->_validateBicIbanWithEpaybl;
	}
	
	/**
	 * Liefert die BIC des angegebenen Bankkontos
	 *
	 * Die BIC ist im 'cc_type' Feld gespeichert.
	 *
	 * @return string BLZ des Kunden
	 */
	public function getBic() {
	    $info = $this->getInfoInstance();
	    $return = $info->getCcType();
	    
		if ($this->getIbanOnly() && empty($return)) {
			return '';
		}

	
		return (string) $return;
	}
	
	/**
	 * Liefert die IBAN des angegebenen Bankkontos
	 *
	 * Die IBAN ist im 'cc_number' Feld gespeichert
	 *
	 * @return string IBAN
	 */
	public function getIban() {
		$info = $this->getInfoInstance();
		$return = $info->getCcNumber();
	
		return (string) $return;
	}
	/**
	 * Prüft die hinterlegte Bankverbindung am Kunden an der ePayBL und ändert diese falls nötig.
	 * 
	 * @param Mage_Payment_Model_Info $payment Payment
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	protected function _checkBankDataModifyOnDemand($payment = null) {
		if (!$payment) {
			$payment = $this->getInfoInstance();
		}
		// prüfen, ob Kunde mit seiner eShopKundennummer schon am Server existiert, sonst anlegen
		$this->createCustomerForPayment();
		/* @var $eCustomer Egovs_Paymentbase_Model_Webservice_Types_Kunde */
		$eCustomer = $this->getECustomer();
		$_bankverbindung = $eCustomer->getBankverbindung();
		if ($eCustomer instanceof Egovs_Paymentbase_Model_Webservice_Types_Kunde
			&& (!isset($_bankverbindung)
				|| !($_bankverbindung instanceof Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung)
				|| ($_bankverbindung->IBAN != $this->getIban())
				|| (!$this->getIbanOnly() && $_bankverbindung->BIC != $this->getBic())
				|| ($this->isCustomerCompany() && $_bankverbindung->kontoinhaber != $eCustomer->nachname)
			)
			&& !$payment->getAdditionalInformation('custom_owner')
		) {
			/* @var $bankverbindung Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung */
			$_bankverbindung = Mage::getModel('paymentbase/webservice_types_bankverbindung');
			if (!$this->getIbanOnly()) {
				$_bankverbindung->BIC = $this->getBic();
			}
			$_bankverbindung->IBAN = $this->getIban();
// 			$_bankverbindung->BLZ = substr($this->getIban(), 4, 8);
			if ($this->isCustomerCompany()) {
				$_bankverbindung->kontoinhaber = $eCustomer->nachname;
			} else {
				$_bankverbindung->kontoinhaber = sprintf('%s %s', $eCustomer->vorname, $eCustomer->nachname);
			}
			$eCustomer->bankverbindung = $_bankverbindung;
			$ignoreList = array(-442 => true, -443 => true, -440 => true);
			$result = Mage::helper('paymentbase')->addOmitMailToAdminList($ignoreList)->modifyCustomerOnEPayment($eCustomer);
			
			if (intval($result) < 0) {
				switch (intval($result)) {
					case -440:
						$ve = new Egovs_Paymentbase_Exception_Validation(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_BIC_INVALID-0440'));
						$ve->addMessage(Mage::getModel('core/message_error', Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_BIC_INVALID-0440')));
						throw $ve;
					case -442:
						$ve = new Egovs_Paymentbase_Exception_Validation(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_IBAN_INVALID-0442'));
						$ve->addMessage(Mage::getModel('core/message_error', Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_IBAN_INVALID-0442')));
						throw $ve;
					case -443:
						$ve = new Egovs_Paymentbase_Exception_Validation(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_IBAN_INVALID-0443'));
						$ve->addMessage(Mage::getModel('core/message_error', Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_IBAN_INVALID-0443')));
						throw $ve;
					default:
						Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
				}
			}
		}
		
		return $_bankverbindung;
	}
	
	/**
	 * Authorize
	 *
	 * Hier wird die eigentliche Buchung am ePayment durchgeführt.<br>
	 * <p>
	 * <ol>
	 * 	<li>Der Kunde wird an der ePayment-Plattform angelegt</li>
	 *  <li>Die Buchungsliste wird erstellt</li>
	 *  <li>Das Ergebnis des WebService-Aufrufs wird validiert</li>
	 *  <li>Der Kunde wird wieder vom ePayment-System gelöscht</li>
	 *  <li>Das Kassenzeichen wird in der PaymentInfo gespeichert</li>
	 * </ol>
	 *
	 * @param Varien_Object $payment Payment
	 * @param integer       $amount  Betrag
	 *
	 * @return  Egovs_Paymentbase_Model_Debit
	 *
	 * @see Egovs_Paymentbase_Model_Debit::_authorize
	 * @see Egovs_Paymentbase_Model_Abstract::createAccountingListParts
	 * @see Egovs_Paymentbase_Model_Abstract::validateSoapResult
	 * @see Egovs_Paymentbase_Model_Abstract::loeschenKunde
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		/* @var $payment Mage_Payment_Model_Info */
		$objResult = null;
		$_method = 'No method name given';
		
		$this->createCustomerForPayment();
		// Fälligkeitsdatum berechnen
		$iDatumFaelligkeit = Mage::app()->getLocale()->date()->addDay(14)->toValue();
		
		// Objekt für Buchungsliste erstellen
		$objBuchungsliste = $this->createAccountingList($payment, $amount, null, $iDatumFaelligkeit);
		if (!$this->getIsInternalManagement()) {
			$this->_checkBankDataModifyOnDemand($payment);
			
			$mandate = $this->_constructSepaMandate($payment);
			$mandate->datumUnterschrift = Mage::app()->getLocale()->date()->toString('dd.MM.yyyy');
			if ($status = $payment->getAdditionalInformation('mandate_status')) {
				$mandate->aktiv = (bool)$status;
				if ($status) {
					$mandate->ortUnterschrift = $this->_getOrder()->getBillingAddress()->getCity();
				}
			}
			$mandate->eShopKundenNr = $this->_getECustomerId();
			$mandate->referenz = "SEPAPTEST".Mage::app()->getLocale()->date()->toString('yyyyMMddHHmmss');
			$mandate->dateOfLastUsage = Mage::app()->getLocale()->date()->toString(Zend_Date::ISO_8601);
			
			$objResult = $this->_getSoapClient()->abbuchenMitSEPAMandatMitBLP($this->_getECustomerId(), $mandate, $objBuchungsliste, $this->getBuchungsListeParameter($payment, $amount));
			$_method = 'abbuchenMitSEPAMandatMitBLP';
		} else {
			// Webservice aufrufen
			$mandate = $payment->getAdditionalInformation('mandate_reference');
			$mandate = $this->_getMandate($mandate);
			$mandate = $this->createNewAdapterMandate($mandate);
			if (!$mandate->isActive() && !$mandate->isCancelled()) {
				$this->_completeSepaMandate($mandate->getAdapteeMandate());
			}
			$objResult = $this->_getSoapClient()->abbuchenMitSEPAMandatreferenzMitBLP($this->_getECustomerId(), $mandate->getReference(), $objBuchungsliste, null, $this->getBuchungsListeParameter($payment, $amount));
			$_method = 'abbuchenMitSEPAMandatreferenzMitBLP';
		}
		$this->validateSoapResult($objResult, $objBuchungsliste, $_method);
		
		//das kassenzeichen sollte erst abgeholt werden wenn das ergebniss geprueft wurde
		$payment->setKassenzeichen($objResult->buchungsListe->kassenzeichen);
        $payment->setPayClient(Mage::helper('paymentbase')->getMandantNr());
        $payment->setPayOperator(Mage::helper('paymentbase')->getBewirtschafterNr());
		$payment->setData( Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $mandate->getReference());
		//print_r($objResult->buchungsListe->kassenzeichen);
		$this->loeschenKunde();
		
		return $this;
	}
	/**
	 * Gibt an ob auch eine externe Mandatsverwaltung untersützt wird.
	 * 
	 * @return bool
	 */
	public function canExternalMandateManagement() {
		return $this->_canExternalMandateManagement;
	}
	
	/**
	 * Gibt an ob die interne ePayBL Mandatsverwaltung untersützt wird.
	 * 
	 * @return bool
	 */
	public function canInternalMandateManagement() {
		return $this->_canInternalMandateManagement;
	}
	
	/**
	 * Liefert die Rechnungsadresse
	 * 
	 * @return Mage_Customer_Model_Address_Abstract
	 */
	protected function _getBillingAddress() {
		$src = $this->_getOrder();
		if (!$src) {
			/* @var $src Mage_Sales_Model_Quote */
			$src = $this->getInfoInstance()->getQuote();
		}
		if (!$src) {
			return null;
		}
		return $src->getBillingAddress();
	}
	
	/**
	 * Ermittelt die Debitor-Adresse
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
	 */
	protected function _extractDebitorAddress() {
		/*
		 * Der Kunde soll mit einem Kompletten Datensatz zur Mahnung angelegt werden
		 */
		
		$address = $this->_getBillingAddress();
		return $this->_extractDebitorAddressFromBillingAddress($address);
	}
	
	protected function _extractDebitorAddressFromBillingAddress($address)
	{
		$errors = array();
		$debitorAddress = $this->_getEmptyAddressInstance();
		
		if (!($address instanceof Mage_Customer_Model_Address_Abstract)) {
			Mage::throwException($this->__('No debitor address available'));
		}
		
		//Straße
		if (strlen($address->getStreetFull()) > 0) {
			$debitorAddress->setStreet($address->getStreetFull());
		} else {
			$errors[] = $this->__('Street is a required field');
		}
		//Land
		if (strlen($address->getCountryId()) > 0) {
			$debitorAddress->setCountry($address->getCountryId());
		} else {
			$errors[] = $this->__('Country is a required field');
		}
		//PLZ
		$plz = $address->getPostcode();
		$plzErrors = Mage::helper('paymentbase/validation')->validatePostcode($plz, $address->getCountryId());
		if (empty($plzErrors)) {
			$debitorAddress->setZip($plz);
		} else {
			$errors = array_merge($errors, $plzErrors);
		}
		//Stadt
		if (strlen($address->getCity()) > 0) {
			$debitorAddress->setCity($address->getCity());
		} else {
			$errors[] = $this->__('City is a required field');
		}
		
		if (!empty($errors)) {
			$errors = implode('<br/>', $errors);
			Mage::throwException($errors);
		}
		
		return $debitorAddress;
	}
	
	/**
	 * Erstellt eine neue leere Adresse
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Adresse
	 */
	protected function _getEmptyAddressInstance() {
		return Egovs_Paymentbase_Model_Sepa_Mandate::createEmptyAddress();
	}
	
	/**
	 * Zusätzliche Unterstützung für Adressen aus Quotes
	 * 
	 * Falls der Kunde schon existiert, wird dieser verwendet.
	 * 
	 * @param Varien_Object $data An object with the customers data
	 * 
	 * @return boolean
	 * 
	 * @see Egovs_Paymentbase_Model_Abstract::createCustomerForPayment($data)
	 */
	public function createCustomerForPayment($data = null) {
		if (empty($data)) {
			Mage::log($this->getCode().'::Include personal data for customers', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			$objRechnungsAdresse = $this->_extractDebitorAddress();
			
			/*
			 * Der Kunde soll mit einem Kompletten Datensatz zur Mahnung angelegt werden
			*/
			$data = new Varien_Object();
			$errors = array();
			$address = $this->_getBillingAddress();
			
			try {
				$data = Mage::helper($this->getCode())->extractCustomerInformation($address);
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
				
			if (!empty($errors)) {
				$errors = implode('<br/>', $errors);
				Mage::throwException($errors);
			}
				
			$data->setInvoiceAddress($objRechnungsAdresse);
		}
		return parent::createCustomerForPayment($data);
	}
}