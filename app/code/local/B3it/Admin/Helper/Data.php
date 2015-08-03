<?php
/**
 * Helper
 * 
 * @category	B3it
 * @package		B3it_Admin
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class B3it_Admin_Helper_Data extends Mage_Core_Helper_Data
{
	/**
	 * Unlock locked accounts
	 *
	 * @return int Anzahl entsperrter Accounts
	 */
	public function unlockLockedAccounts() {
	
		$maxFailed = Mage::getStoreConfig('admin/security/max_failed_logins');
		if ($maxFailed === false) {
			$maxFailed = 3;
		}
		/* @var $adminUsers Mage_Admin_Model_Resource_User_Collection */
		$adminUsers = Mage::getResourceModel('admin/user_collection');
		$utcDate = Mage::app()->getLocale()->utcDate(null, time(), true);
		$adminUsers->addFieldToFilter('failed_logins_count', array('gteq' => $maxFailed))
				->addFieldToFilter('is_active', 0)
				->addFieldToFilter('failed_last_login_date', array('lteq' => $utcDate))
		;
		$sql = $adminUsers->getSelect()->assemble();
		
		foreach ($adminUsers as $item) {
			$item->setIsActive(true);
		}
		$adminUsers->save();
		
		return $adminUsers->getSize();
	}
}