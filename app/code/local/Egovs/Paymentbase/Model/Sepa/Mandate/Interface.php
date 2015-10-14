<?php
/**
 * Interface für gemeinsam genutzte Methoden bei SEPA-Mandaten.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
interface Egovs_Paymentbase_Model_Sepa_Mandate_Interface
{
	/**
	 * Liefert die Mandatsreferenz
	 * 
	 * @return string
	 */
	public function getReference();
	
	/**
	 * Liefert das Deaktivierungsdatum
	 * 
	 * @return Zend_Date
	 */
	public function getCancellationDate();
	
	/**
	 * Gibt an ob das Mandat aktiv ist
	 * 
	 * @return bool
	 */
	public function isActive();
	/**
	 * Prüft ob das Mandat deaktiviert wurde
	 *
	 * @return boolean
	 */
	public function isCancelled();
	public function isMultiPayment();
	
	public function setCreditorId($id);
	public function setDateOfLastUsage($date);
	public function getCreditorId();
	public function getDateOfLastUsage();
	public function setSequenceType($type);
	public function getSequenceType();
	public function setType($type);
	public function getType();	
	public function getAccountholderDiffers();
	public function setAccountholderDiffers($differs);
	
	public function getLocationSigned();
	public function getDateSignedAsString();
	public function setLocationSigned($location);
	public function setDateSignedAsString($date);
	
	public function getAccountholderName();
	public function setAccountholderName($name);
	public function getAccountholderSurname();
	public function setAccountholderSurname($surname);
	public function getAccountholderFullname();
	/**
	 * Gibt die Adresse des Kontoinhabers zurück
	 *
	 * Falls noch keine Adresse vorhanden ist, wird eine neue erzeugt
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
	 */
	public function getAccountholderAddress();
	/**
	 * Setzt die Adresse des Kontoinhabers
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address Adresse
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	public function setAccountholderAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address);
		
	public function setBankingAccount(Egovs_Paymentbase_Model_Sepa_Bankaccount $bankingAccount);
	
	/**
	 * @return Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	public function getBankingAccount();
	
	public function getDebitorName();
	public function setDebitorName($name);	
	public function getDebitorSurname();	
	public function setDebitorSurname($name);
	public function getDebitorFullname();
	/**
	 * Gibt die Adresse des Debitors zurück
	 *
	 * Falls noch keine Adresse vorhanden ist, wird eine neue erzeugt
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
	 */
	public function getDebitorAddress();
	/**
	 * Setzt die Adresse des Debitors
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address Adresse
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface
	 */
	public function setDebitorAddress(Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $address);
	
	/**
	 * Vergleicht die Adresse des Debitors mit der des Kontoinhabers
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $debitorAddress       Debitor-Adresse
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address $accountholderAddress Kontoinhaber-Adresse
	 *
	 * @return boolean
	 */
	public function addressesEqual($debitorAddress = null, $accountholderAddress = null);
	/**
	 * Gibt das adaptierte Mandat zurück
	 *
	 * Falls dem Konstruktor kein Mandat übergeben wurde wird ein neues erstellt.
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
	 */
	public function getAdapteeMandate();
	
	public function setAdapteeMandate($_adapteeMandate);
	
	/**
	 * Erstellt eine neue Bankverbindung
	 *
	 * @param Egovs_Paymentbase_Model_Sepa_Mandate_Abstract $instance Instanz mit Erzeugungsmethode '_createNewBankingAccount()'
	 *
	 * @return Egovs_Paymentbase_Model_Sepa_Bankaccount
	 */
	public static function createNewBankingAccount($instance);
	
	/**
	 * Erstellt eine neue leere Adresse
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Adresse
	 */
	public static function createEmptyAddress();
	
	public function saveAsPdf($path);
}