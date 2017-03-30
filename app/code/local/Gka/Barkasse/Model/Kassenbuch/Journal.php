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
     * @param unknown $customerId
     * @return NULL | Gka_Barkasse_Block_Kassenbuch_Journal
     */
    public function getOpenJournal($customerId = null)
    {
    	if($customerId == null){
    		$customerId = $this->getCustomerId();
    	}
    	 
    	$collection = $this->getCollection();
    	$collection->getSelect()
    	->where('customer_id = '.$customerId)
    	->where('status = '. Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_OPEN);
    	 
    	if(count($collection->getItems()) == 0) return null;
    	 
    	return $collection->getFirstItem();
    }
}
