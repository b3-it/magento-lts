<?php

class Gka_Checkout_Block_Singlepage_Billing extends Mage_Sales_Block_Items_Abstract
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

    public function getCountryOptions()
    {
    	$options    = false;
    	$useCache   = Mage::app()->useCache('config');
    	if ($useCache) {
    		$cacheId    = 'DIRECTORY_COUNTRY_SELECT_STORE_' . Mage::app()->getStore()->getCode();
    		$cacheTags  = array('config');
    		if ($optionsCache = Mage::app()->loadCache($cacheId)) {
    			$options = unserialize($optionsCache);
    		}
    	}
    	
    	if ($options == false) {
    		$options = $this->getCountryCollection()->toOptionArray();
    		if ($useCache) {
    			Mage::app()->saveCache(serialize($options), $cacheId, $cacheTags);
    		}
    	}
    	return $options;
    }

    public function getCountryCollection()
    {
    	if (!$this->_countryCollection) {
    		$this->_countryCollection = Mage::getSingleton('directory/country')->getResourceCollection()
    		->loadByStore();
    	}
    	return $this->_countryCollection;
    }

    public function getCountryHtmlSelect($type)
    {
   		$countryId = Mage::helper('core')->getDefaultCountry();

   		$select = $this->getLayout()->createBlock('core/html_select')
    	->setName($type.'[country_id]')
    	->setId($type.':country_id')
    	->setTitle(Mage::helper('checkout')->__('Country'))
    	->setClass('validate-select')
    	->setValue($countryId)
    	->setOptions($this->getCountryOptions());
    	if ($type === 'shipping') {
    		$select->setExtraParams('onchange="if(window.shipping)shipping.setSameAsBilling(false);"');
    	}
    	
    	return $select->getHtml();
    }
}
