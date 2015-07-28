<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Email Template Mailer Model
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Base_Model_Core_Email_Mailer extends Mage_Core_Model_Email_Template_Mailer
{
 
	protected $_Attachment = null;
	
	public function setAttachment($body, $filename)
	{
		$this->_Attachment = array();
		$this->_Attachment['body'] = $body;
		$this->_Attachment['filename'] = $filename;
	}
	
    public function send()
    {
    	/* @var $emailTemplate Mage_Core_Model_Email_Template */ 
        $emailTemplate = Mage::getModel('core/email_template');
        // Send all emails from corresponding list
        while (!empty($this->_emailInfos)) {
            $emailInfo = array_pop($this->_emailInfos);
            // Handle "Bcc" recepients of the current email
            $emailTemplate->addBcc($emailInfo->getBccEmails());
            // Set required design parameters and delegate email sending to Mage_Core_Model_Email_Template
            $emailTemplate->setDesignConfig(array('area' => 'frontend', 'store' => $this->getStoreId()));
           
            
            $variables = $this->getTemplateParams();
            if(!$variables || !is_array($variables)){
            	$variables = array();
            }
            
            $emailTemplate->load($this->getTemplateId());
            $text = $this->getProcessedTemplate($variables, true);
            $subject = $this->getProcessedTemplateSubject($variables);
            
            /*
            $emails = array_values(is_array($email) ? $email : array($email));
            $names = is_array($name) ? $name : (array)$name;
            $names = array_values($names);
            foreach ($emails as $key => $em) {
            	if (!isset($names[$key])) {
            		$names[$key] = substr($em, 0, strpos($em, '@'));
            	}
            }
            
            $variables['email'] = reset($emails);
            $variables['name'] = reset($names);
            */
            $variables['now'] = date('d.m.Y');
            
            $sender =  $this->getSender();
	        if (!is_array($sender)) {
	            $this->setSenderName(Mage::getStoreConfig('trans_email/ident_' . $sender . '/name', $storeId));
	            $this->setSenderEmail(Mage::getStoreConfig('trans_email/ident_' . $sender . '/email', $storeId));
	        } else {
	            $this->setSenderName($sender['name']);
	            $this->setSenderEmail($sender['email']);
	        }
            
            
          	$setReturnPath = Mage::getStoreConfig(Mage_Core_Model_Email_Template::XML_PATH_SENDING_SET_RETURN_PATH);
          	switch ($setReturnPath) {
          		case 1:
          			$returnPathEmail = $senderEmail;
          			break;
          		case 2:
          			$returnPathEmail = Mage::getStoreConfig(Mage_Core_Model_Email_Template::XML_PATH_SENDING_RETURN_PATH_EMAIL);
          			break;
          		default:
          			$returnPathEmail = null;
          			break;
          	}
          	
            $emailQueue = $this->getQueue();
            $emailQueue->setMessageBody($text);
            $emailQueue->setMessageParameters(array(
            		'subject'           => $subject,
            		'return_path_email' => $returnPathEmail,
            		'is_plain'          => $emailTemplate->isPlain(),
            		'from_email'        => $this->getSenderEmail(),
            		'from_name'         => $this->getSenderName(),
            		//'reply_to'          => $this->getMail()->getReplyTo(),
            		//'return_to'         => $this->getMail()->getReturnPath(),
            ))
            ->addRecipients($emailInfo->getToEmails(), $emailInfo->getToNames(), Mage_Core_Model_Email_Queue::EMAIL_TYPE_TO)
            //->addRecipients($this->_bccEmails, array(), Mage_Core_Model_Email_Queue::EMAIL_TYPE_BCC);
            ;
            
            if($this->_Attachment)
            {
            	$emailQueue->addAttachment($this->_Attachment['body'],
            			Zend_Mime::TYPE_OCTETSTREAM,
            			Zend_Mime::DISPOSITION_ATTACHMENT,
            			Zend_Mime::ENCODING_BASE64,
            			$this->_Attachment['filename']);
            	      	 
            }
            
            
            $emailQueue->addMessageToQueue();
            
            
            
        }
        return $this;
    }
    
    
    private function getQueue()
    {
    	return Mage::getModel('core/email_queue');
    }
    
    
  
    

}
