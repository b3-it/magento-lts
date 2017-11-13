<?php
/**
 * Observer
 *
 * @category	B3it
 * @package		B3it_Admin
 * @author		René Mütterlein <r.muetterlein@b3-it.de>
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class B3it_Admin_Model_Observer
{
    /**
     *
     * @param Varien_Event_Observer $observer Observer
     */
    public function onAdminUserAuthenticateAfter($observer)
	{
		if ($observer->getUser()->getId() > 0) {
			//Passwort wird sonst neu gehasht und überschrieben!!
			$observer->getUser()->setOrigData(null, $observer->getUser()->getData());
			if ( !$observer->getResult() ) {
				$currentTime = Varien_Date::now();
				$fails = $observer->getUser()->getFailedLoginsCount() + 1;
				$observer->getUser()->setFailedLoginsCount($fails);
				$observer->getUser()->setFailedLastLoginDate($currentTime);
				$maxFailed = Mage::getStoreConfig('admin/security/max_failed_logins');
				if ($maxFailed === false) {
					$maxFailed = 3;
				}
				if ($fails >= $maxFailed) {
					$file = Mage::getStoreConfig('dev/log/exception_file');
					Mage::log(sprintf('permissions::warn: User with ID %s has been deactivated due to too many failed logins', $observer->getUser()->getId()), Zend_Log::WARN, $file, true);
					$observer->getuser()->setIsActive(0);
				}
			} else {
				$user = $observer->getUser();
				$user->setFailedLoginsCount(0);
				
				$text = 'Last Login: %s';
				$lastFailed = $user->getFailedLastLoginDate() ? Mage::app()->getLocale()->date($user->getFailedLastLoginDate()) : '';
				if (!empty($lastFailed)) {
					$text .= '<br/>Last Failed Login: %s';
				}
				Mage::getSingleton('adminhtml/session')->addNotice(
						Mage::helper('b3itadmin')->__(
							$text,
							Mage::app()->getLocale()->date($user->getLogdate()),
							$user->getFailedLastLoginDate() ? Mage::app()->getLocale()->date($user->getFailedLastLoginDate()) : ''
						)
				);
			}
			$observer->getUser()->save();
		}
	}
	
	/**
	 * Fügt den Yubico-Tab zum User-Bereich hinzu
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onLayoutRenderAdminhtmlPermissionsUserEditBefore($observer) {
		$block = $this->getLayout()->getBlock('left')->getChild('left.child0');
		
		if (!$block || !($block instanceof Mage_Adminhtml_Block_Permissions_User_Edit_Tabs)) {
			return;
		}
		/* @var $block Mage_Adminhtml_Block_Permissions_User_Edit_Tabs */
		if (!Mage::getStoreConfigFlag('admin/security/yubico_offical_servers')
			|| !Mage::getStoreConfig('admin/security/yubico_client_id')
			|| !Mage::getStoreConfig('admin/security/yubico_api_key')
		) {
			return;
		}
		$block->addTabAfter('yubico_section', array(
            'label'     => Mage::helper('adminhtml')->__('Yubico OTP Info'),
            'title'     => Mage::helper('adminhtml')->__('Yubico OTP  Info'),
            'content'   => $block->getLayout()->createBlock('b3itadmin/adminhtml_permissions_user_edit_tab_yubico', 'user.yubico')->toHtml(),
			),
			'roles_section'
        );
	}

	/**
	 *
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onLayoutRenderAdminhtmlPermissionsUserGridBefore($observer) {
		$block = $observer->getBlock();
		if (!$block || !($block instanceof Mage_Adminhtml_Block_Permissions_User_Grid) || $block->getNameInLayout() == 'permissions_user.grid') {
			return;
		}
		
		$this->_addExtendedInfoColumns($block);
		$block->sortColumnsByOrder();
	}
	
	/**
	 *
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onLayoutRenderAdminhtmlPermissionsUserIndexBefore($observer) {
		$block = $this->getLayout()->getBlock('content')->getChild('content.child0');
		
		if (!$block || !($block instanceof Mage_Adminhtml_Block_Permissions_User)) {
			return;
		}
		
		/* @var $grid Mage_Adminhtml_Block_Permissions_User_Grid */
		$grid = $block->getChild('grid');
		
		if (!$grid) {
			return;
		}
		
		$this->_addExtendedInfoColumns($grid);
	}
	
	/**
	 * 
	 * @param Mage_Adminhtml_Block_Permissions_User_Grid $grid
	 * @return Mage_Adminhtml_Block_Permissions_User_Grid
	 */
	protected function _addExtendedInfoColumns($grid) {
		$grid->addColumnAfter('logdate', array(
					'header'    => Mage::helper('b3itadmin')->__('Last Login'),
					'width'     => 40,
					'align'     => 'left',
					'index'     => 'logdate',
					'type'		=> 'datetime',
			), 'email'
		);
		
		$grid->addColumnAfter('failed_last_login_date', array(
					'header'    => Mage::helper('b3itadmin')->__('Last Failed Login'),
					'width'     => 40,
					'align'     => 'left',
					'index'     => 'failed_last_login_date',
					'type'		=> 'datetime',
			), 'logdate'
		);
		
		$grid->addColumnAfter('failed_logins_count', array(
					'header'    => Mage::helper('b3itadmin')->__('Failed Logins'),
					'width'     => 40,
					'index'     => 'failed_logins_count',
			), 'failed_last_login_date'
		);
		
		return $grid;
	}
	
	/**
	 * Unlock locked accounts
	 *
	 * @param Mage_Cron_Model_Schedule $schedule Schedule
	 *
	 * @return void
	 */
	public function unlockLockedAccounts($schedule) {
		
		Mage::helper('b3itadmin')->unlockLockedAccounts();
	}
	
	/**
	 * Retrieve current layout object
	 *
	 * @return Mage_Core_Model_Layout
	 */
	public function getLayout()
	{
		return Mage::getSingleton('core/layout');
	}
}