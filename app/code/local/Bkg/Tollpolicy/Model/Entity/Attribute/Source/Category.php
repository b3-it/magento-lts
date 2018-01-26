<?php

class Bkg_Tollpolicy_Model_Entity_Attribute_Source_Category extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{


    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
    	$collection = Mage::getModel('bkg_tollpolicy/tollcategory')->getCollection();
        
        if (is_null($this->_options)) {
            $this->_options = array();
            foreach($collection as $item)
            {
            	$this->_options[] = array('label'=>$item->getName(),'value'=>$item->getId());
            }
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }

 
}
