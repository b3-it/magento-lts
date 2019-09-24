<?php
class B3it_Maintenance_Model_Backend extends Mage_Core_Model_Config_Data 
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
	        	if(isset($set['from_date'])){$set['from_date'] = $this->parseDate($set['from_date']);}
	        	if(isset($set['to_date'])){$set['to_date'] = $this->parseDate($set['to_date']);}
	        	$this->__save($set);
	        }
    	}
    	self::$_isSafed = true;
    	if($this->getPath() == "general/offline/from_date")
    	{
    		$this->setValue($this->parseDate($this->getValue()));
    	}
    	if($this->getPath() == "general/offline/to_date")
    	{
    		$this->setValue($this->parseDate($this->getValue()));
    	}
        return parent::save();  
    }
    
    
    private function parseDate($dateFormatted)
    {
    	$locale =  Mage::app()->getLocale()->getLocaleCode();
    	$locale = new Zend_Locale($locale);
    	$date = new Zend_Date(null, null, $locale);
    	$format =  Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
    	$date->setDate($dateFormatted, $format);
    	$date->setTime($dateFormatted, $format);
    	
    	return $date->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    }
    
    public function delete()
    {
    	if(!self::$_isSafed)
    	{
    		$set = $this->getFieldsetData();
    		$set['store'] = $this->getStoreCode()? $this->getStoreCode() : 'all';
    		$set['website'] = $this->getWebsiteCode() ? $this->getWebsiteCode(): 'all';
    		if($this->getOldValue4Field('lock') == B3it_Maintenance_Model_Offline::OFFLINE_YES)
    		{
	    		$set['lock'] = B3it_Maintenance_Model_Offline::OFFLINE_NO;    		
	    		$this->__save($set);
    		}
    		elseif($this->getOldValue4Field('lock') == B3it_Maintenance_Model_Offline::OFFLINE_SCHEDULED)
    		{
    			$set['lock'] = B3it_Maintenance_Model_Offline::OFFLINE_NO; 			
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
     * @param string $field
     * @return mixed|string <string, NULL, multitype:, multitype:Ambigous <string, multitype:, NULL> , mixed>|mixed|string
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
     * @param string $field
     * @return mixed|string <string, NULL, multitype:, multitype:Ambigous <string, multitype:, NULL> , mixed>|mixed|string
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
     * @param array $data
     */
    private function __save($data)
    {
        $data['user'] = $this->__getUser();
    	switch ($data['lock'])
    	{
    		case B3it_Maintenance_Model_Offline::OFFLINE_NO: $this->__saveOn($data); break;
    		case B3it_Maintenance_Model_Offline::OFFLINE_YES: $this->__saveOff($data); break;
    		case B3it_Maintenance_Model_Offline::OFFLINE_SCHEDULED: $this->__saveOffSceduled($data); break;
    		
    	}


    	Mage::helper('b3it_maintenance')->sendMailToAdmin($data);
    }


    private function __getUser()
    {
        $session =  Mage::getSingleton('admin/session');
        if($session) {
            $user = $session->getUser();
            if($user){
                return $user->getUsername();
            }
        }

        return "";
    }
    
    /**
     * Speichern bei anschalten
     * @param array $data
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
     * @param array $data
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
     * @param array $data
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
     * @param array $data
     */
    private function __saveOffSceduled($data)
    {
    	if($this->getOldValue4Field('lock') == B3it_Maintenance_Model_Offline::OFFLINE_YES){
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
    