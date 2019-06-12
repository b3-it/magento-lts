<?php

class Gka_UserStore_Model_Entity_Attribute_Source_Allowedstores
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{   
	
	
	protected $_customer = null;
	
	
    /**
     * Stores aus der Website anzeigen
     *
     * @return array
     */
    public function xgetAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array();
            foreach (Mage::app()->getStores() as $store) {
            	//if(($this->_getCustomer()->isInStore($store)) || empty($this->_getCustomer()->getId()))
            	{
	                /* @var $group Mage_Customer_Model_Group */
	                $this->_options[] = array(
	                    'value' => $store->getId(),
	                    'label' => $store->getName(),
	                );
            	}
            }
        }
        return $this->_options;
    }
    public function getAllOptions()
    {
    	if (!$this->_options) {
    		$collection = Mage::getResourceModel('core/store_collection');
    		if ('store_id' == $this->getAttribute()->getAttributeCode()) {
    			$collection->setWithoutDefaultFilter();
    		}
    		$this->_options = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm();
    		if ('created_in' == $this->getAttribute()->getAttributeCode()) {
    			array_unshift($this->_options, array('value' => '0', 'label' => Mage::helper('customer')->__('Admin')));
    		}
    	}
    	return $this->_options;
    }

    /**
     * Get the label for an option value. If the value is a comma
     * separated string or an array, return an array of matching
     * option labels.
     *
     * @param string|integer $value
     * @return string|array
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();

        if (is_scalar($value) && strpos($value, ',')) {
            $value = explode(',', $value);
        }
        if (is_array($value)) {
            $values = array();
            foreach ($options as $item) {
                if (in_array($item['value'], $value)) {
                    $values[] = $item['label'];
                }
            }
            return $values;
        } else {
            foreach ($options as $item) {
                if ($item['value'] == $value) {
                    return $item['label'];
                }
            }
        }
        return false;
    }

    /**
     * Return the matching option value(s) for the passed option label(s)
     *
     * @param int|string $value A single option label or a comma separated list for multiselect
     * @return null|string
     */
    public function getOptionId($value)
    {
        if (
            $this->getAttribute()->getFrontendInput() === 'multiselect' &&
            (is_array($value) || strpos($value, ',') !== false)
        ) {
            if (is_scalar($value)) {
                $value = explode(',', $value);
            }

            $optionIds = array();
            foreach ($value as $optionValue) {
                $optionIds[] = $this->getOptionId($optionValue);
            }
            return implode(',', $optionIds);
        }

        foreach ($this->getAllOptions() as $option) {
            if (strcasecmp($option['label'], $value) == 0 || $option['value'] == $value) {
                return $option['value'];
            }
        }
        return null;
    }
    
    /***
     * @return Mage_Customer_Model_Customer
     */
    protected function _getCustomer()
    {
    	if($this->_customer == null)
    	{
    		$this->_customer =  Mage::registry('current_customer');
    	}
    	return $this->_customer;

    }
}
