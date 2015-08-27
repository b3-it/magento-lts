<?php

class Dwd_Periode_Model_Periode_Type extends Varien_Object
{
    const PERIOD_DURATION		= 1;
    const PERIOD_TIMESPAN		= 2;
    const PERIOD_DURATION_ABO	= 3;
   // const PERIOD_TIMESPAN_ABO	= 4;
   

    static public function getOptionArray()
    {
        return array(
            self::PERIOD_DURATION    => Mage::helper('periode')->__('Duration'),
            self::PERIOD_TIMESPAN    => Mage::helper('periode')->__('Timespan'),  
        	self::PERIOD_DURATION_ABO    => Mage::helper('periode')->__('Abo'),
        	//self::PERIOD_TIMESPAN_ABO    => Mage::helper('periode')->__('Abo Timespan'),
        );
    }
    
    static public function getOptionArrayWithoutAbo()
    {
    	return array(
    			self::PERIOD_DURATION    => Mage::helper('periode')->__('Duration'),
    			self::PERIOD_TIMESPAN    => Mage::helper('periode')->__('Timespan'),
    			//self::PERIOD_DURATION_ABO    => Mage::helper('periode')->__('Abo Duration'),
    			//self::PERIOD_TIMESPAN_ABO    => Mage::helper('periode')->__('Abo Timespan'),
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