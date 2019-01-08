<?php

class Bkg_VirtualAccess_Model_Cron extends Mage_Core_Model_Abstract
{

	public function runSync($schedule)
	{

		
		if (function_exists('apc_add') && function_exists('apc_fetch')) {
			$apcKey = 'bkg_virtualacces_cron_mutex'.$schedule->getId();

			
			if (apc_fetch($apcKey)) {
				Mage::log("bkg_virtualacces_cron_mutex: already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
				return true;
			}
			
			
			//dauert ca. 1msec
			//TTL = 180s = 3Min
			$apcAdded = apc_add($apcKey, true, 60);
		}
		
		
		
		
		$last_run = date("Y-m-d H:i:s", (time()- (60 * 60)));
		$status_run = Mage_Cron_Model_Schedule::STATUS_RUNNING;
		$status_suc = Mage_Cron_Model_Schedule::STATUS_SUCCESS;
		
		$collection = $schedule->getCollection();
		$collection->addFieldToFilter('job_code', $schedule->getJobCode())
		->addFieldToFilter($schedule->getIdFieldName(), array('neq' => $schedule->getId()))
		->addFieldToSelect('status')
		->getSelect()->where("(executed_at >'".$last_run."'  AND status = '".$status_run."')");
		;
		
		if ($collection->count() > 0) {
			$message = Mage::helper('virtualaccess')->__('Service is still running');
			Mage::log($message, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			throw new Exception($message);
		}
		
		try {
			$this->setLog("virtualaccess service started");
			Mage::log(Mage::helper('virtualaccess')->__('virtualaccess service started'), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			$this->syncAll();
			$this->setLog("virtualaccess service finished");
			Mage::log(Mage::helper('virtualaccess')->__('virtualaccess service finished'), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} catch (Exception $e) {
			Mage::logException($e);
			Mage::log(Mage::helper('virtualaccess')->__('There was an runtime error for the virtualaccess service. Please check your log files.'), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw($e);
		}
		
		return true;
	}
	
  
    public function syncAll()
    {
    	$exp = new Zend_Db_Expr('main_table.sync_status = ' . Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_PENDING .' OR main_table.sync_status = ' . Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_ERROR);
    	

    	
    	//alle icd_orderitems die zu synchronisieren sind abarbeiten
    	$collection = Mage::getModel('virtualaccess/purchased')->getCollection();
    	$collection->getSelect()
    		->where($exp)
    		->join(array('order'=>'sales_flat_order'),"order.entity_id=main_table.order_id AND (order.status='processing' OR order.status='complete')",array())
    		->limit('20')
    		//->where('start_time <= ' ."'". Mage::getModel('core/date')->gmtDate()."'")
    		->order('main_table.id');
    	

    		
    	$this->setLog("running SyncAll Items Count:".count($collection->getItems()));
    	$sql = $collection->getSelect()->__toString();
    	$this->setLog($sql);
    	
    	foreach ($collection->getItems() as $item)
    	{
    		try {
    		$item->sync();
    		}catch (Exception $ex){
    			Mage::log($ex->__toString(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    		}
    	}

    	
    	return $this;
    }
    

    

    
}