<?php
/**
 *  ExportOrder Helper
 *  @category Sid
 *  @package  Sid_ExportOrder
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_ExportOrder_Helper_Data extends Mage_Core_Helper_Abstract
{

		/**
	 * 
	 * @param string $template Path
	 * @param array $recipient array(array('name'=>'Max','email'=>'max@xx.de'))
	 * @param array $data template Data
	 * @param number $storeid default 0
	 * @param array $attachment array(array('filename'=>'xxx.txt','content'=>'abc'))
	 * @return void|Sid_ExportOrder_Helper_Data
	 */
	public function sendEmail($template, array $recipients, array $data = array(), $storeid = 0, $attachments = null)
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
		if(isset($attachments))
		{
		
			foreach($attachments as $att)
			{
				
				$attachment = $mailTemplate->getMail()->createAttachment($att['content']);
				$attachment->filename = $att['filename'];
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
	
}