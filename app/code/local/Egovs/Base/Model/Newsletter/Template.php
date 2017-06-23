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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Newsletter
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Template model
 *
 * @see Mage_Newsletter_Model_Template
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Newsletter_Template extends Mage_Newsletter_Model_Template
{

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
	
	/**
	 * Retrieve mail object instance
	 *
	 * @return Zend_Mail
	 */
	public function getMail() {
		if (is_null($this->_mail)) {
			$this->_mail = $this->_getBaseMail()->getMail();
		}

		return $this->_mail;
	}

	/**
	 * Send mail to subscriber
	 *
	 * @param Mage_Newsletter_Model_Subscriber|string $subscriber subscriber Model or E-mail
	 * @param array                                   $variables  template variables
	 * @param string|null                             $name       receiver name (if subscriber model not specified)
	 * @param Mage_Newsletter_Model_Queue|null        $queue      queue model, used for problems reporting.
	 * 
	 * @return boolean
	 **/
	public function send($subscriber, array $variables = array(), $name=null, Mage_Newsletter_Model_Queue $queue=null)
	{
	    if (!$this->isValidForSend()) {
	        return false;
	    }
	    
	    $email = '';
	    if ($subscriber instanceof Mage_Newsletter_Model_Subscriber) {
	        $email = $subscriber->getSubscriberEmail();
	        if (is_null($name)) {
	            $name = $subscriber->getSubscriberFullName();
	        }
	    } else {
	        $email = (string) $subscriber;
	    }
	    
	    if (Mage::getStoreConfigFlag(Mage_Core_Model_Email_Template::XML_PATH_SENDING_SET_RETURN_PATH)) {
	        $this->getMail()->setReturnPath($this->getTemplateSenderEmail());
	    }
	    
	    // 		ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
	    // 		ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));
	    
	    $mail = $this->getMail();
	    $mail->addTo($email, empty($name) ? '' : '=?utf-8?B?'.base64_encode($name).'?=');
	    $text = $this->getProcessedTemplate($variables, true);
	    
	    /*
	     * 20111220:Frank Rochitzer
	     * Mails werden jetzt als Multipart-Content versendet
	     * @see http://www.magentocommerce.com/boards/viewthread/25075/P15/
	     * Kommentar von: _wookie_ (2010-06-14)
	     */
	    if ($this->isPlain()) {
	        /*
	         * Zend_Mime::ENCODING_QUOTEDPRINTABLE ist der Default-Wert,
	         * dieser darf nach RFC1521 aber nur ASCII enthalten!
	         */
	        $mail->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($text), null, Zend_Mime::ENCODING_BASE64);
	    } else {
	        $boundary = '--END_OF_HTML_MAIL';
	        $boundary_location = strpos($text, $boundary);
	        if ($boundary_location) {
	            $shtml = substr($text, 0, $boundary_location);
	            $stext = str_replace($boundary, '', substr($text, $boundary_location));
	            $stext = trim(strip_tags($stext));
	            $mail->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($stext), null, Zend_Mime::ENCODING_BASE64);
	            $mail->setBodyHTML($shtml);
	        } else {
	            /*
	             * 28.06.2012::Frank Rochlitzer
	             * Codierung ist notwendig, da Mail sonst nicht korrekt als Multipart content gesendet wird
	             */
	            $mail->setBodyText(Mage::helper('egovsbase')->__('This mail is in HTML format, please use an HTML ready mail client.'), null, Zend_Mime::ENCODING_BASE64);
	            $mail->setBodyHTML($text);
	        }
	    }
	    
	    $mail->setSubject('=?utf-8?B?'.base64_encode($this->getProcessedTemplateSubject($variables)).'?=');
	    $mail->setFrom($this->getTemplateSenderEmail(), '=?utf-8?B?'.base64_encode($this->getTemplateSenderName()).'?=');
	    
	    try {
	        $this->_getBaseMail()->send();
	        $this->_mail = null;
	        $this->_baseMail = null;
	        if (!is_null($queue)) {
	            $subscriber->received($queue);
	        }
	    }
	    catch (Exception $e) {
	        if ($subscriber instanceof Mage_Newsletter_Model_Subscriber) {
	            // If letter sent for subscriber, we create a problem report entry
	            $problem = Mage::getModel('newsletter/problem');
	            $problem->addSubscriberData($subscriber);
	            if (!is_null($queue)) {
	                $problem->addQueueData($queue);
	            }
	            $problem->addErrorData($e);
	            $problem->save();
	            
	            if (!is_null($queue)) {
	                $subscriber->received($queue);
	            }
	        } else {
	            // Otherwise throw error to upper level
	            throw $e;
	        }
	        Mage::log($e, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
	        return false;
	    }
	    
	    return true;
	}
}