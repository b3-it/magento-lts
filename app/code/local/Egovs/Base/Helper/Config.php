<?php
class Egovs_Base_Helper_Config extends Mage_Core_Helper_Abstract
{
	//protected $_guestconfig;
	protected $_registerconfig;
	//protected $_shippingconfig;
	
	  public function getConfig($key, $CheckoutMethod)
	    {
	    	if(Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST == $CheckoutMethod)
	    	{
	    		if (is_null($this->_guestconfig)) {
		            $this->_guestconfig = Mage::getStoreConfig('checkout/guestrequired');
		        }
		        return isset($this->_guestconfig[$key]) ? $this->_guestconfig[$key] : '';
	    	}
	    	elseif ('shipping' == $CheckoutMethod)
	    	{
	    		if($key == 'firstname') return true;
	    		if($key == 'lastname') return true;
	    		if($key == 'street') return true;
	    		if($key == 'city') return true;
	    		if($key == 'postcode') return true;
	    		if($key == 'country_id') return true;
		        if (is_null($this->_shippingconfig)) {
		            $this->_shippingconfig = Mage::getStoreConfig('checkout/shippingrequired');
		        }
		        return isset($this->_shippingconfig[$key]) ? $this->_shippingconfig[$key] : '';
	    	}
	    	else
	    	{
	    		
	    		//if(($key == 'email') && ($CheckoutMethod != 'login_in')) return 'req';
		        if (is_null($this->_registerconfig)) {
		            $this->_registerconfig = Mage::getStoreConfig('checkout/registerrequired');
		        }
		        
		        return isset($this->_registerconfig[$key]) ? $this->_registerconfig[$key] : '';
	    	}
	    }
	    
 	public function isFieldRequired($key, $CheckoutMethod)
    {
    	return ($this->getConfig($key, $CheckoutMethod) == 'req');
    }
}