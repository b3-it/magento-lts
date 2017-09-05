<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Model_Kassenbuch_Journal
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Model_Kassenbuch_Journal extends Mage_Core_Model_Abstract
{
	protected $_cashbox = null;
	
	protected $_items = null;
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('gka_barkasse/kassenbuch_journal');
    }
    
    public function setNumber()
    {
    	$this->getResource()->setNumber($this->getId(),$this->getCashboxId());
    }
    
    
    
    public function getFormatedOpeningDateTime()
    {
    	$res = $this->getOpening();
    	if(empty($res)) return '';
    	$date = new Zend_Date($res, Varien_Date::DATETIME_INTERNAL_FORMAT, null);
    	return Mage::app()->getLocale()->date($date, null, null, true);
    }
    
    public function getFormatedClosingDateTime()
    {
    	$res = $this->getClosing();
    	if(empty($res)) return '';
    	$date = new Zend_Date($res, Varien_Date::DATETIME_INTERNAL_FORMAT, null);
    	return Mage::app()->getLocale()->date($date, null, null, true);
    }
    
    
    
    protected function _beforeSave()
    {
    	if(empty($this->getStatus())){
    		$this->setStatus(Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_OPEN);
    	}
    	
    	if(($this->getData('status') != $this->getOrigData('status'))
    			&& ($this->getData('status') == Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_OPEN)){
    				$this->setOpening(now());
    				$customer = $collection = Mage::getModel('customer/customer')->load($this->getCustomerId());
    				$this->setOwner($customer->getName());
    				$cashbox = Mage::getModel('gka_barkasse/kassenbuch_cashbox')->load($this->getCashboxId());
    				$this->setCashboxTitle($cashbox->getTitle());
    	}
    	
    	if(($this->getData('status') != $this->getOrigData('status'))
    			&& ($this->getData('status') == Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED)){
    				$this->setClosing(now());
    	
    	}
    	
    	if(($this->getData('status') == $this->getOrigData('status'))
    			&& ($this->getData('status') == Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED)){
    				throw new Exception('Frault');
    	
    	}
    	
   
    	
    	parent::_beforeSave();
    }
    
    protected function _afterSave()
    {
    	if($this->getNumber() == 0){
    		$this->setNumber();
    	}
    	
    	parent::_afterSave();
    }
    
    
    /**
     * Ermitteln des geöffneten Kassenbuches des aktuellen Kunden
     * @param Mage_Customer_Model_Customer $customerId
     * @return NULL | Gka_Barkasse_Block_Kassenbuch_Journal
     */
    public function getOpenJournal($customerId = null)
    {
    	if($customerId == null){
    		$customerId = $this->_getCustomer()->getId();
    	}
    	 
    	$collection = $this->getCollection();
    	$collection->getSelect()
    	->where('customer_id = '.$customerId)
    	->where('status = '. Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_OPEN);
    	 
    	if(count($collection->getItems()) == 0) return null;
    	 
    	return $collection->getFirstItem();
    }
    
    protected function _getCustomer()
    {
    	if($this->_customer == null){
    		$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
    	}
    	return $this->_customer;
    }
    
    public function getCashbox()
    {
    	if($this->_cashbox == null)
    	{
    		$this->_cashbox = Mage::getModel('gka_barkasse/kassenbuch_cashbox')->load($this->getCashboxId());
    	}
    	return $this->_cashbox;
    }
    
    /**
     * Collection für die einzelen Buchungen des Journals, join mit sales_flat_order
     * @return object|Object
     */
     public function getItemsCollection()
     {
     	$collection = Mage::getModel('gka_barkasse/kassenbuch_journalitems')->getCollection();
     	$collection->getSelect()
     	->join(array('order' => $collection->getTable('sales/order')),'order.entity_id=main_table.order_id')
     	->joinleft(array('payment' => $collection->getTable('sales/order_payment')),'payment.parent_id=main_table.order_id',array('kassenzeichen'))
     	->where('journal_id=?',$this->getId());
     	return $collection;
     }
    
    
    public function getAllItems()
    {
    	if($this->_items == null)
    	{
    		$collection = $this->getItemsCollection();
    		$collection->getSelect()->order('number');
	    	$this->_items = $collection->getItems();
    	}
    	return $this->_items;
    }
    
    /**
     * gesammt Summe aller Positionen
     * @return number
     */
    public function getTotal()
    {
    	$total = 0;
    	foreach($this->getAllItems() as $item)
    	{
    		$total += $item->getBaseGrandTotal();
    	}
    	
    	return $total;
    }
    
    /**
     * Kann der Kunde ein Kassenbuches eröffnen?
     * @param Mage_Customer_Model_Customer $customerId
     */
    public function isCustomerCanOpen($customerId)
    {
    	if($customerId){
    		//nur für benutzer die eine Kassen haben
    		if(Mage::getModel('gka_barkasse/kassenbuch_cashbox')->getCashbox($customerId) != null)
    		{
    			$journal  = Mage::getModel('gka_barkasse/kassenbuch_journal')->getOpenJournal($customerId);
    			if(empty($journal)||(!$journal->getId())){
    				return true;
    			}
    		}
    	}
    	
    	return false;
    }
    /**
     * Kassenbuches mit Id und CustomerId laden
     * @param Gka_Barkasse_Model_Kassenbuch_Journal $id
     * @param Mage_Customer_Model_Customer $customerId
     * @return NULL | Gka_Barkasse_Block_Kassenbuch_Journal
     */
    public function loadById_Customer($id,$customerId = null)
    {
    	if($customerId == null){
    		$customerId = $this->_getCustomer()->getId();
    	}
    
    	$collection = $this->getCollection();
    	$collection->getSelect()
    	->where('customer_id = '.$customerId)
    	->where('id = '. $id);
    
    	if(count($collection->getItems()) == 0) return null;
    
    	return $collection->getFirstItem();
    }
    
}
