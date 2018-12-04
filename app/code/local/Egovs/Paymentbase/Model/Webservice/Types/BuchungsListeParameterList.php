<?php
/**
 * Klasse für BuchungsListeParameterList an der ePayBL 3.x
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @property Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter[] $buchungslistenParameter Array von Buchungs-Listen-Parameter-Objekten
 */
class Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterList
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 *
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter[] $buchungslistenParameter Array von Buchungs-Listen-Parameter-Objekten
	 *
	 * @return void
	 */
	public function __construct(
			$buchungslistenParameter= null
        ) {
            Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

            if (!is_array($buchungslistenParameter)) {
                $buchungslistenParameter = array($buchungslistenParameter);
            }

            $this->buchungslistenParameter= $buchungslistenParameter;

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
	 * Array von Buchungslisten-Parametern
	 * @return Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter[]
	 */
	public function getBuchungslistenParameter() {
		return $this->buchungslistenParameter;
	}
	
	/**
	 * Prüft ob es Buchungslistenparameter gibt
	 *
	 * @return boolean
	 */
	public function isEmpty() {
		if (!isset($this->buchungslistenParameter) || empty($this->buchungslistenParameter)) {
			return true;
		}
		
		return false;
	}
}