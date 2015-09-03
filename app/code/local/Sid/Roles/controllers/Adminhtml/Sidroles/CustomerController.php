<?php

require_once 'Mage/Adminhtml/controllers/CustomerController.php';

class Sid_Roles_Adminhtml_Sidroles_CustomerController extends Mage_Adminhtml_CustomerController
{

	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('contract/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Customer'), Mage::helper('adminhtml')->__('Customer'));
		
		return $this;
	}   
 
	public function indexAction() {
		
		$this->_initAction()
			->renderLayout();
	}
	
	public function gridAction()
	{
		$this->getResponse()->setBody(
			$this->getLayout()->createBlock('sidroles/adminhtml_customer_grid')->toHtml()
		);
	}

	protected function _initCustomer($idFieldName = 'id')
	{
		$this->_title($this->__('Customers'))->_title($this->__('Manage Customers'));
	
		$customerId = (int) $this->getRequest()->getParam($idFieldName);
		$customer = Mage::getModel('customer/customer');
	
		if ($customerId) {
			$customer->load($customerId);
		}
	
		Mage::register('current_customer', $customer);
		return $this;
	}

	public function editAction()
	{
		$this->_initCustomer();
		$this->loadLayout();
	
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = Mage::registry('current_customer');
	
		// set entered data if was error when we do save
		$data = Mage::getSingleton('adminhtml/session')->getCustomerData(true);
	
		// restore data from SESSION
		if ($data) {
			$request = clone $this->getRequest();
			$request->setParams($data);
	
			if (isset($data['account'])) {
				/* @var $customerForm Mage_Customer_Model_Form */
				$customerForm = Mage::getModel('customer/form');
				$customerForm->setEntity($customer)
				->setFormCode('adminhtml_customer')
				->setIsAjaxRequest(true);
				$formData = $customerForm->extractData($request, 'account');
				$customerForm->restoreData($formData);
			}
	
			if (isset($data['address']) && is_array($data['address'])) {
				/* @var $addressForm Mage_Customer_Model_Form */
				$addressForm = Mage::getModel('customer/form');
				$addressForm->setFormCode('adminhtml_customer_address');
	
				foreach (array_keys($data['address']) as $addressId) {
					if ($addressId == '_template_') {
						continue;
					}
	
					$address = $customer->getAddressItemById($addressId);
					if (!$address) {
						$address = Mage::getModel('customer/address');
						$customer->addAddress($address);
					}
	
					$formData = $addressForm->setEntity($address)
					->extractData($request);
					$addressForm->restoreData($formData);
				}
			}
		}
		$this->_title($customer->getId() ? $customer->getName() : $this->__('New Customer'));
		
		/**
		 * Set active menu item
		*/
		$this->_setActiveMenu('customer/new');
		
		$this->renderLayout();
		} 
		
		public function newAction()
		{
			$this->_forward('edit');
		}
		
		protected function _isAllowed()
		{
			return Mage::getSingleton('admin/session')->isAllowed('customer/sid_manage_customer');
		}
		
		public function saveAction()
		{
			$data = $this->getRequest()->getPost();
			if ($data) {
				$redirectBack   = $this->getRequest()->getParam('back', false);
				$this->_initCustomer('customer_id');
		
				/* @var $customer Mage_Customer_Model_Customer */
				$customer = Mage::registry('current_customer');
		
				/* @var $customerForm Mage_Customer_Model_Form */
				$customerForm = Mage::getModel('customer/form');
				$customerForm->setEntity($customer)
				->setFormCode('adminhtml_customer')
				->ignoreInvisible(false)
				;
		
				$formData   = $customerForm->extractData($this->getRequest(), 'account');
				$errors     = $customerForm->validateData($formData);
				if ($errors !== true) {
					foreach ($errors as $error) {
						$this->_getSession()->addError($error);
					}
					$this->_getSession()->setCustomerData($data);
					$this->getResponse()->setRedirect($this->getUrl('adminhtml/sidroles_customer/edit', array('id' => $customer->getId())));
					return;
				}
		
				$customerForm->compactData($formData);
		
				// unset template data
				if (isset($data['address']['_template_'])) {
					unset($data['address']['_template_']);
				}
		
				$modifiedAddresses = array();
				if (!empty($data['address'])) {
					/* @var $addressForm Mage_Customer_Model_Form */
					$addressForm = Mage::getModel('customer/form');
					$addressForm->setFormCode('adminhtml_customer_address')->ignoreInvisible(false);
		
					foreach (array_keys($data['address']) as $index) {
						$address = $customer->getAddressItemById($index);
						if (!$address) {
							$address   = Mage::getModel('customer/address');
						}
		
						$requestScope = sprintf('address/%s', $index);
						$formData = $addressForm->setEntity($address)
						->extractData($this->getRequest(), $requestScope);
						$errors   = $addressForm->validateData($formData);
						if ($errors !== true) {
							foreach ($errors as $error) {
								$this->_getSession()->addError($error);
							}
							$this->_getSession()->setCustomerData($data);
							$this->getResponse()->setRedirect($this->getUrl('adminhtml/sidroles_customer/edit', array(
									'id' => $customer->getId())
							));
							return;
						}
		
						$addressForm->compactData($formData);
		
						// Set post_index for detect default billing and shipping addresses
						$address->setPostIndex($index);
		
						if ($address->getId()) {
							$modifiedAddresses[] = $address->getId();
						} else {
							$customer->addAddress($address);
						}
					}
				}
		
				// default billing and shipping
				if (isset($data['account']['default_billing'])) {
					$customer->setData('default_billing', $data['account']['default_billing']);
				}
				if (isset($data['account']['default_shipping'])) {
					$customer->setData('default_shipping', $data['account']['default_shipping']);
				}
				if (isset($data['account']['confirmation'])) {
					$customer->setData('confirmation', $data['account']['confirmation']);
				}
		
				// not modified customer addresses mark for delete
				foreach ($customer->getAddressesCollection() as $customerAddress) {
					if ($customerAddress->getId() && !in_array($customerAddress->getId(), $modifiedAddresses)) {
						$customerAddress->setData('_deleted', true);
					}
				}
		
				if (isset($data['subscription'])) {
					$customer->setIsSubscribed(true);
				} else {
					$customer->setIsSubscribed(false);
				}
		
				if (isset($data['account']['sendemail_store_id'])) {
					$customer->setSendemailStoreId($data['account']['sendemail_store_id']);
				}
		
				$isNewCustomer = $customer->isObjectNew();
				try {
					$sendPassToEmail = false;
					// force new customer active
					if ($isNewCustomer) {
						$customer->setPassword($data['account']['password']);
						$customer->setForceConfirmed(true);
						if ($customer->getPassword() == 'auto') {
							$sendPassToEmail = true;
							$customer->setPassword($customer->generatePassword());
						}
					}
		
					Mage::dispatchEvent('adminhtml_customer_prepare_save', array(
					'customer'  => $customer,
					'request'   => $this->getRequest()
					));
		
					$customer->save();
		
					// send welcome email
					if ($customer->getWebsiteId() && (isset($data['account']['sendemail']) || $sendPassToEmail)) {
						$storeId = $customer->getSendemailStoreId();
						if ($isNewCustomer) {
							$customer->sendNewAccountEmail('registered', '', $storeId);
						}
						// confirm not confirmed customer
						else if ((!$customer->getConfirmation())) {
							$customer->sendNewAccountEmail('confirmed', '', $storeId);
						}
					}
		
					if (!empty($data['account']['new_password'])) {
						$newPassword = $data['account']['new_password'];
						if ($newPassword == 'auto') {
							$newPassword = $customer->generatePassword();
						}
						$customer->changePassword($newPassword);
						$customer->sendPasswordReminderEmail();
					}
		
					Mage::getSingleton('adminhtml/session')->addSuccess(
					Mage::helper('adminhtml')->__('The customer has been saved.')
					);
					Mage::dispatchEvent('adminhtml_customer_save_after', array(
					'customer'  => $customer,
					'request'   => $this->getRequest()
					));
		
					if ($redirectBack) {
						$this->_redirect('*/*/edit', array(
								'id'    => $customer->getId(),
								'_current'=>true
						));
						return;
					}
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_getSession()->setCustomerData($data);
					$this->getResponse()->setRedirect($this->getUrl('adminhtml/sidroles_customer/edit', array('id' => $customer->getId())));
				} catch (Exception $e) {
					$this->_getSession()->addException($e,
							Mage::helper('adminhtml')->__('An error occurred while saving the customer.'));
					$this->_getSession()->setCustomerData($data);
					$this->getResponse()->setRedirect($this->getUrl('adminhtml/sidroles_customer/edit', array('id'=>$customer->getId())));
					return;
				}
			}
			$this->getResponse()->setRedirect($this->getUrl('adminhtml/sidroles_customer'));
		}
		
		
		public function deleteAction()
		{
			$this->_initCustomer();
			$customer = Mage::registry('current_customer');
			if ($customer->getId()) {
				try {
					$customer->load($customer->getId());
					$customer->delete();
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The customer has been deleted.'));
				}
				catch (Exception $e){
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				}
			}
			$this->getResponse()->setRedirect($this->getUrl('adminhtml/sidroles_customer'));
		}
		
		public function validateAction()
		{
			$response       = new Varien_Object();
			$response->setError(0);
			$websiteId      = Mage::app()->getStore()->getWebsiteId();
			$accountData    = $this->getRequest()->getPost('account');
		
			$customer = Mage::getModel('customer/customer');
			$customerId = $this->getRequest()->getParam('id');
			if ($customerId) {
				$customer->load($customerId);
				$websiteId = $customer->getWebsiteId();
			} else if (isset($accountData['website_id'])) {
				$websiteId = $accountData['website_id'];
			}
		
			/* @var $customerForm Mage_Customer_Model_Form */
			$customerForm = Mage::getModel('customer/form');
			$customerForm->setEntity($customer)
			->setFormCode('adminhtml_customer')
			->setIsAjaxRequest(true)
			->ignoreInvisible(false)
			;
		
			$data   = $customerForm->extractData($this->getRequest(), 'account');
			$errors = $customerForm->validateData($data);
			if ($errors !== true) {
				foreach ($errors as $error) {
					$this->_getSession()->addError($error);
				}
				$response->setError(1);
			}
		
			# additional validate email
			if (!$response->getError()) {
			# Trying to load customer with the same email and return error message
				# if customer with the same email address exisits
				$checkCustomer = Mage::getModel('customer/customer')
				->setWebsiteId($websiteId);
            $checkCustomer->loadByEmail($accountData['email']);
		            if ($checkCustomer->getId() && ($checkCustomer->getId() != $customer->getId())) {
		            $response->setError(1);
		            $this->_getSession()->addError(
		            Mage::helper('adminhtml')->__('Customer with the same email already exists.')
		            );
		            }
        }
		
        $addressesData = $this->getRequest()->getParam('address');
		            if (is_array($addressesData)) {
		            /* @var $addressForm Mage_Customer_Model_Form */
		            $addressForm = Mage::getModel('customer/form');
		            	$addressForm->setFormCode('adminhtml_customer_address')->ignoreInvisible(false);
		            	foreach (array_keys($addressesData) as $index) {
		            	if ($index == '_template_') {
		            	continue;
		            }
		            	$address = $customer->getAddressItemById($index);
		            	if (!$address) {
		            	$address   = Mage::getModel('customer/address');
		            }
		
		            $requestScope = sprintf('address/%s', $index);
		            $formData = $addressForm->setEntity($address)
		            ->extractData($this->getRequest(), $requestScope);
		
		            $errors = $addressForm->validateData($formData);
		            if ($errors !== true) {
		            foreach ($errors as $error) {
		            $this->_getSession()->addError($error);
		            }
		            $response->setError(1);
		            }
		            }
		            }
		
		            	if ($response->getError()) {
		            	$this->_initLayoutMessages('adminhtml/session');
		            	$response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
		}
		
		$this->getResponse()->setBody($response->toJson());
    }
		
}