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
	/**
	 *  @method int getId()
	 *  @method setId(int $value)
	 *  @method int getFirstOrderId()
	 *  @method setFirstOrderId(int $value)
	 *  @method int getFirstOrderitemId()
	 *  @method setFirstOrderitemId(int $value)
	 *  @method int getCurrentOrderId()
	 *  @method setCurrentOrderId(int $value)
	 *  @method int getCurrentOrderitemId()
	 *  @method setCurrentOrderitemId(int $value)
	 *  @method int getProductId()
	 *  @method setProductId(int $value)
	 *  @method int getCounter()
	 *  @method setCounter(int $value)
	 *  @method int getRenewalStatus()
	 *  @method setRenewalStatus(int $value)
	 *  @method int getStatus()
	 *  @method setStatus(int $value)
	 *  @method  getStartDate()
	 *  @method setStartDate( $value)
	 *  @method  getStopDate()
	 *  @method setStopDate( $value)
	 *  @method  getRenewalDate()
	 *  @method setRenewalDate( $value)
	 *  @method int getPeriodLength()
	 *  @method setPeriodLength(int $value)
	 *  @method int getRenewalOffset()
	 *  @method setRenewalOffset(int $value)
	 *  @method string getOrderGroup()
	 *  @method setOrderGroup(string $value)
	 *  @method string getPeriodUnit()
	 *  @method setPeriodUnit(string $value)
	 */
    protected $_currentOrderItem = null;


    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_subscription/subscription');
    }

    /**
     * Neue Bestellungen als Abonement einordnen
     * @param Mage_Sales_Model_Order_Item    $orderItem Item der Bestellung
     * @param Mage_Sales_Model_Quote         $quote
     * @param B3it_Subscription_Model_Period $period
     * @param Zend_Date                      $startDate Tag des Anfangs diesert Period
     *
     * @return B3it_Subscription_Model_Subscription
     * @throws Exception
     */
    public function addNewOrderItem($orderItem, $quote, $period = null, $startDate = null)
    {

        $this->setFirstOrderId($orderItem->getOrderId());
        $this->setFirstOrderitemId($orderItem->getId());
        $this->setCurrentOrderId($orderItem->getOrderId());
        $this->setCurrentOrderitemId($orderItem->getId());
        $this->setProductId($orderItem->getProduct()->getId());
        $this->setRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_PAUSE);
        $this->setStatus(B3it_Subscription_Model_Status::STATUS_ACTIVE);
        $this->setOrderGroup($orderItem->getOrder()->getIncrementId());

        //falls es eine Verlängerung ist
        $oldSubscription = $this->_getSubscriptionItem($orderItem,$quote);
        if($oldSubscription) {
            $this->setFirstOrderId($oldSubscription->getFirstOrderId());
            $this->setFirstOrderitemId($oldSubscription->getFirstOrderitemId());
            $this->setOrderGroup($oldSubscription->getOrderGroup());
            $this->setCounter(intval($oldSubscription->getCounter()) + 1);
        }
        $this->setPeriod($period);
        $data['subscription'] = $this;
        $data['order_item'] = $orderItem;

        //Falls andere Module die Periode überschreiben wollen
        Mage::dispatchEvent('b3it_subscription_model_create_calculate', $data);

        $renewalOffset = 0;
        $periodLength = 1;
        $periodUnit = Zend_Date::YEAR;

        $initialPeriodLength = 1;
        $initialPeriodUnit = Zend_Date::YEAR;

        if($period){
            $renewalOffset = $period->getRenewalOffset();
            $periodLength = $period->getPeriodLength();
            $periodUnit = $period->getPeriodUnit();

            $initialPeriodLength = $period->getInitialPeriodLength();
            $initialPeriodUnit = $period->getInitialPeriodUnit();
        }

        $length = $initialPeriodLength;
        $unit = $initialPeriodUnit;


        if($oldSubscription){
            $startDate = new Zend_Date($oldSubscription->getStopDate());
            $length = $periodLength;
            $unit = $periodUnit;
        }

    	if($startDate == null){
            $startDate = new Zend_Date();
        }

        $this->setStartDate($startDate);
        $this->setPeriodLength($periodLength);
        $this->setRenewalOffset($renewalOffset);

        $stopDate = new Zend_Date($startDate, Varien_Date::DATETIME_INTERNAL_FORMAT, null);
        $stopDate->add($length, $unit);

        $this->setStopDate($stopDate);


    	$date = new Zend_Date($stopDate, Varien_Date::DATETIME_INTERNAL_FORMAT, null);

    	$date->add($renewalOffset, Zend_Date::DAY);
        $this->setRenewalDate($date);
        $data = array();

        Mage::dispatchEvent('B3it_Subscription_Model_Create_Save_Before', $data);
        $this->save();
        Mage::dispatchEvent('B3it_Subscription_Model_Create_Save_After', $data);
        return $this;
    }

    /**
     * @param Mage_Sales_Model_Order_Item $orderItem
     * @param Mage_Sales_Model_Quote      $quote
     */
    protected function _getSubscriptionItem($orderItem, $quote)
    {
        $quoteItem = null;
        foreach($quote->getAllItems() as $item)
        {
            if($item->getId() == $orderItem->getQuoteItemId()){
                $quoteItem = $item;
            }
        }

        if($quoteItem){
            return $quoteItem->getSubscriptionItem();
        }
        return null;
    }

    public function saveStatus($status)
    {
    	$this->setStatus($status);
    	$this->getResource()->saveField($this,'status');
    	return $this;
    }

    public function saveRenewalStatus($status)
    {
    	$this->setRenewalStatus($status);
    	$this->getResource()->saveField($this,'renewal_status');
    	return $this;
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

    /**
     * @return Mage_Sales_Model_Order_Item
     */
   public function getCurrentOrderItem()
   {
        if($this->_currentOrderItem == null)
        {
            $this->_currentOrderItem = Mage::getModel('sales/order_item')->load($this->getCurrentOrderitemId());
        }
        return $this->_currentOrderItem;
   }
}