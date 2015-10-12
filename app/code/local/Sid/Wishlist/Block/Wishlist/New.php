<?php
/**
 * Merkzettel - Anlegen - Block
 * 
 * Dient zum Anlegen eines neuen Merkzettels
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Block_Wishlist_New extends Sid_Wishlist_Block_Wishlist_Abstract
{
	/**
	 * URL für POST Aktion
	 * 
	 * @return string
	 */
	public function getPostActionUrl() {
		return $this->getUrl('*/*/addPost', array('_secure'=>true));
	}
	
	/**
	 * URL für Zurück
	 * 
	 * @return string
	 */
	public function getBackUrl() {
		return $this->getUrl('*/*/backFromAddNew', array());
	}
	
	/**
	 * Prüft ob es ein Pflichtfeld ist
	 * 
	 * @param string $key Feldname
	 * 
	 * @return bool
	 */
	public function isFieldRequired($key) {
		if ($key == 'name') {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Liefert den HTML-Required Zusatzanteil
	 * 
	 * @param string $name Feldname
	 * 
	 * @return string
	 */
	public function getFieldRequiredHtml($name) {
		if ($this->isFieldRequired($name)) {
			return '<span class="required">*</span>';
		}
		return '';
	}
}