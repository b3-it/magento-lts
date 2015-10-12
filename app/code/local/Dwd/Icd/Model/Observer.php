<?php

class Dwd_Icd_Model_Observer
{
   
    public function beforeStationSaved(Varien_Event_Observer $observer)
    {
        $station  = $observer->getDataObject();
		if($station instanceof Dwd_Stationen_Model_Stationen)
		{
			if(($station->getOrigData('status') == Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE ) && ($station->getData('status') != Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE)){
				$txt = 'Die Station mit der Kennung '.$station->getStationskennung(). ' wurde deaktivert.';
				$this->sendMailToAdmin($txt);
			}
			return $this;
		}

        return $this;
    }
    
  
    private function sendMailToAdmin($body, $subject="ICD Station wurde deaktiviert") {
    	{
    		$mailTo = Mage::helper('egovsbase')->getAdminMail('dwd_icd/email/admin_email_address');
    		$mailTo = explode(';', $mailTo);
    		/* @var $mail Mage_Core_Model_Email */
    		$mail = Mage::getModel('core/email');
    		//$shopName = Mage::getStoreConfig('general/imprint/shop_name');
    		//$body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
    		$mail->setBody($body);
    		$mailFrom = $this->getGeneralContact();
    		$mail->setFromEmail($mailFrom['mail']);
    		$mail->setFromName($mailFrom['name']);
    		$mail->setToEmail($mailTo);
    			
    		$mail->setSubject($subject);
    		try {
    			$mail->send();
    		}
    		catch(Exception $ex) {
    			$error = Mage::helper('dwd_icd')->__('Unable to send email.');
    				
    			if (isset($ex)) {
    				Mage::log($error.": {$ex->getTraceAsString()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    			} else {
    				Mage::log($error, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    			}
    
    			//TODO: Im Frontend sollte diese Meldung nicht zu sehen sein!
    			//Mage::getSingleton('core/session')->addError($error);
    		}
    	}
    }
    
    private function getGeneralContact() {
    	/* Sender Name */
    	$name = Mage::getStoreConfig('trans_email/ident_general/name');
    	if (strlen($name) < 1) {
    		$name = 'Shop';
    	}
    	/* Sender Email */
    	$mail = Mage::getStoreConfig('trans_email/ident_general/email');
    	if (strlen($mail) < 1) {
    		$mail = 'dummy@shop.de';
    	}
    
    	return array('name' => $name, 'mail' => $mail);
    }
}
