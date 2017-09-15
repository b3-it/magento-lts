<?php
/**
 * Gesperrte Accounts wieder freischalten
 * 
 * @category	B3it
 * @package		B3it_Admin
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class B3it_Admin_Model_System_Config_Runnow extends Mage_Core_Model_Config_Data
{
	/**
	 * Entsperrt Accounts bei true
	 * 
	 * @return B3it_Admin_Model_System_Config_Runnow
	 */
    protected function _beforeSave() {
        $value = $this->getValue();

        if ($value == true) {
        	switch ($this->getField()) {
        		case 'run_unlock':
        			try {
        				if (($unlocked = Mage::helper('b3itadmin')->unlockLockedAccounts()) > 0) {
        					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('b3itadmin')->__('Unlocked %s accounts'));
        				} else {
        					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('b3itadmin')->__("Nothing to unlock"));
        				}
        			} catch (Exception $e) {
        				Mage::logException($e);
        				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('b3itadmin')->__("Can't unlock accounts. Please check your log files."));
        			}
        			break;
        	}
        }

        //Am Ende muss es immer deaktiviert sein
        $this->setValue(false);
        return $this;
    }
}
