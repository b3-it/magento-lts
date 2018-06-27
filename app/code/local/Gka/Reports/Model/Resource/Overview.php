<?php

class Gka_Reports_Model_Resource_Overview extends Mage_Core_Model_Resource_Abstract
{
	/**
	 * Initialisierung mit eigenem Resource Model
	 *
	 * @return void
	 *
	 * @see Varien_Object::_construct()
	 */
 	protected function _construct() {
         $this->_init('gka_barkasse/kassenbuch_journal', 'id');
    }
}