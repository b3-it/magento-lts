<?php
class Stala_Extcustomer_Block_Account_Dashboard_Discountquota extends Mage_Core_Block_Template
{
	protected $_discountQuotaAttribute = null;
	protected $_customer = null;
	
	/**
	 * 
	 * Get the current customer from session.
	 * 
	 * @return Mage_Customer_Model_Customer
	 */
	protected function _getCustomer() {
		if ($this->_customer == null) {
			$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_customer;
	}
	
	/**
	 * 
	 * Get the discount quota attribute
	 * @return Mage_Eav_Model_Entity_Attribute
	 */
	protected function _getDiscountQuota() {
		if ($this->_discountQuotaAttribute == null) {
			$this->_discountQuotaAttribute = $this->_getCustomer()->getAttribute('discount_quota');
		}
		
		return $this->_discountQuotaAttribute;
	}
	
	/**
	 * 
	 * Is this class available
	 * 
	 * @return TRUE|FALSE
	 */
	public function isAvailable() {		
		if ($this->_getDiscountQuota() != null) {
			return true;
		}
		
		return false;
	}
	
	public function getDiscountQuotaHtml()
    {
    	if (!$this->isAvailable()) {
    		return $this->__('No discount quota available');
    	}
    	
    	$availableDiscount = Mage::getModel('extcustomer/salesdiscount')->getAvailableDiscountQuota($this->_getCustomer());
    	$html = $this->__('Available discount quota: %s', Mage_Core_Helper_Data::currency($availableDiscount, true, false));
    	$html .= '<br>'.$this->__($this->_getDiscountQuota()->getNote());
        return $html;
    }

}