<?php

class Sid_Haushalt_Model_Type extends Varien_Object
{
    public static function getTypeList()
    {
    	$result = array();
    	$types = Mage::getConfig()->getNode('sid_haushaltsysteme')->asArray();
    	
    	if(is_array($types)){
	    	foreach($types as $typ)
	    	{
	    		if(isset($typ['type']) && isset($typ['label'])){
	    			$result[$typ['type']] = $typ['label'];
	    		}
	    	}
    	}
    	return $result;
    	
    }
    
}