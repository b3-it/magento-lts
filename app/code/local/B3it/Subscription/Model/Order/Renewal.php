<?php

class B3it_Subscription_Model_Order_Renewal extends B3it_Subscription_Model_Abstract
{
    /**
     * SubscriptionProdukte neu bestellen
     *
     */
    public function renewAllPendingOrders($limit = 20)
    {
    	$exp1 = new Zend_Db_Expr("(order.status = '".Mage_Sales_Model_Order::STATE_COMPLETE ."') OR (order.status = '".Mage_Sales_Model_Order::STATE_PROCESSING."')");
    	 
    	$collection = Mage::getModel('b3it_subscription/subscription')->getCollection();
    	
    	$collection->getSelect()
    		->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.first_order_id',array('order_status'=>'status','store_id'=>'store_id'))
    		->join(array('customer'=>'customer_entity'),'order.customer_id=customer.entity_id',array('customer_id'=>'customer.entity_id'))
    		->where("(renewal_date) <= ('".Mage::getModel('core/date')->gmtDate()."')")
    		->where('main_table.status = '.B3it_Subscription_Model_Status::STATUS_ACTIVE)
    		->where('renewal_status = '.B3it_Subscription_Model_Renewalstatus::STATUS_PAUSE)
    		->where($exp1)
    		->order('main_table.order_group')
    		->limit($limit);
    	
    	//die($collection->getSelect()->__toString());
        $customerId = 0;
        $orderGroup = null;
    	$items = array();
    	$notAvilable = array();
    	foreach ($collection->getItems() as $item)
    	{
    		$item->saveRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_ORDER_PENDING);
    		

    		if(($item->getCustomerId() != $customerId ) || ($item->getOrderGroup() != $orderGroup))
    		{
    			$items[$item->getOrderGroup()] = array();
    			
    		}
    		if($this->_isAvailable($item)){
    			$items[$item->getOrderGroup()][] = $item;
    		}else {
    			$notAvilable[] = $item;
    		}
            $orderGroup = $item->getOrderGroup();
            $customerId = $item->getCustomerId();
    	}
    	
    	$this->_renewOrder($items);
  		
    	//nicht verfügbare bearbeiten
    	$this->_processNotAvailableItems($notAvilable);
    	return $this;
    }
    
    /**
     * prüfen ob das ursprüngliche Produkt noch zu verfügung steht
     * @return boolean
     */
    protected function _isAvailable($orderItem)
    {
    	$p = Mage::getModel('catalog/product')->load($orderItem->getProductId());
    	if(($p->getId() == 0) || ($p->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_DISABLED)){
    		return false;
    	}
    	
    	return true;
    }
    
    
   /**
    * für die Items eines Abonnements eine Bestellung erstellen
    * @param array B3it_Subscription_Model_Subscription  $items
    */ 
   protected function _renewOrder($items2D) {
       foreach ($items2D as $item1D) {
           try {
               if (count($item1D) > 0) {
                       /** @var $order B3it_Subscription_Model_Order_Order */
                       $order = Mage::getModel('b3it_subscription/order_order');
                       Mage::dispatchEvent('b3it_subscription_order_create_before', array('data' => $item1D));
                       $order->setItems($item1D);
                       $order->placeOrder();
                       Mage::dispatchEvent('b3it_subscription_order_create_after', array('data' => $item1D));

               }
            }
            catch (Exception $ex)
            {
                Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
            }
	   	}
   } 
   
   
   /**
    * nicht verfügbare Produkte (Zeitraum, Station, Produkt fehlt) einen Nachrichtverseneden und Subscription deaktivieren
    * @param  array B3it_Subscription_Model_Subscription $items
    */
   protected function _processNotAvailableItems($items)
   {
        if (count($items) > 0) {
            foreach ($items as $item){
                $item->setStatus(B3it_Subscription_Model_Status::STATUS_DELETE);
                $item->getResource()->saveField($this,'status');
                Mage::dispatchEvent('b3it_subscription_product_not_available',array('data'=>$item));
            }
        }
   }
   

}