<?php 

class Egovs_SepaDebitSax_Model_Email extends Varien_Object
{
	private $_template = null; 
	private $_filename = "SepaMandat.pdf";
	private $_templatedata = array();
	
	/**
	 * Email Template setzen
	 * 
	 * @param int $template
	 * @return Egovs_SepaDebitSax_Model_Email
	 */
	public function setTemplate($template)
	{
		$this->_template = $template;
		return $this;
	}
	
	/**
	 * Daten für die Verwendung im Email Template anhängen
	 * 
	 * @param unknown $key
	 * @param unknown $value
	 * @return Egovs_SepaDebitSax_Model_Email
	 */
	public function addTemplateVar($key,$value)
	{
		$this->_templatedata[$key] = $value;
		
		return $this;
	}
	
	/**
	 * Namen für das Attachment setzen
	 * @param unknown $filename
	 * @return Egovs_SepaDebitSax_Model_Email
	 */
	public function setFilename($filename)
	{
		$this->_filename = $filename;
		return $this;
	}
	
	
	/**
	 * 
	 * @param unknown $customer
	 * @param unknown $attachment
	 * @param unknown $storeId
	 * 
	 * @return Egovs_SepaDebitSax_Model_Email
	 * 
	 * @deprecated see Egovs_SepaDebitSax_Model_Email::sendEmail
	 */
	public function send($customer, $attachment, $storeId = null) {
		return $this->sendEmail($customer, $attachment, $storeId);
	}
	
	/**
	 * 
	 * @param Mage_Customer_Model_Customer|int $customer Kunde
	 * @param unknown $attachment
	 * @param int|Store $storeId
	 * 
	 * @return Egovs_SepaDebitSax_Model_Email
	 */
	public function sendEmail($customer, $attachment, $storeId = null)
	{
		if (!($customer instanceof Varien_Object)) {
			$customer = Mage::getModel('customer/customer')->load(intval($customer));
		}
		
		if ($customer->isEmpty()) {
			Mage::log('Could not send mandate notification mail! Customer was empty!', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			return $this;
		}
		
		/** @var $mailer Egovs_Base_Model_Core_Email_Mailer */
		$mailer = Mage::getModel('egovsbase/core_email_mailer');
		$emailInfo = Mage::getModel('core/email_info');
		$emailInfo->addTo($customer->getEmail(), $customer->getName());
		
		$mailer->addEmailInfo($emailInfo);
		
		$templateId =  Mage::getStoreConfig("payment/sepadebitsax/notification_template", $storeId);
		if ($this->_template != null) {
			$templateId =  Mage::getStoreConfig($this->_template, $storeId);
		}
		
		$this->_templatedata["customer"] = $customer;
		
		// Set all required params and send emails
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("trans_email/ident_sales/name", $storeId);
		$sender['email'] = Mage::getStoreConfig("trans_email/ident_sales/email", $storeId);
		$mailer->setSender($sender);
		$mailer->setStoreId($storeId);
		$mailer->setTemplateId($templateId);
		$mailer->setTemplateParams($this->_templatedata);
		
		if ($attachment) {
			$mailer->setAttachment($attachment, $this->_filename);
		}
		
		try {
			/** @var $emailQueue Egovs_Base_Model_Core_Email_Queue */
			$emailQueue = Mage::getModel('egovsbase/core_email_queue');
			$emailQueue->setEntityId($customer->getId())
				->setEntityType('customer')
				->setEventType('customer_information')
				->setIsForceCheck(true);
			
			$mailer->setQueue($emailQueue)->send();
		} catch(Exception $ex) {
			Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
			Mage::logException($ex);
		}
		
		return $this;
	}
}