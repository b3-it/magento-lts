<?php

class Dwd_Periode_Model_Periode extends Mage_Core_Model_Abstract
{
	const MAGENTO_DATETIME = 'YYYY-MM-dd H:m:s';

	private $_tierPrice = null;
	private $_CustomerTierPrice = null;


    public function _construct()
    {
        parent::_construct();
        $this->_init('periode/periode');
    }

    public function validate()
    {
    	$error = array();
    	if(strlen($this->getPrice()) == 0)
    	{
    		$error[] = Mage::helper('periode')->__('Price is missing');
    	}

    	if(strlen($this->getLabel()) == 0)
    	{
    		$error[] = Mage::helper('periode')->__('Label is missing');
    	}

    	if(($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION) || ($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO))
    	{
    	    	if(strlen($this->getDuration()) == 0)
		    	{
		    		$error[] = Mage::helper('periode')->__('Duration is missing');
		    	}
		    	
		    	if(intval($this->getDuration()) < 1)
		    	{
		    		$error[] = Mage::helper('periode')->__('Duration must be greather than zero');
		    	}
    	}
    	else
    	{
    	    if(strlen($this->getFrom()) == 0)
	    	{
	    		$error[] = Mage::helper('periode')->__('From is missing');
	    	}
    	    	if(strlen($this->getTo()) == 0)
	    	{
	    		$error[] = Mage::helper('periode')->__('To is missing');
	    	}
    	}

    	if(($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO))
    	{
    		if(intval($this->getDurationInDays()) <= intval($this->getCancelationPeriod()))
    		{
    			$error[] = Mage::helper('periode')->__('Duration must be greather than cancelation period');
    		}
    	}
    

    	if(count($error) == 0)
    	{
    		return null;
    	}
    	return implode(', ', $error);
    }



    public function getStartDate()
    {
    	if(($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION) || ($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO))
    	{
    		return Varien_Date::now();
    	}

    	return $this->getFrom();
    }

