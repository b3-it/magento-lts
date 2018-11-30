<?php
/**
 * Erweitert die Authentifizierung um die Yubico OTP Funktion
 *
 * @category	B3it
 * @package		B3it_Admin
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class  B3it_Admin_Model_User extends Mage_Admin_Model_User
{
	/**
	 * Authenticate user name and password and save loaded record
	 *
	 * @param string $username Username
	 * @param string $password Password
	 * 
	 * @return boolean
	 * @throws Mage_Core_Exception
	 */
	public function authenticate($username, $password)
	{
		$config = Mage::getStoreConfigFlag('admin/security/use_case_sensitive_login');
		$result = false;
		$otpValid = true;

        Mage::dispatchEvent('admin_user_authenticate_before', array(
            'username' => $username,
            'user'     => $this
        ));

		try {
			$this->loadByUsername($username);
			$sensitive = ($config) ? $username == $this->getUsername() : true;
	
			if ($this->getUseOtpToken()) {
				$otpValid = false;
				if (mb_strlen($password, 'UTF-8') <= 44) {
					//nothing
				} else {
					//Yubico default OTP length is used
					//password+OTP
					$passotp = $password;
					$password = mb_substr($password, 0, -44, 'UTF-8');
					$otp = mb_ereg_replace($password, '', $passotp);
					/* @var $yubicoAuth B3it_Admin_Model_Auth_Yubico */
					$clientID = Mage::helper('b3itadmin')->decrypt(Mage::getStoreConfig('admin/security/yubico_client_id'));
					$apiKey = Mage::helper('b3itadmin')->decrypt(Mage::getStoreConfig('admin/security/yubico_api_key'));
					$https = Mage::getStoreConfigFlag('admin/security/yubico_verfiy_https');
					$yubicoAuth = Mage::getModel('b3itadmin/auth_yubico', array($clientID, $apiKey, $https));
					$ret = $yubicoAuth->parsePasswordOTP($otp);
					$tokenIds = explode(';', $this->getOtpTokenId());
					$tokenId = null;
					foreach ($tokenIds as $tokenId) {
						if ($ret['prefix'] == $tokenId) {
							$otpValid = true;
							break;
						}
					}
				
					if ($otpValid && $yubicoAuth) {
						$yubicoResult = $yubicoAuth->verify($otp, null, false, 'secure');
						if (PEAR::isError($yubicoResult)) {
							/* @var $result PEAR_Error */
							$file = self::getStoreConfig('dev/log/exception_file');
							Mage::log(sprintf('yubico::error: %s', $yubicoResult->getMessage()), Zend_Log::ERR, $file, true); 
							$otpValid = false;
						}
					}
				}
			}
			
			if ($otpValid
                && $sensitive
                && $this->getId()
                && $this->canAuthenticate()
                && Mage::helper('core')->validateHash($password, $this->getPassword())
            ) {
				if ($this->getIsActive() != '1') {
					Mage::throwException(Mage::helper('adminhtml')->__('This account is inactive.'));
				}
				if (!$this->hasAssigned2Role($this->getId())) {
					Mage::throwException(Mage::helper('adminhtml')->__('Access denied.'));
				}
				$result = true;
			}
	
			Mage::dispatchEvent('admin_user_authenticate_after', array(
				'username' => $username,
				'password' => $password,
				'user'     => $this,
				'result'   => $result,
			));
		} catch (Mage_Core_Exception $e) {
			$this->unsetData();
			throw $e;
		}
	
		if (!$result) {
			$this->unsetData();
            Mage::app()->getFrontController()->getResponse()->setHttpResponseCode(401);
		}
		return $result;
	}

	public function canAuthenticate() {
        $fails = $this->getFailedLoginsCount() + 0;
        $maxFailed = Mage::getStoreConfig('admin/security/max_failed_logins');
        if ($maxFailed === false || !is_numeric($maxFailed)) {
            $maxFailed = 3;
        }

        return ($fails < $maxFailed) || ($fails >= $maxFailed && $this->getIsActive() == 1);
    }
}