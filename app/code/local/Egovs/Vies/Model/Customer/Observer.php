<?php
/**
 * Validiert die VAT - Nummer
 *
 * Diese Klasse kapselt die Methoden für Aufrufe die von Events ausgelöst wurden.
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2018 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Model_Customer_Observer extends Mage_Customer_Model_Observer
{
	protected $_lastOrigAddress = null;
	

	protected function _isBaseAddress($address) {
		return ($address->getId() && $address->getId() == $address->getCustomer()->getBaseAddress())
			|| $address->getIsDefaultBaseAddress();
	}

	protected function _hasBaseAddress($address) {
	    if (!$address) {
	        return false;
        }
        $baseAddress = $address->getCustomer()->getBaseAddress();
        return ($baseAddress > 0) || is_string($baseAddress) || $address->getIsDefaultBaseAddress();
    }
	
	/**
	 * Check whether specified address should be processed in after_save event handler
	 *
	 * @param Mage_Customer_Model_Address $address
	 * 
	 * @return bool
	 */
	protected function _canProcessAddress($address) {
		if ($address->getForceProcess()) {
			return true;
		}
	
		if (Mage::registry(self::VIV_CURRENTLY_SAVED_ADDRESS) != $address->getId()) {
			return false;
		}
		
		$isBaseAddress = $this->_isBaseAddress($address);
		
		if (!$isBaseAddress && !$this->_hasBaseAddress($address)) {
			$configAddressType = Mage::helper('customer/address')->getTaxCalculationAddressType();
			if ($configAddressType == Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING) {
				return $this->_isDefaultShipping($address);
			}
			return $this->_isDefaultBilling($address);
		}
	
		return $isBaseAddress;
	}
	
	/**
	 * Address before save event handler
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function beforeAddressSave($observer) {
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
			if (!$this->_isBaseAddress($customerAddress)) {
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
	
		if (Mage::registry(self::VIV_PROCESSED_FLAG) || !$this->_canProcessAddress($customerAddress)
		) {
			return;
		}
	
		try {
			Mage::register(self::VIV_PROCESSED_FLAG, true);
	
			/* @var $customerHelper Mage_Customer_Helper_Data */
			$customerHelper = Mage::helper('customer');
	
			/*
			 * isVatValidationEnabled prüft ob "Automatische Zuordnung zu Kundengruppen aktivieren" im Backend
			 * aktiviert ist.
			 */
			if (!Mage::helper('customer/address')->isVatValidationEnabled($customer->getStore())
					|| $customerAddress->getVatId() == ''
					|| !Mage::helper('core')->isCountryInEU($customerAddress->getCountry()))
			{
				/*
				 * isVatValidationEnabled prüft ob "Automatische Zuordnung zu Kundengruppen aktivieren" im Backend
				 * aktiviert ist.
				 */
				if (!Mage::helper('customer/address')->isVatValidationEnabled($customer->getStore())) {
					return;
				}
					
				$data = $customerAddress->getData();
				$ruleGroupId = Mage::helper('egovsvies')->getGroupIdByCustomerGroupRules($data);
				//Falls nichts gematched hat!!!
				if (is_null($ruleGroupId)) {
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
				$customerAddress->setVatIsValid((int)$result->getIsValid())
					->setVatRequestId($result->getRequestIdentifier())
					->setVatRequestDate($result->getRequestDate())
					->setVatRequestSuccess($result->getRequestSuccess())
				;
				
				/** @var $customerAddressResource Mage_Customer_Model_Resource_Address */
				$customerAddressResource = $customerAddress->getResource();
				$vatAttributes = array('vat_is_valid', 'vat_request_id', 'vat_request_date', 'vat_request_success');
				foreach ($vatAttributes as $vatAttribute) {
					$customerAddressResource->saveAttribute($customerAddress, $vatAttribute);
				}
	
				$data = $customerAddress->getData();
				$data['taxvat_valid'] = $result->getIsValid();
				if (!$result->getRequestSuccess()) {
					$newGroupId = (int)Mage::getStoreConfig(Mage_Customer_Helper_Data::XML_PATH_CUSTOMER_VIV_ERROR_GROUP, $customer->getStore());
				} else {
					$newGroupId = Mage::helper('egovsvies')->getGroupIdByCustomerGroupRules($data);
					
					//Falls nichts gematched hat!!!
					if (is_null($newGroupId)) {
						$newGroupId = $customerHelper->getDefaultCustomerGroupId($customer->getStore());
					}
				}
	
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
		
		
		$store = Mage::app()->getRequest()->getParam('store');
		if(!isset($store)){
			$store = 0;
		}
		
		$customerGroup = Mage::registry('current_group');
		
		if (!$customerGroup || $customerGroup->isEmpty()) {
			return;
		}
		
		$form = $block->getForm();
		$fieldset = $form->addFieldset(
				'autoassign_country_fieldset',
				array(
					'legend'=> Mage::helper('egovsvies')->__('Settings for group auto assignment')
				)
		);
		
		/* @var $assignedCountries Egovs_Vies_Model_Autoassign */
		$assignedCountries = Mage::getSingleton('egovsvies/autoassign');
		if (!$assignedCountries || $assignedCountries == null) {
			return;
		}
		
		if ($store > 0) {
			//für den Fall das eine Storeview ausgwählt wurde, werden alle Elemente verborgen
			$fieldset->setClass('no-display');
			$fieldset->setLegend(null);
		
			$fieldset->addField(
					'company',
					'hidden',
					array(
						'name'  => 'company',
						'value' => $customerGroup->getCompany()
					)
			);
		
			$fieldset->addField(
					'taxvat',
					'hidden',
					array(
						'name'  => 'taxvat',
						'value' => $customerGroup->getTaxvat()
					)
			);
		
			$values = $assignedCountries->getSelectedCountriesArray($customerGroup);
			for ($i =0, $iMax = count($values); $i < $iMax; $i++) {
				$fieldset->addField(
						'assigned_countries'.$i,
						'hidden',
						array(
							'name'  => 'assigned_countries[]',
							'value' => $values[$i]
						)
				);
			}
		} else {
			$fieldset->addField('company', 'select',
					array(
							'name'  => 'company',
							'label' => Mage::helper('egovsvies')->__('Is for company'),
							'title' => Mage::helper('egovsvies')->__('Is for company'),
							'class' => 'required-entry',
							'required' => true,
							'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
							'value' => $customerGroup->getCompany()
					)
			);
			
			$fieldset->addField('taxvat', 'select',
					array(
							'name'  => 'taxvat',
							'label' => Mage::helper('egovsvies')->__('Is VAT required'),
							'title' => Mage::helper('egovsvies')->__('Is VAT required'),
							'class' => 'required-entry',
							'required' => true,
							'values' => Mage::getModel('egovsvies/adminhtml_system_config_source_yesnocustom')->toOptionArray(),
							'value' => $customerGroup->getTaxvat()
					)
			);
			
			$euCountries = Mage::helper('egovsvies')->getEuCountries();
			$availableCountries = Mage::getSingleton('adminhtml/system_config_source_country')->toOptionArray(true);
			foreach ($availableCountries as $key => $countryOption) {
				if (array_search($countryOption['value'], $euCountries) === false) {
					continue;
				}
				
				unset($availableCountries[$key]);
			}
			$availableCountries = array_merge(array(array('value' => 'EU', 'label' => Mage::helper('egovsvies')->__('European Union'))), $availableCountries);
			$selectedCountries = $assignedCountries->getSelectedCountriesArray($customerGroup);
			$selectEu = false;
			foreach ($selectedCountries as $key => $countryOption) {
				if (array_search($countryOption, $euCountries) === false) {
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
							//'class' => 'required-entry',
							'required' => false,
							'values' => $availableCountries,
							'value' => $selectedCountries,
							'note'	=> Mage::helper('egovsvies')->__('To select multiple values, hold the Control-Key<br/>while clicking on the payment method names.'),
					)
			);
		}
		
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
