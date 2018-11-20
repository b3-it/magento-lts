<?php
class Bkg_VirtualAccess_Model_Purchased_Item extends Mage_Core_Model_Abstract
{
	/**
	 * Initialize resource model
	 *
	 */
	protected function _construct()
	{
		$this->_init('virtualaccess/purchased_item');
		parent::_construct();
	}
}