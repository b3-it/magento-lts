<?php
/**
 * Egovs Infoletter
 *
 *
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Model_Queue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Model_Queue extends Mage_Core_Model_Abstract
{

	
	/**
	 * Maximum number of messages to be sent oer one cron run
	 */
	const MESSAGES_LIMIT_PER_CRON_RUN = 2;
	
	const RECIPIENTS_LIMIT_PER_CRON_RUN = 20;
	
	protected $_baseMail = null;

	
	/**
	 * Get the base mail instance
	 *
	 * @return Egovs_Base_Model_Core_Basemail
	*/
	protected function _getBaseMail() {
		if (is_null($this->_baseMail)) {
			$this->_baseMail = Mage::getModel('egovsbase/core_basemail');
		}
	
		return $this->_baseMail;
	}
	
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('infoletter/queue');
    }
    
    
    public function sendAll()
    {
    	$collection = Mage::getModel('infoletter/queue')->getCollection();
    	$collection->getSelect()
    	->where("status=".Egovs_Infoletter_Model_Status::STATUS_SENDING)
    	->limit(self::MESSAGES_LIMIT_PER_CRON_RUN);
    	
    	foreach($collection->getItems() as $queue)
    	{
    		$queue->send();
    	}
    	
    }
    
    
    public function send()
    {
    	/** @var $collection Mage_Core_Model_Resource_Email_Queue_Collection */
    	$collection = Mage::getModel('infoletter/recipient')->getCollection();
    	$collection->getSelect()
    	->where("message_id=".$this->getMessageId())
    	->where("status=".Egovs_Infoletter_Model_Recipientstatus::STATUS_UNSEND);
    	$collection->setPageSize(self::RECIPIENTS_LIMIT_PER_CRON_RUN)
    	->setCurPage(1)
    	->load();
    	 
    	if(count($collection) == 0)
    	{
    		$this->setStatus(Egovs_Infoletter_Model_Status::STATUS_FINISHED);
    		$this->save();
    		return;
    	}
    	 
    	//ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
    	//ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));
    	 
    	/** @var $message Mage_Core_Model_Email_Queue */
    	foreach ($collection as $recipient) {
    		if ($this->getId()) {
    			$parameters = new Varien_Object($this->getMessageParameters());
    			if ($parameters->getReturnPathEmail() !== null) {
    				$mailTransport = new Zend_Mail_Transport_Sendmail("-f" . $parameters->getReturnPathEmail());
    				Zend_Mail::setDefaultTransport($mailTransport);
    			}
    			 
    			$mailer = $this->_getBaseMail();
    			$mailer->getMail()->addTo($recipient->getEmail(), '=?utf-8?B?' . base64_encode($recipient->getName()) . '?=');
    		
    		    $text = $this->getMessageBody();			 
    		    if ($parameters->getIsPlain()) {
                	/*
                	 * Zend_Mime::ENCODING_QUOTEDPRINTABLE ist der Default-Wert,
                	 * dieser darf nach RFC1521 aber nur ASCII enthalten!
                	 */
                	$mailer->getMail()->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($text), null, Zend_Mime::ENCODING_BASE64);
                } else {
                	$boundary = '--END_OF_HTML_MAIL';
                	$boundaryLocation = strpos($text, $boundary);
                	if ($boundaryLocation) {
                		$shtml = substr($text, 0, $boundaryLocation);
                		$stext = str_replace($boundary, '', substr($text, $boundaryLocation));
                		$stext = trim(strip_tags($stext));
                		$mailer->getMail()->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($stext), null, Zend_Mime::ENCODING_BASE64);
                		$mailer->getMail()->setBodyHTML($shtml);
                	} else {
                		/*
                		 * 28.06.2012::Frank Rochlitzer
                		 * Codierung ist notwendig, da Mail sonst nicht korrekt als Multipart content gesendet wird
                		 */
                		$mailer->getMail()->setBodyText(Mage::helper('egovsbase')->__('This mail is in HTML format, please use an HTML ready mail client.'), null, Zend_Mime::ENCODING_BASE64);
                		$mailer->getMail()->setBodyHTML($text);
                	}
                }
    			 
    			$mailer->getMail()->setSubject('=?utf-8?B?' . base64_encode($this->getMessageSubject()) . '?=');
    			$mailer->getMail()->setFrom($this->getSenderEmail(), $this->getSenderName());
    			if ($parameters->getReplyTo() !== null) {
    				$mailer->setReplyTo($parameters->getReplyTo());
    			}
    			if ($parameters->getReturnTo() !== null) {
    				$mailer->setReturnPath($parameters->getReturnTo());
    			}
    			 
    			try {
    				$mailer->send();
    				unset($mailer);
    				$this->setProcessedAt(Varien_Date::formatDate(true));
    				$this->save();
    				$recipient->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_SEND)
    					->setProcessedAt(Varien_Date::formatDate(true))
    					->save();
    			}
    			catch (Exception $e) {
    				unset($mailer);
    				$oldDevMode = Mage::getIsDeveloperMode();
    				Mage::setIsDeveloperMode(true);
    				Mage::logException($e);
    				$recipient->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_ERROR)
    				->setProcessedAt(Varien_Date::formatDate(true))
    				->setErrorText($e->getMessage())
    				->save();
    				Mage::setIsDeveloperMode($oldDevMode);
    				 
    				return false;
    			}
    		}
    	}
    	 
    	return $this;
    }
    
}
