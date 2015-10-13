<?php
/**
 * Wishlist Abstrakt-Model
 *
 * Stellt die Datumsverarbeitung bereit
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Sid_Wishlist_Model_Abstract extends Mage_Core_Model_Abstract
{
	/**
	 * Gibt die Object-Store-ID zurück
	 *
	 * @return int | string | Mage_Core_Model_Store
	 */
	abstract public function getStore();

	/**
	 * Verarbeitet das Objekt nach dem Speichern
	 *
	 * Update der relevanten Grid-Table-Einträge
	 *
	 * @return Mage_Core_Model_Abstract
	 */
	protected function _afterSave() {
		/* if (!$this->getForceUpdateGridRecords()) {
			$this->_getResource()->updateGridRecords($this->getId());
		} */
		return parent::_afterSave();
	}

	/**
	 * Gibt das Objekt-Erstelldatum in Abhängigkeit der aktiven Store Zeitzone zurück
	 *
	 * @return Zend_Date
	 */
	public function getCreatedAtDate() {
		return Mage::app()->getLocale()->date(
				Varien_Date::toTimestamp($this->getCreatedAt()),
				null,
				null,
				true
		);
	}

	/**
	 * Gibt das Objekt-Erstelldatum in Abhängigkeit der Store Zeitzone zurück
	 *
	 * @return Zend_Date
	 */
	public function getCreatedAtStoreDate() {
		return Mage::app()->getLocale()->storeDate(
				$this->getStore(),
				Varien_Date::toTimestamp($this->getCreatedAt()),
				true
		);
	}
}
