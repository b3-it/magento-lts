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
    
    /**
     * export model Anhand des Types erzeugen
     * 
     * @param string  $type
     * @return Mage_Core_Model_Abstract|false|NULL
     */
    public static function factory($type){
    	$types = Mage::getConfig()->getNode('sid_haushaltsysteme')->asArray();
    	if(is_array($types)){
    		foreach($types as $typ)
    		{
    			if(isset($typ['type']) && isset($typ['model'])){
    				if($typ['type'] == $type){
    					return Mage::getModel($typ['model']);
    				}
    			}
    		}
    	}
    	return Mage::getModel('sidhaushalt/export_type_default');
    }
    
}