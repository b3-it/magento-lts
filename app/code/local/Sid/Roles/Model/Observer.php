<?php

class Sid_Roles_Model_Observer extends Mage_Core_Model_Abstract
{
	public function onAdminUserSaveAfter($observer) {
		if ($post = Mage::app()->getRequest()->getPost()) {
			$user = $observer->getObject();
			$conn = Mage::getSingleton('core/resource')->getConnection('core_write');
			$conn->query('DELETE from sid_roles_customergroups WHERE user_id='.$user->getId());
			$user->setAllowAllCustomergroups($post['allow_all_customergroups']);
			if (isset($post['customergroups'])) {
				foreach ($post['customergroups'] as $key=>$value) {
					if (is_array($value)) {
						$roles = Mage::getModel('sidroles/customergroups');
						$roles->setUserId($user->getId());
						$roles->setCustomerGroupId($key);
						 
						if (isset($value['read'])) $roles->setRead(1);
						if (isset($value['write'])) $roles->setWrite(1);
						$roles->save();
					}
				}
			}

		}
	}
	 
	 
	public function onCustomerEditPrepareLayout($observer)
	{
		$user = Mage::getSingleton('admin/session')->getUser();
		if ($user->getAllowAllCustomergroups()) return $this;
		$user_id = $user->getId();
		$customer = $observer->getCustomer();
		 
		$model = Mage::getModel('sidroles/customergroups');
		 
		//neue Kunden erstmal zulassen
		if (!$customer->getId()) {
			if ($model->getCustomerGroupCountByUser($user_id) == 0) {
				$this->_redirect('*/customer');
				return;
			}
			return $this;
		}
		 
		$model->loadByCustomerGroup_User($customer->getGroupId(),$user_id);
		if (!$model->getRead()) {
			$this->_getSession()->addWarning(Mage::helper('sidroles')->__('Access denied you do not have sufficient privileges. Please contact your administrator.'));
			$this->_redirect('*/customer');

			return;
		}
		 
		if (!$model->getWrite()) {
			$block = $observer->getBlock();
			$block->removeButton('save');
			$block->removeButton('save_and_continue');
			$block->removeButton('delete');
		}
	}
	 
	public function onCustomerGroupEditPrepareLayout($observer)
	{
		$block = $observer->getBlock();
		if ($block instanceof Mage_Adminhtml_Block_Customer_Group_Edit) {
			$user = Mage::getSingleton('admin/session')->getUser();
			if ($user->getAllowAllCustomergroups()) return $this;
			$user_id = $user->getId();
			$group_id = Mage::registry('current_group')->getId();

			$model = Mage::getModel('sidroles/customergroups');

			//neue Kundengruppe erstmal zulassen
			if (!$group_id) {
				return $this;
			}

			$model->loadByCustomerGroup_User($group_id,$user_id);
			if (!$model->getRead()) {
				$this->_getSession()->addWarning(Mage::helper('sidroles')->__('Access denied you do not have sufficient privileges. Please contact your administrator.'));
				$this->_redirect('*/customer_group');
				 
				return;
			}

			if (!$model->getWrite()) {
				$block->removeButton('save');
				$block->removeButton('delete');
			}
		}
	}
	 
	protected function _redirect($path, $arguments=array()) {
		$ctr = Mage::app()->getFrontController()->getAction();
		$this->_getSession()->setIsUrlNotice($ctr->getFlag('', Mage_Adminhtml_Controller_Action::FLAG_IS_URLS_CHECKED));
		$ctr->getResponse()->setRedirect($ctr->getUrl($path, $arguments));
		/* 20131010::Frank Rochlitzer
		 * Ohne sendResponse und exit gehen Session-Messages verloren, da diese noch im aktuellen Aufruf verarbeitet werden!
		* see http://stackoverflow.com/questions/13251078/magento-losing-messages-after-redirect
		*/
		$ctr->getResponse()->sendResponse();
		exit;
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
		$block->addTabAfter('roles_customergroup', array(
				'label'     => Mage::helper('adminhtml')->__('Customer Groups'),
				'title'     => Mage::helper('adminhtml')->__('Customer Groups'),
				'content'   => $this->getLayout()->createBlock('sidroles/adminhtml_permissions_user_edit_tab_customergroups', 'user.customergroups.grid')->toHtml(),
			),
			'roles_section'
		);
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

	protected function _getSession() {
		return Mage::getSingleton('adminhtml/session');
	}

	protected function getResponse() {
		return Mage::app()->getResponse();
	}


}