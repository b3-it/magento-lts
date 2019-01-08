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
		if ($observer->getUser() && $observer->getUser()->getId() > 0) {
			//Passwort wird sonst neu gehasht und überschrieben!!
			$observer->getUser()->setOrigData(null, $observer->getUser()->getData());
            /** @var B3it_Admin_Model_Resource_User $resource */
            $resource = Mage::getResourceModel('b3itadmin/user');
            $updateData = array();
			if ( !$observer->getResult() ) {
				$currentTime = Varien_Date::now();
				$fails = $observer->getUser()->getFailedLoginsCount() + 1;
				$observer->getUser()->setFailedLoginsCount(intval($fails));
				$observer->getUser()->setFailedLastLoginDate($currentTime);

				$updateData = array_merge($updateData, array('failed_logins_count', 'failed_last_login_date'));
				$maxFailed = Mage::getStoreConfig('admin/security/max_failed_logins');
				if ($maxFailed === false || !is_numeric($maxFailed)) {
					$maxFailed = 3;
				}
				if ($observer->getuser()->getIsActive() && $fails >= $maxFailed) {
                    $observer->getuser()->setIsActive(0);
                    $updateData[] = 'is_active';
				    $file = Mage::getStoreConfig('dev/log/exception_file');
					$msg = sprintf('permissions::warn: User with ID %s has been deactivated due to too many failed logins', $observer->getUser()->getId());
					Mage::log($msg, Zend_Log::WARN, $file, true);
					Mage::helper('b3itadmin')->sendMailToAdmin($msg, 'Security::User deactivated:');
				}
                $resource->saveAttributes($observer->getUser(), $updateData);

                $msg = sprintf('permissions:: Failed login for user with ID %s from IP %s', $observer->getUser()->getId(), Mage::app()->getFrontController()->getRequest()->getClientIp());
                Mage::log($msg, Zend_Log::ALERT, '', true);
                //Prevent DOS
                if ($fails > 25) {
                    include_once Mage::getBaseDir() . '/errors/503.php';
                    exit;
                }
			} else {
				$user = $observer->getUser();
				$user->setFailedLoginsCount(0);
                $updateData[] = 'failed_logins_count';
				$resource->saveAttributes($observer->getUser(), $updateData);

				if ($user && $user->getShowLoginInfo()) {
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
			}
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

	public function onAdminhtmlBlockHtmlBefore($observer) {
        if (!($observer->getBlock() instanceof Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Main)) {
            return;
        }
        /** @var Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Main $_userEditTabMain */
        $_userEditTabMain = $observer->getBlock();
        $form = $_userEditTabMain->getForm();
        if (!$form) {
            return;
        }
        /** @var Varien_Data_Form_Element_Fieldset $fieldset */
        $fieldset = $form->getElement('base_fieldset');
        if (!$fieldset) {
            return;
        }

        $_after = 'email';
        if ($form->getElement('phone')) {
            $_after = 'phone';
        }
        $fieldset->addField('show_login_info', 'select', array(
            'name'  => 'show_login_info',
            'label' => Mage::helper('b3itadmin')->__('Show login information'),
            'id'    => 'show_login_info',
            'title' => Mage::helper('b3itadmin')->__('Show login information'),
            'options'    => array('1' => Mage::helper('adminhtml')->__('Yes'), '0' => Mage::helper('adminhtml')->__('No')),
            ),
            $_after
        );

        $model = Mage::registry('permissions_user');
        $data = $model->getData();

        unset($data['password']);

        $form->setValues($data);
    }
}