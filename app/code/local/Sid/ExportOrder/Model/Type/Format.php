<?php

class Sid_ExportOrder_Model_Type_Format extends Varien_Object
{
	const TYPE_PLAIN = 'plain';
	const TYPE_OPENTRANS = 'opentrans';
	
    public static function getTypeList()
    {
    	$result = array();
    	$types = Mage::getConfig()->getNode('sid_exportorder/format')->asArray();
    	
    	if(is_array($types)){
	    	foreach($types as $typ)
	    	{
	    		if(isset($typ['typ']) && isset($typ['label'])){
	    			$result[$typ['typ']] =  Mage::helper('exportorder')->__($typ['label']);
	    		}
	    	}
    	}
    	return $result;
    	
    }
    
}