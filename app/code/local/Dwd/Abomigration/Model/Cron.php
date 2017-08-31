<?php
/**
 * 
 *  Periodisch Nutzer und AboBestellungen Anlegen
 *  @category Egovs
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abomigration_Model_Cron extends Mage_Core_Model_Abstract
{
 	private static $_isRunning = false; 	
 	private $_ScheduleId = 0;
	
	
    public function run()
    {
    	$this->setLog('ScheduleId: '.$this->_ScheduleId);
    	if(self::$_isRunning){
    		$this->setLog('isRunning ->exit');
    		return $this;
    	}
    	self::$_isRunning = true;
    	
    	try{
	    	$model = Mage::getModel('abomigration/abomigration');
	    	
	    	$this->setLog('Starting abomigration service');
	    	
	    	$this->setLog('create customers');
	    	$model->createCustomerAccounts();
	    	
	    	$this->setLog('create addresses');
	    	$model->createCustomerAddresses();
	    	
	    	$this->setLog('create orders');
	    	$model = Mage::getModel('abomigration/order');
	    	$model->createNewAboOrders();
	    	$this->setLog('Ending abomigration service');
    	}
    	catch(Exception $ex)
    	{
    		$this->setLogException($ex);
    		Mage::logException($ex);
    		Mage::throwException('dwd_abomigration Error running Service');	
    	}
    	return true;
    }
    
    
    
    
	public function runCron($schedule) 
	{		
		$this->_ScheduleId = $schedule->getId();
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