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
		
		$eav = Mage::getResourceModel('eav/entity_attribute');
		
		$collection = Mage::getModel('sales/order_item')->getCollection();
		$collection->getSelect()	
			->join(array('items'=>'icd_orderitem'),'items.order_item_id=main_table.item_id',array('station_id', 'account_id', 'application', 'application_url'))
			->join(array('account'=>'icd_account'),'items.account_id=account.id',array('password','login'))
			->join(array('order'=>'sales_flat_order'),'order.entity_id=items.order_id',array('bestellnummer'=>'increment_id','oder_date'=>'created_at'))
			->join(array('p1'=>'catalog_product_entity_int'),'p1.entity_id= items.product_id  AND p1.attribute_id  = '.$eav->getIdByCode('catalog_product', 'icd_use').' AND p1.value = 1' ,array())		
			->joinleft(array('stationen'=>'stationen_entity'),'stationen.entity_id = items.station_id')
			->where('items.order_id = ?', intval($orderid))
		;
		$sql = $collection->getSelect()->__toString();
		$this->setLog($sql);
		
		
		//die($collection->getSelect()->__toString());
		
		try{
			$crypt = Mage::getModel('core/encryption');
			$items = array();
			foreach($collection->getItems() as $item)
			{
				
	    		$item->setPassword($crypt->decrypt($item->getPassword()));
	    		$items[] = $item;
			}
		}catch(Exception $ex){
			Mage::logException($ex);
			Mage::log($sql);
		}

		return $items;
	}
	
	
}
