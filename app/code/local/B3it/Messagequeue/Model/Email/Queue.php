<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Model_Email_Queue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 *  @method int getMessageId()
 *  @method setMessageId(int $value)
 *  @method int getStatus()
 *  @method setStatus(int $value)
 *  @method int getQueueMessageId()
 *  @method setQueueMessageId(int $value)
 *  @method int getStoreId()
 *  @method setStoreId(int $value)
 *  @method string getMessageBodyHash()
 *  @method setMessageBodyHash(string $value)
 *  @method string getMessageBody()
 *  @method setMessageBody(string $value)
 *  @method string getMessageBodyPlain()
 *  @method setMessageBodyPlain(string $value)
 *  @method string getMessageSubject()
 *  @method setMessageSubject(string $value)
 *  @method string getTitle()
 *  @method setTitle(string $value)
 *  @method string getSenderName()
 *  @method setSenderName(string $value)
 *  @method string getSenderEmail()
 *  @method setSenderEmail(string $value)
 *  @method string getMessageParameters()
 *  @method setMessageParameters(string $value)
 *  @method  getCreatedAt()
 *  @method setCreatedAt( $value)
 *  @method  getProcessedAt()
 *  @method setProcessedAt( $value)
 */
class B3it_Messagequeue_Model_Email_Queue extends Mage_Core_Model_Abstract
{
	/**
	 * Maximum number of messages to be sent or one cron run
	 */
	const MESSAGES_LIMIT_PER_CRON_RUN = 2;
	
	const RECIPIENTS_LIMIT_PER_CRON_RUN = 20;
	
	protected $_baseMail = null;
	
	
	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'messagequeue_emailqueue';
	
	/**
	 * Parameter name in event
	 *
	 * In observe method you can use $observer->getEvent()->getObject() in this case
	 *
	 * @var string
	 */
	protected $_eventObject = 'object';
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_mq/email_queue');
    }
    

	
	
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
	
	

    
    public function sendAll()
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()
    	->where("status=".B3it_Messagequeue_Model_Email_Status::STATUS_SENDING)
    	->limit(self::MESSAGES_LIMIT_PER_CRON_RUN);
    	
    	foreach($collection->getItems() as $queue)
    	{
    		$queue->send();
    	}
    	
    }
    
    
    public function send()
    {
    	/** @var $collection Mage_Core_Model_Resource_Email_Queue_Collection */
    	$collection = Mage::getModel('b3it_mq/email_recipient')->getCollection();
    	$collection->getSelect()
    	->where("message_id=?", intval($this->getMessageId()))
    	->where("status=".B3it_Messagequeue_Model_Email_Recipientstatus::STATUS_UNSEND);
    	$collection->setPageSize(self::RECIPIENTS_LIMIT_PER_CRON_RUN)
    	->setCurPage(1)
    	->load();
    	 
    	if(count($collection) == 0)
    	{
    		$this->setStatus(B3it_Messagequeue_Model_Email_Status::STATUS_FINISHED);
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
    		    if ($this->getHasPlain()) {
                	/*
                	 * Zend_Mime::ENCODING_QUOTEDPRINTABLE ist der Default-Wert,
                	 * dieser darf nach RFC1521 aber nur ASCII enthalten!
                	 */
    		    	$variables = $recipient->getData();
    		    	$text = $this->getProcessedMessageBodyPlain($variables);
                	$mailer->getMail()->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($text), null, Zend_Mime::ENCODING_BASE64);
                } 
                
                if ($this->getHasHtml()) {
                	/*
                	 * Zend_Mime::ENCODING_QUOTEDPRINTABLE ist der Default-Wert,
                	 * dieser darf nach RFC1521 aber nur ASCII enthalten!
                	 */
                	$variables = $recipient->getData();
                	$text = $this->getProcessedMessageBody($variables);
                	$mailer->getMail()->setBodyHTML(Mage::helper('egovsbase')->htmlEntityDecode($text), null, Zend_Mime::ENCODING_BASE64);
                	if (!$this->getHasPlain()) 
                	{
                		$mailer->getMail()->setBodyText(Mage::helper('egovsbase')->__('This mail is in HTML format, please use an HTML ready mail client.'), null, Zend_Mime::ENCODING_BASE64);
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
    				
    				$this->setProcessedAt(Varien_Date::formatDate(true));
    				$this->save();
    				
    				if($mailer->getLastErrorMessage())
    				{
    					$recipient->setStatus(B3it_Messagequeue_Model_Email_Recipientstatus::STATUS_ERROR)
    					->setProcessedAt(Varien_Date::formatDate(true))
    					->setErrorText($mailer->getLastErrorMessage())
    					->save();
    				}
    				
    				else {
    					$recipient->setStatus(B3it_Messagequeue_Model_Email_Recipientstatus::STATUS_SEND)
    					->setProcessedAt(Varien_Date::formatDate(true))
    					->save();
    				}
    				unset($mailer);
    			}
    			catch (Exception $e) {
    				unset($mailer);
    				$oldDevMode = Mage::getIsDeveloperMode();
    				Mage::setIsDeveloperMode(true);
    				Mage::logException($e);
    				$recipient->setStatus(B3it_Messagequeue_Model_Email_Recipientstatus::STATUS_ERROR)
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
