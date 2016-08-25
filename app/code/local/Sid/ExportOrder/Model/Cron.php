<?php
/**
 * 
 *  Bestellungen an Lieferanten übermitteln
 *  @category Sid
 *  @package  Sid_ExportOrder_Model_Cron
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2016 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Cron extends Mage_Core_Model_Abstract
{
 
    /**
     * Einsprung
     * @param unknown $schedule
     */
	public function runCron($schedule) 
	{		
		Mage::app()->addEventArea(Mage_Core_Model_App_Area::AREA_FRONTEND);
		if ($this->getIsRunning($schedule->getJobCode(), $schedule->getId())) {
			$this->setLog('Found running Service my Id is:' . $schedule->getId());
			Mage::throwException($message);
		}
		$this->run();
	}
    
    /**
     * 
     * Ermitteln ob noch ein Cronjob läuft
     * @param $job_code
     * @param $job_id
     * @param $timespan Zein in sekunden; default 1h 
     */
  	protected function getIsRunning($job_code, $job_id, $timespan = 3600)
  	{
  		$collection = Mage::getModel('cron/schedule')->getCollection();
		$collection->addFieldToFilter('job_code', $job_code)
			->addFieldToFilter('schedule_id', array('neq' => $job_id))
			->addFieldToSelect('status')
			//falls noch ein Job in der letzten Stunde läuft	
			->getSelect()
				->where("status = '" . Mage_Cron_Model_Schedule::STATUS_RUNNING."'")
				->where("finished_at >= '". date("Y-m-d H:i:s", time()- $timespan)."'")
		;
		///die($collection->getSelect()->__toString());
		return (count($collection->getItems()) > 0);
  	}

  	
  	private function run()
  	{
  		$oderCollection = Mage::getModel('sales/order')->getCollection();
  		$oderCollection->getSelect()
  			->where('entity_id NOT IN (?)',new Zend_Db_Expr('SELECT order_id FROM '.$oderCollection->getTable('exportorder/order')));
  		
  		//preprocessing speichern damit keine Bestellung gleichzeitig bearbeitet wird
  		foreach($oderCollection as $order){
  			if(!$order->getFramecontract())
  			{
  				continue;
  			}
  			$contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
  			$vendor = Mage::getModel('framecontract/vendor')->load($contract->getFramecontractVendorId());
  			$exportOrder = Mage::getModel('exportorder/order');
  			
  			$exportOrder
  				->setOrderId($order->getId())
  				->setVendorId($order->getId())
  				->setContractId($order->getId())
  				->setTransfer($vendor->getTransferType())
  				->setFormat($vendor->getExportFormat())
  				->setCreatedTime(now())
  				->setUpdatedTime(now())
  				->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING)
  				->setVendor($vendor)
  				->setContract($contract)
  				->save();
  			
  			//geladene Objekte merken
  			$order->setExportOrder($exportOrder);
  		}
  		
  		//jetzt bearbeiten
  		foreach($oderCollection as $order){
  			
  			if(!$order->getFramecontract())
  			{
  				continue;
  			}
  			$exportOrder = $order->getExportOrder();
  			$exportOrder->processOrder($order);
  			
  		}
  		
  		
  	}
    
}