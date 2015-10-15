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
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Report order collection
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_CustomerReports_Model_Mysql4_Sales_Order_Collection extends Mage_Sales_Model_Mysql4_Report_Order_Collection
{
	private $_customergroup = null;
	
	public function addCustomerGroup($customergroup)
	{
		$this->_customergroup = $customergroup;
		return $this;
	}
	
	protected function _initSelect()
	{
		parent::_initSelect();
		if($this->_customergroup !== null)
		{
			$this->getSelect()->where('customer_group_id =' . intval($this->_customergroup));
		}
		
		return $this;
	}
	
}
