<?php

class Egovs_Base_Model_Customer_Address_Config extends Mage_Customer_Model_Address_Config
{
	/**
	 * Retrieve default address format
	 *
	 * @return Varien_Object
	 */
    protected function _getDefaultFormat()
    {
    	$store = $this->getStore();
    	$storeId = $store->getId();
    	if(!isset($this->_defaultType[$storeId])) {
    		$this->_defaultType[$storeId] = new Varien_Object();
    		$this->_defaultType[$storeId]->setCode('default')
    		->setDefaultFormat('{{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}'
    				. '{{var middlename}} {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}<br />'
    				. '{{var street}}<br />{{var postcode}} {{var city}}<br />{{var region}}<br />{{var country}}');

    		$this->_defaultType[$storeId]->setRenderer(
    				Mage::helper('customer/address')
    				->getRenderer(self::DEFAULT_ADDRESS_RENDERER)->setType($this->_defaultType[$storeId])
    				);
    	}
    	return $this->_defaultType[$storeId];
    }

}
