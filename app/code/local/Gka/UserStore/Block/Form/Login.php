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
 * Customer login form block
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Gka_UserStore_Block_Form_Login extends Mage_Customer_Block_Form_Login
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
			//if()
		}
		 
		return $res;
	}
	

}
