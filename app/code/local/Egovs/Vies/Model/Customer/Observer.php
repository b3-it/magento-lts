<?php
/**
 * Validiert die VAT - Nummer
 *
 * Diese Klasse kapselt die Methoden für Aufrufe die von Events ausgelöst wurden.
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Model_Customer_Observer extends Mage_Customer_Model_Observer
{
	protected $_lastOrigAddress = null;
	

	protected function _isBaseAdress($address) {
		return ($address->getId() && $address->getId() == $address->getCustomer()->getBaseAddress())
			|| $address->getIsDefaultBaseAddress();
	}
	
	/**
	 * Check whether specified address should be processed in after_save event handler
	 *
	 * @param Mage_Customer_Model_Address $address
	 * @return bool
	 */
	protected function _canProcessAddress($address)
	{
		if ($address->getForceProcess()) {
			return true;
		}
	
		if (Mage::registry(self::VIV_CURRENTLY_SAVED_ADDRESS) != $address->getId()) {
			return false;
		}
	
		return $this->_isBaseAdress($address);
	}
	
	protected function _getGroupIdByCustomerGroupRules($data) {
		$ruleSet = Mage::getModel('customer/group')->getCollection()
			->addOrder('taxvat', Varien_Data_Collection_Db::SORT_ORDER_ASC)
			->getItems()
		;
		$rules = array(
				'company', 'taxvat'
		);
		foreach ($ruleSet as $id => $rule) {
			$ruleMatches = true;
			foreach ($rules as $ruleName) {
				$validate = null;
				switch (strtolower($ruleName)) {
					case 'priority':
						continue 2;
					case 'company':
						//type cast geht sonst nicht
						$validate = ((bool)((int) $rule->getData($ruleName)));
						break;
					case 'taxvat':
						$validate = ((int) $rule->getData($ruleName));
						break;
					default :
						$validate = false;//((bool)((int) $rule->$ruleName));
				}
		
				if (array_key_exists($ruleName, $data) && $validate === true) {
					if (empty($data[$ruleName])) {
						$ruleMatches = false;
						break;
					}
				} elseif (!array_key_exists($ruleName, $data) && $validate === true) {
					$ruleMatches = false;
					break;
				} elseif (array_key_exists($ruleName, $data) && $validate == false) {
					if (!empty($data[$ruleName])) {
						$ruleMatches = false;
						break;
					}
				}
			}
				
			if ($ruleMatches) {
				//VAT Validierung findet schon bei der Eingabe statt, muss hier trotzdem erneut erfolgen falls USt.ID gelöscht wird.
				//Die Validierung der VAT bei der Eingabe schließt die Validerierung von VAT zu Land mit ein!
				if ($rule->getTaxvat() == 1) {
					if ($data->getTaxvatValid() != true) {
						continue;
					}
				}
				$groupToCountry = Mage::getModel('egovsvies/group')->load(
						isset($data['country_id']) ?
						sprintf(
								'%s%s%s',
								$data['country_id'],
								$rule->getCompany(),
								$rule->getTaxvat()
						) : null
				);
		
				if ($groupToCountry && !$groupToCountry->isEmpty()) {
					if ($rule->getId() == $groupToCountry->getCustomerGroupId()) {
						return $rule->getId();
					}
				}
			}
		}
		
		return null;
	}
	
	/**
	 * Address before save event handler
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function beforeAddressSave($observer)
	{
		if (Mage::registry(self::VIV_CURRENTLY_SAVED_ADDRESS)) {
			Mage::unregister(self::VIV_CURRENTLY_SAVED_ADDRESS);
		}
	
		/** @var $customerAddress Mage_Customer_Model_Address */
		$customerAddress = $observer->getCustomerAddress();
		if ($customerAddress->getId()) {
			Mage::register(self::VIV_CURRENTLY_SAVED_ADDRESS, $customerAddress->getId());
		} else {
			$configAddressType = Mage::helper('customer/address')->getTaxCalculationAddressType();
	
			$forceProcess = true;
			if (!$this->_isBaseAdress($customerAddress)) {
				$forceProcess = ($configAddressType == Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING)
					? $customerAddress->getIsDefaultShipping() : $customerAddress->getIsDefaultBilling();
			}
	
			if ($forceProcess) {
				$customerAddress->setForceProcess(true);
			} else {
				Mage::register(self::VIV_CURRENTLY_SAVED_ADDRESS, 'new_address');
			}
		}
	}
	
	/**
	 * Address after save event handler
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function afterAddressSave($observer)
	{
		/** @var $customerAddress Mage_Customer_Model_Address */
		$customerAddress = $observer->getCustomerAddress();
		$customer = $customerAddress->getCustomer();
	
		if (!Mage::helper('customer/address')->isVatValidationEnabled($customer->getStore())
				|| Mage::registry(self::VIV_PROCESSED_FLAG)
				|| !$this->_canProcessAddress($customerAddress)
		) {
			return;
		}
	
		try {
			Mage::register(self::VIV_PROCESSED_FLAG, true);
	
			/** @var $customerHelper Mage_Customer_Helper_Data */
			$customerHelper = Mage::helper('customer');
	
			if ($customerAddress->getVatId() == ''
					|| !Mage::helper('core')->isCountryInEU($customerAddress->getCountry()))
			{
				$data = $customerAddress->getData();
				$ruleGroupId = $this->_getGroupIdByCustomerGroupRules($data);
				//Falls nichts gematched hat!!!
				if (!$ruleGroupId) {
					$ruleGroupId = $customerHelper->getDefaultCustomerGroupId($customer->getStore());
				}
				if (!$customer->getDisableAutoGroupChange() && $customer->getGroupId() != $ruleGroupId) {
					$customer->setGroupId($ruleGroupId);
					$customer->save();
				}
			} else {
	
				$result = $customerHelper->checkVatNumber(
						$customerAddress->getCountryId(),
						$customerAddress->getVatId()
				);
	
				$newGroupId = $customerHelper->getCustomerGroupIdBasedOnVatNumber(
						$customerAddress->getCountryId(), $result, $customer->getStore()
				);
	
				if (!$customer->getDisableAutoGroupChange() && $customer->getGroupId() != $newGroupId) {
					$customer->setGroupId($newGroupId);
					$customer->save();
				}
	
				if (!Mage::app()->getStore()->isAdmin()) {
					$validationMessage = Mage::helper('customer')->getVatValidationUserMessage($customerAddress,
							$customer->getDisableAutoGroupChange(), $result);
	
					if (!$validationMessage->getIsError()) {
						Mage::getSingleton('customer/session')->addSuccess($validationMessage->getMessage());
					} else {
						Mage::getSingleton('customer/session')->addError($validationMessage->getMessage());
					}
				}
			}
		} catch (Exception $e) {
			Mage::register(self::VIV_PROCESSED_FLAG, false, true);
		}
	}
	
	/**
	 * Validiert die VAT des Kunden
	 *  
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function validateVat($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
		
		if (!$customer || $customer->isEmpty()) {
			return;
		}
		
		if (($customer->hasData('taxvat_valid') && $customer->getTaxvatValid() == true)
			) {
			return;
		}
		
		$useBilling = false;
		
		$address = $customer->getAddressById($customer->getBaseAddress());
		if (!$address || $address->isEmpty()) {
			/*
			$taxVat = trim($customer->getTaxvat());
			if (empty($taxVat)) {
				return;
			}
			*/
			$billingAddress = $customer->getDefaultBillingAddress();
			if (!$billingAddress || $billingAddress->isEmpty()) {
				$addresses = $customer->getAddresses();
				if (!isset($addresses[0])) {
					return;
				}
			
				$billingAddress = $addresses[0];
			}
			$address = $billingAddress;
			$useBilling = true;
		}
		$taxVat = $address->getTaxvat();
		
		if (empty($taxVat)) {
			return;
		}
		if ($address->getTaxvatValid()) {
			if (!$customer->hasData('taxvat_valid')) {
				$customer->setTaxvatValid(true);
			}
			return;
		}
		
		$origCountryId = null;
		if (is_array($address)) {
			$data = $address;
		} elseif ($address instanceof Mage_Customer_Model_Address) {
			/*
			 * #1452, ZVM742
			 * billingAddress ist hier schon gespeichert worden und man kann nicht mehr zwischen data und origdata unterscheiden.
			 */
			$data = $address->getData();
			$existsAddress = $this->_lastOrigAddress;
			if ($existsAddress && $existsAddress->getId() && $existsAddress->getParentId() == $customer->getId()) {
				$origCountryId = $existsAddress->getCountryId();
			} else {
				$origCountryId = $address->getOrigData('country_id');
			}
		} else {
			$data = array();
		}
		$countryId = isset($data['country_id']) ? $data['country_id'] : null;
		
		/*
		 * 20130123::Frank Rochlitzer
		* Validierung auslassen falls sich Taxvat, Land und Default Billing nicht geändert haben
		*/
		$origTaxVat = $address->getOrigData('taxvat');
		if ($origTaxVat === $taxVat
			&& $countryId === $origCountryId 
			&& ($customer->getBaseAddress() === $customer->getOrigData('base_address')
					|| ($useBilling && $customer->getDefaultBilling() === $customer->getOrigData('default_billing'))
			)) {
			$customer->setTaxvatValid(true);
			return;
		}
		
		/* @var $vatService Egovs_Vies_Model_Webservice_CheckVatService */
		$vatService = Mage::getModel('egovsvies/webservice_checkVatService');
		
		if (!$vatService)
			return;
		
		$result = $vatService->checkVatBy($taxVat);
		
		if ($result instanceof Egovs_Vies_Model_Webservice_Types_CheckVatResponse && $result->isValid()) {
			$errors = array();
			$result->validateWith($data, $errors);
			
			if (count($errors) < 1) {
				if (isset($data['taxvat_valid'])) {
					$customer->setData('taxvat_valid', true);
				}
				return;
			}
			
			Mage::throwException(implode(' ', $errors));
			return;
		} elseif ($result instanceof Egovs_Vies_Model_Webservice_Types_CheckVatResponse
					&& $result->isCountryNotSupported()
			) {
			Mage::getSingleton('catalog/session')->addNotice(Mage::helper('egovsvies')->__('Country not supported for automatic VAT validation.'));
			$customer->setData('taxvat_valid', true);
			return;
		} elseif ($result instanceof Egovs_Vies_Model_Webservice_Types_CheckVatResponse
					&& $result->hasSoapFault()
					&& $result->getValid() >= Egovs_Vies_Model_Webservice_CheckVatService::UNKNOWN_ERROR
			) {
			Mage::log(sprintf('egovsvies::%s', $result->getSoapFault()->getMessage()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::throwException(Mage::helper('egovsvies')->__("Can't validate entered VAT number, an internal error occured."));
		}
		
		Mage::throwException(Mage::helper('egovsvies')->__('The entered VAT number ist not valid!'));
	}
	
	/**
	 * VAT an Adresse validieren
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return void
	 */
	public function validateVatAddress($observer) {
		/* @var $address Mage_Customer_Model_Address */
		$address = $observer->getCustomerAddress();
		if (!$address || !$address->getTaxvat() || $address->getTaxvatValid()) {
			return;
		}
		
		$data = $address->getData();
		$origData = $address->getOrigData();
		
		$taxVat = isset($data['taxvat']) ? $data['taxvat'] : null;
		$origTaxVat = isset($origData['taxvat']) ? $origData['taxvat'] : null;
		$countryId = isset($data['country_id']) ? $data['country_id'] : null;
		$origCountryId = isset($origData['country_id']) ? $origData['country_id'] : null;
		$entityId = isset($data['entity_id']) ? $data['entity_id'] : null;
		$origEntityId = isset($origData['entity_id']) ? $origData['entity_id'] : null;
		if ($origTaxVat === $taxVat
			&& $countryId === $origCountryId
			&& $entityId === $origEntityId
		) {
			$address->setTaxvatValid(true);
			return;
		}
		
		/* @var $vatService Egovs_Vies_Model_Webservice_CheckVatService */
		$vatService = Mage::getModel('egovsvies/webservice_checkVatService');
		
		if (!$vatService)
			return;
		
		$result = $vatService->checkVatBy($taxVat);
		
		if ($result instanceof Egovs_Vies_Model_Webservice_Types_CheckVatResponse && $result->isValid()) {
			$errors = array();
			$result->validateWith($data, $errors);
				
			if (count($errors) < 1) {
				if (isset($data['taxvat_valid'])) {
					$address->setData('taxvat_valid', true);
				}
				return;
			}
				
			Mage::throwException(implode(' ', $errors));
			return;
		} elseif ($result instanceof Egovs_Vies_Model_Webservice_Types_CheckVatResponse
				&& $result->isCountryNotSupported()
		) {
			Mage::getSingleton('catalog/session')->addNotice(Mage::helper('egovsvies')->__('Country not supported for automatic VAT validation.'));
			$address->setData('taxvat_valid', true);
			return;
		} elseif ($result instanceof Egovs_Vies_Model_Webservice_Types_CheckVatResponse
				&& $result->hasSoapFault()
				&& $result->getValid() >= Egovs_Vies_Model_Webservice_CheckVatService::UNKNOWN_ERROR
		) {
			Mage::log(sprintf('egovsvies::%s', $result->getSoapFault()->getMessage()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::throwException(Mage::helper('egovsvies')->__("Can't validate entered VAT number, an internal error occured."));
		}
		
		Mage::throwException(Mage::helper('egovsvies')->__('The entered VAT number ist not valid!'));
	}
	
	/**
	 * Wird vor der Anzeige des Kundengruppenkonfigurations-Blocks aufgerufen
	 *
	 * @param Varien_Object $observer Observer
	 *
	 * @return void
	 */
	public function afterCustomerGroupEditFormPrepare($observer) {
		$block = $observer->getBlock();
		if (!($block instanceof Mage_Adminhtml_Block_Customer_Group_Edit_Form)) {
			return;
		}
		
		$customerGroup = Mage::registry('current_group');
		
		if (!$customerGroup || $customerGroup->isEmpty()) {
			return;
		}
		
		$form = $block->getForm();
		$fieldset = $form->addFieldset('autoassign_country_fieldset', array('legend'=> Mage::helper('egovsvies')->__('Settings for group auto assignment')));
		
		/* @var $assignedCountries Egovs_Vies_Model_Autoassign */
		$assignedCountries = Mage::getSingleton('egovsvies/autoassign');
		if (!$assignedCountries || $assignedCountries == null) {
			return;
		}
		
		$fieldset->addField('company', 'select',
				array(
						'name'  => 'company',
						'label' => Mage::helper('egovsvies')->__('Is for company'),
						'title' => Mage::helper('egovsvies')->__('Is for company'),
						'class' => 'required-entry',
						'required' => true,
						'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray()
				)
		);
		
		$fieldset->addField('taxvat', 'select',
				array(
						'name'  => 'taxvat',
						'label' => Mage::helper('egovsvies')->__('Is VAT required'),
						'title' => Mage::helper('egovsvies')->__('Is VAT required'),
						'class' => 'required-entry',
						'required' => true,
						'values' => Mage::getModel('egovsvies/adminhtml_system_config_source_yesnocustom')->toOptionArray()
				)
		);
		
		$availableCountries = Mage::getSingleton('adminhtml/system_config_source_country')->toOptionArray(true);
		foreach ($availableCountries as $key => $countryOption) {
			if (!Mage::helper('core')->isCountryInEU($countryOption['value'])) {
				continue;
			}
			
			unset($availableCountries[$key]);
		}
		$availableCountries = array_merge(array(array('value' => 'EU', 'label' => Mage::helper('egovsvies')->__('European Union'))), $availableCountries);
		$selectedCountries = $assignedCountries->getSelectedCountriesArray($customerGroup);
		$selectEu = false;
		foreach ($selectedCountries as $key => $countryOption) {
			if (!Mage::helper('core')->isCountryInEU($countryOption)) {
				continue;
			}
			$selectEu = true;
			unset($selectedCountries[$key]);
		}
		if ($selectEu) {
			$selectedCountries = array_merge(array('EU'), $selectedCountries);
		}
		$fieldset->addField('assigned_countries', 'multiselect',
				array(
						'name'  => 'assigned_countries',
						'label' => Mage::helper('egovsvies')->__('Assigned countries'),
						'title' => Mage::helper('egovsvies')->__('Assigned countries'),
// 						'class' => 'required-entry',
						'required' => false,
						'values' => $availableCountries,
						'value' => $selectedCountries,
						'note'	=> Mage::helper('egovsvies')->__('To select multiple values, hold the Control-Key<br/>while clicking on the payment method names.'),
				)
		);
		 
		
		$form->addValues($customerGroup->getData());
		$form->setMethod('post');
	}
	
	/**
	 * Wird vor dem Speichern der Gruppe aufgerufen
	 *
	 * customer_group_save_before
	 *
	 * @param Varien_Object $observer Observer
	 *
	 * @return void
	 */
	public function onCustomerGroupSaveBefore($observer) {
		/* @var $group Mage_Customer_Model_Group */
		$group = $observer->getEvent()->getObject();
		if (!($group instanceof Mage_Customer_Model_Group)) {
			return;
		}
		
		$value = Mage::app()->getRequest()->getParam('company');
		$group->setData('company',intval($value));
		
		$value = Mage::app()->getRequest()->getParam('taxvat');
		$group->setData('taxvat',intval($value));
		
		$assignedCountries = Mage::app()->getRequest()->getParam('assigned_countries');
		
		$origData = $group->getOrigData();
		if (empty($origData)) {
			return;
		}
		
		if (!is_array($assignedCountries)) {
			Mage::getModel('egovsvies/autoassign')->getCollectionByGroup($group)->walk('delete');
			return;
		}
		
		Mage::getModel('egovsvies/autoassign')->assignCountries($group, $assignedCountries);
	}
	
	/**
	 * Wird vor dem Speichern aufgerufen
	 * 
	 * customer_save_before
	 * 
	 * @param Varien_Object $observer Observer
	 * 
	 * @return void
	 */
	public function autoAssignGroup($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
		
		if (!$customer || $customer->isEmpty() || !$customer->getUseGroupAutoassignment() || $customer->getGroupAutoAssigned()) {
			return;
		}
		
		$address = $customer->getAddressById($customer->getBaseAddress());
		if (!$address || $address->isEmpty()) {
			$billingAddress = $customer->getDefaultBillingAddress();
			if (!$billingAddress) {
				$addresses = $customer->getAddresses();
				if (!isset($addresses[0])) {
					return;
				}
			
				$billingAddress = $addresses[0];
			}
				
			if (is_array($billingAddress)) {
				$data = $billingAddress;
			} elseif ($billingAddress instanceof Mage_Customer_Model_Address) {
				/* $origData = $billingAddress->getOrigData();
				 if (!empty($origData)) {
				return;
				} */
				$data = $billingAddress->getData();
			} else {
				$data = array();
			}
		} else {
			$data = $address->getData();
		}		
		
		if (empty($data)) {
			return;
		}
		
		if (!array_key_exists('taxvat', $data)) {
			$data['taxvat'] = trim($customer->getTaxvat());
		}
		$data->setTaxvatValid(?);
		
		$customer->setGroupId($this->_getGroupIdByCustomerGroupRules($data));
		$customer->setGroupAutoAssigned(true);
		return;
	}
	
	/**
	 * Erzwingt die Anzeige der Adressfelder
	 * 
	 * @return void
	 */
	public function showAddressFields() {
		/* @var $layout Mage_Core_Model_Layout */
		$layout = Mage::getSingleton('core/layout');
		$block = $layout->getBlock('customer_form_register');
		
		if (!$block) {
			return;
		}
		
		$block->setShowAddressFields(true);
	}
}