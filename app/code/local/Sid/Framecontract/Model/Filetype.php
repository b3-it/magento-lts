<?php

class Sid_Framecontract_Model_Filetype extends Varien_Object
{
    const TYP_CONFIG	= 1;
    const TYP_INFO		= 2;
    const TYP_INTERNAL  = 3;

    static public function getOptionArray()
    {
        return array(
            self::TYP_CONFIG    => Mage::helper('framecontract')->__('Configuration'),
            self::TYP_INFO   => Mage::helper('framecontract')->__('Info'),
            //self::TYP_INTERNAL   => Mage::helper('framecontract')->__('Internal')
        );
    }
}