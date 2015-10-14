<?php

class Dwd_Icd_Block_Customer_Credentials_Change extends Mage_Core_Block_Template
{
    protected function x_construct()
    {

        parent::_construct();
        
    }

    protected function x_prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle($this->__('Order # %s', $this->getOrder()->getRealOrderId()));
        }
       
    }

   
    public function getBackUrl()
    {
    	if (Mage::getSingleton('customer/session')->isLoggedIn()) {
    		return Mage::getUrl('dwd_icd/index/view');
    	}
    	return Mage::getUrl('customer/account');
    }
    
    
    public function getBackTitle()
    {
    	if (Mage::getSingleton('customer/session')->isLoggedIn()) {
    		return Mage::helper('dwd_icd')->__('Back to Manage Data Access');
    	}
    	return Mage::helper('dwd_icd')->__('My Account');
    }

}
