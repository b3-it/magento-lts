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
 * Store switcher block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Isolation_Block_Adminhtml_Store_Switcher extends Mage_Adminhtml_Block_Store_Switcher
{

	private $_StoreGroups = null;

	private function getUserStoreGroups()
	{
		if($this->_StoreGroups == null)
		{
			$this->_StoreGroups = Mage::helper('isolation')->getUserStoreGroups();
		}
		return $this->_StoreGroups;
	}
	

	
    /**
     * Get websites
     *
     * @return array
     */
    public function getWebsites()
    {
        $websites = parent::getWebsites();
       
        $UserStoreGroups = $this->getUserStoreGroups();
        
        if($UserStoreGroups)
        {
        
	        foreach($websites as $website)
	        {
	        	$groups = array();
	        	foreach($website->getGroups() as $group)
	        	{
	        		if(in_array($group->getId(), $UserStoreGroups))
	        		{
	        			$groups[] = $group;
	        		}
	        	}
	        	$website->setGroups($groups);
	        }
        }
        
        return $websites;
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
