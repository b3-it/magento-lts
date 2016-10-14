<?php

class Sid_ExportOrder_Model_Type_Transfer extends Varien_Object
{
	const TRANSFER_TYPE_EMAIL = 'email';
	const TRANSFER_TYPE_POST = 'post';
	const TRANSFER_TYPE_EMAIL_ATTACHMENT = 'email_attachment';
	const TRANSFER_TYPE_LINK = 'link';
	
	public static function getTypeList()
	{
		$result = array();
		$types = Mage::getConfig()->getNode('sid_exportorder/transfer')->asArray();
		
		if(is_array($types)){
			foreach($types as $typ)
			{
				if(isset($typ['typ']) && isset($typ['label'])){
					$result[$typ['typ']] = Mage::helper('exportorder')->__($typ['label']);
				}
			}
		}
		 
		return $result;
		 
	}
}