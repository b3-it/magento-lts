<?php
class Sid_Framecontract_Block_Adminhtml_Vendor extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_vendor';
    $this->_blockGroup = 'framecontract';
    $this->_headerText = Mage::helper('framecontract')->__('Vendor Manager');
    $this->_addButtonLabel = Mage::helper('framecontract')->__('Add Vendor');
    parent::__construct();
  }
}