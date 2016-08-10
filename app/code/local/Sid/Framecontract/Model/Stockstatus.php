<?php

class Sid_Framecontract_Model_Stockstatus extends Varien_Object
{
  
	
	public function getStockStatusCollection($losId = 0)
	{
		/* @var $eav Mage_Eav_Model_Entity_Attribute */
		$eav = Mage::getResourceModel('eav/entity_attribute');
    	$status = $eav->getIdByCode('catalog_product', 'status');
    	$los = $eav->getIdByCode('catalog_product', 'framecontract_los');
    	$qty = $eav->getIdByCode('catalog_product', 'framecontract_qty');
		
    	$sold = new Zend_Db_Expr('(qty.value - stock.qty) as sold');
    	$sold_p = new Zend_Db_Expr('IF(qty.value <> 0, (qty.value - stock.qty)/qty.value * 100, 0) as sold_p');
		
		/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
		$collection = Mage::getModel('catalog/product')->getCollection();
		
		$collection->getSelect()
			->columns($sold)
			->columns($sold_p)
			->join(array('status'=>$collection->getTable('catalog/product').'_int'), 'status.entity_id=e.entity_id AND status.attribute_id ='.$status)
			->join(array('los'=>$collection->getTable('catalog/product').'_int'), 'los.entity_id=e.entity_id AND los.attribute_id ='.$los)
			->join(array('qty'=>$collection->getTable('catalog/product').'_int'), 'qty.entity_id=e.entity_id AND qty.attribute_id ='.$qty)
			->join(array('stock'=>$collection->getTable('cataloginventory/stock_item')),'stock.product_id=e.entity_id')
			->where('los.value = '.intval($losId))
			->where('status.value = '. Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
			->where('stock.manage_stock = 1')
		;
		
		
		die($collection->getSelect()->assemble());
	}
	
}