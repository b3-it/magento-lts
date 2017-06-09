<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Kassenbuch_Journal
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Kassenbuch_Journal extends Mage_Core_Block_Template
{
	
	protected $_customer = null;
	protected $_CurrencySymbol = null;
	
  	public function _prepareLayout()
    {
  		return parent::_prepareLayout();
    }

     public function getKassenbuchJournal()
     {
        if (!$this->hasData('kassenbuchjournal')) {
            $this->setData('kassenbuchjournal', Mage::registry('kassenbuchjournal_data'));
        }
        return $this->getData('kassenbuchjournal');
    }
    
    public function getLastKassenbuchJournal()
    {
    	$collection = Mage::getModel('gka_barkasse/kassenbuch_journal')->getCollection();
    	$collection->getSelect()
  		->where('customer_id = ' . $this->getCustomerId())
  		->where('status = '.Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED)
    	->order('id DESC');
    	
    	return $collection->getFirstItem();
    }
    
    public function getLastBalance()
    {
    	$last = $this->getLastKassenbuchJournal();
    	if($last){
    		return $last->getClosingBalance();
    	}
    	
    	return "";
    }
    
    public function getOpeningBalance()
    {
    	return $this->getKassenbuchJournal()->getOpeningBalance();
    }
    
    public function getTotal()
    {
    	return $this->getKassenbuchJournal()->getTotal();
    }
    
    public function getSaldo()
    {
    	return $this->getTotal() + $this->getOpeningBalance();
    }
    
    public function getOpenUrl()
    {
    	return Mage::getUrl('gka_barkasse/kassenbuch_journal/open');
    }
    
    
    public function getCloseUrl()
    {
    	return Mage::getUrl('gka_barkasse/kassenbuch_journal/close',array('id' => $this->getKassenbuchJournal()->getId()));
    }
    
    
    public function getCashboxHtml($id = 'cashbox')
    {
    	$res = array();
    	
    	$collection = Mage::getResourceModel('gka_barkasse/kassenbuch_cashbox_collection');
    	$collection->getSelect()
    		->where('customer_id = ' . $this->getCustomerId());
    	
    	$res[] = '<select name="cashbox_id" id="'.$id.'">';
    	foreach($collection->getItems() as $item)
    	{
    		$res[] = '<option value="'.$item->getId().'">'.$item->getTitle()."</option>";
    	}
    	
    	$res[] = '</select>';
    	
    	return implode('\n',$res);
    }
    
    protected function _getCustomer()
    {
    	if($this->_customer == null){
    		$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
    	}
    	return $this->_customer;
    }
    
    public function getCustomer()
    {
    	if ( $customer = $this->_getCustomer() ) {
            return $customer->getFirstname() . ' ' . $customer->getLastname();
    	}
    	
    	return 'Unknown';
    }
    
    public function getCustomerId()
    {
    	$customer = $this->_getCustomer();
    	if($customer)
    	{
    		return $customer->getId();
    	}
    	
    	return 0;
    }
    
    
    public function getCurrencySymbol()
    {
    	if($this->_CurrencySymbol == null)
    	{
    		$this->_CurrencySymbol =  Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    	}
    	return $this->_CurrencySymbol;

    }

}
