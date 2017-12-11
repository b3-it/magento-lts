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
class Egovs_Isolation_Model_Observer_Report extends Egovs_Isolation_Model_Observer_Abstract
{
  
	public function onEventBundleOptionsCollectionLoad($observer)
	{
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			$collection = $observer->getCollection();
			$storeGroups = implode(',', $storeGroups);
			$collection->getSelect()->where('main_table.store_group in('.$storeGroups.')');
		}
		
	}
    
    
    public function onCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCollection($observer->getCollection(),'entity_id');
    }
    
    public function onBestsellerCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToBestsellersCollection($observer->getCollection(),'entity_id');
    	//die($observer->getCollection()->getSelect()->__toString());
    }
    
    public function onCustomerCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCustomerCollection($observer->getCollection());
    	//die($observer->getCollection()->getSelect()->__toString());
    }
    
    public function onSalesOrderCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCollection($observer->getOrderCollection(),'entity_id');
    }

    
    /**
     * Hinzufügen eines Filters der SoreGroupId's der Order
     * @param $collection
     * @param $order_id_field
     */
	protected function addStoreGroupFilterToCollection($collection, $order_id_field = "order_id")
    {
    	if($collection == null) return;
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
	    	
	    	$expr = new Zend_Db_Expr("(SELECT order_id as oid FROM ".$collection->getTable('sales/order_item'). " as orderitem"
	    		//	." join ".$collection->getTable('catalog/product') . " as product ON product.entity_id=orderitem.product_id"
	    			." WHERE orderitem.store_group in (".$storeGroups.") GROUP BY order_id)");
	       	$collection->getSelect()
	    		->join(array('order_item' => $expr),"order_item.oid=main_table.".$order_id_field,array());
	    	//die($collection->getSelect()->__toString());
    	}	
    }
    
    /**
     * Hinzufügen eines Filters der SoreGroupId's der Order
     * @param $collection
     * @param $order_id_field
     */
    protected function addStoreGroupFilterToBestsellersCollection($collection)
    {
    	if($collection == null) return;
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups = implode(',', $storeGroups);
    
    		$expr = new Zend_Db_Expr("(SELECT order_id as oid FROM ".$collection->getTable('sales/order_item'). " as orderitem"
    				//	." join ".$collection->getTable('catalog/product') . " as product ON product.entity_id=orderitem.product_id"
    				." WHERE orderitem.store_group in (".$storeGroups.") GROUP BY order_id)");
    		$collection->getSelect()
    		->join(array('item' => 'catalog_product_entity'),"item.entity_id=sales_bestsellers_aggregated_yearly.product_id AND  item.store_group in (".$storeGroups.")",array());
    		//die($collection->getSelect()->__toString());
    	}
    }
    
    protected function addStoreGroupFilterToCustomerCollection($collection)
    {
    	if($collection == null) return;
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups = implode(',', $storeGroups);
    		$collection->getSelect()->where('e.store_id IN ('.$storeGroups.')');
    
    		/*
    		$collection->getSelect()
    		->join(array('item' => 'catalog_product_entity'),"item.entity_id=sales_bestsellers_aggregated_yearly.product_id AND  item.store_group in (".$storeGroups.")",array());
    		*/
    		//die($collection->getSelect()->__toString());
    	}
    }
    
    
    
   
}
