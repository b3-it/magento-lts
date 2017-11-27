<?php
/**
 *
 * @category   	Gka Reports
 * @package    	Gka_Reports
 * @name       	Gka_Reports_Block_Transaction
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Reports_Block_Transaction extends Mage_Core_Block_Template
{
	

  	public function _prepareLayout()
    {
  		return parent::_prepareLayout();
    }


    
    protected function _getCustomer()
    {
    	if($this->_customer == null){
    		$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
    	}
    	return $this->_customer;
    }
    
    public function getCustomer()
    {
    	if ( $customer = $this->_getCustomer() ) {
            return $customer->getFirstname() . ' ' . $customer->getLastname();
    	}
    	
    	return 'Unknown';
    }
    
    public function getCustomerId()
    {
    	$customer = $this->_getCustomer();
    	if($customer)
    	{
    		return $customer->getId();
    	}
    	
    	return 0;
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
