<?php
/**
 * Abstrakte Klasse für SEPA Mandat
 * 
 * <h3>Sequence Typen</h3>
 * 	<p>Grundsätzlich muss in der SEPA Lastschriftdatei auch der Sequence Type des zu Grunde liegenden SEPA Lastschriftmandats in der richtigen Reihenfolge der Lastschrifteinzüge angegeben werden. Fehlangaben können zur Nichteinlösung oder Verhinderung von Folgeeinzügen führen.</p>
 *	<table width="614" cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; margin-left: -1.7pt;">
 *	    <tbody>
 *	        <tr>
 *	            <td width="161" valign="top" colspan="2" style="padding-bottom: 0cm; padding-left: 5.4pt; width: 120.5pt; padding-right: 5.4pt; padding-top: 0cm; border: #7ba0cd 1pt solid;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <strong><span style="font-family: 'Verdana','sans-serif'; color: #000066; font-size: 9pt;">Sequence Type</span></strong>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; border-top: #7ba0cd 1pt solid; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <strong><span style="font-family: 'Verdana','sans-serif'; color: #000066; font-size: 9pt;">Beschreibung</span></strong>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>FRST</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Erst</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>first dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Erster Einzug einer Lastschrift, bei der das vom Zahler (Zahlungspflichtigen) erteilte Mandat
 *	                    (Einzugsermächtigung) für regelmäßige, vom Zahlungsempfänger angewiesene Lastschriften genutzt wird.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 990</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>RCUR</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Folge</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>recurrent dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Folgelastschrift, bei der das vom Zahler (Zahlungspflichtigen) erteilte Mandat
 *	                    (Einzugsermächtigung) für regelmäßige, vom Zahlungsempfänger angewiesene Lastschriften genutzt wird.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 991</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>OOFF</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">Einmal</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">one-off dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Einmalige Lastschrift. Das vom Zahler (Zahlungspflichtigen) erteilte Einverständnis erfolgte für
 *	                    einen einzelnen Lastschrifteinzug.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 992</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>FNAL</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Letztmalige</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>final dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Durch das Kennzeichen verzichtet der Zahlungsempfänger auf den Einzug weiterer Lastschrift,
 *	                    dieses kommt faktisch (aber nicht rechtlich) einer Mandatskündigung gleich.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 993</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	    </tbody>
 *	</table>
 * <br/>
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Sepa_Mandate_Abstract
extends Varien_Object
{
	/**
	 * SEPA Mandat
	 * 
	 * @var Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	protected $_mandate = null;
	/**
	 * Bankverbindung für Mandat
	 * 
	 * @var Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	protected $_bankingAccount = null;
	
	/**
	 * Initialisiert diese Klasse
	 * 
	 * @return void
	 * @see Varien_Object::_construct()
	 */
	protected function _construct() {
		$this->getAdapteeMandate();
		parent::_construct();
	}
	
	public function __call($method, $args) {
		if ($this->getAdapteeMandate()) {
			switch (substr($method, 0, 3)) {
				case 'get' :
					$key = substr($method, 3);
					if (isset($this->_mandate->$key)) {
						return  $this->_mandate->$key;
					}
					$key = $this->_underscore($key);
					if (isset($this->_mandate->$key)) {
						return  $this->_mandate->$key;
					}
			}
			if (method_exists($this->_mandate, $method)) {
				return call_user_func(array($this->_mandate, $method), $args);
			}
		}
		return parent::__call($method, $args);
	}
	
	public function __get($var) {
		if ($this->getAdapteeMandate()) {
			if (isset($this->_mandate->$var)) {
				return  $this->_mandate->$var;
			}
		}
		return parent::__get($var);
	}
	
	/**
	 * Gibt das adaptierte Mandat zurück
	 * 
	 * Falls dem Konstruktor kein Mandat übergeben wurde wird ein neues erstellt.
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
	 */
	public function getAdapteeMandate() {
		if (is_null($this->_mandate) && isset($this->_data['mandate'])) {
			$this->_mandate = $this->_data['mandate'];
			$this->unsetData('mandate');
		} elseif (is_null($this->_mandate)) {
			foreach ($this->getData() as $key => $value) {
				if ($value instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee) {
					$this->_mandate = $value;
					$this->unsetData($key);
					return $this->_mandate;
				}
			}
			$this->_mandate = $this->_createNewAdapteeMandate();			
		}
		
		return $this->_mandate;
	}
	
	public function setAdapteeMandate($_adapteeMandate) {
		$this->_mandate = $_adapteeMandate;
		
		return $this;
	}
	
	/**
	 * Liefert eine leere Mandatsinstanz
	 *
	 * Die eigentliche Instanz muss in _getAdapteeMandateCustom() erstellt werden.
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
	 * @see Egovs_Paymentbase_Model_SepaDebit::_createNewAdapteeMandateCustom()
	 */
	protected final function _createNewAdapteeMandate() {
		$mandate = $this->_createNewAdapteeMandateCustom();
		if (!($mandate instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee)) {
			Mage::throwException('Mandate have to be instance of Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee');
		}
		return $mandate;
	}
	
	/**
	 * Liefert eine leere Mandats-Instanz
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 * @see Egovs_Paymentbase_Model_SepaDebit::_createNewAdapteeMandate()
	 */
	protected abstract function _createNewAdapteeMandateCustom();
	
	/**
	 * Prüft ob das Mandat deaktiviert wurde
	 *
	 * @return boolean
	 */
	public function isCancelled() {
		$date = $this->getCancellationDate();
		if (!$date) {
			return false;
		}
		//FIXME :: ePayBL setzt cancel Date direkt nach anlegen, vielleicht weil complete noch nicht aufgerufen wurde?
		if (!$this->isActive() && !$this->getDateOfLastUsage()) {
			return false;
		}
		
		$now = Mage::app()->getLocale()->date();
		$date = Mage::app()->getLocale()->date($date);
		if ($date->isLater($now)) {
			return false;
		}
		if ($this->isActive() && $date->isEarlier($now)) {
			return false;
		}
		if (!$this->isActive() && $date->isEarlier($now)) {
			return true;
		}
			
		Mage::throwException('The mandate is in an inconsistent state, please contact the ePayBL support and shop developers!');
	}
	
	/**
	 * Gibt an ob das Mandat aktiv ist
	 *
	 * @return boolean
	 */
	public function isActive() {
		return $this->getAdapteeMandate()->isActive() == true ? true : false;
	}
	
	public function getCancellationDate() {
		if (!$this->getAdapteeMandate()->getCancellationDate()) {
			return null;
		}
		$cancel = $this->getAdapteeMandate()->getCancellationDate();
		if ($cancel instanceof Zend_Date) {
			return $cancel;
		}
		if ($cancel instanceof SoapVar && isset($cancel->enc_value)) {
			return new Zend_Date($cancel->enc_value);
		}
	
		return null;
	}
	
	public function getDateOfLastUsage() {
		if (!$this->getAdapteeMandate()->dateOfLastUsage) {
			return null;
		}
		$date = $this->getAdapteeMandate()->dateOfLastUsage;
		if ($date instanceof Zend_Date) {
			return $date;
		}
		if ($date instanceof SoapVar && isset($date->enc_value)) {
			return new Zend_Date($date->enc_value);
		}
	
		return null;
	}
	
	public function setDateOfLastUsage($date) {
		$this->getAdapteeMandate()->dateOfLastUsage = $date;
		
		return $this;
	}
	
	
	
	public function importData($payment,  $CreditorId, $AllowOneof, $DebitorAddress)
	{
		/* @var $mandate Egovs_Paymentbase_Model_Sepa_Mandate_Interface */
		$this->setCreditorId($CreditorId);
		if ($AllowOneof && $payment->getAdditionalInformation('sequence_type') == Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF) {
			$this->setSequenceType(Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_OOFF);
		} else {
			$this->setSequenceType(Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_RCUR);
		}
		$this->setType($payment->getAdditionalInformation('mandate_type'));
		
		$infos = new Varien_Object($payment->getAdditionalInformation());
		if ($payment->getAdditionalInformation('custom_owner')) {
			//muss vor IBAN und BIC gesetzt werden
			$this->setAccountholderDiffers(true);
			$address = $this->getAccountholderAddress();
			$this->setAccountholderName($infos->getCustomAccountholderName());
			$this->setAccountholderSurname($infos->getCustomAccountholderSurname());
			
			$address->setStreet($infos->getCustomAccountholderStreet());
			$address->setHousenumber($infos->getCustomAccountholderHousenumber());
			$address->setCity($infos->getCustomAccountholderCity());
			$address->setZip($infos->getCustomAccountholderZip());
			$address->setCountry($infos->getCustomAccountholderLand());
				
			$this->setAccountholderAddress($address);
		} else {
			//muss vor IBAN und BIC gesetzt werden
			$this->setAccountholderDiffers(false);
		}
		
		$_authorisedSignatory = trim(mb_substr($infos->getAuthorisedSignatory(), 0, 100));
		if (empty($_authorisedSignatory) || mb_strlen($_authorisedSignatory) < 4) {
			throw new Egovs_Paymentbase_Exception_Validation(Mage::helper('paymentbase')->__('Authorised signatory is required.'));
		}
		$this->setAuthorisedSignatory($_authorisedSignatory);
		$this->setDebitorAddress($DebitorAddress);
		
		
		$ba = Egovs_Paymentbase_Model_Sepa_Mandate_Abstract::createNewBankingAccount($this);
		$ba->setIban($payment->getIban());
		$ba->setBic($payment->getBic());
		$this->setBankingAccount($ba);
		
		
	}
	
	
	/**
	 * Erstellt eine neue Bankverbindung oder gibt die aktuelle zurück 
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	public function getBankingAccount() {
		return null;
	}
	
	public function setBankingAccount(Egovs_Paymentbase_Model_Sepa_Bankaccount $bankingAccount) {
		return $this;
	}
	
	/**
	 * Erstellt eine neue Bankverbindung
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Abstract $instance Instanz mit Erzeugungsmethode '_createNewBankingAccount()'
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	public final static function createNewBankingAccount($instance) {
		$banking = $instance->_createNewBankingAccount();
		if (!($banking instanceof Egovs_Paymentbase_Model_Sepa_Bankaccount)) {
			Mage::throwException('Banking account must be type of Egovs_Paymentbase_Model_Sepa_Bankaccount');
		}
		return $banking;
	}
	
	/**
	 * Erstellt eine neue Bankverbindung
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	protected abstract function _createNewBankingAccount();
	
	/**
	 * Vergleicht die Adresse des Debitors mit der des Kontoinhabers
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $debitorAddress       Debitor-Adresse
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $accountholderAddress Kontoinhaber-Adresse
	 *
	 * @return boolean
	 */
	public function addressesEqual($debitorAddress = null, $accountholderAddress = null) {
		if (!$debitorAddress) {
			$debitorAddress = $this->getDebitorAddress();
		}
	
		if (!$accountholderAddress) {
			try {
				$accountholderAddress = $this->getAccountholderAddress();
			} catch (Exception $e) {
				$accountholderAddress = Mage::getModel('paymentbase/webservice_types_adresse');;
			}
		}
	
		if (strlen($debitorAddress->getZip()) + strlen($accountholderAddress->getZip()) < 1) {
			Mage::throwException('Debitor or accountholder address must be filled!');
		}
		if ($debitorAddress == $accountholderAddress) {
			return true;
		}
	
		if ($debitorAddress->getCountry() != $accountholderAddress->getCountry()) {
			return false;
		}
		if ($debitorAddress->getZip() != $accountholderAddress->getZip()) {
			return false;
		}
		if ($debitorAddress->getStreet() != $accountholderAddress->getStreet()) {
			if ($debitorAddress->getStreet() == "{$accountholderAddress->getStreet()} {$accountholderAddress->getHousenumber()}") {
				return true;
			}
			return false;
		}
		if ($debitorAddress->getHousenumber() != $accountholderAddress->getHousenumber()) {
			return false;
		}
	
		return true;
	}
	
	/**
	 * Gibt die Adresse des Kontoinhabers zurück
	 *
	 * Falls noch keine Adresse vorhanden ist, wird eine neue erzeugt
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
	 */
	public function getAccountholderAddress() {
		return null;
	}
	
	/**
	 * Gibt die Adresse des Debitors zurück
	 *
	 * Falls noch keine Adresse vorhanden ist, wird eine neue erzeugt
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
	 */
	public function getDebitorAddress() {
		return null;
	}
	
	public function getAccountholderFullname() {
		if ($this->getIsCompany()) {
			$name = $this->getCompany();
			if (empty($name)) {
				$name = $this->getAccountholderSurname();
			}
		} else {
			if (get_class($this) == 'Egovs_SepaDebitSax_Model_Sepa_Mandate') {
				$name = sprintf('%2$s %1$s', $this->getAccountholderName(), $this->getAccountholderSurname());
			} else {
				/*
				 * FIXME : Workaraound für ePayBL, da diese Name und Surname falsch auswertet
				 */
				$name = sprintf('%s %s', $this->getAccountholderName(), $this->getAccountholderSurname());
			}
		}
		return trim($name);
	}
	
	public function getAccountholderName() {
		return null;
	}
	public function getAccountholderSurname() {
		return null;
	}
	
	public function getDebitorFullname() {
		$name = sprintf('%s %s', $this->getDebitorName(), $this->getDebitorSurname());
		return trim($name);
	}
	
	public function getDebitorName() {
		return null;
	}
	public function getDebitorSurname() {
		return null;
	}
}