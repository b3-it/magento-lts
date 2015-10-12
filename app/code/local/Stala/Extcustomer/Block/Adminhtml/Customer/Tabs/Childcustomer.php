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
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml customers list block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Childcustomer extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_customer_tabs_childcustomer';
        $this->_blockGroup = 'extcustomer';
        $this->_headerText = Mage::helper('customer')->__('Child Customers');
        parent::__construct();
        $this->_removeButton('add');
        $this->setTemplate('egovs/widget/grid/container.phtml');
 
    }
    
   	protected function x_prepareLayout()
    {
         $this->setChild( 'overview',
            $this->getLayout()->createBlock('extcustomer/adminhtml_customer_tabs_parentcustomer_form'));
		
            //Grid nur wenn noch keine Bestellung oder kein hauptkunde
            $customer   = Mage::registry('current_customer');
            if (($customer== null)|| ($customer->getCustomerOrdersCount()== 0) || ($customer->getParentCustomerId()== null))
            {
        		return parent::_prepareLayout();
            }
        return $this;
        
    }

}
