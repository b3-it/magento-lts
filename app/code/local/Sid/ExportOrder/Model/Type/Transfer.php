<?php

class Sid_ExportOrder_Model_Type_Transfer extends Varien_Object
{
	public static function getTypeList()
	{
		$result = array();
		$types = Mage::getConfig()->getNode('sid_exportorder/transfer')->asArray();
		 
		foreach($types as $typ)
		{
			if(isset($typ['typ']) && isset($typ['label'])){
				$result[$typ['typ']] = $typ['label'];
			}
		}
		 
		return $result;
		 
	}
}