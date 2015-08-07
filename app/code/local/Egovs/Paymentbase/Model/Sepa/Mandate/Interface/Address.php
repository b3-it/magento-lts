<?php
interface Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
{
	public function getCity();
	/**
	 * Gibt die Straße mit Hausnummer (optional) zurück
	 *
	 * Der Parameter $withHouseNr gibt nur an ob das Feld $hausNr zu Straße hinzugefügt werden soll.
	 *
	 * @param boolean $withHouseNr Straße mit oder ohne Hausnummer
	 *
	 * @return boolean
	 *
	 * @see Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address::getStreet()
	 */
	public function getStreet($withHouseNr = true);
	public function getHousenumber();
	public function getZip();
	public function getPostofficeBox();
	public function getCountry();
	
	public function setCity($city);
	public function setStreet($street);
	public function setHousenumber($number);
	public function setZip($zip);
	public function setPostofficeBox($pob);
	public function setCountry($country);
}