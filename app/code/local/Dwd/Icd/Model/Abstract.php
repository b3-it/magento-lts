<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Abstract
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Abstract extends Mage_Core_Model_Abstract
{
	
	//Konstanten für Fehler vom LDAPService die keine für den Shop sind
	
	//0 kein Fehler
	//16 Element nicht vorhanden
	//20 Element schon vorhanden
	//32 Gruppenmidgliedschaft nicht vorhanden
	private $_noError = array(0,16,20);
	private $_noError_addUser = array(68);
	private $_noError_addAttributeNameValuePair = array(20);
	private $_noError_removeAttributeNameValuePair = array(16,32);
	private $_noError_addGroup = array(20);
	private $_noError_removeGroup = array(32);
	
	//lebensdauer der semaphore in sekunden
	protected static $semaphorLifeTime = 40;
	
	
	
	/**
	 * Prüfung anhand des returnCodes auf Fehler
	 * @param Zend_Validate_Exception $error
	 * @param string $action  Methode die aufgerufen wurde
	 * @return boolean
	 */
	protected function isError($error,$action = '')
	{
		
		$s = '_noError_' . $action;
		$a = $this->$s;
		if(!$a) { $a = array();}
		$a = array_merge($a, $this->_noError);
		if(in_array($error->getCode(), $a)) {return false;}
		return !$error->getStatus();
	} 
	
	/**
	 * Püft auf Fehler und gibt einen Status zurück
	 * @param Zend_Validate_Exception $error
	 * @return boolean TRUE = kein Fehler, FALSE = Fehler
	 */
    protected function processError($error, $action = '', $value = '')
    {
    	
    	$msg = "Action: " . $action ." Params: " . $value;
    	if ($error instanceof SoapFault || $error instanceof Exception) {
    		if ($this->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_ERROR) {
    			$this->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PERMANENTERROR);
    		} else {
    			$this->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_ERROR);
    		}
    		
    		if( $error instanceof SoapFault)
    		{
    			$msg = $error->faultstring;
    		}
    		else
    		{
    			$msg = $error->getMessage();
    		}
    		
    		$this->setError($msg)->setUpdateTime(now());
    		$this->save();
    		$this->createErrorMail($msg);
    		Mage::log("ICD:: Sync Error: ".$msg , Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    		return false;
     	} else {
    		if ($this->isError($error,$action)) {
    			if ($this->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_ERROR) {
    				$this->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PERMANENTERROR);
    			} else {
    				$this->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_ERROR);
    			}
    			$this->setError('('.$error->getCode().') '.$error->getMessage())
    				->setUpdateTime(now());
    			$this->save();
    			$this->createErrorMail($msg);
    			Mage::log("ICD:: Sync Error: ".$this->getError()." ".$msg , Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    			return false;	
    		} else {
    			$this->setError('('.$error->getCode().') '.$error->getMessage());
    			//$this->setError('');
    			$this->save();
    			Mage::log("ICD:: Sync Message: " . $this->getError() , Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    		}
    	}
    	
    	return true;
    }
    
    
    protected function createErrorMail($msg = "")
    {
    	$body = $this->getError() . "\n" . $msg;
    	$this->sendMailToAdmin($body);
    }
    
   
	public function sendMailToAdmin($body, $subject="ICD Fehler") {
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
     * speichern welche Befehle tatsächlich zum LDAP gesendet wurden
     * @param integer $accountId
     * @param string $action
     * @param string $param
     * @param string $code
     * @param string $msg
     */
	public function log($accountId,$action,$param,$code,$msg)
	{
		$log = Mage::getModel('dwd_icd/account_log');
		$log->setAccountId($accountId);
		$log->setAction($action);
		$log->setParam($param);
		$log->setReturnCode($code);
		$log->setReturnMsg($msg);
		$log->save();
	}
	
	protected function getMutexKey()
	{
		return 'icd_abstract_'.$this->getId();
	}
	
	protected function getIsSetMutex()
	{
		if (function_exists('apc_add') && function_exists('apc_fetch')) {
			$apcKey = $this->getMutexKey();
			if (apc_fetch($apcKey)) {
				Mage::log("ICD:: APC_FETCH: already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
				return true;
			}
		}	

	
		
		if($this->getSemaphor() >= self::getMutexReleaseTime())
		{
			return true;
		}
		
		return false;
	}
	
	public static function getMutexReleaseTime()
	{
		//lebenszeit in sekunden
		$lifetime = self::$semaphorLifeTime;
	
		if (function_exists('microtime')) {
			$releaseTime = microtime(true) - ($lifetime );
		} else {
			$releaseTime = time() - $lifetime;
		}
		
		return $releaseTime;
	}
	
	
	protected function removeMutex()
	{
		if (function_exists('apc_delete') ){
			$apcKey = $this->getMutexKey();
			$apcAdded = apc_delete($apcKey);
		}
		
		$this->setSemaphor(0);
		$this->getResource()->saveField($this, 'semaphor');
		return $this;
	}
	
	protected function setMutex()
	{
		if (function_exists('microtime')) {
			$startTime = microtime(true);
		} else {
			$startTime = time();
		}
		 
				 
		if (function_exists('apc_add') && function_exists('apc_fetch')) {
			$apcKey = $this->getMutexKey();
			
			//dauert ca. 1msec
			//TTL = 180s = 3Min
			$apcAdded = apc_add($apcKey, true, self::$semaphorLifeTime);
		}
		
		//semaphor immer speichern wg. datenbank abfrage 
			
			if (function_exists('microtime')) {
				$this->setSemaphor(microtime(true));
			} else {
				$this->setSemaphor(time());
			}
			$this->getResource()->saveField($this, 'semaphor');
		
		if (function_exists('microtime')) {
			$endTime = microtime(true);
		} else {
			$endTime = time();
		}
		$runTime = $endTime - $startTime;
		if ($runTime > 8) {
			Mage::log("ICD:: Server seems to be under heavy load!", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
		} else {
			$this->setLog(sprintf("ICD:: Measured runtime for MUTEX was %s seconds.", $runTime), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			
		}
		
		
	}
	
	
    
}