    public function getEndDate($time = null)
    {
    	if ($time == null) { $time = time(); }
    	if(($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION) || ($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO))
    	{
	    	$duration = $this->getDuration();
	    	//jetzt in sekunden * unit
	    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_DAY)
	    	{
	    		$dt = strtotime("+".$duration." days",$time);
	    		$duration *= 24*60*60;
	    	}
	    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_WEEK)
	    	{
	    		$dt = strtotime("+".$duration." week",$time);
	    		$duration *= 24*60*60 * 7;
	    	}
	    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_MONTH)
	    	{
	    		$dt = strtotime("+".$duration." month",$time);
	    		$duration *= 24*60*60 * 30;
	    	}
	    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_YEAR)
	    	{
	    		$dt = strtotime("+".$duration." year",$time);
	    		$duration *= 24*60*60 * 365;
	    	}
	    	$duration = ceil($duration);
	    	
	    	//return date('Y-m-d H:i:s',$time+$duration);
	    	return date('Y-m-d H:i:s',$dt);
    	}

    	return $this->getTo();

    }
    private function getDurationInDays()
    {
    	$duration = $this->getDuration();
    	//jetzt in sekunden * unit
    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_DAY)
    	{
    		$duration *= 1;
    	}
    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_WEEK)
    	{
    		$duration *= 7;
    	}
    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_MONTH)
    	{
    		$duration *= 30;
    	}
    	if($this->getUnit() == Dwd_Periode_Model_Periode_Unit::UNIT_YEAR)
    	{
    		$duration *= 365;
    	}
    	$duration = ceil($duration);
    	return $duration;
    }

    public function getFormatedText()
    {
    	if(($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION) || ($this->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO))
    	{
    		return $this->getLabel();
    	}

    	return $this->getStartDateFormated().' - '.$this->getEndDateFormated();
    }

	public function getLabel()
	{
		$store_label = $this->getData('store_label');
		if($store_label){
			return $store_label;
		}
		return $this->getData('label');
	}
	
	public function getStoreId()
	{
		$store_id = $this->getData('store_id');
		if($store_id){
			return $store_id;
		}
		return 0;
	}
	
	/**
	 * Set store id
	 *
	 * @param integer $storeId
	 * @return Mage_Catalog_Model_Category
	 */
	public function setStoreId($storeId)
	{
		if (!is_numeric($storeId)) {
			$storeId = Mage::app($storeId)->getStore()->getId();
		}
		$this->setData('store_id', $storeId);
		$this->getResource()->setStoreId($storeId);
		return $this;
	}
    
    public function getEndDateFormated() {
    	$sDate = $this->getEndDate();
    	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
    	return $date->toString(Zend_Date::DATE_MEDIUM);
    }
     
    public function getStartDateFormated() {
    	$sDate = $this->getStartDate();
    	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
    	return $date->toString(Zend_Date::DATE_MEDIUM);
    }
    
    public function getEndDateTimeFormated() {
    	$sDate = $this->getEndDate();
    	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
    	return $date->toString(Zend_Date::DATETIME_MEDIUM);
    }
     
    public function getStartDateTimeFormated() {
    	$sDate = $this->getStartDate();
    	$date = Mage::app()->getLocale()->date($sDate, null, null, true);
    	return $date->toString(Zend_Date::DATETIME_MEDIUM);
    }
    
    
    
    

    //zum Überprüfen ob der Nutzer eine Option wählen muss
    public function getProductHasPeriodeOption($productId)
    {
    	
    	return count($this->getProductPeriodeIds($productId));
    }
    
    //zum Überprüfen ob der Nutzer eine Option wählen muss
    public function getProductPeriodeIds($productId)
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()
    	->where('product_id=?',intval($productId));
    
    	/* @var $collection Dwd_Periode_Model_Mysql4_Periode_Collection */ 
    	return $collection->getAllIds();
    }

    /**
     * Liefert ein neues Perioden Item
     *
     * @param number $duration In Tagen
     *
     * @return Dwd_Periode_Model_Periode
     */
    public static function getNewOneDayDuration($duration = 1) {
    	$new = Mage::getModel('periode/periode');
    	$new->setType(Dwd_Periode_Model_Periode_Type::PERIOD_DURATION);
    	$new->setUnit(Dwd_Periode_Model_Periode_Unit::UNIT_DAY);
    	if (empty($duration)) {
    		$duration = 1;
    	}
    	$new->setDuration($duration);

    	return $new;
    }

    /**
     * Startdatum als Zend_Date in UTC
     *
     * @return Zend_Date
     */
    public function getStartZendDate() {
    	$sDate = $this->getStartDate();
    	return Mage::app()->getLocale()->date($sDate, null, null, false);
    }

    /**
     * Enddatum als Zend_Date in UTC
     *
     * @return Zend_Date
     */
    public function getEndZendDate() {
    	$sDate = $this->getEndDate();
    	return Mage::app()->getLocale()->date($sDate, null, null, false);
    }


    /**
     * Finden des gültigen Staffelpreises
     * @param float|int $qty Menge
     * @return <NULL, object, boolean, Mage_Core_Model_Abstract, unknown>
     */

    public function getTierPriceForQty($qty)
    {
    	$result = null;
    	foreach ($this->getTierPrices() as $tp)
    	{
    		if($tp->getQty() <= $qty){
    			$result = $tp;
    		}
    	}
    	return $result;
    }

    /**
     * Preis in abhängigkeit von Mwst incl/excl ermitteln
     * @param Mage_Tax_Helper_Data $product
     */
    public function getFinalPrice($product)
    {
    	if($tp = $this->getCustomerTierPrice())
    	{
    		return Mage::helper('tax')->getPrice($product,$tp->getPrice());
    	}


    	return Mage::helper('tax')->getPrice($product,$this->getPrice());
    }



    public function getCustomerTierPrice($customer_id = null)
    {
    	if( $this->_CustomerTierPrice === null)
    	{
    		if(!$customer_id)
    		{
    			$customer_id = Mage::getSingleton('customer/session')->getId();
    		}
    		//Staffelpreise für Abo Perioden
    		if(Mage::helper('periode')->isModuleEnabled('Dwd_Abo'))
    		{
    			if($customer_id > 0)
    			{
    				$this->_CustomerTierPrice = false;
    				/** @var $collection Sales_Model_Order_Items */
    				$collection = Mage::getModel('sales/order_item')->getCollection();
    				$collection->getSelect()
    				->join(array('abo'=>$collection->getResource()->getTable('dwd_abo/abo')),'abo.current_orderitem_id = main_table.item_id AND abo.status = '.Dwd_Abo_Model_Status::STATUS_ACTIVE,array())
    				->join(array('order'=>$collection->getResource()->getTable('sales/order')),'order.entity_id=main_table.order_id',array())
    				->where('main_table.period_id = ' .$this->getId())
    				->where('order.customer_id='.$customer_id)
    				->distinct()
    				;
    				//die($collection->getSelect()->__toString());
    				$qty = 1 + count($collection->getItems());

    				if($tp = $this->getTierPriceForQty($qty))
    				{
    					$depends = array();
    					foreach($collection->getItems() as $item)
    					{
    						$depends[] = $item->getId();
    					}
    					
    					$tp->setPriceDepentsOn($depends);
    					$this->_CustomerTierPrice = $tp;
    					
    				}
    			}
    		}
    	}
    	return $this->_CustomerTierPrice;
    }


    public function getTierPrices()
    {
    	if($this->_tierPrice == null)
    	{
    		$collection = Mage::getModel('periode/tierprice')->getCollection();
    		$id = $this->getId();
    		if(!$id) $id = -1;
    		$collection->getSelect()
    			->where('periode_id=?', intval($id))
    			->order('qty');
    		$this->_tierPrice = $collection;

    	}

    	return $this->_tierPrice;
    }

    public function _afterSave()
    {
    	$tp = $this->getTierPrices();
    	foreach($tp as $p)
    	{
    		$p->setPeriodeId($this->getId());
    		$p->save();
    	}
    }

    public function deleteTierPrices()
    {
    	$tp = $this->getTierPrices();
    	foreach($tp as $p)
    	{
    		$p->delete();
    		$p->save();
    	}
    }

    public function _afterDelete()
    {
    	$tp = $this->getTierPrices();
    	foreach($tp as $p)
    	{
    		$p->delete();
    		$p->save();
    	}
    }

    public function toJson(array $arrAttributes = array())
    {
    	$data = $this->getData();
    	$list = $this->getTierPrices()->toArray();
    	$array_liste = array();
    	
	      foreach( $list['items'] AS $key => $val )
	      {
	         $array_liste[] = array($val['qty'], $val['price']);
	      }

    	$new = array(
    	              'entity_id' => $data['entity_id'],
    	              'type' => $data['type'],
    	              'from' => $data['from'],
    	              'to' => $data['to'],
    	              'duration' => $data['duration'],
    	              'label' => $this->getLabel(), //$data['label'],
    	              'unit' => $data['unit'],
    	              'price' => $data['price'],
    	              'product_id' => $data['product_id'],
    	              'cancelation_period' => $data['cancelation_period'],
    	              'tierprices' => $array_liste,
    				  'store_id' => $this->getStoreId()
    	            );

    	return str_replace('"', "'", json_encode($new));
    }
    
  
    /**
     * Periode aus der QuoteOption lesen, oder anhand der Id Laden
     * @param Mage_Sales_Model_Order_Item $orderitem
     * @return Dwd_Periode_Model_Periode|<Mage_Core_Model_Abstract, Mage_Core_Model_Abstract>|NULL
     */
    public static function loadPeriodeByOrderItem($orderitem, $storeId = 0)
    {
    	$collection = Mage::getModel('sales/quote_item_option')->getCollection();
    	$collection->getSelect()->where('item_id=?', intval($orderitem->getQuoteItemId()));
    
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
    
    	$periode = Mage::getModel('periode/periode')
    	->setStoreId($storeId)
    	->load($orderitem->getPeriodId());
    	if($periode->getId()){
    		return $periode;
    	}
    	 
    	return null;
    
    }
    
    protected function _beforeSave(){
    	if($this->getStoreId() > 0){
    		$storelabel = Mage::getModel('periode/storelabel')->loadByPeriode($this->getId(),$this->getStoreId());
    		$storelabel->setLabel($this->getLabel());
    		$storelabel->setPeriodeId($this->getId());
    		$storelabel->setStoreId($this->getStoreId());
    		//var_dump($storelabel); die();
    		$storelabel->save();
    		$this->unsetData('label');
    	}
    }
}