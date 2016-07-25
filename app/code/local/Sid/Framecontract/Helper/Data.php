<?php

class Sid_Framecontract_Helper_Data extends Mage_Core_Helper_Abstract
{

	/**
	 * 
	 * @param string $template Path
	 * @param array $recipient array(array('name'=>'xxx','email'=>'xx@xx'))
	 * @param array $data template Data
	 * @param number $storeid default 0
	 * @return void|Sid_Framecontract_Helper_Data
	 */
	public function sendEmail($template, array $recipients, array $data = array(), $storeid = 0)
	{
		$template = Mage::getStoreConfig($template, $storeid);
		 
		$translate = Mage::getSingleton('core/translate');
		/* @var $translate Mage_Core_Model_Translate */
		$translate->setTranslateInline(false);
	
		$mailTemplate = Mage::getModel('core/email_template');
		/* @var $mailTemplate Mage_Core_Model_Email_Template */
			
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("framecontract/email/sender_name", $storeid);
		$sender['email'] = Mage::getStoreConfig("framecontract/email/sender_email_address", $storeid);
	
		
		if(strlen($sender['name']) < 2 ){
			$sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeid);
		}
		
		if(strlen($sender['email']) < 2 ){
			$sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeid);
		}
		
		if(Mage::getStoreConfig("framecontract/email/notify_owner", $storeid))
		{
			$recipients[] = $sender;
		}
		
		$emails = array();
		$names = array();
		
		foreach($recipients as $recipient)
		{
			$emails[] = $recipient['email'];
			$names[] = $recipient['name'];
		}
		
		
		$mailTemplate->setReturnPath($sender['email']);
		$mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
		
		try{
			$mailTemplate->sendTransactional(
					$template,
					$sender,
					$emails,
					$names,
					$data,
					$storeid
			);
		}
		catch(Exception $ex)
		{
			Mage::logException($ex);
		}
	
		$translate->setTranslateInline(true);
	
		return $this;
	}
	
	
}