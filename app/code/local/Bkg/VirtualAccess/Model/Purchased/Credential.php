<?php
class Bkg_VirtualAccess_Model_Purchased_Credential extends Mage_Core_Model_Abstract
{
	/**
	 * Initialize resource model
	 *
	 */
	protected function _construct()
	{
		$this->_init('virtualaccess/purchased_credential');
		parent::_construct();
	}

	public function createUuid()
    {
        $this->setUuid(Mage::helper('core')->getRandomString(10));
        return $this;
    }


}