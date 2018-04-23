<?php

class B3it_Subscription_Block_Customer_Account_View extends Mage_Core_Block_Template
{
	public function getBackUrl() {
		if ($this->getRefererUrl()) {
			return $this->getRefererUrl();
		}
		return Mage::getUrl('customer/account/');
	}

	public function getBackTitle() {
		 
		return Mage::helper('b3it_icd')->__('My Account');
	}

}
