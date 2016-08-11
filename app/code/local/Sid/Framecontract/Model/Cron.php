<?php

class Sid_Framecontract_Model_Cron extends Mage_Core_Model_Abstract
{
   
	/**
	 * Abgelaufenen Verträge und zugehoerige Produkte deaktivieren
	 * @param unknown $sceduler
	 */
	public function disableExpiredContracts($sceduler)
	{
		$collection = Mage::getModel('framecontract/contract')->getCollection();
		$collection->getSelect()
			->where("end_date < '". date('Y-m-d')."'")
			->where('status ='.Sid_Framecontract_Model_Status::STATUS_ENABLED );
		
		foreach($collection->getItems() as $contract)
		{
			$contract->setStatus(Sid_Framecontract_Model_Status::STATUS_DISABLED)->save();
			$contract->alterLosStatus(Sid_Framecontract_Model_Status::STATUS_DISABLED);
		}
	}
    
	/**
	 * Warnung versenden falls ein Schwellwert erreicht ist
	 * @param unknown $sceduler
	 */
	public function sendStockWarning($sceduler)
	{
		$model= Mage::getModel('framecontract/stockstatus');
		$model->sendStockStatusEmail();
	}
 
}