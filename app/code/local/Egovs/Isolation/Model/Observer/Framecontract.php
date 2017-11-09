<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Relation
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_Framecontract extends Egovs_Isolation_Model_Observer_Abstract
{
  /**
   * für die Lieferanten des IT Warenhauses
   * @param Varien_Event_Observer $observer Observer
   */
	public function onVendorCollectionLoad($observer)
	{
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			$collection = $observer->getCollection();
			$storeGroups = implode(',', $storeGroups);
			$collection->getSelect()->where('main_table.store_group in('.$storeGroups.')');
		}
		
	}
    
	/**
	 * Für die Verträge des IT Warenhauses
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onContractCollectionLoad($observer)
	{
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			$collection = $observer->getCollection();
			$storeGroups = implode(',', $storeGroups);
			$collection->getSelect()->where('main_table.store_id in('.$storeGroups.')');
		}
	
	}
	
	/**
	 * Für die Lose des IT Warenhauses
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onLosCollectionLoad($observer)
	{
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			$collection = $observer->getCollection();
			$storeGroups = implode(',', $storeGroups);
			
			$expr = new Zend_Db_Expr('SELECT framecontract_contract_id FROM '.$collection->getTable('framecontract/contract').' WHERE store_id IN ('.$storeGroups.')');
			
			$collection->getSelect()
			->where('main_table.framecontract_contract_id IN(?)',$expr);
			
		}
	
	}
	
	public function onOrderExportLoad($observer)
	{
		/* @var $model Sid_ExportOrder_Model_Order */
		$model = $observer->getObject();
		
		if($model->getId() == 0){
			return;
		}
		
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			if(!in_array($model->getContract()->getStoreId(), $storeGroups))
			{
				$this->denied();
			}
		}
		
	}
	
	public function onVendorLoad($observer)
	{
		// @var $model Sid_Framecontract_Model_Vendor
		$model = $observer->getObject();
	
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			
			//Mage::log(print_r($storeGroups));
			//Mage::log(var_export($model, true));
			
			if(!in_array($model->getStoreGroup(), $storeGroups))
			{
				$this->denied();
			}
		}
	
	}
	
	public function onContractLoad($observer)
	{
		/* @var $model Sid_Framecontract_Model_Contract */
		$model = $observer->getObject();
	
		if($model->getId() == 0){
			return;
		}
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			if(!in_array($model->getStoreId(), $storeGroups))
			{
				$this->denied();
			}
		}
	}
    
   
    
   
}
