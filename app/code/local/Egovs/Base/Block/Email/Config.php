<?php

/***
 * Block zum Ausgeben von config Variablen (in EmailTemplates )
 * benutzung :  {{block type="egovsbase/email_config" path="trans_email/ident_general/email"}}. 
 */

class Egovs_Base_Block_Email_Config extends Mage_Core_Block_Template {
	

	
	protected function _toHtml() 
	{
		if($this->getPath())
		{
			return Mage::getStoreConfig($this->getPath());
		}
		return ""; 
	}
}