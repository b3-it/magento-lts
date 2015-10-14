<?php

class Dwd_Stationen_Model_Stationen_Status extends Varien_Object
{
    const STATUS_ACTIVE		= 1;
    const STATUS_INACTIVE	= 5;
    const STATUS_PLANNED	= 4;
    const STATUS_REMOVED	= 2;
	const STATUS_DELETED	= 10;
	
	/* dwd stati
	    1            aktiv
        2            aufgelöst
        4            geplant
        5            ruhend
	*/
    static public function getOptionArray()
    {
        return array(
            self::STATUS_ACTIVE    => Mage::helper('stationen')->__('Active'),
            self::STATUS_INACTIVE   => Mage::helper('stationen')->__('Inactive'),
            self::STATUS_PLANNED   => Mage::helper('stationen')->__('Planned'),
            self::STATUS_REMOVED   => Mage::helper('stationen')->__('Removed'),
            self::STATUS_DELETED   => Mage::helper('stationen')->__('Deleted')
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