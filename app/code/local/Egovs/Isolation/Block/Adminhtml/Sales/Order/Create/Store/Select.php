<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales order create select store block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Egovs_Isolation_Block_Adminhtml_Sales_Order_Create_Store_Select extends Mage_Adminhtml_Block_Sales_Order_Create_Store_Select
{
	public function getWebsiteCollection()
	{
		$collection = Mage::getModel('core/website')->getResourceCollection();
	
		$websiteIds = $this->getWebsiteIds();
		if (!is_null($websiteIds)) {
			$collection->addIdFilter($this->getWebsiteIds());
		}
	
	
		$UserStoreGroups = Mage::helper('isolation')->getUserStoreGroups();
		if($UserStoreGroups)
		{
			$UserStoreGroups = implode(',', $UserStoreGroups);
			$collection->getSelect()
			->join(array('store_group' => $collection->getTable('core/store_group')),"store_group.website_id = main_table.website_id",array())
			->where("group_id IN (" .$UserStoreGroups .")")
			->distinct();
			//die($collection->getSelect()->__toString());
		}
	
		return $collection->load();
	}
	
	public function getGroupCollection($website)
	{
		$collection = parent::getGroupCollection($website);
		$UserStoreGroups = $this->getUserStoreGroups();
	
		if($UserStoreGroups)
		{
			$groups = array();
			foreach($collection->getItems() as $group)
			{
				if(in_array($group->getId(), $UserStoreGroups))
				{
					$groups[] = $group;
				}
			}
		}
		else {
			$groups = $collection->getItems();
		}
		return $groups;
	}
}
