<?php 


class Egovs_SepaDebitSax_Model_Email extends Varien_Object
{

	private $_template = null; 
	private $_filename = "SepaMandat.pdf";
	private $_templatedata = array();
	
	/**
	 * Email Template setzen
	 * @param int $template
	 * @return Egovs_SepaDebitSax_Model_Email
	 */
	public function setTemplate($template)
	{
		$this->_template = $template;
		return $this;
	}
	
	/**
	 * Daten für die Verwendung im Email TEmplate anhängen
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
	
	
	public function send($customer, $attachment, $storeId = 0)
	{
		if(! $customer instanceof Varien_Object)
		{
			$customer = Mage::getModel('customer/customer')->load(intval($customer));
		}

		$translate = Mage::getSingleton('core/translate');
		/* @var $translate Mage_Core_Model_Translate */
		$translate->setTranslateInline(false);
		
		$mailTemplate = Mage::getModel('core/email_template');
		/* @var $mailTemplate Mage_Core_Model_Email_Template */
		
		$templateid =  Mage::getStoreConfig("payment/sepadebitsax/notification_template", $storeId);
		if($this->_template != null)
		{
			$templateid =  Mage::getStoreConfig($this->_template, $storeId);
		}
		
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("trans_email/ident_sales/name", $storeId);
		$sender['email'] =Mage::getStoreConfig("trans_email/ident_sales/email", $storeId);
		
		
		if($attachment)
		{
			$fileContents = $attachment;
			$attachment = $mailTemplate->getMail()->createAttachment($fileContents);
			$attachment->filename = $this->_filename;
		}
		

		$this->_templatedata["customer"] = $customer;
		
		$empf_email = $customer->getEmail();
		
		//foreach ($vendorEMail as $mail)
		{
			try {
				//$mailTemplate->setReturnPath($user->getEmail());
				$mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeId));
				$mailTemplate->sendTransactional(
						$templateid,
						$sender,
						$empf_email,
						null,
						$this->_templatedata
				);
				 
					
				$translate->setTranslateInline(true);
			}
			 
			catch(Exception $ex)
			{
				Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
				Mage::logException($ex);
			}
		}
		return $this;
		}
}