<?php
class Egovs_Base_Model_Sales_Quote extends Mage_Sales_Model_Quote
{
	/**
	 * Retrieve base address
	 *
	 * @return Mage_Sales_Model_Quote_Address
	 */
	public function getBaseAddress()
	{
		return $this->_getAddressByType('base_address');
	}
	
	/**
	 * Enter description here...
	 *
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @return Mage_Sales_Model_Quote
	 */
	public function setBaseAddress(Mage_Sales_Model_Quote_Address $address)
	{
		$old = $this->getBaseAddress();
	
		if (!empty($old)) {
			$old->addData($address->getData());
		} else {
			$this->addAddress($address->setAddressType('base_address'));
		}
		return $this;
	}
	
	/**
	 * Assign customer model to quote with billing and shipping address change
	 *
	 * @param  Mage_Customer_Model_Customer    $customer
	 * @param  Mage_Sales_Model_Quote_Address  $billingAddress
	 * @param  Mage_Sales_Model_Quote_Address  $shippingAddress
	 * @return Mage_Sales_Model_Quote
	 */
	public function assignCustomerWithAddressChange(
			Mage_Customer_Model_Customer    $customer,
			Mage_Sales_Model_Quote_Address  $billingAddress  = null,
			Mage_Sales_Model_Quote_Address  $shippingAddress = null
	)
	{
		if ($customer->getId()) {
			$this->setCustomer($customer);
			
			$baseAddress = $customer->getBaseAddress();
			if (is_numeric($baseAddress) && $baseAddress > 0) {
				$baseAddress = $customer->getAddressById($baseAddress);
				if ($baseAddress && $baseAddress->getId()) {
					$baseAddress = Mage::getModel('sales/quote_address')
						->importCustomerAddress($baseAddress);
					$this->setBaseAddress($baseAddress);
				}
			}
		}
		
		return parent::assignCustomerWithAddressChange($customer, $billingAddress, $shippingAddress);
	}
}