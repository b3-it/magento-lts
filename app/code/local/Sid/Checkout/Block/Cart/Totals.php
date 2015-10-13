<?php

class Sid_Checkout_Block_Cart_Totals extends Mage_Checkout_Block_Cart_Totals
{
	private $_CheckoutUrl = 'sidcheckout/multishipping';
	
    public function getCheckoutUrl()
    {
        return $this->getUrl($this->_CheckoutUrl, array('_secure'=>true));
    }
    
   	public function setCheckoutUrl($url)
    {
        $this->_CheckoutUrl = $url;
    }
}