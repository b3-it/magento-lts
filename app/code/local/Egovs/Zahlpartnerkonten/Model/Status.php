<?php

class Egovs_Zahlpartnerkonten_Model_Status extends Varien_Object
{
    const STATUS_NEW	= 1;
    const STATUS_USED	= 2;
    const STATUS_ZPKONTO	= 3;
    const STATUS_ERROR	= 4;
    const STATUS_DISABLED	= 5;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_NEW    => Mage::helper('zpkonten')->__('New'),
            self::STATUS_USED   => Mage::helper('zpkonten')->__('Used'),
            self::STATUS_ZPKONTO   => Mage::helper('zpkonten')->__('ZP Konto'),
            self::STATUS_ERROR    => Mage::helper('zpkonten')->__('Error'),
            self::STATUS_DISABLED   => Mage::helper('zpkonten')->__('Disabled'),
        );
    }
    
    static public function getOptionHashArray()
    {
    	$res = array();
    	foreach (self::getOptionArray() as $key => $value) {
    		$res[] = array('value'=>$key,'label'=>$value);
    	}
    	return $res;
    }
}