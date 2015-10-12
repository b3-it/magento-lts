<?php
/**
 * Marker-Interface für Mandate der jeweiligen Webservcie-Klassen
 * 
 * @author Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 *
 */
interface Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
{
	/**
	 * Gibt an ob das Mandat aktiv ist
	 *
	 * @return boolean
	 */
	public function isActive();	
	public function getCancellationDate();
	public function getReference();	
	public function setCreditorId($id);
	public function getCreditorId();
	public function setSequenceType($type);
	public function getSequenceType();
	public function setType($type);
	public function getType();	
	public function getAccountholderDiffers();
	public function setAccountholderDiffers($differs);
}