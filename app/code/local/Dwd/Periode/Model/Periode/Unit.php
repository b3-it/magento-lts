<?php

class Dwd_Periode_Model_Periode_Unit extends Varien_Object
{
    const UNIT_DAY	= 1;
    const UNIT_WEEK	= 2;
    const UNIT_MONTH	= 3;
    const UNIT_YEAR	= 4;

    static public function getOptionArray()
    {
        return array(
            self::UNIT_DAY    => Mage::helper('periode')->__('per Day'),
            self::UNIT_WEEK    => Mage::helper('periode')->__('per Week'),
            self::UNIT_MONTH    => Mage::helper('periode')->__('per Month'),
            self::UNIT_YEAR    => Mage::helper('periode')->__('per Year'),
            
        );
    }
    
    static public function getOptionLabel($value)
    {
    	$a = self::getOptionArray();
    	if(isset($a[$value]))
    	{
    		return $a[$value];
    	}
    	
    	return '';
    }
}