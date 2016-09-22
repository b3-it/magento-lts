<?php

class Sid_Haushalt_Model_Source_Attribute_Type extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions($addEmpty = true)
    {
        if (is_null($this->_options)) {
        	if($addEmpty) {
	            $this->_options = array();
	            $this->_options[] =  array(
	                    'label' => '',
	                    'value' =>  ''
	                	); 
        	}
           $items = Sid_Haushalt_Model_Type::getTypeList();
            foreach ($items as $type => $label) {
            	$this->_options[] =  array(
                    'label' => $label,
                    'value' =>  $type
                	); 
            }
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray($addEmpty = true)
    {
        $_options = array();
        foreach ($this->getAllOptions($addEmpty) as $option) {
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
