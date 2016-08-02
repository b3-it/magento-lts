<?php
/**
 * 
 *  Helper
 *  @category Egovs
 *  @package  Sid_Framecontract_Helper_Data
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2016 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Framecontract_Helper_Data extends Mage_Core_Helper_Abstract
{

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
		
		//Dateien anhängen
		if(isset($files))
		{
			if(!is_array($files)){
				$files = array($files);
			}
			foreach($files as $file)
			{
				$fileContents = file_get_contents($file->getDiskFilename());
				$attachment = $mailTemplate->getMail()->createAttachment($fileContents);
				$attachment->filename = $file->getfilenameOriginal();
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
		}
	
		$translate->setTranslateInline(true);
	
		return $this;
	}
	
	
	/**
	 * Speichert die Info über die gesendete Email am Rahmenvertrag 
	 * @param int $contractId
	 * @param array $recipients
	 * @param string $user
	 */
	public function saveEmailSendInformation($contractId, $losId, array $recipients, $note ='', $user = null)
	{
		if($user == null){
			$user = Mage::getSingleton('admin/session')->getUser()->getUsername();
		}
		foreach($recipients as $recipient)
		{
			$name = trim($recipient['name'] . ' (' . $recipient['email']).')';
			$transmit = Mage::getModel('framecontract/transmit');
			$transmit->setOwner($user);
			$transmit->setRecipient($name);
			$transmit->setFramecontractContractId($contractId);
			$transmit->setLosId($losId);
			$transmit->setNote($note);
			$transmit->save();
		}
	}
	
	
}