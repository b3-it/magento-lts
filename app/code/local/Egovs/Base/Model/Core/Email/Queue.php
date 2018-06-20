<?php
/**
 * Erweitert die Core-Mail Funktion um das Senden über SMTP, Mime-Kompatibilität und UTF-8 Kodierung
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Base_Model_Core_Email_Queue extends Mage_Core_Model_Email_Queue 
{

	protected $_baseMail = null;
	protected $_attachment  = array(); 
	
	/**
	 * Get the base mail instance
	 *
	 * @return Egovs_Base_Model_Core_Basemail
	 */
	protected function _getBaseMail() {
		if (is_null($this->_baseMail)) {
			$this->_baseMail = Mage::getModel('egovsbase/core_basemail');
			$this->_baseMail->setIsQueueProcess();
		}
	
		return $this->_baseMail;
	}
	
	
	public function addAttachment($body,
									 $mimeType    = Zend_Mime::TYPE_OCTETSTREAM,
                                     $disposition = Zend_Mime::DISPOSITION_ATTACHMENT,
                                     $encoding    = Zend_Mime::ENCODING_BASE64,
                                     $filename    = null)
    {

    	
       
    	$att = Mage::getModel('egovsbase/core_email_queue_attachment');
    	$att->setBody($body);
    	$att->setBodyHash(md5($body));
    	$att->setMimeType($mimeType);
    	$att->setDisposition($disposition);
    	$att->setEncoding($encoding);
    	$att->setFilename($filename);
    	$this->_attachment[]= $att;
        return $this;
    }
    
    protected function _afterSave() {
    	parent::_afterSave();
    	
    	foreach($this->_attachment as $att) {
    		$att->setMessageId($this->getId());
    		$att->save();
    	}
    	
    }
	
    public function send()
    {
        /** @var $collection Mage_Core_Model_Resource_Email_Queue_Collection */
        $collection = Mage::getModel('core/email_queue')->getCollection()
            ->addOnlyForSendingFilter()
            ->setPageSize(self::MESSAGES_LIMIT_PER_CRON_RUN)
            ->setCurPage(1)
            ->load();


        //ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
        //ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));

        /** @var $message Mage_Core_Model_Email_Queue */
        foreach ($collection as $message) {
            if ($message->getId()) {
                $parameters = new Varien_Object($message->getMessageParameters());
                if ($parameters->getReturnPathEmail() !== null) {
                    $mailTransport = new Zend_Mail_Transport_Sendmail("-f" . $parameters->getReturnPathEmail());
                    Zend_Mail::setDefaultTransport($mailTransport);
                }

                $mailer = $this->_getBaseMail()->getMail();
                foreach ($message->getRecipients() as $recipient) {
                    list($email, $name, $type) = $recipient;
                    switch ($type) {
                        case self::EMAIL_TYPE_BCC:
                            $mailer->addBcc($email, '=?utf-8?B?' . base64_encode($name) . '?=');
                            break;
                        case self::EMAIL_TYPE_TO:
                        case self::EMAIL_TYPE_CC:
                        default:
                            $mailer->addTo($email, '=?utf-8?B?' . base64_encode($name) . '?=');
                            break;
                    }
                }
             
                $text = $message->getMessageBody();
                
                /*
                 * 20111220:Frank Rochitzer
                 * Mails werden jetzt als Multipart-Content versendet
                 * @see http://www.magentocommerce.com/boards/viewthread/25075/P15/
                 * Kommentar von: _wookie_ (2010-06-14)
                 */
                if ($parameters->getIsPlain()) {
                	/*
                	 * Zend_Mime::ENCODING_QUOTEDPRINTABLE ist der Default-Wert,
                	 * dieser darf nach RFC1521 aber nur ASCII enthalten!
                	 */
                	$mailer->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($text), null, Zend_Mime::ENCODING_BASE64);
                } else {
                	$boundary = '--END_OF_HTML_MAIL';
                	$boundaryLocation = strpos($text, $boundary);
                	if ($boundaryLocation) {
                		$shtml = substr($text, 0, $boundaryLocation);
                		$stext = str_replace($boundary, '', substr($text, $boundaryLocation));
                		$stext = trim(strip_tags($stext));
                		$mailer->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($stext), null, Zend_Mime::ENCODING_BASE64);
                		$mailer->setBodyHTML($shtml);
                	} else {
                		/*
                		 * 28.06.2012::Frank Rochlitzer
                		 * Codierung ist notwendig, da Mail sonst nicht korrekt als Multipart content gesendet wird
                		 */
                		$mailer->setBodyText(Mage::helper('egovsbase')->__('This mail is in HTML format, please use an HTML ready mail client.'), null, Zend_Mime::ENCODING_BASE64);
                		$mailer->setBodyHTML($text);
                	}
                }
                

                $mailer->setSubject('=?utf-8?B?' . base64_encode($parameters->getSubject()) . '?=');
                $mailer->setFrom($parameters->getFromEmail(), $parameters->getFromName());
                if ($parameters->getReplyTo() !== null) {
                    $mailer->setReplyTo($parameters->getReplyTo());
                }
                if ($parameters->getReturnTo() !== null) {
                    $mailer->setReturnPath($parameters->getReturnTo());
                }

                
                $attachments = Mage::getModel('egovsbase/core_email_queue_attachment')->getCollection();
                $attachments->getSelect()->where('message_id = ? ', $message->getId());
                foreach ($attachments->getItems() as $att) {
                	$mailer->createAttachment($att->getBody(),$att->getMimeType(),$att->getDisposition(),$att->getEncoding(),$att->getFilename());
                }
                
                try {
                	$this->_getBaseMail()->send();
                    unset($mailer);
                    unset($this->_baseMail);
                    $message->setProcessedAt(Varien_Date::formatDate(true));
                    $message->save();
                } catch (Exception $e) {
                    unset($mailer);
                    unset($this->_baseMail);
                    $oldDevMode = Mage::getIsDeveloperMode();
                    Mage::setIsDeveloperMode(true);
                    Mage::logException($e);
                    Mage::setIsDeveloperMode($oldDevMode);

                    return false;
                }
            }
        }

        return $this;
    }

    /**
     * Add message to queue
     *
     * @return Mage_Core_Model_Email_Queue
     */
    public function addMessageToQueue() {
        if ($this->getIsForceCheck() && $this->_getResource()->wasEmailQueued($this)) {
            Mage::log("egovs::email_queue: Mail already queued!", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
            return $this;
        }
        try {
            $this->save();
            $this->setId(null);
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $this;
    }

    public function hasAttachments() {
        return !empty($this->_attachment);
    }

    public function getAttachments() {
        return $this->_attachment;
    }
}
