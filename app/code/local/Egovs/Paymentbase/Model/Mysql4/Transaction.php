<?php
/**
 * Transaktions-Resource-Model
 *
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Transaction extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Primery key auto increment flag
	 *
	 * @var bool
	 */
	protected $_isPkAutoIncrement    = false;

	/**
	 * Resource initialization
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('paymentbase/transactions', 'bkz');
	}
	
	/**
	 * Daten zum Speichern vorbereiten
	 *
	 * @param Mage_Core_Model_Abstract $object Object
	 * 
	 * @return array
	 */
	protected function _prepareDataForSave(Mage_Core_Model_Abstract $object)
	{
		if ((!$object->getId() || $object->isObjectNew()) && !$object->getCreatedAt()) {
			$object->setCreatedAt(now());
		}
		$object->setUpdatedAt(now());
		return parent::_prepareDataForSave($object);
	}
}