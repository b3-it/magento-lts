<?php

class Gka_Checkout_Block_Singlepage_Start_Billing extends Mage_Sales_Block_Items_Abstract
{
   
    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle(Mage::helper('checkout')->__('Ship to Multiple Addresses') . ' - ' . $headBlock->getDefaultTitle());
        }
        
        
        parent::_prepareLayout();
        
        return $this;
    }

   

    public function getCustomer()
    {
        return $this->getCheckout()->getCustomerSession()->getCustomer();
    }



    public function isContinueDisabled()
    {
        return !$this->getCheckout()->validateMinimumAmount();
    }
}
