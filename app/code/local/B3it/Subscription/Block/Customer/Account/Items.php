<?php

class B3it_Subscription_Block_Customer_Account_Items extends Mage_Core_Block_Template
{
    protected function _construct() {
        parent::_construct();

        $this->getItemsCollection();
    }

    /**
     * Enter description here...
     *
     * @return B3it_Subscription_Block_Customer_Account_Items
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
		if (!$this->hasSubscriptions()) {
			$eav = Mage::getResourceModel('eav/entity_attribute');
			$userId = intval(Mage::getSingleton('customer/session')->getCustomerId());
			/* @var $collection B3it_Subscription_Model_Resource_Subscription_Collection */
			$collection = Mage::getModel('b3it_subscription/subscription')->getCollection();
			$collection->getSelect()
				//->join(array('items'=>'icd_orderitem'),'items.account_id=main_table.id',array('item_status'=>'status','item_id'=>'id'))
				->join(array('orderitem'=>'sales_flat_order_item'),'orderitem.item_id=main_table.current_orderitem_id',array('name'=>'name','sku'=>'sku'))
				//->join(array('products'=>'catalog_product_entity'),'products.entity_id = orderitem.product_id',array('sku'=>'sku'))
				//->join(array('p'=>'catalog_product_entity_varchar'),'p.entity_id= orderitem.product_id AND p.attribute_id  = '.$eav->getIdByCode('catalog_product', 'name'),array('name'=>'value'))
				//->join(array('p1'=>'catalog_product_entity_varchar'),'p1.entity_id= orderitem.product_id AND p1.attribute_id  = '.$eav->getIdByCode('catalog_product', 'configvirtual_base_url'),array('url'=>'value'))
				->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.first_order_id',array('initial_bestellnummer'=>'increment_id','initial_order_date'=>'created_at'))
				->join(array('order2'=>'sales_flat_order'),'order2.entity_id=main_table.current_order_id',array('bestellnummer'=>'increment_id','order_date'=>'created_at', 'original_increment_id'=>'original_increment_id'))
				->joinleft(array('stationen'=>'stationen_entity_varchar'),'stationen.entity_id = orderitem.station_id AND stationen.attribute_id = ' .$eav->getIdByCode('stationen_stationen', 'name') ,array('station'=>'value'))
				->joinleft(array('stationen1'=>'stationen_entity'),'stationen1.entity_id = orderitem.station_id' ,array('stationskennung'=>'stationskennung'))
				->where('order.customer_id = ' . $userId)
				->where('main_table.status <> '.B3it_Subscription_Model_Status::STATUS_EXPIRED);
			
			
			if(Mage::helper('configvirtual')->isModuleEnabled('B3it_Icd'))
			{
				$collection->getSelect()
				->joinLeft(array('icd'=>'icd_orderitem'),'icd.order_item_id= orderitem.item_id',array('application_url'=>'application_url'));
			}
			
			
			;
			$collection->setOrder('main_table.subscription_id', 'desc');
			$this->setSubscriptions($collection);
 			//die($collection->getSelect()->__toString());
		}
		return $this->getSubscriptions();
	}

	public function getItemPeriod($item)
	{
		$a = Mage::app()->getLocale()->date($item->getStartDate(), null, null, true);
		$b = Mage::app()->getLocale()->date($item->getStopDate(), null, null, true);
		return $a.' - ' . $b;
	}

	public function getItemStatus($item)
	{
		switch($item->getStatus())
		{
			case B3it_Subscription_Model_Status::STATUS_ACTIVE : return $this->__('Active');
			case B3it_Subscription_Model_Status::STATUS_CANCELED : return $this->__('Resigned');
			case B3it_Subscription_Model_Status::STATUS_DELETE : return $this->__('Deleted');
		}

		return "";
	}

	public function canSubscriptionCancel($item)
	{

		return ((strtotime($item->getCancelationPeriodEnd()) > time()) &&($item->getStatus() == B3it_Subscription_Model_Status::STATUS_ACTIVE));
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

	public function getCancelUrl($id)
	{
		return $this->getUrl('b3it_subscription/index/cancel',array('id'=>$id));
	}

	public function getApplicationUrl($item) {
		$url = $item->getApplicationUrl();

		if (!empty($url) && strpos($url, '://') === false) {
			$url = 'http://'.$url;
		}

		return $url;
	}

}
