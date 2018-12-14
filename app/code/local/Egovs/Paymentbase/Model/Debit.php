<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im Debit-Verfahren (Lastschrift).
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Debit extends Egovs_Paymentbase_Model_Abstract
{
	
	/**
     * Can use this payment method in administration panel?
     * 
     * @var boolean $_canUseInternal
     */
	protected $_canUseInternal = false;
	
	/**
	 * Encrypt data for mail
	 *
	 * @param string $data Daten
	 * 
	 * @return string
	 */
	protected function _emailEncrypt($data) {
		$l     = strlen($data);		// string length
		$l3    = substr($data,-3);	// last 3 values
		$rest  = $l - 3;
		$crypt = '';
		for ($i=1; $i<=$rest; $i++) {
			$crypt .= '*';
		}
		$crypt .= $l3;				// add plain text values to crypted value

		return $crypt;
	}
	
	/**
	 * Get the path of the file "bankleitzahlen.csv"
	 *
	 * @return  string
	 */
	protected function _getFilePath()
	{
		$f = dirname(__FILE__);			// Get the path of this file
		$f = substr($f, 0, -5);			// Remove the "Model" dir
		$f = $f.'etc/';					// Add the "etc" dir
		$f = $f.'bankleitzahlen.csv';	// Add the filename
		$f = str_replace("\\", "/", $f);	// change slashes

		//echo $f; exit;

		return $f;
	}
	
	/**
	 * Validiert die Bankverbindung des Kunden
	 * 
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>pruefenKontonummer</li>
	 * </ul>
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung $bankverbindung Bankverbindung
	 * 
	 * @return int ePayment Returncode
	 */
	protected function _ePaymentCheckBankData($bankverbindung) {		
		// Pruefung von Parametern
		if (!$this->_getMandantNr()
			|| !$this->_getBewirtschafterNr()
			|| !$this->_getWebShopDesMandanten()
			|| strlen($this->_getMandantNr()) <= 0
			|| strlen($this->_getBewirtschafterNr()) <= 0
			|| strlen($this->_getWebShopDesMandanten()) <= 0
			) {
			return '-9999';
		}
	
		$objResult = null;
		try {
			$objResult = $this->_getSoapClient()->pruefenKontonummer(
							$bankverbindung
						);
		} catch (Exception $e) {
			Mage::log(sprintf("%s in %s Line: %d", $e->getMessage(), $e->getFile(), $e->getLine()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::logException($e);
		}
		
		// wenn SOAP-Fehler
		if (!($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis)) {
			// dann Abbruch mit Fehler
			return '-999989';
		}
	
		return $objResult->ergebnis->getCode();
	}
	
	/**
	 * Liefert die zu sendenten Kontodaten für eine E-Mail im HTML Format
	 * 
	 * Folgende Kontodaten werden geliefert:<br>
	 * <ul>
	 * 	<li>Kontoinhaber</li>
	 * 	<li>Kontonummer</li>
	 * 	<li>Bankleitzahl (BLZ)</li>
	 * 	<li>(optional)Kreditinstitut</li>
	 * </ul>
	 * 
	 * @return string String mit HTML Tags
	 */
	public function getEmailSettings()
	{
		if ($this->getConfigData('sendmail')) {
			// send bank data via mail
			if ($this->getConfigData('sendmail_crypt')) {
				//encrypt bank data
			
				$return  = "<br />Kontoinhaber: ".$this->getAccountName();
				$return .= "<br />Kontonummer: ".$this->_emailEncrypt($this->getAccountNumber());
				$return .= "<br />Bankleitzahl: ".$this->_emailEncrypt($this->getAccountBLZ());
			} else {
				// do not encrypt bank data
			
				$return  = "<br />Kontoinhaber: ".$this->getAccountName();
				$return .= "<br />Kontonummer: ".$this->getAccountNumber();
				$return .= "<br />Bankleitzahl: ".$this->getAccountBLZ();
				$return .= "<br />Kreditinstitut: ".$this->getAccountBankname();
			}
			return $return;
		}
		return false;
	}
	
	/**
	 * Liefert den Inhaber des angegebenen Bankkontos
	 * 
	 * Der Kontoinhaber ist im 'cc_owner' Feld gespeichert.
	 * 
	 * @return String Kontoinhaber
	 */
	public function getAccountName()
	{
		$info = $this->getInfoInstance();
		return $info->getCcOwner();
	}
	
	/**
	 * Liefert die Kontonummer des angegebenen Bankkontos
	 * 
	 * Die Kontonummer ist im 'cc_number' Feld gespeichert
	 * 
	 * @return string Kontonummer
	 */
	public function getAccountNumber()
	{
		$info = $this->getInfoInstance();
		$return = $info->getCcNumberEnc();

		if (!is_numeric($return)) {
			$return = $this->decrypt($return);
		} elseif ($info->getCcNumber()) {
			$return = $info->getCcNumber();
		} else {
			$return = '';
		}

		return (string) $return;
	}
	
	/**
	 * Liefert die BLZ des angegebenen Bankkontos
	 * 
	 * Die BLZ ist im 'cc_type' Feld gespeichert.
	 * 
	 * @return string BLZ des Kunden
	 */
	public function getAccountBLZ()
	{
		//TODO 20110820 : Prüfen
		//TODO Funktioniert in DebitPIN nicht --> Daten sind nicht gespeichert!
		$info = $this->getInfoInstance();
		$return = $info->getCcType();

		if (!is_numeric($return)) {
			$return = '';
		}

		return (string) $return;
	}
	
	/**
	 * Liefert den entsprechenden Banknamen zur BLZ
	 *
	 * @return String Bankname
	 * @see Egovs_Debit_Model_Debit::getAccountBLZ
	 */
	public function getAccountBankname()
	{
		$info = $this->getInfoInstance();
		$blz  = $this->getAccountBLZ();
		$name = '';
		$file = $this->_getFilePath();

		// Open file
		$fp = fopen($file, 'rb');
		
		while ($data = fgetcsv($fp, 1024, ";")) {
			if ($data[0] == $blz) {
				$name = $data[1];
			}
		}

		if ($name == '')
			return 'existiert nicht';
		
		return $name;
	}
	
	/**
	 * Encrypt data
	 *
	 * @param string $data Daten
	 * 
	 * @return string
	 */
	public function encrypt($data)
	{
		if ($data) {
			return Mage::helper('core')->encrypt($data);
		}
		return $data;
	}

	/**
	 * Decrypt data
	 *
	 * @param string $data Daten
	 * 
	 * @return string
	 */
	public function decrypt($data)
	{
		if ($data) {
			return Mage::helper('core')->decrypt($data);
		}
		return $data;
	}
}