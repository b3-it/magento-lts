<?php

/**
 * Multipage checkout controller
 *
 * 
 */
class Slpb_Checkout_ShopletterController extends Slpb_Checkout_Controller_Abstract
{
    

    protected function _getCheckout()
    {
    	if($this->_checkout == null)
    	{
        	$this->_checkout = Mage::getSingleton('slpbcheckout/shop');
        	$this->_checkout->setPaymentMethode('checkmo');
    		$this->_checkout->setShippingMethode('slpbshipping_slpbshipping');
	
    	}
    	
    	return $this->_checkout;
    	
    }

  	protected function redirectSuccess()
    {
    	$this->_redirect('slpb_checkout/shopletter/successview',array('_secure'=>true));
    }
     
}
