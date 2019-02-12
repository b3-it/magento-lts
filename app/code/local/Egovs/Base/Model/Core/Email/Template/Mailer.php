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
 * @package     Mage_Core
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Email Template Mailer Model
 *
 * @method Mage_Core_Model_Email_Template_Mailer setQueue(Mage_Core_Model_Abstract $value)
 * @method Mage_Core_Model_Email_Queue getQueue()
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Core_Email_Template_Mailer extends Mage_Core_Model_Email_Template_Mailer
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
    	/** @var $emailTemplate Mage_Core_Model_Email_Template */
    	$emailTemplate = Mage::getModel('core/email_template');
    	// Send all emails from corresponding list
    	while (!empty($this->_emailInfos)) {
    		$emailInfo = array_pop($this->_emailInfos);
    		// Handle "Bcc" recipients of the current email
    		$emailTemplate->addBcc($emailInfo->getBccEmails());
    		
    		if($this->_Attachment) {
    			if ($emailQueue = $this->getQueue()) {
    				$emailQueue->addAttachment($this->_Attachment['body'],
    						Zend_Mime::TYPE_OCTETSTREAM,
    						Zend_Mime::DISPOSITION_ATTACHMENT,
    						Zend_Mime::ENCODING_BASE64,
    						$this->_Attachment['filename']);
    			} else {
	    			$emailTemplate->getMail()->createAttachment($this->_Attachment['body'],
	    					Zend_Mime::TYPE_OCTETSTREAM,
	    					Zend_Mime::DISPOSITION_ATTACHMENT,
	    					Zend_Mime::ENCODING_BASE64,
	    					$this->_Attachment['filename']);
    			}
    		}
    		
    		// Set required design parameters and delegate email sending to Mage_Core_Model_Email_Template
    		$emailTemplate->setDesignConfig(array('area' => 'frontend', 'store' => $this->getStoreId()))
	    		->setQueue($this->getQueue())
	    		->sendTransactional(
    				$this->getTemplateId(),
    				$this->getSender(),
    				$emailInfo->getToEmails(),
    				$emailInfo->getToNames(),
    				$this->getTemplateParams(),
    				$this->getStoreId()
    		);
    	}
    	return $this;
    }
}
