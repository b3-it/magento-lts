<?php
/**
 * Slpb Customer
 * 
 * 
 * @category   	Slpb
 * @package    	Slpb_Customer
 * @name       	Slpb_Customer_Block_Adminhtml_Sales_Edit_Tabs
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Customer_Block_Adminhtml_Sales_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('sales_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customer')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customer')->__('Item Information'),
          'title'     => Mage::helper('customer')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('customer/adminhtml_sales_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}