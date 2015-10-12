<?php
class Egovs_Base_Block_Customer_Account_Dashboard_Hello extends Mage_Customer_Block_Account_Dashboard_Hello
{
    public function getCustomerName() {
    	$customer = Mage::getSingleton('customer/session')->getCustomer();
    	if (strlen($customer->getCompany()) > 0) {
    		$str = trim($customer->getName());
    		//Firma
    		if (!empty($str)) {
    			$str = trim(sprintf('%s (%s)', $str, $customer->getCompany()));
    		} else {
    			$str = trim(sprintf('%s', $customer->getCompany()));
    		}
    	} else {
    		$str = $customer->getName();
    	}
    	
    	return $str;
    }

}
