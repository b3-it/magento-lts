<?php

class Sid_Framecontract_Model_Cron extends Mage_Core_Model_Abstract
{
   
	/**
	 * Abgelaufenen Verträge und zugehoerige Produkte deaktivieren
	 * 
	 * @param Mage_Cron_Model_Schedule $sceduler Schedule
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
			
		}
		
		//ablufdatum der Links setzen
		$collection = Mage::getModel('framecontract/los')->getCollection();
		$collection->getSelect()
			->where("link_valid_to_modified < '". date('Y-m-d',time() - (24 * 60 * 60))."'")
			->orwhere('link_valid_to_modified is null');
		
		foreach($collection->getItems() as $los)
		{
			$n = intval($los->getLinkValidTo());
			if($n > 0){
				$n--;
				$los->setLinkValidTo($n)
					->setLinkValidToModified(now())
					->save();
			}
		}
	}
    
	/**
	 * Warnung versenden falls ein Schwellwert fürs Lager erreicht ist
	 * 
	 * @param Mage_Cron_Model_Schedule $sceduler Schedule
	 */
	public function sendStockWarning($sceduler)
	{
		$model= Mage::getModel('framecontract/stockstatus');
		$model->sendStockStatusEmail();
	}
 
}