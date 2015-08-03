<?php
class Egovs_Maintenance_Model_Backend extends Mage_Core_Model_Config_Data 
{
	private static $_isSafed = false;
 	
 	/**
 	 * speichern der Werte
 	 * @see Mage_Core_Model_Abstract::save()
 	 */
 	public function save()
    {
    	if(!self::$_isSafed)
    	{
	        $set = $this->getFieldsetData(); 
	        if(count($set) > 0)
	        {
	        	$set['lock'] = $this->getValue4Field('lock');
	        	$store = $this->getStoreCode();
	        	$page = $set['cmspagepicker'];
	        	$set['store'] = $this->getStoreCode()? $this->getStoreCode() : 'all';
	        	$set['website'] = $this->getWebsiteCode() ? $this->getWebsiteCode(): 'all';
	        	
	        	$this->__save($set);
	        }
    	}
    	self::$_isSafed = true;
        return parent::save();  
    }
    
    
    public function delete()
    {
    	if(!self::$_isSafed)
    	{
    		$set = $this->getFieldsetData();
    		$set['store'] = $this->getStoreCode()? $this->getStoreCode() : 'all';
    		$set['website'] = $this->getWebsiteCode() ? $this->getWebsiteCode(): 'all';
    		if($this->getOldValue4Field('lock') == Egovs_Maintenance_Model_Offline::OFFLINE_YES)
    		{
	    		$set['lock'] = Egovs_Maintenance_Model_Offline::OFFLINE_NO;    		
	    		$this->__save($set);
    		}
    		elseif($this->getOldValue4Field('lock') == Egovs_Maintenance_Model_Offline::OFFLINE_SCHEDULED)
    		{
    			$set['lock'] = Egovs_Maintenance_Model_Offline::OFFLINE_NO; 			
    			$zd = Mage::app()->getLocale()->date($this->getOldValue4Field('to_date'), null, null, false);
    			$set['on_time'] = $zd->toString("Y-M-d H:m");
    			
    			$this->__saveManuellOn4Schedules($set);
    		}
    	}
    	self::$_isSafed = true;
    	parent::delete();
    }
    
    /**
     * aktelle Werte für das Feld aus POST oder Konfig
     * @param unknown $field
     * @return unknown|Ambigous <string, NULL, multitype:, multitype:Ambigous <string, multitype:, NULL> , mixed>|mixed|string
     */
    private function getValue4Field($field)
    {
    	$path = 'general/offline/'.$field;
    	$data = $this->getFieldsetData(); 
    	if(isset($data[$field]) && $data[$field] != null)
    	{
    		return $data[$field];
    	}
    	
    	$storeCode   = $this->getStoreCode();
    	$websiteCode = $this->getWebsiteCode();
    	$path        = $this->getPath();
    	
    	if ($storeCode) {
    		return Mage::app()->getStore($storeCode)->getConfig($path);
    	}
    	if ($websiteCode) {
    		return Mage::app()->getWebsite($websiteCode)->getConfig($path);
    	}
    	return (string) Mage::getConfig()->getNode('default/' . $path);	
    }
    
    /**
     * alte Werte für das Feld aus Konfig
     * @param unknown $field
     * @return unknown|Ambigous <string, NULL, multitype:, multitype:Ambigous <string, multitype:, NULL> , mixed>|mixed|string
     */
    private function getOldValue4Field($field)
    {
    	$storeCode   = $this->getStoreCode();
    	$websiteCode = $this->getWebsiteCode();
    	$path = 'general/offline/'.$field;
    
    	if ($storeCode) {
    		return Mage::app()->getStore($storeCode)->getConfig($path);
    	}
    	if ($websiteCode) {
    		return Mage::app()->getWebsite($websiteCode)->getConfig($path);
    	}
    	return (string) Mage::getConfig()->getNode('default/' . $path);
    }
    
    /**
     * case Switcher
     * @param unknown $data
     */
    private function __save($data)
    {
    	switch ($data['lock'])
    	{
    		case Egovs_Maintenance_Model_Offline::OFFLINE_NO: $this->__saveOn($data); break;
    		case Egovs_Maintenance_Model_Offline::OFFLINE_YES: $this->__saveOff($data); break;
    		case Egovs_Maintenance_Model_Offline::OFFLINE_SCHEDULED: $this->__saveOffSceduled($data); break;
    		
    	}
    }
    
    /**
     * Speichern bei anschalten
     * @param unknown $data
     */
    private function __saveOn($data)
    {
    	$collection = Mage::getModel('maintenance/offline')->getCollection();
    	
    	$collection->getSelect()
    		->where("website='".$data['website']."'")
    		->where("store='".$data['store']."'")
    		->where("on_time = '0000-00-00 00:00:00'")
    		->where("scheduled = 0");
    	
    	foreach($collection->getItems() as $item)
    	{
    		$zd = Mage::app()->getLocale()->date(null, null, null, true);
    		$item->setOnTime($zd->toString("Y-M-d H:m"));
    		$item->save();
    		break;
    	}
    	
    	
    }
    
    /**
     * Speichern bei abschalten duch "Website verwenden"
     * @param unknown $data
     */
    private function __saveManuellOn4Schedules($data)
    {
    	$collection = Mage::getModel('maintenance/offline')->getCollection();
    	 
    	$collection->getSelect()
    	->where("website='".$data['website']."'")
    	->where("store='".$data['store']."'")
    	->where("on_time >= '".$data['on_time']."'" )
    	->where("scheduled = 1");
    	 
    	foreach($collection->getItems() as $item)
    	{
    		$zd = Mage::app()->getLocale()->date(null, null, null, true);
    		$item->setOnTime($zd->toString("Y-M-d H:m"));
    		$item->save();
    		break;
    	}
    	 
    	 
    }
    
    /**
     * speichern beim Abschalten
     * @param unknown $data
     */
    private function __saveOff($data)
    {
    	
    	$model = Mage::getModel('maintenance/offline');
    	$model->setData($data);
    	$zd = Mage::app()->getLocale()->date(null, null, null, true);
    	$model->setOffTime($zd->toString("Y-M-d H:m"));
    	
    	$model->save();
    }
    
    
    /**
     * speichern bei Zeitgesteuert
     * @param unknown $data
     */
    private function __saveOffSceduled($data)
    {
    	if($this->getOldValue4Field('lock') == Egovs_Maintenance_Model_Offline::OFFLINE_YES){
    		$this->__saveOn($data);
    	}
    	
    	$model = Mage::getModel('maintenance/offline');
    	$model->setData($data);
    	$model->setScheduled(true);
    	
    	try{
    		$zd = Mage::app()->getLocale()->date($data['from_date'], null, null, false);
    		$model->setOffTime($zd->toString("Y-M-d H:m"));
    	}catch(Exception $ex)
    	{
    		throw new Exception('From Date is not valid!');
    	}
    	
    	try{
    		$zd = Mage::app()->getLocale()->date($data['to_date'], null, null, false);
    		$model->setOnTime($zd->toString("Y-M-d H:m"));
    	}catch(Exception $ex)
    	{
    		throw new Exception('From Date is not valid!');
    	}
    	
    	$model->save();
    }
    
}
    