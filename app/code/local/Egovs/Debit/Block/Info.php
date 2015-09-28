<?php

/**
 * Infoblock für Laschriftzahlungen
 *
 * Setzt eigene Templates
 *
 * @category   	Egovs
 * @package    	Egovs_Debit
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011-2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Info
 */
class Egovs_Debit_Block_Info extends Mage_Payment_Block_Info
{
	protected $_mask = true;
	
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Payment_Block_Info::_construct()
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('egovs/debit/info.phtml');
	}
	
	/**
	 * Liefert den Kontoinhaber
	 *
	 * @return string|boolean
	 */
	public function getAccountName() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $value;
		}
		return false;
	}
	
	/**
	 * Liefert die Kontonummer
	 *
	 * @return string|boolean
	 */
	public function getAccountNumber() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $this->_maskValue($value);
		}
		return false;
	}
	
	/**
	 * Liefert die BLZ
	 *
	 * @return string|boolean
	 */
	public function getAccountBLZ() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $this->_maskValue($value);;
		}
		return false;
	}
	
	/**
	 * Liefert den Banknamen
	 *
	 * @return string|boolean
	 */
	public function getAccountBankname() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $value;
		}
		return false;
	}
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return string
	 * 
	 * @see Mage_Payment_Block_Info::toPdf()
	 */
	public function toPdf()
	{
		$this->_mask = false;
		$this->setTemplate('egovs/debit/debit.phtml');
		$html = $this->toHtml();
		$this->_mask = true;
		return $html;
	}
	
	protected function _maskValue($value) {
		if (!is_string($value) || !$this->_mask) {
			return $value;
		}
		 
		if (strlen($value) > 4) {
			$_visible = 4;
		} else {
			$_visible = 1;
		}
		$_aS = str_split($value);
		for ($i = 0; $i < strlen($value) - $_visible; $i++) {
			$_aS[$i] = '*';
		}
		$value = implode('', $_aS);
		return $value;
	}
}
