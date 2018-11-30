<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Observer_Cms
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_Cms extends Egovs_Isolation_Model_Observer_Abstract
{
  /**
   * für die Cms Seiten
   * @param Varien_Event_Observer $observer Observer
   */
	public function onPageCollectionLoad($observer)
	{
		$storeViews = $this->getUserStoreViews();
		if(($storeViews) && (count($storeViews) > 0))
		{
			$storeViews[] = '0';
			$collection = $observer->getCollection();
			$storeViews = implode(',', $storeViews);
			
			$expr = new Zend_Db_Expr('SELECT page_id FROM '.$collection->getTable('cms/page_store').' WHERE store_id IN ('.$storeViews.') group by page_id');
			
			$collection->getSelect()
				->where('main_table.page_id in(?)',$expr);
		}
		
	}
    
	/**
	 * Für die Cms Blöcke
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onBlockCollectionLoad($observer)
	{
	$storeViews = $this->getUserStoreViews();
		if(($storeViews) && (count($storeViews) > 0))
		{
			$storeViews[] = '0';
			$collection = $observer->getCollection();
			$storeViews = implode(',', $storeViews);
			
			$expr = new Zend_Db_Expr('SELECT block_id FROM '.$collection->getTable('cms/block_store').' WHERE store_id IN ('.$storeViews.') group by block_id');
			
			$collection->getSelect()
				->where('main_table.block_id in(?)',$expr);
		}
	
	}
	

	/**
	 * Für die Cms Navigation
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onNaviCollectionLoad($observer)
	{
		$storeViews = $this->getUserStoreViews();
		if(($storeViews) && (count($storeViews) > 0))
		{
			$storeViews[] = '0';
			$collection = $observer->getCollection();
			$storeViews = implode(',', $storeViews);
								
			$collection->getSelect()
			->where('main_table.store_id in(?)',$storeViews);
		}
	
	}
	
	/**
	 * Für die Cms Navigation
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onNaviLoad($observer)
	{
		$model = $observer->getObject();
		
		if($model->getId() == 0){
			return;
		}
		
		$storeViews = $this->getUserStoreViews();
		if(($storeViews) && (count($storeViews) > 0))
		{
			if(!in_array($model->getStoreId(), $storeViews))
			{
				$this->denied();
			}
		}
	}
    
   
    
   
}
