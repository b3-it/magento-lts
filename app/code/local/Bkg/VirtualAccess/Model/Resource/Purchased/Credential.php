<?php
class Bkg_VirtualAccess_Model_Resource_Purchased_Credential extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
	 * Initialize connection and define resource
	 *
	 */
	protected function _construct() {
		$this->_init('virtualaccess/purchased_credential', 'credential_id');
	}


}