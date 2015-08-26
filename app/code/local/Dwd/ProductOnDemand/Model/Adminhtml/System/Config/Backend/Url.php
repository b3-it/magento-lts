<?php
class Dwd_ProductOnDemand_Model_Adminhtml_System_Config_Backend_Url extends Mage_Core_Model_Config_Data
{
	protected function _beforeSave() {
        $value = $this->getValue();

        if (empty($value)) {
        	return $this;
        }
        $parsedUrl = parse_url($value);
        if (!isset($parsedUrl['scheme']) || !isset($parsedUrl['host'])) {
        	Mage::throwException(Mage::helper('core')->__('The %s you entered is invalid. Please make sure that it follows "http://domain.com/" format.', $this->getFieldConfig()->label));
        }

        $value = rtrim($value,  '/');
        
        $this->setValue($value);
        return $this;
    }
}