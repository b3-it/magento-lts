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
 * @package     Mage_Customer
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer group attribute source
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Roles_Model_Customer_Attribute_Source_Group extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $model = Mage::getResourceModel('customer/group_collection');
            
            $user = Mage::getSingleton('admin/session')->getUser();
   			if(!$user->getAllowAllCustomergroups())
   			{
   				$user_id = $user->getId();
   				$model->getSelect()
   					->join(array('role'=>'sid_roles_customergroups'),'main_table.customer_group_id = role.customer_group_id AND role.write = 1 AND role.customer_group_id > 0 AND user_id='.$user_id);
   				//die($this->_options->getSelect()->__toString());		
   			}
            else 
            {          
            	$model->setRealGroupsFilter();
            }
            $this->_options = $model->load()->toOptionArray();
        }
        return $this->_options;
    }
}