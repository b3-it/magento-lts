<?php

class Sid_ExportOrder_Model_Type_Format extends Varien_Object
{
    public static function getTypeList()
    {
    	$result = array();
    	$types = Mage::getConfig()->getNode('sid_exportorder/format')->asArray();
    	
    	foreach($types as $typ)
    	{
    		if(isset($typ['typ']) && isset($typ['label'])){
    			$result[$typ['typ']] = $typ['label'];
    		}
    	}
    	
    	return $result;
    	
    }
    
}