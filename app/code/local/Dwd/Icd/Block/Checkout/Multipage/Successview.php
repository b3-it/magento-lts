<?php

class Dwd_Icd_Block_Checkout_Multipage_Successview extends Egovs_Checkout_Block_Multipage_Successview
{
	
	protected function _toHtml()
	{
		$this->setTemplate('dwd/icd/checkout/multipage/successview.phtml');
		return parent::_toHtml();
	}
	
	
	public function getNewAccountInfo()
	{
		$orderid = Mage::getSingleton('checkout/session')->getLastOrderId();
		$storeId = Mage::app()->getStore()->getId();
		
		$eav = Mage::getResourceModel('eav/entity_attribute');
		$expr1 = new Zend_Db_Expr(' COALESCE(p.value,p0.value) as name');
		
		
		$collection = Mage::getModel('dwd_icd/account')->getCollection();
		$collection->getSelect()	
		->join(array('items'=>'icd_orderitem'),'items.account_id=main_table.id',array('order_item_id', 'order_id', 'product_id', 'station_id', 'account_id', 'application', 'application_url', 'start_time', 'end_time', 'status', 'created_time', 'update_time', 'sync_status', 'error', 'semaphor'))
		->join(array('order'=>'sales_flat_order'),'order.entity_id=items.order_id',array('bestellnummer'=>'increment_id','oder_date'=>'created_at'))
		->join(array('products'=>'catalog_product_entity'),'products.entity_id = items.product_id')
		->joinleft(array('p0'=>'catalog_product_entity_varchar'),'p0.entity_id= items.product_id AND p0.store_id= 0 AND p0.attribute_id  = '.$eav->getIdByCode('catalog_product', 'name'),array('name_store0'=>'value'))
		->joinleft(array('p'=>'catalog_product_entity_varchar'),'p.entity_id= items.product_id AND p.store_id= order.store_id AND p.attribute_id  = '.$eav->getIdByCode('catalog_product', 'name'),array('name_store'=>'value'))
		->columns($expr1)
		->join(array('p1'=>'catalog_product_entity_int'),'p1.entity_id= items.product_id  AND p1.attribute_id  = '.$eav->getIdByCode('catalog_product', 'icd_use').' AND p1.value = 1' ,array())
		
		->joinleft(array('stationen'=>'stationen_entity'),'stationen.entity_id = items.station_id')
		->where('items.order_id = ' . $orderid)
		;
		//die($collection->getSelect()->__toString());
		
		$crypt = Mage::getModel('core/encryption');
		$items = array();
		foreach($collection->getItems() as $item)
		{
			
    		$item->setPassword($crypt->decrypt($item->getPassword()));
    		$items[] = $item;
		}
		

		return $items;
	}
	
	
}
