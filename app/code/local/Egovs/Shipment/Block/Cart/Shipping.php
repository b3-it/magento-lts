<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Egovs_Shipment_Block_Cart_Shipping extends Mage_Checkout_Block_Cart_Shipping //Mage_Checkout_Block_Cart_Abstract
{
    protected $_carriers = null;
    protected $_rates = array();
    protected $_address = array();

    public function getEstimateRates()
    {
        if (empty($this->_rates)) {
        	if(($this->getAddress()->getPostcode() != null))
        	{
            	$this->_rates = $this->getShippingRates($this->getAddress());
        	}            
        	
        }
        return $this->_rates;
    }

    
    private function filterRank($groups)
    {
    	$res = array();
    	$max = 0;
    	foreach ($groups as $key=>$value) {
    		$rank = Mage::getStoreConfig('carriers/'.$key.'/rank');
    		if(!$rank) $rank = 0;
    		if(!isset($res[$rank])) $res[$rank] = array();
    		$res[$rank][$key]= $value;
    		if($rank > $max) $max = $rank;
    	}
    	 
    	if(count($res) > 0) return $res[$max];
    	 
    	return $groups;
    }
    
    public function getShippingRates($address) {
    	$groups = $address->getGroupedAllShippingRates();
    	
    	{
    		if (array_key_exists('freeshipping', $groups)) {
    			return array('freeshipping'=>$groups['freeshipping']);
    		}
    	}
    
    
    	return $this->filterRank($groups);
    }
    
    
    
    
    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
    	return Mage::getSingleton('checkout/cart');
    }
    
    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
    	return Mage::getSingleton('checkout/session');
    }
    
    /**
     * Get current active quote instance
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
    	return $this->_getSession()->getQuote();
    	//return $this->_getCart()->getQuote();
    }
    
    /**
     * Get address model
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getAddress()
    {
        if (empty($this->_address)) {
            $this->_address = $this->getQuote()->getShippingAddress();
            
            if(($code = $this->getDefaultShippingMethod($this->_address)) && ($this->_address->getShippingMethod() == null))
            {
            	$this->_address->setShippingMethod($code);
            	//$this->getQuote()->save();
            }
            
            if($this->_address->getPostcode() == null)
            {
            	if($adr = $this->getCustomerAdress())
            	{
	            	$this->getQuote()->getShippingAddress()
	            	->setCountryId($adr->getCountryId())
	            	->setCity($adr->getCity())
	            	->setPostcode($adr->getPostcode())
	            	->setRegionId($adr->getRegionId())
	            	->setRegion($adr->getRegion())
	            	->setCollectShippingRates(true);
	            	
	            	if($code)
	            	{
	            		$this->getQuote()->getShippingAddress()->setShippingMethod($code);
	            	}
	            	       
	            	
	            	$this->getQuote()->save();
            	}
            }
            
            
            
        }
        return $this->_address;
    }

    
    public function getCustomerAdress()
    {
    	$customer = $this->getCustomer();
    	if($customer->getId()){
    		return $customer->getPrimaryShippingAddress();
    	}
    }
    
    
    public function getDefaultShippingMethod($address = null)
    {
    	
    	if($address != null)
    	{
	    	$rates = $this->getShippingRates($address);
	    	
	    	if(count($rates) == 1)
	    	{
	    		$rates = array_shift($rates);
	    		$rates = $rates[0];
	    		return $rates->getCode();
	    	}
    	}
    	if ($name = Mage::getStoreConfig('shipping/estimate_costs/default_shipping_method')) {
    		return $name;
    	}
    	
    	return null;
    }
    
    public function getCarrierName($carrierCode)
    {
        if ($name = Mage::getStoreConfig('carriers/'.$carrierCode.'/title')) {
            return $name;
        }
        return $carrierCode;
    }

    public function getAddressShippingMethod()
    {
        return $this->getAddress()->getShippingMethod();
    }

    public function getEstimateCountryId()
    {
        return $this->getAddress()->getCountryId();
    }

    public function getEstimatePostcode()
    {
        return $this->getAddress()->getPostcode();
    }

    public function getEstimateCity()
    {
        return $this->getAddress()->getCity();
    }

    public function getEstimateRegionId()
    {
        return $this->getAddress()->getRegionId();
    }

    public function getEstimateRegion()
    {
        return $this->getAddress()->getRegion();
    }

    public function getCityActive()
    {
        return (bool)Mage::getStoreConfig('carriers/dhl/active');
    }

    public function getStateActive()
    {
    	
        return (bool)Mage::getStoreConfig('carriers/dhl/active') || (bool)Mage::getStoreConfig('carriers/tablerate/active');
    }

    public function formatPrice($price)
    {
        return $this->getQuote()->getStore()->convertPrice($price, true);
    }

    public function getShippingPrice($price, $flag)
    {
        return $this->formatPrice($this->helper('tax')->getShippingPrice(
            $price,
            $flag,
            $this->getAddress(),
            $this->getQuote()->getCustomerTaxClassId()
        ));
    }

    /**
     * Obtain available carriers instances
     *
     * @return array
     */
    public function getCarriers()
    {
        if (null === $this->_carriers) {
            $this->_carriers = array();
            if($this->getEstimateRates())
            {
	            foreach ($this->_rates as $rateGroup) {
	                if (!empty($rateGroup)) {
	                    foreach ($rateGroup as $rate) {
	                        $this->_carriers[] = $rate->getCarrierInstance();
	                    }
	                }
	            }
            }
        }
        return $this->_carriers;
    }

    /**
     * Check if one of carriers require state/province
     *
     * @return bool
     */
    public function isStateProvinceRequired()
    {
        foreach ($this->getCarriers() as $carrier) {
            if ($carrier->isStateProvinceRequired()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if one of carriers require city
     *
     * @return bool
     */
    public function isCityRequired()
    {
        foreach ($this->getCarriers() as $carrier) {
            if ($carrier->isCityRequired()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if one of carriers require zip code
     *
     * @return bool
     */
    public function isZipCodeRequired()
    {
        foreach ($this->getCarriers() as $carrier) {
            if ($carrier->isZipCodeRequired()) {
                return true;
            }
        }
        return false;
    }
    
    public function showEstimatedCosts()
    {
    	return  (bool)Mage::getStoreConfig('shipping/estimate_costs/show_at_card');
    	 
    } 
}
