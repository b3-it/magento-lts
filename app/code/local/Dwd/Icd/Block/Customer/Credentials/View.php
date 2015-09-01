<?php

class Dwd_Icd_Block_Customer_Credentials_View extends Mage_Core_Block_Template
{
	public function getBackUrl() {
		if ($this->getRefererUrl()) {
			return $this->getRefererUrl();
		}
		return Mage::getUrl('customer/account/');
	}

	public function getBackTitle() {
		 
		return Mage::helper('dwd_icd')->__('My Account');
	}

}
