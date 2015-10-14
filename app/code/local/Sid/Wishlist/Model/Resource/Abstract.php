<?php
/**
 * Model Resource-Abstract
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Sid_Wishlist_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
	 * Daten zu Speichern aufbereiten
	 *
	 * @param Mage_Core_Model_Abstract $object Object
	 * 
	 * @return array
	 */
	protected function _prepareDataForSave(Mage_Core_Model_Abstract $object) {
		$currentTime = Varien_Date::now();
		if ((!$object->getId() || $object->isObjectNew()) && !$object->getCreatedAt()) {
			$object->setCreatedAt($currentTime);
		}
		$object->setUpdatedAt($currentTime);
		$data = parent::_prepareDataForSave($object);
		return $data;
	}
}