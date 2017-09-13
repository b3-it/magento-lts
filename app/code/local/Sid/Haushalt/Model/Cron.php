<?php
/**
 * 
 *  Bestellungen an HHSystem übermitteln
 *  @category Sid
 *  @package  Sid_Haushalt_Model_Cron
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2016 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Haushalt_Model_Cron extends Mage_Core_Model_Abstract
{
 
    /**
     * Einsprung
     * @param Mage_Cron_Model_Schedule $schedule
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
     * @param string   $job_code
     * @param int      $job_id
     * @param DateTime $timespan Zein in sekunden; default 1h 
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
  		$stores = Mage::getModel('core/store')->getCollection();
  		$helper = Mage::helper('sidhaushalt');
  		foreach($stores as $store)
  		{
  			$expr = Mage::getStoreConfig('sidhaushalt/hhexport/cron_expression',$store->getId());
  			
  			//nur abarbeiten wenn Zeit erreicht ist
  			if($helper->canSchedule($expr))
  			{
		  		$oderCollection = Mage::getModel('sidhaushalt/order_info')->getCollection();
		  		$oderCollection->getSelect()
		  			->join(array('order'=>$oderCollection->getTable('order/sales'),'order.entity_id = main_table.order_id',array()))
		  			->where('exported = 0')
		  			->where('order.store_id ='. $store->getId())	;
		  		
		  		$exports = array();
		  			
		  		foreach($oderCollection as $order){
		  			$hhs = !empty($order->getHaushaltsSystem()) ? $order->getHaushaltsSystem() : 'default' ;
		  			//if(!empty($hhs)){
		  				if(!isset($exports[$hhs])){
		  					$exports[$hhs]=array();
		  				}
		  				
		  				$exports[$hhs][] = $order->getOrderId();
		  			//}
		  		}
		  		
		  		
		  		foreach($exports as $model){
		  			$export = Sid_Haushalt_Model_Type::factory($model);
		  			$export->setStoreId($store->getId())
		  					->setOrderIds($model);
		  			$data = $export->getExportData();
		  			$export->saveFile($data);
		  		}
		  		
	  		}
  		}
  		
  	}
    
}