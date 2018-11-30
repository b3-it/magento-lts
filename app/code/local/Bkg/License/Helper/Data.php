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
  * @category   	Bkg License
  * @package    	Bkg_License
  * @name       	Bkg_License_Helper_Data
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_License_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getLicenseFilePath($license_id)
	{
		$path = $path = Mage::getBaseDir('media') . DS .'license'.DS.$license_id;
		if(!file_exists($path))
		{
			try {
				mkdir($path,'0777',true);
			}catch(Exception $ex)
			{
				Mage::logException($ex);
				$path = null;
			}
		}
		
		return $path;
	}
	
	
	/**
	 *
	 * @param string $template Path
	 * @param array $recipient array(array('name'=>'Max','email'=>'max@xx.de'))
	 * @param array $data template Data
	 * @param number $storeid default 0
	 * @param array dateien die versendet werden sollen
	 * @return void|Sid_Framecontract_Helper_Data
	 */
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
		$sender['name'] = Mage::getStoreConfig("bkg_license/email/sender_name", $storeid);
		$sender['email'] = Mage::getStoreConfig("bkg_license/email/sender_email_address", $storeid);
	
	
		if(strlen($sender['name']) < 2 ){
			$sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeid);
		}
	
		if(strlen($sender['email']) < 2 ){
			$sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeid);
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
				//$fileContents = file_get_contents($file->getDiskFilename());
				//$attachment = $mailTemplate->getMail()->createAttachment($fileContents);
				//$attachment->filename = $file->getfilenameOriginal();
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
