<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Relation
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_Abstract extends Varien_Object
{
    
	/**
	 * Falls Produkte aus einer Bestellung geladen werden sollen
	 * @var string
	 */
	protected $_AllowProductLod4View = false;
	
	protected function getUser()
	{
		return Mage::getSingleton('admin/session')->getUser();
	}
	
	protected function getUserStoreGroups()
	{
		$user = Mage::getSingleton('admin/session')->getUser();
		return $user->getStoreGroups();
	}
	
	protected function getUserStoreViews()
	{
		$res = array();
		$user = Mage::getSingleton('admin/session')->getUser();
		$storeGroups = $user->getStoreGroups();
		
		if(($storeGroups) && (count($storeGroups) > 0)) 
		{	
			$storeGroups = implode(',', $storeGroups);
			$collection = Mage::getModel('core/store')->getCollection();
			$collection->getSelect()->where('group_id In ('.$storeGroups.')');
			
			
			foreach($collection->getItems() as $item )
			{
				$res[] = $item->getId();
			}
		}
		return $res;
	}
	
	protected function getUserStoreRootCategories()
	{
		$res = array();
		$user = Mage::getSingleton('admin/session')->getUser();
		$storeGroups = $user->getStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0)) 
		{	
			$storeGroups = implode(',', $storeGroups);
			$collection = Mage::getModel('core/store_group')->getCollection();
			$collection->getSelect()->where('group_id In ('.$storeGroups.')');
			
			
			foreach($collection->getItems() as $item )
			{
				$res[] = $item->getRootCategoryId();
			}
		}
		return $res;
	}
	
	
	protected function getUsername($id)
	{
		$user = Mage::getModel('admin/user')->load($id);
		return $user->getFirstname()." " . $user->getLastname();
	}
	
	
	protected function getRelatedOrderItems4Order($orderId)
	{
		$storeGroups = $this->getUserStoreGroups();
    	
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
    		$count = Mage::getModel('isolation/relation')->getResource()->getCountOrderItems4Stores($storeGroups, $orderId);
    		return $count;
    	}
    	
    	return -1;
	}
	
	/**
	 * Falls der Nutzer die URL manipuliert hat loggen und abbrechen 
	 */
	protected function denied()
	{
		$req = Mage::app()->getRequest()->getRequestString();
		$ip = Mage::app()->getRequest()->getClientIp();
		$obj = get_class($this);
		Mage::log("Access denied for User: ". $this->getUser()->getName(). " Request: " . $req . " IP:" .$ip . " /". $obj);
		die('<h1>Access denied! Your Data has been logged!</h1>');
	}
	

    
}