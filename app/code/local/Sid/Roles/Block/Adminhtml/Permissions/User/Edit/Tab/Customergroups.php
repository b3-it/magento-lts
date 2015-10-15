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
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Sid_Roles_Block_Adminhtml_Permissions_User_Edit_Tab_Customergroups extends Mage_Core_Block_Template
{

	
 	protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('sid/roles/customergroups.phtml');
    }
	
  	public function getCustomerGroups()
  	{
  		$res = array();
  		//$model = Mage::registry('permissions_user');
  		if (Mage::registry('permissions_user')->getId())
  		{
	  		$user_id = Mage::registry('permissions_user')->getId();
	  		$expr = new Zend_Db_Expr('(select * From sid_roles_customergroups where user_id='.$user_id.')');
	  		$collection = Mage::getModel('customer/group')->getCollection();
	  		$collection->getSelect()
	  			->joinleft(array('t1'=>$expr),'t1.customer_group_id=main_table.customer_group_id',array('read'=>'read','write'=>'write'))
	  			//->where('main_table.customer_group_id > 0')
	  			;
	  		
	  		//die($collection->getSelect()->__toString());
	  		foreach ($collection->getItems() as $item) 
	  		{
	  			$res[] = array('id'=>$item->getId(), 
	  							'label'=>$item->getCustomerGroupCode(),
	  							'read'=>intval($item->getRead()), 
	  							'write'=>intval($item->getWrite())
	  			);
	  		}
  		}
  		
  		return $res;
  	}
  	
  	public function getAllowAllCustomergroups()
  	{
  		return Mage::registry('permissions_user')->getAllowAllCustomergroups();
  	}
}
