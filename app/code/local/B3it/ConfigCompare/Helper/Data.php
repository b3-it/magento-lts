<?php
/**
 *  ConfigCompare Helper
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function getCmsPageCollection()
	{
		$collection = Mage::getModel('cms/page')->getCollection();
		
		$stores = new Zend_Db_Expr('(SELECT page_id, group_concat(store_id) AS stores FROM '.$collection->getTable('cms/page_store'). ' GROUP BY page_id ORDER BY store_id)');
		$collection->getSelect()
		->joinleft(array('store'=>$stores),'store.page_id = main_table.page_id',array('stores'));
		
		return $collection;
	}
	
	public function getCmsBlockCollection()
	{
		$collection = Mage::getModel('cms/block')->getCollection();
	
		$stores = new Zend_Db_Expr('(SELECT block_id, group_concat(store_id) AS stores FROM '.$collection->getTable('cms/block_store'). ' GROUP BY block_id ORDER BY store_id)');
		$collection->getSelect()
		->joinleft(array('store'=>$stores),'store.block_id = main_table.block_id',array('stores'));
	
		return $collection;
	}
}