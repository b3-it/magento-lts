<?php
class Bkg_VirtualAccess_Model_Purchased extends Mage_Core_Model_Abstract
{
	/**
	 * Initialize resource model
	 *
	 */
	protected function _construct()
	{
		$this->_init('virtualaccess/purchased');
		parent::_construct();
	}
}