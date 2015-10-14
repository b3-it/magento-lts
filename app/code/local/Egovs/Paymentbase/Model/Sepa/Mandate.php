<?php
/**
 * Adaptiert ein ePayBL SEPA Mandat
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Sepa_Mandate
extends Egovs_Paymentbase_Model_Sepa_Mandate_Abstract
implements Egovs_Paymentbase_Model_Sepa_Mandate_Interface
{
	/**
	 * Erweitert den Kostruktor um die Angabe von AccountholderDiffers (accountOwnerDiffers)
	 * 
	 * @return void
	 * @see Egovs_Paymentbase_Model_Sepa_Mandate_Abstract::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		//Muss nach getAdapteeMandate aufgerufen werden!
		foreach ($this->getData() as $key => $value) {
			if ($key == 'accountholder_differs') {
				$this->getAdapteeMandate()->accountOwnerDiffers = $value;
				break;
			}
		}
	}
	
	/**
	 * Erstellt eine neue leere Adresse
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Adresse
	 */
	public static function createEmptyAddress() {
		return Mage::getModel('paymentbase/webservice_types_adresse');
	}
	/**
	 * Liefert eine leere Mandats-Instanz
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 * @see Egovs_Paymentbase_Model_SepaDebit::_createNewAdapteeMandate()
	 */
	protected function _createNewAdapteeMandateCustom() {
		return Mage::getModel('paymentbase/webservice_types_sepaMandat');
	}
	
	/**
	 * Erstellt eine neue Bankverbindung
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	protected function _createNewBankingAccount() {
		return Mage::getModel('paymentbase/webservice_types_bankverbindung');
	}
	
	/**
	 * Gibt das adaptierte Mandat zurück
	 *
	 * Falls dem Konstruktor kein Mandat übergeben wurde wird ein neues erstellt.
	 * Expiziten Return-Typ angegeben
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_SepaMandat
	 */
	public function getAdapteeMandate() {
		return parent::getAdapteeMandate();
	}
	
	public function setBankingAccount(Egovs_Paymentbase_Model_Sepa_Bankaccount $bankingAccount) {
		if (!$bankingAccount) {
			Mage::throwException("Argument banking account missing!");
		}
		
		$this->_bankingAccount = $bankingAccount;
		
		if ($this->getAccountholderDiffers()) {
			$this->getAdapteeMandate()->accountOwnerIban = $bankingAccount->getIban();
			$this->getAdapteeMandate()->accountOwnerBic = $bankingAccount->getBic();
		}
	
		return $this;
	}
	
	public function getBankingAccount() {
		if (!$this->_bankingAccount) {
			$this->_bankingAccount = self::createNewBankingAccount($this);
		}
		
		if ($this->getAccountholderDiffers()) {
			$this->_bankingAccount->setIban($this->getAdapteeMandate()->accountOwnerIban);
			$this->_bankingAccount->setBic($this->getAdapteeMandate()->accountOwnerBic);
		}
	
		return $this->_bankingAccount;
	}
	
	/**
	 * Gibt die Adresse des Kontoinhabers zurück
	 *
	 * Falls noch keine Adresse vorhanden ist, wird eine neue erzeugt
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
	 */
	public function getAccountholderAddress() {
		if ($this->hasData('accountholder_address')) {
			return $this->getData('accountholder_address');
		}
		
		if ($this->getAccountholderDiffers()) {
			$adaptee = $this->getAdapteeMandate();
			$address = self::createEmptyAddress();
			/* @var $address Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address */
			$includeHouseHumber = true;
			if (isset($adaptee->accountOwnerHousenumber) && !empty($adaptee->accountOwnerHousenumber)) {
				$hn = $adaptee->accountOwnerHousenumber;
				if (preg_match(sprintf('/%s$/i', $hn), $adaptee->accountOwnerStreet)) {
					$includeHouseHumber = false;
				}
			}
			$address->setStreet($adaptee->accountOwnerStreet);
			if ($includeHouseHumber) {
				$address->setHousenumber($adaptee->accountOwnerHousenumber);
			}
			$address->setCity($adaptee->accountOwnerCity);
			$address->setZip($adaptee->accountOwnerZip);
			$address->setCountry($adaptee->accountOwnerLand);
				
			$this->setData('accountholder_address', $address);
			return $address;
		}
	
		return self::createEmptyAddress();
	}
	
	/**
	 * Setzt die Adresse des Kontoinhabers
	 * 
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address Adresse
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	public function setAccountholderAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address) {
		if ($this->getAccountholderDiffers()) {
			$this->unsetData('accountholder_address');
			$adaptee = $this->getAdapteeMandate();
			$adaptee->accountOwnerStreet = $address->getStreet($address->getHousenumber() ? false : true);
			if (!$address->getHousenumber()) {
				$hn = mb_substr($adaptee->accountOwnerStreet, mb_strrpos($adaptee->accountOwnerStreet, " ")+1);
				if (!empty($hn)) {
					$adaptee->accountOwnerHousenumber = $hn;
				} else {
					$adaptee->accountOwnerHousenumber = "?";
				}
			} else {
				$adaptee->accountOwnerHousenumber = $address->getHousenumber();
			}
			$adaptee->accountOwnerCity = $address->getCity();
			$adaptee->accountOwnerLand = $address->getCountry();
			$adaptee->accountOwnerZip = $address->getZip();
		} else {
			$this->setData('accountholder_address', $address);
		}
		
		return $this;
	}
	
	public function getCreditorId() {
		return $this->getAdapteeMandate()->getCreditorId();
	}
	
	/**
	 * Gibt die Adresse des Debitors zurück
	 *
	 * Falls noch keine Adresse vorhanden ist, wird eine neue erzeugt
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
	 */
	public function getDebitorAddress() {
		if ($this->hasData('debitor_address')) {
			return $this->getData('debitor_address');
		}
	
		return self::createEmptyAddress();
	}
	
	public function setCreditorId($id) {
		$this->getAdapteeMandate()->setCreditorId($id);
		
		return $this;
	}
	
	/**
	 * Setzt die Adresse des Debitors
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address Adresse
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	public function setDebitorAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address) {
		$this->setData('debitor_address', $address);
	
		return $this;
	}
	
	public function getAccountholderName() {
		if ($this->getAccountholderDiffers()) {
			/*
			 * FIXME : Workaraound für ePayBL, da diese Name und Surname falsch auswertet
			 */
			return trim($this->getAdapteeMandate()->accountOwnerSurname);
		}
		
		return trim($this->getData('accountholder_name'));
	}
	
	public function setAccountholderName($name) {
		if ($this->getAccountholderDiffers()) {
			/*
			 * Längenprüfung wird für Felder in PDF-Formular benötigt!
			*/
			$length = $this->getAdapteeMandate()->getParamLength('accountOwnerSurname');
			//Ein Zeichen für Leerzeichen zwischen Vor- und Zuname abziehen
			//und ein weiteres da Vorname nicht leer sein darf!
			$length -= 2;
			$surname = $this->getAccountholderSurname();
			
			if (mb_strlen($surname, 'UTF-8') >= $length && !$this->getIsCompany()) {
				$name = " ";
			} else {
				$usedLength = mb_strlen($surname, 'UTF-8');
			
				if (mb_strlen($name, 'UTF-8') > 0 && !$this->getIsCompany()) {
					$availableLength = max(0, $length - $usedLength);
					$name = mb_substr($name, 0, $availableLength, 'UTF-8');
				}
			}
			
			/*
			 * FIXME : Workaraound für ePayBL, da diese Name und Surname falsch auswertet
			 */
			if (property_exists($this->getAdapteeMandate(), 'accountOwnerSurname')) {
				unset ($this->getAdapteeMandate()->accountOwnerSurname);
			}
			$this->getAdapteeMandate()->accountOwnerSurname = $name;
		} else {
			$this->setData('accountholder_name', $name);
			$this->setData('debitor_name', $name);
		}
		
		return $this;
	}
	
	/**
	 * Vorname des Kontoinhabers
	 * 
	 * @return string
	 * 
	 * @see Egovs_Paymentbase_Model_Sepa_Mandate_Abstract::getAccountholderSurname()
	 */
	public function getAccountholderSurname() {
		if ($this->getAccountholderDiffers()) {
			/*
			 * FIXME : Workaraound für ePayBL, da diese Name und Surname falsch auswertet
			*/
			return trim($this->getAdapteeMandate()->accountOwnerName);
		}
	
		return trim($this->getData('accountholder_surname'));
	}
	
	public function setAccountholderSurname($surname) {
		if ($this->getAccountholderDiffers()) {
			/*
			 * Längenprüfung wird für Felder in PDF-Formular benötigt!
			 */
			$length = $this->getAdapteeMandate()->getParamLength('accountOwnerSurname');
			//Ein Zeichen für Leerzeichen zwischen Vor- und Zuname abziehen
			//und ein weiteres da Vorname nicht leer sein darf!
			$length -= 2;
			if (mb_strlen($surname, 'UTF-8') >= $length) {
				if (mb_strlen($surname, 'UTF-8') > $length) {
					$msg = Mage::helper('paymentbase')->__('Account owner name is to long, you can not use more than 23 characters! Please edit your address information or use the checkbox for different account owner.');
					$ve = new Egovs_Paymentbase_Exception_Validation($msg);
					$ve->addMessage(Mage::getModel('core/message_error', $msg));
					throw $ve;
				}
				$surname = mb_substr($surname, 0, $length, 'UTF-8');
				
				if (!$this->getIsCompany()) {
					$this->setAccountholderName(" ");
				}
			} else {
				if (!$this->getIsCompany()) {
					$usedLength = mb_strlen($surname, 'UTF-8');
					$name = $this->getAccountholderName();
					if (mb_strlen($name, 'UTF-8') > 0) {
						$availableLength = max(0, $length - $usedLength);
						$name = mb_substr($name, 0, $availableLength, 'UTF-8');
						$this->setAccountholderName($name);
					}
				}
			}
			/*
			 * FIXME : Workaraound für ePayBL, da diese Name und Surname falsch auswertet
			 */
			if (property_exists($this->getAdapteeMandate(), 'accountOwnerName')) {
				unset ($this->getAdapteeMandate()->accountOwnerName);
			}
			$this->getAdapteeMandate()->accountOwnerName = $surname;
		} else {
			$this->setData('debitor_surname', $surname);
			$this->setData('accountholder_surname', $surname);
		}
	
		return $this;
	}
	
	public function setAccountholderBankname($bankname) {
		if ($this->getAccountholderDiffers()) {
			$this->getAdapteeMandate()->accountOwnerBankname = $bankname;
		}
		
		return $this;
	}
	
	public function getAccountholderBankname() {
		if ($this->getAccountholderDiffers()) {
			return $this->getAdapteeMandate()->accountOwnerBankname;
		}
	
		return null;
	}
	
	public function getDebitorName() {
		return $this->getData('debitor_name');
	}
	
	public function setDebitorName($name) {
		$this->setData('debitor_name', $name);
		return $this;
	}
	
	public function getDebitorSurname() {
		return $this->getData('debitor_surname');
	}
	
	public function getReference() {
		return $this->getAdapteeMandate()->getReference();
	}
	
	public function getSequenceType() {
		return $this->getAdapteeMandate()->getSequenceType();
	}
	
	public function getType() {
		return $this->getAdapteeMandate()->getType();
	}
	
	public function setDebitorSurname($name) {
		$this->setData('debitor_surname', $name);
		return $this;
	}
	
	public function setSequenceType($type) {
		$this->getAdapteeMandate()->setSequenceType($type);
		
		return $this;
	}
	
	public function setType($type) {
		$this->getAdapteeMandate()->setType($type);
	
		return $this;
	}
	
	public function getAccountholderDiffers() {
		//FIXME : accountOwnerDiffers wird beim laden von ePayBL nie gesetzt => liegt an ePayBL!!
		if (!isset($this->getAdapteeMandate()->accountOwnerDiffers) && !isset($this->getAdapteeMandate()->referenz)) {
			Mage::throwException("First, set accountOwnerDiffers before other properties can be set!");
		}
		
		return $this->getAdapteeMandate()->getAccountholderDiffers();
	}
	
	public function getAccountholderFullname() {
		if ($this->getAccountholderDiffers()) {
			return parent::getAccountholderFullname();
		}
		if ($this->getData('accountholder_name')) {
			return $this->getData('accountholder_name');
		}
		
		return '';
	}
	
	public function setAccountholderDiffers($differs) {
		$this->getAdapteeMandate()->setAccountholderDiffers($differs);
		
		if (!$differs) {
			$this->setAccountholderAddress(self::createEmptyAddress());
		}
		return $this;
	}
	
	public function saveAsPdf($path) {
		$ioObject = new Varien_Io_File();
		$ioObject->setAllowCreateFolders(true);
		$file = basename($path);
		//Separator bleibt am Ende erhalten
		$path = $ioObject->dirname($path);
		$ioObject->open(array('path' => $path));
		
		if ($ioObject->fileExists($file)) {
			if (!$ioObject->rm($file)) {
				$msg = Mage::helper('paymentbase')->__("Can't replace PDF mandate: %s", $file);
				Mage::helper('paymentbase')->sendMailToAdmin("paymentbase::".$msg);
				Mage::log('paymentbase::'.$msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				throw new Mage_Core_Exception(Mage::helper('paymentbase')->__($msg));
			}
		}
		/* @var $pdfMandate Egovs_Paymentbase_Model_Sepa_Mandate_Pdf */
		$pdfMandate = Mage::getModel('paymentbase/sepa_mandate_pdf');
		$pdfMandate->getPdf($this)->save($path.$file);
		
		return $this;
	}
	
	public function isMultiPayment() {
		return $this->getSequenceType() == Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF ? false : true;
	}
	
	public function getDateSignedAsString() {
		if (isset($this->getAdapteeMandate()->datumUnterschrift)) {
			$date = $this->getAdapteeMandate()->datumUnterschrift;
			return str_ireplace('.', '', $date);
		}
		
		return '';
	}
	
	public function getLocationSigned() {
		if (isset($this->getAdapteeMandate()->ortUnterschrift)) {
			return $this->getAdapteeMandate()->ortUnterschrift;
		}
		
		return '';
	}
	
	public function setLocationSigned($location) {
		$this->getAdapteeMandate()->ortUnterschrift = $location;
	}
	public function setDateSignedAsString($date) {
		$this->getAdapteeMandate()->datumUnterschrift = $date;
	}
}