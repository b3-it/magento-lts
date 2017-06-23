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
 * Rechnung
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Sales_Order_Creditmemo extends Mage_Sales_Model_Order_Creditmemo
{
	
	const ADD_ATTACHMENT_TO_EMAIL_TEMPLATE               = 'sales_email/creditmemo/add_attachment_to_mail';

	protected function _getAddAttachment() {
		$add = Mage::getStoreConfig(self::ADD_ATTACHMENT_TO_EMAIL_TEMPLATE, $this->getStoreId());
		return $add;
	}
    /**
     * Send email with creditmemo data
     *
     * @param boolean $notifyCustomer
     * @param string $comment
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function sendEmail($notifyCustomer = true, $comment = '')
    {
        $order = $this->getOrder();
        $storeId = $order->getStore()->getId();

        if (!Mage::helper('sales')->canSendNewCreditmemoEmail($storeId)) {
            return $this;
        }
        // Get the destination email addresses to send copies to
        $copyTo = $this->_getEmails(Mage_Sales_Model_Order_Creditmemo::XML_PATH_EMAIL_COPY_TO);
        $copyMethod = Mage::getStoreConfig(Mage_Sales_Model_Order_Creditmemo::XML_PATH_EMAIL_COPY_METHOD, $storeId);
        // Check if at least one recepient is found
        if (!$notifyCustomer && !$copyTo) {
            return $this;
        }

        // Start store emulation process
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);

        try {
            // Retrieve specified view block from appropriate design package (depends on emulated store)
            $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())
                ->setIsSecureMode(true);
            $paymentBlock->getMethod()->setStore($storeId);
            $paymentBlockHtml = $paymentBlock->toHtml();
        } catch (Exception $exception) {
            // Stop store emulation process
            $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
            throw $exception;
        }

        // Stop store emulation process
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        // Retrieve corresponding email template id and customer name
        if ($order->getCustomerIsGuest()) {
            $templateId = Mage::getStoreConfig(Mage_Sales_Model_Order_Creditmemo::XML_PATH_EMAIL_GUEST_TEMPLATE, $storeId);
            $customerName = $order->getBillingAddress()->getName();
        } else {
            $templateId = Mage::getStoreConfig(Mage_Sales_Model_Order_Creditmemo::XML_PATH_EMAIL_TEMPLATE, $storeId);
            $customerName = $order->getCustomerName();
        }

        $mailer = Mage::getModel('egovsbase/core_email_template_mailer');
        if ($notifyCustomer) {
            $emailInfo = Mage::getModel('core/email_info');
            $emailInfo->addTo($order->getCustomerEmail(), $customerName);
            if ($copyTo && $copyMethod == 'bcc') {
                // Add bcc to customer email
                foreach ($copyTo as $email) {
                    $emailInfo->addBcc($email);
                }
            }
            $mailer->addEmailInfo($emailInfo);
        }

        // Email copies are sent as separated emails if their copy method is 'copy' or a customer should not be notified
        if ($copyTo && ($copyMethod == 'copy' || !$notifyCustomer)) {
            foreach ($copyTo as $email) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($email);
                $mailer->addEmailInfo($emailInfo);
            }
        }

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig(Mage_Sales_Model_Order_Creditmemo::XML_PATH_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
                'order'        => $order,
                'creditmemo'   => $this,
                'comment'      => $comment,
                'billing'      => $order->getBillingAddress(),
                'payment_html' => $paymentBlockHtml
            )
        );
        
  		if ($this->_getAddAttachment()) {
	        $pdf = Mage::getModel('pdftemplate/pdf_creditmemo');
	        if ($pdf) {
	        	$pdf = $pdf->getPdf(array($this));
	        	$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_EMAIL;
	        	$mailer->setAttachment($pdf->render(),$pdf->Name);
	        }
  		}
  		/** @var $emailQueue Egovs_Base_Model_Core_Email_Queue */
  		$emailQueue = Mage::getModel('egovsbase/core_email_queue');
  		$emailQueue->setEntityId($this->getId())
	  		->setEntityType('creditmemo')
	  		->setEventType('new_creditmemo')
	  		->setIsForceCheck(true);
  		
  		$mailer->setQueue($emailQueue)->send();
  		
        $this->setEmailSent(true);
        $this->_getResource()->saveAttribute($this, 'email_sent');

        return $this;
    }
    
    /**
     * Send email with creditmemo update information
     *
     * @param boolean $notifyCustomer
     * @param string $comment
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function sendUpdateEmail($notifyCustomer = true, $comment = '')
    {
    	$order = $this->getOrder();
    	$storeId = $order->getStore()->getId();
    
    	if (!Mage::helper('sales')->canSendCreditmemoCommentEmail($storeId)) {
    		return $this;
    	}
    	// Get the destination email addresses to send copies to
    	$copyTo = $this->_getEmails(self::XML_PATH_UPDATE_EMAIL_COPY_TO);
    	$copyMethod = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_COPY_METHOD, $storeId);
    	// Check if at least one recepient is found
    	if (!$notifyCustomer && !$copyTo) {
    		return $this;
    	}
    
    	// Retrieve corresponding email template id and customer name
    	if ($order->getCustomerIsGuest()) {
    		$templateId = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_GUEST_TEMPLATE, $storeId);
    		$customerName = $order->getBillingAddress()->getName();
    	} else {
    		$templateId = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_TEMPLATE, $storeId);
    		$customerName = $order->getCustomerName();
    	}
    
    	$mailer = Mage::getModel('egovsbase/core_email_template_mailer');
    	if ($notifyCustomer) {
    		$emailInfo = Mage::getModel('core/email_info');
    		$emailInfo->addTo($order->getCustomerEmail(), $customerName);
    		if ($copyTo && $copyMethod == 'bcc') {
    			// Add bcc to customer email
    			foreach ($copyTo as $email) {
    				$emailInfo->addBcc($email);
    			}
    		}
    		$mailer->addEmailInfo($emailInfo);
    	}
    
    	// Email copies are sent as separated emails if their copy method is 'copy' or a customer should not be notified
    	if ($copyTo && ($copyMethod == 'copy' || !$notifyCustomer)) {
    		foreach ($copyTo as $email) {
    			$emailInfo = Mage::getModel('core/email_info');
    			$emailInfo->addTo($email);
    			$mailer->addEmailInfo($emailInfo);
    		}
    	}
    
    	// Set all required params and send emails
    	$mailer->setSender(Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_IDENTITY, $storeId));
    	$mailer->setStoreId($storeId);
    	$mailer->setTemplateId($templateId);
    	$mailer->setTemplateParams(array(
    			'order'      => $order,
    			'creditmemo' => $this,
    			'comment'    => $comment,
    			'billing'    => $order->getBillingAddress()
    			)
    	);
    	
    	if ($this->_getAddAttachment()) {
    		$pdf = Mage::getModel('pdftemplate/pdf_creditmemo');
    		if ($pdf) {
    			$pdf = $pdf->getPdf(array($this));
    			$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_EMAIL;
    			$mailer->setAttachment($pdf->render(),$pdf->Name);
    		}
    	}
    	/** @var $emailQueue Egovs_Base_Model_Core_Email_Queue */
    	$emailQueue = Mage::getModel('egovsbase/core_email_queue');
    	$emailQueue->setEntityId($this->getId())
	    	->setEntityType('creditmemo')
	    	->setEventType('update_creditmemo')
	    	->setIsForceCheck(true);
    	
    	$mailer->setQueue($emailQueue)->send();
    
    	return $this;
    }
}
