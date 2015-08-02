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
 * Adminhtml sales order create block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Egovs_Informationservice_Block_Adminhtml_Request_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{

  public function __construct()
  {
    $this->_controller = 'adminhtml_request_customer';
    $this->_blockGroup = 'informationservice';
    $this->_headerText = Mage::helper('informationservice')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('customer')->__('Add New Customer');
    //$this->removeButton('add');
   
    parent::__construct();
  }
	
	protected function _prepareLayout()
	{
		parent::_prepareLayout();
		$url = $this->getUrl('adminhtml/customer/new/');
	 	$this->_updateButton('add','onclick', "setLocation('".$url."');");
	}
  
	

    public function getHeaderText()
    {
        return Mage::helper('sales')->__('Please select a customer');
    }

    public function xgetButtonsHtml()
    {
    	return '';
    	/*
        $addButtonData = array(
            'label'     => Mage::helper('sales')->__('Create New Customer'),
            'onclick'   => 'order.setCustomerId(false)',
            'class'     => 'add',
        );
        */
        return $this->getLayout()->createBlock('adminhtml/widget_button')->setData($addButtonData)->toHtml();
    }

}
