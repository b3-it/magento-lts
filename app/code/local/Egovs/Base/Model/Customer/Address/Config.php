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
        if( !isset($this->_defaultType) || is_null($this->_defaultType)) {
            $this->_defaultType = new Varien_Object();
            $this->_defaultType->setCode('default')
                 ->setDefaultFormat('{{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} ' .
                                    '{{depend middlename}}{{var middlename}} {{/depend}}' .
                                    '{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}} ' .
                                    '<br /> {{var street}} <br /> {{var postcode}} - {{var city}} <br /> ' .
                                    '{{var region}} <br /> {{var country}}');

            $this->_defaultType->setRenderer(
                Mage::helper('customer/address')
                    ->getRenderer(self::DEFAULT_ADDRESS_RENDERER)->setType($this->_defaultType)
            );
        }
        return $this->_defaultType;
    }

}
