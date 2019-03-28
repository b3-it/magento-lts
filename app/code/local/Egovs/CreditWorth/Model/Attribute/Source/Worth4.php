<?php

class Egovs_CreditWorth_Model_Attribute_Source_Worth4 extends Egovs_CreditWorth_Model_Attribute_Source_Worth3
{
    /**
     * {@inheritDoc}
     * @see Egovs_CreditWorth_Model_Attribute_Source_Worth3::getAllOptions()
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
                array(
                    'label' => "4",
                    'value' => 4
                ),
            );
        }
        return $this->_options;
    }
}