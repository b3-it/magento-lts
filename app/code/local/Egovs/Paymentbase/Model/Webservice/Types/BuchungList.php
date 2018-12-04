<?php
/**
 * Klasse für BuchungList an der ePayBL
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property Egovs_Paymentbase_Model_Webservice_Types_Buchung[]  $buchungen Array von Buchungs-Objekten
 */
class Egovs_Paymentbase_Model_Webservice_Types_BuchungList
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Buchung[]  $buchungen Array von Buchungs-Objekten
	 * 
	 * @return void
	 */
	public function __construct(
			$buchungen = null
	) {
		$args = func_get_args();
		Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		if (!is_array($buchungen)) {
			$buchungen = array($buchungen);
		}
		$this->buchungen = $buchungen;
        
        parent::__construct();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * @param string $name Parametername
	 *
	 * @return int
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::_getParamLength()
	 */
	protected function _getParamLength($name) {
		switch ($name) {
			default:
				$length = 0;
		}
		
		return $length;
	}
	
	/**
	 * Gibt die Liste der Buchungen zurück
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Buchung[]
	 */
	public function getBuchungen() {
		return $this->buchungen;
	}
}