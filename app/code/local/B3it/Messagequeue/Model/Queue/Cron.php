<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  B3it_Messagequeue_Model_Queue_Cron
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Cron extends Mage_Core_Model_Abstract
{
 
    
    /**
     * Einsprung
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     */
	public function runCron($schedule) 
	{		
		Mage::app()->addEventArea(Mage_Core_Model_App_Area::AREA_FRONTEND);
		if ($this->getIsRunning($schedule->getJobCode(), $schedule->getId())) {
			$message ='found running service '.$schedule->getJobCode() ;
			$this->setLog('Found running Service my Id is:' . $schedule->getId());
			Mage::throwException($message);
		}
		$this->_run();
	}
    
	
	protected function _run()
	{
		//in der ersten Ausbaustufe einfach in email queue kopieren
		$collection = Mage::getModel('b3it_mq/queue_message')->getCollection();
		$collection->getSelect()->where('status=?',B3it_Messagequeue_Model_Queue_Messagestatus::STATUS_NEW);
		
		/** @var B3it_Messagequeue_Model_Queue_Message $item */
		foreach ($collection as $item)
		{
			if($item->getStatus() == B3it_Messagequeue_Model_Queue_Messagestatus::STATUS_NEW)
			{
				$item->setStatus(B3it_Messagequeue_Model_Queue_Messagestatus::STATUS_PROCESSING)->save();
				$recipients = explode(';', $item->getRecipients());
				/** @var B3it_Messagequeue_Model_Email_Queue $email */
				/*
				$email = Mage::getModel('b3it_mq/email_queue');
				$email->setMessageBody($item->getContentHtml());
				$email->setMessageBodyPlain($item->getContent());
				$email->setCreatedAt(now());
				$email->setQueueMessageId($item->getId());
				$email->setMessageSubject($item->getSubject());
				$email->setSenderEmail($item->getSenderEmail());
				$email->setSenderName($item->getSenderName());
				$email->setStatus(B3it_Messagequeue_Model_Email_Status::STATUS_NEW);
				$email->setStoreId($item->getStoreId());
				$email->save();
				*/
				$is_plain = mb_strlen($item->getContentHtml()) == 0;
				$text = array();
				if(!$is_plain){
					$text[] = $item->getContentHtml();
					$text[] = '--END_OF_HTML_MAIL';
				}
				$text[] = $item->getContent();
				
				/** @var Mage_Core_Model_Email_Queue $emailQueue */
				$emailQueue = Mage::getModel('core/email_queue');
				$emailQueue->setMessageBody(trim(implode(' ',$text)));
				$emailQueue->setEntityId($item->getId());
				$emailQueue->setEntityType('b3it_message_queue');
				
				$emailQueue->setMessageParameters(array(
						'subject'           => $item->getSubject(),
						//'return_path_email' => $returnPathEmail,
						'is_plain'          => $is_plain,
						'from_email'        => $item->getSenderEmail(),
						'from_name'         => $item->getSenderName(),
						//'reply_to'          => $this->getMail()->getReplyTo(),
						//'return_to'         => $this->getMail()->getReturnPath(),
				))
				->addRecipients($recipients);
				//->addRecipients($this->_bccEmails, array(), Mage_Core_Model_Email_Queue::EMAIL_TYPE_BCC);
				$emailQueue->addMessageToQueue();
				
				$item->setStatus(B3it_Messagequeue_Model_Queue_Messagestatus::STATUS_FINISHED)->save();
			}
		}
		
		
	}
	
    /**
     * 
     * Ermitteln ob noch ein Cronjob läuft
     * @param string  $job_code
     * @param integer $job_id
     * @param Varien_Event $timespan Zeit in sekunden; default 1h
     */
  	protected function getIsRunning($job_code, $job_id, $timespan = 3600)
  	{
  		$collection = Mage::getModel('cron/schedule')->getCollection();
		$collection->addFieldToFilter('job_code', $job_code)
			->addFieldToFilter('schedule_id', array('neq' => $job_id))
			->addFieldToSelect('status')
			//falls noch ein Job in der letzten Stunde läuft	
			->getSelect()
				->where("status = '" . Mage_Cron_Model_Schedule::STATUS_RUNNING."'")
				->where("finished_at >= '". date("Y-m-d H:i:s", time()- $timespan)."'")
		;
		///die($collection->getSelect()->__toString());
		return (count($collection->getItems()) > 0);
  	}
    		
    
}