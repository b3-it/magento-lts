<?php
/**
 * Dwd Icd
 * 
 * @var login
 * @var password
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Account
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Account extends Dwd_Icd_Model_Abstract
{
	
	private $_soapClient = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/account');
    }
    
    
  
    public static function loadOrCreate($customerId, $is_shareable, $email, $connectionId, $pwd = null)
    {
    	
    		$account = null;
    		if(($customerId != 0) && ($is_shareable))
    		{
    			$collection = Mage::getModel('dwd_icd/account')->getCollection();
    			$collection
    			->getSelect()
    			->where('connection_id = ' .$connectionId)
    			->where('customer_id = '.$customerId)
    			->where('is_shareable = 1')
    			->where('status <> '. Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_DELETE)
    			->limit('1');
    			foreach ($collection->getItems() as $item)
    			{
    				$account = $item;
    				break;
    			}
    	
    		}
    	
    		if ($account == null)
    		{
    			$account = Mage::getModel('dwd_icd/account');
    			if(!$is_shareable)
    			{
    				$account->setLogin(Mage::helper('core')->getRandomString(8));
    			}
    			else
    			{
    				$account->setLogin($email);
    			}
    			$account->setIsShareable($is_shareable)
    			->setCustomerId($customerId)
    			->setPassword(self::createPassword($account->getUsername()))
    			->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_NEW)
    			->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING)
    			->setCreatedTime(now())
    			->setUpdateTime(now())
    			->setConnectionId($connectionId);
    			
    			if($pwd !== null)
    			{
    				$account->setPassword($pwd);
    			}
    			
    			$account->save();
    			//neu laden wg. crypto
    			$account = Mage::getModel('dwd_icd/account')->load($account->getId());
    		}
    		
    		return $account; 	
    }
    
    
    public function getSoapClient()
    {
    	    	
    	if($this->_soapClient == null)
    	{
    		try {
    		$connection = Mage::getModel('dwd_icd/connection')->load($this->getConnectionId());
    		$this->_soapClient = Mage::getSingleton('dwd_icd/webservice_icdServices', array($connection->getUrl(), array('login'=> $connection->getUser(), 'password' => $connection->getPassword())));
    		}
    		catch (Exception $ex){
    			Mage::logException($ex);
    			throw $ex;
    		}
    	}
    	return $this->_soapClient;
    }
    
    protected static function createPassword($username)
    {
    	$res =  self::getRandomString(2,"ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    	$res .= self::getRandomString(3,"abcdefghijklmnopqrstuvwxyz"); 
    	$res .= self::getRandomString(2,"ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    	$res .= self::getRandomString(2,"0123456789"); 
    	return $res;
    }
    
    public function _checkPassword()
    {
    	return $this->checkPassword($this->getLogin(),$this->getPassword());
    }
    
    /**
     * Checks for valid passwords.
     *
     * @param string $sUsername username
     * @param string $sPassword the password
     *
     * @return boolean True if the password is valid, and false otherwise.
     */
    public function checkPassword($sUsername = null, $sPassword = null)
    {
    	if (is_null($sPassword) || (strlen($sPassword) < 8) ) {
    		return false;
    	}

    	$sLowerUser = strtolower($sUsername);
    	$sLowerPass = strtolower($sPassword);

    	$sUserSix = substr($sLowerUser, 0, 6);
    	$sUserTwo = substr($sLowerUser, 0, 2);

    	if (strpos($sLowerPass, $sLowerUser)) {
    		return false;
    	}

    	if ((strlen($sLowerUser) >= 6) AND strpos($sLowerUser, $sUserSix)) {
    		return false;
    	}
    	if ( (strlen($sLowerUser) > 4) AND strpos($sLowerUser, $sUserTwo) ) {
    		return false;
    	}

    	$iCat = 0;

    	if ( preg_match("/.*[A-Z].*/", $sPassword) ) {
    		$iCat++;
    	}
    	if ( preg_match("/.*[a-z].*/", $sPassword) ) {
    		$iCat++;
    	}
    	if ( preg_match("/.*\\d.*/", $sPassword) ) {
    		$iCat++;
    	}
    	if ( preg_match("/.*\\W.*/", $sPassword) ) {
    		$iCat++;
    	}

    	if ( $iCat < 3 ) {
    		return false;
    	} 
    	
    	return true;
    }
    
    
    protected function createErrorMail($msg = "") {
    	$url = Mage::helper("adminhtml")->getUrl('dwd_icd/adminhtml_account/edit',array('id'=>$this->getId()));
    	$body = $this->getError() . "\n Link:" . $url ." \n".$msg;
    	$this->sendMailToAdmin($body);
    }
    
    public function sync()
    {
    	///falls das item in Bearbeitung ist
    	if($this->getIsSetMutex()){
    		return $this;
    	}
    	$this->setMutex();
    	
    	//$connection = Mage::getModel('dwd_icd/connection')->load($this->getConnectionId());
    	/* @var $client Dwd_Icd_Model_Webservice_IcdServices */
    	$client = $this->getSoapClient();
    	if (($this->getSyncStatus() != Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PERMANENTERROR) && ($this->getSyncStatus() != Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS))
    	{
    		try 
    		{
    			//neuer Account
    			if($this->getStatus() == Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_NEW)
    			{
    				$this->_addUser();
	    			
    			}
    			//das Passwort wurde geändert
    			if($this->getStatus() == Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_NEWPASSWORD)
    			{
    				$this->_changePassword();
    			}
    				
    			//Benutzer wurde gelöscht
   				if($this->getStatus() == Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_DELETE)
    			{
    				$this->_removeUser();
    			}
    		}
    		catch (Exception $e)
    		{
    			Mage::log("ICD:: Sync Error: ".$e->__toString(), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    			$this->processError($e);
    		}    		
    	}
    	$this->setSemaphor(0);
    	$this->getResource()->saveField($this, 'semaphor');
    }
    
  
    
    
    protected function _addUser()
    {
    	//Egovs_Helper::printMemUsage('_addUser=>'.$this->getId());
    	Mage::log("ICD:: _addUser: ".$this->getId(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	
    	$client = $this->getSoapClient();
    	//Egovs_Helper::printMemUsage('client->addUser=>'.$this->getId());
    	$res = $client->addUser($this->getLogin(),$this->getPassword());
    	//Egovs_Helper::printMemUsage('client->addUser<='.$this->getId());
    	if($success = $this->processError($res,'addUser',$this->getLogin()))
    	{
    		$this
    		->setPassword('')
    		->setError('')
    		->setUpdateTime(now())
    		->setStatus(Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_ACTIVE)
    		->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    		
    		$this->log($this->getId(), 'addUser', $this->getLogin(),$res->getCode(),$res->getMessage());
    	}
    	//Egovs_Helper::printMemUsage('_addUser<='.$this->getId());
    	return $success;
    }
    
    protected function _removeUser()
    {
    	Mage::log("ICD:: _removeUser: ".$this->getId(), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    	$client = $this->getSoapClient();
    	$res = $client->removeUser($this->getLogin());
    	if($success = $this->processError($res,'removeUser',$this->getLogin()))
    	{
    		$this
    		->setPassword('')
    		->setError('')
    		->setUpdateTime(now())
    		->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    		$this->log($this->getId(), 'removeUser', $this->getLogin(),$res->getCode(),$res->getMessage());
    	}
    	return $success;
    }
  
    protected function _changePassword()
    {
    	Mage::log("ICD:: _changePassword: ".$this->getId(), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    	$client = $this->getSoapClient();
    	$pwd = $this->getPassword();
    	$res = $client->setPasswordUser($this->getLogin(),$pwd);
    	if($success = $this->processError($res,'setPasswortUser',$this->getLogin()))
    	{
    		$this
    		->setPassword('')
    		//->setError('')
    		->setUpdateTime(now())
    		->setStatus(Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_ACTIVE)
    		->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save()
    		;
    		$this->log($this->getId(), 'setPasswortUser', '',$res->getCode(),$res->getMessage());
    		//$this->log($this->getId(), 'setPasswortUser', $pwd,$res->getCode(),$res->getMessage());
    	}
    	return $success;
    }
    
    protected static function getRandomString($len, $chars=null)
    {
    	if (is_null($chars)) {
    		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    	}
    	mt_srand(10000000*(double)microtime());
    	for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
    		$str .= $chars[mt_rand(0, $lc)];
    	}
    	return $str;
    }
    
    
    
    protected function getMutexKey()
    {
    	return 'icd_account_'.$this->getId();
    }
    
    
    /*
    public function getAppliationCount($application)
    {
    	$collection = Mage::getModel('dwd_icd/orderitem')->getCollection();
    	$collection->getSelect()
    		->where('account_id='.$this->getId())
    		->where('status='.Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)
    		->where("application='".$application."'");
    	//die ($collection->getSelect()->__toString());
    	return count($collection->getItems());
    }
    */
    public function getItemsCount()
    {
    	$exp = new Zend_Db_Expr('((main_table.status='.Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE . ') OR ( main_table.status=' . Dwd_Icd_Model_OrderStatus::ORDERSTATUS_NEW .'))' );
    	$collection = Mage::getModel('dwd_icd/orderitem')->getCollection();
    	$collection->getSelect()
    	//alle accounts abfragen die dasselbe Login haben
    	->join(array('account'=>$this->getResource()->getTable('dwd_icd/icd_account')),"main_table.account_id=account.id AND account.login='".$this->getLogin()."'",array() )
    	//->where('account_id='.$this->getId())
    	->where($exp);
    	
    	$n = count($collection->getItems());
    	$this->setLog('Account ItemsCount = ' .$n);
    	//die($collection->getSelect()->__toString());
    	return $n;
    }
    
    
    protected function _afterLoad()
    {
    	Mage::dispatchEvent('model_load_after', array('object'=>$this));
    	Mage::dispatchEvent($this->_eventPrefix.'_load_after', $this->_getEventData());
    	$crypt = Mage::getModel('core/encryption');
    	$this->setPassword($crypt->decrypt($this->getPassword()));
    	return $this;
    }
    
    protected function _beforeSave()
    {
    	if (!$this->getId()) {
    		$this->isObjectNew(true);
    	}
    	Mage::dispatchEvent('model_save_before', array('object'=>$this));
    	Mage::dispatchEvent($this->_eventPrefix.'_save_before', $this->_getEventData());
    	if($this->getPassword() != null){
    		$crypt = Mage::getModel('core/encryption');
    		$this->setPassword($crypt->encrypt($this->getPassword()));
    	}
    	return $this;
    }
    
    
}