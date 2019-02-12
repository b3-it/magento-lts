<?php
/**
 * Validiert die VAT - Nummer
 *
 * Diese Klasse kapselt die Methoden für Aufrufe die von Events ausgelöst wurden.
 *
 * @category	Egovs
 * @package		Egovs_Vies
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Vies_Model_Sales_Observer extends Mage_Sales_Model_Observer
{
	/**
	 * Retrieve sales address (order or quote) on which tax calculation must be based
	 *
	 * @param Mage_Core_Model_Abstract $salesModel
	 * @param Mage_Core_Model_Store|string|int|null $store
	 * @return Mage_Customer_Model_Address_Abstract|null
	 */
	protected function _getVatRequiredSalesAddress($salesModel, $store = null) {
		$configAddressType = Mage::helper('customer/address')->getTaxCalculationAddressType($store);

		$requiredAddress = $salesModel->getBaseAddress();
		if (!$requiredAddress || $requiredAddress->isEmpty()) {
			switch ($configAddressType) {
				case Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING:
					$requiredAddress = $salesModel->getShippingAddress();
					break;
				default:
					$requiredAddress = $salesModel->getBillingAddress();
			}
		}
		return $requiredAddress;
	}
	
	/**
	 * Handle customer VAT number if needed on collect_totals_before event of quote address
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function changeQuoteCustomerGroupId(Varien_Event_Observer $observer)
	{
		/** @var $addressHelper Mage_Customer_Helper_Address */
		$addressHelper = Mage::helper('customer/address');
	
		$quoteAddress = $observer->getQuoteAddress();
		$quoteInstance = $quoteAddress->getQuote();
		$customerInstance = $quoteInstance->getCustomer();
		$isDisableAutoGroupChange = $customerInstance->getDisableAutoGroupChange();
	
		$storeId = $customerInstance->getStore();
	
		$configAddressType = Mage::helper('customer/address')->getTaxCalculationAddressType($storeId);
	
		// When VAT is based on billing address then Magento have to handle only billing addresses
		$additionalBillingAddressCondition = ($configAddressType == Mage_Customer_Model_Address_Abstract::TYPE_BILLING)
			? $configAddressType != $quoteAddress->getAddressType() : false;
		// Handle only addresses that corresponds to VAT configuration
		if (!$addressHelper->isVatValidationEnabled($storeId) || ($quoteAddress->getAddressType() != 'base_address' && $additionalBillingAddressCondition)) {
			return;
		}
	
		/** @var $customerHelper Mage_Customer_Helper_Data */
		$customerHelper = Mage::helper('customer');
	
		$customerCountryCode = $quoteAddress->getCountryId();
		$customerVatNumber = $quoteAddress->getVatId();
	
		if ((empty($customerVatNumber) || !Mage::helper('core')->isCountryInEU($customerCountryCode))
				&& !$isDisableAutoGroupChange
		) {
		    if (strlen($customerCountryCode) > 0) {
                $data = array('country_id' => $customerCountryCode, 'company' => $quoteAddress->getCompany());
                $groupId = Mage::helper('egovsvies')->getGroupIdByCustomerGroupRules($data);
                //Falls nichts gematched hat!!!
                if (is_null($groupId)) {
                    $groupId = Mage::helper('customer')->getDefaultCustomerGroupId($storeId);
                }
                $groupId = ($customerInstance->getId()) ? $groupId : Mage_Customer_Model_Group::NOT_LOGGED_IN_ID;
            } else {
		        $groupId = ($customerInstance->getId()) ? $customerInstance->getGroupId() : Mage_Customer_Model_Group::NOT_LOGGED_IN_ID;
            }
	
			$quoteAddress->setPrevQuoteCustomerGroupId($quoteInstance->getCustomerGroupId());
			$customerInstance->setGroupId($groupId);
			$quoteInstance->setCustomerGroupId($groupId);
	
			return;
		}
	
		/** @var $coreHelper Mage_Core_Helper_Data */
		$coreHelper = Mage::helper('core');
		$merchantCountryCode = $coreHelper->getMerchantCountryCode();
		$merchantVatNumber = $coreHelper->getMerchantVatNumber();
	
		$gatewayResponse = null;
		if ($addressHelper->getValidateOnEachTransaction($storeId)
				|| $customerCountryCode != $quoteAddress->getValidatedCountryCode()
				|| $customerVatNumber != $quoteAddress->getValidatedVatNumber()
		) {
			// Send request to gateway
			$gatewayResponse = $customerHelper->checkVatNumber(
					$customerCountryCode,
					$customerVatNumber,
					($merchantVatNumber !== '') ? $merchantCountryCode : '',
					$merchantVatNumber
			);
	
			// Store validation results in corresponding quote address
			$quoteAddress->setVatIsValid((int)$gatewayResponse->getIsValid())
				->setVatRequestId($gatewayResponse->getRequestIdentifier())
				->setVatRequestDate($gatewayResponse->getRequestDate())
				->setVatRequestSuccess($gatewayResponse->getRequestSuccess())
				->setValidatedVatNumber($customerVatNumber)
				->setValidatedCountryCode($customerCountryCode)
				->save()
			;
		} else {
			// Restore validation results from corresponding quote address
			$gatewayResponse = new Varien_Object(array(
					'is_valid' => (int)$quoteAddress->getVatIsValid(),
					'request_identifier' => (string)$quoteAddress->getVatRequestId(),
					'request_date' => (string)$quoteAddress->getVatRequestDate(),
					'request_success' => (boolean)$quoteAddress->getVatRequestSuccess()
			));
		}
	
		// Magento always has to emulate group even if customer uses default billing/shipping address
		if (!$isDisableAutoGroupChange) {
			$data = array(
					'country_id' => $customerCountryCode,
					'company' => $quoteAddress->getCompany(),
					'vat_id' => $customerVatNumber,
					'taxvat_valid' => $gatewayResponse->getIsValid()
			);
			if (!$gatewayResponse || !$gatewayResponse->getRequestSuccess()) {
				$groupId = (int)Mage::getStoreConfig(Mage_Customer_Helper_Data::XML_PATH_CUSTOMER_VIV_ERROR_GROUP, $storeId);
			} else {
				$groupId = Mage::helper('egovsvies')->getGroupIdByCustomerGroupRules($data);
				//Falls nichts gematched hat!!!
				if (is_null($groupId)) {
					$groupId = Mage::helper('customer')->getDefaultCustomerGroupId($storeId);
				}
			}
		} else {
			$groupId = $quoteInstance->getCustomerGroupId();
		}
	
		if ($groupId) {
			$quoteAddress->setPrevQuoteCustomerGroupId($quoteInstance->getCustomerGroupId());
			$customerInstance->setGroupId($groupId);
			$quoteInstance->setCustomerGroupId($groupId);
		}
	}
}