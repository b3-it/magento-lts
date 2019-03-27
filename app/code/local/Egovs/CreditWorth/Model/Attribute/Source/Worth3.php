<?php

class Egovs_CreditWorth_Model_Attribute_Source_Worth3 extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    /**
     * {@inheritDoc}
     * @see Mage_Eav_Model_Entity_Attribute_Source_Interface::getAllOptions()
     */
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                /*
                 array(
                 'label' => "",
                 'value' => self::VALUE_NONE
                 ),
                 //*/
                array(
                    'label' => "0",
                    'value' => 0
                ),
                array(
                    'label' => "1",
                    'value' => 1
                ),
                array(
                    'label' => "2",
                    'value' => 2
                ),
                array(
                    'label' => "3",
                    'value' => 3
                ),
            );
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
        return "";
    }
}