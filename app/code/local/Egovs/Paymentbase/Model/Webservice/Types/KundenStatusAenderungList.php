<?php
/**
 * Klasse für KundenStatusAenderungList an der ePayBL 3.x
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property Egovs_Paymentbase_Model_Webservice_Types_Response_KundenStatusAenderung[] $kundenStatusAenderungList Array von KundenStatusAenderung-Objekten
 */
class Egovs_Paymentbase_Model_Webservice_Types_KundenStatusAenderungList
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param array $kundenStatusAenderungList Array von KundenStatusAenderung-Objekten
	 * 
	 * @return void
	 */
	public function __construct(
			$kundenStatusAenderungList = null
	) {
		Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		if (!is_array($kundenStatusAenderungList)) {
			$kundenStatusAenderungList = array($kundenStatusAenderungList);
		}
		$this->kundenStatusAenderungList = $kundenStatusAenderungList;
        
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
	 * Gibt ein Array von KundenStatusAenderung-Objekten zurück
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_KundenStatusAenderungList
	 */
	public function getKundenStatusAenderungList() {
		return $this->kundenStatusAenderungList;
	}
}