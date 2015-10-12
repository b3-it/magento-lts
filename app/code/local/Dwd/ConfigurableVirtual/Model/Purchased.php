<?php
class Dwd_ConfigurableVirtual_Model_Purchased extends Mage_Core_Model_Abstract
{
	/**
	 * Initialize resource model
	 *
	 */
	protected function _construct()
	{
		$this->_init('configvirtual/purchased');
		parent::_construct();
	}
}