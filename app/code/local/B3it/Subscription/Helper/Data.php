<?php
/**
 * B3it Subscription
 *
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Helper_Data
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Sendet Mails
	 * 
	 * @param string                       $EmailAddress Mail
	 * @param Mage_Customer_Model_Customer $customer     Customer
	 * @param array                        $data         Daten
	 * @param string                       $template     e.g "b3it_subscription/email/renewal_subscription_template"
	 * 
	 * @return B3it_Subscription_Model_Subscription
	 */
	public function sendEmail($EmailAddress, $customer, $data, $template)
	{
		try
		{
			$storeid = $customer->getStoreId();
			 
			$translate = Mage::getSingleton('core/translate');
			/* @var $translate Mage_Core_Model_Translate */
			$translate->setTranslateInline(false);
				
			$mailTemplate = Mage::getModel('core/email_template');
			/* @var $mailTemplate Mage_Core_Model_Email_Template */
				
				
			$template = Mage::getStoreConfig($template, $storeid);
				
				
			$sender = array();
			$sender['name'] = Mage::getStoreConfig("b3it_subscription/email/subscription_email_sender", $storeid);
			$sender['email'] = Mage::getStoreConfig("b3it_subscription/email/subscription_email_address", $storeid);

			if (strlen($sender['name']) < 2) {
				Mage::log('SubscriptionModul::Email Absendername ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}

			if (strlen($sender['email']) < 2) {
				Mage::log('SubscriptionModul::Email Absendemail ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}

			if (!Zend_Validate::is($sender['email'], 'EmailAddress')) {
				Mage::throwException(Mage::helper('adminhtml')->__('Invalid email address "%s".', $sender['email']));
			}

			if (!is_array($data)) {
				$data = array();
			}

			$data['customer'] = $customer;
			$data['current_date'] = time();//date('d.m.Y');

			$mailTemplate->setReturnPath($sender['email']);
			$mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
			$mailTemplate->sendTransactional(
					$template,
					$sender,
					$EmailAddress,
					'',
					$data
			);
				
				
			$translate->setTranslateInline(true);
		} catch (Exception $ex) {
			Mage::logException($ex);
			Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::getSingleton('core/session', array('name'=>'adminhtml'));
			if (Mage::getSingleton('admin/session')->isLoggedIn()) {
				Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
			}
		}
		return $this;
	}
}