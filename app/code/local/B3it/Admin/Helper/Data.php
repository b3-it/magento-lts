<?php
/**
 * Helper
 * 
 * @category	B3it
 * @package		B3it_Admin
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014-2018 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class B3it_Admin_Helper_Data extends Mage_Core_Helper_Data
{
	/**
	 * Unlock locked accounts
	 *
	 * @return int Anzahl entsperrter Accounts
	 */
	public function unlockLockedAccounts() {
	
		$maxFailed = Mage::getStoreConfig('admin/security/max_failed_logins');
		$maxFailed = intval($maxFailed);
		if ($maxFailed == false) {
			$maxFailed = 3;
		}
		/* @var $adminUsers Mage_Admin_Model_Resource_User_Collection */
		$adminUsers = Mage::getResourceModel('admin/user_collection');
		$utcDate = Mage::getModel('core/date')->gmtDate();
		$adminUsers->addFieldToFilter('failed_logins_count', array('gteq' => $maxFailed))
				->addFieldToFilter('is_active', 0)
				//->addFieldToFilter('failed_last_login_date', array('lteq' => $utcDate))
		;
		$adminUsers->addBindParam('utc', $utcDate);
		$adminUsers->getSelect()->where("DATE_ADD(`failed_last_login_date`, INTERVAL LEAST(60 * (`failed_logins_count`+1), 1800) SECOND) <= :utc");
		$sql = $adminUsers->getSelect()->assemble();
		//assemble löst bind params nicht auf
		$sql = preg_replace("/\:utc/", $utcDate, $sql);

		Mage::log(sprintf('b3itadmin::unlockAccounts:SQL:%s',$sql), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		foreach ($adminUsers as $adminUser) {
			$adminUser->setIsActive(true);
		}
		$adminUsers->save();
		
		return $adminUsers->getSize();
	}

    /**
     * ermittelt die im Pfad angegeben Konfiguration der speziellen AdminEMail Adresse
     * falls diese nicht vorhanden wird auf "'trans_email/ident_general/email" ausgewischen
     *
     * @param string $path
     * @return string Admin EMail Adresse
     */
    public function getAdminMail($path = 'trans_email/ident_admin/email') {
        $mail = Mage::getStoreConfig($path);
        if (strlen(trim($mail)) > 0) {
            return $mail;
        }

        return $this->getCustomerSupportMail();
    }

    /**
     * Gibt die Kundensupport Mailadresse aus der Adminkonfiguration zurück.
     *
     * @param string $module Name für Helper
     *
     * @return string
     */
    public function getCustomerSupportMail() {
        //trans_email/ident_support/email
        $mail = Mage::getStoreConfig('trans_email/ident_support/email');
        if (strlen($mail) > 0) {
            return $mail;
        }

        return null;
    }

    /**
     * Liefert den Allgemeinen Kontakt des Shops als array
     *
     * Format:</br>
     * array (
     * 	name => Name
     * 	mail => Mail
     * )
     *
     * @return array <string, string>
     */
    public function getGeneralContact() {
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

    /**
     * Sendet eine Mail mit $body als Inhalt an den Administrator
     *
     * @param string $body    Body der Mail
     * @param string $subject Betreff
     *
     * @return void
     */
    public function sendMailToAdmin($body, $subject="Security:") {
        if (strlen(Mage::getStoreConfig('payment_services/paymentbase/adminemail')) > 0
            && strlen($body) > 0
        ) {
            $mailTo = $this->getAdminMail();
            $mailTo = explode(';', $mailTo);
            /* @var $mail Mage_Core_Model_Email */
            $mail = Mage::getModel('core/email');
            $shopName = Mage::getStoreConfig('general/imprint/shop_name');
            $subject.=$shopName;
            $body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
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
                $error = Mage::helper('b3itadmin')->__('Unable to send email.');

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
}