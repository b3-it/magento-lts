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
class Egovs_Isolation_Model_Observer_Customer extends Egovs_Isolation_Model_Observer_Abstract
{
   
    public function onCustomerCollectionLoad($observer)
    {
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		
    		
    		$storeGroups = implode(',', $storeGroups);
	    	$collection = $observer->getCollection();

	    	
	    	//hier Schalter einbauen falls der Kunde nur sichtbar sein soll falls im Store angelegt
	    	if(true){
	    	$orderItem = new Zend_Db_Expr("((e.entity_id IN (SELECT customer_id FROM ".$collection->getTable('sales/order_item')." as oi
									join ".$collection->getTable('sales/order')." as o on o.entity_id =  oi.order_id 
									where store_group in (".$storeGroups.")
									group by store_group, customer_id))
									OR (e.store_id IN ( SELECT store_id from ".$collection->getTable('core/store'). " WHERE group_id IN ("  . $storeGroups."))))");

	    	$collection->getSelect()->where($orderItem);
	    	}else{
                $collection->getSelect()->where('e.store_id IN ( SELECT store_id from '.$collection->getTable('core/store'). ' WHERE group_id IN ('  . $storeGroups.'))');
            }
	    	
	    
    	}
    	//die($collection->getSelect()->__toString());
    }
    
    
    public function onCustomerLoad($observer)
    {
    	$customer = $observer->getCustomer();
    	$StoreViews = $this->getUserStoreViews();
    	$storeGroups = $this->getUserStoreGroups();
    	$store = $customer->getStoreId();
	
    	if($store === 0 ) { return; }
    	if($customer->getId()==0) { return; }
    	
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
    		
    		$collection = Mage::getModel('sales/order')->getCollection();
    		//SalesOrderCollection filtert bereits nach gekauften Items    		
    		//$expr = new Zend_Db_Expr("(SELECT order_id as oid FROM ".$collection->getTable('sales/order_item')." WHERE store_group in (".$storeGroups.") GROUP BY order_id)");
    		$collection->getSelect()
    			//->join(array('order_item' => $expr),"order_item.oid=main_table.entity_id",array())
    			->where('customer_id = '. intval($customer->getId()))
    			;
 			//die($collection->getSelect()->__toString());   		
    		if(count($collection->getItems()) > 0)
    		{
    			return ;
    		}
    		
    	
    	}
    	
    	if(($store) &&($StoreViews) && (count($StoreViews) > 0))
    	{ 
	    	foreach ($StoreViews as $st)
	    	{
	    		if($st == $store)
	    		{
	    			return;
	    		}
	    	}
	    	$this->denied();
    	}
    	
    }
    
    public function onCustomerWishlistLoad($observer)
    {
    	$collection = $observer->getWishlistItemCollection();
    	if($collection == null) return;
    	$storeGroups = Mage::helper('isolation')->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups = implode(',', $storeGroups);
    	
    		$expr = new Zend_Db_Expr("(SELECT entity_id FROM ".$collection->getTable('catalog/product') 
    				." WHERE store_group in (".$storeGroups.") GROUP BY entity_id)");
    		$collection->getSelect()
    		->where("main_table.product_id IN (".$expr.")");
    		//die($collection->getSelect()->__toString());
    	}
    
    }
  
}