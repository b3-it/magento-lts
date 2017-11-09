<?php
/**
 * 
 *  Automatische Aktvierung bzw Deaktivierung einer cms Page
 *  @category Egovs
 *  @package  Sid_Cms_Model_Cron
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Model_Cron extends Mage_Core_Model_Abstract
{
 
    public function run()
    {
    	$this->getIsRunning('sid_cms',1);
    	
    	try{
    		
			$this->setStatus('activate_time',Mage_Cms_Model_Page::STATUS_ENABLED);
			$this->setStatus('deactivate_time',Mage_Cms_Model_Page::STATUS_DISABLED);
	    	

    	}
    	catch(Exception $ex)
    	{
    		$this->setLogException($ex);
    		Mage::logException($ex);
    		Mage::throwException('sid_cms Error running Service');	
    	}
    	return true;
    }
    
    
    
  
    
    protected function setStatus($field, $status)
    {
    	/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
    	$date = Mage::getModel('core/date')->Date();
    	$collection = Mage::getModel('cms/page')->getCollection();
    	$collection->getSelect()
    		->where($field .' is not null')
    		->where($field ." < '" .$date."'");
    	
    	foreach($collection as $page){
    		$page
    			->setData($field,null)
    			->setIsActive($status)
    			->save();
    	}
    }
    
    
    
    /**
     * Einsprung
     * 
     * @param Mage_Cron_Model_Schedule $schedule Schedule
     */
	public function runCron($schedule) 
	{		
		Mage::app()->addEventArea(Mage_Core_Model_App_Area::AREA_FRONTEND);
		if ($this->getIsRunning($schedule->getJobCode(), $schedule->getId())) {
			$message ='sid::cron some service running';
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
    		
    
}