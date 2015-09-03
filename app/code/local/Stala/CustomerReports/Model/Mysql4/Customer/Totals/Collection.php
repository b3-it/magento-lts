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
 * @category   Mage
 * @package    Mage_Reports
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Reports orders collection
 *
 * @category   Mage
 * @package    Mage_Reports
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_CustomerReports_Model_Mysql4_Customer_Totals_Collection extends Mage_Reports_Model_Mysql4_Customer_Totals_Collection
{
    public function setDateRange($from, $to) {
    	parent::setDateRange($from, $to);
        
    	$this->joinAttribute('group_id', 'customer/group_id', 'customer_id', null, 'left');
    	
        $group_id = Mage::registry('cgroup');
        if (isset($group_id)) {
        	$this->getSelect()->having("group_id = $group_id");
        }
          
//        printf($this->getSelect()->assemble()."<br>");
        return $this;
    }
}
