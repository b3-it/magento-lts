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
class Egovs_Isolation_Model_Observer_Order extends Egovs_Isolation_Model_Observer_Abstract
{
  
    public function onQuoteItemSetProduct($observer)
    {
    	$product = null;
    	$items = $observer->getItems();
    	foreach ($items as $quoteItem)
    	{
	        if($quoteItem){
	        	$product = $quoteItem->getProduct();
	        } 
	        if($product && $quoteItem)
	        {
	        	if($product->getStoreGroup()){
	        		$quoteItem->setStoreGroup($product->getStoreGroup());
	        	}
	        	//fallback für grupped Produkte
	        	else{
	        		$product = Mage::getModel('catalog/product')->load($product->getId());
	        		$quoteItem->setStoreGroup($product->getStoreGroup());
	        	}
	        }
    	}
        return $this;
    }
    
    
    public function onOrderCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCollection($observer->getOrderGridCollection(),'main_table.entity_id');
    }
    
	public function onOrderLoad($observer)
    {   	
    	$order = $observer->getOrder();
    	$this->testOrderAllow($order->getId(),$order);	
    	self::$_AllowProductLod4View = true;
    }
    
	public function onOrderInvoiceCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCollection($observer->getOrderInvoiceCollection());
    }
    
    public function onOrderInvoiceGridCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCollection($observer->getOrderInvoiceGridCollection());
    }
    
	public function onOrderInvoiceLoad($observer)
    {   	
    	$sale_item = $observer->getInvoice();
    	$this->testOrderAllow($sale_item->getOrderId());
    	self::$_AllowProductLod4View = true;
    }
    
	public function onOrderShipmentCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCollection($observer->getOrderShipmentGridCollection());
    }
    
	public function onOrderShipmentLoad($observer)
    {   	

    	$sale_item = $observer->getShipment();
    	if($sale_item->getOrderId())
    	{
    		$this->testOrderAllow($sale_item->getOrderId());
    		self::$_AllowProductLod4View = true;
    	}
    }
    
	public function onOrderCreditmemoCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToCollection($observer->getOrderCreditmemoGridCollection());
    }
    
	public function onOrderCreditmemoLoad($observer)
    {   	
    	$sale_item = $observer->getCreditmemo();
    	$this->testOrderAllow($sale_item->getOrderId());
    }
    
    /**
     * Prüfen ob der User ein Produkt in der Order hat
     * @param Mage_Sales_Model_Order $orderid
     */
	protected function testOrderAllow($orderid, $order = null)
    {  
    	$storeGroups = $this->getUserStoreGroups();
    	
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
    		if($order == null)
    		{
    			$order = Mage::getModel('sales/order')->load($orderid);
    		}
    		
    		$collection = Mage::getModel('core/store')->getCollection();
    		$collection->getSelect()
    			->where('group_id IN('.$storeGroups.')');
    		
    		if($order->getCustomerId())
    		{
    			$customer =  Mage::getModel('customer/customer')->load($order->getCustomerId());
    			$collection->getSelect()
    			->where('store_id = '. $customer->getStoreId());
    		}
    		
    		//die($collection->getSelect()->__toString());
    		if(count($collection->getItems()) > 0)
    		{
    			return true;
    		}
    	}
    	
    	if($this->getRelatedOrderItems4Order($orderid) == 0)
    	{
    		$this->denied();
    	}	
    }
    
    /**
     * Hinzufügen eines Filters der SoreGroupId's des Users
     * @param $collection
     * @param $order_id_field
     */
	protected function addStoreGroupFilterToCollection($collection, $order_id_field = "order_id")
    {
    	if($collection == null) return;
        if($this->_skipIsolation()) return null;

    	$storeGroups = $this->getUserStoreGroups();
    	$storeViews = $this->getUserStoreViews();
    	if(($storeGroups) && (count($storeGroups) > 0) || ($storeViews) && (count($storeViews) > 0))
    	{
    		$collection->getSelect()->where("{$order_id_field} in (?)", $this->_getOrderIdsDbExpr());

	    	//die($collection->getSelect()->__toString());
    	}	
    }
    
    protected function addStoreGroupFilterToQuoteCollection($collection, $order_id_field = "order_id")
    {
    	if($collection == null) return;
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups = implode(',', $storeGroups);
    		
    		$expr = new Zend_Db_Expr("(SELECT quote_id as oid FROM ".$collection->getTable('sales/quote_item'). " as orderitem"
    				." join ".$collection->getTable('catalog/product') . " as product ON product.entity_id=orderitem.product_id"
    				." WHERE product.store_group in (".$storeGroups.") GROUP BY quote_id)");
    		$collection->getSelect()
    		->join(array('order_item' => $expr),"order_item.oid=main_table.".$order_id_field,array());
    		//die($collection->getSelect()->__toString());
    	}
    }
    
    
    public function onQuoteItemCollectionLoad($observer)
    {
    	$this->addStoreGroupFilterToQuoteCollection($observer->getQuoteItemCollection(),'quote_id');
    }
    
}
