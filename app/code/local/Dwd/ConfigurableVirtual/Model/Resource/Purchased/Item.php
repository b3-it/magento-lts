<?php
class Dwd_ConfigurableVirtual_Model_Resource_Purchased_Item extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
	 * Initialize connection and define resource
	 *
	 */
	protected function _construct() {
		$this->_init('configvirtual/purchased_item', 'item_id');
	}
}