<?php
/**
 * Transaktions-Model
 *
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Transaction extends Mage_Core_Model_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		$this->_init('paymentbase/transaction');
	}
	
	/**
	 * Gibt das Erstelldatum des Objektes zurück.
	 * 
	 * Als Zeitzone wird des aktiven Stores verwendet
	 *
	 * @return Zend_Date
	 */
	public function getCreatedAtDate()
	{
		return Mage::app()->getLocale()->date(
				$this->_getResource()->mktime(($this->getCreatedAt())),
				null,
				null,
				true
		);
	}
	
	/**
	 * Gibt das Erstelldatum des Objektes zurück.
	 *
	 * Als Zeitzone wird des aktiven Stores verwendet
	 *
	 * @return Zend_Date
	 */
	public function getUpdatedAtDate()
	{
		return Mage::app()->getLocale()->date(
				$this->_getResource()->mktime(($this->getUpdatedAt())),
				null,
				null,
				true
		);
	}
}