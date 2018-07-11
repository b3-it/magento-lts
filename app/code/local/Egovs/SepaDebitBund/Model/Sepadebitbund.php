<?php
/**
 * ePayment-Kommunikation im SEPA-Debit-Verfahren (Lastschrift) für Bund.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitBund_Model_Sepadebitbund extends Egovs_Paymentbase_Model_SepaDebit
{
	/**
	 * Eindeutige interne Bezeichnung für Payment [a-z0-9_]
	 *
	 * @var string $_code
	 */
	protected $_code = 'sepadebitbund';
	/**
	 * Formblock Type
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'sepadebitbund/form';
	/**
	 * Infoblock Type
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'sepadebitbund/info';
	
	/**
	 * Erstellt das Mandats-Objekt mit individuellen Erweiterungen
	 *
	 * Die eShopKundennummer wird nicht gesetzt!</br>
	 * Die dateOfLastUsage wird nicht gesetzt!
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Abstract $mandate Mandat als Adapter
	 * @param Mage_Payment_Model_Info                       $payment Payment
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_SepaMandat
	 * @throws Exception
	 */
	protected function _constructSepaMandate($mandate, $payment = null) {
		if (!$payment) {
			$payment = $this->getInfoInstance();
		}
		$mandate->setBewirtschafterNr($this->_getBewirtschafterNr());
		$mandate->setType(Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::TYPE_SDD_CORE_BASE);
		if ($payment->getAdditionalInformation('custom_owner')) {
			$mandate->setAccountholderBankname($this->getAccountBankname());
		}
	
		return $mandate;
	}
	
	/**
	 * Ein SEPA Mandat aus Mandatsverwaltung lesen
	 *
	 * @param string $_mandateReference Mandatsreferenz
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 * @throws Exception
	 */
	protected function _getMandate($_mandateReference) {
		$objResult = null;
		try {
			$objResult = $this->_getSoapClient()->leseSEPAMandat($_mandateReference);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}
		$soapFunction = __FUNCTION__;
		$sMailText = '';
		if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis) {
			if ($objResult->ergebnis->istOk) {
				return $objResult->sepaMandat;
			}
			$sMailText .= Mage::helper('paymentbase')->getErrorStringFromObjResult($objResult->ergebnis);
		} elseif ($objResult instanceof SoapFault) {
			$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
		} else {
			$sMailText .= "Error: No result returned\n";
		}
		Mage::helper("paymentbase")->sendMailToAdmin("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n\n".$sMailText);
		Mage::log("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			
		Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
	}
	
	protected function _removeCurrentMandate($mandate) {
		if (!is_string($mandate)) {
			return $this;
		}
		$soapFunction = 'deaktivierenSepaMandat()';
		Mage::log("{$this->getCode()}::Rufe auf $soapFunction: Mandant Nr.: {$this->_getMandantNr()} , EKundenNr: {$this->_getECustomerId()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		$objResult = null;
		try {
			$objResult = $this->_getSoapClient()->deaktiviernSEPAMandat($this->_getECustomerId(), $mandate);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}
		$sMailText = '';
		if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis) {
			if ($objResult->ergebnis->istOk) {
				$customer = $this->getCustomer();
				if($customer)
				{
					$mandateRef = Mage::helper('paymentbase')->getAdditionalCustomerMandateData($customer,"change_mandate");
					Mage::helper('paymentbase')->unsAdditionalCustomerMandateData($customer,"change_mandate");			
					Mage::helper('paymentbase')->changeAdditionalCustomerMandateData($customer,array("old_mandate"=>$mandateRef));
				}
				return $this;
			}
			
			$sMailText .= Mage::helper('paymentbase')->getErrorStringFromObjResult($objResult->ergebnis);
			switch ($objResult->ergebnis->getCodeAsInt()) {
				case -5201:
					//SEPA-Daten-Fehler, der NICHT begründet ist im Fehlschlagen einer Datenbankoperation: Das Mandat zu einer Mandanten-Nummer und Mandat-Referenz ist NICHT vorhanden.
					Mage::log("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n". $sMailText, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
					$customer = $this->getCustomer();
					if ($customer) {
						$mandateRef = Mage::helper('paymentbase')->getAdditionalCustomerMandateData($customer,"change_mandate");
						Mage::helper('paymentbase')->unsAdditionalCustomerMandateData($customer,"change_mandate");
						Mage::helper('paymentbase')->changeAdditionalCustomerMandateData($customer,array("old_mandate"=>$mandateRef));
					}
					return $this;
			}
			
		} elseif ($objResult instanceof SoapFault) {
			$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
		} else {
			$sMailText .= "Error: No result returned\n";
		}
		Mage::helper("paymentbase")->sendMailToAdmin("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n\n".$sMailText);
		Mage::log("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
	
		Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
	}
	
	/**
	 * Erstellt das Mandat an der ePayBL
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee $mandate Mandat
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface Sepa-Mandat mit Referenz
	 * @throws Exception
	 */
	protected function _createSepaMandate($mandate) {
		// prüfen, ob Kunde mit seiner eShopKundennummer schon am Server existiert, sonst anlegen
		$this->createCustomerForPayment();
	
		//Workaround: ePayBL verlangt immer eine Bankverbindung am Kunden
		//############################################################################################################################################
		$eCustomer = $this->getECustomer();
		$_bankverbindung = $eCustomer->getBankverbindung();
		if ($mandate->getAccountholderDiffers() && (!isset($_bankverbindung) || !($_bankverbindung instanceof Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung))) {
			/* @var $bankverbindung Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung */
			$_bankverbindung = Mage::getModel('paymentbase/webservice_types_bankverbindung');
			if (!$this->getIbanOnly()) {
				$_bankverbindung->BIC = $this->getBic();
			}
			$_bankverbindung->IBAN = $this->getIban();
			// 			$_bankverbindung->BLZ = substr($this->getIban(), 4, 8);
			$_surname = $eCustomer->vorname;
			$_name = $eCustomer->nachname;
			if (isset($mandate->accountOwnerSurname)) {
				$_surname = $mandate->accountOwnerSurname;
			}
			if (isset($mandate->accountOwnerName)) {
				$_name = $mandate->accountOwnerName;
			}
			$_bankverbindung->kontoinhaber = sprintf('%s %s', $_name, $_surname);

			$eCustomer->bankverbindung = $_bankverbindung;
			$ignoreList = array(-442 => true, -443 => true);
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
				}
				Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
			}
		}
		//############################################################################################################################################
		
		$mandate->dateOfLastUsage = Mage::app()->getLocale()->date()->toString(Zend_Date::ISO_8601);
		$mandate->eShopKundenNr = $this->_getECustomerId();
	
		$soapFunction = 'anlegenSepaMandat()';
		Mage::log("{$this->getCode()}::Rufe auf $soapFunction: Mandant Nr.: {$this->_getMandantNr()} , EKundenNr: {$this->_getECustomerId()}", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
	
		$objResult = null;
		try {
			$objResult = $this->_getSoapClient()->anlegenSEPAMandat($mandate);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}
		$sMailText = '';
		$result = -9999;
		if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_SepaMandatErgebnis) {
			if ($objResult->ergebnis->istOk) {
				return $objResult->sepaMandat;
			}
			$sMailText .= Mage::helper('paymentbase')->getErrorStringFromObjResult($objResult->ergebnis);
            $sMailText .= "IbanOnly: {$this->getIbanOnly()}\n";
			$sMailText .= "BIC {$this->getBic()}\n\n";

			$result = $objResult->ergebnis->getCodeAsInt();
		} elseif ($objResult instanceof SoapFault) {
			$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
		} else {
			$sMailText .= "Error: No result returned\n";
		}
		Mage::log("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n". $sMailText, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
	
		switch ($result) {
			case -117:
				Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_-0117', Mage::helper("paymentbase")->getCustomerSupportMail()));
			case -405:
				Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_-0405', Mage::helper("paymentbase")->getCustomerSupportMail()));
			case -417:
				$ve = new Egovs_Paymentbase_Exception_Validation(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_IBAN_INVALID-0442'));
				$ve->addMessage(Mage::getModel('core/message_error', Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_IBAN_INVALID-0442')));
				throw $ve;
			case -440:
				$ve = new Egovs_Paymentbase_Exception_Validation(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_BIC_INVALID-0440'));
				$ve->addMessage(Mage::getModel('core/message_error', Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_BIC_INVALID-0440')));
				throw $ve;
			case -5120:
				$ve = new Egovs_Paymentbase_Exception_Validation(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_ALT_BANK_OWNER-5120'));
				$ve->addMessage(Mage::getModel('core/message_error', Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_ALT_BANK_OWNER-5120')));
				throw $ve;
			case -5126:
				$ve = new Egovs_Paymentbase_Exception_Validation(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_-5126'));
				$ve->addMessage(Mage::getModel('core/message_error', Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_-5126')));
				throw $ve;
		}
		Mage::helper("paymentbase")->sendMailToAdmin("{$this->getCode()}::Fehler in WebService-Funktion: $soapFunction\n\n".$sMailText);
		Mage::throwException(Mage::helper($this->getCode())->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper("paymentbase")->getCustomerSupportMail()));
	}
	
	/**
	 * Liefert eine Mandatsinstanz
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee $mandate Mandate
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	protected function _createNewAdapterMandate($mandate) {
		if ($mandate != null && !($mandate instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee)) {
			Mage::throwException('Mandate have to be instance of Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee');
		}
		$args = array();
		if ($mandate) {
			$args['mandate'] = $mandate;
		}
		return Mage::getModel('sepadebitbund/sepa_mandate', $args);
	}
	
	public function validate() {
		parent::validate();
		
		$payment = $this->getInfoInstance();
		if (($this->getIbanOnly() || $payment->getData('cc_type')) && $payment->getData('cc_number')) {
			$mandate = $this->getMandate();
			if ($mandate->getIsNew()) {
				$mandate->setTemplateId($this->getMandatePdfTemplateId());
				$mandate->setStoreId($this->getInfoInstance()->getQuote()->getStoreId());
				$date = Mage::app()->getLocale()->date()->toString('dd.MM.yyyy');
				$mandate->setDateSignedAsString($date);
				$mandate->setLocationSigned($mandate->getDebitorAddress()->getCity());
				$path = $this->getMandatePdfTemplateStore();
				$name = $this->getPdfMandateName();
				$mandate->saveAsPdf(sprintf('%s/%s', $path, $name));
			}
		}
	}
	
	/**
	 * Capture
	 *
	 * Der State wird hier auf "Verarbeitung geändert"
	 *
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 *
	 * @return Egovs_Debit_Model_Debit
	 *
	 * @see Mage_Payment_Model_Method_Abstract::capture()
	 */
	public function capture(Varien_Object $payment, $amount) {
		parent::capture($payment, $amount);
	
		//Ticket #705
		//http://www.kawatest.de:8080/trac/ticket/705
		if (!$this->hasKassenzeichen($payment)) {
			$this->authorize($payment, $amount);
		}
	
		$order = $this->getInfoInstance()->getOrder();
	
		$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING);
	
		return $this;
	}
	
	/**
	 * Liefert die Einstellung ob OOFF erlaubt ist.
	 * 
	 * @return boolean
	 */
	public function getAllowOneoff() {
		return Mage::getStoreConfig('payment/sepadebitbund/allow_ooff') == 0 ? false : true;
	}
	
	
	
	
	public function createNewMandateFromCustomer($customer, $paymentFormData)
	{
		$info = $this->getInfoInstance();
		$quote = $info->getQuote();
		$info ->addData($paymentFormData->getData());  
		
		$quote->setBillingAddress($customer->getDefaultBillingAddress());
		
		//Mage::helper('paymentbase')->changeCustomerAddressOnPlattform($customer);
		
		$this->_validateBankdata();
		$mandate= $this->getMandate();
		
		$mandate->setTemplateId($this->getMandatePdfTemplateId());
		$mandate->setStoreId($this->getInfoInstance()->getQuote()->getStoreId());
		$date = Mage::app()->getLocale()->date()->toString('dd.MM.yyyy');
		$mandate->setDateSignedAsString($date);
		$mandate->setLocationSigned($mandate->getDebitorAddress()->getCity());
		$path = $this->getMandatePdfTemplateStore();
		$name = $this->getPdfMandateName();
		$mandate->saveAsPdf(sprintf('%s/%s', $path, $name));
		
		$this->_completeSepaMandate($mandate->getReference());
		
		/*
		 * Wenn alles OK ist alte Daten löschen
		 */
		Mage::helper('paymentbase')->unsAdditionalCustomerMandateData($customer,"change_mandate");
	}
	
	public function readMandate($_mandateReference)
	{
		$adaptee = $this->_getMandate($_mandateReference);
		if($adaptee)
		{
			$mandate = $this->_createNewAdapterMandate($adaptee);
			$this->_getReferencedInformation($mandate);
			return $mandate;
		}
		return null;
	}
}