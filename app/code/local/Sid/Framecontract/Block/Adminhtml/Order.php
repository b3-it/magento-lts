<?php
class Sid_Framecontract_Block_Adminhtml_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_order';
    $this->_blockGroup = 'framecontract';
    $this->_headerText = Mage::helper('framecontract')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('framecontract')->__('Add Item');
    parent::__construct();
  }
}