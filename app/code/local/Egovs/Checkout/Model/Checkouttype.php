<?php
class Egovs_Checkout_Model_Checkouttype extends Mage_Checkout_Model_Type_Abstract
{
	const TYPE_ONEPAGE 			= 'onepage';
	const TYPE_MULTIPAGE         = 'multipage';
	
 	public function getAllOptions()
    {
    	return $this->toOptionArray();
    }
	
  	public function toOptionArray()
    {
    	$res = array();
		$res[] = array('value'=>self::TYPE_ONEPAGE,'label'=>Mage::helper('mpcheckout')->__('Onepage'));
		$res[] = array('value'=>self::TYPE_MULTIPAGE,'label'=>Mage::helper('mpcheckout')->__('Multipage'));
        
    	
    	return $res;
    }
}