<?php

class Bkg_License_Block_Customer_Account_View extends Mage_Core_Block_Template
{
	public function getBackUrl() {
		if ($this->getRefererUrl()) {
			return $this->getRefererUrl();
		}
		return Mage::getUrl('customer/account/');
	}

	public function getBackTitle() {
		 
		return Mage::helper('bkg_license')->__('My Account');
	}

}
