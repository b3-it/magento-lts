<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Subscription
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2012 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @copyright  	Copyright (c) 2014 B3 - IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */



class B3it_Subscription_Model_Subscription extends B3it_Subscription_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_subscription/subscription');
    }

    /**
     * Neue Bestellungen als Abonement einordnen
     * @param $orderItem Item der Bestellung
     * @param null $startDate Tag des Anfangs diesert Periode
     * @param int $periodeLength Länge der Periode in Tagen
     * @param int $renewalOffsett Zeitpunkt der Erneuerung in Tagen vom errechneten Enddatum ggf. mit negativem Vorzeichen
     * @return B3it_Subscription_Model_Subscription
     * @throws Exception
     */
    protected function _addNewOrderItem($orderItem, $startDate = null, $periodeLength = 365, $renewalOffset = 0 )
    {
    	$subscription = Mage::getModel('b3it_subscription/subscription');
    	$subscription->setFirstOrderId($orderItem->getOrderId());
    	$subscription->setFirstOrderitemId($orderItem->getId());
    	$subscription->setCurrentOrderId($orderItem->getOrderId());
    	$subscription->setCurrentOrderitemId($orderItem->getId());
    	$subscription->setRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_PAUSE);
    	$subscription->setStatus(B3it_Subscription_Model_Status::STATUS_ACTIVE);
    	$subscription->setOrderGroup($orderItem->getOrder()->getIncrementId());

    	if($startDate == null){
            $startDate = new Zend_Date();
        }

    	$subscription->setStartDate($startDate);
    	$subscription->setPeriodeLength($periodeLength);
    	$subscription->setRenewalOffset($renewalOffset);

        $stopDate = new Zend_Date($startDate, Varien_Date::DATETIME_INTERNAL_FORMAT, null);
        $stopDate->add($periodeLength, Zend_Date::DAY);

    	$subscription->setStopDate($stopDate);


    	$date = new Zend_Date($stopDate, Varien_Date::DATETIME_INTERNAL_FORMAT, null);

    	$date->add($renewalOffset, Zend_Date::DAY);
    	$subscription->setCancelationPeriodEnd($date);
    	$subscription->save();
        return $this;
    }

    
    /**
     * SubscriptionProdukte neu bestellen
     *
     */
    protected function _renewOrders($limit = 20)
    {
    	$exp1 = new Zend_Db_Expr("(order.status = '".Mage_Sales_Model_Order::STATE_COMPLETE ."') OR (order.status = '".Mage_Sales_Model_Order::STATE_PROCESSING."')");
    	 
    	$collection = $this->getCollection();
    	
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
    		$item->setRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_ORDER_PENDING);
    		$item->saveField('renewal_status');

    		if(($item->getCustomerId() != $customerId ) || ($item->getOrderGroup() != $orderGroup))
    		{
    			$this->_orderItems($items);
    			$items = array();
    			
    		}
    		if($this->_isAvailable($item)){
    			$items[] = $item;
    		}else {
    			$notAvilable[] = $item;
    		}
            $orderGroup = $item->getOrderGroup();
            $customerId = $item->getCustomerId();
    		
    	}
    	//die Letzten bearbeiten
    	$this->_orderItems($items);
  		
    	//nicht verfügbare bearbeiten
    	$this->_processNotAvailableItems($notAvilable);
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
    * für die Items einse Abonnements eine Bestellung erstellen
    * @param array B3it_Subscription_Model_Subscription  $items
    */ 
   protected function _orderItems($items)
   {
	   	try
	   	{
	   		if (count($items) > 0) {
	   			/** @var $order B3it_Subscription_Model_Order_Order */
	   			$order = Mage::getModel('b3it_subscription/order_order');
                Mage::dispatchEvent('b3it_subscription_order_create_before',array('data'=>$items));
	   			$order->createOrders($items);
                Mage::dispatchEvent('b3it_subscription_order_create_after',array('data'=>$items));
	   		}
	   	}
	   	catch(Exception $ex)
	   	{
	   		Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
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
                $item->saveField('status');
                Mage::dispatchEvent('b3it_subscription_product_not_available',array('data'=>$item));
            }
        }
   }
   

   
   /**
    * Helper Datun in Lokaler Zeit formatieren
    * @return string <string, unknown>
    */
   public function getStopDateFormated() {
   		$sDate = $this->getStopDate();
   		$date = Mage::app()->getLocale()->date($sDate, null, null, true);
   		return $date->toString(Zend_Date::DATE_MEDIUM);
   }
   
   /**
    * Helper Datun in Lokaler Zeit formatieren
    * @return string <string, unknown>
    */
   public function getStartDateFormated() {
	   	$sDate = $this->getStartDate();
	   	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
	   	return $date->toString(Zend_Date::DATE_MEDIUM);
   }
   
   /**
    * Helper Datun in Lokaler Zeit formatieren
    * @return string <string, unknown>
    */
   public function getStopDateTimeFormated() {
	   	$sDate = $this->getStopDate();
	   	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
	   	return $date->toString(Zend_Date::DATETIME_MEDIUM);
   }
    
   /**
    * Helper Datun in Lokaler Zeit formatieren
    * @return string <string, unknown>
    */
   public function getStartDateTimeFormated() {
	   	$sDate = $this->getStartDate();
	   	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
	   	return $date->toString(Zend_Date::DATETIME_MEDIUM);
   }
   
   /**
    * Helper Datun in Lokaler Zeit formatieren
    * @return string <string, unknown>
    */
   public function getRenewalDateFormated() {
	   	$sDate = $this->getRenewalDate();
	   	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
	   	return $date->toString(Zend_Date::DATETIME_MEDIUM);
   }
   
}