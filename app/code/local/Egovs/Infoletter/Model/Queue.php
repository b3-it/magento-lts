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
	protected $_eventPrefix = 'infoletter_queue';
	
	/**
	 * Parameter name in event
	 *
	 * In observe method you can use $observer->getEvent()->getObject() in this case
	 *
	 * @var string
	 */
	protected $_eventObject = 'object';
	
	
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
    	->where("message_id=?", intval($this->getMessageId()))
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
    					$recipient->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_ERROR)
    					->setProcessedAt(Varien_Date::formatDate(true))
    					->setErrorText($mailer->getLastErrorMessage())
    					->save();
    				}
    				
    				else {
    					$recipient->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_SEND)
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
    
    
    public function getProcessedMessageBody(array $variables = array())
    {
    	return $this->getProcessedTemplate($this->getMessageBody(),$variables);
    }
    
    public function getProcessedMessageBodyPlain(array $variables = array())
    {
    	return $this->getProcessedTemplate($this->getMessageBodyPlain(),$variables);
    }
    
    
    private function getProcessedTemplate($text, array $variables = array())
    {
    	/* @var $processor Mage_Newsletter_Model_Template_Filter */
    	$processor = Mage::helper('newsletter')->getTemplateProcessor();
    	$variables['this'] = $this;
   
    

    	if (Mage::app()->isSingleStoreMode()) {
    		$processor->setStoreId(Mage::app()->getStore());
    	} else {
    		$processor->setStoreId($this->getStoreId());
    	}
    	
    	$processor
    	//->setTemplateProcessor(array($this, 'getTemplateByConfigPath'))
    	//->setIncludeProcessor(array($this, 'getInclude'))
    	->setVariables($variables);
    
    	// Filter the template text so that all HTML content will be present
    	$result = $processor->filter($text);
    	
    
    	return $result;
    }
    
    
    private function getHasPlain()
    {
    	return mb_strlen($this->getMessageBodyPlain()) > 1;
    }
    
    private function getHasHtml()
    {
    	return mb_strlen($this->getMessageBody()) > 1;
    }

    /**
     * @param $emails Array $data['email'] = array('prefix'=>,'firstname'=> ,'lastname'=>,'company'=>);
     * @return int Anzahl der eingefügten Adressen
     * @throws Exception
     */
    public function addEmailToQueue($emails)
    {
        $res = 0;

        if($this && ($this->getStatus() ==  Egovs_Infoletter_Model_Status::STATUS_NEW))
        {
            $collection = Mage::getModel('infoletter/recipient')->getCollection();
            $collection->getSelect()->where("message_id=?", intval($this->getId()));
            $exiting = array();
            foreach ($collection->getItems() as $recipient)
            {
                $exiting[] = $recipient->getEmail();
            }

            foreach ($emails as $email => $data)
            {
                if(!in_array($email, $exiting))
                {
                    $recipient =  Mage::getModel('infoletter/recipient');
                    $recipient->setData($data);
                    $recipient->setEmail($email);
                    $recipient->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_UNSEND);
                    $recipient->setMessageId($this->getId());
                    $recipient->save();
                    $res++;
                }
            }

        }

        return $res;
    }
}
