<?php
/**
 * 
 *  Formular zur Auswahl zum Umschalten der Stores
 *  @category Gka
 *  @package  Gka_UserStore_Block_Form_Switch
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_UserStore_Block_Form_Switch extends Mage_Customer_Block_Form_Login
{
	
	protected $_customer = null;
	
	protected function _getCustomer()
	{
		if($this->_customer == null){
			$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_customer;
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
	
	public function getStoresAllowed()
	{
		$store_ids = $this->_getCustomer()->getAllowedStores();
		$res = array();
		 
		$stores = Mage::app()->getStores();
		 
		foreach($stores as $store)
		{
			if(array_search($store->getStoreId(),$store_ids) !== false){
				$res[] = $store;
			}
		}
		 
		return $res;
	}
	
	
	public function getPostUrl()
	{
		return $this->getUrl('userstore/index/switch');
	}

}
