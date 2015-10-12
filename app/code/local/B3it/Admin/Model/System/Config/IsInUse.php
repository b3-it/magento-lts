<?php
/**
 * Prüft ob noch OTPs genutzt werden
 * 
 * @category	B3it
 * @package		B3it_Admin
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class B3it_Admin_Model_System_Config_IsInUse extends Mage_Adminhtml_Model_System_Config_Backend_Encrypted
{
	/**
	 * Prüft ob Accounts OTP nutzen
	 * 
	 * @return void
	 * 
	 * @see Mage_Adminhtml_Model_System_Config_Backend_Encrypted::_beforeSave()
	 */
    protected function _beforeSave() {
        $value = $this->getValue();
        $oldValue = $this->getOldValue();

        if (empty($value) && !empty($oldValue)) {
        	/* @var $adminUsers Mage_Admin_Model_Resource_User_Collection */
        	$adminUsers = Mage::getResourceModel('admin/user_collection');
        	$adminUsers->addFieldToFilter('use_otp_token', '1');
        	if ($adminUsers->getSize() > 0) {
        		Mage::throwException(Mage::helper('b3itadmin')->__('Some accounts still use OTP authentication, first please deactivate the accounts with OTP authentication.'));
        	}
        }
        
        parent::_beforeSave();
    }
}
