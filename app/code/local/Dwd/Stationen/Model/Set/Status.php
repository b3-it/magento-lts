<?php

class Dwd_Stationen_Model_Set_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('stationen')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('stationen')->__('Disabled')
        );
    }
    
  static public function getOptionHashArray()
    {
    	$res = array();
    	foreach( self::getOptionArray() as $k=>$v)
    	{
    		$res[] = array('label'=>$v,'value'=>$k);
    	}
    	return $res;
    }
}