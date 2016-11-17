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
class Dwd_Icd_Model_Stress extends Dwd_Icd_Model_Abstract
{
	
	private $_soapClient = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/account');
    }
    
    
    
    private function getConnection()
    {
    	$collection = Mage::getModel('dwd_icd/connection')->getCollection();
    	foreach($collection->getItems() as $item)
    	{
    		return Mage::getModel('dwd_icd/connection')->load($item->getId());
    	}
    	
    	return null;
    }
    
    
    
    public function syncAll()
    {
    	for($i=0; $i < 10; $i++)
    	{
    		$this->sync();
    	}
    }
    
    
    public function sync()
    {
    	$start = microtime(true);
    	$pwd = self::createPassword("");
    	$user = self::createPassword("");
    	echo "<h1>Add User ".$user."</h1><br>";;
    	$this->_addUser($user,$pwd);
    	
    	echo "Add Group "."<br>";
    	$this->_addGroup($user, "AgrowetterPrognose");
    	
    	/*
    	echo "Add Attribute "."<br>";
    	$this->_addAttributeNameValuePair($user, "dwdkennAgrowetterPrognose", "1234");
    	
    	echo "Remove Attribute "."<br>";
    	$this->_removeAttributeNameValuePair($user, "dwdkennAgrowetterPrognose", "1234");
    	*/
    	
    	
    	echo "Remove Group "."<br>";
    	$this->_removeGroup($user, "AgrowetterPrognose");
    	
    	echo "Remove User" . $user."<br>";;
    	$this->_removeUser($user);
    	
    	echo "User removed"."<br>";;
    	
    	$ende = microtime(true);
    	echo  "Runtime: " . (($ende - $start)/1000) ."s <br><br>";
    }
    
    
    
  
    
    public function getSoapClient()
    {
    	    	
    	if($this->_soapClient == null)
    	{
    		try {
    		$connection = $this->getConnection();
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
    
    
    
    protected function _addUser($user, $pwd)
    {
    	Egovs_Helper::printMemUsage('_addUser=>'.$user);
    	
    	
    	$client = $this->getSoapClient();
    	
    	try{
    		$res = $client->addUser($user, $pwd);
    		$success = $this->processError($res,'removeUser',$user);
    	}catch(Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	

    	return $success;
    }
    
    protected function _removeUser($user)
    {
    	Mage::log("ICD:: _removeUser: ".$user, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	$client = $this->getSoapClient();
    	try{
    		$res = $client->removeUser($user);
    		$success = $this->processError($res,'removeUser',$user);
    	}catch(Exception $e)
    	{
    		echo $e->getMessage()."<br>";
    	}
    	
    	
    	return $success;
    }
  
    
    protected function _addGroup($user,$application)
    {
    	Mage::log("ICD:: _addGroup: ".$user, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	$client = $this->getSoapClient();
    	$success = true;
    	try{
    	$res = $client->addGroup($user,$application);
    	$success = $this->processError($res,'addGroup',$user. '/'. $application);
    	}catch(Exception $e)
    	{
    		echo $e->getMessage()."<br>";
    	}
    
    	return $success;
    
    }
    
 
    protected function _removeGroup($user,$application)
    {
    	Mage::log("ICD:: _removeGroup: ".$this->getId(), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    	$client = $this->getSoapClient();
    	$success = true;
    	try{
    		$res = $client->removeGroup($user, $application);
    		$success = $this->processError($res,'removeGroup',$user. '/'. $application);
    	}catch(Exception $e)
    	{
    		echo $e->getMessage()."<br>";
    	}
    
    	return $success;
    
    }
    
    protected function _addAttributeNameValuePair($user,$name,$value)
    {
    	Mage::log("ICD:: _addAttributeNameValuePair: ".$user, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	$att = Mage::getModel('dwd_icd/webservice_types_attributeNameValuePair');
    	$att->value = $value;
    	$att->name = $name;
    
    	$client = $this->getSoapClient();
    	try{
    	$res = $client->addAttributeNameValuePair($user,$att);
    	$success = $this->processError($res,'addAttributeNameValuePair',$user. '/'.$att->name.'='.$att->value);
    	}catch(Exception $e)
    	{
    		echo $e->getMessage()."<br>";
    	}
    
    	return $success;
    }
    
   
    
    protected function _removeAttributeNameValuePair($user,$name,$value)
    {
    	$att = Mage::getModel('dwd_icd/webservice_types_attributeNameValuePair');
    	$att->value = $value;
    	$att->name = $name;
    
    	$client = $this->getSoapClient();
    	try{
    	$res = $client->removeAttributeNameValuePair($user,$att);
    	$success = $this->processError($res,'removeAttributeNameValuePair',$user. '/'.$att->name.'='.$att->value);
    	}catch(Exception $e)
    	{
    		echo $e->getMessage()."<br>";
    	}
    
    	return $success;
    }
    
    
    
    
    
    
    protected function processError($error, $action = '', $value = '')
    {
    	if($error == null) return false;
    	if ($error instanceof SoapFault || $error instanceof Exception) {
    		
    		echo $error->getMessage()."<br>";
    		$this->save();
    		
    		Mage::log("ICD:: Sync Error: ".$error->getMessage() , Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    		return false;
    	} else {
    		if ($this->isError($error,$action)) {
    			echo "---(".$error->getCode().') '.$error->getMessage()."<br>";;
    			
    			Mage::log("ICD:: Sync Error: ".$this->getError()." ".$msg , Zend_Log::ERR, Egovs_Helper::LOG_FILE);
    			return false;
    		} else {
    			echo "---(".$error->getCode().') '.$error->getMessage() ."<br>";
    			//$this->setError('');
    			
    			Mage::log("ICD:: Sync Message: " . $this->getError() , Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    		}
    	}
    	 
    	return true;
    }
  
}