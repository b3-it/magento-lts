<?php
/**
 * Adaptiert ein ePayBL SEPA Mandat
 *
 * @category	Egovs
 * @package		Egovs_SepaDebitSax
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitSax_Model_Sepa_Mandate
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
	 * Gibt das adaptierte Mandat zurück
	 *
	 * Falls dem Konstruktor kein Mandat übergeben wurde wird ein neues erstellt.
	 * Expiziten Return-Typ angegeben
	 *
	 * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
	 */
	public function getAdapteeMandate() {
		return parent::getAdapteeMandate();
	}
	
	protected function _createNewAdapteeMandateCustom()
	{
		return Mage::getModel('sepadebitsax/webservice_types_mandat');
	}
	
	
	protected function _createNewBankingAccount()
	{
	
		return Mage::getModel('sepadebitsax/webservice_types_bankverbindung');
	}
	
	
	public function getReference() {
		return $this->getAdapteeMandate()->getReference();
	}
	
	public function isMultiPayment()
	{
		return $this->getAdapteeMandate()->isMultiPayment();
	}
	
	public function setCreditorId($id)
	{
		$this->getAdapteeMandate()->setCreditorId($id);
		return $this;
	}
	//public function setDateOfLastUsage($date);
	public function getCreditorId()
	{
		return $this->getAdapteeMandate()->getCreditorId();
	}
	
	
	//public function getDateOfLastUsage();
	public function setSequenceType($type)
	{
		$this->getAdapteeMandate()->setSequenceType($type);
		return $this;
	}
	
	public function getSequenceType()
	{
		return $this->getAdapteeMandate()->getSequenceType();
	}
	
	public function setStatus($status)
	{
		$this->getAdapteeMandate()->setMandateStatus($status);
		return $this;
	}
	
	public function getStatus()
	{
		return $this->getAdapteeMandate()->getMandatStatus();
	}
	
	public function setType($type)
	{
		return $this;
	}
	
	public function getType()
	{
		return $this->getAdapteeMandate()->getType();
	}
	
	
	public function setBankingAccount(Egovs_Paymentbase_Model_Sepa_Bankaccount $bankingAccount) {
		if (!$bankingAccount) {
			Mage::throwException("Argument banking account missing!");
		}
	
		$this->getAdapteeMandate()->setBankingAccount($bankingAccount);
	
		return $this;
	}
	
	public function getBankingAccount() {
		
		$ba = $this->getAdapteeMandate()->getBankingAccount();
		if(!$ba) 
		{
			$ba = $this->_createNewBankingAccount();
		}
		return $ba;
	}
	
	
	public function getAccountholderDiffers()
	{
		if (!isset($this->getAdapteeMandate()->DebitorIstKontoinhaber) && !isset($this->getAdapteeMandate()->Mandatsreferenz)) {
			Mage::throwException("First, set accountOwnerDiffers before other properties can be set!");
		}
		
		return $this->getAdapteeMandate()->getAccountholderDiffers();
	}
	
	public function setAccountholderDiffers($differs)
	{
		$this->getAdapteeMandate()->setAccountholderDiffers($differs);
		
		if (!$differs) {
			//$this->setAccountholderAddress(self::createEmptyAddress());
		}
		return $this;
	}
	
	public function getDateSignedAsString() {
		if (isset($this->getAdapteeMandate()->DatumUnterschrift)) {
			$date = $this->getAdapteeMandate()->DatumUnterschrift;
			return str_ireplace('.', '', $date);
		}
		
		return '';
	}
	
	public function getLocationSigned() {
		if (isset($this->getAdapteeMandate()->OrtUnterschrift)) {
			return $this->getAdapteeMandate()->OrtUnterschrift;
		}
		
		return '';
	}
	

	public function setLocationSigned($location) {
		$this->getAdapteeMandate()->OrtUnterschrift = $location;
	}
	
	
	public function setDateSignedAsString($date) {
		$this->getAdapteeMandate()->DatumUnterschrift = $date;
	}
	
	
	public function setAccountholderName($name)
	{
			if ($this->getAccountholderDiffers()) {
			$length = $this->getAdapteeMandate()->getParamLength('accountOwnerName');
			//Ein Zeichen für Leerzeichen zwischen Vor- und Zuname abziehen
			//und ein weiteres da Vorname nicht leer sein darf!
			$length -= 2;
			
			if (mb_strlen($name, 'UTF-8') >= $length) {
				if (mb_strlen($name, 'UTF-8') > $length) {
					$msg = Mage::helper('paymentbase')->__('Account owner name is to long, you can not use more than 23 characters! Please edit your address information or use the checkbox for different account owner.');
					$ve = new Egovs_Paymentbase_Exception_Validation($msg);
					$ve->addMessage(Mage::getModel('core/message_error', $msg));
					throw $ve;
				}
				$name = mb_substr($name, 0, $length, 'UTF-8');
				$this->getAdapteeMandate()->setAccountholderName(" ");
			} else {
				$usedLength = mb_strlen($name, 'UTF-8');
				$oname = $this->getAccountholderName();
				if (mb_strlen($oname, 'UTF-8') > 0) {
					$availableLength = max(0, $length - $usedLength);
					$oname = mb_substr($oname, 0, $availableLength, 'UTF-8');
					$this->getAdapteeMandate()->KontoinhaberName = $oname;
				}
			}
			
			$this->getAdapteeMandate()->KontoinhaberName = $name;
		} else {
			$this->getAdapteeMandate()->setDebitorName($name);
			//$this->setData('accountholder_name', $name);
			//$this->setData('debitor_name', $name);
		}
		
		return $this;
	}
	
	public function getAccountholderSurname() {
		if ($this->getAccountholderDiffers()) {
			return trim($this->getAdapteeMandate()->KontoinhaberName);
		}
	
		return trim($this->getAdapteeMandate()->getDebitorSurname());
	}
	
	public function getAccountholderName() {
		if ($this->getAccountholderDiffers()) {
			return trim($this->getAdapteeMandate()->KontoinhaberVorname);
		}
	
		return trim($this->getAdapteeMandate()->getDebitorName());
	}
	
	public function setAccountholderSurname($surname) {
		if ($this->getAccountholderDiffers()) {
			$length = $this->getAdapteeMandate()->getParamLength('accountOwnerName');
			//Ein Zeichen für Leerzeichen zwischen Vor- und Zuname abziehen
			//und ein weiteres da Vorname nicht leer sein darf!
			$length -= 2;
			$name = $this->getAccountholderSurname();
				
			if (mb_strlen($name, 'UTF-8') >= $length) {
				$surname = " ";
			} else {
				$usedLength = mb_strlen($name, 'UTF-8');
				
				if (mb_strlen($surname, 'UTF-8') > 0) {
					$availableLength = max(0, $length - $usedLength);
					$surname = mb_substr($surname, 0, $availableLength, 'UTF-8');
				}
			}
			
			/*
			if (property_exists($this->getAdapteeMandate(), 'accountOwnerSurname')) {
				unset ($this->getAdapteeMandate()->accountOwnerSurname);
			}
			*/
			$this->getAdapteeMandate()->KontoinhaberVorname = $surname;
		} else {
			$this->getAdapteeMandate()->setDebitorSurname($surname);
		}
	
		return $this;
	}
	
	
	public function getAccountholderAddress()
	{
		$adr = null;
		if ($this->getAccountholderDiffers()) 
		{
			$adr = $this->getAdapteeMandate()->getAccountholderAddress();
		}
		else 
		{
			$adr = $this->getAdapteeMandate()->getDebitorAddress();
		}
		
		if(!$adr)
		{
			$adr = $this->createEmptyAddress();
		}
		
		if(! $adr instanceof Egovs_Paymentbase_Model_Webservice_Types_Adresse )
		{
			$adr = new Egovs_SepaDebitSax_Model_Webservice_Types_Adresse($adr->Strasse,$adr->Plz,$adr->Stadt,$adr->Land,$adr->Postfach);
		}
		
		return $adr;
	}
	
	public function getKreditorGlaeubigerId()
	{
		return  $this->getAdapteeMandate()->KreditorGlaeubigerId;
	}
	
	
	
	public function setAccountholderAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address)
	{
			if ($this->getAccountholderDiffers()) {
			//$this->unsetData('accountholder_address');
			/*
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
			*/
			$this->getAdapteeMandate()->setAccountholderAddress($address);
				
		} else {
			$this->getAdapteeMandate()->setDebitorAddress($address);
		}
		
		return $this;
	}
	
	public function getDebitorAddress() {
		$adr = $this->getAdapteeMandate()->getDebitorAddress();
		
		if(! $adr instanceof Egovs_Paymentbase_Model_Webservice_Types_Adresse )
		{
			
			$adr = new Egovs_SepaDebitSax_Model_Webservice_Types_Adresse($adr->Strasse,$adr->Plz,$adr->Stadt,$adr->Land,$adr->Postfach);
		}
		
		if ($adr) {
			return $adr;
		}
	
		return self::createEmptyAddress();
	}
	
	public function getDebitorName() {
		//return $this->getData('debitor_name');
		return $this->getAdapteeMandate()->getDebitorName();
	}
	
	public function setDebitorName($name) {
		//$this->setData('debitor_name', $name);
		$this->getAdapteeMandate()->setDebitorName($name);
		return $this;
	}
	
	public function getDebitorSurname() {
		//return $this->getData('debitor_surname');
		return $this->getAdapteeMandate()->getDebitorSurname();
	}
	
	
	public function setCompanyRepresented($name)
	{
		$this->getAdapteeMandate()->setDebitorSurname($name);
		return $this;
	}
	

	public function setDebitorSurname($name) {
		//$this->setData('debitor_surname', $name);
		$this->getAdapteeMandate()->setDebitorSurname($name);
		return $this;
	}
	
	public function getAccountholderFullname() {
		if ($this->getAccountholderDiffers()) {
			return parent::getAccountholderFullname();
		}
		
		return $this->getDebitorFullname();
	
	}
	
	public function setDebitorAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address)
	{
		//$this->setData('debitor_address', $address);
		$this->getAdapteeMandate()->setDebitorAddress($address);
		return $this;
	}
	
	public static function createEmptyAddress()
	{
		return Mage::getModel('sepadebitsax/webservice_types_adresse');
	}
	
	public function saveAsPdf($path)
	{
		
	}
	
	public function importData($payment,  $CreditorId, $AllowOneof, $DebitorAddress)
	{
		$this->getAdapteeMandate()->importData($payment, $CreditorId, $AllowOneof);
	}
	
	public function convertToEPayBlMandate($EShopKundenNummer)
	{
		                
		//$glaubigerId = "DE17HKS00000032546";// $this->getCreditorId();
		//$glaubigerId = $this->getKreditorGlaeubigerId
		
		
		/* @var $res Egovs_Paymentbase_Model_Webservice_Types_SepaMandat */
		$res = Mage::getModel('paymentbase/webservice_types_sepaMandat');
		$res->abweichenderKontoinhaber = $this->getAccountholderDiffers() ? "true" : "false";
		$res->accountOwnerDiffers = $this->getAccountholderDiffers();
		$res->accountOwnerBankname = trim($this->getBankingAccount()->getBankname($this->getBankingAccount()->getBic()));
		if ($this->getBankingAccount()->getBic()) {
			$res->accountOwnerBic = $this->getBankingAccount()->getBic();
		}
		$res->accountOwnerCity = $this->getAccountholderAddress()->getCity();
		$res->accountOwnerHousenumber =  $this->getAccountholderAddress()->getHousenumber();
		$res->accountOwnerIban = $this->getBankingAccount()->getIban();
		$res->accountOwnerLand = $this->getAccountholderAddress()->getCountry();
		$res->accountOwnerName = $this->getAccountholderName();
		$res->accountOwnerSprache = "";
		$res->accountOwnerStreet = $this->getAccountholderAddress()->getStrasse();
		$res->accountOwnerSurname = $this->getAccountholderSurname();
		$res->accountOwnerZip = $this->getAccountholderAddress()->getZip();
		$res->aktiv = true;
		
		$res->amendment = null;
		
		//$res->betrag
		$res->bewirtschafterNr = Mage::helper('paymentbase')->getBewirtschafterNr();
		$res->cancellationDate =  Mage::app()->getLocale()->date()->toString(Zend_Date::ISO_8601);
		$res->creditorESignature = "";
		$res->dateOfLastUsage = Mage::app()->getLocale()->date()->toString(Zend_Date::ISO_8601);
		$res->datumUnterschrift = Mage::app()->getLocale()->date()->toString('dd.MM.yyyy');
		$res->eShopKundenNr = $EShopKundenNummer;
		$res->glaeubigerID =  $this->getKreditorGlaeubigerId();
		$res->frequency = 0;
		$res->land = $this->getAccountholderAddress()->getCountry();
		$res->ortUnterschrift = $this->getLocationSigned();
		//TODO Länge klären
		$res->referenz = $this->getReference();
		$res->sequenceType = $this->getSequenceType();
		$res->type = Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::TYPE_SDD_CORE_BASE;
		
	
		
		return $res;
		
	}
	
	public function canCreateNew()
	{
		$a = ($this->getStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GEKUENDIGT);
		$b = ($this->getStatus() == Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN);
		return $a || $b;
	}
	
	
	
	
	
	public function hasChanged($payment = null)
	{
		return $this->getAdapteeMandate()->hasChanged($payment);
	}
	
	
}