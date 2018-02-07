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
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     */
	public function runCron($schedule) 
	{		
		Mage::app()->addEventArea(Mage_Core_Model_App_Area::AREA_FRONTEND);
		if ($this->getIsRunning($schedule->getJobCode(), $schedule->getId())) {
			$this->setLog('Found running Service my Id is:' . $schedule->getId());
			Mage::throwException($message);
		}
		$this->prepare();
		$this->run();
		//für Transfermodel Link werden evtl. mehrere Bestellungen zusammen gefasst deshalb gesondert bearbeitet 
		Mage::getModel('exportorder/order')->processPendingOrders();
		$this->deleteOldLinks();
	}
    
    /**
     * 
     * Ermitteln ob noch ein Cronjob läuft
     * @param string     $job_code
     * @param int        $job_id
     * @param DateTime   $timespan Zein in sekunden; default 1h 
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

  	/**
  	 * Bestelldetails von sales_flat_order nach export_order kopieren - falls nicht vorhanden
  	 */
  	private function prepare()
  	{
  		$oderCollection = Mage::getModel('sales/order')->getCollection();
  		$oderCollection->getSelect()
  		->where('entity_id NOT IN (?)',new Zend_Db_Expr('SELECT order_id FROM '.$oderCollection->getTable('exportorder/order')))
  		->where("main_table.status IN ('processing','complete')");
  	
  		//preprocessing speichern damit keine Bestellung gleichzeitig bearbeitet wird
  		$orderIds = array();
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
  			->setVendorId($vendor->getId())
  			->setContractId($contract->getId())
  			->setTransfer($vendor->getTransferType())
  			->setFormat($vendor->getExportFormat())
  			->setCreatedTime(now())
  			->setUpdateTime(now())
  			->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING)
  			->setVendor($vendor)
  			->setContract($contract)
  			->save();
  			$orderIds[] = $order->getId();
  			
  		}
  		
  		//logging
  		if(count($orderIds)>0){
  			$this->setLog('Prepare OrderIds: ' . implode(',',$orderIds));
  		}
  	

  	
  	
  	}
  	
  	/**
  	 * Alle Bestellungen mit Exportstatus Pending bearbeiten
  	 */
  	private function run()
  	{
  		$oderCollection = Mage::getModel('sales/order')->getCollection();
  		$oderCollection->getSelect()
  			->join(array('export'=> $oderCollection->getTable('exportorder/order')),'export.order_id=main_table.entity_id')
  			->where('export.status = '.Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING)
  			->where('export.semaphor < ' .Mage::helper('exportorder')->getSemaphor(-120))
  			->where("main_table.status IN ('processing','complete')");
		
  		//die(($oderCollection->getSelect()->__toString()));  		
  		
  		foreach($oderCollection as $order){
  			if(!$order->getFramecontract())
  			{
  				continue;
  			}
  			
  			/* @var $exportOrder Sid_ExportOrder_Model_Order */
  			$exportOrder = Mage::getModel('exportorder/order')->load($order->getId(),'order_id');
  			$exportOrder->processOrder($order);
  		}
  	}
  	
  	/**
  	 * ALte Links nach definierter ablaufzeit löschen
  	 */
  	private function deleteOldLinks()
  	{
  		$days = intval(Mage::getConfig()->getNode('sid_exportorder/delete_old_links/days'));
  		if ($days == 0){
  			return;
  		}
  		
  		$collection = Mage::getModel('exportorder/link')->getCollection();
  		$collection->getSelect()
  			->where("DATE_ADD(create_time, INTERVAL " . $days . " DAY) < NOW() ")
  			->where('link_status ='.Sid_ExportOrder_Model_Linkstatus::STATUS_ENABLED);
  		
  		$LinkIds = array();
  		foreach($collection as $link)
  		{
  			$LinkIds[] = $link->getId();
  			$link->deleteFile()
			->setLinkStatus(Sid_ExportOrder_Model_Linkstatus::STATUS_DISABLED)
			->save();
  			
  		}
  		
  		//logging
  		if(count($LinkIds)>0){
  			$this->setLog('Deleting Links: ' . implode(',',$LinkIds));
  		}
  	}
    
}