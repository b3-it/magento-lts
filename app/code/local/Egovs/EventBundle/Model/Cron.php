<?php
/**
 * 
 *  Eventbundle Produkte automatisch deaktivieren bzw. unverkäuflich setzen
 *  @category Egovs
 *  @package  Egovs_EventBundle_Model_Cron
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Cron extends Mage_Core_Model_Abstract
{
 
    public function run()
    {
    	$this->getIsRunning('egovs_eventbundle',1);
    	
    	try{
    		
			$this->setIsNotSaleable();
			$this->setDisabled();
	    	

    	}
    	catch(Exception $ex)
    	{
    		$this->setLogException($ex);
    		Mage::logException($ex);
    		Mage::throwException('egovs_eventbundle Error running Service');	
    	}
    	return true;
    }
    
    
    
    protected function setIsNotSaleable()
    {
    	/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
    	$collection = Mage::getModel('catalog/product')->getCollection();
    	$collection->addAttributeToSelect('*');
    	$collection->addAttributeToFilter('date_notsaleable',array('neq'=>null));
    	$collection->addAttributeToFilter('date_notsaleable',array('lt'=> Mage::getModel('core/date')->date()));
    	$collection->getSelect()->where("type_id = '".Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE."'");
    	
    	foreach($collection as $product){
    		$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product->getId());
    		$stockItem->setManageStock(true);
    		$stockItem->setUseConfigManageStock(false);
    		$stockItem->setIsInStock(false);
    		$stockItem->save();
    		$product->setDateNotsaleable(null)->save();
    	}
    }
    
    protected function setDisabled()
    {
    	/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
    	$collection = Mage::getModel('catalog/product')->getCollection();
    	$collection->addAttributeToSelect('*');
    	$collection->addAttributeToFilter('status', array('eq'=>Mage_Catalog_Model_Product_Status::STATUS_ENABLED));
    	$collection->addAttributeToFilter('date_disable',array('neq'=>null));
    	$collection->addAttributeToFilter('date_disable',array('lt'=> Mage::getModel('core/date')->date()));
    	$collection->getSelect()->where("type_id = '".Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE."'");
    	 
    	foreach($collection as $product){
    		$product
    			->setStatus(Mage_Catalog_Model_Product_Status::STATUS_DISABLED)
    			->save();
    	}
    }
    
    
    
    /**
     * Einsprung
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     */
	public function runCron($schedule) 
	{		
		Mage::app()->addEventArea(Mage_Core_Model_App_Area::AREA_FRONTEND);
		if ($this->getIsRunning($schedule->getJobCode(), $schedule->getId())) {
			$message ='dwd::abomigration Some abomigration service running';
			$this->setLog('Found running Service my Id is:' . $schedule->getId());
			Mage::throwException($message);
		}
		$this->run();
	}
    
    /**
     * 
     * Ermitteln ob noch ein Cronjob läuft
     * @param string  $job_code
     * @param integer $job_id
     * @param Varien_Event $timespan Zeit in sekunden; default 1h
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
    		
    
}