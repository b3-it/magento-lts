<?php

class Gka_Checkout_Block_Singlepage_Givenamount extends Mage_Core_Block_Template
{
	protected $_CurrencySymbol = null;
	
	
	/**
	 * Get multishipping checkout model
	 *
	 * @return Mage_Checkout_Model_Type_Multishipping
	 */
	public function getCheckout()
	{
		return Mage::getSingleton('gkacheckout/type_singlepage');
	}
	
	
 	public function getTotal()
    {
        return $this->getCheckout()->getQuote()->getGrandTotal();
    }
	
	
 	public function getCurrencySymbol()
    {
    	if($this->_CurrencySymbol == null)
    	{
    		$this->_CurrencySymbol =  Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    	}
    	return $this->_CurrencySymbol;
    }
    
}
