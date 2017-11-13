<?php
/**
 * <Namespace> <Module>
 *
 *
 * @category   	<Namespace>
 * @package    	<Namespace>_<Module>
 * @name       	<Namespace>_<Module>_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

 /**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse_Helper_Data
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Barkasse_Helper_Data extends Egovs_Paymentbase_Helper_Data
{

	public function sendEmail($template, array $recipients, array $data = array(), $storeid = 0, $files = null)
	{
		if(!is_numeric($template))
		{
			$templateId = Mage::getStoreConfig($template, $storeid);
		}
		//prüfen ob pfad zur config oder TemplateIdentifier
		if($templateId){
			$template = $templateId;
		}
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
	
		//Dateien anhängen
		if(isset($files))
		{
			if(!is_array($files)){
				$files = array($files);
			}
			foreach($files as $file)
			{
				
				$attachment = $mailTemplate->getMail()->createAttachment($file['content']);
				$attachment->filename = $file['filename'];
			}
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
			return false;
		}
	
		$translate->setTranslateInline(true);
	
		return $this;
	}
}
