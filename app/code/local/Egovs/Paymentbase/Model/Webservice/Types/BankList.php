<?php
/**
 * Klasse für BankList an der ePayBL
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property Egovs_Paymentbase_Model_Webservice_Types_Bank  $bank Bank
 */
class Egovs_Paymentbase_Model_Webservice_Types_BankList
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Bank $bank Bank
	 * 
	 * @return void
	 */
	public function Egovs_Paymentbase_Model_Webservice_Types_BankList(
			$bank = null
	) {
		$args = func_get_args();
		Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		$this->bank = $bank;
        
        parent::Egovs_Paymentbase_Model_Webservice_Types_Abstract();
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
	
	public function getBank() {
		return $this->bank;
	}
}