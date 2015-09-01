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
class Sid_Framecontract_Block_Adminhtml_Product_Customergroups extends Mage_Adminhtml_Block_Template
{
	
   private $_CustomerGroups = null;
    
   public function __construct()
    {
        parent::__construct();
        $this->setTemplate('sid/framecontract/customergroups.phtml');
        $this->setUseConfirm(true);
        $this->setUseAjax(true);
        //$this->setDefaultStoreName($this->__('All Store Views'));
    }

  
    public function getSwitchUrl()
    {
        
        return $this->getUrl('*/*/*');
    }

   
	public function getCustomerGroups()
	{
		if( $this->_CustomerGroups == null)
		{
			$collection = Mage::getModel('customer/group')->getCollection();
			$this->_CustomerGroups = array();
			
			foreach($collection->getItems() as $item)
			{
				$this->_CustomerGroups[$item->getCustomerGroupId()] = $item->getCustomerGroupCode();
			}
			
		}
		
		return $this->_CustomerGroups;
	}
   
	
	public function getSelectedGroup()
	{
		return $this->getRequest()->getParam('group');
	}
  
}
