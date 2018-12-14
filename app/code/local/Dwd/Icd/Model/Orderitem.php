<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Orderitem
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Orderitem extends Dwd_Icd_Model_Abstract
{
	/* @var $_Order Mage_Sales_Model_Order */ 
	private $_Order = null;
	private $_account = null;
	
		
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/orderitem');
    }
    
    
    private function renewPeriode($orderItemId)
    {
    	$orderItem = Mage::getModel('sales/order_item')->load($orderItemId);
    	
    	$collection = Mage::getModel('sales/quote_item_option')->getCollection();
    	$collection->getSelect()->where('item_id=?', intval($orderItem->getQuoteItemId()));
    	
    	$periode = null;
    	foreach ($collection->getItems() as $option)
    	{
    		if($option->getCode() == 'period_object'){
    			$periode = unserialize($option->getValue());
    		}
    	}
    	
    	if($periode instanceof Dwd_Periode_Model_Periode )
    	{
    		$this->setStartTime($periode->getStartDate());
    		$this->setEndTime($periode->getEndDate());
    		$this->save();
    	}
    	
    }
    
    public function sync()
    {
    	//falls das item in Bearbeitung ist
    	if($this->getIsSetMutex()){
    		return $this;
    	}
    	$this->setMutex();
    	
    	$account = $this->getAccount();
    	if($account->getSyncStatus() != Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    	{
    		$account->sync();
    	}
    	
    	if ($account->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    	{
    		if (($this->getSyncStatus() != Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PERMANENTERROR) 
    				&& ($this->getSyncStatus() != Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS))
    		{
    			
    			//neu
    			$state = $this->getOrder()->getStatus();
    			
    			$msg = "ICD sync item: " .$this->getId(). " Status " .$this->getStatus() . " Syncstatus ".$this->getSyncStatus(). " Orderstatus " .$state;
    			Mage::log($msg, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    			$this->setLog($msg);
    			
    			if(($this->getStatus() == Dwd_Icd_Model_OrderStatus::ORDERSTATUS_NEW) &&
    				 (($state == Mage_Sales_Model_Order::STATE_COMPLETE) ||
    				 ( $state == Mage_Sales_Model_Order::STATE_PROCESSING)))
    			{
    				$this->renewPeriode($this->getOrderItemId());

    				
    				$success = $this->addGroup($this->getApplication());	
    				if($success){
    					$success = $this->addStation($this->getStationId());
    				}
    				
    			}
    			
    			//neue Station
    			if($this->getStatus() == Dwd_Icd_Model_OrderStatus::ORDERSTATUS_NEWSTATION)
    			{
    				$this->changeStation();	
    				
    			}
    				 
    			//gelöscht oder deaktiviert
    			if(($this->getStatus() == Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DELETE) || ($this->getStatus() == Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DISABLED))
    			{
    				//Status sichern
    				$oldStatus = $this->getStatus();
    				$success = $this->removeGroup($this->getApplication());
    				
    				if ($success){
    					$this->removeStation($this->getStationId());
    				}
    				
    				$this->setStatus($oldStatus)->save();
    			}
    			$msg = "ICD sync item: " .$this->getId(). " Status " .$this->getStatus() . " Syncstatus ".$this->getSyncStatus();
    			Mage::log($msg, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    			$this->setLog($msg);
    		}
    	}
    	$this->setSemaphor(0);
    	$this->getResource()->saveField($this, 'semaphor');
    }
    
    /**
     * Wechselt die Station des Items
     * @param Dwd_Icd_Model_Account $account
     * 
     * Dabei wird auch der Wert der Station in sales_flat_order_item über die Resource geändert
     */
    public function changeStation()
    {
    	$orderItem = Mage::getModel('sales/order_item')->load($this->getOrderItemId());
    	if($this->removeStation($orderItem->getStationId())){
    		if($this->addStation($this->getStationId())){
    			$orderItem->setStationId($this->getStationId());
    			$orderItem->getResource()->save($orderItem);
    		}
    	}
    }
    
   
    
    protected function getMutexKey()
    {
    	return 'icd_orderitem_'.$this->getId();
    }
  
    

    
    protected function addStation($stationId)
    {
    	if(!$stationId) return true;
    	$station = Mage::getModel('stationen/stationen')->load($stationId);

    	$value = $station->getStationskennung();
    	$name = 'dwdKenn'.$this->getApplication();
    	
    	$success = $this->addAttributeNameValuePair($name,$value);
    	   	
    	if($success){
    		$this
    		->setError('')
    		->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)
    		->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    	}
    	
    	return $success;
   	
    }
    
    protected function removeStation($stationId)
    {
    	if(!$stationId) return true;
    	$station = Mage::getModel('stationen/stationen')->load($stationId);
    
    	$value = $station->getStationskennung();
    	$name = 'dwdKenn'.$this->getApplication();
    	
    	$success = $this->removeAttributeNameValuePair($name,$value);
    	    	 
    	if($success){   		
    		$this
    		->setError('')
    		->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)
    		->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    	}
    
    	return $success;
    }
    
  
    
    
    
    
    
    
    public function addGroup($application)
    {
    	//Egovs_Helper::printMemUsage('addGroup<=');
    	$group = Dwd_Icd_Model_Account_Groups::getGroup($this->getAccount(),  $application);
    	$success  = true;
    	if($group->getCount() <= 0)
    	{
    		$success = $this->_addGroup($application);
    	}
    	if($success){
    		$group->setCount($group->getCount() + 1);
    		$group->save();
    		
    		$this
    		->setError('')
    		->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)
    		->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    	}
    	//Egovs_Helper::printMemUsage('addGroup=>');
    	return $success;
    }
    
    protected function _addGroup($application)
    {
    	Mage::log("ICD:: _addGroup: ".$this->getId(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	$client = $this->getAccount()->getSoapClient();
    	$success = true;
    	$res = $client->addGroup($this->getAccount()->getLogin(),$application);
    	$success = $this->processError($res,'addGroup',$this->getAccount()->getLogin(). '/'. $application);
    	if($success)
    	{
    
    		$this->log($this->getAccount()->getId(), 'addGroup', $application,$res->getCode(),$res->getMessage());
    	}
    
    	return $success;
    
    }
    
    public function removeGroup($application)
    {
    	$group = Dwd_Icd_Model_Account_Groups::getGroup($this->getAccount(),  $application);
    	$success  = true;
    	if($group->getCount() == 1)
    	{
    		$success = $this->_removeGroup($application);
    	}
    	if($success){
    		$group->setCount($group->getCount() - 1);
    		$group->save();
    		
    		$this
    		->setError('')
    		->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)
    		->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    
    	}
    	return $success;
    }
    
    protected function _removeGroup($application)
    {
    	Mage::log("ICD:: _removeGroup: ".$this->getId(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	$client = $this->getAccount()->getSoapClient();
    	$success = true;
    	$res = $client->removeGroup($this->getAccount()->getLogin(), $application);
    	$success = $this->processError($res,'removeGroup',$this->getAccount()->getLogin(). '/'. $application);
    	if($success)
    	{
    		$this->log($this->getAccount()->getId(), 'removeGroup', $application,$res->getCode(),$res->getMessage());
    	}
    
    	return $success;
    
    }
    
    
    public function addAttributeNameValuePair($name,$value)
    {
    	//Egovs_Helper::printMemUsage('addAttributeNameValuePair<=');
    	$model = Dwd_Icd_Model_Account_Attributes::getAttribute($this->getAccount(), $name."=".$value);
    	$success  = true;
        /** @noinspection PrintfScanfArgumentsInspection */
        $this->setLog(sprintf('addAttributeNameValuePair Account %s %s=%s Count %i ',$this->getAccount()->getLogin(), $name, $value, $model->getCount()));
    	if($model->getCount() == 0)
    	{
    		$success = $this->_addAttributeNameValuePair($name,$value);
    	}
    	 
    	if($success){
    		$model->setCount($model->getCount() + 1);
    		$model->save();
    	}
    	//Egovs_Helper::printMemUsage('addAttributeNameValuePair=>');
    	
    	return $success;
    }
    
    
    protected function _addAttributeNameValuePair($name,$value)
    {
    	Mage::log("ICD:: _addAttributeNameValuePair: ".$this->getId(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	$att = Mage::getModel('dwd_icd/webservice_types_attributeNameValuePair');
    	$att->value = $value;
    	$att->name = $name;
    
    	$client = $this->getAccount()->getSoapClient();
    	$res = $client->addAttributeNameValuePair($this->getAccount()->getLogin(),$att);
    	$success = $this->processError($res,'addAttributeNameValuePair',$this->getAccount()->getLogin(). '/'.$att->name.'='.$att->value);
    	if($success)
    	{
    
    		$this->log($this->getAccount()->getId(), 'addAttributeNameValuePair', $att->name.'='.$att->value,$res->getCode(),$res->getMessage());
    	}
    
    	return $success;
    }
    
    public function removeAttributeNameValuePair($name,$value)
    {
    	$model = Dwd_Icd_Model_Account_Attributes::getAttribute($this->getAccount(), $name."=".$value);
    	$success  = true;
        /** @noinspection PrintfScanfArgumentsInspection */
    	$this->setLog(sprintf('removeAttributeNameValuePair Account %s %s=%s Count %i ',$this->getAccount()->getLogin(), $name, $value, $model->getCount()));
    	if($model->getCount() == 1)
    	{
    		$success = $this->_removeAttributeNameValuePair($name,$value);
    	}
    	 
    	if($success){
    		$model->setCount($model->getCount() - 1);
    		$model->save();
    		 
    	}
    	 
    	return $success;
    }
    
    protected function _removeAttributeNameValuePair($name,$value)
    {
    	$att = Mage::getModel('dwd_icd/webservice_types_attributeNameValuePair');
    	$att->value = $value;
    	$att->name = $name;
    
    	$client = $this->getAccount()->getSoapClient();
    	$res = $client->removeAttributeNameValuePair($this->getAccount()->getLogin(),$att);
    	$success = $this->processError($res,'removeAttributeNameValuePair',$this->getAccount()->getLogin(). '/'.$att->name.'='.$att->value);
    	if($success)
    	{
    		$this->log($this->getAccount()->getId(), 'removeAttributeNameValuePair', $att->name.'='.$att->value,$res->getCode(),$res->getMessage());
    	}
    
    	return $success;
    }
    
    
    
    
    /**
     * Zugehöriges Konto laden
     * @return Dwd_Icd_Model_Account
     */
    protected function getAccount()
    {
    	if($this->_account == null)
    	{
    		$this->_account = Mage::getModel('dwd_icd/account')->load($this->getAccountId());
    	}
    	
    	return $this->_account ;
    }
    
    
    
    
    
    
    protected function getOrder()
    {
    	if($this->_Order == null)
    	{
    		$this->_Order = Mage::getModel('sales/order')->load($this->getOrderId());
    	}
    	return $this->_Order;
    }
    
    protected function createErrorMail($msg = "")
    {
    	$url = Mage::helper("adminhtml")->getUrl('adminhtml/icd_orderitem/edit',array('id'=>$this->getId()));
    	$body = $this->getError() . "\n Link:" . $url ."\n".$msg;
    	$this->sendMailToAdmin($body);
    }
    
  
}