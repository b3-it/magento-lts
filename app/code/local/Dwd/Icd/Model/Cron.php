<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Cron
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Cron extends Mage_Core_Model_Abstract
{

    
    
	
	public function runSync($schedule)
	{
		
	
		
		if (function_exists('apc_add') && function_exists('apc_fetch')) {
			$apcKey = 'icd_cron_mutex'.$schedule->getId();

			
			if (apc_fetch($apcKey)) {
				Mage::log("ICD:: icd_cron_mutex: already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
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

		//->getSelect()->where("((finished_at >= '".$last_run . "' and status = '".$status_suc."') OR (executed_at >'".$last_run."'  AND status = '".$status_run."'))");
		->getSelect()->where("(executed_at >'".$last_run."'  AND status = '".$status_run."')");
		;
		
		//$s = $collection->getSelect()->__toString();
		/*
		if ($collection->count() > 0) {
			
			Mage::log($s, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			foreach ($collection as $items) {
				if ($items->getStatus() != Mage_Cron_Model_Schedule::STATUS_RUNNING) {
					continue;
				}
				$message = Mage::helper('dwd_icd')->__('ICD service is still running');
				//Mage::helper('dwdafa')->sendMailToAdmin("dwdafa::".$message);
				Mage::log($message, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
				break;
			}
			if (!isset($message)) {
				$message = Mage::helper('dwd_icd')->__('ICD service last runtime was less than hours ago');
				Mage::log($message, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			}
			throw new Exception($message);
		}*/
		if ($collection->count() > 0) {
			$message = Mage::helper('dwd_icd')->__('ICD service is still running');
			Mage::log($message, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			throw new Exception($message);
		}
		
		try {
			$this->setLog("ICD service started");
			Mage::log(Mage::helper('dwd_icd')->__('ICD service started'), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			$this->syncAll();
			$this->setLog("ICD service finished");
			Mage::log(Mage::helper('dwd_icd')->__('ICD service finished'), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} catch (Exception $e) {
			Mage::logException($e);
			Mage::log(Mage::helper('dwd_icd')->__('There was an runtime error for the ICD service. Please check your log files.'), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw($e);
		}
		
		return true;
	}
	
  
    public function syncAll()
    {
    	
    	
    	$exp = new Zend_Db_Expr('main_table.sync_status = ' . Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING .' OR main_table.sync_status = ' . Dwd_Icd_Model_Syncstatus::SYNCSTATUS_ERROR);
    	
    	//alle abgelaufenen Zugänge deaktivieren und SyncStatus auf pending stellen 
    	$this->disableOutDated();
    	
    	//alle icd_orderitems die zu synchronisieren sind abarbeiten
    	$collection = Mage::getModel('dwd_icd/orderitem')->getCollection();
    	$collection->getSelect()
    		->where($exp)
    		->join(array('order'=>'sales_flat_order'),"order.entity_id=main_table.order_id AND (order.status='processing' OR order.status='complete')",array())
    		->join(array('account'=>$collection->getTable('icd_account')),"account.id=main_table.account_id AND account.sync_status <>". Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PERMANENTERROR ,array())
    		->limit('20')
    		->where('start_time <= ' ."'". Mage::getModel('core/date')->gmtDate()."'")
    		->where('main_table.semaphor < '. Dwd_Icd_Model_Abstract::getMutexReleaseTime())
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
    	
    	
    	//Accounts Syncronisieren
    	$collection = Mage::getModel('dwd_icd/account')->getCollection();
    	$collection->getSelect()
    		->where($exp)
    		->where('semaphor < '. Dwd_Icd_Model_Abstract::getMutexReleaseTime())
    		->limit('20');
    	
    	foreach ($collection->getItems() as $item)
    	{   	
    		try {
    		$crypt = Mage::getModel('core/encryption');
    		$item->setPassword($crypt->decrypt($item->getPassword()));
    		$item->sync();
    		}catch (Exception $ex){
    			Mage::log($ex->__toString(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    		}
    	}
    	
    	
    	//Acounts zum löschen markieren
    	//Synchronisieren erst im nächsten Lauf!!
    	
    	$exprItems = new Zend_Db_Expr("(SELECT account_id FROM icd_orderitem 
    			WHERE (status <> ".Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DISABLED." AND status <>" .Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DELETE.") 
    			AND sync_status = " . Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS ." GROUP BY account_id)" );
    	
    	
    	$collection = Mage::getModel('dwd_icd/account')->getCollection();
    	$collection->getSelect()
    	->where('id NOT IN ' . $exprItems)
    	->where("sync_status = " . Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    	->where('status <>'.Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_DELETE)
    	->limit('20');
    //die($collection->getSelect()->__toString());	
    	foreach ($collection->getItems() as $item)
    	{
    		//nochmal zählen
    		$n = $item->getItemsCount();
    		if($n == 0) {
    			$item->setStatus(Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_DELETE);
    			$item->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING);
    			$item->save();
    		}
    		
    		
    	}
    	
    	$log = Mage::getModel('dwd_icd/account_log');
    	$log->removeOldLines();
    	
    	return $this;
    }
    
    
    /***
     * alle abgelaufenen Zugänge deaktivieren und SyncStatus auf pending stellen und synchronisieren
     */
    private function disableOutDated()
    {
    	$collection = Mage::getModel('dwd_icd/orderitem')->getCollection();
    	
    	$ORDERSTATUS_ACTIVE = Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE;
    	//Zählen wieviele Stationen dieses Kontos aktiv sind 
    	$expr = new Zend_Db_Expr("(SELECT count(id) as aktiv, account_id, station_id, application FROM {$collection->getMainTable()}  AS main_table WHERE status = {$ORDERSTATUS_ACTIVE} GROUP BY application, account_id, station_id)");
    		
    	$collection->getSelect()
    	->where('status = ' . Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)
    	->where('end_time < ' ."timestampadd(HOUR,1,'". Mage::getModel('core/date')->gmtDate()."')")
    	->joinLeft(array('z'=>$expr), 'z.account_id = main_table.account_id and z.station_id=main_table.station_id and z.application=main_table.application', array('aktiv'));
    	
    	foreach ($collection->getItems() as $item)
    	{
    		$item->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DISABLED);
    		$aktiv = intval($item->getAktiv());
    		if(intval($item->getAktiv()) > 1)
    		{
    			$item->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    				->save();
    		}else{
    			$item->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING)
    				 ->save()
    				 ->sync();
    		}
    			
    	}
    }
    

    
}