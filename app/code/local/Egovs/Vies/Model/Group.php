<?php
class Egovs_Vies_Model_Group extends Mage_Core_Model_Abstract
{
	public function _construct() {
		parent::_construct();
		$this->_init('egovsvies/group');
	}
}