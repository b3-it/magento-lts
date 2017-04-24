<?php

class Dwd_Fix_Model_Cron extends Mage_Core_Model_Abstract
{

    
    
	
	public function runSync($schedule)
	{
		if (function_exists('apc_add') && function_exists('apc_fetch')) {
			$apcKey = 'dwd_fix_cron_mutex'.$schedule->getId();

			
			if (apc_fetch($apcKey)) {
				Mage::log("ICD:: dwd_fix_cron_mutex: already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
				return true;
			}
			
			
			//dauert ca. 1msec
			//TTL = 180s = 3Min
			$apcAdded = apc_add($apcKey, true, 60);
		}
		
		
		if(Mage::getStoreConfig('dwd_fix/fix/enable') == 0){
			return true;
		}
		
		
		$last_run = date("Y-m-d H:i:s", (time()- (60 * 60)));
		$status_run = Mage_Cron_Model_Schedule::STATUS_RUNNING;
		$status_suc = Mage_Cron_Model_Schedule::STATUS_SUCCESS;
		
		$collection = $schedule->getCollection();
		$collection->addFieldToFilter('job_code', $schedule->getJobCode())
		->addFieldToFilter($schedule->getIdFieldName(), array('neq' => $schedule->getId()))
		->addFieldToSelect('status')

		//->getSelect()->where("((finished_at >= '".$last_run . "' and status = '".$status_suc."') OR (executed_at >'".$last_run."'  AND status = '".$status_run."'))");
		->getSelect()->where("(executed_at >'".$last_run."'  AND status = '".$status_run."')");
		;
		
		$s = $collection->getSelect()->__toString();

		if ($collection->count() > 0) {
			$message = 'DWD Fix service is still running';
			Mage::log($message, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			throw new Exception($message);
		}
		
		try {
			
			Mage::log('DWD Fix service started', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			Mage::getModel('dwd_fix/rechnung_rechnung')->process();
			Mage::log('DWD Fix service finished', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} catch (Exception $e) {
			Mage::logException($e);
			Mage::log('There was an runtime error for the DWD Fix service. Please check your log files.', Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw($e);
		}
		
		return true;
	}
	
  
    public function syncAll()
    {
    	
    }
    

    
}