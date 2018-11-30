<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Abo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2014 B3 - IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 * @method int getHasTierPrice() | die Anzahl der Abos die zum Staffelpreis geführt haben
 * @method setHasTierPrice(int) | die Anzahl der Abos die zum Staffelpreis geführt haben
 */

class Dwd_Abo_Model_Abo extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_abo/abo');
    }
    
    /**
     * Neue Bestellungen finden und als Abo einordnen
     */
    public function collectNewOrders()
    {
    	
    	$exp1 = new Zend_Db_Expr("(order.status = '".Mage_Sales_Model_Order::STATE_COMPLETE ."') OR (order.status = '".Mage_Sales_Model_Order::STATE_PROCESSING."')");
    	
    	$collection = Mage::getModel('sales/order_item')->getCollection();
    	$exp = new Zend_Db_Expr('(SELECT current_orderitem_id FROM '.$collection->getTable('dwd_abo/abo').')');
    	$collection->getSelect()
    		->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.order_id',array('order_status'=>'status'))
    		->where('item_id not in '. $exp)
    		->where('period_type = '.Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO)
    		->where($exp1);
    	
    	//die($collection->getSelect()->__toString());
    	foreach($collection->getItems() as $orderitem)
    	{
    			$abo = Mage::getModel('dwd_abo/abo');
    			$abo->setFirstOrderId($orderitem->getOrderId());
    			$abo->setFirstOrderitemId($orderitem->getId());
    			$abo->setCurrentOrderId($orderitem->getOrderId());
    			$abo->setCurrentOrderitemId($orderitem->getId());
    			$abo->setRenewalStatus(Dwd_Abo_Model_Renewalstatus::STATUS_PAUSE);
    			$abo->setStatus(Dwd_Abo_Model_Status::STATUS_ACTIVE);
    			$abo->setStartDate($orderitem->getPeriodStart());
    			$abo->setStopDate($orderitem->getPeriodEnd());
    			
    		
    			$cancel = 14; //default 14 Tage Kündigungsfrist 
    			$periode = $this->getPeriode($orderitem);
    			if($periode)
    			{
    			
    				$abo->setStartDate($periode->getStartDate());
    				$abo->setStopDate($periode->getEndDate());
    				$cancel = $periode->getCancelationPeriod();
    			}
    			
    			
    			$date = new Zend_Date($abo->getStopDate(), Varien_Date::DATETIME_INTERNAL_FORMAT, null);
    			
    			$date->add($cancel *-1, Zend_Date::DAY);
    			$abo->setCancelationPeriodEnd($date);
    			$abo->save();
    			
    			$n= 0;
    			$br = $orderitem->getBuyRequest();
    			if($br)
    			{
    				if($depends = $br->getPeriodeTierPriceDepends())
    				{
    					foreach($depends as $d)
    					{
    						$td = Mage::getModel('dwd_abo/tierpricedepends');
    						$td->setProviderOrderitemId($d);
    						$td->setBenefitOrderitemId($orderitem->getId());
    						$td->save();
    						$n++;
    					}
    					$abo->setHasTierPrice($n)->save();
    				}
    				
    			}
    	}
    }
    
    
    
    /**
     * Periode aus der QuoteOption lesen, oder anhand der Id Laden 
     * @param Mage_Sales_Model_Order_Item $orderitem
     * @return Dwd_Periode_Model_Periode|<Mage_Core_Model_Abstract, Mage_Core_Model_Abstract>|NULL
     */
    private function getPeriode($orderitem)
    {  	 
    	$collection = Mage::getModel('sales/quote_item_option')->getCollection();
    	$collection->getSelect()->where('item_id='.intval($orderitem->getQuoteItemId()));
    	 
    	$periode = null;
    	foreach ($collection->getItems() as $option)
    	{
    		if($option->getCode() == 'period_object'){
    			$periode = unserialize($option->getValue());
    		}
    	}
    	 
    	if($periode instanceof Dwd_Periode_Model_Periode )
    	{
    		return $periode;
    	}
    	 
    	$periode = Mage::getModel('periode/periode')->load($orderitem->getPeriodId());
    	if($periode->getId()){
    		return $periode;
    	}
    	
    	return null;
    	 
    }
    
    /**
     * AboProdukte neu bestellen 
     * @param number $limit
     */
    public function renewOrders($limit = 20)
    {
    	$exp1 = new Zend_Db_Expr("(order.status = '".Mage_Sales_Model_Order::STATE_COMPLETE ."') OR (order.status = '".Mage_Sales_Model_Order::STATE_PROCESSING."')");
    	 
    	$collection = $this->getCollection();
    	
    	$collection->getSelect()
    		->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.first_order_id',array('order_status'=>'status','store_id'=>'store_id'))
    		->join(array('customer'=>'customer_entity'),'order.customer_id=customer.entity_id',array('customer_id'=>'customer.entity_id'))
    		->join(array('orderitem'=>'sales_flat_order_item'),'orderitem.item_id = main_table.current_orderitem_id',array('product_id'=>'product_id','period_id'=>'period_id','station_id'=>'station_id'))
    		->where("(cancelation_period_end) <= ('".Mage::getModel('core/date')->gmtDate()."')")
    		->where('main_table.status = '.Dwd_Abo_Model_Status::STATUS_ACTIVE)
    		->where('renewal_status = '.Dwd_Abo_Model_Renewalstatus::STATUS_PAUSE)
    		->where($exp1)
    		->order('main_table.first_order_id')
    		->limit($limit);
    	
    	//die($collection->getSelect()->__toString());
    	$orderId = 0;
    	$items = array();
    	$notAvilable = array();
    	foreach ($collection->getItems() as $item)
    	{
    		$item->setRenewalStatus(Dwd_Abo_Model_Renewalstatus::STATUS_ORDER_PENDING);
    		$item->save();
    		if($item->getFirstOrderId() !=  $orderId )
    		{
    			$this->processItems($items);
    			$items = array();
    			
    		}
    		if($this->isAvailable($item)){
    			$items[] = $item;
    		}else {
    			$notAvilable[] = $item;
    		}
    		$orderId = $item->getFirstOrderId();
    		
    	}
    	//die Letzten bearbeiten
    	$this->processItems($items);
  		
    	//nicht verfügbare bearbeiten
    	$this->processNotAvailableItems($notAvilable);
    }
    
    /**
     * prüfen ob das ursprüngliche Produkt noch zu verfügung steht
     * Station, Periode
     * @param Dwd_Stationen_Model_Stationen $item
     * @return boolean
     */
    private function isAvailable($item)
    {
    	$p = Mage::getModel('catalog/product')->load($item->getProductId());
    	if(($p->getId() == 0) || ($p->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_DISABLED)){
    		return false;
    	}
    	
    	if($item->getStationId() > 0)
    	{
	    	$s = Mage::getModel('stationen/stationen')->load($item->getStationId());
	    	if(($s->getId() == 0) || ($s->getStatus() != Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE)){
	    		return false;
	    	}
	    	
	    	$set = Mage::getModel('stationen/set')->load($p->getStationenSet());
	    	if(($set->getId() == 0) || ($set->getStatus() == Dwd_Stationen_Model_Set_Status::STATUS_DISABLED)){
	    		return false;
	    	}
	    	
	    	$set = array_keys($set->getStationen());
	    	if(!in_array($s->getId(), $set)){
	    		return false;
	    	}
    	}
    	
    	$p = Mage::getModel('periode/periode')->load($item->getPeriodId());
    	if($p->getId() == 0) {
    		return false;
    	}
    	
    	
    	
    	return true;
    }
    
    
   /**
    * für die Items einse Abos eine Bestellung erstellen
    * @param array Dwd_Abo_Model_Abo  $items
    */ 
   protected function processItems($items)
   {
	   	try
	   	{
	   		if (count($items) > 0) {
	   			/** @var $order Dwd_Abo_Model_Order_Order */
	   			$order = Mage::getModel('dwd_abo/order_order');
	   			$order->createOrders($items);   				
	   			
	   		}
	   	}
	   	catch(Exception $ex)
	   	{
	   		Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
	   	}
   } 
   
   
   /**
    * nicht verfügbare Produkte (Zeitraum, Station, Produkt fehlt) einen Nachrichtverseneden und Abo deaktivieren
    * @param  array Dwd_Abo_Model_Abo $items
    */
   protected function processNotAvailableItems($items)
   {
   	if (count($items) > 0) {
   		foreach ($items as $item){
   			$data=array();
   			$data['item'] = $item;
   			$data['order'] = Mage::getModel('sales/order')->load($item->getFirstOrderId());
   			$data['product'] = Mage::getModel('catalog/product')->load($item->getProductId());
   			$data['station'] = Mage::getModel('stationen/stationen')->load($item->getStationId());
   			$data['orderitem'] = Mage::getModel('sales/order_item')->load($item->getCurrentOrderitemId());
   			$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
   			Mage::helper('dwd_abo')->sendEmail($customer->getEmail(), $customer, $data, 'dwd_abo/email/notavailable_abo_template');
   			$item->setStatus(Dwd_Abo_Model_Status::STATUS_DELETE)->save();
   			
   		}
   		
   	}
   }
   
   
   /**
    * Produktnewsletter entfernen
    * @param Dwd_Abo_Model_Abo $abo
    * @param Mage_Customer_Model_Customer $customer
    */
   public function removeProductNewsletter($customer = null)
   {
   		
   		$orderitem = Mage::getModel('sales/order_item')->load($this->getCurrentOrderitemId());
   		
   		if($customer === null)
   		{
   			$order = Mage::getModel('sales/order')->load($this->getCurrentOrderId());
   			$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
   		}
   		
   		//abfrage ob noch andere Abos mit dieser Id aktiv sind
   		if($this->getResource()->getAcvitvProductAbosCount($customer->getId(),$orderitem->getProductId()) < 1)
   		{
	   		/* @var $subscriber Mage_Newsletter_Model_Subscriber */
	   		$subscriber = Mage::getModel('newsletter/subscriber')->loadByCustomer($customer);
	    		
	   		/* @var $extnews Egovs_Extnewsletter_Model_Extnewsletter */
	   		$extnews = Mage::getModel('extnewsletter/extnewsletter');
	   		$extnews->loadByIdAndProduct($subscriber->getSubscriberId(),$orderitem->getProductId());
	   		if($extnews->getId())
	   		{
	   			$extnews->delete()->save();
	   		}
   		}
   		
   }

   protected function removeTierPriceDepends()
   {
   		$id = $this->getCurrentOrderitemId();
   		$res= $this->getResource();
   		$res->removeTierPriceDepends($id);
   		
   		return $this;
   } 
 
   /**
    * falls Abo gelöscht/inaktiv Produktnewsletter entfernen
    *  @see Mage_Core_Model_Abstract::_afterSave()
    */
   public function _afterSave()
   {
   		if($this->getStatus() != Dwd_Abo_Model_Status::STATUS_ACTIVE)
   		{
   			$this->removeProductNewsletter();
   			//nur die Staffelpreisabhängigkeiten entfernen wenn nicht in Bestellung
   			//if($this->getRenewalStatus() != Dwd_Abo_Model_Renewalstatus::STATUS_ORDER_PENDING){
   			$this->removeTierPriceDepends();
   			//}
   		}
   		return parent::_afterSave();
   }
   
   /**
    * feststellen wieviele Staffelpreise von diesem Abo abhängen
    */
   public function getTierPriceDependProviderCount()
   {
   		$td = Mage::getModel('dwd_abo/tierpricedepends')->getCollection();
   		$td->getSelect()->where('provider_orderitem_id = '. $this->getCurrentOrderitemId());
   		return count($td->getItems());
   }
   
   /**
    * feststellen von wievielen Abos der Staffelpreis von diesem Abo gebildet wurde
    */
   public function getTierPriceDependBenefitCount()
   {
   	$td = Mage::getModel('dwd_abo/tierpricedepends')->getCollection();
   	$td->getSelect()->where('benefit_orderitem_id = ?', $this->getCurrentOrderitemId());
   	return count($td->getItems());
   }
   	
   /**
    * Falls Staffelpreise vom alten Abo(Bestellung) abhängen muss die Abhängigkeit auf die neue Bestellug geswitcht werden 
    * @param Dwd_Abo_Model_Abo $OldAbo
    */
   public function switchTierPriceDepends($OldAbo)
   {
   		$res= $this->getResource();
   		$res->switchTierPriceDepends($this->getCurrentOrderitemId(),$OldAbo->getCurrentOrderitemId());
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
   public function getCancelationPeriodeEndFormated() {
	   	$sDate = $this->getCancelationPeriodeEnd();
	   	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
	   	return $date->toString(Zend_Date::DATETIME_MEDIUM);
   }
   
}