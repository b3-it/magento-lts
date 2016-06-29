<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Helper_Data
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getUser()
	{
		return Mage::getSingleton('admin/session')->getUser();
	}
	
	public function getUserStoreGroups()
	{
		$user = Mage::getSingleton('admin/session')->getUser();
		return $user->getStoreGroups();
	}
	
	public function getUserIsAdmin()
	{
		$user = Mage::getSingleton('admin/session')->getUser();	
		return ($user->getRole()->getId() == 1);
	}
	
	
	public function getUsername($id)
	{
		$user = Mage::getModel('admin/user')->load($id);
		return $user->getFirstname()." " . $user->getLastname();
	}
	
	
	public function getUserStoreViews()
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
	
	public function getUserWebsites()
	{

		$user = Mage::getSingleton('admin/session')->getUser();
		$storeGroups = $user->getStoreGroups();
	
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			$storeGroups = implode(',', $storeGroups);
			$collection = Mage::getModel('core/website')->getCollection();
			$exp = new Zend_Db_Expr('SELECT website_id FROM '.$collection->getTable('core/store_group').' WHERE group_id IN('.$storeGroups.') GROUP BY website_id');
			
			
			$collection->getSelect()
				->where('website_id In ('.$exp.')');
	
			
			return $collection;
		}
		
		return Mage::app()->getWebsites();
			
	}
	
	public function filterSharedWebsiteIds($sharedWebsiteIds)
	{
		$storeGroups = $this->getUserStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0))
		{
			$storeGroups = implode(',', $storeGroups);
			$collection = Mage::getModel('core/store_group')->getCollection();
			$collection->getSelect()->where('group_id IN ('.$storeGroups.')');
			$res = array();
			foreach($collection->getItems() as $group)
			{
				if(in_array($group->getWebsiteId(), $sharedWebsiteIds))
				{
					$res[] = $group->getWebsiteId();
				}
			}
			
			return $res;
		}
		
		return $sharedWebsiteIds;
	}
}