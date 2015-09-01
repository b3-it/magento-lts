<?php

class Dwd_Icd_Block_Customer_Credentials_Items extends Mage_Core_Block_Template
{
    protected function _construct() {
        parent::_construct();
        
        $this->getItemsCollection();
    }
    
    /**
     * Enter description here...
     *
     * @return Dwd_Icd_Block_Customer_Credentials_Items
     */
    protected function _prepareLayout()
    {
    	parent::_prepareLayout();
    
    	$pager = $this->getLayout()->createBlock('page/html_pager', 'credentials.customer.items.pager')
    						->setCollection($this->getItemsCollection());
    	$this->setChild('pager', $pager);
    	$this->getItemsCollection()->load();
    	
    	return $this;
    }
    
	public function getItemsCollection()
	{
		if (!$this->hasCredentials()) {
			$eav = Mage::getResourceModel('eav/entity_attribute');
			$userId = Mage::getSingleton('customer/session')->getCustomerId();
			/* @var $collection Dwd_Icd_Model_Mysql4_Account_Collection */
			$collection = Mage::getModel('dwd_icd/orderitem')->getCollection();
			$collection->getSelect()
				//->join(array('items'=>'icd_orderitem'),'items.account_id=main_table.id',array('item_status'=>'status','item_id'=>'id'))
				->join(array('account'=>'icd_account'),'account.id=main_table.account_id',array('account_sync_status'=>'sync_status','account_id'=>'id','login'=>'login'))
				//->join(array('products'=>'catalog_product_entity'),'products.entity_id = main_table.product_id')
				//->join(array('p'=>'catalog_product_entity_varchar'),'p.entity_id= main_table.product_id AND p.attribute_id  = '.$eav->getIdByCode('catalog_product', 'name'),array('name'=>'value'))
				->join(array('orderitem'=>'sales_flat_order_item'),'orderitem.item_id = main_table.order_item_id',array('name'=>'name','sku'=>'sku'))
				->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.order_id',array('bestellnummer'=>'increment_id','order_date'=>'created_at','original_increment_id'=>'original_increment_id'))			
				->joinleft(array('stationen'=>'stationen_entity_varchar'),'stationen.entity_id = main_table.station_id AND stationen.attribute_id = ' .$eav->getIdByCode('stationen_stationen', 'name') ,array('station'=>'value'))
				->joinleft(array('stationen1'=>'stationen_entity'),'stationen1.entity_id = main_table.station_id' ,array('stationskennung'=>'stationskennung'))
				->where('account.customer_id = ' . $userId)
			;
			$collection->setOrder('main_table.id', 'desc');
			$this->setCredentials($collection);
// 			die($collection->getSelect()->__toString());
		}
		return $this->getCredentials();
	}
	
	public function getItemPeriode($item)
	{
		$a = Mage::app()->getLocale()->date($item->getStartTime(), null, null, true);
		$b = Mage::app()->getLocale()->date($item->getEndTime(), null, null, true);
		return $a.' - ' . $b;
	}
	
	public function getItemStatus($item)
	{
		if(($item->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PERMANENTERROR) || 
			($item->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_ERROR) ||
			($item->getAccountSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_ERROR) ||
			($item->getAccountSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PERMANENTERROR))
		{
			return $this->__('Error');
		}
		
		
		switch($item->getStatus())
		{
			case Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE : return $this->__('Active');
			case Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DELETE : return $this->__('Disabled');
			case Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DISABLED : return $this->__('Disabled');
			case Dwd_Icd_Model_OrderStatus::ORDERSTATUS_NEW : return $this->__('Processing');
			case Dwd_Icd_Model_OrderStatus::ORDERSTATUS_NEWSTATION: return $this->__('Active');
		}
		
		return "";
		
		
	}
	
	public function formatItemDateTime($date)
	{
		return Mage::app()->getLocale()->date($date, null, null, true);	
	}
	
	public function formatItemDate($date)
	{
		$date = Mage::app()->getLocale()->date($date, null, null,  true);
		//return $date;
		return date('d.m.Y',$date->getTimestamp());
	}
	
	public function getApplicationUrl($item) {
		$url = $item->getApplicationUrl();
		
		if (!empty($url) && strpos($url, '://') === false) {
			$url = 'http://'.$url;
		}
		
		return $url;
	}
}
