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
		return $this->isAdmin(Mage::getSingleton('admin/session')->getUser());
	}

	public function isAdmin($user) {
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

	public function getOrderIdsDbExpr()
    {
        $result = null;

        $storeGroups = $this->getUserStoreGroups();
        $storeViews = $this->getUserStoreViews();
        if(($storeGroups) && (count($storeGroups) > 0)) {
            $storeGroups = implode(',', $storeGroups);
        }else{
            $storeGroups = '-1';
        }

        if(($storeViews) && (count($storeViews) > 0)) {
            $storeViews = implode(',', $storeViews);
        }else{
            $storeViews = '-1';
        }
        //helper zum Feststellen der Tabellen Namen
        $tmp = Mage::getModel('isolation/relation')->getResource();

        //falls der KundenStore mit berücksichtigt werden soll
        if( Mage::getStoreConfigFlag('storeisolation/filter/show_order_within_customer_store',0))
        {
            $sql = array();
            $sql[] = "(SELECT order_table.entity_id  FROM {$tmp->getTable('sales/order')} AS `order_table`";
            $sql[] = "LEFT JOIN (SELECT order_id as oid FROM {$tmp->getTable('sales/order_item')} as orderitem WHERE store_group in ({$storeGroups}) GROUP BY order_id) AS `order_item` ON order_item.oid=order_table.entity_id";
            $sql[] = "LEFT JOIN {$tmp->getTable('customer/entity')} AS `customer` ON customer.entity_id=order_table.customer_id and customer.store_id in ({$storeViews})";
            $sql[] = "where ((customer.store_id is not null) or (order_item.oid is not null)))";
            $result = new Zend_Db_Expr( implode(' ',$sql));
        }
        else //
        {
            $sql = array();
            $sql[] = "(SELECT order_table.entity_id  FROM {$tmp->getTable('sales/order')} AS `order_table`";
            $sql[] = "LEFT JOIN (SELECT order_id as oid, store_group FROM {$tmp->getTable('sales/order_item')} as orderitem  GROUP BY order_id) AS `order_item` ON order_item.oid=order_table.entity_id and store_group in ({$storeGroups})";
            $sql[] = "where order_item.store_group is not null)";
            $result = new Zend_Db_Expr( implode(' ',$sql));
        }

        return $result;
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